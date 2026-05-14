@extends('layouts.customer')

@section('title', 'My Orders - Lavender Pharmacy')

@section('content')
    <div>
        <h1 class="font-serif text-3xl font-bold text-foreground">Orders</h1>

        @if ($orders->isEmpty())
            <div class="mt-8 rounded-xl border border-border bg-card p-10 text-center text-muted-foreground">
                <p>You have no orders yet.</p>
                <a href="{{ route('shop') }}" class="mt-4 inline-block text-sm font-medium text-primary hover:underline">Start shopping</a>
            </div>
        @else
            <div class="mt-8 overflow-hidden rounded-xl border border-border bg-card shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-border text-sm">
                        <thead class="bg-secondary/50">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold">Order</th>
                                <th class="px-4 py-3 text-left font-semibold">Date</th>
                                <th class="px-4 py-3 text-left font-semibold">Total</th>
                                <th class="px-4 py-3 text-left font-semibold">Payment</th>
                                <th class="px-4 py-3 text-left font-semibold">Status</th>
                                <th class="px-4 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border">
                            @foreach ($orders as $order)
                                <tr>
                                    <td class="px-4 py-3 font-mono text-xs">#{{ str_pad($order->order_id, 6, '0', STR_PAD_LEFT) }}</td>
                                    <td class="px-4 py-3 text-muted-foreground">{{ $order->date_ordered->format('M d, Y') }}</td>
                                    <td class="px-4 py-3 font-medium">₱{{ number_format($order->total_amount, 2) }}</td>
                                    <td class="px-4 py-3 capitalize text-muted-foreground">{{ $order->payment_method }}</td>
                                    <td class="px-4 py-3">
                                        @php
                                            $cls = match ($order->order_status) {
                                                'completed' => 'bg-primary/15 text-primary',
                                                'pending' => 'bg-amber-100 text-amber-900',
                                                default => 'bg-destructive/10 text-destructive',
                                            };
                                        @endphp
                                        <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium {{ $cls }}">{{ ucfirst($order->order_status) }}</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <a href="{{ route('customer.orders.show', $order) }}" class="text-sm font-medium text-primary hover:underline">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="mt-8">{{ $orders->links() }}</div>
        @endif
    </div>
@endsection
