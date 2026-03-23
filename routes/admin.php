<?php

use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\ProductController;
use Illuminate\Support\Facades\Route;





//* Backend Route
Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');


Route::prefix('/category')
    ->name('category.')
    ->controller(CategoryController::class)
    ->group(function(){
        Route::get('/search','searchCategory')->name('search');
        Route::get('/{id?}', 'showCategory')->name('show');
        Route::post('/store', 'storeCategory')->name('store');
        Route::get('/delete/{id}', 'deleteCategory')->name('delete');
        Route::post('/update/{id}', 'updateCategory')->name('update');
    });

// add product routes
Route::prefix('/product')
    ->name('product.')     
    ->controller(ProductController::class)
    ->group(function(){
        Route::get('/add-product/{id?}', 'addProduct')->name('add');
        Route::post('/store-product','storeProduct')->name('storproduct');
        Route::get('/product-list', 'productList')->name('list');
        Route::get('/delete-product/{id}','deleteProduct')->name('deleteproduct');
        Route::post('/update-product/{id}','updateProduct')->name('updateproduct');
        Route::get('/search-product','searchProduct')->name('search');
    });



