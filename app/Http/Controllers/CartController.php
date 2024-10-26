<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    // List all cart items
    public function index()
    {
        return response()->json(Cart::all(), 200);
    }

    // Add a new item to the cart
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $cart = Cart::create($request->all());

        return response()->json($cart, 201);
    }

    // Show a specific cart item
    public function show($id)
    {
        $cart = Cart::find($id);

        if (!$cart) {
            return response()->json(['message' => 'Cart item not found'], 404);
        }

        return response()->json($cart, 200);
    }

    // Update the quantity of a specific cart item
    public function update(Request $request, $id)
    {
        $cart = Cart::find($id);

        if (!$cart) {
            return response()->json(['message' => 'Cart item not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $cart->update($request->only('quantity'));

        return response()->json($cart, 200);
    }

    // Remove a specific item from the cart
    public function destroy($id)
    {
        $cart = Cart::find($id);

        if (!$cart) {
            return response()->json(['message' => 'Cart item not found'], 404);
        }

        $cart->delete();

        return response()->json(['message' => 'Cart item removed successfully'], 200);
    }
}
