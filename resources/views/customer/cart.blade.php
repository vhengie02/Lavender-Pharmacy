@extends('layouts.storefront')

@section('title', 'Shopping Cart - Lavender Pharmacy')

@section('content')
    <div class="mx-auto max-w-7xl px-4 pb-16 pt-24 sm:px-6 lg:px-8">
        <h1 class="font-serif text-3xl font-bold text-foreground">Shopping cart</h1>
        <p class="mt-2 text-muted-foreground">Review your items before checkout.</p>

        @if ($cartItems->isEmpty())
            <div class="mt-10 rounded-xl border border-border bg-card p-10 text-center text-muted-foreground">
                <p>Your cart is empty.</p>
                <a href="{{ route('shop') }}" class="mt-4 inline-block text-sm font-medium text-primary hover:underline">Continue shopping</a>
            </div>
        @else
            @php
                $subtotal = $cartItems->sum(fn ($item) => $item->product->price * $item->quantity);
                $vat = $subtotal * 0.12;
                $total = $subtotal + $vat;
            @endphp
            <div class="mt-10 grid gap-8 lg:grid-cols-3">
                <div class="lg:col-span-2">
                    <div class="overflow-hidden rounded-xl border border-border bg-card shadow-sm">
                        <table class="min-w-full divide-y divide-border text-sm">
                            <thead class="bg-secondary/50">
                                <tr>
                                    <th class="px-4 py-3 text-left font-semibold text-foreground">Product</th>
                                    <th class="hidden px-4 py-3 text-right font-semibold text-foreground sm:table-cell">Price</th>
                                    <th class="px-4 py-3 text-left font-semibold text-foreground">Qty</th>
                                    <th class="px-4 py-3 text-right font-semibold text-foreground">Subtotal</th>
                                    <th class="px-4 py-3"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-border">
                                @foreach ($cartItems as $item)
                                    <tr>
                                        <td class="px-4 py-4">
                                            <span class="font-medium text-foreground">{{ $item->product->product_name }}</span>
                                            <p class="text-xs text-muted-foreground">{{ $item->product->category->category_name ?? '' }}</p>
                                        </td>
                                        <td class="hidden px-4 py-4 text-right text-muted-foreground sm:table-cell">₱{{ number_format($item->product->price, 2) }}</td>
                                        <td class="px-4 py-4">
                                            <form action="{{ route('cart.update', $item->cart_id) }}" method="POST" class="flex flex-wrap items-center gap-2">
                                                @csrf
                                                @method('PUT')
                                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="w-16 rounded-lg border border-input bg-background px-2 py-1.5 text-sm" />
                                                <button type="submit" class="rounded-lg border border-border px-2 py-1 text-xs hover:bg-secondary">Update</button>
                                            </form>
                                        </td>
                                        <td class="px-4 py-4 text-right font-medium">₱{{ number_format($item->product->price * $item->quantity, 2) }}</td>
                                        <td class="px-4 py-4">
                                            <form action="{{ route('cart.remove', $item->cart_id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-sm text-destructive hover:underline">Remove</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div>
                    <div class="rounded-xl border border-border bg-card p-6 shadow-sm">
                        <h2 class="font-serif text-lg font-semibold">Order summary</h2>
                        <div class="mt-4 space-y-2 text-sm">
                            <div class="flex justify-between text-muted-foreground"><span>Subtotal</span><span>₱{{ number_format($subtotal, 2) }}</span></div>
                            <div class="flex justify-between text-muted-foreground"><span>VAT (12%)</span><span>₱{{ number_format($vat, 2) }}</span></div>
                            <div class="border-t border-border pt-3 text-base font-semibold text-foreground">
                                <div class="flex justify-between"><span>Total</span><span>₱{{ number_format($total, 2) }}</span></div>
                            </div>
                        </div>
                        <a href="{{ route('orders.checkout') }}" class="mt-6 block w-full rounded-lg bg-primary py-3 text-center text-sm font-medium text-primary-foreground hover:bg-primary/90">Proceed to checkout</a>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
