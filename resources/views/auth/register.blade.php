@extends('layouts.storefront')

@section('title', 'Register - Lavender Pharmacy')

@section('content')
    <div class="flex min-h-[calc(100vh-4rem)] items-center justify-center bg-gradient-to-br from-primary/5 via-background to-accent/5 px-4 py-16 pt-24">
        <div class="w-full max-w-lg">
            <div class="mb-8 text-center">
                <a href="{{ route('home') }}" class="inline-block">
                    <x-storefront-logo class="mx-auto h-12 w-auto" />
                </a>
                <p class="mt-2 text-muted-foreground">Create your customer account</p>
            </div>

            <div class="rounded-xl border border-primary/10 bg-card p-8 shadow-lg">
                <div class="mb-6 text-center">
                    <h1 class="font-serif text-2xl font-semibold text-foreground">Create account</h1>
                </div>

                <form action="{{ route('register') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="name" class="mb-1.5 block text-sm font-medium">Full name</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required class="w-full rounded-lg border border-input bg-background px-3 py-2.5 text-sm outline-none focus:ring-2 focus:ring-ring/30 @error('name') border-destructive @enderror" />
                        @error('name')<p class="mt-1 text-sm text-destructive">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="email" class="mb-1.5 block text-sm font-medium">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required class="w-full rounded-lg border border-input bg-background px-3 py-2.5 text-sm outline-none focus:ring-2 focus:ring-ring/30 @error('email') border-destructive @enderror" />
                        @error('email')<p class="mt-1 text-sm text-destructive">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="contact_number" class="mb-1.5 block text-sm font-medium">Contact number <span class="text-muted-foreground">(optional)</span></label>
                        <input type="tel" id="contact_number" name="contact_number" value="{{ old('contact_number') }}" class="w-full rounded-lg border border-input bg-background px-3 py-2.5 text-sm outline-none focus:ring-2 focus:ring-ring/30" />
                    </div>
                    <div>
                        <label for="address" class="mb-1.5 block text-sm font-medium">Address <span class="text-muted-foreground">(optional)</span></label>
                        <textarea id="address" name="address" rows="3" class="w-full rounded-lg border border-input bg-background px-3 py-2.5 text-sm outline-none focus:ring-2 focus:ring-ring/30">{{ old('address') }}</textarea>
                    </div>
                    <div>
                        <label for="password" class="mb-1.5 block text-sm font-medium">Password</label>
                        <input type="password" id="password" name="password" required class="w-full rounded-lg border border-input bg-background px-3 py-2.5 text-sm outline-none focus:ring-2 focus:ring-ring/30 @error('password') border-destructive @enderror" />
                        @error('password')<p class="mt-1 text-sm text-destructive">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="password_confirmation" class="mb-1.5 block text-sm font-medium">Confirm password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required class="w-full rounded-lg border border-input bg-background px-3 py-2.5 text-sm outline-none focus:ring-2 focus:ring-ring/30" />
                    </div>
                    <button type="submit" class="w-full rounded-lg bg-primary py-3 text-sm font-medium text-primary-foreground hover:bg-primary/90">Register</button>
                </form>
                <p class="mt-6 text-center text-sm text-muted-foreground">
                    Already have an account? <a href="{{ route('login') }}" class="font-medium text-primary hover:underline">Sign in</a>
                </p>
            </div>
        </div>
    </div>
@endsection
