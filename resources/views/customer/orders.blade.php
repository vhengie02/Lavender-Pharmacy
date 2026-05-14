@extends('layouts.app')

@section('title', 'My Orders - Lavender Pharmacy')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <h1 style="color: #5D3A66;"><i class="fas fa-list"></i> My Orders</h1>
    </div>
</div>

@if($orders->isEmpty())
    <div class="alert alert-info">
        You have no orders yet. <a href="{{ route('customer.shop') }}">Start shopping</a>
    </div>
@else
    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Total Amount</th>
                        <th>Payment Method</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>#{{ $order->order_id }}</td>
                            <td>{{ $order->date_ordered->format('M d, Y') }}</td>
                            <td>₱{{ number_format($order->total_amount, 2) }}</td>
                            <td>{{ ucfirst($order->payment_method) }}</td>
                            <td>
                                <span class="badge bg-{{ $order->order_status === 'completed' ? 'success' : ($order->order_status === 'pending' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($order->order_status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-primary" style="background-color: #B57EDC; border-color: #B57EDC;">
                                    <i class="fas fa-eye"></i> View
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{ $orders->links() }}
@endif
@endsection
