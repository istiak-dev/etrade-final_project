<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    function shop(Request $request){
        $query = Product::query();

        $category  = $request->category;

        if($category){
            $query->whereHas('categories', function($q) use ($category){
                $q->where('slug', $category);
            });
        }
        


        
    }
    function getProduct($slug){
        $product = product::where('slug', $slug)->firstOrFail();
        dd($product);
    }
}
