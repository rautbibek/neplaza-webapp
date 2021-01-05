<?php

namespace App\Http\Controllers;
use App\Scategory;
use App\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    //category and category Product
    public function scategoryProduct($slug){

        $scategory = Scategory::with('category')->where('slug',$slug)->firstOrFail();
        if(!Session::has($slug)){
            $scategory->increment('view_count');
            Session::put($slug,1);
        }
        $product = app(Pipeline::class)
                  ->send(Product::query())
                  ->through([
                      \App\Filter\Type::class,
                      \App\Filter\Status::class,
                      \App\Filter\Filters::class,
                      \App\Filter\Sort::class,
                      \App\Filter\Filter_1::class,
                      \App\Filter\Filter_2::class,
                      \App\Filter\Filter_3::class,
                      \App\Filter\Brand::class,
                      \App\Filter\Price::class,
                      \App\Filter\Sort::class,

                  ])
                  ->thenReturn();

        if(request()->has('city_id') && request('city_id') != null){
            $product->where('city_id',request('city_id'));
        }

        if(request()->has('nhood_id') && request('nhood_id') != null){
            $product->where('nhood_id',request('nhood_id'));
        }

        $p = $product->where('scategory_id',$scategory->id)
                  ->where('deleted',false)
                  ->where('sold',false)
                  ->with(['product_property','image','favorite_to_users'=>function($query){
                     $query->select('user_id')->where('user_id',Auth::id());
                    }])
                  ->simplePaginate(15)->appends([
                      'price' => request('price'),
                      'filter' => request('filter'),
                      'filter_1_id' => request('filter_1_id'),
                      'filter_2_id' => request('filter_2_id'),
                      'filter_3_id' => request('filter_3_id'),
                      'brand' => request('brand'),
                      'city_id' => request('city_id'),
                      'nhood_id'=>request('nhood_id')
                  ]);

        return response()->json($p,200);
    }

    //category and category Product
    public function subcategoryFilter($slug){
        $subcategoryFilter = cache()->remember('filter-'.$slug,60*60*24,function() use ($slug){ 
         return Scategory::
                   with(['type','category','status','filter','filter_1','filter_2','filter_3','brand'])
                   ->where('slug',$slug)
                   ->get();
        });
        return response()->json($subcategoryFilter,200);
    }
}
