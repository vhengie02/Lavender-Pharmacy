@extends('layouts.admin')

@section('title', 'Admin Settings - Lavender Pharmacy')

@section('content')
    <header class="mb-8 border-b border-border pb-4">
        <h1 class="font-serif text-2xl font-bold text-foreground">Settings</h1>
        <p class="mt-1 text-sm text-muted-foreground">Store configuration (reference layout).</p>
    </header>

    <div class="max-w-xl rounded-xl border border-border bg-card p-6 shadow-sm">
        <p class="text-sm text-muted-foreground">Administrative preferences and integrations can be configured here to match your deployment.</p>
    </div>
@endsection
