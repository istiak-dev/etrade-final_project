<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    function addToCart(Request $request, $id)
    {
        
        if (Cart::where('product_id', $id)->where('customer_id', auth('customer')->id())->exists()) {
            Cart::where('product_id', $id)->where('customer_id', auth('customer')->id())->increment('qty', $request->qty ?? 1);
        } else {
            Cart::create([
                'customer_id' => auth('customer')->id(),
                'product_id' => $id,
                'qty' => $request->qty ?? 1
            ]);
        }
        return back();
    }
}
