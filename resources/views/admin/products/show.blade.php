@extends('layouts.admin')

@section('title', $product->product_name . ' - Admin')

@section('content')
    <header class="mb-8 flex flex-wrap items-center justify-between gap-4 border-b border-border pb-4">
        <div>
            <h1 class="font-serif text-2xl font-bold text-foreground">{{ $product->product_name }}</h1>
            <p class="mt-1 text-sm text-muted-foreground">{{ $product->category->category_name ?? '' }}</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.products.edit', $product) }}" class="rounded-lg bg-primary px-4 py-2 text-sm text-primary-foreground hover:bg-primary/90">Edit</a>
            <a href="{{ route('admin.products.index') }}" class="rounded-lg border border-border px-4 py-2 text-sm hover:bg-secondary">Back</a>
        </div>
    </header>

    <div class="grid gap-6 lg:grid-cols-2">
        <div class="rounded-xl border border-border bg-card p-6 shadow-sm">
            <h2 class="font-semibold">Details</h2>
            <dl class="mt-4 space-y-2 text-sm">
                <div class="flex justify-between"><dt class="text-muted-foreground">Generic</dt><dd>{{ $product->generic_name ?? '—' }}</dd></div>
                <div class="flex justify-between"><dt class="text-muted-foreground">Brand</dt><dd>{{ $product->brand_name ?? '—' }}</dd></div>
                <div class="flex justify-between"><dt class="text-muted-foreground">Price</dt><dd>₱{{ number_format($product->price, 2) }}</dd></div>
                <div class="flex justify-between"><dt class="text-muted-foreground">Stock</dt><dd>{{ $product->stock_quantity }}</dd></div>
                <div class="flex justify-between"><dt class="text-muted-foreground">Rx required</dt><dd>{{ $product->prescription_required ? 'Yes' : 'No' }}</dd></div>
                <div class="flex justify-between"><dt class="text-muted-foreground">Expires</dt><dd>{{ $product->expiration_date?->format('M d, Y') }}</dd></div>
            </dl>
        </div>
        <div class="rounded-xl border border-border bg-card p-6 shadow-sm">
            <h2 class="font-semibold">Description</h2>
            <p class="mt-4 text-sm text-muted-foreground">{{ $product->description ?? 'No description.' }}</p>
        </div>
    </div>

    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="mt-8" onsubmit="return confirm('Delete this product?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="rounded-lg border border-destructive px-4 py-2 text-sm text-destructive hover:bg-destructive/10">Delete product</button>
    </form>
@endsection
