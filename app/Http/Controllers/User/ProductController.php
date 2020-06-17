<?php

namespace App\Http\Controllers\user;
use App\Http\Controllers\Controller;

use App\product;
use Illuminate\Support\Facades\Auth;
use App\Http\imageExtractor\ImageResizer;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    private $imageResizer;

    public function __construct(ImageResizer $imageResizer){
        $this->imageResizer = $imageResizer;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        
        
        $product= $request->user()->product()->create($request->except('image'));
        if($request->hasFile('image')){
            return $this->imageResizer->resizeImage($request->image,$product->id);
        }
        $message="Ad posted succefully !!"  ;
        return response()->json($message,200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::select('id','created_at','user_id','title')->with('product_image')->where('id',$id)->firstOrFail();
        $this->authorize('view', $product);
       
        return response()->json($product,200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::with('category','scategory')->findOrFail($id);
        return response()->json($product,200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, product $product)
    {
        //return $request->all();
        if($request->url === 'house'){
           $product->filter_id    = $request->filter_id;
           $product->filter_1_id  = $request->filter_1_id;
           $product->filter_2_id  = $request->filter_2_id;
           $product->filter_3_id  = $request->filter_3_id;
           $product->type_id      = $request->type_id;
           $product->status_id    = $request->status_id;
           $product->property_1   = $request->property_1;
           $product->property_2   = $request->property_2;
           $product->property_3   = $request->property_3;
        }
        if($request->url === 'shop'){
           $product->filter_id    = $request->filter_id;
           $product->filter_1_id  = $request->filter_1_id;
           $product->filter_2_id  = $request->filter_2_id;
           $product->filter_3_id  = $request->filter_3_id;
           $product->type_id      = $request->type_id;
           $product->status_id    = $request->status_id;
           $product->property_2   = $request->property_2;
           $product->property_3   = $request->property_3;
        }

        if($request->url === 'land'){
           $product->filter_1_id  = $request->filter_1_id;
           $product->filter_3_id  = $request->filter_3_id;
           $product->type_id      = $request->type_id;
           $product->property_3   = $request->property_3;
        }

        if($request->url === 'mobile'){
           $product->filter_1_id  = $request->filter_1_id;
           $product->filter_2_id  = $request->filter_2_id;
           $product->brand_id      = $request->type_id;
           $product->status_id   = $request->status_id;
        }

        if($request->url === 'bike' || $request->url === 'car'){
           $product->brand_id     = $request->brand_id;
           $product->status_id    = $request->status_id;
           $product->type_id      = $request->type_id;
           $product->property_2   = $request->property_2;
           $product->property_1   = $request->property_2;
        }

        if($request->url === 'job'){
            $product->filter_id    = $request->filter_id;
            $product->type_id      = $request->type_id;
            $product->maxprice     = $request->maxprice;
        }

        if($request->brand_id != null &&  $request->brand_id != ''){
            $product->brand_id       = $request->brand_id;
        }

        if($request->status_id != null &&  $request->status_id != ''){
            $product->status_id       = $request->status_id;
        }

        if($request->type_id != null &&  $request->type_id != ''){
            $product->type_id       = $request->type_id;
        }

        if($request->filter_id != null &&  $request->filter_id != ''){
            $product->filter_id      = $request->filter_id;
        }
        
        $product->title       = $request->title;
        $product->description = $request->description;
        $product->city_id     = $request->city_id;
        $product->nhood_id    = $request->nhood_id;
        $product->address     = $request->address;
        $product->price       = $request->price;
        //return $request->all();
        $product->update();
        $message = "ad detail updated succefully !!";
        return response()->json($message,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(product $product)
    {
        //
    }

    public function softDelete($id){
        $product = Product::findOrFail($id);
        $product->deleted = true;
        $product->update();
        $message="ad moved to trash";
        return response()->json($message,200);
    }

    public function sold($id){
        $product = Product::findOrFail($id);
        $product->sold = true;
        $product->update();
        $message="ad moved to sold out state";
        return response()->json($message,200);
    }

    public function restore($id){
        $product = Product::findOrFail($id);
        $product->deleted = false;
        $product->update();
        $message="ad recovered succefully !!";
        return response()->json($message,200);
    }


    public function resell($id){
        $product = Product::findOrFail($id);
        $product->sold = false;
        $product->update();
        $message="your ad had been readvertised !!";
        return response()->json($message,200);
    }
}
