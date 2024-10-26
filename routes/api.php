<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\V1\SwiperController;
use App\Http\Controllers\Api\V1\WishlistController;
use App\Http\Controllers\Api\V1\CartController;

// Define the v1 API prefix for all routes
Route::prefix('v1')->group(function () {

    // Public auth routes
    Route::post('auth/login', [AuthController::class, 'login']);
    Route::post('auth/register', [AuthController::class, 'register']);

    // Protected routes - require authentication via sanctum
    Route::middleware(['auth:sanctum'])->group(function () {

        // Authenticated user route
        Route::get('user', fn(Request $request) => $request->user());
        Route::post('auth/logout', [AuthController::class, 'logout']);

        // Categories CRUD routes
        Route::prefix('categories')->group(function () {
            Route::get('/', [CategoryController::class, 'index']);
            Route::post('/', [CategoryController::class, 'store']);
            Route::get('/{id}', [CategoryController::class, 'show']);
            Route::put('/{id}', [CategoryController::class, 'update']);
            Route::delete('/{id}', [CategoryController::class, 'destroy']);
        });

        // Products CRUD routes
        Route::prefix('products')->group(function () {
            Route::get('/', [ProductController::class, 'index']);
            Route::post('/', [ProductController::class, 'store']);
            Route::get('/{id}', [ProductController::class, 'show']);
            Route::put('/{id}', [ProductController::class, 'update']);
            Route::delete('/{id}', [ProductController::class, 'destroy']);
        });

        // Swipers CRUD routes
        Route::prefix('swipers')->group(function () {
            Route::get('/', [SwiperController::class, 'index']);
            Route::post('/', [SwiperController::class, 'store']);
            Route::get('/{id}', [SwiperController::class, 'show']);
            Route::put('/{id}', [SwiperController::class, 'update']);
            Route::delete('/{id}', [SwiperController::class, 'destroy']);
        });

        // Wishlist routes
        Route::prefix('wishlist')->group(function () {
            Route::get('/', [WishlistController::class, 'index']);
            Route::post('/', [WishlistController::class, 'store']);
            Route::get('/{id}', [WishlistController::class, 'show']);
            Route::delete('/{id}', [WishlistController::class, 'destroy']);
        });

        // Cart routes
        Route::prefix('cart')->group(function () {
            Route::get('/', [CartController::class, 'index']);
            Route::post('/', [CartController::class, 'store']);
            Route::get('/{id}', [CartController::class, 'show']);
            Route::put('/{id}', [CartController::class, 'update']);
            Route::delete('/{id}', [CartController::class, 'destroy']);
        });
    });
});
