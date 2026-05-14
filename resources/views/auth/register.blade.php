@extends('layouts.storefront')

@section('title', 'Register - Lavender Pharmacy')

@section('content')
    <section class="relative bg-gradient-to-b from-primary/10 to-background pb-12 pt-32">
        <div class="container mx-auto px-4">
            <div class="mx-auto max-w-3xl text-center">
                <div class="mb-6 flex justify-center">
                    <x-storefront-logo class="h-14 w-auto sm:h-16" />
                </div>
                <p class="mb-2 text-sm font-medium uppercase tracking-wide text-primary">Account</p>
                <h1 class="text-balance font-serif text-4xl font-bold tracking-tight text-foreground md:text-5xl">Create your account</h1>
                <p class="mx-auto mt-4 max-w-xl text-pretty text-lg text-muted-foreground">
                    Join Lavender Pharmacy to shop online, save addresses, and track your orders.
                </p>
            </div>
        </div>
    </section>

    <section class="border-b border-border bg-secondary/30 py-16">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-lg">
                <div class="rounded-xl border border-border bg-card p-8 shadow-sm">
                    <form action="{{ route('register') }}" method="POST" class="space-y-5">
                        @csrf
                        <div>
                            <label for="name" class="mb-1.5 block text-sm font-medium text-foreground">Full name</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required class="w-full rounded-lg border border-input bg-background px-3 py-2.5 text-sm text-foreground outline-none focus:ring-2 focus:ring-ring/30 @error('name') border-destructive @enderror" />
                            @error('name')<p class="mt-1 text-sm text-destructive">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="email" class="mb-1.5 block text-sm font-medium text-foreground">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required class="w-full rounded-lg border border-input bg-background px-3 py-2.5 text-sm text-foreground outline-none focus:ring-2 focus:ring-ring/30 @error('email') border-destructive @enderror" />
                            @error('email')<p class="mt-1 text-sm text-destructive">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="contact_number" class="mb-1.5 block text-sm font-medium text-foreground">Contact number <span class="font-normal text-muted-foreground">(optional)</span></label>
                            <input type="tel" id="contact_number" name="contact_number" value="{{ old('contact_number') }}" class="w-full rounded-lg border border-input bg-background px-3 py-2.5 text-sm text-foreground outline-none focus:ring-2 focus:ring-ring/30" />
                        </div>
                        <div>
                            <label for="address" class="mb-1.5 block text-sm font-medium text-foreground">Address <span class="font-normal text-muted-foreground">(optional)</span></label>
                            <textarea id="address" name="address" rows="3" class="w-full rounded-lg border border-input bg-background px-3 py-2.5 text-sm text-foreground outline-none focus:ring-2 focus:ring-ring/30">{{ old('address') }}</textarea>
                        </div>
                        <div>
                            <label for="password" class="mb-1.5 block text-sm font-medium text-foreground">Password</label>
                            <input type="password" id="password" name="password" required class="w-full rounded-lg border border-input bg-background px-3 py-2.5 text-sm text-foreground outline-none focus:ring-2 focus:ring-ring/30 @error('password') border-destructive @enderror" />
                            @error('password')<p class="mt-1 text-sm text-destructive">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="password_confirmation" class="mb-1.5 block text-sm font-medium text-foreground">Confirm password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" required class="w-full rounded-lg border border-input bg-background px-3 py-2.5 text-sm text-foreground outline-none focus:ring-2 focus:ring-ring/30" />
                        </div>
                        <button type="submit" class="w-full rounded-lg bg-primary py-3 text-sm font-medium text-primary-foreground shadow-sm transition-colors hover:bg-primary/90">Register</button>
                    </form>
                    <p class="mt-8 border-t border-border pt-6 text-center text-sm text-muted-foreground">
                        Already have an account?
                        <a href="{{ route('login') }}" class="font-medium text-primary hover:underline">Sign in</a>
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection
