<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    function homepage(){
        // Get Active Categories
        $categories = Category::where('status', true)->take(12)->latest()->get();

        // Get Active Products
        $products = product::where('stock_status', true)->select('id', 'title', 'image', 'slug', 'price', 'sale_price','deal_date', 'deal_status', 'gall_img')->latest()->get();

        return view('frontend.index', compact('categories','products'));
    }
}
