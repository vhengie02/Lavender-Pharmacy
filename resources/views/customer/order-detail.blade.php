@extends('layouts.app')

@section('title', 'Order #' . $order->order_id . ' - Lavender Pharmacy')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <h1 style="color: #5D3A66;"><i class="fas fa-receipt"></i> Order Details</h1>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <!-- Order Information -->
        <div class="card shadow-sm mb-4">
            <div class="card-header" style="background-color: #B57EDC; color: white;">
                <h5 class="mb-0">Order #{{ str_pad($order->order_id, 6, '0', STR_PAD_LEFT) }}</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-2"><strong>Order Date:</strong> {{ $order->date_ordered->format('F d, Y H:i') }}</p>
                        <p class="mb-2"><strong>Payment Method:</strong> {{ ucfirst($order->payment_method) }}</p>
                        <p class="mb-2">
                            <strong>Status:</strong>
                            @php
                                $statusColor = match($order->order_status) {
                                    'completed' => '#28a745',
                                    'pending' => '#ffc107',
                                    default => '#dc3545'
                                };
                            @endphp
                            <span class="badge" style="background-color: {{ $statusColor }}">
                                {{ ucfirst($order->order_status) }}
                            </span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-2"><strong>Delivery Status:</strong> {{ $order->delivery_status ?? 'Pending' }}</p>
                        @if($order->receipt)
                            <p class="mb-2"><strong>Receipt Number:</strong> {{ $order->receipt->invoice_number }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Items -->
        <div class="card shadow-sm mb-4">
            <div class="card-header" style="background-color: #B57EDC; color: white;">
                <h5 class="mb-0">Items Ordered</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr style="background-color: #f8f9fa;">
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                                <tr>
                                    <td>
                                        <strong>{{ $item->product->product_name }}</strong><br>
                                        <small class="text-muted">{{ $item->product->generic_name ?? '' }}</small>
                                    </td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>₱{{ number_format($item->price, 2) }}</td>
                                    <td><strong>₱{{ number_format($item->price * $item->quantity, 2) }}</strong></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="card shadow-sm">
            <div class="card-header" style="background-color: #B57EDC; color: white;">
                <h5 class="mb-0">Order Summary</h5>
            </div>
            <div class="card-body">
                @php
                    $subtotal = $order->total_amount / 1.12; // Remove VAT
                    $vat = $order->total_amount - $subtotal;
                @endphp
                <div class="row mb-3">
                    <div class="col-md-8 text-end"><strong>Subtotal:</strong></div>
                    <div class="col-md-4"><strong>₱{{ number_format($subtotal, 2) }}</strong></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-8 text-end"><strong>VAT (12%):</strong></div>
                    <div class="col-md-4"><strong>₱{{ number_format($vat, 2) }}</strong></div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-8 text-end"><h5 style="color: #B57EDC;">Total Amount:</h5></div>
                    <div class="col-md-4"><h5 style="color: #B57EDC;">₱{{ number_format($order->total_amount, 2) }}</h5></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-md-4">
        <!-- Shipping Address -->
        <div class="card shadow-sm mb-4">
            <div class="card-header" style="background-color: #B57EDC; color: white;">
                <h5 class="mb-0">Shipping Address</h5>
            </div>
            <div class="card-body">
                <p class="mb-2"><strong>{{ $order->user->name }}</strong></p>
                <p class="mb-2">{{ $order->user->address ?? 'Not provided' }}</p>
                <p class="mb-2">📞 {{ $order->user->contact_number ?? 'Not provided' }}</p>
                <p class="mb-0">📧 {{ $order->user->email }}</p>
            </div>
        </div>

        <!-- Actions -->
        <div class="card shadow-sm">
            <div class="card-body">
                @if($order->receipt)
                    <a href="{{ route('receipts.show', $order->receipt) }}" class="btn btn-primary w-100 mb-2" style="background-color: #B57EDC; border-color: #B57EDC;">
                        <i class="fas fa-file-pdf"></i> View Receipt
                    </a>
                    <a href="{{ route('receipts.download', $order->receipt) }}" class="btn btn-outline-primary w-100 mb-2">
                        <i class="fas fa-download"></i> Download Receipt
                    </a>
                @endif
                <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary w-100">
                    <i class="fas fa-arrow-left"></i> Back to Orders
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
