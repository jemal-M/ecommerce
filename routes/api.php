<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\CategoryController;





// public routes
Route::post('/v1/auth/login',[AuthController::class, 'login']);
Route::post('/v1/auth/register',[AuthController::class, 'register']);


Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
Route::post('/v1/auth/logout',[AuthController::class, 'logout']);
    
// categories
Route::prefix('v1')->group(function () {
    Route::get('categories', [CategoryController::class, 'index']);
    Route::post('categories', [CategoryController::class, 'store']);
    Route::get('categories/{id}', [CategoryController::class, 'show']);
    Route::put('categories/{id}', [CategoryController::class, 'update']);
    Route::delete('categories/{id}', [CategoryController::class, 'destroy']);
});
// products
Route::prefix('v1')->group(function () {
    Route::get('products', [ProductController::class, 'index']);
    Route::post('products', [ProductController::class, 'store']);
    Route::get('products/{id}', [ProductController::class, 'show']);
    Route::put('products/{id}', [ProductController::class, 'update']);
    Route::delete('products/{id}', [ProductController::class, 'destroy']);
});
});