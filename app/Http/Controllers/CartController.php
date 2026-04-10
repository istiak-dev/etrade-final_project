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

    function deleteCart($id)
    {
        if (auth('customer')->check()) {
            $delete = Cart::where('id', $id)->where('customer_id', auth('customer')->id())->delete();
            return back()->with('msg', ['type' => 'warning', 'content' => 'Product Removed!']);
        }
        return back();
    }

    function deleteAllCart()
    {
        $customerId = auth('customer')->id();

        if (auth('customer')->check() && Cart::where('customer_id', $customerId)->exists()) {
            $deleteAll = Cart::where('customer_id', $customerId)->delete();
            return back()->with('msg', ['type' => 'warning', 'content' => 'Cart Cleared!']);
        }
        
        return back();
    }

    function updateCart(Request $request)
    {

        $isUpdated = false;

        if (auth('customer')->check() && $request->has('product_ids')) {

            foreach ($request->product_ids as $key => $product_id) {

                // Fetch the CURRENT row from the database
                $cartItem = Cart::where('product_id', $product_id)
                    ->where('customer_id', auth('customer')->id())
                    ->first();

                // If the database qty is DIFFERENT from the requested qty, then update
                if ($cartItem && $cartItem->qty != $request->qty[$key]) {
                    $cartItem->update([
                        'qty' => $request->qty[$key]
                    ]);
                    $isUpdated = true;
                }
            }

            if ($isUpdated) {
                return back()->with('msg', ['type' => 'success', 'content' => 'Cart Updated!']);
            }
        }

        return back();
    }
}
