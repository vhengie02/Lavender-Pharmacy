@extends('layouts.admin')

@section('title', 'Receipt Management - Admin')

@section('content')
<div class="container-fluid mt-4">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1><i class="fas fa-receipt"></i> Receipt Management</h1>
        </div>
    </div>

    @if($receipts->isEmpty())
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> No receipts found yet.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Receipt #</th>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($receipts as $receipt)
                    <tr>
                        <td>{{ $receipt->invoice_number }}</td>
                        <td>#{{ $receipt->order_id }}</td>
                        <td>{{ $receipt->order->user->name ?? 'N/A' }}</td>
                        <td>₱{{ number_format($receipt->order->total_amount, 2) }}</td>
                        <td>{{ $receipt->date_created->format('M d, Y') }}</td>
                        <td>
                            <a href="{{ route('receipts.show', $receipt->receipt_id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('receipts.download', $receipt->receipt_id) }}" class="btn btn-sm btn-success">
                                <i class="fas fa-download"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
