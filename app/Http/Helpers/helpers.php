<?php

function isActiveRoute($uri, $activeClass = 'active'){
    if(!$uri){
        return null;
    }
    return request()->routeIs($uri) ? $activeClass : '';
}


function getImage($src = null){
    if(!$src) return asset('placeholder.png');

    return asset('storage/'. $src);
}


function getDiscount($product){
    return round((100 - ($product->sale_price / $product->price) * 100)) . '%';
}

function dealBtnClr($product){
    return ($product->deal_status ?? 0) == 1
    ? ($product->deal_date && (date('Y-m-d', strtotime($product->deal_date)) >= date('Y-m-d')) ? 'btn-danger' : 'btn-secondary')
    : ($product->deal_date && (date('Y-m-d', strtotime($product->deal_date)) >= date('Y-m-d')) ? 'btn-info' : 'btn-secondary');
}