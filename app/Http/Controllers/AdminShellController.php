<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Product;
use App\Models\Receipt;
use App\Models\Order;

class AdminShellController extends Controller
{
    public function inventory()
    {
        $products = Product::with('category')
            ->orderBy('stock_quantity')
            ->paginate(20);

        return view('admin.inventory.index', compact('products'));
    }

    public function salesReports()
    {
        $completedTotal = Order::where('order_status', 'completed')->sum('total_amount');
        $recentCompleted = Order::with('user')
            ->where('order_status', 'completed')
            ->latest('date_ordered')
            ->take(15)
            ->get();

        return view('admin.reports.sales', compact('completedTotal', 'recentCompleted'));
    }

    public function receipts()
    {
        $receipts = Receipt::with('order.user')->latest('date_created')->paginate(20);

        return view('admin.receipts.index', compact('receipts'));
    }

    public function auditLogs()
    {
        $logs = AuditLog::with('user')->latest('date_logged')->paginate(25);

        return view('admin.audit-logs.index', compact('logs'));
    }

    public function settings()
    {
        return view('admin.settings.index');
    }
}
