@extends('layouts.customer')

@section('title', 'Payment Methods - Lavender Pharmacy')

@section('content')
    <div>
        <h1 class="font-serif text-3xl font-bold text-foreground">Payment methods</h1>
        <p class="mt-2 text-muted-foreground">Saved cards and wallets (reference layout).</p>
        <div class="mt-8 rounded-xl border border-dashed border-border bg-card/50 p-12 text-center text-muted-foreground">
            <p>No saved payment methods yet.</p>
            <p class="mt-2 text-sm">Checkout supports cash, GCash, and card as configured in the store.</p>
        </div>
    </div>
@endsection
