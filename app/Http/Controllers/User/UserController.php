<?php

namespace App\Http\Controllers\User;
use App\User;
use App\Product;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(){
        return $this->middleware('auth');
    }

    public function contact_status(Request $request){
        $contact = User::where('id',Auth::id())->firstOrFail();
        $contact->hide_contact = $request->status;
        $contact->update();
        $message="status changed succefully";
        return response()->json($message,200);
    }

    public function deactivateAccount(Request $request){
        
        $user= User::where('id',Auth::id())->firstOrFail();
        
        $user->account_status = true;
        if($user->update()){
            $products = Product::where('user_id',Auth::id())->get();
            foreach($products as $product){
                $product->deleted = true ;
                $product->update();
            }
            $message= "your account has been deactivated";
            
        } 
        //$this->performLogout($request);
        
        return response()->json($message,200);
    }

    public function updateProfile(UserRequest $request){
        $user = User::where('id',Auth::id())->firstOrFail();
        $user->name = $request->name;
        $user->phone = $request->contact;
        $user->about = $request->about;
        $user->nhood_id = $request->nhood;
        $user->city_id = $request->district;
        $user->update();
        $message="profile updated succefully";
        return response()->json($message,200);
    }

    
    public function myProfile(){
        $user = User::where('id',Auth::id())
              ->with('city','nhood')
              ->firstOrFail();
        return response()->json($user,200);
    }
}
