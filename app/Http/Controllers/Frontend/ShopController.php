<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    function shop(Request $request)
    {
        $query = Product::query();

        $category  = $request->category;

        if ($category) {
            $query->whereHas('categories', function ($q) use ($category) {
                $q->where('slug', $category);
            });
        }
    }

    function getProduct($slug)
    {
        $product = product::where('slug', $slug)->firstOrFail();
        // dd($product);
        return view('frontend.single-product', compact('product'));
    }

    function productSearch(Request $request)
    {
        $search = $request->search;
        $products = product::whereLike('title', "%$search%")->latest()->take(4)->get();
        $count = product::whereLike('title', "%$search%")->latest()->count();

        return response()->json([
            'data' => $products,
            'count' => $count
        ]);
    }
}
