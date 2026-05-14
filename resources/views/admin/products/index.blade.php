@extends('layouts.admin')

@section('title', 'Products - Admin')

@section('content')
    <header class="mb-8 flex flex-col gap-4 border-b border-border pb-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="font-serif text-2xl font-bold text-foreground">Products</h1>
            <p class="mt-1 text-sm text-muted-foreground">Catalog administration.</p>
        </div>
        <form action="{{ route('admin.products.index') }}" method="GET" class="flex flex-wrap gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search…" class="rounded-lg border border-input bg-background px-3 py-2 text-sm" />
            <button type="submit" class="rounded-lg bg-primary px-4 py-2 text-sm text-primary-foreground">Search</button>
        </form>
    </header>

    <div class="overflow-hidden rounded-xl border border-border bg-card shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-border text-sm">
                <thead class="bg-secondary/50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold">Name</th>
                        <th class="px-4 py-3 text-left font-semibold">Category</th>
                        <th class="px-4 py-3 text-right font-semibold">Price</th>
                        <th class="px-4 py-3 text-right font-semibold">Stock</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @foreach ($products as $product)
                        <tr>
                            <td class="px-4 py-3 font-medium">{{ $product->product_name }}</td>
                            <td class="px-4 py-3 text-muted-foreground">{{ $product->category->category_name ?? '—' }}</td>
                            <td class="px-4 py-3 text-right">₱{{ number_format($product->price, 2) }}</td>
                            <td class="px-4 py-3 text-right">{{ $product->stock_quantity }}</td>
                            <td class="px-4 py-3">
                                <a href="{{ route('admin.products.show', $product) }}" class="text-primary hover:underline">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="border-t border-border px-4 py-3">{{ $products->links() }}</div>
    </div>
@endsection
