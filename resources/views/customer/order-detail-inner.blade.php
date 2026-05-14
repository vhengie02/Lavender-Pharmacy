@php
    $subtotal = $order->total_amount / 1.12;
    $vat = $order->total_amount - $subtotal;
    $statusCls = match ($order->order_status) {
        'completed' => 'bg-primary/15 text-primary',
        'pending' => 'bg-amber-100 text-amber-900',
        default => 'bg-destructive/10 text-destructive',
    };
    $ordersListUrl = $ordersListUrl ?? route('orders.index');
    $wrapperClass = $wrapperClass ?? 'mx-auto max-w-7xl px-4 pb-16 pt-24 sm:px-6 lg:px-8';
@endphp
<div class="{{ $wrapperClass }}">
    <h1 class="font-serif text-3xl font-bold text-foreground">Order details</h1>

    <div class="mt-10 grid gap-8 lg:grid-cols-3">
        <div class="space-y-6 lg:col-span-2">
            <div class="overflow-hidden rounded-xl border border-border bg-card shadow-sm">
                <div class="border-b border-border bg-primary px-6 py-4 text-primary-foreground">
                    <h2 class="font-semibold">Order #{{ str_pad($order->order_id, 6, '0', STR_PAD_LEFT) }}</h2>
                </div>
                <div class="grid gap-4 p-6 sm:grid-cols-2">
                    <div class="text-sm">
                        <p class="text-muted-foreground">Date</p>
                        <p class="font-medium">{{ $order->date_ordered->format('F d, Y H:i') }}</p>
                    </div>
                    <div class="text-sm">
                        <p class="text-muted-foreground">Payment</p>
                        <p class="font-medium capitalize">{{ $order->payment_method }}</p>
                    </div>
                    <div class="text-sm">
                        <p class="text-muted-foreground">Status</p>
                        <span class="mt-1 inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium {{ $statusCls }}">{{ ucfirst($order->order_status) }}</span>
                    </div>
                    <div class="text-sm">
                        <p class="text-muted-foreground">Delivery</p>
                        <p class="font-medium">{{ $order->delivery_status ?? 'Pending' }}</p>
                    </div>
                    @if ($order->receipt)
                        <div class="text-sm sm:col-span-2">
                            <p class="text-muted-foreground">Receipt</p>
                            <p class="font-medium">{{ $order->receipt->invoice_number }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="overflow-hidden rounded-xl border border-border bg-card shadow-sm">
                <div class="border-b border-border bg-primary px-6 py-4 text-primary-foreground">
                    <h2 class="font-semibold">Items</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-border text-sm">
                        <thead class="bg-secondary/50">
                            <tr>
                                <th class="px-6 py-3 text-left font-semibold">Product</th>
                                <th class="px-6 py-3 text-left font-semibold">Qty</th>
                                <th class="px-6 py-3 text-right font-semibold">Unit</th>
                                <th class="px-6 py-3 text-right font-semibold">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border">
                            @foreach ($order->items as $item)
                                <tr>
                                    <td class="px-6 py-3">
                                        <span class="font-medium">{{ $item->product->product_name }}</span>
                                        @if ($item->product->generic_name)
                                            <p class="text-xs text-muted-foreground">{{ $item->product->generic_name }}</p>
                                        @endif
                                    </td>
                                    <td class="px-6 py-3">{{ $item->quantity }}</td>
                                    <td class="px-6 py-3 text-right">₱{{ number_format($item->price, 2) }}</td>
                                    <td class="px-6 py-3 text-right font-medium">₱{{ number_format($item->price * $item->quantity, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="rounded-xl border border-border bg-card p-6 shadow-sm">
                <h2 class="font-semibold text-foreground">Totals</h2>
                <div class="mt-4 space-y-2 text-sm">
                    <div class="flex justify-between"><span class="text-muted-foreground">Subtotal</span><span>₱{{ number_format($subtotal, 2) }}</span></div>
                    <div class="flex justify-between"><span class="text-muted-foreground">VAT (12%)</span><span>₱{{ number_format($vat, 2) }}</span></div>
                    <div class="flex justify-between border-t border-border pt-3 text-lg font-bold text-primary">
                        <span>Total</span><span>₱{{ number_format($order->total_amount, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="rounded-xl border border-border bg-card p-6 shadow-sm">
                <h2 class="font-semibold text-foreground">Shipping</h2>
                <p class="mt-3 font-medium">{{ $order->user->name }}</p>
                <p class="mt-2 text-sm text-muted-foreground">{{ $order->user->address ?? 'Not provided' }}</p>
                <p class="mt-2 text-sm text-muted-foreground">{{ $order->user->contact_number ?? 'No phone' }}</p>
                <p class="mt-2 text-sm text-muted-foreground">{{ $order->user->email }}</p>
            </div>
            <div class="rounded-xl border border-border bg-card p-6 shadow-sm">
                @if ($order->receipt)
                    <a href="{{ route('receipts.show', $order->receipt) }}" class="mb-3 block w-full rounded-lg bg-primary py-2.5 text-center text-sm font-medium text-primary-foreground hover:bg-primary/90">View receipt</a>
                    <a href="{{ route('receipts.download', $order->receipt) }}" class="mb-3 block w-full rounded-lg border border-border py-2.5 text-center text-sm font-medium hover:bg-secondary">Download</a>
                @endif
                <a href="{{ $ordersListUrl }}" class="block w-full rounded-lg border border-border py-2.5 text-center text-sm font-medium hover:bg-secondary">Back to orders</a>
            </div>
        </div>
    </div>
</div>
