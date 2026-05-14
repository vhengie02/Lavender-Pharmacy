@extends('layouts.app')

@section('title', 'Editor Dashboard - Lavender Pharmacy')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <h1 style="color: #5D3A66;"><i class="fas fa-edit"></i> Editor Dashboard</h1>
        <p class="text-muted">Welcome, {{ auth()->user()->name }}! Manage your pharmacy products here.</p>
    </div>
</div>

<!-- Key Metrics -->
<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="card shadow-sm border-0" style="border-top: 4px solid #B57EDC;">
            <div class="card-body">
                <h6 class="card-title text-muted">Total Products</h6>
                <h3 style="color: #B57EDC;">{{ $totalProducts }}</h3>
                <small class="text-muted">In inventory</small>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card shadow-sm border-0" style="border-top: 4px solid #dc3545;">
            <div class="card-body">
                <h6 class="card-title text-muted">Low Stock Products</h6>
                <h3 style="color: #dc3545;">{{ $lowStockProducts }}</h3>
                <small class="text-muted">Less than 10 units</small>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card shadow-sm border-0" style="border-top: 4px solid #5D3A66;">
            <div class="card-body">
                <h6 class="card-title text-muted">Recent Products</h6>
                <h3 style="color: #5D3A66;">{{ $recentProducts->count() }}</h3>
                <small class="text-muted">Updated recently</small>
            </div>
        </div>
    </div>
</div>

<!-- Recent Products -->
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-header" style="background-color: #B57EDC; color: white;">
                <h5 class="mb-0"><i class="fas fa-boxes"></i> Recently Updated Products</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead style="background-color: #f8f9fa;">
                        <tr>
                            <th>Product Name</th>
                            <th>Generic Name</th>
                            <th>Category</th>
                            <th>Stock</th>
                            <th>Price</th>
                            <th>Updated</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentProducts as $product)
                            <tr>
                                <td><strong>{{ $product->product_name }}</strong></td>
                                <td>{{ $product->generic_name ?? '-' }}</td>
                                <td>{{ $product->category->category_name ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge" style="background-color: @if($product->stock_quantity < 10) #dc3545 @else #28a745 @endif">
                                        {{ $product->stock_quantity }}
                                    </span>
                                </td>
                                <td>₱{{ number_format($product->price, 2) }}</td>
                                <td><small class="text-muted">{{ $product->date_updated->format('M d, Y') }}</small></td>
                                <td>
                                    <a href="{{ route('editor.products.edit', $product) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">No products yet</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer text-center">
                <a href="{{ route('editor.products.index') }}" class="btn btn-sm btn-outline-primary">View All Products</a>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-header" style="background-color: #5D3A66; color: white;">
                <h5 class="mb-0"><i class="fas fa-cogs"></i> Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('editor.products.create') }}" class="btn btn-primary w-100" style="background-color: #B57EDC; border-color: #B57EDC;">
                            <i class="fas fa-plus"></i> Add New Product
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('editor.products.index', ['stock' => 'low']) }}" class="btn btn-warning w-100">
                            <i class="fas fa-exclamation-triangle"></i> View Low Stock
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('profile.show') }}" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-user"></i> My Profile
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger w-100">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
