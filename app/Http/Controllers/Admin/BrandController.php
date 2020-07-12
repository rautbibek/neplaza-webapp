<?php

namespace App\Http\Controllers\Admin;
use App\Brand;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.brand');
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
    public function store(Request $request)
    {
      $this->validate($request,[
        'name' => 'required|unique:brands',
        'scategory_id'  => 'required'
      ]);
      $image = $request->file('image');
      $slug = str_slug($request->name);
      if(isset($image)){
        $currentDate = Carbon::now()->toDateString();
        $imagename = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();
        
        if(!Storage::disk('public')->exists('thumb')){
          Storage::disk('public')->makeDirectory('thumb');
        }
        $thumb = Image::make($image)->resize(230,150)->stream();
        Storage::disk('public')->put('thumb/'.$imagename,$thumb);
      }else{
          $imagename = "";
      }
      
      $brand = new Brand();
      $brand->name = $request->name;
      $brand->brand_logo= $imagename;
      $brand->scategory_id = $request->scategory_id;
      $brand->save();
      $message = "brand succefully Saved";
      return response()->json($message,200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $brand = Brand::where('scategory_id',$id)->get();
        return response()->json($brand,200);
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
        $this->validate($request,[
            'name' => 'required|unique:brands,name,'.$id,
            'scategory_id'  => 'required'
        ]);
        $image = $request->file('image');
        $slug = str_slug($request->name);
        $brand = Brand::findOrFail($id);
        if(isset($image)){
            
          $currentDate = Carbon::now()->toDateString();
          $imagename = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();
          
          if(!Storage::disk('public')->exists('thumb')){
            Storage::disk('public')->makeDirectory('thumb');
          }
          if(Storage::disk('public')->exists('thumb/'.$brand->image)){
            Storage::disk('public')->delete('thumb/'.$brand->image);
          }
          $thumb = Image::make($image)->resize(230,150)->stream();
          Storage::disk('public')->put('thumb/'.$imagename,$thumb);
        }
        else{
          $imagename = $brand->brand_logo;
          
        }
      
      $brand->name = $request->name;
      $brand->brand_logo= $imagename;
      $brand->scategory_id = $request->scategory_id;
      $brand->save();
      $message = "brand succefully Updated";
      return response()->json($message,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $brand = Brand::find($id);
            
            if(Storage::disk('public')->exists('thumb/'.'/'.$brand->image)){
                Storage::disk('public')->delete('thumb/'.'/'.$brand->image);
            }
            $brand->delete();
            return response()->json('Brand deleted succefully ',200);
        }
}
