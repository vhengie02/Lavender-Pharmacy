<?php

namespace App\Http\Controllers;

use App\Models\Receipt;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Http\Request;

class EditorUiController extends Controller
{
    public function pos()
    {
        $products = Product::where('stock_quantity', '>', 0)
            ->with('category')
            ->orderBy('product_name')
            ->get();
        
        return view('editor.pos.index', compact('products'));
    }

    public function checkout(Request $request)
    {
        try {
            $validated = $request->validate([
                'items' => 'required|array',
                'items.*.id' => 'required|integer',
                'items.*.quantity' => 'required|integer|min:1',
                'items.*.price' => 'required|numeric',
                'subtotal' => 'required|numeric',
                'tax' => 'required|numeric',
                'total' => 'required|numeric',
            ]);



            // Create order
            $order = Order::create([
                'user_id' => auth()->id(),
                'order_status' => 'completed',
                'payment_method' => 'cash',
                'date_ordered' => now(),
                'total_amount' => $validated['total'],
            ]);

            // Create order items and update stock
            foreach ($validated['items'] as $item) {
                $product = Product::find($item['id']);
                
                if (!$product || $product->stock_quantity < $item['quantity']) {
                    throw new \Exception("Insufficient stock for {$product->product_name}");
                }

                // Create order item
                OrderItem::create([
                    'order_id' => $order->order_id,
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);

                // Update product stock
                $product->decrement('stock_quantity', $item['quantity']);
            }

            // Create payment
            Payment::create([
                'order_id' => $order->order_id,
                'payment_method' => 'cash',
                'amount_paid' => $validated['total'],
                'payment_status' => 'completed',
                'date_paid' => now(),
            ]);

            // Create receipt
            $receipt = Receipt::create([
                'order_id' => $order->order_id,
                'invoice_number' => 'INV-' . str_pad($order->order_id, 6, '0', STR_PAD_LEFT),
                'vat_amount' => $validated['tax'],
                'vat_exempt_sales' => 0,
                'zero_rated_sales' => 0,
                'cash_tendered' => $validated['total'],
                'change_amount' => 0,
                'date_created' => now(),
            ]);



            return response()->json([
                'success' => true,
                'message' => 'Checkout completed successfully',
                'receipt_id' => $receipt->receipt_id,
                'order_id' => $order->order_id,
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function receipts()
    {
        $receipts = Receipt::with('order')->latest('date_created')->paginate(20);

        return view('editor.receipts.index', compact('receipts'));
    }

    public function settings()
    {
        return view('editor.settings.index');
    }
}
