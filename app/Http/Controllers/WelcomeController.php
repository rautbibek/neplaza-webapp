<?php

namespace App\Http\Controllers;
use App\City;
use App\Nhood;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index(){
        return view('welcome');
    }
    
    public function check(){
        return view('check');
    }

    public function city(){
        $city= City::select('id','name')->orderBy('name','ASC')->get();
        return response()->json($city,200);
    }

    public function nhood($id){
        $nhood= Nhood::select('id','name')->where('city_id',$id)->orderBy('name','ASC')->get();
        return response()->json($nhood,200);
    }
}
