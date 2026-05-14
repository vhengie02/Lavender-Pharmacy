@extends('layouts.admin')

@section('title', 'Edit ' . $product->product_name)

@section('content')
    <header class="mb-8 border-b border-border pb-4">
        <h1 class="font-serif text-2xl font-bold text-foreground">Edit product</h1>
        <p class="mt-1 text-sm text-muted-foreground">{{ $product->product_name }}</p>
    </header>

    <form action="{{ route('admin.products.update', $product) }}" method="POST" class="max-w-2xl space-y-4 rounded-xl border border-border bg-card p-6 shadow-sm">
        @csrf
        @method('PUT')
        <div>
            <label class="mb-1 block text-sm font-medium">Product name *</label>
            <input type="text" name="product_name" value="{{ old('product_name', $product->product_name) }}" required class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm" />
            @error('product_name')<p class="mt-1 text-sm text-destructive">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="mb-1 block text-sm font-medium">Generic name</label>
            <input type="text" name="generic_name" value="{{ old('generic_name', $product->generic_name) }}" class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm" />
        </div>
        <div>
            <label class="mb-1 block text-sm font-medium">Brand name</label>
            <input type="text" name="brand_name" value="{{ old('brand_name', $product->brand_name) }}" class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm" />
        </div>
        <div>
            <label class="mb-1 block text-sm font-medium">Category *</label>
            <select name="category_id" required class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm">
                @foreach ($categories as $category)
                    <option value="{{ $category->category_id }}" @selected(old('category_id', $product->category_id) == $category->category_id)>{{ $category->category_name }}</option>
                @endforeach
            </select>
            @error('category_id')<p class="mt-1 text-sm text-destructive">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="mb-1 block text-sm font-medium">Description</label>
            <textarea name="description" rows="3" class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm">{{ old('description', $product->description) }}</textarea>
        </div>
        <div>
            <label class="mb-1 block text-sm font-medium">Dosage info</label>
            <input type="text" name="dosage_info" value="{{ old('dosage_info', $product->dosage_info) }}" class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm" />
        </div>
        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label class="mb-1 block text-sm font-medium">Price *</label>
                <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" required class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm" />
                @error('price')<p class="mt-1 text-sm text-destructive">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="mb-1 block text-sm font-medium">Stock *</label>
                <input type="number" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}" required class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm" />
                @error('stock_quantity')<p class="mt-1 text-sm text-destructive">{{ $message }}</p>@enderror
            </div>
        </div>
        <div>
            <label class="mb-1 block text-sm font-medium">Expiration date *</label>
            <input type="date" name="expiration_date" value="{{ old('expiration_date', $product->expiration_date?->format('Y-m-d')) }}" required class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm" />
            @error('expiration_date')<p class="mt-1 text-sm text-destructive">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="mb-1 block text-sm font-medium">Manufacturer</label>
            <input type="text" name="manufacturer" value="{{ old('manufacturer', $product->manufacturer) }}" class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm" />
        </div>
        <div>
            <label class="mb-1 block text-sm font-medium">Barcode</label>
            <input type="text" name="barcode" value="{{ old('barcode', $product->barcode) }}" class="w-full rounded-lg border border-input bg-background px-3 py-2 text-sm" />
            @error('barcode')<p class="mt-1 text-sm text-destructive">{{ $message }}</p>@enderror
        </div>
        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="prescription_required" value="1" @checked(old('prescription_required', $product->prescription_required)) />
            Prescription required
        </label>
        <div class="flex gap-3 pt-4">
            <button type="submit" class="rounded-lg bg-primary px-5 py-2.5 text-sm font-medium text-primary-foreground hover:bg-primary/90">Save changes</button>
            <a href="{{ route('admin.products.show', $product) }}" class="rounded-lg border border-border px-5 py-2.5 text-sm hover:bg-secondary">Cancel</a>
        </div>
    </form>
@endsection
