<?php

use App\Http\Controllers\Api\v1\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::get('/v1/products',[ProductController::class, 'getAllProducts']);
Route::get('/v1/products/{id}',[ProductController::class, 'getProductById']);
Route::post('/v1/products/create',[ProductController::class, 'createProduct']);
Route::delete('/v1/products/{id}',[ProductController::class, 'deleteProduct']);