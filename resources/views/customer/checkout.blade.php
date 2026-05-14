@extends('layouts.storefront')

@section('title', 'Checkout - Lavender Pharmacy')

@section('content')
    <div class="mx-auto max-w-7xl px-4 pb-16 pt-24 sm:px-6 lg:px-8">
        <h1 class="font-serif text-3xl font-bold text-foreground">Checkout</h1>
        <p class="mt-2 text-muted-foreground">Confirm your order and choose a payment method.</p>

        <div class="mt-10 grid gap-8 lg:grid-cols-3">
            <div class="space-y-6 lg:col-span-2">
                <div class="overflow-hidden rounded-xl border border-border bg-card shadow-sm">
                    <div class="border-b border-border bg-secondary/40 px-6 py-4">
                        <h2 class="font-semibold text-foreground">Order items</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-border text-sm">
                            <thead>
                                <tr class="text-left text-muted-foreground">
                                    <th class="px-6 py-3 font-medium">Product</th>
                                    <th class="px-6 py-3 font-medium">Qty</th>
                                    <th class="px-6 py-3 font-medium">Price</th>
                                    <th class="px-6 py-3 font-medium">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-border">
                                @foreach ($cartItems as $item)
                                    <tr>
                                        <td class="px-6 py-3">{{ $item->product->product_name }}</td>
                                        <td class="px-6 py-3">{{ $item->quantity }}</td>
                                        <td class="px-6 py-3">₱{{ number_format($item->product->price, 2) }}</td>
                                        <td class="px-6 py-3 font-medium">₱{{ number_format($item->product->price * $item->quantity, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="rounded-xl border border-border bg-card p-6 shadow-sm">
                    <h2 class="font-semibold text-foreground">Payment method</h2>
                    <form action="{{ route('orders.store') }}" method="POST" class="mt-4 space-y-4">
                        @csrf
                        <label class="flex cursor-pointer items-center gap-3 rounded-lg border border-border p-4 has-[:checked]:border-primary has-[:checked]:bg-primary/5">
                            <input type="radio" name="payment_method" value="cash" class="text-primary" checked />
                            <span>Cash on delivery</span>
                        </label>
                        <label class="flex cursor-pointer items-center gap-3 rounded-lg border border-border p-4 has-[:checked]:border-primary has-[:checked]:bg-primary/5">
                            <input type="radio" name="payment_method" value="gcash" class="text-primary" />
                            <span>GCash</span>
                        </label>
                        <label class="flex cursor-pointer items-center gap-3 rounded-lg border border-border p-4 has-[:checked]:border-primary has-[:checked]:bg-primary/5">
                            <input type="radio" name="payment_method" value="card" class="text-primary" />
                            <span>Credit / debit card</span>
                        </label>
                        <button type="submit" class="w-full rounded-lg bg-primary py-3 text-sm font-medium text-primary-foreground hover:bg-primary/90">Complete order</button>
                    </form>
                </div>
            </div>

            <div class="rounded-xl border border-border bg-card p-6 shadow-sm">
                <h2 class="font-serif text-lg font-semibold">Summary</h2>
                <div class="mt-4 space-y-2 text-sm">
                    <div class="flex justify-between text-muted-foreground"><span>Subtotal</span><span>₱{{ number_format($total, 2) }}</span></div>
                    <div class="flex justify-between text-muted-foreground"><span>VAT (12%)</span><span>₱{{ number_format($total * 0.12, 2) }}</span></div>
                    <div class="border-t border-border pt-3 text-base font-semibold">
                        <div class="flex justify-between text-foreground"><span>Total</span><span>₱{{ number_format($total * 1.12, 2) }}</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
