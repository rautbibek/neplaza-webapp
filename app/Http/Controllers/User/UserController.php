<?php

namespace App\Http\Controllers\User;
use App\User;
use App\Product;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;
//use Intervention\Image\Image;

use Illuminate\Support\Facades\Storage;
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
            Auth::user()->comment()->delete();
            Auth::user()->notifications()->delete();
            $message= "your account has been deactivated";
            
        } 
        //$this->performLogout($request);
        
        return response()->json($message,200);
    }

    public function updateProfile(UserRequest $request){
        $user = User::where('id',Auth::id())->firstOrFail();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->contact;
        $user->about = $request->about;
        $user->nhood_id = $request->nhood;
        $user->city_id = $request->district;
        $user->update();
        $message="profile updated succefully";
        return response()->json($message,200);
    }

    public function updateContact(Request $request){
        $this->validate($request ,[
            'contact' => 'required|min:9 | max:11',
        ]);
        $user = User::where('id',Auth::id())->firstOrFail();
        $user->phone = $request->contact;
        $user->update();
        $message="contact number saved succefully";
        return response()->json($message,200);
    }

    public function updateCover(Request $request){
        $this->validate($request ,[
            'image' => 'required|file|image|mimes:jpeg,jpg,png',
        ]);
        $image = $request->file('image');
        $slug = str_slug(Auth::user()->name);
        if(isset($image)){
                $currentDate = Carbon::now()->toDateString();
                $imagename = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();
                if(!Storage::disk('public')->exists('profile')){
                    Storage::disk('public')->makeDirectory('profile');
                }
                if(Storage::disk('public')->exists('profile/'.Auth::user()->image)){
                    Storage::disk('public')->delete('profile/'.Auth::user()->image);
                }
                //resize the image
                $profile = Image::make($image)->resize(200,150,function($constrain){
                    $constrain->aspectRatio();

                })->stream();
                Storage::disk('public')->put('profile/'.$imagename,$profile);
            }
            else{
                $imagename= '';
        }
        $user = User::findOrFail(Auth::id());
        $user->image = $imagename;
        $user->update();
        $message="profile picture updated succefully";
        return response()->json($message,200);
    }

    public function myProfile(){
        $user = User::where('id',Auth::id())
              ->with('city','nhood')
              ->firstOrFail();
        return response()->json($user,200);
    }

    public function notification(){
        $notification = Auth::user()->unreadNotifications()->get();
        return response()->json($notification,200);
    }

    public function readNotification(){
        $notification = Auth::user()->readNotifications()->take(3)->get();
        return response()->json($notification,200);
    }

    public function read($id){
        Auth::user()->notifications->where('id', $id)->markAsRead();
        return response()->json('readed',200);
    }
}
