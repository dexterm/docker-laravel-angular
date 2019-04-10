<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Hash;
//use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth; 

use Illuminate\Http\Request; 

use Response;
use Illuminate\Support\Facades\Input;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

   // use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
   // protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /*public function __construct()
    {
        //$this->middleware(['guest', 'web']);
    }*/

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    /*protected function validator(array $data)
    {
        return true;
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'c_password' => 'required|same:password', 
        ]);
    }*/

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    public function register(Request $request)
    {

        Log::info('Registering user into db.....: ');
       
        $valid = validator($request->only('email', 'name', 'password','mobile', 'c_password'), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'c_password' => 'required|same:password', 
            'mobile' => 'required|min:10'
        ]);
    
        if ($valid->fails()) {
            $jsonError=response()->json($valid->errors()->all(), 400);
            return \Response::json($jsonError);
        }
    
        $data = request()->only('email','name','password','mobile');
    
        /*$user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'mobile' => $data['mobile']
        ]);*/
    
        $data = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

        // And created user until here.
    
        //$client = Client::where('password_client', 1)->first();
        $client = DB::table('oauth_clients', 3)->first();

        //$client = db::where('oauth_clients', 3)->first();

    
        // Is this $request the same request? I mean Request $request? Then wouldn't it mess the other $request stuff? Also how did you pass it on the $request in $proxy? Wouldn't Request::create() just create a new thing?
    
        $request->request->add([
            'grant_type'    => 'password',
            'client_id'     => $client->id,
            'client_secret' => $client->secret,
            'username'      => $data['email'],
            'password'      => $data['password'],
            'scope'         => null,
        ]);
    

        Auth::user();
        // Fire off the internal request. 
        $token = Request::create(
            'oauth/token',
            'POST'
        );
        return response()->json(['success' => $token], 200); 
        //return \Route::dispatch($token);
        
    }
}
