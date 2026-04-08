<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    function shop(Request $request)
    {
        $query = Product::query();

        $category  = $request->category;

        if ($category) {
            $query->whereHas('category', function ($q) use ($category) {
                $q->where('slug', $category);
            });
        }
        // dd($query->toSql());

        if ($request->filled('prod-search')) {
            $search = $request->input('prod-search');
            $query->whereLike('title', "%$search%");
        }

        $categories = Category::where('status', true)->select('id','title','slug')->latest()->get();
        $products = $query->select('title', 'slug', 'category_id', 'image', 'price', 'sale_price','stock')->latest()->get();
        $count = $query->latest()->count();

        return view('frontend.shop-sidebar', compact('categories','products', 'count'));
    }

    function getProduct($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        // dd($product);
        return view('frontend.single-product', compact('product'));
    }

    function productSearch(Request $request)
    {
        $search = $request->search;
        $products = Product::whereLike('title', "%$search%")->latest()->take(4)->get();
        $count = Product::whereLike('title', "%$search%")->latest()->count();

        return response()->json([
            'data' => $products,
            'count' => $count
        ]);
    }
}
