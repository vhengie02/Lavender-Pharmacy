@extends('layouts.admin')

@section('title', 'Sales Reports - Lavender Pharmacy')

@section('content')
    <header class="mb-8 border-b border-border pb-4">
        <h1 class="font-serif text-2xl font-bold text-foreground">Sales reports</h1>
        <p class="mt-1 text-sm text-muted-foreground">Completed order revenue summary.</p>
    </header>

    <div class="mb-8 rounded-xl border border-border bg-card p-6 shadow-sm">
        <p class="text-sm text-muted-foreground">Lifetime revenue (completed)</p>
        <p class="mt-2 font-serif text-3xl font-bold text-primary">₱{{ number_format($completedTotal, 2) }}</p>
    </div>

    <div class="overflow-hidden rounded-xl border border-border bg-card shadow-sm">
        <div class="border-b border-border px-6 py-4">
            <h2 class="font-semibold">Recent completed orders</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-border text-sm">
                <thead class="bg-secondary/50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold">Order</th>
                        <th class="px-4 py-3 text-left font-semibold">Customer</th>
                        <th class="px-4 py-3 text-left font-semibold">Date</th>
                        <th class="px-4 py-3 text-right font-semibold">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @forelse ($recentCompleted as $order)
                        <tr>
                            <td class="px-4 py-3 font-mono text-xs">#{{ $order->order_id }}</td>
                            <td class="px-4 py-3">{{ $order->user->name ?? '—' }}</td>
                            <td class="px-4 py-3 text-muted-foreground">{{ $order->date_ordered?->format('M d, Y') }}</td>
                            <td class="px-4 py-3 text-right font-medium">₱{{ number_format($order->total_amount, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-muted-foreground">No completed orders.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
