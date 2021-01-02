<?php

namespace App\Http\Controllers\Admin;
use App\Urgent;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UrgentController extends Controller
{
    public function save(Request $request){

        $this->validate($request,[
            'expire_date' => 'required',
            'product_id'  => 'required|unique:urgents'
        ]);

        $urgent = new Urgent();
        $urgent->expire_date = $request->expire_date;
        $urgent->product_id = $request->product_id;
        $urgent->save();
        
        return response()->json('Add succefully add to Urgent selling list',200);
    }

    public function delete($id){
        $urgent = Urgent::findOrFail($id);
        $urgent->delete();
        
        return response()->json('Add succefully removed from urgent selling list',200);
    }
}
