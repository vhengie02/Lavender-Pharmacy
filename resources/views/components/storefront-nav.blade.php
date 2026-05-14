@php
    $shopUrl = route('shop');
@endphp
<header class="fixed top-0 left-0 right-0 z-50 border-b border-border bg-background/80 backdrop-blur-md">
    <nav class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
        <a href="{{ route('home') }}" class="shrink-0">
            <x-storefront-logo class="h-10 w-auto" />
        </a>

        <div class="hidden items-center gap-8 md:flex">
            <a href="{{ route('home') }}" class="text-sm font-medium text-muted-foreground transition-colors hover:text-primary">Home</a>
            <a href="{{ $shopUrl }}#catalog" class="text-sm font-medium text-muted-foreground transition-colors hover:text-primary">Shop</a>
            <a href="{{ route('home') }}#about" class="text-sm font-medium text-muted-foreground transition-colors hover:text-primary">About</a>
            <a href="{{ route('home') }}#contact" class="text-sm font-medium text-muted-foreground transition-colors hover:text-primary">Contact</a>
        </div>

        <div class="hidden items-center gap-4 md:flex">
            <a href="tel:+1234567890" class="flex items-center gap-2 text-sm text-muted-foreground transition-colors hover:text-primary">
                <svg class="h-4 w-4 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" /></svg>
                <span>(123) 456-7890</span>
            </a>
            @auth
                <a href="{{ route('cart.index') }}" class="inline-flex h-10 w-10 items-center justify-center rounded-md text-muted-foreground transition-colors hover:bg-secondary hover:text-primary" aria-label="Cart">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" /></svg>
                </a>
                <div class="relative group">
                    <button type="button" class="inline-flex h-10 w-10 items-center justify-center rounded-md text-muted-foreground transition-colors hover:bg-secondary hover:text-primary" aria-expanded="false" aria-haspopup="true" id="user-menu-btn">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" /></svg>
                    </button>
                    <div class="invisible absolute right-0 top-full z-50 mt-1 w-48 origin-top-right rounded-lg border border-border bg-card py-1 opacity-0 shadow-lg transition-all group-hover:visible group-hover:opacity-100" role="menu">
                        <div class="border-b border-border px-3 py-2 text-sm text-muted-foreground">{{ auth()->user()->name }}</div>
                        <a href="{{ route('orders.index') }}" class="block px-3 py-2 text-sm text-foreground hover:bg-secondary">Orders</a>
                        <a href="{{ route('profile.show') }}" class="block px-3 py-2 text-sm text-foreground hover:bg-secondary">Profile</a>
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 text-sm text-foreground hover:bg-secondary">Admin</a>
                        @endif
                        @if(auth()->user()->role === 'editor')
                            <a href="{{ route('editor.dashboard') }}" class="block px-3 py-2 text-sm text-foreground hover:bg-secondary">Editor</a>
                        @endif
                        <form action="{{ route('logout') }}" method="POST" class="border-t border-border">
                            @csrf
                            <button type="submit" class="w-full px-3 py-2 text-left text-sm text-destructive hover:bg-secondary">Logout</button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="inline-flex h-10 w-10 items-center justify-center rounded-md text-muted-foreground transition-colors hover:bg-secondary hover:text-primary" aria-label="Account">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" /></svg>
                </a>
            @endauth
            <a href="{{ $shopUrl }}#catalog" class="inline-flex items-center justify-center rounded-lg bg-primary px-4 py-2 text-sm font-medium text-primary-foreground shadow-sm transition-colors hover:bg-primary/90">Shop Now</a>
        </div>

        <button type="button" class="inline-flex items-center justify-center rounded-md p-2 text-foreground md:hidden" onclick="document.getElementById('mobile-nav').classList.toggle('hidden')" aria-expanded="false" aria-controls="mobile-nav" aria-label="Toggle menu">
            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" /></svg>
        </button>
    </nav>

    <div id="mobile-nav" class="hidden border-t border-border md:hidden">
        <div class="space-y-1 px-2 pb-3 pt-2">
            <a href="{{ route('home') }}" class="block rounded-md px-3 py-2 text-base font-medium text-muted-foreground hover:bg-secondary hover:text-primary">Home</a>
            <a href="{{ $shopUrl }}#catalog" class="block rounded-md px-3 py-2 text-base font-medium text-muted-foreground hover:bg-secondary hover:text-primary">Shop</a>
            <a href="{{ route('home') }}#about" class="block rounded-md px-3 py-2 text-base font-medium text-muted-foreground hover:bg-secondary hover:text-primary">About</a>
            <a href="{{ route('home') }}#contact" class="block rounded-md px-3 py-2 text-base font-medium text-muted-foreground hover:bg-secondary hover:text-primary">Contact</a>
            @guest
                <a href="{{ route('login') }}" class="mt-2 block rounded-lg bg-primary px-3 py-2 text-center text-sm font-medium text-primary-foreground">Sign in</a>
            @else
                <a href="{{ route('cart.index') }}" class="mt-2 block rounded-lg bg-primary px-3 py-2 text-center text-sm font-medium text-primary-foreground">Cart</a>
            @endguest
        </div>
    </div>
</header>
