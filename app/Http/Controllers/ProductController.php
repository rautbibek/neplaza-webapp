<?php

namespace App\Http\Controllers;
use App\Product;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function allProduct(){
        $product = Product::select('id','price','maxprice','title','scategory_id','category_id','user_id','city_id','nhood_id','created_at')
                 ->with(['category','scategory','user','city','nhood','favorite_to_users'=>function($query){
                     $query->select('user_id')->where('user_id',Auth::id());
                    }])
                 ->latest()
                 ->simplePaginate(20);
                 
        return response()->json($product,200);
    }

    public function premium(){
        $product = Product::select('id','price','premium','maxprice','title','category_id','user_id','city_id','nhood_id','created_at')
                ->where('premium',1) 
                ->with(['category','scategory','user','city','nhood','favorite_to_users'=>function($query){
                     $query->select('user_id')->where('user_id',Auth::id());
                }])->simplePaginate(16);
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
