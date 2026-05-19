@extends('layouts.editor')

@section('title', 'Add New Product - Lavender Pharmacy')

@section('content')
<style>
    .dashboard-main { width: 100%; min-height: 100vh; background: #F7F3FC; }
    .dashboard-container { padding: 32px 40px; max-width: 1400px; margin: 0 auto; }
    @media (max-width: 768px) { .dashboard-container { padding: 24px 16px; } }

    /* ── Header ── */
    .dashboard-header {
        margin-bottom: 28px;
        background: linear-gradient(135deg, #5D3A66 0%, #8B4DAB 60%, #B57EDC 100%);
        padding: 28px 32px;
        border-radius: 14px;
        box-shadow: 0 4px 20px rgba(93, 58, 102, 0.25);
        color: white;
        position: relative;
        overflow: hidden;
    }
    .dashboard-header::before {
        content: '';
        position: absolute;
        top: -40px; right: -40px;
        width: 180px; height: 180px;
        border-radius: 50%;
        background: rgba(255,255,255,0.06);
        pointer-events: none;
    }
    .dashboard-header-inner {
        display: flex; align-items: center;
        justify-content: space-between;
        flex-wrap: wrap; gap: 16px;
    }
    .dashboard-header h1 { font-size: 1.9rem; font-weight: 700; margin-bottom: 6px; color: white; }
    .dashboard-header p { color: rgba(255,255,255,0.75); font-size: 0.9rem; margin: 0; }
    .dashboard-header i.header-icon { margin-right: 10px; opacity: 0.85; }

    /* ── Card shell ── */
    .card-modern {
        background: white; border: none; border-radius: 14px;
        box-shadow: 0 2px 12px rgba(93, 58, 102, 0.07); overflow: hidden;
    }
    .card-modern-body {
        padding: 28px 32px;
    }

    /* ── Form styling ── */
    .form-section { margin-bottom: 24px; }
    .form-section-title {
        font-size: 0.9rem; font-weight: 700; color: #5D3A66;
        text-transform: uppercase; letter-spacing: 0.8px;
        margin-bottom: 16px; padding-bottom: 12px; border-bottom: 2px solid #F0E8FA;
    }

    .form-group { margin-bottom: 18px; }
    .form-label {
        display: block; font-size: 0.875rem; font-weight: 600;
        color: #3D2549; margin-bottom: 8px;
    }
    .form-label .required { color: #DC2626; }

    .form-control {
        width: 100%; padding: 10px 14px; border: 1.5px solid #E0C8F5;
        border-radius: 9px; font-size: 0.875rem; color: #3D2549;
        background: white; transition: all 0.2s ease;
    }
    .form-control:focus {
        outline: none; border-color: #B57EDC;
        box-shadow: 0 0 0 3px rgba(181, 126, 220, 0.1);
    }
    .form-control::placeholder { color: #C0A8D8; }
    .form-control.is-invalid {
        border-color: #DC2626;
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
    }

    .invalid-feedback {
        display: block; font-size: 0.75rem; color: #DC2626; margin-top: 4px;
    }

    textarea.form-control { resize: vertical; min-height: 100px; }

    select.form-control {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath fill='%23B57EDC' d='M1 1l5 5 5-5'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        padding-right: 32px;
    }

    .form-check { display: flex; align-items: center; margin-bottom: 16px; }
    .form-check-input {
        width: 18px; height: 18px; border: 1.5px solid #E0C8F5;
        border-radius: 5px; cursor: pointer; margin-right: 10px;
        accent-color: #B57EDC;
    }
    .form-check-label {
        font-size: 0.875rem; color: #3D2549; cursor: pointer; margin: 0;
    }

    /* ── Button group ── */
    .button-group {
        display: flex; gap: 12px; margin-top: 32px;
    }

    .btn {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 11px 24px; border: none; border-radius: 9px;
        font-size: 0.875rem; font-weight: 700; text-decoration: none;
        cursor: pointer; transition: all 0.2s ease;
        white-space: nowrap;
    }

    .btn-primary {
        background: linear-gradient(135deg, #8B4DAB, #B57EDC);
        color: white; box-shadow: 0 3px 10px rgba(139,77,171,0.3);
    }
    .btn-primary:hover {
        transform: translateY(-1px); box-shadow: 0 5px 16px rgba(139,77,171,0.4);
        color: white; text-decoration: none;
    }

    .btn-secondary {
        background: #F0E8FA; color: #7A4F85;
        border: 1.5px solid #E0C8F5;
    }
    .btn-secondary:hover {
        background: #E8DDF0; color: #5D3A66; text-decoration: none;
    }

    .btn i { font-size: 0.9rem; }

    /* ── Form rows ── */
    .form-row { display: grid; grid-template-columns: 1fr; gap: 16px; }
    .form-row.cols-2 { grid-template-columns: repeat(2, 1fr); }
    @media (max-width: 768px) {
        .form-row.cols-2 { grid-template-columns: 1fr; }
    }

    /* ── Success/Error messages ── */
    .alert {
        padding: 14px 18px; border-radius: 9px; margin-bottom: 20px;
        font-size: 0.875rem; font-weight: 500;
    }
    .alert-success {
        background: #ECFDF5; color: #047857; border: 1.5px solid #A7F3D0;
    }
    .alert-danger {
        background: #FEF2F2; color: #991B1B; border: 1.5px solid #FECACA;
    }
</style>

<div class="dashboard-main">
    <div class="dashboard-container">

        <!-- Header -->
        <div class="dashboard-header">
            <div class="dashboard-header-inner">
                <div>
                    <h1><i class="fas fa-plus-circle header-icon"></i>Add New Product</h1>
                    <p>Create a new product in your pharmacy catalog</p>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="card-modern">
            <div class="card-modern-body">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong><i class="fas fa-exclamation-circle"></i> Please fix the errors below:</strong>
                    </div>
                @endif

                <form action="{{ route('editor.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Basic Information -->
                    <div class="form-section">
                        <div class="form-section-title">Basic Information</div>

                        <div class="form-group">
                            <label for="product_name" class="form-label">Product Name <span class="required">*</span></label>
                            <input type="text" class="form-control @error('product_name') is-invalid @enderror"
                                   id="product_name" name="product_name" value="{{ old('product_name') }}" required>
                            @error('product_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-row cols-2">
                            <div class="form-group">
                                <label for="generic_name" class="form-label">Generic Name</label>
                                <input type="text" class="form-control @error('generic_name') is-invalid @enderror"
                                       id="generic_name" name="generic_name" value="{{ old('generic_name') }}">
                                @error('generic_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="form-group">
                                <label for="brand_name" class="form-label">Brand Name</label>
                                <input type="text" class="form-control @error('brand_name') is-invalid @enderror"
                                       id="brand_name" name="brand_name" value="{{ old('brand_name') }}">
                                @error('brand_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="category_id" class="form-label">Category <span class="required">*</span></label>
                            <select class="form-control @error('category_id') is-invalid @enderror"
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
                    </div>

                    <!-- Description & Details -->
                    <div class="form-section">
                        <div class="form-section-title">Product Details</div>

                        <div class="form-group">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description" name="description">{{ old('description') }}</textarea>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label for="product_image" class="form-label">Product Image</label>
                            <input type="file" class="form-control @error('product_image') is-invalid @enderror"
                                   id="product_image" name="product_image" accept="image/*">
                            @error('product_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <small style="color: #6B7280; display: block; margin-top: 6px;">Supported formats: JPG, PNG, GIF, WebP (Max 5MB)</small>
                        </div>

                        <div class="form-row cols-2">
                            <div class="form-group">
                                <label for="dosage_info" class="form-label">Dosage Info</label>
                                <input type="text" class="form-control @error('dosage_info') is-invalid @enderror"
                                       id="dosage_info" name="dosage_info" placeholder="e.g., 500mg"
                                       value="{{ old('dosage_info') }}">
                                @error('dosage_info')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="form-group">
                                <label for="manufacturer" class="form-label">Manufacturer</label>
                                <input type="text" class="form-control @error('manufacturer') is-invalid @enderror"
                                       id="manufacturer" name="manufacturer" value="{{ old('manufacturer') }}">
                                @error('manufacturer')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="barcode" class="form-label">Barcode</label>
                            <input type="text" class="form-control @error('barcode') is-invalid @enderror"
                                   id="barcode" name="barcode" value="{{ old('barcode') }}">
                            @error('barcode')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <!-- Pricing & Stock -->
                    <div class="form-section">
                        <div class="form-section-title">Pricing & Inventory</div>

                        <div class="form-row cols-2">
                            <div class="form-group">
                                <label for="price" class="form-label">Price (₱) <span class="required">*</span></label>
                                <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror"
                                       id="price" name="price" value="{{ old('price') }}" required>
                                @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="form-group">
                                <label for="stock_quantity" class="form-label">Stock Quantity <span class="required">*</span></label>
                                <input type="number" class="form-control @error('stock_quantity') is-invalid @enderror"
                                       id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity') }}" required>
                                @error('stock_quantity')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="form-row cols-2">
                            <div class="form-group">
                                <label for="expiration_date" class="form-label">Expiration Date <span class="required">*</span></label>
                                <input type="date" class="form-control @error('expiration_date') is-invalid @enderror"
                                       id="expiration_date" name="expiration_date" value="{{ old('expiration_date') }}" required>
                                @error('expiration_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="form-group">
                                <label for="prescription_required" class="form-label">&nbsp;</label>
                                <div class="form-check" style="margin-bottom: 0;">
                                    <input class="form-check-input" type="checkbox" id="prescription_required"
                                           name="prescription_required" value="1" {{ old('prescription_required') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="prescription_required">
                                        Requires Prescription
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="button-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Add Product
                        </button>
                        <a href="{{ route('editor.products.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
