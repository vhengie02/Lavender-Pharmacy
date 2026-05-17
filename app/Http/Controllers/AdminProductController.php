<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    /**
     * Display list of all products
     */
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Search
        if ($request->has('search') && $request->search) {
            $search = '%' . $request->search . '%';
            $query->where(function ($q) use ($search) {
                $q->where('product_name', 'like', $search)
                  ->orWhere('generic_name', 'like', $search)
                  ->orWhere('barcode', 'like', $search);
            });
        }

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        // Filter by stock status
        if ($request->has('stock') && $request->stock === 'low') {
            $query->where('stock_quantity', '<', 10);
        }

        // Filter by expiration status
        if ($request->has('expiration') && $request->expiration === 'expired') {
            $query->whereDate('expiration_date', '<', now());
        } elseif ($request->has('expiration') && $request->expiration === 'expiring') {
            $query->whereDate('expiration_date', '>', now())
                  ->whereDate('expiration_date', '<=', now()->addDays(90));
        }

        $products = $query->paginate(15);
        $categories = Category::all();

        return view('admin.products.index', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }

    /**
     * Show product details
     */
    public function show(Product $product)
    {
        $product->load('category', 'inventoryLogs');
        return view('admin.products.show', ['product' => $product]);
    }

    /**
     * Show edit product form
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', [
            'product' => $product,
            'categories' => $categories,
        ]);
    }

    /**
     * Update a product
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'generic_name' => 'nullable|string|max:255',
            'brand_name' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,category_id',
            'description' => 'nullable|string',
            'dosage_info' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0.01',
            'stock_quantity' => 'required|integer|min:0',
            'expiration_date' => 'required|date',
            'manufacturer' => 'nullable|string|max:255',
            'barcode' => 'nullable|string|unique:products,barcode,' . $product->product_id . ',product_id',
            'prescription_required' => 'boolean',
        ]);

        $validated['date_updated'] = now();

        $product->update($validated);

        return redirect()->route('admin.products.show', $product)->with('success', 'Product updated successfully');
    }

    /**
     * Delete a product
     */
    public function destroy(Product $product)
    {
        // Delete image if exists
        if ($product->product_image && file_exists(public_path('uploads/' . $product->product_image))) {
            unlink(public_path('uploads/' . $product->product_image));
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully');
    }
}
