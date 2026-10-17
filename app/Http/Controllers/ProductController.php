<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')
            ->latest()
            ->get();

        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::where('status', true)
            ->orderBy('name')
            ->get();

        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'required|boolean',
        ]);

        $imageName = null;

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();

            $request->image->move(
                public_path('product-images'),
                $imageName
            );
        }

        $validated['image'] = $imageName;

        $product=Product::create($validated);

        return response()->json([
            'success' => true,
            'message'=> 'Product created successfully!',
            'product' => $product
        ]);  
    }

    public function show(Product $product)
    {
        $product->load('category');

        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::where('status', true)
            ->orderBy('name')
            ->get();

        return view('products.edit', compact(
            'product',
            'categories'
        ));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'required|boolean',
        ]);

        if ($request->hasFile('image')) {

            if (
                $product->image &&
                file_exists(public_path('product-images/' . $product->image))
            ) {
                unlink(public_path('product-images/' . $product->image));
            }

            $imageName = time() . '.' . $request->image->extension();

            $request->image->move(
                public_path('products-images'),
                $imageName
            );

            $validated['image'] = $imageName;
        } else {
            $validated['image'] = $product->image;
        }

        $product->update($validated);

        return response()->json([
            'success' => true,
            'message'=> 'Product Update successfully!',
            'product' => $product
        ]);
    }

    public function destroy(Product $product)
    {
        if (
            $product->image &&
            file_exists(public_path('products-images/' . $product->image))
        ) {
            unlink(public_path('products/' . $product->image));
        }

        $product->delete();
        return response()->json([
                'success' => true,
                'message' => 'Product deleted successfully.'
        ]);
        
    }
}