<?php

namespace App\Http\Controllers\Auth;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminLoginController extends Controller
{
    public function __construct(){
        $this->middleware('guest:admin');
    }

    public function adminLoginForm(){
        return view('auth.adminLogin');
    }

    public function login(Request $request){
        //return $request->email;
        //validate the  login form
        $this->validate($request,[
            'email' => 'required | email | exists:admins',
            'password' => 'required | min:6'
        ]);
        
        //attemtp the logged the user in
        if(Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password],$request->remember)){
            //if succeful then redirect
            return redirect()->intended(route('admin.dashboard'));
        }
        //return if unsucceful
        return redirect()->back()->withInput($request->only('email','remember'));

    }

    
}
