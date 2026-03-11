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
        $oldProduct = Product::findOrFail($id);

        // Delete Main Image
        if ($oldProduct->image && Storage::disk('public')->exists($oldProduct->image)) {
            Storage::disk('public')->delete($oldProduct->image);
        }

        // Delete Gallery Images
        if ($oldProduct->gall_img) {
            $images = json_decode($oldProduct->gall_img, true);
            if (is_array($images)) {
                foreach ($images as $img) {
                    if (Storage::disk('public')->exists($img)) {
                        Storage::disk('public')->delete($img);
                    }
                }
            }
        }

        $oldProduct->delete();

        return redirect()->route('admin.product.list')->with('msg', ['type' => 'warning', 'content' => 'Product Deleted!']);
    }

    public function updateProduct(ProductRequest $request, $id)
    {
        $oldProduct = product::findOrFail($id);

        // 1. daily deal status update
        if ($request->has('deal_status')) {
            $oldProduct->update(['deal_status' => $request->deal_status]);

            if ($request->deal_status == '1') {
                return back()->with('msg', ['content' => 'Deal resumed!']);
            } elseif ($request->deal_status == '0') {
                return back()->with('msg', ['type' => 'error', 'content' => 'Deal suspended!']);
            }
        }

        // 2. daily deal date update
        if ($request->has('deal_date') && $request->has('id')) {
            if ($request->filled('deal_date')) {

                $oldProduct->update(['deal_date'   => $request->deal_date, 'deal_status' => true]);
                return back()->with('msg', ['type' => 'success', 'content' => 'Deal Scheduled!']);

            } else {
                return back()->with('msg', ['type' => 'error', 'content' => 'Please select a valid date!']);
            }
        }


        // Update Main Image (Only if new image is uploaded)
        $productImg = $request->hasFile('image') ? $request->file('image')->store('product', 'public') : $oldProduct->image;
        if ($request->hasFile('image') && $oldProduct->image) {
            if (Storage::disk('public')->exists($oldProduct->image)) {
                Storage::disk('public')->delete($oldProduct->image);
            }
        }

        // Update Gallery Images
        if ($request->hasFile('gall_img')) {
            //store in local storage
            $galleryPaths = [];
            foreach ($request->file('gall_img') as $file) {
                $galleryPaths[] = $file->store('product/galleryimg', 'public');
            }
            //delete from local storage
            if ($oldProduct->gall_img) {
                $images = json_decode($oldProduct->gall_img, true) ?? [];
                foreach ($images as $img) {
                    Storage::disk('public')->exists($img) ? Storage::disk('public')->delete($img) : null;
                }
            }
        } else {
            $galleryPaths = json_decode($oldProduct->gall_img, true) ?? [];
        }


        // Use update() instead of create()
        $oldProduct->update([
            'title'             => $request->title,
            // 'slug'              => str($request->title)->slug(),
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
