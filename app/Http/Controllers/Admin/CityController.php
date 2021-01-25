<?php

namespace App\Http\Controllers\Admin;
use App\City;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.city');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $city = City::orderBy('name','asc')->withCount('product')->get();
        return response()->json($city,200);
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
        'name' => 'required|unique:cities',
      ]);

      $slug = str_slug($request->name);
      $city = new City();
      $city->name = $request->name;
      $city->slug = $slug;
      $city->save();
      cache::forget('city');
      return response()->json('District succefully Saved',200);
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
      $this->validate($request,[
        'name' => 'required|unique:cities,name,'.$id,
      ]);

      $city = City::find($id);
      $city->name = $request->name;
      $city->show = $request->show;
      $city->slug = str_slug($request->name);
      $city->save();
      cache::forget('city');
      return response()->json('district updated succefully !!',200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $city=City::findOrFail($id);
      if($city->product->count()<1){
        $city->delete();
        return response()->json('district deleted succefully');
      }
      
      return response()->json('this district has '. $city->product->count() .' ads cannot delete the city');
    }
}
