<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseAPIController as BaseAPIController;
use App\Http\Controllers\OctaAPIController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserAuthMaster;
use App\Models\NotificationMaster;
use App\Models\TagMaster;
use App\Models\Gym;
use App\Models\Agent;
use Illuminate\Http\Request;
use Exception;
use Storage;
use File;
use DB;
use Log;

class NotificationAPIController extends BaseAPIController
{ 

    /**
     * @OA\Get(
     *      path="/TestNotification",
     *      operationId="TestNotification",
     *      tags={"Notification API Section"},
     *      summary="Logout process of user",
     *      description="Notification testing",
     *      @OA\Response(
     *          response=200,
     *          description="Notification sent successfully.",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *     )
    */
   
    public function TestNotification(Request $request)
    {
        $SERVER_API_KEY = 'AAAA7fpctRI:APA91bEtK0fwlPg1J2BTGlzo2V7Okt3c3YbXq_ERaDjQptudo606pRbO3Z4xQOFvlq3HD6Y62e1cz2REizHx51ZvDd2RLVaNebt5-25JpRI9tPfv1Mj3orrhnBg1pVO0x8mipnlDwmt2';  
        // payload data, it will vary according to requirement

        $token ='ev3yC3wvS-e6ygbs0wExtC:APA91bFTNc_GOJT2H-eHRWsCLARZE0-Q6CrBy4THlHtrlSO_bNGF9Jp4ZCuFusHAb40vONpSpvHBPv2Fz3hz9vfHqkwdoUmgZGQcUxKAXXqwDDv1fseRqNd7J79vOFGgq6ffVDsaC6ry';
        $data = [
            // "registration_ids" => ['ckAkIrCJR-yWBu0DNhXuWf:APA91bFsDvq7AUtxqjD45oTVgcaIez81M5XfiRpl9mzqcncpUK0D_riiIPD14CVFkA5jVDqnAaB3SxOUlbMf9TEy3ntKFA9YCtB7lBD_abx4XEM_KBQMeSkCpBoItVmFeg1eAEvEoQ-c'], // for multiple device ids
            'to'        => $token, 
            "notification" => array(
                "title" => "Sample Message", 
                "body" => "This is Test message body"
              )
        ];
        $dataString = json_encode($data);

        // echo "<pre>";
        // print_r($dataString); die;
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];    
        $ch = curl_init();      
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
               
        $response = curl_exec($ch);
        print_r($response);exit();      
        curl_close($ch);      
        return $response;
    }
    

    public function NotificationSend($input)
    {
        try
        {
            if(Auth::guard('api')->check())
            {
                $auth_user = Auth::guard('api')->user();
                $receiver_id = $input['receiver_id'];   
                
                // echo $receiver_id; die;
              
                $ios_device_token = UserAuthMaster::where('user_id',$receiver_id)->where('device_type',1)->whereNotNull('device_token')->pluck('device_token')->toArray();
                
                $android_device_token = UserAuthMaster::where('user_id',$receiver_id)->where('device_type',2)->whereNotNull('device_token')->pluck('device_token')->toArray();

                $web_device_token = UserAuthMaster::where('user_id',$receiver_id)->where('device_type',3)->whereNotNull('device_token')->pluck('device_token')->first();

                // echo "<pre>";
                // print_r($web_device_token);die;

                $total = count((array)$web_device_token);
                $receiver_data = User::where('id',$receiver_id)->first();
                $data = [
                    'title'             => $input['notification_text'],
                    'message'           => $input['notification_title'],
                    'receiver_id'       => $receiver_id,
                    // 'item_id'           => $input['item_id'],
                    'conversation_id'   => '',
                    'notification_type' => $input['notification_type'],
                    'notification_id'   => $input['notification_id'],
                    'receiver_firebase_uid' => $receiver_data->firebase_uid,
                    'receiver_name' => $receiver_data->name,
                    'receiver_profile_image' => $this->GetImage($receiver_data->profile_image,$path=config('global.file_path.user_profile'))                    
                ];
                     
                $Title = $input['notification_text'];
                $Body = $input['notification_title'];
                $count_data = NotificationMaster::where('receiver_id', $receiver_id)
                ->where('notification_type',6)
                ->where('is_view', 0)
                ->where('is_disable',0)
                ->count();
                $Badge =$count_data;
                
                if(count($ios_device_token) > 0)
                {
                    $response = $this->SendIOSPushNotification($ios_device_token,$data);
                    // echo "<pre>";
                    // print_r(count($response)); exit();
                    if($response)
                    {
                        $resp = json_decode($response);                      
                        if($resp->success == 1)
                        {
                            if(count($android_device_token) > 0)
                            {
                                $response = $this->SendAndroidPushNotification($android_device_token,$data);                                
                                if($response)
                                {
                                    $resp = json_decode($response);
                                    if($resp->success == 1)
                                    {
                                        return $this->sendResponse($resp, __('messages.api.notification.notification_sent_success'));
                                    }
                                    else
                                    {
                                        return $this->sendError( __('messages.api.notification.notification_sent_error'), config('global.null_object'),401,false);
                                    }
                                }
                                else
                                {
                                    return $this->sendError( __('messages.api.notification.notification_sent_error'), config('global.null_object'),401,false);
                                }
                            }
                            return $this->sendResponse($resp, __('messages.api.notification.notification_sent_success'));
                        }
                        else
                        {
                            return $this->sendError( __('messages.api.notification.notification_sent_error'), config('global.null_object'),401,false);
                        }
                    }
                    else
                    {
                        return $this->sendError( __('messages.api.notification.notification_sent_error'), config('global.null_object'),401,false);
                    }                    
                }
                if(count($android_device_token) > 0)
                {
                    $response = $this->SendAndroidPushNotification($android_device_token,$data);
                    if($response)
                    {
                        $resp = json_decode($response);
                        if($resp->success == 1)
                        {
                            if(count($ios_device_token) > 0)
                            {
                                $response = $this->SendIOSPushNotification($ios_device_token,$data);
                                if($response)
                                {
                                    $resp = json_decode($response);
                                    if($resp->success == 1)
                                    {
                                        return $this->sendResponse($resp, __('messages.api.notification.notification_sent_success'));
                                    }
                                    else
                                    {
                                        return $this->sendError( __('messages.api.notification.notification_sent_error'), config('global.null_object'),401,false);
                                    }
                                }
                                else
                                {
                                    return $this->sendError( __('messages.api.notification.notification_sent_error'), config('global.null_object'),401,false);
                                }                                
                            }
                            return $this->sendResponse($resp, __('messages.api.notification.notification_sent_success'));
                        }
                        else
                        {
                            return $this->sendError( __('messages.api.notification.notification_sent_error'), config('global.null_object'),401,false);
                        }
                    }
                    else
                    {
                        return $this->sendError( __('messages.api.notification.notification_sent_error'), config('global.null_object'),401,false);
                    }
                }
                if($total > 0)
                {
                    $response = $this->WebPushNotificationFirebase($web_device_token,$Title, $Body,$Badge);
                    if($response)
                    {
                        $resp = json_decode($response);
                        if($resp->success == 1)
                        {
                            return $this->sendResponse($resp, __('messages.api.notification.notification_sent_success'));
                        }
                        else
                        {
                            return $this->sendError( __('messages.api.notification.notification_sent_error'), config('global.null_object'),401,false);
                        }
                    }
                    else
                    {
                        return $this->sendError( __('messages.api.notification.notification_sent_error'), config('global.null_object'),401,false);
                    }
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
            $this->serviceLogError($service_name = 'NotificationSend',$user_id = $auth_user->id,$message = $e->getMessage(),$requested_field = json_encode($input),$response_data=$e);
            return $this->sendError($e->getMessage(), config('global.null_object'),401,false);
        }
    }

    public function SendNotification($input)
    {
        try
        {     
                $auth_user = Auth::guard('api')->user();
                $receiver_id = $input['receiver_id'];   
                
                // echo $receiver_id; die;
              
                $ios_device_token = UserAuthMaster::where('user_id',$receiver_id)->where('device_type',1)->whereNotNull('device_token')->pluck('device_token')->toArray();
                
                $android_device_token = UserAuthMaster::where('user_id',$receiver_id)->where('device_type',2)->whereNotNull('device_token')->pluck('device_token')->toArray();

                $web_device_token = UserAuthMaster::where('user_id',$receiver_id)->where('device_type',3)->whereNotNull('device_token')->pluck('device_token')->first();

                // echo "<pre>";
                // print_r($web_device_token);die;

                $total = count((array)$web_device_token);
                $receiver_data = User::where('id',$receiver_id)->first();
                $data = [
                    'title'             => $input['notification_text'],
                    'message'           => $input['notification_title'],
                    'receiver_id'       => $receiver_id,
                    // 'item_id'           => $input['item_id'],
                    'conversation_id'   => '',
                    'notification_type' => $input['notification_type'],
                    'notification_id'   => $input['notification_id'],
                    'receiver_firebase_uid' => $receiver_data->firebase_uid,
                    'receiver_name' => $receiver_data->name,
                    'receiver_profile_image' => $this->GetImage($receiver_data->profile_image,$path=config('global.file_path.user_profile'))                    
                ];
                     
                $Title = $input['notification_text'];
                $Body = $input['notification_title'];
                $count_data = NotificationMaster::where('receiver_id', $receiver_id)
                ->where('notification_type',6)
                ->where('is_view', 0)
                ->where('is_disable',0)
                ->count();
                $Badge =$count_data;
                
                if(count($ios_device_token) > 0)
                {
                    $response = $this->SendIOSPushNotification($ios_device_token,$data);
                    // echo "<pre>";
                    // print_r(count($response)); exit();
                    if($response)
                    {
                        $resp = json_decode($response);                      
                        if($resp->success == 1)
                        {
                            if(count($android_device_token) > 0)
                            {
                                $response = $this->SendAndroidPushNotification($android_device_token,$data);                                
                                if($response)
                                {
                                    $resp = json_decode($response);
                                    if($resp->success == 1)
                                    {
                                        return $this->sendResponse($resp, __('messages.api.notification.notification_sent_success'));
                                    }
                                    else
                                    {
                                        return $this->sendError( __('messages.api.notification.notification_sent_error'), config('global.null_object'),401,false);
                                    }
                                }
                                else
                                {
                                    return $this->sendError( __('messages.api.notification.notification_sent_error'), config('global.null_object'),401,false);
                                }
                            }
                            return $this->sendResponse($resp, __('messages.api.notification.notification_sent_success'));
                        }
                        else
                        {
                            return $this->sendError( __('messages.api.notification.notification_sent_error'), config('global.null_object'),401,false);
                        }
                    }
                    else
                    {
                        return $this->sendError( __('messages.api.notification.notification_sent_error'), config('global.null_object'),401,false);
                    }                    
                }
                if(count($android_device_token) > 0)
                {
                    $response = $this->SendAndroidPushNotification($android_device_token,$data);
                    if($response)
                    {
                        $resp = json_decode($response);
                        if($resp->success == 1)
                        {
                            if(count($ios_device_token) > 0)
                            {
                                $response = $this->SendIOSPushNotification($ios_device_token,$data);
                                if($response)
                                {
                                    $resp = json_decode($response);
                                    if($resp->success == 1)
                                    {
                                        return $this->sendResponse($resp, __('messages.api.notification.notification_sent_success'));
                                    }
                                    else
                                    {
                                        return $this->sendError( __('messages.api.notification.notification_sent_error'), config('global.null_object'),401,false);
                                    }
                                }
                                else
                                {
                                    return $this->sendError( __('messages.api.notification.notification_sent_error'), config('global.null_object'),401,false);
                                }                                
                            }
                            return $this->sendResponse($resp, __('messages.api.notification.notification_sent_success'));
                        }
                        else
                        {
                            return $this->sendError( __('messages.api.notification.notification_sent_error'), config('global.null_object'),401,false);
                        }
                    }
                    else
                    {
                        return $this->sendError( __('messages.api.notification.notification_sent_error'), config('global.null_object'),401,false);
                    }
                }
                if($total > 0)
                {
                    $response = $this->WebPushNotificationFirebase($web_device_token,$Title, $Body,$Badge);
                    if($response)
                    {
                        $resp = json_decode($response);
                        if($resp->success == 1)
                        {
                            return $this->sendResponse($resp, __('messages.api.notification.notification_sent_success'));
                        }
                        else
                        {
                            return $this->sendError( __('messages.api.notification.notification_sent_error'), config('global.null_object'),401,false);
                        }
                    }
                    else
                    {
                        return $this->sendError( __('messages.api.notification.notification_sent_error'), config('global.null_object'),401,false);
                    }
                }
            
        }
        catch(\Exception $e)
        {
            $auth_user = Auth::guard('api')->user();
            $this->serviceLogError($service_name = 'SendNotification',$user_id = $auth_user->id,$message = $e->getMessage(),$requested_field = json_encode($input),$response_data=$e);
            return $this->sendError($e->getMessage(), config('global.null_object'),401,false);
        }
    }

    public function SendGymNotification($input)
    {
        try
        {     
                $receiver_id = $input['receiver_id'];   
                
                // echo $receiver_id; die;
              
                $ios_device_token = Gym::where('gym_id',$receiver_id)->where('device_type',1)->whereNotNull('device_token')->pluck('device_token')->toArray();
                
                $android_device_token = Gym::where('gym_id',$receiver_id)->where('device_type',2)->whereNotNull('device_token')->pluck('device_token')->toArray();

                $web_device_token = Gym::where('gym_id',$receiver_id)->where('device_type',3)->whereNotNull('device_token')->pluck('device_token')->first();

                // echo "<pre>";
                // print_r($web_device_token);die;

                $total = count((array)$web_device_token);
                $receiver_data = Gym::where('gym_id',$receiver_id)->first();
                $data = [
                    'title'             => $input['notification_text'],
                    'message'           => $input['notification_title'],
                    'receiver_id'       => $receiver_id,
                    // 'item_id'           => $input['item_id'],
                    'conversation_id'   => '',
                    'notification_type' => $input['notification_type'],
                    'notification_id'   => $input['notification_id'],
                    'receiver_firebase_uid' => $receiver_data->firebase_uid,
                    'receiver_name' => $receiver_data->gym_name,
                    'receiver_profile_image' => $this->GetImage($receiver_data->gym_profile_img,$path=config('global.file_path.gym_img'))                    
                ];
                     
                $Title = $input['notification_text'];
                $Body = $input['notification_title'];
                $count_data = NotificationMaster::where('receiver_id', $receiver_id)
                ->where('notification_type',6)
                ->where('is_view', 0)
                ->where('is_disable',0)
                ->count();
                $Badge =$count_data;
                
                if(count($ios_device_token) > 0)
                {
                    $response = $this->SendIOSPushNotification($ios_device_token,$data);
                    // echo "<pre>";
                    // print_r(count($response)); exit();
                    if($response)
                    {
                        $resp = json_decode($response);                      
                        if($resp->success == 1)
                        {
                            if(count($android_device_token) > 0)
                            {
                                $response = $this->SendAndroidPushNotification($android_device_token,$data);                                
                                if($response)
                                {
                                    $resp = json_decode($response);
                                    if($resp->success == 1)
                                    {
                                        return $this->sendResponse($resp, __('messages.api.notification.notification_sent_success'));
                                    }
                                    else
                                    {
                                        return $this->sendError( __('messages.api.notification.notification_sent_error'), config('global.null_object'),401,false);
                                    }
                                }
                                else
                                {
                                    return $this->sendError( __('messages.api.notification.notification_sent_error'), config('global.null_object'),401,false);
                                }
                            }
                            return $this->sendResponse($resp, __('messages.api.notification.notification_sent_success'));
                        }
                        else
                        {
                            return $this->sendError( __('messages.api.notification.notification_sent_error'), config('global.null_object'),401,false);
                        }
                    }
                    else
                    {
                        return $this->sendError( __('messages.api.notification.notification_sent_error'), config('global.null_object'),401,false);
                    }                    
                }
                if(count($android_device_token) > 0)
                {
                    $response = $this->SendAndroidPushNotification($android_device_token,$data);
                    if($response)
                    {
                        $resp = json_decode($response);
                        if($resp->success == 1)
                        {
                            if(count($ios_device_token) > 0)
                            {
                                $response = $this->SendIOSPushNotification($ios_device_token,$data);
                                if($response)
                                {
                                    $resp = json_decode($response);
                                    if($resp->success == 1)
                                    {
                                        return $this->sendResponse($resp, __('messages.api.notification.notification_sent_success'));
                                    }
                                    else
                                    {
                                        return $this->sendError( __('messages.api.notification.notification_sent_error'), config('global.null_object'),401,false);
                                    }
                                }
                                else
                                {
                                    return $this->sendError( __('messages.api.notification.notification_sent_error'), config('global.null_object'),401,false);
                                }                                
                            }
                            return $this->sendResponse($resp, __('messages.api.notification.notification_sent_success'));
                        }
                        else
                        {
                            return $this->sendError( __('messages.api.notification.notification_sent_error'), config('global.null_object'),401,false);
                        }
                    }
                    else
                    {
                        return $this->sendError( __('messages.api.notification.notification_sent_error'), config('global.null_object'),401,false);
                    }
                }
                if($total > 0)
                {
                    $response = $this->WebPushNotificationFirebase($web_device_token,$Title, $Body,$Badge);
                    if($response)
                    {
                        $resp = json_decode($response);
                        if($resp->success == 1)
                        {
                            return $this->sendResponse($resp, __('messages.api.notification.notification_sent_success'));
                        }
                        else
                        {
                            return $this->sendError( __('messages.api.notification.notification_sent_error'), config('global.null_object'),401,false);
                        }
                    }
                    else
                    {
                        return $this->sendError( __('messages.api.notification.notification_sent_error'), config('global.null_object'),401,false);
                    }
                }
            
        }
        catch(\Exception $e)
        {
            $this->serviceLogError($service_name = 'SendGymNotification',$user_id = 0,$message = $e->getMessage(),$requested_field = json_encode($input),$response_data=$e);
            return $this->sendError($e->getMessage(), config('global.null_object'),401,false);
        }
    }

    public function SendAgentNotification($input)
    {
        try
        {     
                $receiver_id = $input['receiver_id'];   
                
                // echo $receiver_id; die;
              
                $ios_device_token = Agent::where('agent_id',$receiver_id)->where('device_type',1)->whereNotNull('device_token')->pluck('device_token')->toArray();
                
                $android_device_token = Agent::where('agent_id',$receiver_id)->where('device_type',2)->whereNotNull('device_token')->pluck('device_token')->toArray();

                $web_device_token = Agent::where('agent_id',$receiver_id)->where('device_type',3)->whereNotNull('device_token')->pluck('device_token')->first();

                $total = count((array)$web_device_token);
                $receiver_data = Agent::where('agent_id',$receiver_id)->first();
                $data = [
                    'title'             => $input['notification_text'],
                    'message'           => $input['notification_title'],
                    'receiver_id'       => $receiver_id,
                    // 'item_id'           => $input['item_id'],
                    'conversation_id'   => '',
                    'notification_type' => $input['notification_type'],
                    'notification_id'   => $input['notification_id'],
                    'receiver_firebase_uid' => $receiver_data->firebase_uid,
                    'receiver_name' => $receiver_data->gym_name,
                    'receiver_profile_image' => $this->GetImage($receiver_data->gym_profile_img,$path=config('global.file_path.gym_img'))                    
                ];
                     
                $Title = $input['notification_text'];
                $Body = $input['notification_title'];
                $count_data = NotificationMaster::where('receiver_id', $receiver_id)
                ->where('notification_type',6)
                ->where('is_view', 0)
                ->where('is_disable',0)
                ->count();
                $Badge =$count_data;
                
                if(count($ios_device_token) > 0)
                {
                    $response = $this->SendIOSPushNotification($ios_device_token,$data);
                    // echo "<pre>";
                    // print_r(count($response)); exit();
                    if($response)
                    {
                        $resp = json_decode($response);                      
                        if($resp->success == 1)
                        {
                            if(count($android_device_token) > 0)
                            {
                                $response = $this->SendAndroidPushNotification($android_device_token,$data);                                
                                if($response)
                                {
                                    $resp = json_decode($response);
                                    if($resp->success == 1)
                                    {
                                        return $this->sendResponse($resp, __('messages.api.notification.notification_sent_success'));
                                    }
                                    else
                                    {
                                        return $this->sendError( __('messages.api.notification.notification_sent_error'), config('global.null_object'),401,false);
                                    }
                                }
                                else
                                {
                                    return $this->sendError( __('messages.api.notification.notification_sent_error'), config('global.null_object'),401,false);
                                }
                            }
                            return $this->sendResponse($resp, __('messages.api.notification.notification_sent_success'));
                        }
                        else
                        {
                            return $this->sendError( __('messages.api.notification.notification_sent_error'), config('global.null_object'),401,false);
                        }
                    }
                    else
                    {
                        return $this->sendError( __('messages.api.notification.notification_sent_error'), config('global.null_object'),401,false);
                    }                    
                }
                if(count($android_device_token) > 0)
                {
                    $response = $this->SendAndroidPushNotification($android_device_token,$data);
                    if($response)
                    {
                        $resp = json_decode($response);
                        if($resp->success == 1)
                        {
                            if(count($ios_device_token) > 0)
                            {
                                $response = $this->SendIOSPushNotification($ios_device_token,$data);
                                if($response)
                                {
                                    $resp = json_decode($response);
                                    if($resp->success == 1)
                                    {
                                        return $this->sendResponse($resp, __('messages.api.notification.notification_sent_success'));
                                    }
                                    else
                                    {
                                        return $this->sendError( __('messages.api.notification.notification_sent_error'), config('global.null_object'),401,false);
                                    }
                                }
                                else
                                {
                                    return $this->sendError( __('messages.api.notification.notification_sent_error'), config('global.null_object'),401,false);
                                }                                
                            }
                            return $this->sendResponse($resp, __('messages.api.notification.notification_sent_success'));
                        }
                        else
                        {
                            return $this->sendError( __('messages.api.notification.notification_sent_error'), config('global.null_object'),401,false);
                        }
                    }
                    else
                    {
                        return $this->sendError( __('messages.api.notification.notification_sent_error'), config('global.null_object'),401,false);
                    }
                }
                if($total > 0)
                {
                    $response = $this->WebPushNotificationFirebase($web_device_token,$Title, $Body,$Badge);
                    if($response)
                    {
                        $resp = json_decode($response);
                        if($resp->success == 1)
                        {
                            return $this->sendResponse($resp, __('messages.api.notification.notification_sent_success'));
                        }
                        else
                        {
                            return $this->sendError( __('messages.api.notification.notification_sent_error'), config('global.null_object'),401,false);
                        }
                    }
                    else
                    {
                        return $this->sendError( __('messages.api.notification.notification_sent_error'), config('global.null_object'),401,false);
                    }
                }
            
        }
        catch(\Exception $e)
        {
            $this->serviceLogError($service_name = 'SendAgentNotification',$user_id = 0,$message = $e->getMessage(),$requested_field = json_encode($input),$response_data=$e);
            return $this->sendError($e->getMessage(), config('global.null_object'),401,false);
        }
    }

    public function NotificationList(Request $request)
    {
        try
        {
                $input= $request->all();  
                $page           = $input['page'];
                $result = NotificationMaster::where('receiver_id',$input['id'])->where('is_disable', 0)->orderBy('created_at', 'desc')->get();

                // print_r($result); die;
                // $dashboard_object = new DashboardAPIController;
                // $notiresult = $dashboard_object->GetNotificationData($result);
                $notiresult = $this->NotificationResponse($result);                
                if(!empty($notiresult)){
                    $result_data = NotificationMaster::where('receiver_id',$input['id'])->where('is_view',0)->where('is_disable',0)->get();
                    if(!empty($result_data)){                        
                        NotificationMaster::where('receiver_id',$input['id'])->update(['is_view' => 1]);
                    }
                    // $data['result_data'] = $notiresult;
                    $keys = array_column($notiresult, 'created_at');
                    // array_multisort($keys, SORT_DESC, $data_gym);
                    $result = $this->ResponseWithPagination($page,$notiresult);
                    return $this->sendResponse($result, __('messages.api.notification.notification_get_success'));
                }
                else{
                    return $this->sendResponse(config('global.null_object'), __('messages.api.notification.notification_get_success'));
                }               
            
        }
        catch(\Exception $e)
        {
            $this->serviceLogError($service_name = 'NotificationList',$user_id = 0,$message = $e->getMessage(),$requested_field = json_encode($request->all()),$response_data=$e);
            return $this->sendError($e->getMessage(), config('global.null_object'),401,false);
        }
    }
}
?>    
