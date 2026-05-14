@extends('layouts.customer')

@section('title', 'Account Settings - Lavender Pharmacy')

@section('content')
    <div>
        <h1 class="font-serif text-3xl font-bold text-foreground">Settings</h1>
        <p class="mt-2 text-muted-foreground">Account preferences (reference layout).</p>
        <div class="mt-8 space-y-4 rounded-xl border border-border bg-card p-6 shadow-sm">
            <div class="flex items-center justify-between border-b border-border pb-4">
                <div>
                    <p class="font-medium text-foreground">Email notifications</p>
                    <p class="text-sm text-muted-foreground">Order updates and promotions</p>
                </div>
                <span class="text-sm text-muted-foreground">On</span>
            </div>
            <div class="flex items-center justify-between">
                <div>
                    <p class="font-medium text-foreground">Password</p>
                    <p class="text-sm text-muted-foreground">Change your sign-in password</p>
                </div>
                <a href="{{ route('password.request') }}" class="text-sm font-medium text-primary hover:underline">Reset</a>
            </div>
        </div>
    </div>
@endsection
