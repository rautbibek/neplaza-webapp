<?php

namespace App\Http\Controllers\Admin;
use App\Featured;
use App\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FeaturedController extends Controller
{
    public function save(Request $request){
        
        $this->validate($request,[
            'expire_date' => 'required',
            'product_id'  => 'required|unique:featureds'
        ]);

        $featured = new Featured();
        $featured->expire_date = $request->expire_date;
        $featured->product_id = $request->product_id;
        $featured->save();
        
        return response()->json('Add succefully add to featured list',200);
    }

    public function delete($id){
        $feature = Featured::findOrFail($id);
        $feature->delete();
        return response()->json('Add succefully removed from featured list',200);
    }
    
}
