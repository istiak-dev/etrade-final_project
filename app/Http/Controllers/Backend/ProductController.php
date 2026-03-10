<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function addProduct()
    {
        $categories = Category::where('status', true)->select('id', 'title')->latest()->get();
        $products = Product::latest()->get();

        return view('backend.product.add-product', compact('categories', 'products'));
    }

    public function storeProduct(ProductRequest $request)
    {
        // ProductRequest
        // 1. Handle Main Image
        $productImg = $request->hasFile('image') ? $request->file('image')->store('product', 'public') : null;

        // 2. Handle Gallery Images
        $galleryPaths = [];
        if ($request->hasFile('gall_img')) {
            foreach ($request->file('gall_img') as $file) {
                $galleryPaths[] = $file->store('galleryimg', 'public');
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


        return back()->with('msg', ['type' => 'success', 'content' => 'New Product Added!']);
    }

    public function productList()
    {
        $categories = Category::select('id', 'title')->latest()->get();
        $products = Product::latest()->get();

        return view('backend.product.product-list', compact('categories', 'products'));
    }

    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);

        // Delete Main Image
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        // Delete Gallery Images
        if ($product->gall_img) {
            $images = json_decode($product->gall_img, true);
            if (is_array($images)) {
                foreach ($images as $img) {
                    if (Storage::disk('public')->exists($img)) {
                        Storage::disk('public')->delete($img);
                    }
                }
            }
        }

        $product->delete();

        return redirect()->route('admin.product.list')->with('msg', ['type' => 'warning', 'content' => 'Product Deleted!']);
    }

    public function updateProduct(ProductRequest $request, $id)
    {
        $product = product::findOrFail($id);

        // 1. daily deal status update
        if ($request->has('deal_status')) {
            $product->update(['deal_status' => $request->deal_status]);

            if ($request->deal_status == '1') {
                return back()->with('msg', ['content' => 'Deal resumed!']);
            } elseif ($request->deal_status == '0') {
                return back()->with('msg', ['type' => 'error','content' => 'Deal suspended!']);
            }
        }

        // 2. daily deal date update
        if ($request->has('deal_date') && $request->has('id')) {
            if ($request->filled('deal_date')) {
                $product->update(['deal_date'   => $request->deal_date]);

                return back()->with('msg', ['type' => 'success', 'content' => 'Deal Scheduled!']);
            } else {
                return back()->with('msg', ['type' => 'error', 'content' => 'Please select a valid date!']);
            }
        }


        // Update Main Image (Only if new image is uploaded)

        $productImg = $request->hasFile('image') ? $request->file('image')->store('product', 'public') : $product->image;
        if ($request->hasFile('image') && $product->image) {
            if (Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
        }

        // Update Gallery Images
        $galleryPaths = json_decode($product->gall_img, true) ?? [];
        if ($request->hasFile('gall_img')) {
            // Optional: delete old gallery images here if you want to replace them
            foreach ($request->file('gall_img') as $file) {
                $galleryPaths[] = $file->store('galleryimg', 'public');
            }
        }

        // Use update() instead of create()
        $product->update([
            'title'             => $request->title,
            'slug'              => str($request->title)->slug(),
            'short_description' => $request->short_description,
            'description'       => $request->description,
            'catagory_id'       => $request->catagory_id,
            'category_id'       => $request->category_id,
            'brand_name'        => $request->brand_name,
            'model'             => $request->model,
            'sku'               => $request->sku,
            'stock'             => $request->stock,
            'minstock'          => $request->minstock,
            'stock_status'      => $request->stock_status,
            'price'             => $request->price,
            'sale_price'        => $request->sale_price,
            'image'             => $productImg,
            'gall_img'          => json_encode($galleryPaths),
            'published_status'  => $request->published_status,
            'published_date'    => $request->published_date,
        ]);

        return back()->with('msg', ['type' => 'success', 'content' => 'Product Updated!']);
    }
}
