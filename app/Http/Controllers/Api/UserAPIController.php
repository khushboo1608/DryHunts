<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseAPIController as BaseAPIController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Models\Settings;
use App\Models\UserAuthMaster;
use App\Models\NotificationMaster;
use Hash;
use Mail;
use Carbon\Carbon; 
use App\Models\PasswordReset;
use App\Mail\ForgotPasswordMail;

class UserAPIController extends BaseAPIController
{
    
    // public function Registration(Request $request)
    // {
    //     $otp='1234';       
    //     try
    //     {
    //         $input = $request->all();
    //         $phone =$input['phone'];
    //         $user = User::where('phone',$input['phone'])->where('login_type',2)->first();
    //         if($user)
    //         {
    //             // echo 'if';die;
    //             User::where('phone',$input['phone'])->update(['otp' => $otp]);
                
    //             $sms_data = $this->SentMobileVerificationCode($phone,$otp);
    //             if($sms_data['flag'] == 'success')
    //             {
    //                         $token = $user->createToken(env('APP_NAME'));
    //                         $user->token = $token->accessToken;
    //                         $oauth_access_token_id = $token->token->id;
                            
    //                         $getauth_data = UserAuthMaster::where('device_token',$input['device_token'])->first();
    //                         if(!$getauth_data)
    //                         {
    //                             $user_auth_id = $this->GenerateUniqueRandomString($table='user_auth_master', $column="user_auth_id", $chars=32);
    //                             $auth_input = array(
    //                                 'user_auth_id'      => $user_auth_id,
    //                                 'user_id' => $user->id,
    //                                 'oauth_access_token_id' => $oauth_access_token_id,
    //                                 'device_type'  => $input['device_type'],
    //                                 'device_token' => $input['device_token'],
    //                             );
    //                             $user_auth_token = UserAuthMaster::create($auth_input);
    //                         }
    //                         else
    //                         {
    //                             $auth_input = array(
    //                                 'oauth_access_token_id' => $oauth_access_token_id,
    //                                 'device_type' => $input['device_type'],
    //                                 'device_token' => $input['device_token'],
    //                             );
    //                             UserAuthMaster::where('device_token',$input['device_token'])->update($auth_input);
    //                         } 
    //                 $user_data = $this->UserResponse($user);
    //                 return $this->sendResponse($user_data, __('messages.api.user.register_success'));
    //             }
    //             else
    //             {
    //                 return $this->sendError(__('messages.api.user.invalid_phone'), config('global.null_object'),226,false);
    //             }
               
    //         }
    //         else{
                               
    //             // echo $otp;die;
    //             $sms_data = $this->SentMobileVerificationCode($phone,$otp);

    //             if($sms_data['flag'] == 'success')
    //             {
    //                 // echo 'if';die;
    //                 $input['otp'] = $otp;

    //                 // echo "<pre>";
    //                 // print_r($input);die;
    //                 $user = User::create($input);   
    //                 $token = $user->createToken(env('APP_NAME'));
    //                 $user->token = $token->accessToken;
    //                 $oauth_access_token_id = $token->token->id;
    //                 $user_auth_id = $this->GenerateUniqueRandomString($table='user_auth_master', $column="user_auth_id", $chars=32);
    //                 $auth_input = array(
    //                     'user_auth_id'      => $user_auth_id,
    //                     'user_id'           => $user->id,
    //                     'oauth_access_token_id' => $oauth_access_token_id,
    //                     'device_type'  => $input['device_type'],
    //                     'device_token' => $input['device_token'],
    //                 );
    //                 $user_auth_token = UserAuthMaster::create($auth_input);
                    
    //                 $user_data = $this->UserResponse($user);
    //                 return $this->sendResponse($user_data, __('messages.api.user.register_success'));
    //             }
    //             else
    //             {
    //                 // echo 'else';die;
    //                 return $this->sendError(__('messages.api.user.invalid_phone'), config('global.null_object'),226,false);
    //             }                

    //         }
    //     }
    //     catch(\Exception $e)
    //     {
    //         $this->serviceLogError($service_name = 'Registration',$user_id = 0,$message = $e->getMessage(),$requested_field = json_encode($request->all()),$response_data=$e);
    //         return $this->sendError($e->getMessage(), config('global.null_object'),401,false);
    //     }
    // }
    
    // public function VerifyOtp(Request $request)
    // {
    //     // echo 'in';die;
    //     try
    //     {
    //         if(Auth::guard('api')->check())
    //         {
    //             $input = $request->all();
    //             $auth_user = Auth::guard('api')->user();                
    //             // echo "<pre>";
    //             // print_r($input);die;
    //             $user_otp = User::where('otp', $input['otp'])->where('id',$auth_user->id)->where('is_disable',0)->first();

    //             // echo "<pre>";
    //             // print_r($user_otp);die;
    //             if($user_otp){
    //                 User::where('id', $auth_user->id)->where('otp', $input['otp'])->update(['is_verified' => 1]);
    //                 $user = User::where('id',$auth_user->id)->where('is_disable',0)->first();
    //                 $token = $request->bearerToken();
    //                 $user->token = $token;
    //                 $user_data = $this->UserResponse($user);
                   
    //                 return $this->sendResponse($user_data, __('messages.api.user.user_login_success'));
    //             }
    //             else{
    //                 return $this->sendError(__('messages.api.user.invalid_otp'), config('global.null_object'),401,false);
    //             }
                                  
    //         }
    //         else
    //         {
                
    //             return $this->sendError(__('messages.api.authentication_err_message'), config('global.null_object'),401,false);
    //         }
    //     }
    //     catch(\Exception $e)
    //     {
    //         $auth_user = Auth::guard('api')->user();
    //         $this->serviceLogError($service_name = 'VerifyOtp',$user_id = $auth_user->id,$message = $e->getMessage(),$requested_field = json_encode($request->all()),$response_data=$e);
    //         return $this->sendError($e->getMessage(), config('global.null_object'),401,false);
    //     }
    // }

    public function Registration(Request $request)
    {
        try
        {
            $input = $request->all();
            $rules = array('email' => 'unique:users,email','phone' => 'unique:users,phone');
            $messages = [
                'email.unique'    => 'User already exist with this email. Try another.',
                'phone.unique'     => 'User already exist with this Phone no. Try another.',
        
            ];
            // $validator = Validator::make($userData, $rules);
            $validator = Validator::make($input, $rules,$messages);
            if (!$validator->fails())
            {
                if($request->hasFile('user_profile'))
                {    
                    $input['imageurl']= $this->UploadImage($file = $request->user_profile,$path = config('global.file_path.user_profile'));
                }
                $input['password'] = Hash::make($request->password);

                // echo "<pre>";
                // print_r($input);die;
                $user = User::create($input);   
                $token = $user->createToken(env('APP_NAME'));
                $user->token = $token->accessToken;
                $oauth_access_token_id = $token->token->id;
                $user_auth_id = $this->GenerateUniqueRandomString($table='user_auth_master', $column="user_auth_id", $chars=32);
                $auth_input = array(
                    'user_auth_id'      => $user_auth_id,
                    'user_id'           => $user->id,
                    'oauth_access_token_id' => $oauth_access_token_id,
                    'device_type'  => $input['device_type'],
                    'device_token' => $input['device_token'],
                );
                $user_auth_token = UserAuthMaster::create($auth_input);
                
                $user_data = $this->UserResponse($user);
                return $this->sendResponse($user_data, __('messages.api.user.register_success'));
            }
            else
            {
                $errors = $validator->errors()->first();   
                return $this->sendError($errors, config('global.null_object'),226,false);
            }
        }
        catch(\Exception $e)
        {
            $this->serviceLogError($service_name = 'Registration',$user_id = 0,$message = $e->getMessage(),$requested_field = json_encode($request->all()),$response_data=$e);
            return $this->sendError($e->getMessage(), config('global.null_object'),401,false);
        }
    }

 
    public function GetUserProfile(Request $request)
    {
        // echo 'in';die;
        try
        {
            if(Auth::guard('api')->check())
            {
                $input = $request->all();
                $auth_user = Auth::guard('api')->user();
                
                $user = User::find($auth_user->id);
                $token = $request->bearerToken();
                $user->token = $token;
                $user_data = $this->UserResponse($user);
                
                return $this->sendResponse($user_data, __('messages.api.user.user_get_profile_success'));              
            }
            else
            {                
                return $this->sendError(__('messages.api.authentication_err_message'), config('global.null_object'),401,false);
            }
        }
        catch(\Exception $e)
        {
            $auth_user = Auth::guard('api')->user();
            $this->serviceLogError($service_name = 'GetUserProfile',$user_id = $auth_user->id,$message = $e->getMessage(),$requested_field = json_encode($request->all()),$response_data=$e);
            return $this->sendError($e->getMessage(), config('global.null_object'),401,false);
        }
    }

    public function ProfileUpdate(Request $request)
    {
        try
        {
            if(Auth::guard('api')->check())
            {
                $input = $request->all();
                $auth_user = Auth::guard('api')->user();
                $imageurl = '';
                if($request->hasFile('user_profile'))
                {  
                    // $this->RemoveImage($name = $auth_user->imageurl,$path = config('global.file_path.user_profile'));
                    $imageurl = $this->UploadImage($file = $request->user_profile,$path = config('global.file_path.user_profile'));
                    $input['imageurl'] = $imageurl;
                }
                else{
                    $input['imageurl'] = $auth_user->imageurl;
                }
                $token = $request->bearerToken();               

                // echo "<pre>";
                // print_r($input);die;
                $user = User::find($auth_user->id);
                $user->fill($input);
                $user->save();
                $user->token = $token;
                $user_data = $this->UserResponse($user);
                return $this->sendResponse($user_data, __('messages.api.user.profile_setup_success'));
            }
            else
            {
                return $this->sendError(__('messages.api.authentication_err_message'), config('global.null_object'),401,false);
            }
        }
        catch(\Exception $e)
        {
            $auth_user = Auth::guard('api')->user();
            $this->serviceLogError($service_name = 'ProfileUpdate',$user_id = $auth_user->id,$message = $e->getMessage(),$requested_field = json_encode($request->all()),$response_data=$e);
            return $this->sendError($e->getMessage(), config('global.null_object'),401,false);
        }
    }
    public function Login(Request $request)
    {   
        try
        {
            $input = $request->all();
            // echo "<pre>";
            // print_r($input);die;
            $user ='';
            $user = User::where('email',$input['email'])->orwhere('phone',$input['email'])->where('is_disable',0)->first();

            if($user)
            {
                if($user->is_verified == 1){
                    if (Hash::check($input['password'], $user->password)) {
                        
                        // $auth_input = array(
                        //     'device_type' => $input['device_type'],
                        //     'device_token' => $input['device_token'],
                        // );
                        // // $update = User::where('email',$input['email'])->update($auth_input);
                        // $update = User::where('email',$input['email'])->update($auth_input);     
                            $user = User::find($user->id);
                            if(isset($input['firebase_uid']) && $input['firebase_uid'] != '')
                            {
                                $n_input = [
                                    'firebase_uid'  => $input['firebase_uid']
                                ];
                                $user->fill($n_input);
                                $user->save();
                            }                        
                            // $token = $user->createToken(env('APP_NAME'))->accessToken;
                            $token = $user->createToken(env('APP_NAME'));
                            $user->token = $token->accessToken;
                            $oauth_access_token_id = $token->token->id;
                            // $user->token = $token;
                            $getauth_data = UserAuthMaster::where('device_token',$input['device_token'])->first();
                            if(!$getauth_data)
                            {
                                $user_auth_id = $this->GenerateUniqueRandomString($table='user_auth_master', $column="user_auth_id", $chars=32);
                                $auth_input = array(
                                    'user_auth_id' => $user_auth_id,
                                    'user_id' => $user->id, 
                                    'oauth_access_token_id' => $oauth_access_token_id,                                  
                                    'device_type'  => $input['device_type'],
                                    'device_token' => $input['device_token'],
                                );
                                $user_auth_token = UserAuthMaster::create($auth_input);
                            }
                            else
                            {
                                $auth_input = array(
                                    'oauth_access_token_id' => $oauth_access_token_id,                                    
                                    'device_type' => $input['device_type'],
                                    'device_token' => $input['device_token'],
                                );
                                UserAuthMaster::where('device_token',$input['device_token'])->update($auth_input);
                            }                        
                            $user_data = $this->UserResponse($user);  
                        return $this->sendResponse($user_data, __('messages.api.user.user_login_success'));               

                    }
                    else{
                        return $this->sendError(__('messages.api.user.email_or_password_incorrect'),config('global.null_object'),200,false); 
                    }
                }
                else{
                    return $this->sendError(__('Your profile is under review.'),config('global.null_object'),200,false);

                    // return back()->withInput()->with('error', 'Your profile is under review.');
                }
            }
            else
            {   
                return $this->sendError(__('messages.api.user.user_disable'),config('global.null_object'),200,false);
            }
        }
        catch(\Exception $e)
        {
            // $auth_user = Auth::guard('api')->user();
            // echo "<pre>";
            // print_r($auth_user); die;
            $this->serviceLogError($service_name = 'Login',$user_id = 0,$message = $e->getMessage(),$requested_field = json_encode($request->all()),$response_data=$e);
            return $this->sendError($e->getMessage(), config('global.null_object'),401,false);
        }
    }

    public function Logout(Request $request)
    {
        try
        {
            if (Auth::guard('api')->check()) {
                $user = Auth::guard('api')->user()->token();
                $oauth_access_token_id = $user->id;
                $user_id = $user->user_id;
                UserAuthMaster::where('oauth_access_token_id',$oauth_access_token_id)->delete();
                $user->revoke();
                return $this->sendResponse(config('global.null_object'), __('messages.api.logout'));
            }
            else
            {
                return $this->sendError(__('messages.api.user.user_not_found'), config('global.null_object'),404,false);
            }
        }
        catch(\Exception $e)
        {
            $auth_user = Auth::guard('api')->user();
            $this->serviceLogError($service_name = 'Logout',$user_id = $auth_user->id,$message = $e->getMessage(),$requested_field = json_encode($request->all()),$response_data=$e);
            return $this->sendError($e->getMessage(), config('global.null_object'),401,false);
        }
    }

    public function ForgotPassword(Request $request)
    {
        try
        {
            $user = User::where('email',$request->email)->where('is_disable',0)->first();
            if($user)
            {  
                $token = \Str::random(64);
                $cred = array(
                    'email'      => $user->email,
                    'token'      => $token,
                    'created_at' => Carbon::now()
                );
                PasswordReset::create($cred);
                $details = [
                    'name'  => $user->name,
                    'id'    => $user->id,
                    'email' => $user->email,
                    'token' => $token
                ];
            
                Mail::to($user->email)->send(new ForgotPasswordMail($details));
                if (Mail::failures()) {
                    return $this->sendError(__('messages.api.user.user_reset_password_email_sent_fail'), config('global.null_object'),404,false);
                } else {
                    return $this->sendResponse(config('global.null_object'), __('messages.api.user.user_reset_password_email_sent_success'));
                }                
            }
            else
            {
                return $this->sendError(__('messages.api.user.user_not_found'), config('global.null_object'),404,false);
            }
        }
        catch(\Exception $e)
        {
            $auth_user = User::where('email',$request->email)->first();
            $this->serviceLogError($service_name = 'ForgotPassword',$user_id = $auth_user->id,$message = $e->getMessage(),$requested_field = json_encode($request->all()),$response_data=$e);
            return $this->sendError($e->getMessage(), config('global.null_object'),401,false);
        }
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
                'confirm_password' => 'required|same:password'
            ]);

            $updatePassword = PasswordReset::where(['email' => $email[0],'token' => $request->token])->first();

            if(!$updatePassword){
                return back()->withInput()->with('error', 'Invalid token!');
            }
            else{
                $input = $request->all();
                // print_r($input);die;
                $user = User::where('email', $email[0])->first();
                if($input['password'] == $input['confirm_password'])
                { 
                    $password  = Hash::make($input['password']);
                    
                    User::where('email', $email[0])->update(['password' => $password]);
                    
                    PasswordReset::where(['email'=> $email[0]])->delete(); 
                    // return redirect('/admin')->with('message', 'Your password has been changed!');
                    if($user->login_type == 2){

                        return redirect('/userlogin')->with('message', 'Your password has been changed!');
                    }
                    else{

                        return redirect('/admin')->with('message', 'Your password has been changed!');
                    }
                }
                else
                {
                    return redirect()->back()->with('errormessage', 'New password and Confirm password does not matched.');
                }
             }
        
        }
        else{
        return redirect()->back()->with('errormessage', 'Invalid token!'); 
        }
    }

    public function ChangePassword(Request $request)
    {
        try
        {
            if(Auth::guard('api')->check())
            {
                $input = $request->all();
                $auth_user = Auth::guard('api')->user();
                $userdata = User::where('id',$auth_user->id)->first();
                if($userdata!='')
                {
                    if (Hash::check($input['old_password'], $userdata->password)) {
                        if($input['new_password'] != $input['old_password'])
                        {  
                            if($input['new_password'] == $input['confirm_password'])
                            {  
                                $password  = Hash::make($input['new_password']);
                                User::where('id',$auth_user->id)->update(['password' => $password]);
                                $user_data = User::where('id',$auth_user->id)->first();
                                
                                $token = $request->bearerToken();   
                                $user_data->token = $token;

                                $user_data = $this->UserResponse($user_data);  
                                return $this->sendResponse($user_data, __('messages.api.user.change_password_success'));
                            }
                            else
                            {
                                return $this->sendError(__('messages.api.user.confirm_new_password_not_match'), config('global.null_object'),200,false);
                            }
                        }
                        else
                        {
                            return $this->sendError(__('messages.api.user.password_should_different'), config('global.null_object'),200,false);
                        }
                    }
                    else
                    {
                        return $this->sendError(__('messages.api.user.invalid_oldpassword'), config('global.null_object'),200,false);
                    }
                }   
                else
                {
                    return $this->sendError(__('messages.api.user.user_not_found'),config('global.null_object'),200,false);
                }
            }
            else
            {
                return $this->sendError(__('messages.api.authentication_err_message'), config('global.null_object'),401,false);
            }
            
        }
        catch(\Exception $e)
        {
            $auth_user = Auth::guard('api')->user();
            $this->serviceLogError($service_name = 'ChangePassword',$user_id = $auth_user->id,$message = $e->getMessage(),$requested_field = json_encode($request->all()),$response_data=$e);
            return $this->sendError($e->getMessage(), config('global.null_object'),401,false);
        }
    }
    
 }
?>    