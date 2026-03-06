<?php
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ShopController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;




Route::get('/', [HomeController::class,'homepage'])->name('home');

// Shop
Route::get('/shop', [ShopController::class, 'shop'])->name('shop')  ;
Route::get('/shop/{slug}', [ShopController::class, 'getProduct'])->name('shop.product')  ;

Auth::routes();

