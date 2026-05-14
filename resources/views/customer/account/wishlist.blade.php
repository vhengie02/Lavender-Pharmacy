@extends('layouts.customer')

@section('title', 'Wishlist - Lavender Pharmacy')

@section('content')
    <div>
        <h1 class="font-serif text-3xl font-bold text-foreground">Wishlist</h1>
        <p class="mt-2 text-muted-foreground">Items you have saved for later.</p>
        <div class="mt-8 rounded-xl border border-dashed border-border bg-card/50 p-12 text-center text-muted-foreground">
            <p>Your wishlist is empty.</p>
            <a href="{{ route('shop') }}" class="mt-4 inline-block text-sm font-medium text-primary hover:underline">Browse the shop</a>
        </div>
    </div>
@endsection
