<?php

namespace App\Providers;

use App\Models\Cart;
use App\Models\Category;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        view()->composer('layouts.FrontendLayouts', function ($view) {
            $categories = Category::where('status', true)->select('id','title', 'slug')->take(20)->latest()->get();
            $carts = auth('customer')->check() ? Cart::where('customer_id', auth('customer')->id())->with('product:id,slug,title,image,sale_price,price')->get() : null;
            
            return $view->with(['categories' =>  $categories, 'carts' => $carts]);
        });
    }
}
