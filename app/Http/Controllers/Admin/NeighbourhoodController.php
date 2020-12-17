<?php

namespace App\Http\Controllers\Admin;
use App\Nhood;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NeighbourhoodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.neighbourhood');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|unique:nhoods',
            'city_id' =>'required'
        ]);

        $slug = str_slug($request->name);
        $nhood = new Nhood();
        $nhood->name = $request->name;
        $nhood->city_id = $request->city_id;
        $nhood->slug = $slug;
        $nhood->save();
        return response()->json('metro/vdc created succefully',200);
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
            'name' => 'required|unique:nhoods,name,'.$id,
            'city_id' =>'required'
        ]);
        //return $request;
        $slug = str_slug($request->name);
        $nhood = Nhood::findOrFail($id);
        $nhood->name = $request->name;
        $nhood->city_id = $request->city_id;
        $nhood->slug = $slug;
        $nhood->save();
        return response()->json('metro/vdc updated succefully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $nhood = Nhood::findOrFail($id);
      $nhood->delete();
      return response()->json('metro/vdc deleted succefully !!');
      
    }
}
