<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use App\Models\User;
use App\Mail\ForgotPasswordMail;
use Carbon\Carbon;
use Mail;
use Illuminate\Support\Str;
use App\Models\PasswordReset;
use Session;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\OctaAPIController;
use Response;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;
    // public function sendResetLinkEmail(Request $request)
    // {
    //     $input = $request->all();
    //     $octa_con = new OctaAPIController;        
    //     $octa_data = $octa_con->OctaForgotPasswordEmail($input);
    //     // print_r($octa_data);exit();
    //     if($octa_data['flag'] == 'success')
    //     {
    //         if(isset($octa_data['data']->errorSummary))
    //         {
    //             return Response::json(['result' => false,'message'=>$octa_data['data']->errorSummary]);
    //         }
    //         else
    //         {
    //             return Response::json(['result' => true,'message'=>'success']);
    //         }
           
    //     }
    //     else
    //     {
    //         return Response::json(['result' => false,'message'=>'Email Was Not Successfully Sent.']);
    //     }
      
      
    //     // $user = User::where('email',$request->email)->first();
    //     // if($user)
    //     // {  
    //     //     $ps = PasswordReset::where('email',$request->email)->first();
    //     //     if($ps)
    //     //     {
    //     //         PasswordReset::where('email',$request->email)->delete();
    //     //     }
    //     //     $token = Str::random(64);
    //     //     $cred = array(
    //     //         'email' => $user->email,
    //     //         'token' => \Hash::make($token),
    //     //         'created_at' => date('Y-m-d H:i:s')
    //     //     );
    //     //     PasswordReset::create($cred);
    //     //     $details = [
    //     //         'name' => $user->name,
    //     //         'id' => $user->id,
    //     //         'token' => $token
    //     //     ];
    //     //     Mail::to($user->email)->send(new ForgotPasswordMail($details));
    //     //     return $request->wantsJson()
    //     //             ? new JsonResponse(['message' => 'Reset password link has been sent successfully. Please Check your email.'], 200)
    //     //             : back()->with('status', 'Reset password link has been sent successfully. Please Check your email.');
    //     //     // return redirect()->back()->withErrors(array('success_email' => 'Reset password link has been sent successfully. Please Check your email.'));
    //     // }
    //     // else
    //     // {
    //     //     return redirect()->back()->withErrors(array('email' => 'Email not found.'));
    //     // }
    // }
}
