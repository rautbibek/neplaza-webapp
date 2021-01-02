<?php

namespace App\Http\Controllers;
use App\Scategory;

use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function subcategory($slug){
        $subcategory = cache()->remember($slug,60*60*24,function() use ($slug){ 
            return Scategory::where('slug',$slug)->with('category','brand','type','status','filter','filter_1','filter_2','filter_3')->firstOrFail();
        });
       return response()->json($subcategory,200);
    }

    public function otherSub($slug){
        $subcategory= Scategory::where('slug',$slug)
                     ->with('category','brand','type','status','filter','filter_1','filter_2','filter_3')
                     ->get();
        return response()->json($subcategory,200);
    }
}
