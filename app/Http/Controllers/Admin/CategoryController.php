<?php

namespace App\Http\Controllers\Admin;
use App\Category;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.category');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::with(['scategory'=>function($q){
          $q->orderBy('product_count','desc');
          $q->withCount('product');
        }])
                             ->orderBy('product_count','desc')
                             ->withCount('product')
                             ->get();
                             foreach ($category as $key => $cat) {
                              $c = Category::where('id',$cat->id)->update(['product_count'=>$cat->product_count]);
                            }
        return response()->json($category,200);
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
        'name' => 'required|unique:categories',
        'image'=> 'required|image|mimes:jpeg,png,jpg,gif,svg,bmp|max:2048',
        'icon' => 'required',
        'url'  => 'required'
      ]);
      $image = $request->file('image');
      $slug = str_slug($request->name);
      if(isset($image)){
        $currentDate = Carbon::now()->toDateString();
        $imagename = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();
        if(!Storage::disk('public')->exists('category')){
          Storage::disk('public')->makeDirectory('category');
        }
        //resize the image
        $category = Image::make($image)->resize(1600,579)->stream();
        Storage::disk('public')->put('category/'.$imagename,$category);

        if(!Storage::disk('public')->exists('thumb')){
          Storage::disk('public')->makeDirectory('thumb');
        }
        $thumb = Image::make($image)->resize(230,150)->stream();
        Storage::disk('public')->put('thumb/'.$imagename,$thumb);
      }
      else{
        $imagename= 'default.png';
      }
      $category = new Category();
      $category->name = $request->name;
      $category->slug = $slug;
      $category->image= $imagename;
      $category->icons = $request->icon;
      $category->url = $request->url;
      $category->save();
      Cache::forget('menu-category');
      Cache::forget('meghamenu');
      $message = "Category succefully Saved";
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
        //
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
      //return request()->name;
        $this->validate($request,[
            'name' => 'required|unique:categories,name,' . $id,
            //'image'=> 'mimes:jpeg,png,jpg,gif,svg,bmp',
            'icon' => 'required',
            'url' => 'required',
        ]);
        $image = $request->file('image');
        $slug = str_slug($request->name);
        $category = Category::find($id);
        if(isset($image)){
          $currentDate = Carbon::now()->toDateString();
          $imagename = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();
          if(!Storage::disk('public')->exists('category')){
            Storage::disk('public')->makeDirectory('category');
          }

          if(Storage::disk('public')->exists('category/'.$category->image)){
            Storage::disk('public')->delete('category/'.$category->image);
          }
          //resize the image
          $categoryImage = Image::make($image)->resize(1600,579)->stream();
          Storage::disk('public')->put('category/'.$imagename,$categoryImage);

          if(!Storage::disk('public')->exists('thumb')){
            Storage::disk('public')->makeDirectory('thumb');
          }
          if(Storage::disk('public')->exists('thumb/'.$category->image)){
            Storage::disk('public')->delete('thumb/'.$category->image);
          }
          $thumb = Image::make($image)->resize(230,150)->stream();
          Storage::disk('public')->put('thumb/'.$imagename,$thumb);
        }
        else{
          $imagename= $category->image;
        }
        $category->name = $request->name;
        $category->slug = $slug;
        $category->image= $imagename;
        $category->visible = $request->show;
        $category->icons = $request->icon;
        $category->url = $request->url;
        $category->update();
        Cache::forget('menu-category');
        Cache::forget('meghamenu');
        return response()->json('category updated succefully ',200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $category = Category::find($id);
        if($category->product->count()< 1){
          if(Storage::disk('public')->exists('category/'.'/'.$category->image)){
            Storage::disk('public')->delete('category/'.$category->image);
          }
          if(Storage::disk('public')->exists('thumb/'.'/'.$category->image)){
            Storage::disk('public')->delete('thumb/'.'/'.$category->image);
          }
          $category->delete();
          Cache::forget('menu-category');
          Cache::forget('meghamenu');
          return response()->json('Category item deleted succefully ',200);
      }
      return response()->json('Cannot deleted this category it contains '.$category->product->count().' ads',200);
    }
}
