@extends('layouts.admin')

@section('title', 'Receipt Management - Admin')

@section('content')
<div style="width:100%; min-height:100vh; background:#F7F3FC; padding:32px 40px; max-width:1400px; margin:0 auto;">
    <header class="mb-8 border-b border-border pb-4">
        <h1 class="font-serif text-2xl font-bold text-foreground">
            <i class="fas fa-receipt"></i> Receipts
        </h1>
        <p class="mt-1 text-sm text-muted-foreground">Manage customer receipts and invoices.</p>
    </header>
    <div class="overflow-hidden rounded-xl border border-border bg-card shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-border text-sm">
                <thead class="bg-secondary/50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold">Invoice #</th>
                        <th class="px-4 py-3 text-left font-semibold">Order</th>
                        <th class="px-4 py-3 text-left font-semibold">Customer</th>
                        <th class="px-4 py-3 text-left font-semibold">Amount</th>
                        <th class="px-4 py-3 text-left font-semibold">Date</th>
                        <th class="px-4 py-3 text-right font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @forelse ($receipts as $receipt)
                        <tr class="hover:bg-muted/50 transition-colors">
                            <td class="px-4 py-3 font-mono text-xs">{{ $receipt->invoice_number }}</td>
                            <td class="px-4 py-3">#{{ $receipt->order_id }}</td>
                            <td class="px-4 py-3">{{ $receipt->order->user->name ?? 'N/A' }}</td>
                            <td class="px-4 py-3 font-semibold">₱{{ number_format($receipt->order->total_amount, 2) }}</td>
                            <td class="px-4 py-3 text-muted-foreground">{{ $receipt->date_created->format('M d, Y') }}</td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('receipts.show', $receipt->receipt_id) }}" class="inline-flex items-center justify-center rounded-lg border border-border px-3 py-2 text-xs font-medium hover:bg-secondary transition-colors" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('receipts.download', $receipt->receipt_id) }}" class="inline-flex items-center justify-center rounded-lg border border-border px-3 py-2 text-xs font-medium hover:bg-secondary transition-colors" title="Download">
                                        <i class="fas fa-download"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center text-muted-foreground">
                                <i class="fas fa-inbox text-2xl mb-2 block opacity-50"></i>
                                <p>No receipts found.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="border-t border-border px-4 py-3">{{ $receipts->links() }}</div>
    </div>
{!! '</'.'div>' !!}
@endsection
