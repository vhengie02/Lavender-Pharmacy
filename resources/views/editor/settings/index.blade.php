@extends('layouts.editor')

@section('title', 'Editor Settings')

@section('content')
<div style="width:100%; min-height:100vh; background:#F7F3FC; padding:32px 40px; max-width:1400px; margin:0 auto;">
    <header class="mb-8 border-b border-border pb-4">
        <h1 class="font-serif text-2xl font-bold text-foreground">Settings</h1>
        <p class="mt-1 text-sm text-muted-foreground">Editor preferences and device options (reference layout).</p>
    </header>
    <div class="max-w-xl rounded-xl border border-border bg-card p-6 shadow-sm">
        <p class="text-sm text-muted-foreground">Printer, receipt template, and register assignment can be configured to match the zip example.</p>
    </div>
</div>
@endsection
