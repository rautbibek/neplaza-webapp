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
        $product = Product::select('id','price','maxprice','title','category_id','user_id','city_id','nhood_id','created_at')
                ->where('user_id',$user_id) 
                ->where('deleted',false)
                ->where('sold',false)
                ->with('category','user','city','nhood','product_image')->simplePaginate(16);
        return response()->json($product,200);
    }

    public function myFav(){
        $user_id = Auth::user()->id;
      //$fav_product = Product::;
      $fav = Auth::user()->with('favourit_products','favourit_products.category',
      'favourit_products.product_image','favourit_products.user','favourit_products.city','favourit_products.nhood')->where('id',$user_id)->get();
      return response()->json($fav,200);
    }
}
