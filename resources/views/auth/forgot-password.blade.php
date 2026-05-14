@extends('layouts.storefront')

@section('title', 'Reset Password - Lavender Pharmacy')

@section('content')
    <div class="flex min-h-[calc(100vh-4rem)] items-center justify-center bg-gradient-to-br from-primary/5 via-background to-accent/5 px-4 py-16 pt-24">
        <div class="w-full max-w-md">
            <div class="mb-8 text-center">
                <a href="{{ route('home') }}" class="inline-block">
                    <x-storefront-logo class="mx-auto h-12 w-auto" />
                </a>
            </div>

            <div class="rounded-xl border border-primary/10 bg-card p-8 shadow-lg">
                <div class="mb-6 text-center">
                    <h1 class="font-serif text-2xl font-semibold text-foreground">Reset Password</h1>
                    <p class="mt-1 text-sm text-muted-foreground">Enter your email to receive a password reset link</p>
                </div>

                @if (session('success'))
                    <div class="mb-4 rounded-lg border border-primary/20 bg-primary/10 px-4 py-3 text-sm text-foreground">{{ session('success') }}</div>
                @endif

                <form action="{{ route('password.email') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="email" class="mb-1.5 block text-sm font-medium text-foreground">Email Address</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required autocomplete="email"
                            class="w-full rounded-lg border border-input bg-background px-3 py-2.5 text-sm text-foreground shadow-sm outline-none ring-ring focus:border-ring focus:ring-2 focus:ring-ring/30 @error('email') border-destructive @enderror"
                            placeholder="you@example.com" />
                        @error('email')
                            <p class="mt-1 text-sm text-destructive">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="w-full rounded-lg bg-primary py-3 text-sm font-medium text-primary-foreground transition-colors hover:bg-primary/90">Send reset link</button>
                </form>

                <p class="mt-6 text-center text-sm text-muted-foreground">
                    <a href="{{ route('login') }}" class="font-medium text-primary hover:underline">Back to Sign In</a>
                </p>
            </div>
        </div>
    </div>
@endsection
