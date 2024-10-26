<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Validator;

class WishlistController extends Controller
{
    // List all wishlist items
    public function index()
    {
        return response()->json(Wishlist::all(), 200);
    }

    // Add a new item to the wishlist
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'product_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $wishlist = Wishlist::create($request->all());

        return response()->json($wishlist, 201);
    }

    // Show a specific wishlist item
    public function show($id)
    {
        $wishlist = Wishlist::find($id);
        
        if (!$wishlist) {
            return response()->json(['message' => 'Wishlist item not found'], 404);
        }

        return response()->json($wishlist, 200);
    }

    // Remove a specific item from the wishlist
    public function destroy($id)
    {
        $wishlist = Wishlist::find($id);

        if (!$wishlist) {
            return response()->json(['message' => 'Wishlist item not found'], 404);
        }

        $wishlist->delete();

        return response()->json(['message' => 'Wishlist item removed successfully'], 200);
    }
}
