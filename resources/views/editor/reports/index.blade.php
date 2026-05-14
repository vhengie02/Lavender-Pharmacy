@extends('layouts.editor')

@section('title', 'Reports - Editor')

@section('content')
    <div class="mb-8">
        <h1 class="font-serif text-3xl font-bold text-foreground">Reports</h1>
        <p class="mt-1 text-muted-foreground">Sales and inventory summaries (reference layout).</p>
    </div>
    <div class="rounded-xl border border-border bg-card p-8 text-sm text-muted-foreground shadow-sm">
        Connect reporting queries here to mirror the charts and tables from the reference site.
    </div>
@endsection
