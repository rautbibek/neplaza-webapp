<?php

namespace App\Http\Controllers\Admin;
use App\Product;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all_ad = Product::all()->count();
        $urgent_ad = Product::where('emergency_sell',true)->count();
        $deleted_ad = Product::where('deleted',true)->count();
        $feature_ad = Product::where('premium',true)->count();
        $sold_ad = Product::where('sold',true)->count();

        return view('admin.product',compact('deleted_ad','feature_ad','urgent_ad','all_ad','sold_ad'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product = Product::select('id','productid','premium','sold',
        'emergency_sell','user_id','title','category_id','deleted','created_at')
        ->with(['user','category','featured','urgent','image']);

        if(request()->has('premium') && request('premium') !== null){
            $product->where('premium',request('premium'));
        }

        if(request()->has('search') && request('search') !== null){
            $product->where('productid','LIKE', "%".request('search')."%")->orWhere('title','LIKE', "%".request('search')."%");
        }

        if(request()->has('deleted') && request('deleted') !== null){
            $product->where('deleted',request('deleted'));
        }

        if(request()->has('sold') && request('sold') !== null){
            $product->where('sold',request('sold'));
        }

        if(request()->has('emergency_sell') && request('emergency_sell') !== null){
            $product->where('emergency_sell',request('emergency_sell'));
        }

        $p = $product->latest()->simplePaginate(30)->appends([
                      'premium' => request('premium'),
                      'deleted' => request('deleted'),
                      'sold'    =>  request('sole'),
                      'emergency_sell'  =>  request('emergency_sell')
                  ]);

        return response()->json($p,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ad = Product::with('featured','urgent','report','product_image','user')
           ->where('id',$id)->first();
        //return $ad;
        return view('admin.detail.adDetail',compact('ad'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->premium = $request->premium;
        $product->sold = $request->sold;
        $product->emergency_sell = $request->urgent;
        $product->deleted = $request->deleted;

        $product->update();

        return response()->json('ad state changed succefully',200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $products = Product::findOrFail($id);
        $products->deleted = true;
        foreach ($products->product_image as $product) {
            $product->delete();
        }
        $products->delete();
        //$products->update(['deleted' => 1]);
        return response()->json('ad deleted succefully ',200);
    }
}
