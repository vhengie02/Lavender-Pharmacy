@extends('layouts.app')

@section('title', 'Shop - Lavender Pharmacy')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <h1 style="color: #5D3A66;"><i class="fas fa-shopping-bag"></i> Product Shop</h1>
    </div>
</div>

<!-- Search and Filter -->
<div class="row mb-4">
    <div class="col-md-4">
        <form action="{{ route('customer.shop') }}" method="GET" class="d-flex">
            <input type="text" name="search" class="form-control" placeholder="Search products..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary ms-2" style="background-color: #B57EDC; border-color: #B57EDC;">
                <i class="fas fa-search"></i> Search
            </button>
        </form>
    </div>
    <div class="col-md-4">
        <form action="{{ route('customer.shop') }}" method="GET">
            <select name="category" class="form-select" onchange="this.form.submit()">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->category_id }}" {{ request('category') == $category->category_id ? 'selected' : '' }}>
                        {{ $category->category_name }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>
</div>

<!-- Products Grid -->
<div class="row">
    @forelse($products as $product)
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                @if($product->product_image)
                    <img src="{{ asset('uploads/' . $product->product_image) }}" class="card-img-top" alt="{{ $product->product_name }}" style="height: 200px; object-fit: cover;">
                @else
                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                        <i class="fas fa-image fa-3x text-muted"></i>
                    </div>
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $product->product_name }}</h5>
                    <p class="card-text text-muted small">{{ $product->category->category_name ?? 'N/A' }}</p>
                    <p class="card-text small">{{ Str::limit($product->description, 100) }}</p>
                    
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <span class="h5 mb-0" style="color: #B57EDC;">₱{{ number_format($product->price, 2) }}</span>
                        <span class="badge bg-info">{{ $product->stock_quantity }} in stock</span>
                    </div>
                </div>
                <div class="card-footer">
                    @if($product->stock_quantity > 0)
                        <form action="{{ route('cart.add') }}" method="POST" class="d-flex">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                            <input type="number" name="quantity" class="form-control form-control-sm me-2" value="1" min="1" max="{{ $product->stock_quantity }}">
                            <button type="submit" class="btn btn-sm btn-primary" style="background-color: #B57EDC; border-color: #B57EDC;">
                                <i class="fas fa-cart-plus"></i>
                            </button>
                        </form>
                    @else
                        <button class="btn btn-sm btn-secondary w-100" disabled>Out of Stock</button>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="col-md-12 text-center py-5">
            <i class="fas fa-search fa-3x text-muted mb-3"></i>
            <p class="text-muted">No products found</p>
        </div>
    @endforelse
</div>

<!-- Pagination -->
@if($products->hasPages())
    <nav aria-label="Page navigation">
        {{ $products->links() }}
    </nav>
@endif
@endsection
