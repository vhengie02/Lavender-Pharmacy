@extends('layouts.admin')

@section('title', 'Inventory - Lavender Pharmacy')

@section('content')
    <header class="mb-8 border-b border-border pb-4">
        <h1 class="font-serif text-2xl font-bold text-foreground">Inventory</h1>
        <p class="mt-1 text-sm text-muted-foreground">Stock levels across the catalog (lowest stock first).</p>
    </header>

    <div class="overflow-hidden rounded-xl border border-border bg-card shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-border text-sm">
                <thead class="bg-secondary/50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold">Product</th>
                        <th class="px-4 py-3 text-left font-semibold">Category</th>
                        <th class="px-4 py-3 text-right font-semibold">Stock</th>
                        <th class="px-4 py-3 text-right font-semibold">Price</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @foreach ($products as $product)
                        <tr class="{{ $product->stock_quantity < 10 ? 'bg-amber-50/80' : '' }}">
                            <td class="px-4 py-3 font-medium">{{ $product->product_name }}</td>
                            <td class="px-4 py-3 text-muted-foreground">{{ $product->category->category_name ?? '—' }}</td>
                            <td class="px-4 py-3 text-right">{{ $product->stock_quantity }}</td>
                            <td class="px-4 py-3 text-right">₱{{ number_format($product->price, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="border-t border-border px-4 py-3">{{ $products->links() }}</div>
    </div>
@endsection
