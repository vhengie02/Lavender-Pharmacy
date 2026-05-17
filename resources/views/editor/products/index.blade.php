@extends('layouts.editor')

@section('title', 'Products - Lavender Pharmacy')

@section('content')
<div class="dashboard-main" style="width:100%; min-height:100vh; background:#F7F3FC;">
    <div style="padding:32px 40px; max-width:1400px; margin:0 auto;">
        <header class="mb-8 flex flex-col gap-4 border-b border-border pb-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h1 class="font-serif text-2xl font-bold text-foreground">Products</h1>
                <p class="mt-1 text-sm text-muted-foreground">Manage pharmacy inventory and stock levels.</p>
            </div>
            <a href="{{ route('editor.products.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-primary px-4 py-2 text-sm font-semibold text-primary-foreground hover:opacity-90">
                <i class="fas fa-plus"></i> Add New Product
            </a>
        </header>

        <form action="{{ route('editor.products.index') }}" method="GET" class="mb-6 flex flex-wrap gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, generic name, or barcode…" class="min-w-[200px] flex-1 rounded-lg border border-input bg-background px-3 py-2 text-sm" />
            <select name="category" class="rounded-lg border border-input bg-background px-3 py-2 text-sm">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->category_id }}" {{ request('category') == $category->category_id ? 'selected' : '' }}>
                        {{ $category->category_name }}
                    </option>
                @endforeach
            </select>
            <select name="stock" class="rounded-lg border border-input bg-background px-3 py-2 text-sm">
                <option value="">All Stock Levels</option>
                <option value="low" {{ request('stock') === 'low' ? 'selected' : '' }}>Low Stock (&lt; 10)</option>
            </select>
            <button type="submit" class="rounded-lg bg-primary px-4 py-2 text-sm text-primary-foreground">
                <i class="fas fa-search"></i> Search
            </button>
        </form>

        <div class="overflow-hidden rounded-xl border border-border bg-card shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-border text-sm">
                    <thead class="bg-secondary/50">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold">Product</th>
                            <th class="px-4 py-3 text-left font-semibold">Category</th>
                            <th class="px-4 py-3 text-right font-semibold">Price</th>
                            <th class="px-4 py-3 text-right font-semibold">Stock</th>
                            <th class="px-4 py-3 text-left font-semibold">Expiration</th>
                            <th class="px-4 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        @forelse($products as $product)
                            <tr>
                                <td class="px-4 py-3">
                                    <span class="font-medium">{{ $product->product_name }}</span>
                                    @if($product->prescription_required)
                                        <br><span class="mt-1 inline-block rounded bg-primary/10 px-2 py-0.5 text-xs text-primary">Rx Required</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-muted-foreground">{{ $product->category->category_name ?? '—' }}</td>
                                <td class="px-4 py-3 text-right">₱{{ number_format($product->price, 2) }}</td>
                                <td class="px-4 py-3 text-right">
                                    <span class="{{ $product->stock_quantity < 10 ? 'font-semibold text-destructive' : '' }}">
                                        {{ $product->stock_quantity }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-muted-foreground">
                                    @if($product->expiration_date)
                                        {{ $product->expiration_date->format('M d, Y') }}
                                    @else
                                        —
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('editor.products.edit', $product) }}" class="text-primary hover:underline">Edit</a>
                                        <form action="{{ route('editor.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-destructive hover:underline">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-muted-foreground">No products found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($products->hasPages())
                <div class="border-t border-border px-4 py-3">{{ $products->links() }}</div>
            @endif
        </div>
    </div>
</div>
@endsection
