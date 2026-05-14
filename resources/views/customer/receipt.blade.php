@extends('layouts.storefront')

@section('title', 'Receipt ' . $receipt->invoice_number . ' - Lavender Pharmacy')

@push('head')
    <style>
        @media print {
            body { background: white !important; }
            header, footer, .no-print { display: none !important; }
            main { padding: 0 !important; }
            #printable-receipt { box-shadow: none !important; border: none !important; }
        }
    </style>
@endpush

@section('content')
    @php
        $statusColor = match ($receipt->order->order_status) {
            'completed' => 'bg-primary/15 text-primary',
            'pending' => 'bg-amber-100 text-amber-900',
            default => 'bg-destructive/10 text-destructive',
        };
    @endphp
    <div class="mx-auto max-w-4xl px-4 pb-16 pt-24 sm:px-6 lg:px-8">
        <div class="no-print mb-6 flex flex-wrap items-center justify-between gap-4">
            <h1 class="font-serif text-2xl font-bold text-foreground">Receipt</h1>
            <button type="button" onclick="window.print()" class="rounded-lg bg-primary px-4 py-2 text-sm font-medium text-primary-foreground hover:bg-primary/90">Print</button>
        </div>

        <div id="printable-receipt" class="rounded-xl border border-border bg-card p-8 shadow-sm">
            <div class="text-center">
                <h2 class="text-xl font-bold text-primary">Lavender Pharmacy</h2>
                <p class="text-sm text-muted-foreground">Official receipt</p>
            </div>
            <hr class="my-6 border-primary/30" />

            <div class="grid gap-4 text-sm sm:grid-cols-2">
                <div>
                    <p><span class="text-muted-foreground">Receipt #</span> {{ $receipt->invoice_number }}</p>
                    <p><span class="text-muted-foreground">Date</span> {{ now()->format('F d, Y H:i:s') }}</p>
                </div>
                <div class="sm:text-right">
                    <p><span class="text-muted-foreground">Order</span> #{{ str_pad($receipt->order->order_id, 6, '0', STR_PAD_LEFT) }}</p>
                    <p><span class="text-muted-foreground">Customer</span> {{ $receipt->order->user->name }}</p>
                </div>
            </div>

            <div class="mt-6 grid gap-4 border-t border-border pt-6 text-sm sm:grid-cols-2">
                <div>
                    <p class="font-medium text-foreground">Bill to</p>
                    <p class="mt-2 text-muted-foreground">{{ $receipt->order->user->name }}</p>
                    <p class="text-muted-foreground">{{ $receipt->order->user->address ?? 'N/A' }}</p>
                    <p class="text-muted-foreground">{{ $receipt->order->user->contact_number ?? 'N/A' }}</p>
                    <p class="text-muted-foreground">{{ $receipt->order->user->email }}</p>
                </div>
                <div class="sm:text-right">
                    <p><span class="text-muted-foreground">Payment</span> {{ ucfirst($receipt->order->payment_method) }}</p>
                    <p class="mt-2">
                        <span class="text-muted-foreground">Status</span>
                        <span class="ml-2 inline-flex rounded-full px-2 py-0.5 text-xs font-medium {{ $statusColor }}">{{ ucfirst($receipt->order->order_status) }}</span>
                    </p>
                </div>
            </div>

            <div class="mt-8 overflow-x-auto">
                <table class="min-w-full divide-y divide-border text-sm">
                    <thead class="bg-secondary/50">
                        <tr>
                            <th class="px-4 py-2 text-left">Product</th>
                            <th class="px-4 py-2 text-center">Qty</th>
                            <th class="px-4 py-2 text-right">Unit</th>
                            <th class="px-4 py-2 text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        @foreach ($receipt->order->items as $item)
                            <tr>
                                <td class="px-4 py-2">
                                    <strong>{{ $item->product->product_name }}</strong>
                                    @if ($item->product->generic_name)
                                        <br /><span class="text-xs text-muted-foreground">{{ $item->product->generic_name }}</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 text-center">{{ $item->quantity }}</td>
                                <td class="px-4 py-2 text-right">₱{{ number_format($item->price, 2) }}</td>
                                <td class="px-4 py-2 text-right font-medium">₱{{ number_format($item->price * $item->quantity, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-8 max-w-sm space-y-2 border-t border-border pt-6 text-sm sm:ml-auto">
                <div class="flex justify-between">
                    <span class="text-muted-foreground">Subtotal</span>
                    <strong>₱{{ number_format($receipt->order->total_amount / 1.12, 2) }}</strong>
                </div>
                <div class="flex justify-between">
                    <span class="text-muted-foreground">VAT (12%)</span>
                    <strong>₱{{ number_format($receipt->vat_amount, 2) }}</strong>
                </div>
                <div class="flex justify-between border-t border-primary/30 pt-3 text-lg font-bold text-primary">
                    <span>Total</span>
                    <span>₱{{ number_format($receipt->order->total_amount, 2) }}</span>
                </div>
            </div>

            <p class="mt-10 text-center text-xs text-muted-foreground">Thank you for choosing Lavender Pharmacy.</p>
        </div>

        <div class="no-print mt-8 flex flex-wrap gap-3">
            <a href="{{ route('orders.show', $receipt->order) }}" class="rounded-lg border border-border px-4 py-2 text-sm hover:bg-secondary">Back to order</a>
            <a href="{{ route('orders.index') }}" class="rounded-lg border border-border px-4 py-2 text-sm hover:bg-secondary">All orders</a>
        </div>
    </div>
@endsection
