<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
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
}
