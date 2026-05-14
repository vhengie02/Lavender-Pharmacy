<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Receipt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Show checkout page
     */
    public function checkout()
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Cart is empty');
        }

        $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
        return view('customer.checkout', ['cartItems' => $cartItems, 'total' => $total]);
    }

    /**
     * Process order
     */
    public function store(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:cash,gcash,card',
        ]);

        return DB::transaction(function () use ($request) {
            $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();
            $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_amount' => $total,
                'payment_method' => $request->payment_method,
                'order_status' => 'pending',
            ]);

            // Create order items
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->order_id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);

                // Update stock
                $item->product->decrement('stock_quantity', $item->quantity);
            }

            // Clear cart
            Cart::where('user_id', Auth::id())->delete();

            // Generate receipt
            $invoiceNumber = 'INV-' . str_pad($order->order_id, 6, '0', STR_PAD_LEFT);
            Receipt::create([
                'order_id' => $order->order_id,
                'invoice_number' => $invoiceNumber,
                'vat_amount' => $total * 0.12,
            ]);

            return redirect()->route('orders.show', $order)->with('success', 'Order placed successfully');
        });
    }

    /**
     * View order history
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->paginate(10);
        return view('customer.orders', ['orders' => $orders]);
    }

    /**
     * Show order details
     */
    public function show(Order $order)
    {
        $this->authorize('view', $order);
        $order->load('items', 'receipt');
        return view('customer.order-detail', ['order' => $order]);
    }
}
