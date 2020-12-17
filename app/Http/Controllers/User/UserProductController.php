<?php

namespace App\Http\Controllers\User;
use App\Product;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserProductController extends Controller
{

    public function __construct(){
        return $this->middleware('auth');
    }

    public function myAds(){
        $user_id = Auth::id();
        $product = Product::select('id','price','slug','maxprice','title','scategory_id','category_id','user_id','city_id','nhood_id','created_at')
                ->where('user_id',$user_id)
                ->where('deleted',false)
                ->where('sold',false)
                ->latest()
                ->with('product_property','product_image')->simplePaginate(12);
        return response()->json($product,200);
    }

    public function myFav(){
        $user_id = Auth::user()->id;
      //$fav_product = Product::;
      $fav = Auth::user()->with(
      'favourit_products.product_image','favourit_products.product_property')->where('id',$user_id)->get();
      return response()->json($fav,200);
    }

    public function featured(){
        $user_id = Auth::id();
        $product = Product::select('id','price','slug','maxprice','title','category_id','scategory_id','premium','user_id','city_id','nhood_id','created_at')
                ->where('user_id',$user_id)
                ->where('deleted',false)
                ->where('sold',false)
                ->where('premium',true)
                ->latest()
                ->with('product_property','product_image','featured')->simplePaginate(16);
        return response()->json($product,200);
    }

    public function sold(){
        $user_id = Auth::id();
        $product = Product::select('id','price','slug','maxprice','title','scategory_id','category_id','user_id','city_id','nhood_id','created_at')
                ->where('user_id',$user_id)
                ->where('sold',true)
                ->latest()
                ->with('product_property','product_image')->simplePaginate(16);
        return response()->json($product,200);
    }

    public function deleted(){
        $user_id = Auth::id();
        $product = Product::select('id','price','maxprice','title','category_id','scategory_id','user_id','city_id','nhood_id','created_at')
                ->where('user_id',$user_id)
                ->where('deleted',true)
                ->latest()
                ->with('product_property','product_image')->simplePaginate(16);
        return response()->json($product,200);
    }

    public function urgent(){
        $user_id = Auth::id();
        $product = Product::select('id','price','slug','maxprice','title','scategory_id','category_id','user_id','city_id','nhood_id','created_at')
                ->where('user_id',$user_id)
                ->where('emergency_sell',true)
                ->latest()
                ->with('product_property','product_image','urgent')->simplePaginate(16);
        return response()->json($product,200);
    }
}
