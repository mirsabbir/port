<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use App\Jobs\SendEmailVerification;
use Illuminate\Auth\Events\Registered;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    |                       Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    public function showRegistrationForm(Request $request)
    {
        /**
         * if status is failed 
         * return them to 'verify page'
         * 
         */
        if(session()->has('failed')){
            return view('auth.verify');
        }

        /**
         * if status is success
         * return to the 'enter details page'
         * 
         */
        if(session()->has('success')){
            return view('auth.register');
        }

        

        /**
         * -----------------------------------------------------------
         *          GET request /register?code=XXXXXX (last step)
         * -----------------------------------------------------------
         * 
         *  second step ---> third step
         *  HEAD contains 'code'
         *  scenario -
         *  1. someone types code in the input box
         *  2. someone enters address in the addressbar with HEAD
         *  
         *  response -
         *  either return them the 'enter details page' (name, password, etc)
         *  or a failed response
         *  
         */
        if($request->has('code')){
            /** 
             * If HEAD contains 'code' but session does not
             * scenario -
             * 1. someone enters address in the addressbar with HEAD,
             * but they have no code saved in the session
             * 2. someone enters correct code but 120 min later
             * their code deleted from session
             * 
             * return them 'enter email page'
             * No message required
             * 
             */
            if(!session()->has('code')){
                return view('auth.email');
            }
            /**
             * 
             * If they have code
             * 
             * check if both code equals
             * ----------------------------------------------
             *       if equal         |     if not equal
             * ----------------------------------------------
             *  session -> success    |    session -> failed
             *     ( verified )       |     ( wrong code )
             *                        |
             *                        |
             * 
             * 
             * 
             */

            if($request->code==session('code')){
                session(['success'=>'verified']);
                $emailFromSession = session('email');
                session(['email' => $emailFromSession]);
                return view('auth.register');
            }  
            else{
                if(session()->has('email')){
                    session()->flash('failed','Wrong Code');
                    return redirect('register');
                } else {
                    return redirect()->route('register');
                }
            }
        }



        

        /**
         * ---------------------------------------------------------------
         *      GET request /register?email=XXXXXX@XX.com (Second step)
         * ---------------------------------------------------------------
         * 
         * 
         *  first step --> second step
         *  when email is present in HEAD
         * 
         *
         * 
         * 
         */
        
         /**--------------------------------------------
         * 
         * validate this email
         * 
         */
        if($request->has('email')){
            
            $validatedData = $request->validate([
                'email' => 'email|required|unique:users',
            ]);



            // generate a code
            $code = 5;
            while(strlen($code)<6){
                $code = rand() + 89 * 19 + 37;
                $code %= 100000;
                $code = '5' . $code;
            }

            session(['email' => $request->email]);
            session(['code' => $code]);
        
            SendEmailVerification::dispatch($request->email, $code);

            session(['step2' => 'user was on step two']);
            
            return view('auth.verify');
        }
        

        /**
         * was on step two ? redirect them to step2
         */
        if(session()->has('step2')){
            return view('auth.verify');
        }

        /**
         * ------------------------------------------------
         *                  First step
         * ------------------------------------------------
         * 
         *  return view of entering email
         * 
         */
        return view('auth.email');
    }

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
            'terms' => 'accepted',
            'email' => 'email|unique:users'
        ]);
    }





    
    
    protected $mail;


    
    /**
     * --------------------------------------------------------------
     *              POST request /register ( last step )
     * --------------------------------------------------------------
     */


    public function register(Request $request)
    {
        /**----------------------------------------------------------
         *              Google recaptcha verification
         * ----------------------------------------------------------
         *    
         * Go to https://www.google.com/recaptcha/admin#list -->
         *'Register a new site' for make new API 'key' and 'secret'.
         * reference --> https://www.youtube.com/watch?v=a3ubiUOAHTc
         * 
         * 
         */
        $client = new \GuzzleHttp\Client();
        $token = $request->input('g-recaptcha-response');
        $res = $client->post('https://www.google.com/recaptcha/api/siteverify', [
            'form_params' => [
            'secret' => '6Ld8P2IUAAAAAK_zLYcF0MXAwxcaQzQAzxxGBxz7',
            'response' => $token,
            ]
        ]);
        $result = json_decode($res->getBody()->getContents());
        if(!$result->success){
            $request->session()->flash('google', $result->{'error-codes'}[0]);
            return redirect()->back();
        }

        /**
         * ----------------------------------------------------------
         *                 Google recaptcha verified
         * ----------------------------------------------------------
         * 
         * 
         * 
         * 
         */
        

        
        /**
         * If User delays more than 120 miniutes we will loose
         * Session data (verified email) 
         * so we check Session has success and email
         * 
         * 
         */

        if(! ($request->session()->has('success') )){
            if(! $request->session()->has('email'))
                return redirect()->route('register');
        }

        
        
        $this->mail = session('email');
        

        $arr = $request->all();
        $arr['email'] = $this->mail;
        
        $this->validator($arr)->validate();

        session()->flush();
        
        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        return $this->registered($request, $user)
                        ?: redirect($this->redirectPath());
    }
    
    
    
    
    
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $this->mail,
            'password' => Hash::make($data['password']),
        ]);
    }
}
