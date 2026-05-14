@extends('layouts.storefront')

@section('title', 'Login - Lavender Pharmacy')

@section('content')
    <div class="flex min-h-[calc(100vh-4rem)] items-center justify-center bg-gradient-to-br from-primary/5 via-background to-accent/5 px-4 py-16 pt-24">
        <div class="w-full max-w-md">
            <div class="mb-8 text-center">
                <a href="{{ route('home') }}" class="inline-block">
                    <x-storefront-logo class="mx-auto h-12 w-auto" />
                </a>
                <p class="mt-2 text-muted-foreground">Your trusted healthcare partner</p>
            </div>

            <div class="rounded-xl border border-primary/10 bg-card p-8 shadow-lg">
                <div class="mb-6 text-center">
                    <h1 class="font-serif text-2xl font-semibold text-foreground">Welcome back</h1>
                    <p class="mt-1 text-sm text-muted-foreground">Sign in to your account to continue</p>
                </div>

                <form action="{{ route('login') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="email" class="mb-1.5 block text-sm font-medium text-foreground">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required autocomplete="username"
                            class="w-full rounded-lg border border-input bg-background px-3 py-2.5 text-sm text-foreground shadow-sm outline-none ring-ring focus:border-ring focus:ring-2 focus:ring-ring/30 @error('email') border-destructive @enderror"
                            placeholder="you@example.com" />
                        @error('email')
                            <p class="mt-1 text-sm text-destructive">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="password" class="mb-1.5 block text-sm font-medium text-foreground">Password</label>
                        <input type="password" name="password" id="password" required autocomplete="current-password"
                            class="w-full rounded-lg border border-input bg-background px-3 py-2.5 text-sm text-foreground shadow-sm outline-none ring-ring focus:border-ring focus:ring-2 focus:ring-ring/30 @error('password') border-destructive @enderror"
                            placeholder="••••••••" />
                        @error('password')
                            <p class="mt-1 text-sm text-destructive">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="w-full rounded-lg bg-primary py-3 text-sm font-medium text-primary-foreground transition-colors hover:bg-primary/90">Sign in</button>
                </form>

                <p class="mt-6 text-center text-sm text-muted-foreground">
                    Don’t have an account?
                    <a href="{{ route('register') }}" class="font-medium text-primary hover:underline">Sign up</a>
                </p>
            </div>
        </div>
    </div>
@endsection
