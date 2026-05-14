<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display shop with products
     */
    public function shop(Request $request)
    {
        $query = Product::with('category');

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        // Search by name or generic name
        if ($request->has('search') && $request->search) {
            $search = '%' . $request->search . '%';
            $query->where(function ($q) use ($search) {
                $q->where('product_name', 'like', $search)
                  ->orWhere('generic_name', 'like', $search);
            });
        }

        $products = $query->paginate(12);
        $categories = Category::all();

        return view('customer.shop', ['products' => $products, 'categories' => $categories]);
    }

    /**
     * Show product details
     */
    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);
        return view('customer.product-detail', ['product' => $product]);
    }
}
