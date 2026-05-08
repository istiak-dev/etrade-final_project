<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'title',
        'slug',
        'short_description',
        'description',
        'category_id',
        'brand_name',
        'model',
        'sku',
        'stock',
        'minstock',
        'stock_status',
        'price',
        'sale_price',
        'deal_date',
        'deal_status',
        'image',
        'gall_img',
        'published_status',
        'published_date'
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    function carts(){
        return $this->hasMany(Cart::class);
    }
}
