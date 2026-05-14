@extends('layouts.app')

@section('title', 'Checkout - Lavender Pharmacy')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <h1 style="color: #5D3A66;"><i class="fas fa-money-check-alt"></i> Checkout</h1>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h5 class="card-title">Order Items</h5>
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cartItems as $item)
                            <tr>
                                <td>{{ $item->product->product_name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>₱{{ number_format($item->product->price, 2) }}</td>
                                <td>₱{{ number_format($item->product->price * $item->quantity, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Payment Method</h5>
                <form action="{{ route('orders.store') }}" method="POST">
                    @csrf
                    
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="payment_method" id="cash" value="cash" checked>
                        <label class="form-check-label" for="cash">
                            <i class="fas fa-money-bill"></i> Cash on Delivery
                        </label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="payment_method" id="gcash" value="gcash">
                        <label class="form-check-label" for="gcash">
                            <i class="fas fa-mobile-alt"></i> GCash
                        </label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="payment_method" id="card" value="card">
                        <label class="form-check-label" for="card">
                            <i class="fas fa-credit-card"></i> Credit/Debit Card
                        </label>
                    </div>

                    <hr>

                    <button type="submit" class="btn btn-primary w-100" style="background-color: #B57EDC; border-color: #B57EDC;">
                        <i class="fas fa-check"></i> Complete Order
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Order Summary</h5>
                <hr>
                <div class="d-flex justify-content-between mb-2">
                    <span>Subtotal:</span>
                    <span>₱{{ number_format($total, 2) }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>VAT (12%):</span>
                    <span>₱{{ number_format($total * 0.12, 2) }}</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <strong>Total Amount:</strong>
                    <strong>₱{{ number_format($total * 1.12, 2) }}</strong>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
