@extends('layouts.storefront')

@section('title', 'My Profile - Lavender Pharmacy')

@section('content')
    <div class="mx-auto max-w-2xl px-4 pb-16 pt-24 sm:px-6 lg:px-8">
        <h1 class="font-serif text-3xl font-bold text-foreground">Profile</h1>
        <div class="mt-8 rounded-xl border border-border bg-card p-8 shadow-sm">
            <dl class="space-y-6 text-sm">
                <div>
                    <dt class="text-muted-foreground">Name</dt>
                    <dd class="mt-1 text-lg font-medium text-foreground">{{ $user->name }}</dd>
                </div>
                <div>
                    <dt class="text-muted-foreground">Email</dt>
                    <dd class="mt-1 text-lg font-medium">{{ $user->email }}</dd>
                </div>
                <div>
                    <dt class="text-muted-foreground">Contact</dt>
                    <dd class="mt-1">{{ $user->contact_number ?? 'Not provided' }}</dd>
                </div>
                <div>
                    <dt class="text-muted-foreground">Address</dt>
                    <dd class="mt-1">{{ $user->address ?? 'Not provided' }}</dd>
                </div>
                <div>
                    <dt class="text-muted-foreground">Role</dt>
                    <dd class="mt-1"><span class="inline-flex rounded-full bg-primary/10 px-3 py-1 text-xs font-medium text-primary">{{ ucfirst($user->role) }}</span></dd>
                </div>
            </dl>
            <a href="{{ route('profile.edit') }}" class="mt-8 inline-flex rounded-lg bg-primary px-5 py-2.5 text-sm font-medium text-primary-foreground hover:bg-primary/90">Edit profile</a>
        </div>
    </div>
@endsection
