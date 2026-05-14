@extends('layouts.storefront')

@section('title', $product->product_name . ' - Lavender Pharmacy')

@section('content')
    <div class="mx-auto max-w-7xl px-4 pb-16 pt-24 sm:px-6 lg:px-8">
        <nav class="mb-8 text-sm text-muted-foreground" aria-label="Breadcrumb">
            <ol class="flex flex-wrap items-center gap-2">
                <li><a href="{{ route('home') }}" class="hover:text-primary">Home</a></li>
                <li>/</li>
                <li><a href="{{ route('customer.shop') }}" class="hover:text-primary">Shop</a></li>
                <li>/</li>
                <li class="text-foreground">{{ $product->product_name }}</li>
            </ol>
        </nav>

        <div class="grid gap-10 lg:grid-cols-2">
            <div class="overflow-hidden rounded-2xl border border-border bg-card shadow-sm">
                @if ($product->product_image)
                    <img src="{{ asset('uploads/' . $product->product_image) }}" alt="{{ $product->product_name }}" class="aspect-square w-full object-cover" />
                @else
                    <div class="flex aspect-square items-center justify-center bg-secondary/50 text-primary/30">
                        <svg class="h-24 w-24" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3A1.5 1.5 0 0 0 1.5 6v12a1.5 1.5 0 0 0 1.5 1.5Z" /></svg>
                    </div>
                @endif
            </div>

            <div class="rounded-2xl border border-border bg-card p-6 shadow-sm sm:p-8">
                <h1 class="font-serif text-3xl font-bold text-foreground">{{ $product->product_name }}</h1>
                @if ($product->category)
                    <p class="mt-2 text-sm text-muted-foreground">Category: <span class="font-medium text-primary">{{ $product->category->category_name }}</span></p>
                @endif
                @if ($product->generic_name)
                    <p class="mt-1 text-sm text-muted-foreground">Generic: {{ $product->generic_name }}</p>
                @endif
                @if ($product->brand_name)
                    <p class="mt-1 text-sm text-muted-foreground">Brand: {{ $product->brand_name }}</p>
                @endif

                <p class="mt-6 text-3xl font-bold text-primary">₱{{ number_format($product->price, 2) }}</p>

                <div class="mt-4">
                    @if ($product->stock_quantity > 0)
                        <span class="inline-flex rounded-full bg-primary/10 px-3 py-1 text-sm font-medium text-primary">{{ $product->stock_quantity }} in stock</span>
                    @else
                        <span class="inline-flex rounded-full bg-destructive/10 px-3 py-1 text-sm font-medium text-destructive">Out of stock</span>
                    @endif
                </div>

                @if ($product->prescription_required)
                    <div class="mt-4 rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-900">This product requires a prescription.</div>
                @endif

                @if ($product->dosage_info)
                    <p class="mt-4 text-sm"><span class="font-medium text-foreground">Dosage:</span> {{ $product->dosage_info }}</p>
                @endif
                @if ($product->manufacturer)
                    <p class="mt-2 text-sm text-muted-foreground"><span class="font-medium">Manufacturer:</span> {{ $product->manufacturer }}</p>
                @endif
                @if ($product->expiration_date)
                    <p class="mt-2 text-sm text-muted-foreground"><span class="font-medium">Expiration:</span> {{ $product->expiration_date->format('F d, Y') }}</p>
                @endif
                @if ($product->barcode)
                    <p class="mt-2 text-sm text-muted-foreground"><span class="font-medium">Barcode:</span> {{ $product->barcode }}</p>
                @endif

                @if ($product->description)
                    <div class="mt-6 border-t border-border pt-6">
                        <h2 class="font-semibold text-foreground">Description</h2>
                        <p class="mt-2 leading-relaxed text-muted-foreground">{{ $product->description }}</p>
                    </div>
                @endif

                <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                    @if ($product->stock_quantity > 0)
                        <form action="{{ route('cart.add') }}" method="POST" class="flex flex-1 flex-wrap items-end gap-3">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->product_id }}" />
                            <div>
                                <label for="quantity" class="mb-1 block text-sm font-medium">Qty</label>
                                <input type="number" id="quantity" name="quantity" value="1" min="1" max="{{ $product->stock_quantity }}" required class="w-24 rounded-lg border border-input bg-background px-3 py-2 text-sm" />
                            </div>
                            <button type="submit" class="rounded-lg bg-primary px-6 py-2.5 text-sm font-medium text-primary-foreground hover:bg-primary/90">Add to cart</button>
                        </form>
                    @else
                        <button type="button" disabled class="cursor-not-allowed rounded-lg border border-border px-6 py-2.5 text-sm text-muted-foreground">Unavailable</button>
                    @endif
                    <a href="{{ route('customer.shop') }}" class="inline-flex items-center justify-center rounded-lg border border-border px-6 py-2.5 text-sm font-medium hover:bg-secondary">Back to shop</a>
                </div>
            </div>
        </div>
    </div>
@endsection
