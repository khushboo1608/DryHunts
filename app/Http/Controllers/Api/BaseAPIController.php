<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller as Controller;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class BaseAPIController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message)
    {
    	$response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];
        return response()->json($response, 200);
    }

    public function sendResponsecart($result, $message)
    {
        $total_Discount = 0;
        foreach($result as $val){
            $total_Discounts = $val['cart_service_quantity']*$val['cart_service_discount_price'];
            $total_Discount += $total_Discounts;
        }
        $total_Amount = 0;
        foreach($result as $val){
            $total_Amounts = $val['cart_service_quantity']*$val['cart_service_original_price'];
            $total_Amount += $total_Amounts;
        }
    	$response = [
            'success' => true,
            'total_Amount'    => $total_Amount,
            'total_Discount'    => $total_Discount,
            'data'    => $result,
            'message' => $message,
        ];
        return response()->json($response, 200);
    }
    

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
    	$response = [
            'success' => false,
            'message' => $error,
        ];


        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }


        return response()->json($response, $code);
    }
    public function serviceLogError($service_name = 'service_name',$user_id = 0,$message = 'message',$requested_field = 'requested_field',$response_data="response_data")
    {
        $service_error_log = [
            'service_name'      => $service_name,
            'user_id'           => $user_id,
            'message'           => $message,
            'requested_field'   => $requested_field,
            'response_data'     => $response_data,
            'created_at'        => Carbon::now(),
            'updated_at'        => Carbon::now()
        ];
        DB::table('service_error_log')->insert($service_error_log);
    }
}
