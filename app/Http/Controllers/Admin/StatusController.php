<?php

namespace App\Http\Controllers\Admin;
use App\Status;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.status');
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
        
        $status = new Status();
        $status->title = $request->name;
        $status->scategory_id = $request->scategory_id;
        $status->save();
        Cache::flush();
        $message = "status succefully Saved";
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
        $status = Status::where('scategory_id',$id)->get();
        return response()->json($status,200);
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
        
        $status = Status::findOrFail($id);
        $status->title = $request->name;
        $status->scategory_id = $request->scategory_id;
        $status->save();
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
        $status = Status::findOrFail($id);
        $status->delete();
        Cache::flush();
        return response()->json('Status deleted succefully !!',200);
    }
}
