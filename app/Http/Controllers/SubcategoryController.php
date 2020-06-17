<?php

namespace App\Http\Controllers;
use App\Scategory;
use App\Product;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    //category and category Product
    public function scategoryProduct($slug){
        $scategory = Scategory::with('category')->where('slug',$slug)->firstOrFail();
        $product = Product::select('id','price','maxprice','title','category_id','user_id','city_id','nhood_id','scategory_id','created_at')
                 ->where('scategory_id',$scategory->id)
                 ->where('deleted',false)
                 ->where('sold',false)
                 ->latest()
                 ->with('category','user','city','nhood','scategory','product_image')
                 ->simplePaginate(20);
                 return response()->json([
                  $product,
                  $scategory
               ],
            200
        );
    }

    //category and category Product
    public function subcategoryFilter($slug){
        $subcategoryFilter = Scategory::
                   with('type','status','filter','filter_1','filter_2','filter_3','brand')
                   ->where('slug',$slug)
                   ->get();
        return $subcategoryFilter;
    }
}
