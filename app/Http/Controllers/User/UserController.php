<?php

namespace App\Http\Controllers\User;
use App\Mail\VerifyMail;
use Illuminate\Support\Facades\Mail;
use App\User;
use App\Product;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Hash;
//use Intervention\Image\Image;
use Illuminate\Support\Facades\Session;
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

    public function account_completion(Request $request){
        $this->validate($request ,[
            'password' => 'required|min:6',
            'confirm_password' => 'required_with:password|same:password|min:6'
        ]);
        $user = User::where('id',Auth::id())->firstOrFail();
        $user->password = bcrypt($request->password);
        $user->update();
        return response()->json('Password updated succefully');
    }

    public function deactivateAccount(Request $request){

        $user= User::where('id',Auth::id())->firstOrFail();

        $user->account_status = true;
        if($user->update()){
            $products = Product::where('user_id',Auth::id())->get();
            foreach($products as $product){
                $product->deleted = true ;
                event(new ProductDeletedEvent($product));
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
        $user->nhood_id = $request->nhood;
        $user->city_id = $request->district;
        $user->about = $request->about;
        $user->update();
        $message="profile updated succefully";
        return response()->json($message,200);
    }


    public function send_otp(Request $request){
      $this->validate($request ,[
          'contact_number' => 'required|numeric|digits:10|unique:users,phone,'.Auth::id(),
      ]);

      if($request->contact_number ==  Auth::user()->phone && Auth::user()->phone_verified == true){
        return response()->json(['errors','Provided contact number is already verified'],422);
      }
      $otp = rand(10000,99999);
      Session::put('OTP',$otp);
      Session::put('contact_number',$request->contact_number);
      $authKey= config('app.sms_api');
      $senderId='31001';
      $data = array(
        'auth_token' => $authKey,
        'from'=>$senderId,
        'to' =>$request->contact_number,
        'text'=>'Your mobile verification code for '.config('app.name').' is '.$otp,
      );


      $url = config('app.sms_api_url') ;
      $ch = curl_init();

      curl_setopt_array($ch, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST =>true,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $data,
      ));

      $response = curl_exec($ch);
      $err = curl_error($ch);

      if ($err) {
      echo "cURL Error #:" . $err;
      }
      curl_close($ch);
      return response()->json(['success','Verification code succefully sent to your phone. '],200);
    }

    public function updateContact(Request $request){
        $this->validate($request ,[
            'otp' => 'required',
        ]);
        if($request->otp == $request->session()->get('OTP')){
          $user = User::where('id',Auth::id())->firstOrFail();
          $user->phone = $request->session()->get('contact_number');
          $user->phone_verified = true;
          $user->update();
          $request->session()->forget('contact_number');
          $request->session()->forget('OTP');
          $message="Contact number verified succefully";
          return response()->json(['success',$message],200);
        }else{
          $message="OTP Code doesn`t match";
          return response()->json(['error',$message],200);
        }


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
              ->firstOrFail()->makeVisible(['phone','email']);
        return response()->json($user,200);
    }

    public function notification(){
        $notification = Auth::user()->unreadNotifications()->get();
        return response()->json($notification,200);
    }

    public function markAllAsRead(){
        Auth::user()->notifications()->delete();;
    }

    public function read($id){
        Auth::user()->notifications->where('id', $id)->markAsRead();
        return response()->json('readed',200);
    }

    public function changePassword(Request $request){
        $this->validate($request, [
          'old_password' => 'required|min:6',
          'password'      => 'required|min:6',
          'password_confirmation' =>'required_with:password|same:password|min:6',
        ]);
        $hashedPassword= Auth::user()->password;
        if(Hash::check($request->old_password,$hashedPassword)){
          if(!Hash::check($request->password,$hashedPassword)){
            $user = User::find(Auth::id());
            $user->password = Hash::make($request->password);
            $user->save();
            $message =['success','Password Changed Succefully !'];
            return response()->json($message);
          }
          else
          {
            $message =['error','New password cannot be same as old password'];
            return response()->json($message,200);
          }
        }
        else
        {
          $message =['error','Invalid Old Password'];
          return response()->json($message);

        }
      }

      public function verify_email(Request $request){
        $this->validate($request ,[
            'email' => 'required| email |unique:users,email,'.Auth::id(),
        ]);
        $user = User::where('id',Auth::id())->firstOrFail();


        $activation_code = rand(10000,99999);
        Session::put('ACTIVE_CODE',$activation_code);
        Session::put('email',$request->email);
        Mail::to($request->email)->queue(new VerifyMail($activation_code));
        //$user->sendEmailVerificationNotification();
        return response()->json('Verification code sent succefully. Please Check Your Email.');
    }

    public function email_verified_at(Request $request){
      $this->validate($request ,[
          'verification_code' => 'required',
      ]);
      $user = User::where('id',Auth::id())->firstOrFail();


      if($request->verification_code == $request->session()->get('ACTIVE_CODE')){
          $user->email_verified_at = date('Y-m-d H:i:s');
          $user->email = session()->get('email');
          $user->update();
          $request->session()->forget('ACTIVE_CODE');
          $request->session()->forget('email');
          return response()->json(['success','Email verified succefully.'],200);
      }
      return response()->json(['error','Verification code doesn`t match.'],200);
  }
}
