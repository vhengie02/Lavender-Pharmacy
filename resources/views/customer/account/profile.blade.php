@extends('layouts.customer')

@section('title', 'Profile - Lavender Pharmacy')

@section('content')
    <div>
        <h1 class="font-serif text-3xl font-bold text-foreground">Profile</h1>
        <div class="mt-6 rounded-xl border border-border bg-card p-6 shadow-sm sm:p-8">
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
            </dl>
            <a href="{{ route('profile.edit') }}" class="mt-8 inline-flex rounded-lg bg-primary px-5 py-2.5 text-sm font-medium text-primary-foreground hover:bg-primary/90">Edit profile</a>
        </div>
    </div>
@endsection
