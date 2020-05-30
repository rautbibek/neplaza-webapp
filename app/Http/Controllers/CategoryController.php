<?php

namespace App\Http\Controllers;
use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function category(){
        $category = Category::select('id','name','slug','icons')->where('visible',true)->get();
        return response()->json($category,200);
    }

    public function subCategory(){
        $subcategory = Category::select('id','name','slug','icons')->with('scategory')->get();
        return response()->json($subcategory,200);
        
    }
}
