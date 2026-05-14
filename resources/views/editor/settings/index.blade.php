@extends('layouts.editor')

@section('title', 'Editor Settings')

@section('content')
    <div class="mb-8">
        <h1 class="font-serif text-3xl font-bold text-foreground">Settings</h1>
        <p class="mt-1 text-muted-foreground">Editor preferences and device options (reference layout).</p>
    </div>
    <div class="max-w-xl rounded-xl border border-border bg-card p-6 shadow-sm">
        <p class="text-sm text-muted-foreground">Printer, receipt template, and register assignment can be configured to match the zip example.</p>
    </div>
@endsection
