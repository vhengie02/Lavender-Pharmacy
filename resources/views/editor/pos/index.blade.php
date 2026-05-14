@extends('layouts.editor')

@section('title', 'Point of Sale - Editor')

@section('content')
    <div class="mb-8">
        <h1 class="font-serif text-3xl font-bold text-foreground">Point of Sale</h1>
        <p class="mt-1 text-muted-foreground">In-store checkout (reference layout). Wire to your POS backend as needed.</p>
    </div>
    <div class="grid gap-6 lg:grid-cols-3">
        <div class="rounded-xl border border-border bg-card p-6 shadow-sm lg:col-span-2">
            <p class="text-sm text-muted-foreground">Cart and barcode entry would appear here, matching the reference Next.js screen.</p>
        </div>
        <div class="rounded-xl border border-border bg-card p-6 shadow-sm">
            <h2 class="font-semibold">Totals</h2>
            <p class="mt-4 text-sm text-muted-foreground">Subtotal, tax, and tender amounts align with the zip layout when connected to live sales data.</p>
        </div>
    </div>
@endsection
