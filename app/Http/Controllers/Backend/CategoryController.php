<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    // Get all Categories
    function showCategory (){
        $categories = Category::latest()->get();
        return view('backend.category.index', compact('categories'));
    }
    // Store Category
    function storeCategory(CategoryRequest $request){
        // File Upload
       $categoryIcon  = $request->hasFile('icon') ? $request->icon->store('category', 'public') : null;

       // Database Store
        $category =  Category::create([
            'title' => $request->title,
            'slug'=> str($request->title)->slug(),
            'icon'=> $categoryIcon
        ]);
        return back()->with('msg', [
            'type' => 'success',
            'content' => 'New Category added!'
        ]);
    }

    // Update Category
    function updateCategory(CategoryRequest $request,  $id){
        $oldCategory = Category::findOrFail($id);
        $categoryIcon  = $request->hasFile('icon') ? $request->icon->store('category', 'public') : $oldCategory->icon;
        if($request->hasFile('icon') && $oldCategory->icon){
            // Previous img delete
            if(Storage::disk('public')->exists($oldCategory->icon)){
                Storage::disk('public')->delete($oldCategory->icon);
            }
        }

         $category =  $oldCategory->update([
            'title' => $request->title,
            'icon'=> $categoryIcon
        ]);
        return back()->with('msg', [
            'type' => 'success',
            'content' => 'Category updated!'
        ]);
        
    }


    // Delete Category
    function deleteCategory($id){
         $oldCategory = Category::findOrFail($id);
        
        if( $oldCategory->icon && Storage::disk('public')->exists($oldCategory->icon)){
            // Previous img delete
            Storage::disk('public')->delete($oldCategory->icon);
        }
        $oldCategory->delete();
        return to_route('admin.category.show')->with('msg', [
            'type' => 'warning',
            'content' => 'Delete Category!'
        ]);
    }

    function searchCategory(Request $request){
        $search = $request->search;
        $categories = Category::whereLike('title',"%$search%")->select('id','title','icon')->latest()->get();
        return response()->json([
            'data' => $categories,
        ]);
    }
}
