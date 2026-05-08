<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    function checkout()
    {
        $carts = Cart::with('product:id,title,price,sale_price')->where('customer_id', auth('customer')->id())->get();
        
        return view('frontend.checkout', compact('carts'));
    }
}
