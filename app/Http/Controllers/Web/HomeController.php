<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PasswordReset;
use App\Models\User;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function showResetPasswordForm($token) 
    {
        // echo 'in'; die;
        $tokenData = PasswordReset::where('token',$token)->first();
        // echo "<pre>";
        // print_r($tokenData); die;
        if ($tokenData != null || $tokenData != '') {
        return view('forgotpassword.forgetPasswordLink', ['token' => $token]);
        } 
        else {
        return view('forgotpassword.forgetPasswordLink', ['errormessage' =>  'Invalid token!']);
        }      
    }

    public function submitResetPasswordForm(Request $request)
    {
        $token = PasswordReset::where('token',$request->token)->first();
        if ($token != null || $token != '') {  
            $email = PasswordReset::where('token',$request->token)->pluck('email');
            $request->validate([
                'password' => 'required|string|min:6',
                'password_confirmation' => 'required|same:password'
            ]);

            $updatePassword = PasswordReset::where(['email' => $email[0],'token' => $request->token])->first();

            if(!$updatePassword){
                return back()->withInput()->with('error', 'Invalid token!');
            }
            else{
                $input = $request->all();
                // print_r($input);exit();
                $user = User::where('email', $email[0])->first();
                $input['octa_registration_id'] = $user->OctaUserDetail->octa_registration_id;
                $octa_con = new OctaAPIController;        
                $octa_data = $octa_con->OctaResetPassword($input);
                if($octa_data['flag'] == 'success')
                {
                    if(isset($octa_data['data']->errorCode))
                    {   
                        return back()->withInput()->with('errormessage', $octa_data['data']->errorCauses[0]->errorSummary);
                    }
                    else
                    {
                        // echo "<pre>";
                        // print_r($user->user_type); die;

                        // return back()->withInput()->with('success', 'Your password has been changed!');
                        User::where('email', $email[0])->update(['password' => bcrypt($request->password)]);
                        
                        PasswordReset::where(['email'=> $email[0]])->delete(); 

                        if($user->user_type == 4){

                            return redirect('/login')->with('message', 'Your password has been changed!');
                        }
                        else if($user->user_type == 1){
                            return redirect('/admin')->with('message', 'Your password has been changed!');
                        }
                        else{

                            return redirect('homepage')->with('message', 'Your password has been changed!');
                        }
                        // return back()->withInput()->with('message', 'Your password has been changed!');
                
                    }
                }
            }
        
        }
        else{
        return redirect()->back()->with('errormessage', 'Invalid token!'); 
        }
    }
}
