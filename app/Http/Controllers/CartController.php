<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
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

    function cart()
    {
        $carts = auth('customer')->check() ? Cart::where('customer_id', auth('customer')->id())->with('product:id,slug,title,image,sale_price,price')->get() : [];
        return view('frontend.cart', compact('carts'));
    }
}
