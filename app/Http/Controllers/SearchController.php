<?php

namespace App\Http\Controllers;
use App\Product;
use App\Brand;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request){
      $keyword = request()->search;
      $products = Product::select('id','category_id','slug','brand_id','nhood_id','description','title','created_at')->with('category','brand','nhood')
      ->where('title', 'LIKE', "%{$keyword}%")
      ->orWhereHas('brand', function($q) use ($keyword){
        return $q->where('name','like','%'. $keyword . '%');
      })
      ->orWhereHas('nhood', function($q) use ($keyword){
        return $q->where('name','like','%'. $keyword . '%');
      })
      ->get();
      return response()->json($products,200);
    }

    public function searchResult(Request $request){
      $keyword = \Request::get('q');
      $searchResult = Product::with(['scategory','brand','product_image','city','user','nhood','favorite_to_users'=>function($query){
                     $query->select('user_id')->where('user_id',Auth::id());
                    }])
      ->where('title', 'LIKE', "%{$keyword}%")
      ->orWhereHas('brand', function($q) use ($keyword){
        return $q->where('name','like','%'. $keyword . '%');
      })
      ->orWhereHas('nhood', function($q) use ($keyword){
        return $q->where('name','like','%'. $keyword . '%');
      })
      ->simplePaginate(20)->appends(
          ['q'=>\Request::get('q')]
        );
      return response()->json($searchResult,200);
    }
}
