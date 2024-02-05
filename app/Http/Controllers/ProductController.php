<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('categories');

        // Filter by category if category_id is provided
        if ($request->has('category_id')) {
            $query->whereHas('categories', function ($query) use ($request) {
                $query->where('id', $request->category_id);
            });
        }

        // Sort by price
        if ($request->has('sort_by_price')) {
            $query->orderBy('price', $request->sort_by_price);
        }

        $products = $query->get();

        return response()->json($products);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id'
        ]);

        $product = new Product($request->only(['name', 'description', 'price']));
        
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('product_images', 'public');
            $product->image = $imagePath;
        }

        $product->save();

        $product->categories()->sync($request->categories);

        return response()->json($product, 201);
    }
}
