@extends('layouts.admin')

@section('title', 'Order #' . $order->order_id . ' - Admin')

@section('content')
    @php
        $subtotal = $order->total_amount / 1.12;
        $vat = $order->total_amount - $subtotal;
    @endphp
    <header class="mb-8 flex flex-wrap items-center justify-between gap-4 border-b border-border pb-4">
        <div>
            <h1 class="font-serif text-2xl font-bold text-foreground">Order #{{ str_pad($order->order_id, 6, '0', STR_PAD_LEFT) }}</h1>
            <p class="mt-1 text-sm text-muted-foreground">{{ $order->date_ordered?->format('F d, Y H:i') }}</p>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="text-sm font-medium text-primary hover:underline">Back to orders</a>
    </header>

    <div class="mb-6 rounded-xl border border-border bg-card p-6 shadow-sm">
        <h2 class="mb-4 font-semibold">Update status</h2>
        <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="flex flex-wrap items-end gap-3">
            @csrf
            @method('PATCH')
            <div>
                <label for="order_status" class="mb-1 block text-xs font-medium text-muted-foreground">Status</label>
                <select name="order_status" id="order_status" class="rounded-lg border border-input bg-background px-3 py-2 text-sm">
                    @foreach (['pending', 'completed', 'cancelled'] as $s)
                        <option value="{{ $s }}" @selected($order->order_status === $s)>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="rounded-lg bg-primary px-4 py-2 text-sm font-medium text-primary-foreground hover:bg-primary/90">Save</button>
        </form>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="space-y-6 lg:col-span-2">
            <div class="overflow-hidden rounded-xl border border-border bg-card shadow-sm">
                <div class="border-b border-border px-6 py-4">
                    <h2 class="font-semibold">Line items</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-border text-sm">
                        <thead class="bg-secondary/50">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold">Product</th>
                                <th class="px-4 py-3 text-left font-semibold">Qty</th>
                                <th class="px-4 py-3 text-right font-semibold">Unit</th>
                                <th class="px-4 py-3 text-right font-semibold">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border">
                            @foreach ($order->items as $item)
                                <tr>
                                    <td class="px-4 py-3">{{ $item->product->product_name ?? '—' }}</td>
                                    <td class="px-4 py-3">{{ $item->quantity }}</td>
                                    <td class="px-4 py-3 text-right">₱{{ number_format($item->price, 2) }}</td>
                                    <td class="px-4 py-3 text-right font-medium">₱{{ number_format($item->price * $item->quantity, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="rounded-xl border border-border bg-card p-6 shadow-sm">
                <h2 class="font-semibold">Totals</h2>
                <div class="mt-4 space-y-2 text-sm">
                    <div class="flex justify-between"><span class="text-muted-foreground">Subtotal</span><span>₱{{ number_format($subtotal, 2) }}</span></div>
                    <div class="flex justify-between"><span class="text-muted-foreground">VAT (12%)</span><span>₱{{ number_format($vat, 2) }}</span></div>
                    <div class="flex justify-between border-t border-border pt-3 text-lg font-bold text-primary">
                        <span>Total</span><span>₱{{ number_format($order->total_amount, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="rounded-xl border border-border bg-card p-6 shadow-sm">
            <h2 class="font-semibold">Customer</h2>
            <p class="mt-3 font-medium">{{ $order->user->name ?? '—' }}</p>
            <p class="mt-2 text-sm text-muted-foreground">{{ $order->user->email ?? '' }}</p>
            <p class="mt-2 text-sm capitalize text-muted-foreground">Payment: {{ $order->payment_method }}</p>
        </div>
    </div>
@endsection
