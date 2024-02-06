<?php

namespace App\Http\Controllers\web;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use DB;
use Mail;
use Carbon\Carbon;
use App\Models\User;
use App\Mail\ForgotPasswordMail;
use App\Models\PasswordReset;
use Illuminate\Http\JsonResponse;
use Response;

class ForgetPasswordController extends BaseController
{
    public function index()
    {
        // return view('/distributor/FGPassword');
        return view('auth.passwords.email');
        
    }
    public function SendEmail(Request $request)
    {
        // echo "in"; die;
        $user = User::where('email',$request->email)->first();
        if($user)
        {  
            $ps = PasswordReset::where('email',$request->email)->first();
            if($ps)
            {
                PasswordReset::where('email',$request->email)->delete();
            }
            $token = Str::random(64);
            $cred = array(
                'email' => $user->email,
                'token' => $token,
                'created_at' => date('Y-m-d H:i:s')
            );
            PasswordReset::create($cred);
            $details = [
                'name' => $user->first_name,
                'id' => $user->id,
                'email' => $user->email,
                'token' => $token
            ];
            Mail::to($user->email)->send(new ForgotPasswordMail($details));

            if (Mail::failures()) {
                // return $this->sendError(__('messages.api.user.user_reset_password_email_sent_fail'), config('global.null_object'),404,false);
                return Response::json(['result' => false,'message'=>'Email not send. please try again.']);
            } else {
                return Response::json(['result' => true,'message'=>'success']);
            } 

            // return $request->wantsJson()
            //         ? new JsonResponse(['message' => 'Reset password link has been sent successfully. Please Check your email.'], 200)
            //         : back()->with('status', 'Reset password link has been sent successfully. Please Check your email.');
            // return redirect()->back()->withErrors(array('success_email' => 'Reset password link has been sent successfully. Please Check your email.'));
        }
        else
        {
            return redirect()->back()->withErrors(array('email' => 'Email not found.'));
        }
        
    }
    
}