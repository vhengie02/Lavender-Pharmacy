@extends('layouts.app')

@section('title', 'Receipt ' . $receipt->invoice_number . ' - Lavender Pharmacy')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center">
            <h1 style="color: #5D3A66;"><i class="fas fa-file-invoice"></i> Receipt</h1>
            <button onclick="window.print()" class="btn btn-primary" style="background-color: #B57EDC; border-color: #B57EDC;">
                <i class="fas fa-print"></i> Print Receipt
            </button>
        </div>
    </div>
</div>

<!-- Receipt Content (Printable) -->
<div id="printable-receipt" class="card shadow-sm" style="border: 1px solid #ddd; padding: 30px;">
    <div class="row mb-4">
        <div class="col-md-12 text-center">
            <h2 style="color: #B57EDC;">🌸 LAVENDER PHARMACY 🌸</h2>
            <p class="text-muted">Professional Pharmacy Management System</p>
        </div>
    </div>

    <hr style="border: 2px solid #B57EDC;">

    <!-- Receipt Header -->
    <div class="row mb-4">
        <div class="col-md-6">
            <p><strong>Receipt Number:</strong> {{ $receipt->invoice_number }}</p>
            <p><strong>Date:</strong> {{ now()->format('F d, Y H:i:s') }}</p>
        </div>
        <div class="col-md-6 text-end">
            <p><strong>Order ID:</strong> #{{ str_pad($receipt->order->order_id, 6, '0', STR_PAD_LEFT) }}</p>
            <p><strong>Customer:</strong> {{ $receipt->order->user->name }}</p>
        </div>
    </div>

    <!-- Customer Information -->
    <div class="row mb-4">
        <div class="col-md-6">
            <p><strong>Customer Details:</strong></p>
            <p>
                {{ $receipt->order->user->name }}<br>
                {{ $receipt->order->user->address ?? 'N/A' }}<br>
                📞 {{ $receipt->order->user->contact_number ?? 'N/A' }}<br>
                📧 {{ $receipt->order->user->email }}
            </p>
        </div>
        <div class="col-md-6 text-end">
            <p><strong>Payment Method:</strong> {{ ucfirst($receipt->order->payment_method) }}</p>
            @php
                $statusColor = match($receipt->order->order_status) {
                    'completed' => '#28a745',
                    'pending' => '#ffc107',
                    default => '#dc3545'
                };
            @endphp
            <p><strong>Order Status:</strong> <span class="badge" style="background-color: {{ $statusColor }}">{{ ucfirst($receipt->order->order_status) }}</span></p>
        </div>
    </div>

    <hr>

    <!-- Items Table -->
    <div class="table-responsive mb-4">
        <table class="table table-bordered">
            <thead style="background-color: #f8f9fa;">
                <tr>
                    <th style="width: 50%;">Product Description</th>
                    <th style="width: 10%;">Qty</th>
                    <th style="width: 20%;">Unit Price</th>
                    <th style="width: 20%;">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($receipt->order->items as $item)
                    <tr>
                        <td>
                            <strong>{{ $item->product->product_name }}</strong><br>
                            <small>{{ $item->product->generic_name ?? 'N/A' }}</small>
                        </td>
                        <td class="text-center">{{ $item->quantity }}</td>
                        <td class="text-end">₱{{ number_format($item->price, 2) }}</td>
                        <td class="text-end"><strong>₱{{ number_format($item->price * $item->quantity, 2) }}</strong></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Summary Section -->
    <div class="row mb-4">
        <div class="col-md-8 offset-md-4">
            <table class="table table-borderless" style="font-size: 14px;">
                <tr>
                    <td style="width: 50%;" class="text-end"><strong>Subtotal:</strong></td>
                    <td class="text-end" style="width: 50%;"><strong>₱{{ number_format(($receipt->order->total_amount / 1.12), 2) }}</strong></td>
                </tr>
                <tr>
                    <td class="text-end"><strong>VAT (12%):</strong></td>
                    <td class="text-end"><strong>₱{{ number_format($receipt->vat_amount, 2) }}</strong></td>
                </tr>
                <tr style="border-top: 2px solid #B57EDC; border-bottom: 2px solid #B57EDC;">
                    <td class="text-end" style="padding: 10px 0;"><h5 style="color: #B57EDC; margin: 0;">TOTAL AMOUNT:</h5></td>
                    <td class="text-end" style="padding: 10px 0;"><h5 style="color: #B57EDC; margin: 0;">₱{{ number_format($receipt->order->total_amount, 2) }}</h5></td>
                </tr>
            </table>
        </div>
    </div>

    <hr style="border: 2px solid #B57EDC;">

    <!-- Footer -->
    <div class="text-center mt-4">
        <p style="font-size: 12px; color: #666;">
            <strong>Thank you for shopping at Lavender Pharmacy!</strong><br>
            This is your official receipt. Please keep it for your records.<br>
            <br>
            © 2026 Lavender Pharmacy. All rights reserved.
        </p>
    </div>
</div>

<!-- Non-printable actions -->
<div class="row mt-4 d-print-none">
    <div class="col-md-12">
        <a href="{{ route('orders.show', $receipt->order) }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Back to Order
        </a>
        <a href="{{ route('orders.index') }}" class="btn btn-outline-primary">
            <i class="fas fa-list"></i> View All Orders
        </a>
    </div>
</div>

@section('styles')
<style>
    @media print {
        body {
            background: white;
            padding: 0;
        }
        .navbar, footer, .d-print-none, .btn {
            display: none !important;
        }
        #printable-receipt {
            box-shadow: none !important;
            border: none !important;
            padding: 0 !important;
        }
    }
</style>
@endsection
@endsection
