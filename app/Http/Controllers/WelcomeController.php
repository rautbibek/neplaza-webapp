<?php

namespace App\Http\Controllers;
use App\City;
use App\Nhood;
use App\User;
use App\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index(){
        return view('welcome');
    }
    
    public function check(){
        return view('check');
    }

    public function city(){
        $city= City::select('id','name')->orderBy('name','ASC')->get();
        return response()->json($city,200);
    }

    public function nhood($id){
        $nhood= Nhood::select('id','name')->where('city_id',$id)->orderBy('name','ASC')->get();
        return response()->json($nhood,200);
    }

    public function seller($id,$username){
        $user = User::where('id',$id)->where('username',$username)->with('city','nhood')->first();
        return response()->json($user,200);
    }

    public function sellerAd($id){
        $product = Product::select('id','price','maxprice','slug','title','scategory_id',
                           'city_id','nhood_id','user_id','created_at')
                           ->where('user_id',$id)
                           ->where('deleted',false)
                           ->where('sold',false)
                           ->with(['scategory','user','city','nhood','favorite_to_users'=>function($query){
                                $query->select('user_id')->where('user_id',Auth::id());
                            }])
                           ->latest()
                           ->simplePaginate(15);
        return response()->json($product,200);
    }
}
