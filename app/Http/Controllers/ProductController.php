<?php

namespace App\Http\Controllers;
use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function allProduct(){
        $product = Product::select('id','price','maxprice','title','category_id','user_id','city_id','nhood_id','created_at')
                 ->with('category','user','city','nhood')->simplePaginate(20);
        return response()->json($product,200);
    }
}
