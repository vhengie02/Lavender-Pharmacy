@extends('layouts.editor')

@section('title', 'Receipts - Editor')

@section('content')
    <div class="mb-8">
        <h1 class="font-serif text-3xl font-bold text-foreground">Receipts</h1>
        <p class="mt-1 text-muted-foreground">Orders with generated receipts.</p>
    </div>
    <div class="overflow-hidden rounded-xl border border-border bg-card shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-border text-sm">
                <thead class="bg-secondary/50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold">Invoice</th>
                        <th class="px-4 py-3 text-left font-semibold">Order</th>
                        <th class="px-4 py-3 text-left font-semibold">Created</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @forelse ($receipts as $receipt)
                        <tr>
                            <td class="px-4 py-3 font-mono text-xs">{{ $receipt->invoice_number }}</td>
                            <td class="px-4 py-3">#{{ $receipt->order_id }}</td>
                            <td class="px-4 py-3 text-muted-foreground">{{ $receipt->date_created?->format('M d, Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-8 text-center text-muted-foreground">No receipts.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="border-t border-border px-4 py-3">{{ $receipts->links() }}</div>
    </div>
@endsection
