<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->get();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'status' => 'required|boolean',
        ]);

       $categories = Category::create($validate);

        return response()->json([
            'success' => true,
            'message'=> 'Category created successfully!',
            'category' => $categories
        ]);    
    }

    public function show(Category $category)
    {
        return view('categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validate = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'status' => 'boolean',
        ]);

        $category->update($validate);
        return response()->json([
            'success' => true,
            'message'=> 'Category Update successfully!',
            'category' => $category
        ]);
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json([
                'success' => true,
                'message' => 'Category deleted successfully.'
        ]);
        
    }
}