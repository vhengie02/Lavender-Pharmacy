@extends('layouts.admin')

@section('title', 'Orders - Lavender Pharmacy')

@section('content')
    <header class="mb-8 flex flex-col gap-4 border-b border-border pb-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="font-serif text-2xl font-bold text-foreground">Orders</h1>
            <p class="mt-1 text-sm text-muted-foreground">Fulfillment queue and history.</p>
        </div>
        <form action="{{ route('admin.orders.index') }}" method="GET" class="flex flex-wrap gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search…" class="rounded-lg border border-input bg-background px-3 py-2 text-sm" />
            <select name="status" class="rounded-lg border border-input bg-background px-3 py-2 text-sm" onchange="this.form.submit()">
                <option value="">All statuses</option>
                @foreach (['pending', 'completed', 'cancelled'] as $s)
                    <option value="{{ $s }}" @selected(request('status') === $s)>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
        </form>
    </header>

    <div class="overflow-hidden rounded-xl border border-border bg-card shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-border text-sm">
                <thead class="bg-secondary/50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold">Order</th>
                        <th class="px-4 py-3 text-left font-semibold">Customer</th>
                        <th class="px-4 py-3 text-left font-semibold">Date</th>
                        <th class="px-4 py-3 text-right font-semibold">Total</th>
                        <th class="px-4 py-3 text-left font-semibold">Status</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @foreach ($orders as $order)
                        <tr>
                            <td class="px-4 py-3 font-mono text-xs">#{{ str_pad($order->order_id, 6, '0', STR_PAD_LEFT) }}</td>
                            <td class="px-4 py-3">{{ $order->user->name ?? '—' }}</td>
                            <td class="px-4 py-3 text-muted-foreground">{{ $order->date_ordered?->format('M d, Y') }}</td>
                            <td class="px-4 py-3 text-right font-medium">₱{{ number_format($order->total_amount, 2) }}</td>
                            <td class="px-4 py-3 capitalize">{{ $order->order_status }}</td>
                            <td class="px-4 py-3">
                                <a href="{{ route('admin.orders.show', $order) }}" class="text-sm font-medium text-primary hover:underline">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="border-t border-border px-4 py-3">{{ $orders->links() }}</div>
    </div>
@endsection
