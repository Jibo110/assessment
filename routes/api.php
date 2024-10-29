<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WooCommerceController;

/*
|--------------------------------------------------------------------------
// API Routes
|--------------------------------------------------------------------------
// Register API routes for your application.
|-------------------------------------------------------------------------- 
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route for ProductController
Route::post('/store-product', [ProductController::class, 'store']);

// Route for WooCommerceController
Route::post('/woocommerce/store-product', [WooCommerceController::class, 'storeProduct']);

// Route to fetch products
Route::get('/fetch-products', [ProductController::class, 'fetchProducts']);

// for view
Route::get('/products', [ProductController::class, 'index']);

