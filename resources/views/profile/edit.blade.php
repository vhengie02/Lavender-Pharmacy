@extends('layouts.storefront')

@section('title', 'Edit Profile - Lavender Pharmacy')

@section('content')
    <div class="mx-auto max-w-2xl px-4 pb-16 pt-24 sm:px-6 lg:px-8">
        <h1 class="font-serif text-3xl font-bold text-foreground">Edit profile</h1>
        <div class="mt-8 rounded-xl border border-border bg-card p-8 shadow-sm">
            <form action="{{ route('profile.update') }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label for="name" class="mb-1.5 block text-sm font-medium">Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required class="w-full rounded-lg border border-input bg-background px-3 py-2.5 text-sm outline-none focus:ring-2 focus:ring-ring/30 @error('name') border-destructive @enderror" />
                    @error('name')<p class="mt-1 text-sm text-destructive">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="email" class="mb-1.5 block text-sm font-medium">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full rounded-lg border border-input bg-background px-3 py-2.5 text-sm outline-none focus:ring-2 focus:ring-ring/30 @error('email') border-destructive @enderror" />
                    @error('email')<p class="mt-1 text-sm text-destructive">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="contact_number" class="mb-1.5 block text-sm font-medium">Contact number</label>
                    <input type="tel" id="contact_number" name="contact_number" value="{{ old('contact_number', $user->contact_number) }}" class="w-full rounded-lg border border-input bg-background px-3 py-2.5 text-sm outline-none focus:ring-2 focus:ring-ring/30" />
                </div>
                <div>
                    <label for="address" class="mb-1.5 block text-sm font-medium">Address</label>
                    <textarea id="address" name="address" rows="3" class="w-full rounded-lg border border-input bg-background px-3 py-2.5 text-sm outline-none focus:ring-2 focus:ring-ring/30">{{ old('address', $user->address) }}</textarea>
                </div>
                <div>
                    <label for="password" class="mb-1.5 block text-sm font-medium">New password <span class="text-muted-foreground">(optional)</span></label>
                    <input type="password" id="password" name="password" class="w-full rounded-lg border border-input bg-background px-3 py-2.5 text-sm outline-none focus:ring-2 focus:ring-ring/30 @error('password') border-destructive @enderror" />
                    @error('password')<p class="mt-1 text-sm text-destructive">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="password_confirmation" class="mb-1.5 block text-sm font-medium">Confirm password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="w-full rounded-lg border border-input bg-background px-3 py-2.5 text-sm outline-none focus:ring-2 focus:ring-ring/30" />
                </div>
                <div class="flex flex-wrap gap-3 pt-4">
                    <button type="submit" class="rounded-lg bg-primary px-5 py-2.5 text-sm font-medium text-primary-foreground hover:bg-primary/90">Save</button>
                    <a href="{{ route('profile.show') }}" class="rounded-lg border border-border px-5 py-2.5 text-sm hover:bg-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
