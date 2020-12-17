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
        if($provider == 'facebook' || $provider =='google' || $provider == 'twitter'){
          return Socialite::driver($provider)->redirect();
        }else{
          return redirect('/');
        }
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider)
    {

        $userSocial = Socialite::driver($provider)->user();
        $isUser = User::where('email',$userSocial->email)->first();
        if($isUser){
            Auth::login($isUser);
            return redirect()->route('welcome');
        }
        $user = User::where('provider_id',$userSocial->id)->first();
        if($user){
            Auth::login($user);
        }else{

            $newuser = new User;
            $newuser->role_id  = 3;
            $newuser->name = $userSocial->name;
            $newuser->username = str_slug($userSocial->name).'-'.uniqid();
            if($userSocial->email == null || $userSocial->email==""){
                $newuser->email = uniqid();
            }else{
                $newuser->email = $userSocial->email;
            }
            if($provider =='google'){
              $newuser->email_verified_at = date('Y-m-d H:i:s');
            }
            $newuser->image = $userSocial->avatar;
            $newuser->login_provider = $provider;
            $newuser->provider_id = $userSocial->id;
            //$newuser->password = bcrypt('neplaza2311');
            //$newuser->remember_token = rememberToken();

            $newuser->save();
            Auth::login($newuser);
        }
        return redirect()->intended();
        // $user->token;
    }
    public function username(){
      $login = request()->input('email');
      $fieldType = filter_var($login,FILTER_VALIDATE_EMAIL)?'email':'phone';
      request()->merge([$fieldType =>$login]);
      return $fieldType;
    }
}
