<?php

namespace App\Http\Controllers;
use App\Category;
use App\Product;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function category(){
       $category = cache()->remember('menu-category',60*60*24,function(){
        return Category::select('id','name','slug','icons','product_count')->where('visible',true)->get();
      });
        return response()->json($category,200);
    }

    public function subCategory(){
        $subcategory = cache()->remember('meghamenu',60*60*24,function(){
          return Category::select('id','name','slug','icons','product_count')->with(['scategory'=>function($q){
            $q->withCount('product');
          }])->get();
        });
        return response()->json($subcategory,200);

    }


    //category and category Product
    public function categoryProduct($slug){
        $category = Category::where('slug',$slug)->with('scategory')->firstOrFail(['id','name','slug']);
        if(!Session::has($slug)){
            $category->increment('view_count');
            Session::put($slug,1);
        }
        $product = Product::select('id','price','maxprice','title','slug','category_id','user_id','city_id','nhood_id','scategory_id','created_at')
                 ->where('category_id',$category->id)
                 ->where('deleted',false)
                 ->where('sold',false)
                 ->with(['image','product_property','favorite_to_users'=>function($query){
                     $query->select('user_id')->where('user_id',Auth::id());
                 }])->latest()
                 ->simplePaginate(20);
                 return response()->json([
                  $product,
                  $category
               ],
            200
        );
    }
}
