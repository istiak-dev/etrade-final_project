<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    function getAllProducts(Request $request)
    {
        $search = $request->search;

        $query = Product::query();
        if ($search) {
            $query->whereLike('title', "%$search%");
        }

        $products = $query->get();
        return response()->json([
            'status' => 'success',
            'data' => $products,
            'message' => 'Products retrieved successfully'
        ]);
    }


    function getProductById($id)
    {
        try {
            $product = Product::findOrFail($id);
            return response()->json([
                'status' => 'success',
                'data' => $product,
                'message' => 'Product retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found'
            ], 404);
        }
    }

    function createProduct(Request $request)
    {
        $productImg = $request->hasFile('image') ? $request->file('image')->store('product', 'public') : null;

        // 2. Handle Gallery Images
        $galleryPaths = [];
        if ($request->hasFile('gall_img')) {
            foreach ($request->file('gall_img') as $file) {
                $galleryPaths[] = $file->store('product/galleryimg', 'public');
            }
        }

        // 3. Database Store
        $product =  Product::create([
            'title'             => $request->title,
            'category_id'       => $request->category_id,
            'slug'              => str($request->title)->slug(),
            'short_description' => $request->short_description,
            'description'       => $request->description,
            'brand_name'        => $request->brand_name,
            'model'             => $request->model,
            'sku'               => $request->sku,
            'stock'             => $request->stock,
            'minstock'          => $request->minstock,
            'stock_status'      => $request->stock_status ?? true,
            'price'             => $request->price,
            'sale_price'        => $request->sale_price,
            'image'             => $productImg,
            'gall_img'          => json_encode($galleryPaths),
            'published_status'  => $request->published_status,
            'published_date'    => $request->published_date,
        ]);

        return response()->json([
            'status' => 'success',
            'data' => $product,
            'message' => 'Product created successfully'
        ], 201);
    }


    function deleteProduct($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Product deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found'
            ], 404);
        }
    }
}
