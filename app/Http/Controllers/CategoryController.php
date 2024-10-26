<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    // Display a listing of the categories
    public function index()
    {
        $categories = Category::all();
        return response()->json($categories);
    }

    // Store a newly created category in storage
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'thumbnail_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->description = $request->description;

        if ($request->hasFile('thumbnail_image')) {
            $path = $request->file('thumbnail_image')->store('thumbnails', 'public');
            $category->thumbnail_image = $path;
        }

        $category->save();
        return response()->json($category, 201);
    }

    // Display the specified category
    public function show($id)
    {
        $category = Category::findOrFail($id);
        return response()->json($category);
    }

    // Update the specified category in storage
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'thumbnail_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->description = $request->description;

        if ($request->hasFile('thumbnail_image')) {
            // Delete old image if it exists
            if ($category->thumbnail_image) {
                Storage::disk('public')->delete($category->thumbnail_image);
            }
            $path = $request->file('thumbnail_image')->store('thumbnails', 'public');
            $category->thumbnail_image = $path;
        }

        $category->save();
        return response()->json($category);
    }

    // Remove the specified category from storage
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        
        // Delete the image if it exists
        if ($category->thumbnail_image) {
            Storage::disk('public')->delete($category->thumbnail_image);
        }

        $category->delete();
        return response()->json(null, 204);
    }
}
