<?php

use App\Http\Controllers\Auth\CustomerController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ShopController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;




Route::get('/', [HomeController::class,'homepage'])->name('home');
// product search
Route::get('/product-search', [ShopController::class, 'productSearch'])->name('shop.search')  ;

// Shop
Route::get('/shop', [ShopController::class, 'shop'])->name('shop')  ;
Route::get('/shop/{slug}', [ShopController::class, 'getProduct'])->name('shop.product')  ;


// Customers
Route::get('/sign-in', [CustomerController::class,'showLoginForm'])->name('customer.show-sign-in');
Route::post('/sign-in', [CustomerController::class,'login'])->name('customer.sign-in');
Route::get('/sign-up', [CustomerController::class,'showRegisterForm'])->name('customer.show-sign-up');
Route::post('/sign-up', [CustomerController::class,'register'])->name('customer.sign-up');
Route::post('/sign-out', [CustomerController::class,'logout'])->name('customer.sign-out');

Route::get('/google-login', [CustomerController::class,'googleLogin'])->name('customer.google.signin');
Route::get('/google-callback', [CustomerController::class,'googleLoginCallback'])->name('customer.google.callback');
Route::get('/my-account', [CustomerController::class,'profile'])->name('customer.profile')->middleware('isCustomer');


// Cart
Route::get('/add-to-cart/{id}', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart',[CartController::class,'cart'])->name('cart');
Route::get('/cart/delete/{id}', [CartController::class,'deleteCart'])->name('cart.delete');
Route::get('/cart/delete-all',[CartController::class,'deleteAllCart'])->name('cart.delete-all');
Route::post('/cart/update',[CartController::class,'updateCart'])->name('cart.update');


// Checkout
Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');

Auth::routes();

