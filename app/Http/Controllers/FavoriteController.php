<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
  public function __construct(){
    return $this->middleware('auth');
  }

  public function add($id){
    $user = Auth::user();
    $isfavorite = $user->favourit_products()->where('product_id',$id)->count();
    if($isfavorite == 0){
      $user->favourit_products()->attach($id);
    }else{
      $user->favourit_products()->detach($id);
    }
  }
}
