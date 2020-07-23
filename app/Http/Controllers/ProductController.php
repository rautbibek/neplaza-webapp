<?php

namespace App\Http\Controllers;
use App\Product;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function homeProduct(){
        $product = Product::select('id','price','slug','maxprice','title','scategory_id','user_id','city_id','nhood_id','created_at')
                 ->with(['scategory','user','city','nhood','favorite_to_users'=>function($query){
                     $query->select('user_id')->where('user_id',Auth::id());
                    }])
                 ->where('deleted',false)
                 ->where('sold',false) 
                 ->latest()
                 ->take(12)
                 ->get();
                 
        return response()->json($product,200);
    }

    //homepage urgent product display only 4 products
    public function urgentProduct(){
        $product = Product::select('id','price','slug','maxprice','title','scategory_id','user_id','city_id','nhood_id','created_at')
                 ->with(['scategory','user','city','nhood','favorite_to_users'=>function($query){
                     $query->select('user_id')->where('user_id',Auth::id());
                    }])
                 ->where('emergency_sell',true)
                 ->where('deleted',false)
                 ->where('sold',false) 
                 ->latest()
                 ->take(4)
                 ->get();
                 
        return response()->json($product,200);
    }

    //all urgent product  display with simaple pagination
    public function urgent(){
        $product = Product::select('id','price','slug','maxprice','title','scategory_id','user_id','city_id','nhood_id','created_at')
                 ->with(['scategory','user','city','nhood','favorite_to_users'=>function($query){
                     $query->select('user_id')->where('user_id',Auth::id());
                    }])
                 ->where('emergency_sell',true)
                 ->where('deleted',false)
                 ->where('sold',false) 
                 ->latest()
                 ->simplePaginate(20);
                 
        return response()->json($product,200);
    }

    public function allProduct(){
        $product = Product::select('id','price','slug','maxprice','title','scategory_id','user_id','city_id','nhood_id','created_at')
                 ->with(['scategory','user','city','nhood','favorite_to_users'=>function($query){
                     $query->select('user_id')->where('user_id',Auth::id());
                    }])
                 ->where('deleted',false)
                 ->where('sold',false) 
                 ->latest()

                 ->simplePaginate(20);
                 
        return response()->json($product,200);
    }

    public function premium(){
        $product = Product::select('id','price','premium','maxprice','title','slug','scategory_id','user_id','city_id','nhood_id','created_at')
                ->where('premium',1)
                ->where('deleted',false)
                ->where('sold',false) 
                ->with(['scategory','user','city','nhood','favorite_to_users'=>function($query){
                     $query->select('user_id')->where('user_id',Auth::id());
                }])->take(8)->get();
        return response()->json($product,200);
    }

    public function featured(){
        $product = Product::select('id','price','premium','maxprice','title','slug','scategory_id','user_id','city_id','nhood_id','created_at')
                ->where('premium',1)
                ->where('deleted',false)
                ->where('sold',false) 
                ->with(['scategory','user','city','nhood','favorite_to_users'=>function($query){
                     $query->select('user_id')->where('user_id',Auth::id());
                }])->simplePaginate(20);
        return response()->json($product,200);
    }

    public function productDetail($id){
        
        $product = Product:: where('id',$id)->with(
                [
                    'category',
                    'type',
                    'status',
                    'brand',
                    'filter',
                    'filter_1',
                    'filter_2',
                    'filter_3',
                    'scategory',
                    'user',
                    'city',
                    'nhood',
                    'favorite_to_users'=>function($query){
                        $query->select('user_id')->where('user_id',Auth::id());
                    }])->get();
        return response()->json($product,200);
    }
}
