<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    function checkout(){
        return view('frontend.checkout');
    }
}
