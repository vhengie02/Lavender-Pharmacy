@extends('layouts.storefront')

@section('title', 'Shop - Lavender Pharmacy')

@section('content')
    <section id="catalog" class="scroll-mt-20 bg-secondary/30 py-16 pt-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto mb-12 max-w-3xl text-center">
                <p class="mb-2 text-sm font-medium uppercase tracking-wide text-primary">Catalog</p>
                <h2 class="font-serif text-3xl font-bold tracking-tight text-foreground sm:text-4xl">Health essentials</h2>
                <p class="mt-3 text-muted-foreground">Browse our inventory and add items to your cart.</p>
            </div>

            <div class="mb-10 flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                <form action="{{ route('shop') }}" method="GET" class="flex w-full max-w-md flex-1 flex-col gap-2 sm:flex-row">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products…" class="w-full rounded-lg border border-input bg-card px-4 py-2.5 text-sm text-foreground shadow-sm outline-none ring-ring placeholder:text-muted-foreground focus:border-ring focus:ring-2 focus:ring-ring/30" />
                    <button type="submit" class="shrink-0 rounded-lg bg-primary px-4 py-2.5 text-sm font-medium text-primary-foreground transition-colors hover:bg-primary/90">Search</button>
                </form>
                <form action="{{ route('shop') }}" method="GET" class="w-full max-w-xs">
                    <label for="category" class="sr-only">Category</label>
                    <select id="category" name="category" onchange="this.form.submit()" class="w-full rounded-lg border border-input bg-card px-4 py-2.5 text-sm text-foreground shadow-sm outline-none ring-ring focus:border-ring focus:ring-2 focus:ring-ring/30">
                        <option value="">All categories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->category_id }}" @selected(request('category') == $category->category_id)>{{ $category->category_name }}</option>
                        @endforeach
                    </select>
                </form>
            </div>

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @forelse ($products as $product)
                    <article class="group flex flex-col overflow-hidden rounded-xl border border-border bg-card shadow-sm transition-all duration-300 hover:border-primary/30 hover:shadow-lg hover:shadow-primary/5">
                        <a href="{{ route('product.show', $product->product_id) }}" class="relative block aspect-square overflow-hidden bg-gradient-to-br from-primary/15 to-accent/20">
                            @if ($product->product_image)
                                <img src="{{ asset('uploads/' . $product->product_image) }}" alt="{{ $product->product_name }}" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105" />
                            @else
                                <div class="flex h-full w-full items-center justify-center text-primary/40">
                                    <svg class="h-16 w-16" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3A1.5 1.5 0 0 0 1.5 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" /></svg>
                                </div>
                            @endif
                        </a>
                        <div class="flex flex-1 flex-col p-4">
                            <p class="text-xs font-medium uppercase tracking-wide text-primary">{{ $product->category->category_name ?? 'Product' }}</p>
                            <h3 class="mt-1 font-semibold text-card-foreground group-hover:text-primary">
                                <a href="{{ route('product.show', $product->product_id) }}">{{ $product->product_name }}</a>
                            </h3>
                            <p class="mt-2 line-clamp-2 text-sm text-muted-foreground">{{ Str::limit($product->description, 100) }}</p>
                            <div class="mt-4 flex items-center justify-between gap-2">
                                <span class="text-lg font-bold text-primary">₱{{ number_format($product->price, 2) }}</span>
                                <span class="rounded-full bg-secondary px-2 py-0.5 text-xs text-secondary-foreground">{{ $product->stock_quantity }} in stock</span>
                            </div>
                            <div class="mt-4">
                                @if ($product->stock_quantity > 0)
                                    <form action="{{ route('cart.add') }}" method="POST" class="flex gap-2">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->product_id }}" />
                                        <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock_quantity }}" class="w-16 rounded-lg border border-input bg-background px-2 py-2 text-sm" />
                                        <button type="submit" class="flex-1 rounded-lg border border-border bg-background py-2 text-sm font-medium transition-colors hover:bg-primary hover:text-primary-foreground">Add to cart</button>
                                    </form>
                                @else
                                    <button type="button" disabled class="w-full cursor-not-allowed rounded-lg border border-border py-2 text-sm text-muted-foreground">Out of stock</button>
                                @endif
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full rounded-xl border border-dashed border-border bg-card/50 py-16 text-center text-muted-foreground">
                        <p class="text-lg">No products found.</p>
                        <p class="mt-2 text-sm">Try adjusting your search or filters.</p>
                    </div>
                @endforelse
            </div>

            @if ($products->hasPages())
                <div class="mt-12 flex justify-center">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection
