<?php

namespace App\Http\Controllers;
use App\Category;
use App\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function category(){
        $category = Category::select('id','name','slug','icons')->where('visible',true)->get();
        return response()->json($category,200);
    }

    public function subCategory(){
        $subcategory = Category::select('id','name','slug','icons')->with('scategory')->get();
        return response()->json($subcategory,200);
        
    }


    //category and category Product
    public function categoryProduct($slug){
        $category = Category::where('slug',$slug)->select('id','name','slug')->firstOrFail();
        
        $product = Product::select('id','price','maxprice','title','category_id','user_id','city_id','nhood_id','created_at')
                 ->where('category_id',$category->id)
                 ->with('category','user','city','nhood')->simplePaginate(20);
        return response()->json([
                $product,
                $category
             ],
            200
        );
    }
}
