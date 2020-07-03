<?php

namespace App\Http\Controllers;
use App\Category;
use App\Product;
use Illuminate\Support\Facades\Auth;
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
        $category = Category::where('slug',$slug)->firstOrFail(['id','name','slug']);
        
        $product = Product::select('id','price','maxprice','title','category_id','user_id','city_id','nhood_id','scategory_id','created_at')
                 ->where('category_id',$category->id)
                 ->where('deleted',false)
                 ->where('sold',false)
                 ->with(['favorite_to_users'=>function($query){
                     $query->select('user_id')->where('user_id',Auth::id());
                 }])
                 ->simplePaginate(20);
                 return response()->json([
                  $product,
                  $category
               ],
            200
        );
    }
}
