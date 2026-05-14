@extends('layouts.app')

@section('title', $product->product_name . ' - Lavender Pharmacy')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('customer.shop') }}">Shop</a></li>
                <li class="breadcrumb-item active">{{ $product->product_name }}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row">
    <!-- Product Image -->
    <div class="col-md-5">
        <div class="card shadow-sm">
            @if($product->product_image)
                <img src="{{ asset('uploads/' . $product->product_image) }}" class="card-img-top" alt="{{ $product->product_name }}" style="height: 400px; object-fit: cover;">
            @else
                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 400px;">
                    <i class="fas fa-image fa-5x text-muted"></i>
                </div>
            @endif
        </div>
    </div>

    <!-- Product Details -->
    <div class="col-md-7">
        <div class="card shadow-sm">
            <div class="card-body">
                <!-- Product Name -->
                <h1 style="color: #5D3A66;">{{ $product->product_name }}</h1>

                <!-- Category -->
                @if($product->category)
                    <p class="text-muted mb-3">
                        <strong>Category:</strong> {{ $product->category->category_name }}
                    </p>
                @endif

                <!-- Generic Name -->
                @if($product->generic_name)
                    <p class="text-muted mb-3">
                        <strong>Generic Name:</strong> {{ $product->generic_name }}
                    </p>
                @endif

                <!-- Brand Name -->
                @if($product->brand_name)
                    <p class="text-muted mb-3">
                        <strong>Brand:</strong> {{ $product->brand_name }}
                    </p>
                @endif

                <!-- Price -->
                <h2 style="color: #B57EDC;" class="mb-3">₱{{ number_format($product->price, 2) }}</h2>

                <!-- Stock Status -->
                <p class="mb-3">
                    @if($product->stock_quantity > 0)
                        <span class="badge bg-success">{{ $product->stock_quantity }} in stock</span>
                    @else
                        <span class="badge bg-danger">Out of Stock</span>
                    @endif
                </p>

                <!-- Prescription Required -->
                @if($product->prescription_required)
                    <p class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i> This product requires a prescription
                    </p>
                @endif

                <!-- Dosage Info -->
                @if($product->dosage_info)
                    <p class="mb-3">
                        <strong>Dosage:</strong> {{ $product->dosage_info }}
                    </p>
                @endif

                <!-- Manufacturer -->
                @if($product->manufacturer)
                    <p class="mb-3">
                        <strong>Manufacturer:</strong> {{ $product->manufacturer }}
                    </p>
                @endif

                <!-- Expiration Date -->
                @if($product->expiration_date)
                    <p class="mb-3">
                        <strong>Expiration Date:</strong> {{ $product->expiration_date->format('F d, Y') }}
                    </p>
                @endif

                <!-- Barcode -->
                @if($product->barcode)
                    <p class="mb-3">
                        <strong>Barcode:</strong> {{ $product->barcode }}
                    </p>
                @endif

                <!-- Description -->
                @if($product->description)
                    <div class="mb-4">
                        <h5>Description</h5>
                        <p>{{ $product->description }}</p>
                    </div>
                @endif

                <!-- Add to Cart Form -->
                @if($product->stock_quantity > 0)
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <label for="quantity" class="form-label">Quantity</label>
                                <input type="number" id="quantity" name="quantity" class="form-control" value="1" min="1" max="{{ $product->stock_quantity }}" required>
                            </div>
                        </div>
                        <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                        <button type="submit" class="btn btn-lg mt-3" style="background-color: #B57EDC; border-color: #B57EDC; color: white;">
                            <i class="fas fa-cart-plus"></i> Add to Cart
                        </button>
                    </form>
                @else
                    <button class="btn btn-lg btn-secondary" disabled>
                        <i class="fas fa-ban"></i> Out of Stock
                    </button>
                @endif

                <!-- Back Button -->
                <a href="{{ route('customer.shop') }}" class="btn btn-outline-secondary mt-3">
                    <i class="fas fa-arrow-left"></i> Back to Shop
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
