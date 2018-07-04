<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;


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
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * --------------------------------------------------------
     *                        Facebook
     * --------------------------------------------------------
     */

    public function redirectToProvider(){
        return Socialite::driver('facebook')->redirect();
    }

   
    public function handleProviderCallback(){

        $user = Socialite::driver('facebook')->user();
        dd($user);

    }

    /**
     * --------------------------------------------------------
     *                      Google
     * --------------------------------------------------------
     */

    
    public function redirectToProviderGoogle(){
        return Socialite::driver('google')->redirect();
    }

    
    public function handleProviderCallbackGoogle(){
        
        $user = Socialite::driver('google')->user();
        dd($user);

    }

    /**
     * --------------------------------------------------------
     *                      Twitter
     * --------------------------------------------------------
     */
    
    public function redirectToProviderTwitter(){
        return Socialite::driver('twitter')->redirect();
    }

    public function handleProviderCallbackTwitter(){
        
        $user = Socialite::driver('twitter')->user();
        return  [$user->token];

    }


    /**
     * --------------------------------------------------------
     *                      Linkedin
     * --------------------------------------------------------
     */
    
    public function redirectToProviderLinkedin(){
        return Socialite::driver('linkedin')->redirect();
    }

    
    public function handleProviderCallbackLinkedin(){
        
        $user = Socialite::driver('linkedin')->user();
        return  [$user->token];

    }
   
}
