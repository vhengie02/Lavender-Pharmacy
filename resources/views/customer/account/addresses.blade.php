@extends('layouts.customer')

@section('title', 'Addresses - Lavender Pharmacy')

@section('content')
    <div>
        <h1 class="font-serif text-3xl font-bold text-foreground">Addresses</h1>
        <p class="mt-2 text-muted-foreground">Manage your delivery addresses.</p>
        <div class="mt-8 rounded-xl border border-border bg-card p-6 shadow-sm">
            <h2 class="font-semibold text-foreground">Default address</h2>
            <p class="mt-3 text-sm text-muted-foreground">{{ $user->address ?? 'No address on file. Update your profile to add one.' }}</p>
            <a href="{{ route('profile.edit') }}" class="mt-4 inline-flex rounded-lg border border-border px-4 py-2 text-sm font-medium hover:bg-secondary">Edit in profile</a>
        </div>
    </div>
@endsection
