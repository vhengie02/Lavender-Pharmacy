@extends('layouts.storefront')

@section('title', 'Access Denied - Lavender Pharmacy')

@section('content')
    <div class="mx-auto max-w-lg px-4 py-24 text-center">
        <p class="text-5xl font-bold text-primary">403</p>
        <h1 class="mt-4 font-serif text-2xl font-bold text-foreground">Access Denied</h1>
        <p class="mt-3 text-muted-foreground">
            You do not have permission to view this page. Contact an administrator if you believe this is an error.
        </p>
        <a href="{{ route('home') }}" class="mt-8 inline-flex items-center gap-2 rounded-lg bg-primary px-5 py-2.5 text-sm font-medium text-primary-foreground hover:bg-primary/90">
            <i class="fas fa-home" aria-hidden="true"></i>
            Go to Home
        </a>
    </div>
@endsection
