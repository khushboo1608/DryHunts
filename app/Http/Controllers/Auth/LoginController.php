<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use App\Http\Controllers\Controller;
use App\Http\Controllers\OctaAPIController;
use App\Models\User;
use App\Models\UserAuthMaster;
use Illuminate\Support\Facades\Session;

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

    use AuthenticatesUsers {
        logout as performLogout;
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function showLoginForm()
    {
        // echo "hi";exit();
       if(Auth::user())
       {
            return Redirect('login');
       }
       else
       {
            return view('auth.admin.login');
       }
        
    }
    public function login(Request $request)
    {   
        // echo '<pre>'; 
        $input = $request->all();
        // print_r($input); die;
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);
        // $user = User::where('email',$request->email)->where('is_disable',0)->first();
        $user = User::where('email',$input['email'])->orwhere('phone',$input['email'])->where('is_disable',0)->first();
        // print_r($user); die;
        if($user)
        {
            // echo "if";die;
            if($request->login_type == 'web')
            {
                // echo "web";die;
                if ($request->login_type == 'web' &&  $user->login_type == 2) {
                    if($user->is_verified == 1){
                        if(auth()->attempt(array('email' => $input['email'], 'password' => $input['password'])))
                        {
                            // echo 'if';die;
                                Auth::loginUsingId($user->id); 
                                return Redirect('/webhome');
                            
                        }else{
                            // echo 'else';die;
                            if(auth()->attempt(array('phone' => $input['email'], 'password' => $input['password'])))
                            {
                                Auth::loginUsingId($user->id); 
                                return Redirect('/webhome');

                            }
                            else{

                                return back()->withInput()->with('error', 'Invalid email or password.');
                            }
                        }
                    }
                    else{
                        return back()->withInput()->with('error', 'Your profile is under review.');
                    }
                    
            }
            else{
                return back()->withInput()->with('error', 'User could not found with this credential.');
                
            }
            }
            else{
                // echo 'admin';die;

                
                    // echo 'admin';die;
                    // echo '<pre>'; 
                    // print_r(auth()->user());die;
                    // session()->put('AdminRole', $user->login_type);
                    if ($user->login_type == 1) {
                        if(auth()->attempt(array('email' => $input['email'], 'password' => $input['password'])))
                        {
                            // echo 'if';die;
                        Auth::guard('admin')->loginUsingId($user->id);
                        session()->put('AdminRole', $user->login_type);
                            return redirect('admin/home');
                        }else{
                            return back()->withInput()->with('message', 'Admin could not found with this credential.');
                        }
                    }
                    elseif ($user->login_type == 3) {
                        // echo 'elseif';die;
                        if(auth()->attempt(array('email' => $input['email'], 'password' => $input['password'])))
                        {
                            Auth::guard('admin')->loginUsingId($user->id);
                            session()->put('AdminRole', $user->login_type);
                            return redirect('admin/order');
                        }else{
                            return back()->withInput()->with('message', 'Admin could not found with this credential.');
                        }
                    }
                   elseif ($user->login_type == 4) {
                        // echo 'elseif';die;
                        if(auth()->attempt(array('email' => $input['email'], 'password' => $input['password'])))
                        {
                            Auth::guard('admin')->loginUsingId($user->id); 
                            session()->put('AdminRole', $user->login_type);              
                            return redirect('admin/order');
                        }else{
                            return back()->withInput()->with('message', 'Admin could not found with this credential.');
                        }
                }else{
                    return back()->withInput()->with('message', 'Invalid email or password.');
                }
            }
        }
        else
        {
            return back()->withInput()->with('error', 'User not found with this email.');
        }
          
    }
    public function logout(Request $request)
    {
        if(isset($request->is_web))
        {
            $this->performLogout($request);
            // return Redirect('userlogin');
            // Session::flush();
            return Redirect('/');
        }
        else
        {
            // Session::flush();
            $this->performLogout($request);
            return Redirect('admin');
        }
    }
    
}
