<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use App\Http\Controllers\OctaAPIController;
use App\Http\Controllers\Api\BaseAPIController;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserOrganizationMaster;
use App\Models\OctaUserDetail;
use App\Models\UserAuthMaster;
use App\Models\District;
use App\Models\State;
use App\Models\Talukas;
use App\Models\Pincode;


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

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    public function showRegistrationForm(Request $request)
    {
        // $referer = User::where('referer', $request->ref)->first();

        // return view('auth.register', compact('referer'));
        $data['state'] = State::orderBy('state_name')->where('state_status',0)->get();
        return view('auth.register')->with(['master_data' => $data]); 
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
            'organization_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'organization_name' => $data['organization_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function register(Request $request)
    {
        // echo "register";die;
        // exit();
            $userData = $request->all();
        // echo"<pre>";print_r($userData);die;
        $rules = array('email' => 'unique:users,email','phone' => 'unique:users,phone');
        $messages = [
            'email.unique'    => 'User already exist with this email. Try another.',
            'phone.unique'     => 'User already exist with this Phone no. Try another.',
    
        ];
        $validator = Validator::make($userData, $rules,$messages);

        if ($validator->fails())
        {
            $errors = $validator->errors()->first();                
            return redirect()->back()->with('error',$errors);
        }
        else
        {
        
            if($request->imageurl != "")
            {   
                $imageurl = $this->UploadImage($file = $request->imageurl,$path = config('global.file_path.user_profile'));
            }
            else{
                $imageurl =$request->image64;
            }
            $userData['imageurl'] = $imageurl;
            $userData['login_type'] = 2;
            // echo "<pre>";
            // print_r($userData);die;
            $userData['password'] = Hash::make($request->password);
            $user = User::create($userData);
            $token = $user->createToken(env('APP_NAME'));
            $user->token = $token->accessToken;
            $oauth_access_token_id = $token->token->id;
            $user_auth_id = $this->GenerateUniqueRandomString($table='user_auth_master', $column="user_auth_id", $chars=32);
            $auth_input = array(
                'user_auth_id'      => $user_auth_id,
                'user_id'           => $user->id,
                'oauth_access_token_id' => $oauth_access_token_id,
                'device_type'  => 3,
                'device_token' => 'webTestToken',
            );
            UserAuthMaster::create($auth_input);
            //    $this->guard()->login($user);
                // $user_data = Auth::user();
                return view('web.thankyou');   
        }
    }  
}
