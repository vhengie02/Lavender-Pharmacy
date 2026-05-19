<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Show admin dashboard
     */
    public function index()
    {
        $totalRevenue = Order::where('order_status', 'completed')->sum('total_amount');
        $totalOrders = Order::count();
        $totalProducts = Product::count();
        $totalUsers = User::count();
        $lowStockProducts = Product::where('stock_quantity', '<', 10)->count();
        $recentOrders = Order::latest('date_ordered')->take(5)->get();

        // Get revenue chart data for monthly, weekly, yearly views
        $revenueChart = [
            'monthly' => $this->getMonthlyRevenue(),
            'weekly' => $this->getWeeklyRevenue(),
            'yearly' => $this->getYearlyRevenue(),
        ];

        // Get top products
        $topProducts = $this->getTopProducts();

        return view('admin.dashboard', [
            'totalRevenue' => $totalRevenue,
            'totalOrders' => $totalOrders,
            'totalProducts' => $totalProducts,
            'totalUsers' => $totalUsers,
            'lowStockProducts' => $lowStockProducts,
            'recentOrders' => $recentOrders,
            'revenueChart' => $revenueChart,
            'topProducts' => $topProducts,
        ]);
    }

    /**
     * Get revenue for last 12 months
     */
    private function getMonthlyRevenue()
    {
        $data = Order::selectRaw("DATE_FORMAT(date_ordered, '%Y-%m') as month_key, SUM(total_amount) as revenue")
            ->where('order_status', 'completed')
            ->where('date_ordered', '>=', now()->subMonths(12))
            ->groupByRaw("DATE_FORMAT(date_ordered, '%Y-%m')")
            ->orderByRaw("DATE_FORMAT(date_ordered, '%Y-%m')")
            ->get()
            ->toArray();

        // Fill in missing months with zero revenue
        $result = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $label = $date->format('M Y');
            $month = $date->format('Y-m');

            $existing = collect($data)->firstWhere('month_key', $month);
            $result[] = [
                'label' => $label,
                'revenue' => $existing ? floatval($existing['revenue']) : 0,
            ];
        }

        return $result;
    }

    /**
     * Get revenue for last 12 weeks
     */
    private function getWeeklyRevenue()
    {
        $data = Order::selectRaw("YEAR(date_ordered) as year, WEEK(date_ordered) as week, SUM(total_amount) as revenue")
            ->where('order_status', 'completed')
            ->where('date_ordered', '>=', now()->subWeeks(12))
            ->groupByRaw("YEAR(date_ordered), WEEK(date_ordered)")
            ->orderByRaw("YEAR(date_ordered), WEEK(date_ordered)")
            ->get()
            ->toArray();

        // Fill in missing weeks with zero revenue
        $result = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subWeeks($i);
            $year = $date->year;
            $week = $date->weekOfYear;
            $label = "Week {$week}";

            $existing = collect($data)->first(
                fn ($row) => (int) $row['year'] === $year && (int) $row['week'] === $week
            );
            $result[] = [
                'label' => $label,
                'revenue' => $existing ? floatval($existing['revenue']) : 0,
            ];
        }

        return $result;
    }

    /**
     * Get revenue for last 5 years
     */
    private function getYearlyRevenue()
    {
        $data = Order::selectRaw("YEAR(date_ordered) as label, SUM(total_amount) as revenue")
            ->where('order_status', 'completed')
            ->where('date_ordered', '>=', now()->subYears(5))
            ->groupByRaw("YEAR(date_ordered)")
            ->orderByRaw("YEAR(date_ordered)")
            ->get()
            ->toArray();

        // Fill in missing years with zero revenue
        $result = [];
        for ($i = 4; $i >= 0; $i--) {
            $year = now()->subYears($i)->year;
            
            $existing = collect($data)->firstWhere('label', $year);
            $result[] = [
                'label' => strval($year),
                'revenue' => $existing ? floatval($existing['revenue']) : 0,
            ];
        }

        return $result;
    }

    /**
     * Get top selling products
     */
    private function getTopProducts()
    {
        $topProducts = OrderItem::select('product_id')
            ->selectRaw('SUM(quantity) as units_sold')
            ->selectRaw('SUM(quantity * price) as revenue')
            ->with('product')
            ->groupBy('product_id')
            ->orderByDesc('units_sold')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return [
                    'product_name' => $item->product->product_name ?? 'Unknown',
                    'units_sold' => (int) $item->units_sold,
                    'revenue' => (float) ($item->revenue ?? 0),
                ];
            });

        return $topProducts;
    }
}
