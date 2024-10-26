<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Ensure you have this import for the User model

class AuthController extends Controller
{
    /**
     * Login user and generate an authentication token.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        // Validate input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Attempt to authenticate the user
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials'
            ], 401);
        }

        // Generate a token with a 2-day expiration
        $user = Auth::user();
        $token = $user->createToken('token', ['*'], Carbon::now()->addDays(2))->plainTextToken;

        // Return the token and user data in the response
        return response()->json([
            'success' => true,
            'token' => $token,
            'token_expiration' => Carbon::now()->addDays(2)->toDateTimeString(),
            'user' => $user
        ], 200);
    }

    /**
     * Register a new user.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'fullname' => 'required|string|max:255',
            'default_shipping_address' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8', // Ensure password confirmation
        ]);

        // Create the user
        $user = User::create([
            'fullname' => $validatedData['fullname'],
            'default_shipping_address' => $validatedData['default_shipping_address'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'password' => Hash::make($validatedData['password']), // Hash the password
        ]);

        // Optionally log the user in after registration (if desired)
        // Auth::login($user);

        return response()->json([
            'success' => true,
            'message' => 'User registered successfully',
            'user' => $user,
        ], 201);
    }

    /**
     * Logout the authenticated user.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        // Revoke the token that was used to authenticate the current request
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Successfully logged out'
        ], 200);
    }
}
