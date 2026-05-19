<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    /**
     * Display list of all orders
     */
    public function index(Request $request)
    {
        $query = Order::with('user');

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('order_status', $request->status);
        }

        // Filter by payment method
        if ($request->has('payment_method') && $request->payment_method) {
            $query->where('payment_method', $request->payment_method);
        }

        // Search by order ID or customer name
        if ($request->has('search') && $request->search) {
            $search = '%' . $request->search . '%';
            $query->where(function ($q) use ($search) {
                $q->where('order_id', 'like', $search)
                  ->orWhereHas('user', function ($subQuery) use ($search) {
                      $subQuery->where('name', 'like', $search);
                  });
            });
        }

        $orders = $query->latest('date_ordered')->paginate(15);

        // Get dashboard metrics
        $totalRevenue = Order::where('order_status', 'completed')->sum('total_amount');
        $totalOrders = Order::count();
        $totalProducts = \App\Models\Product::count();
        $totalUsers = \App\Models\User::count();
        $lowStockProducts = \App\Models\Product::where('stock_quantity', '<', 10)->count();
        $recentOrders = $orders->take(5);

        return view('admin.orders.index', [
            'orders' => $orders,
            'totalRevenue' => $totalRevenue,
            'totalOrders' => $totalOrders,
            'totalProducts' => $totalProducts,
            'totalUsers' => $totalUsers,
            'lowStockProducts' => $lowStockProducts,
            'recentOrders' => $recentOrders,
        ]);
    }

    /**
     * Show order details
     */
    public function show(Order $order)
    {
        $order->load('items', 'receipt');
        return view('admin.orders.show', ['order' => $order]);
    }

    /**
     * Update order status
     */
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'order_status' => 'required|in:pending,completed,cancelled',
        ]);

        $order->update($validated);

        return redirect()->route('admin.orders.show', $order)->with('success', 'Order status updated');
    }
}
