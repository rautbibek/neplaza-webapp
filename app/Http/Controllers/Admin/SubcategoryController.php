<?php

namespace App\Http\Controllers\Admin;
use App\Scategory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.subcategory');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subcategory = Scategory::orderBy('category_id','asc')->get();
        return response()->json($subcategory,200);
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
        'category_id' => 'required',
      ]);

      $scategory = new Scategory();
      $scategory->name = $request->name;
      $scategory->slug = str_slug($request->name).'-'.uniqid();
      $scategory->url = $request->url;
      $scategory->category_id = $request->category_id;
      $scategory->save();
      return response()->json('new subcategory added succefully ',200);
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
          'name' => 'required',
          'category_id' =>  'required'
      ]);
      $scategory = Scategory::find($id);
      $scategory->name = $request->name;
      $scategory->slug = str_slug($request->name).'-'.uniqid();
      $scategory->url = $request->url;
      $scategory->category_id = $request->category_id;
      $scategory->update();
      
      return response()->json('subcategory updated succefully ',200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $scategory = Scategory::find($id);
      $scategory->delete();
      return response()->json('Subcategory Deleted succefully',200);
    }
}
