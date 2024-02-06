<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use DB;
use Hash;
use App\Http\Controllers\OctaAPIController;
use App\Models\User;
use App\Models\PasswordReset;
use App\Models\OctaUserDetail;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
   

    // public function reset(Request $request)
    // {
      
    //     $request->validate([
    //         'email' => 'required|email|exists:users',
    //         'password' => 'required|string|min:6|confirmed',
    //         'password_confirmation' => 'required'
    //     ]);
        
    //     $updatePassword = DB::table('password_resets')
    //                         ->where([
    //                           'email' => $request->email])
    //                         ->first();
    
    //     if(!$updatePassword)
    //     {
    //         return back()->withInput()->with('error', 'Invalid token!');
    //     }
    //     else
    //     {

    //         if(!Hash::check($request->token,$updatePassword->token) == true)
    //         {
    //             return back()->withInput()->with('error', 'Invalid token!');
    //         }
    //     }
    //     $input = $request->all();
    //     // print_r($input);exit();
    //     $user = User::where('email', $request->email)->first();
    //     $input['octa_registration_id'] = $user->OctaUserDetail->octa_registration_id;
    //     $octa_con = new OctaAPIController;        
    //     $octa_data = $octa_con->OctaResetPassword($input);
    //     if($octa_data['flag'] == 'success')
    //     {
    //         if(isset($octa_data['data']->errorCode))
    //         {   
    //             return back()->withInput()->with('error', $octa_data['data']->errorCauses[0]->errorSummary);
    //         }
    //         else
    //         {
    //             DB::table('password_resets')->where(['email'=> $request->email])->delete();
    //             return redirect('/login')->with('message', 'Your password has been changed!');
    //             // return back()->withInput()->with('success', 'Your password has been changed!');
    //         }
    //     }
    // }
}
