<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Display a listing of the products
    public function index()
    {
        $products = Product::with('category')->get(); // eager loading category
        return response()->json($products);
    }

    // Store a newly created product in storage
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'price' => 'required|numeric',
            'discount_percent' => 'nullable|integer',
            'description' => 'required|string|max:255',
            'detail' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'image_1' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'stock' => 'nullable|integer',
            'featured' => 'nullable|boolean',
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->discount_percent = $request->discount_percent;
        $product->description = $request->description;
        $product->detail = $request->detail;
        $product->category_id = $request->category_id;
        $product->stock = $request->stock;
        $product->featured = $request->featured;

        if ($request->hasFile('image_1')) {
            $path = $request->file('image_1')->store('products/images', 'public');
            $product->image_1 = $path;
        }

        if ($request->hasFile('image_2')) {
            $path = $request->file('image_2')->store('products/images', 'public');
            $product->image_2 = $path;
        }

        $product->save();
        return response()->json($product, 201);
    }

    // Display the specified product
    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);
        return response()->json($product);
    }

    // Update the specified product in storage
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'price' => 'required|numeric',
            'discount_percent' => 'nullable|integer',
            'description' => 'required|string|max:255',
            'detail' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'image_1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'stock' => 'nullable|integer',
            'featured' => 'nullable|boolean',
        ]);

        $product = Product::findOrFail($id);
        $product->name = $request->name;
        $product->price = $request->price;
        $product->discount_percent = $request->discount_percent;
        $product->description = $request->description;
        $product->detail = $request->detail;
        $product->category_id = $request->category_id;
        $product->stock = $request->stock;
        $product->featured = $request->featured;

        if ($request->hasFile('image_1')) {
            // Delete old image if it exists
            if ($product->image_1) {
                Storage::disk('public')->delete($product->image_1);
            }
            $path = $request->file('image_1')->store('products/images', 'public');
            $product->image_1 = $path;
        }

        if ($request->hasFile('image_2')) {
            // Delete old image if it exists
            if ($product->image_2) {
                Storage::disk('public')->delete($product->image_2);
            }
            $path = $request->file('image_2')->store('products/images', 'public');
            $product->image_2 = $path;
        }

        $product->save();
        return response()->json($product);
    }

    // Remove the specified product from storage
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        
        // Delete images if they exist
        if ($product->image_1) {
            Storage::disk('public')->delete($product->image_1);
        }
        if ($product->image_2) {
            Storage::disk('public')->delete($product->image_2);
        }

        $product->delete();
        return response()->json(null, 204);
    }
}
