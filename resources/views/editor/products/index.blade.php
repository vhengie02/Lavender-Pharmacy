@extends('layouts.app')

@section('title', 'Products - Lavender Pharmacy')

@section('content')
<div class="row mb-4">
    <div class="col-md-6">
        <h1 style="color: #5D3A66;"><i class="fas fa-boxes"></i> Manage Products</h1>
    </div>
    <div class="col-md-6 text-end">
        <a href="{{ route('editor.products.create') }}" class="btn btn-primary" style="background-color: #B57EDC; border-color: #B57EDC;">
            <i class="fas fa-plus"></i> Add New Product
        </a>
    </div>
</div>

<!-- Search and Filter -->
<div class="row mb-4">
    <div class="col-md-12">
        <form action="{{ route('editor.products.index') }}" method="GET" class="row g-3">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Search by name, generic name, or barcode..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="category" class="form-select">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->category_id }}" {{ request('category') == $category->category_id ? 'selected' : '' }}>
                            {{ $category->category_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="stock" class="form-select">
                    <option value="">All Stock Levels</option>
                    <option value="low" {{ request('stock') === 'low' ? 'selected' : '' }}>Low Stock (< 10)</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100" style="background-color: #B57EDC; border-color: #B57EDC;">
                    <i class="fas fa-search"></i> Search
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Products Table -->
<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead style="background-color: #f8f9fa;">
                <tr>
                    <th>Product Name</th>
                    <th>Generic Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Expiration</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td>
                            <strong>{{ $product->product_name }}</strong>
                            @if($product->prescription_required)
                                <br><small class="badge bg-info">Rx Required</small>
                            @endif
                        </td>
                        <td>{{ $product->generic_name ?? '-' }}</td>
                        <td>{{ $product->category->category_name ?? 'N/A' }}</td>
                        <td>₱{{ number_format($product->price, 2) }}</td>
                        <td>
                            <span class="badge" style="background-color: @if($product->stock_quantity < 10) #dc3545 @else #28a745 @endif">
                                {{ $product->stock_quantity }} units
                            </span>
                        </td>
                        <td>
                            @if($product->expiration_date)
                                {{ $product->expiration_date->format('M d, Y') }}
                                @if($product->expiration_date->isPast())
                                    <br><small class="badge bg-danger">EXPIRED</small>
                                @elseif($product->expiration_date->diffInDays() < 90)
                                    <br><small class="badge bg-warning">Expiring Soon</small>
                                @endif
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('editor.products.edit', $product) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('editor.products.destroy', $product) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
                            <i class="fas fa-inbox fa-2x mb-2"></i><br>
                            No products found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Pagination -->
@if($products->hasPages())
    <nav aria-label="Page navigation" class="mt-4">
        {{ $products->links() }}
    </nav>
@endif
@endsection
