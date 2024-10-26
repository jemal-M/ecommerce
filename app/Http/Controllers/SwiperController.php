<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Swiper;
use Illuminate\Support\Facades\Validator;

class SwiperController extends Controller
{
    // List all swipers
    public function index()
    {
        return response()->json(Swiper::all(), 200);
    }

    // Store a new swiper
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'file_path' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $swiper = Swiper::create($request->all());

        return response()->json($swiper, 201);
    }

    // Show a specific swiper
    public function show($id)
    {
        $swiper = Swiper::find($id);
        
        if (!$swiper) {
            return response()->json(['message' => 'Swiper not found'], 404);
        }

        return response()->json($swiper, 200);
    }

    // Update a specific swiper
    public function update(Request $request, $id)
    {
        $swiper = Swiper::find($id);

        if (!$swiper) {
            return response()->json(['message' => 'Swiper not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'file_path' => 'sometimes|required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $swiper->update($request->all());

        return response()->json($swiper, 200);
    }

    // Delete a specific swiper
    public function destroy($id)
    {
        $swiper = Swiper::find($id);

        if (!$swiper) {
            return response()->json(['message' => 'Swiper not found'], 404);
        }

        $swiper->delete();

        return response()->json(['message' => 'Swiper deleted successfully'], 200);
    }
}
