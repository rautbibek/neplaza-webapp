<?php

namespace App\Http\Controllers\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider)
    {
        $userSocial = Socialite::driver($provider)->user();
        $user = User::where('email',$userSocial->email)->first();
        if($user){
            Auth::login($user);
        }else{
            //dd($userSocial);
            $newuser = new User;
            $newuser->role_id  = 3;
            $newuser->name = $userSocial->name;
            $newuser->username = str_slug($userSocial->name);
            $newuser->email = $userSocial->email;
            $newuser->image = $userSocial->avatar;
            $newuser->password = bcrypt('neplaza2311');
            //$newuser->remember_token = rememberToken();
            $newuser->save();
            Auth::login($newuser);
        }
        return redirect()->route('welcome');
        // $user->token;
    }
}
