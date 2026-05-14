<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class EditorController extends Controller
{
    /**
     * Show editor dashboard
     */
    public function dashboard()
    {
        $totalProducts = Product::count();
        $lowStockProducts = Product::where('stock_quantity', '<', 10)->count();
        $recentProducts = Product::latest('date_updated')->take(5)->get();

        return view('editor.dashboard', [
            'totalProducts' => $totalProducts,
            'lowStockProducts' => $lowStockProducts,
            'recentProducts' => $recentProducts,
        ]);
    }

    /**
     * Display list of products
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

        $products = $query->paginate(15);
        $categories = Category::all();

        return view('editor.products.index', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }

    /**
     * Show create product form
     */
    public function create()
    {
        $categories = Category::all();
        return view('editor.products.create', ['categories' => $categories]);
    }

    /**
     * Store a new product
     */
    public function store(Request $request)
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
            'expiration_date' => 'required|date|after:today',
            'manufacturer' => 'nullable|string|max:255',
            'barcode' => 'nullable|string|unique:products',
            'prescription_required' => 'boolean',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('product_image')) {
            $file = $request->file('product_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $filename);
            $validated['product_image'] = $filename;
        }

        $validated['date_added'] = now();
        $validated['date_updated'] = now();

        Product::create($validated);

        return redirect()->route('editor.products.index')->with('success', 'Product created successfully');
    }

    /**
     * Show edit product form
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('editor.products.edit', [
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
            'expiration_date' => 'required|date|after:today',
            'manufacturer' => 'nullable|string|max:255',
            'barcode' => 'nullable|string|unique:products,barcode,' . $product->product_id . ',product_id',
            'prescription_required' => 'boolean',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('product_image')) {
            // Delete old image
            if ($product->product_image && file_exists(public_path('uploads/' . $product->product_image))) {
                unlink(public_path('uploads/' . $product->product_image));
            }

            $file = $request->file('product_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $filename);
            $validated['product_image'] = $filename;
        }

        $validated['date_updated'] = now();

        $product->update($validated);

        return redirect()->route('editor.products.index')->with('success', 'Product updated successfully');
    }

    /**
     * Delete a product
     */
    public function destroy(Product $product)
    {
        // Delete image
        if ($product->product_image && file_exists(public_path('uploads/' . $product->product_image))) {
            unlink(public_path('uploads/' . $product->product_image));
        }

        $product->delete();

        return redirect()->route('editor.products.index')->with('success', 'Product deleted successfully');
    }
}
