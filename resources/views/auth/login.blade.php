@extends('layouts.storefront')

@section('title', 'Login - Lavender Pharmacy')

@section('content')
    <section class="relative bg-gradient-to-b from-primary/10 to-background pb-12 pt-32">
        <div class="container mx-auto px-4">
            <div class="mx-auto max-w-3xl text-center">
                <div class="mb-6 flex justify-center">
                    <x-storefront-logo class="h-14 w-auto sm:h-16" />
                </div>
                <p class="mb-2 text-sm font-medium uppercase tracking-wide text-primary">Account</p>
                <h1 class="text-balance font-serif text-4xl font-bold tracking-tight text-foreground md:text-5xl">Welcome back</h1>
                <p class="mx-auto mt-4 max-w-xl text-pretty text-lg text-muted-foreground">
                    Sign in to continue shopping, track orders, and manage your profile.
                </p>
            </div>
        </div>
    </section>

    <section class="border-b border-border bg-secondary/30 py-16">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-md">
                <div class="rounded-xl border border-border bg-card p-8 shadow-sm">
                    <form action="{{ route('login') }}" method="POST" class="space-y-5">
                        @csrf
                        <div>
                            <label for="email" class="mb-1.5 block text-sm font-medium text-foreground">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required autocomplete="username"
                                class="w-full rounded-lg border border-input bg-background px-3 py-2.5 text-sm text-foreground outline-none focus:ring-2 focus:ring-ring/30 @error('email') border-destructive @enderror"
                                placeholder="you@example.com" />
                            @error('email')
                                <p class="mt-1 text-sm text-destructive">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <div class="mb-1.5 flex items-center justify-between gap-2">
                                <label for="password" class="block text-sm font-medium text-foreground">Password</label>
                                <a href="{{ route('password.request') }}" class="text-xs font-medium text-primary hover:underline">Forgot password?</a>
                            </div>
                            <input type="password" name="password" id="password" required autocomplete="current-password"
                                class="w-full rounded-lg border border-input bg-background px-3 py-2.5 text-sm text-foreground outline-none focus:ring-2 focus:ring-ring/30 @error('password') border-destructive @enderror"
                                placeholder="••••••••" />
                            @error('password')
                                <p class="mt-1 text-sm text-destructive">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" class="w-full rounded-lg bg-primary py-3 text-sm font-medium text-primary-foreground shadow-sm transition-colors hover:bg-primary/90">
                            Sign in
                        </button>
                    </form>

                    <p class="mt-8 border-t border-border pt-6 text-center text-sm text-muted-foreground">
                        Don’t have an account?
                        <a href="{{ route('register') }}" class="font-medium text-primary hover:underline">Create one</a>
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection
