<section id="products" class="bg-secondary/30 py-24">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="mx-auto mb-16 max-w-3xl text-center">
            <p class="mb-2 text-sm font-medium uppercase tracking-wide text-primary">Featured Products</p>
            <h2 class="font-serif text-3xl font-bold tracking-tight text-foreground sm:text-4xl lg:text-5xl">Health Essentials for You</h2>
            <p class="mt-4 text-lg leading-relaxed text-muted-foreground">
                Discover our carefully curated selection of health and wellness products,
                chosen by our pharmacists to support your daily well-being.
            </p>
        </div>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ([
                ['name' => 'Daily Multivitamins', 'category' => 'Supplements', 'price' => '₱24.99', 'badge' => 'Bestseller', 'from' => 'from-primary/30', 'to' => 'to-accent/30'],
                ['name' => 'Organic Lavender Oil', 'category' => 'Aromatherapy', 'price' => '₱18.99', 'badge' => 'New', 'from' => 'from-accent/30', 'to' => 'to-primary/20'],
                ['name' => 'First Aid Kit', 'category' => 'Emergency Care', 'price' => '₱34.99', 'badge' => null, 'from' => 'from-primary/20', 'to' => 'to-accent/20'],
                ['name' => 'Pain Relief Cream', 'category' => 'Topicals', 'price' => '₱12.99', 'badge' => 'Popular', 'from' => 'from-primary/20', 'to' => 'to-accent/20'],
            ] as $p)
                <article class="group overflow-hidden rounded-xl border border-border bg-card transition-all duration-300 hover:border-primary/30 hover:shadow-lg hover:shadow-primary/5">
                    <div class="relative aspect-square overflow-hidden bg-gradient-to-br {{ $p['from'] }} {{ $p['to'] }}">
                        @if ($p['badge'])
                            <span class="absolute left-3 top-3 rounded-full bg-primary px-2.5 py-0.5 text-xs font-medium text-primary-foreground">{{ $p['badge'] }}</span>
                        @endif
                        <div class="flex h-full w-full items-center justify-center">
                            <span class="text-5xl font-bold text-primary/40">{{ substr($p['name'], 0, 1) }}</span>
                        </div>
                    </div>
                    <div class="p-5">
                        <p class="text-xs font-medium uppercase tracking-wide text-primary">{{ $p['category'] }}</p>
                        <h3 class="mt-1 font-semibold text-foreground">{{ $p['name'] }}</h3>
                        <div class="mt-4 flex items-center justify-between">
                            <span class="text-lg font-bold text-foreground">{{ $p['price'] }}</span>
                            <a href="{{ route('shop') }}" class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-primary text-primary-foreground transition-colors hover:bg-primary/90" aria-label="View shop">
                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" /></svg>
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-12 text-center">
            <a href="{{ route('shop') }}" class="inline-flex items-center justify-center rounded-lg border border-border bg-background px-8 py-3 text-sm font-medium text-foreground shadow-sm transition-colors hover:bg-secondary">View All Products</a>
        </div>
    </div>
</section>
