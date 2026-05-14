@extends('layouts.app')

@section('title', 'Shopping Cart - Lavender Pharmacy')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <h1 style="color: #5D3A66;"><i class="fas fa-shopping-cart"></i> Shopping Cart</h1>
    </div>
</div>

@if($cartItems->isEmpty())
    <div class="alert alert-info" role="alert">
        Your cart is empty. <a href="{{ route('customer.shop') }}">Continue shopping</a>
    </div>
@else
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cartItems as $item)
                                <tr>
                                    <td>
                                        {{ $item->product->product_name }}<br>
                                        <small class="text-muted">{{ $item->product->category->category_name ?? 'N/A' }}</small>
                                    </td>
                                    <td>₱{{ number_format($item->product->price, 2) }}</td>
                                    <td>
                                        <form action="{{ route('cart.update', $item->cart_id) }}" method="POST" class="d-flex">
                                            @csrf
                                            @method('PUT')
                                            <input type="number" name="quantity" class="form-control form-control-sm" value="{{ $item->quantity }}" min="1" style="width: 60px;">
                                            <button type="submit" class="btn btn-sm btn-outline-primary ms-1">Update</button>
                                        </form>
                                    </td>
                                    <td>₱{{ number_format($item->product->price * $item->quantity, 2) }}</td>
                                    <td>
                                        <form action="{{ route('cart.remove', $item->cart_id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
                        <span>₱{{ number_format($cartItems->sum(fn($item) => $item->product->price * $item->quantity), 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>VAT (12%):</span>
                        <span>₱{{ number_format($cartItems->sum(fn($item) => $item->product->price * $item->quantity) * 0.12, 2) }}</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-3">
                        <strong>Total:</strong>
                        <strong>₱{{ number_format($cartItems->sum(fn($item) => $item->product->price * $item->quantity) * 1.12, 2) }}</strong>
                    </div>
                    <a href="{{ route('orders.checkout') }}" class="btn btn-primary w-100" style="background-color: #B57EDC; border-color: #B57EDC;">
                        Proceed to Checkout
                    </a>
                </div>
            </div>
        </div>
    </div>
@endif
@endsection
