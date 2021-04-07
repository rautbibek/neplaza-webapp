<?php

namespace App\Http\Controllers\Admin;
use App\Feature;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FeatureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.feature');
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
            'name' => 'required',
            'scategory_id'  => 'required'
        ]);
        
        $feature = new Feature();
        $feature->name = $request->name;
        $feature->icon = $request->icon;
        $feature->scategory_id = $request->scategory_id;
        $feature->save();
        Cache::flush();
        $message = "Feature succefully Saved";
        cache::forget('meghamenu');
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
        
        $feature = Feature::where('scategory_id',$id)->get();
        return response()->json($feature,200);
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
            'name' => 'required',
            'scategory_id'  => 'required'
        ]);
        
        $feature = Feature::findOrFail($id);
        $feature->name = $request->name;
        $feature->icon = $request->icon;
        $feature->scategory_id = $request->scategory_id;
        $feature->save();
        Cache::flush();
        $message = "status succefully Saved";
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
        $feature = Feature::findOrFail($id);
        $feature->delete();
        Cache::flush();
        return response()->json('Feature deleted succefully !!',200);
    }
}
