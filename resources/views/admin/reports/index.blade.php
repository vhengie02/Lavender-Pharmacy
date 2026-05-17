@extends('layouts.admin')

@section('title', 'Reports - Admin')

@section('content')
<div style="width:100%; min-height:100vh; background:#F7F3FC; padding:32px 40px; max-width:1400px; margin:0 auto;">
    <header class="mb-8 border-b border-border pb-4">
        <h1 class="font-serif text-2xl font-bold text-foreground">
            <i class="fas fa-chart-bar"></i> Reports
        </h1>
        <p class="mt-1 text-sm text-muted-foreground">Sales and inventory analytics.</p>
    </header>

    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4 mb-8">
        <!-- Total Sales Card -->
        <div class="rounded-xl border border-border bg-card p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-muted-foreground uppercase">Total Sales</p>
                    <p class="mt-2 text-2xl font-bold text-foreground">₱0.00</p>
                    <p class="mt-1 text-xs text-muted-foreground">This period</p>
                </div>
                <div class="text-3xl text-primary/20">
                    <i class="fas fa-chart-line"></i>
                </div>
            </div>
        </div>

        <!-- Orders Card -->
        <div class="rounded-xl border border-border bg-card p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-muted-foreground uppercase">Orders</p>
                    <p class="mt-2 text-2xl font-bold text-foreground">0</p>
                    <p class="mt-1 text-xs text-muted-foreground">Completed</p>
                </div>
                <div class="text-3xl text-primary/20">
                    <i class="fas fa-shopping-bag"></i>
                </div>
            </div>
        </div>

        <!-- Products Sold Card -->
        <div class="rounded-xl border border-border bg-card p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-muted-foreground uppercase">Items Sold</p>
                    <p class="mt-2 text-2xl font-bold text-foreground">0</p>
                    <p class="mt-1 text-xs text-muted-foreground">Total units</p>
                </div>
                <div class="text-3xl text-primary/20">
                    <i class="fas fa-box"></i>
                </div>
            </div>
        </div>

        <!-- Low Stock Card -->
        <div class="rounded-xl border border-border bg-card p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-muted-foreground uppercase">Low Stock</p>
                    <p class="mt-2 text-2xl font-bold text-foreground">0</p>
                    <p class="mt-1 text-xs text-muted-foreground">Products</p>
                </div>
                <div class="text-3xl text-destructive/20">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid gap-6 lg:grid-cols-2">
        <!-- Sales Chart -->
        <div class="rounded-xl border border-border bg-card p-6 shadow-sm">
            <h2 class="font-semibold text-foreground mb-4">Sales Overview</h2>
            <div class="h-64 flex items-center justify-center text-muted-foreground">
                <div class="text-center">
                    <i class="fas fa-chart-area text-4xl mb-2 opacity-30"></i>
                    <p class="text-sm">Sales data visualization would appear here</p>
                </div>
            </div>
        </div>

        <!-- Inventory Chart -->
        <div class="rounded-xl border border-border bg-card p-6 shadow-sm">
            <h2 class="font-semibold text-foreground mb-4">Inventory Status</h2>
            <div class="h-64 flex items-center justify-center text-muted-foreground">
                <div class="text-center">
                    <i class="fas fa-warehouse text-4xl mb-2 opacity-30"></i>
                    <p class="text-sm">Inventory distribution would appear here</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Products Table -->
    <div class="mt-8 rounded-xl border border-border bg-card shadow-sm">
        <div class="border-b border-border p-6">
            <h2 class="font-semibold text-foreground">Top Products</h2>
            <p class="mt-1 text-sm text-muted-foreground">Best-selling items this period</p>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-border text-sm">
                <thead class="bg-secondary/50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold">Product</th>
                        <th class="px-4 py-3 text-left font-semibold">Units Sold</th>
                        <th class="px-4 py-3 text-left font-semibold">Revenue</th>
                        <th class="px-4 py-3 text-left font-semibold">% of Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    <tr>
                        <td colspan="4" class="px-4 py-8 text-center text-muted-foreground">
                            <i class="fas fa-inbox text-2xl mb-2 block opacity-50"></i>
                            <p>No sales data available yet.</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
