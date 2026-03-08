<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    function homepage()
    {
        // Get Active Categories
        $categories = Category::where('status', true)->take(12)->latest()->get();

        // Get Active Products
        $products = product::where('stock_status', true)->select('id', 'title', 'image', 'slug', 'price', 'sale_price', 'gall_img')->latest()->get();

        $ddProducts = product::whereDate('deal_date', date('Y-m-d'))->where('deal_status', true)->select('id', 'title', 'image', 'price', 'sale_price', 'deal_date', 'deal_status')->latest()->get();

        return view('frontend.index', compact('categories', 'products', 'ddProducts'));
    }
}
