@extends('layouts.app')

@section('title', 'Add New Product - Lavender Pharmacy')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <h1 style="color: #5D3A66;"><i class="fas fa-plus-circle"></i> Add New Product</h1>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('editor.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Product Name -->
                    <div class="mb-3">
                        <label for="product_name" class="form-label">Product Name *</label>
                        <input type="text" class="form-control @error('product_name') is-invalid @enderror" 
                               id="product_name" name="product_name" value="{{ old('product_name') }}" required>
                        @error('product_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <!-- Generic Name -->
                    <div class="mb-3">
                        <label for="generic_name" class="form-label">Generic Name</label>
                        <input type="text" class="form-control @error('generic_name') is-invalid @enderror" 
                               id="generic_name" name="generic_name" value="{{ old('generic_name') }}">
                        @error('generic_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <!-- Brand Name -->
                    <div class="mb-3">
                        <label for="brand_name" class="form-label">Brand Name</label>
                        <input type="text" class="form-control @error('brand_name') is-invalid @enderror" 
                               id="brand_name" name="brand_name" value="{{ old('brand_name') }}">
                        @error('brand_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <!-- Category -->
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Category *</label>
                        <select class="form-select @error('category_id') is-invalid @enderror" 
                                id="category_id" name="category_id" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->category_id }}" {{ old('category_id') == $category->category_id ? 'selected' : '' }}>
                                    {{ $category->category_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="3">{{ old('description') }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <!-- Dosage Info -->
                    <div class="mb-3">
                        <label for="dosage_info" class="form-label">Dosage Info</label>
                        <input type="text" class="form-control @error('dosage_info') is-invalid @enderror" 
                               id="dosage_info" name="dosage_info" placeholder="e.g., 500mg" value="{{ old('dosage_info') }}">
                        @error('dosage_info')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row">
                        <!-- Price -->
                        <div class="col-md-6 mb-3">
                            <label for="price" class="form-label">Price *</label>
                            <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" 
                                   id="price" name="price" value="{{ old('price') }}" required>
                            @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <!-- Stock Quantity -->
                        <div class="col-md-6 mb-3">
                            <label for="stock_quantity" class="form-label">Stock Quantity *</label>
                            <input type="number" class="form-control @error('stock_quantity') is-invalid @enderror" 
                                   id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity') }}" required>
                            @error('stock_quantity')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row">
                        <!-- Expiration Date -->
                        <div class="col-md-6 mb-3">
                            <label for="expiration_date" class="form-label">Expiration Date *</label>
                            <input type="date" class="form-control @error('expiration_date') is-invalid @enderror" 
                                   id="expiration_date" name="expiration_date" value="{{ old('expiration_date') }}" required>
                            @error('expiration_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <!-- Manufacturer -->
                        <div class="col-md-6 mb-3">
                            <label for="manufacturer" class="form-label">Manufacturer</label>
                            <input type="text" class="form-control @error('manufacturer') is-invalid @enderror" 
                                   id="manufacturer" name="manufacturer" value="{{ old('manufacturer') }}">
                            @error('manufacturer')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <!-- Barcode -->
                    <div class="mb-3">
                        <label for="barcode" class="form-label">Barcode</label>
                        <input type="text" class="form-control @error('barcode') is-invalid @enderror" 
                               id="barcode" name="barcode" value="{{ old('barcode') }}">
                        @error('barcode')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <!-- Prescription Required -->
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="prescription_required" 
                                   name="prescription_required" value="1" {{ old('prescription_required') ? 'checked' : '' }}>
                            <label class="form-check-label" for="prescription_required">
                                Requires Prescription
                            </label>
                        </div>
                    </div>

                    <!-- Product Image -->
                    <div class="mb-3">
                        <label for="product_image" class="form-label">Product Image</label>
                        <input type="file" class="form-control @error('product_image') is-invalid @enderror" 
                               id="product_image" name="product_image" accept="image/*">
                        <small class="text-muted">Max size: 2MB. Accepted formats: JPEG, PNG, JPG, GIF</small>
                        @error('product_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary" style="background-color: #B57EDC; border-color: #B57EDC;">
                            <i class="fas fa-save"></i> Add Product
                        </button>
                        <a href="{{ route('editor.products.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Instructions Sidebar -->
    <div class="col-md-4">
        <div class="card shadow-sm bg-light">
            <div class="card-body">
                <h5 style="color: #B57EDC;">📝 Instructions</h5>
                <ul class="small">
                    <li>All fields marked with * are required</li>
                    <li>Price should be in PHP currency</li>
                    <li>Stock quantity must be 0 or more</li>
                    <li>Expiration date must be in the future</li>
                    <li>Barcode must be unique</li>
                    <li>Product image is optional</li>
                    <li>Check "Requires Prescription" for controlled medications</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
