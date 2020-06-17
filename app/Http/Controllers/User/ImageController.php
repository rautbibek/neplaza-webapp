<?php

namespace App\Http\Controllers\User;
use App\Product_image;
use App\Product;
use App\Http\imageExtractor\ImageResizer;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ImageController extends Controller
{
     public function __construct(ImageResizer $imageResizer){
        $this->imageResizer = $imageResizer;
    }

    public function delete($id){
        $image = Product_image::findOrFail($id);
        //return $image;
        $this->authorize('delete', $image);
        //return $image_id;
        //$image = Product_image::findOrFail($id);
        if(Storage::disk('public')->exists('product/'.'/'.$image->image)){
            Storage::disk('public')->delete('product/'.$image->image);
        }
        if(Storage::disk('public')->exists('thumb/'.'/'.$image->image)){
            Storage::disk('public')->delete('thumb/'.'/'.$image->image);
        }
        $image->delete();
        $message= "image deleted succefully";
        return response()->json($message,200);
        
    }

    public function store(Request $request){
        
        $this->validate($request,[
        'product_id'    => 'required',
        'image'     => 'required',
        'image.*'   =>'image|mimes:jpeg,png,jpg,gif,svg|max:20648',
      ]);
        if($request->hasFile('image')){
            return $this->imageResizer->resizeImage($request->image,$request->product_id);
        }
        $message = "image uploaded succefully";
        return response()->json($message,200);
    }
}
