<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseAPIController as BaseAPIController;
use App\Models\User;
use App\Models\Service;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\DashboardAPIController;
use Validator;
use Illuminate\Support\Str;

class OrderAPIController extends BaseAPIController
{
    
    public function AddOrder(Request $request)
    {
        try
        {  
            if(Auth::guard('api')->check())
            {          
                $input = $request->all();  

                $auth_user = Auth::guard('api')->user();
                // echo "<pre>";
                // print_r($auth_user->id);die;
                if($auth_user->id!='' && $input['order_amount'] !='' && $input['order_discount_amount'] !=''){
                    $check_cart = Cart::where('user_id',$auth_user->id)
                    ->where('cart_status',0)
                    ->orderBy('created_at','desc')->get();

                    if(count($check_cart)>0)
                    {                    
                        $order_id = $this->generateUniqueOrderId($table='orders', $column="order_id");
                        
                        $input['order_id'] = $order_id;
                        $input['user_id'] = $auth_user->id;
                        $input['state_id'] = $auth_user->state_id;
                        $input['district_id'] = $auth_user->district_id;
                        $input['taluka_id'] = $auth_user->taluka_id;
                        $input['pincode_id'] = $auth_user->pincode_id;
                        $input['gst_number'] = $auth_user->gst_number;

                        $Order= Order::create($input);

                        $check_cart->map(function($pro) use ($Order){
                            $category_id = $pro->CategoryData->category_id;
                            $sub_categories_id = $pro->SubCategoryData->sub_categories_id;
                            // dd( $pro->CategoryData->category_id);
                            $service_id = $pro->ServiceData->service_id;
                            $ServiceDetails = $pro->ServiceData->ServiceDetails;
                            $ServiceDetailsarray= $ServiceDetails->sortByDesc('created_at')->values();
                            // $ServiceDetailsarray= $ServiceDetails->where('service_detail_id',$pro->service_detail_id)->sortByDesc('created_at')->values();
                            // echo "<pre>";
                            // print_r($ServiceDetailsarray);die;
                            // foreach($ServiceDetailsarray as $val){
                                // echo "<pre>";
                                // print_r($pro);die;
                                $order_detail_id = $this->GenerateUniqueRandomString($table='order_details', $column="order_detail_id", $chars=32);
                                    
                                        $detailinput = array(
                                            'order_detail_id'      => $order_detail_id,
                                            'order_id' =>  $Order->order_id,
                                            'category_id' => $category_id,
                                            'sub_categories_id' => $sub_categories_id,
                                            'service_id' => $service_id,
                                            'service_detail_id'  => $pro->service_detail_id,
                                            // 'order_original_price' =>$pro->ServiceData->service_original_price,
                                            // 'order_discount_price' =>$pro->ServiceData->service_discount_price,
                                            'order_original_price' =>$pro->cart_service_original_price,
                                            'order_discount_price' =>$pro->cart_service_discount_price,
                                            'order_quantity' =>$pro->cart_service_quantity,
                                            'order_unit' =>$pro->cart_service_unit,

                                        );
                                        // dd($detailinput);
                                        $OrderDetail = OrderDetail::create($detailinput);
                                    
                        // }
                            
                        });  

                        //------------------- activity log -----------------

                        $activity_log_id = $this->GenerateUniqueRandomString($table='activity_logs', $column="activity_log_id", $chars=32);
                        $input1['activity_log_id'] = $activity_log_id;
                        $input1['user_id'] = $auth_user->id;
                        $input1['order_id'] = $Order->order_id;
                        $input1['description'] = 'Hello! a request with Request ID "'. $Order->order_id.'" is PENDING to get accepted by Admin.';
                        $ActivityLog= ActivityLog::create($input1);

                        // $check_order_detail= OrderDetail::where('order_id',$Order->order_id)->where('order_details_status',0)->get();
                        $check_order_detail= Order::where('order_id',$Order->order_id)->with('OrderDetails')->where('order_status',0)->first();
                        $orderdetail =[];
                        foreach($check_order_detail->OrderDetails as $detail){
                            $orderdetail = array(
                                'order_detail_id'      => $detail->order_detail_id,
                                'order_id' =>   $detail->order_id,
                                'category_id' =>   $detail->category_id,
                                'sub_categories_id' =>   $detail->sub_categories_id,
                                'service_id' => $detail->service_id,
                                'service_detail_id'  => $detail->service_detail_id,
                                'order_original_price' =>$detail->order_original_price,
                                'order_discount_price' =>$detail->order_discount_price,
                                'order_quantity' =>$detail->order_quantity,
                                'order_unit' =>$detail->order_unit,
                                'order_details_status' =>$detail->order_details_status,
                                'created_at' =>$detail->created_at,
                                'updated_at' =>$detail->updated_at,
        
                            );
                        }
                        $check_order_detail->order_details = $orderdetail;
                        // echo "<pre>";
                        // print_r( $orderdetail);die;
                        // $check_order_detail->order_details = $orderdetail;
                        // Cart::where('user_id',$auth_user->id)->delete();
                        $order_data = $this->OrderResponse($check_order_detail);
                        return $this->sendResponse($order_data, __('messages.api.order.order_add_success'));
                    }
                    else
                    {
                        return $this->sendError(__('messages.api.cart.cart_not_found'), config('global.null_object'),200,false);
                    }

                }
                else{
                    return $this->sendError(__('messages.api.cart.service_not_found'), config('global.null_object'),226,false);
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
            $this->serviceLogError($service_name = 'AddOrder',$user_id = $auth_user->id,$message = $e->getMessage(),$requested_field = json_encode($request->all()),$response_data=$e);
            return $this->sendError($e->getMessage(), config('global.null_object'),401,false);
        }

    }
    
    public function OrderList(Request $request)
    {        
        try
        {  
            if(Auth::guard('api')->check())
            {          
                $input = $request->all();  
                $auth_user = Auth::guard('api')->user(); 
                $page = $input['page'];
                $order= Order::where('user_id',$auth_user->id)->where('order_status',0)->orderBy('created_at','desc')->get();
                // echo $order;
                // exit;

                
                $order->map(function($pro) use ($auth_user){


                    $order_details = $pro->OrderDetails->sortByDesc('created_at')->values();
                    
                    $order_details->map(function($order_details){

                        $order_original_price =$order_details->order_original_price;
                        $order_discount_price =$order_details->order_discount_price;

                        if($order_discount_price >0){
                            $order_per_discount = (($order_original_price - $order_discount_price) / $order_original_price) * 100;
                            
                                $order_per_discount = round($order_per_discount, 2);  
                            }
                            else{
                            $order_per_discount = 0;  
                            }  

                        $order_details->order_detail_id =($order_details->order_detail_id) ?$order_details->order_detail_id : '';

                        $order_details->order_id =($order_details->order_id) ?$order_details->order_id : '';

                        $order_details->category_id =($order_details->category_id) ?$order_details->category_id : '';

                        $order_details->sub_categories_id =($order_details->sub_categories_id) ?$order_details->sub_categories_id : '';

                        $order_details->service_id =($order_details->service_id) ?$order_details->service_id : '';

                        $order_details->service_detail_id =($order_details->service_detail_id) ?$order_details->service_detail_id : '';

                        $order_details->order_original_price =($order_details->order_original_price) ?$order_details->order_original_price : '';

                        $order_details->order_discount_price =($order_details->order_discount_price) ?$order_details->order_discount_price : '';
                        
                        $order_details->order_quantity =($order_details->order_quantity) ?$order_details->order_quantity : '';

                        $order_details->order_unit =($order_details->order_unit) ?$order_details->order_unit : '';

                        $order_details->order_details_status =($order_details->order_details_status) ?$order_details->order_details_status : 0;
                        
                        $order_details->order_per_discount = $order_per_discount;
                    });
                    // $order_details->makeHidden(['created_at','updated_at']);
                    $pro->order_details =$order_details;
                }); 

                // echo "<pre>";
                // print_r($order);die;
                $order_data = $this->OrderListResponse($order);
                $result = $this->ResponseWithPagination($page,$order_data);
                return $this->sendResponse($result, __('messages.api.order.order_get_success')); 
            
            }
            else
            {                
                return $this->sendError(__('messages.api.authentication_err_message'), config('global.null_object'),401,false);
            }
           
        }
        catch(\Exception $e)
        {
            $auth_user = Auth::guard('api')->user();
            $this->serviceLogError($service_name = 'OrderList',$user_id = $auth_user->id,$message = $e->getMessage(),$requested_field = json_encode($request->all()),$response_data=$e);
            return $this->sendError($e->getMessage(), config('global.null_object'),401,false);
        }
    }

    public function SingleOrderGet(Request $request)
    {
        try
        {  
            if(Auth::guard('api')->check())
            {          
                $input = $request->all();  

                // echo "<pre>";
                // print_r($input);die;
                $auth_user = Auth::guard('api')->user();
                // $orderdetail =[];
                if($input['order_id'] !=''){
                    
                    $check_order_detail= Order::where('order_id',$input['order_id'])->with('OrderDetails')->where('order_status',0)->first();

                    if($check_order_detail !=''){

                    // echo"<pre>";
                    // print_r($check_order_detail->OrderDetails);die;

                    foreach($check_order_detail->OrderDetails as $detail){
                        // $service = Service::where('service_status',0)->where('service_id',$detail->service_id)->first();
                        $service = Service::where('service_status', 0)
                        ->where('service_id', $detail->service_id)
                        ->leftJoin('categories', 'service.category_id', '=', 'categories.category_id')
                        ->leftJoin('sub_categories', 'service.sub_categories_id', '=', 'sub_categories.sub_categories_id')
                        ->select('service.*', 'categories.category_name as category_name', 'sub_categories.sub_categories_name as sub_categories_name')
                        ->first();
                        $service_single_image = '';
                        if(isset($service->service_single_image))
                        {   
                            // echo 'in';die;
                            $service_single_image = $this->GetImage( $service->service_single_image,$path=config('global.file_path.service_image'));
                        } 

                        $order_original_price =$detail->order_original_price;
                        $order_discount_price =$detail->order_discount_price;

                        if($order_discount_price >0){
                            $order_per_discount = (($order_original_price - $order_discount_price) / $order_original_price) * 100;
                            
                                $order_per_discount = round($order_per_discount, 2);  
                            }
                            else{
                            $order_per_discount = 0;  
                            }  


                        $orderdetail []= array(
                            'order_detail_id'      => $detail->order_detail_id,
                            'order_id' =>   $detail->order_id,
                            'category_id' =>   $detail->category_id,
                            'category_name' =>   $service->category_name,
                            'sub_categories_id' =>   $detail->sub_categories_id,
                            'sub_categories_name' =>   $service->sub_categories_name,
                            'service_id' => $detail->service_id,                           
                            'service_name' =>  $service->service_name,
                            'service_image' =>  $service_single_image,
                            'service_detail_id'  => $detail->service_detail_id,
                            'order_original_price' =>$detail->order_original_price,
                            'order_discount_price' =>$detail->order_discount_price,
                            'order_quantity' =>$detail->order_quantity,
                            'order_unit' =>$detail->order_unit,
                            'order_details_status' =>$detail->order_details_status,
                            'created_at' =>$detail->created_at,
                            'updated_at' =>$detail->updated_at,
                            'order_per_discount' => $order_per_discount,
                            
    
                        );
                    }
                    $check_order_detail->order_details = $orderdetail;
                    // echo "<pre>";
                    // print_r( $check_order_detail);die;

                    $order_data = $this->OrderResponse($check_order_detail);
                    return $this->sendResponse($order_data, __('messages.api.order.order_get_success'));

                }
                else{
                    return $this->sendError(__('messages.api.order.order_not_found'), config('global.null_object'),226,false);
                }
                }
                else{
                    return $this->sendError(__('messages.api.order.order_not_found'), config('global.null_object'),226,false);
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
            $this->serviceLogError($service_name = 'SingleOrderGet',$user_id = $auth_user->id,$message = $e->getMessage(),$requested_field = json_encode($request->all()),$response_data=$e);
            return $this->sendError($e->getMessage(), config('global.null_object'),401,false);
        }

    }

    public function UpcomingOrderList(Request $request)
    {        
        try
        {  
            if(Auth::guard('api')->check())
            {          
                $input = $request->all();  
                $auth_user = Auth::guard('api')->user(); 
                $page = $input['page'];
                // $order= Order::where('order_status',0)->orderBy('created_at','desc')->get();
                $order = Order::where('user_id',$auth_user->id)->whereIn('order_type',[1,2,3])->where('order_status',0)->orderBy('created_at','desc')->get();
                
                $order->map(function($pro) use ($auth_user){


                    $order_details = $pro->OrderDetails->sortByDesc('created_at')->values();
                    $order_details->map(function($order_details){

                        $order_details->order_detail_id =($order_details->order_detail_id) ?$order_details->order_detail_id : '';

                        $order_details->order_id =($order_details->order_id) ?$order_details->order_id : '';

                        $order_details->service_id =($order_details->service_id) ?$order_details->service_id : '';

                        $order_details->service_detail_id =($order_details->service_detail_id) ?$order_details->service_detail_id : '';

                        $order_details->order_original_price =($order_details->order_original_price) ?$order_details->order_original_price : '';

                        $order_details->order_discount_price =($order_details->order_discount_price) ?$order_details->order_discount_price : '';
                        
                        $order_details->order_quantity =($order_details->order_quantity) ?$order_details->order_quantity : '';

                        $order_details->order_unit =($order_details->order_unit) ?$order_details->order_unit : '';

                        $order_details->order_details_status =($order_details->order_details_status) ?$order_details->order_details_status : 0;
                    });
                    // $order_details->makeHidden(['created_at','updated_at']);
                    $pro->order_details =$order_details;
                }); 

                // echo "<pre>";
                // print_r($order);die;
                $order_data = $this->OrderListResponse($order);
                return $this->ResponseWithPaginationorder($page,$order_data, __('messages.api.order.order_get_success'));
                // return $this->sendorderResponse($$order_data,$page, __('messages.api.order.order_get_success')); 
            
            }
            else
            {                
                return $this->sendError(__('messages.api.authentication_err_message'), config('global.null_object'),401,false);
            }
           
        }
        catch(\Exception $e)
        {
            $auth_user = Auth::guard('api')->user();
            $this->serviceLogError($service_name = 'UpcomingOrderList',$user_id = $auth_user->id,$message = $e->getMessage(),$requested_field = json_encode($request->all()),$response_data=$e);
            return $this->sendError($e->getMessage(), config('global.null_object'),401,false);
        }
    }
    
    public function OlderOrderList(Request $request)
    {        
        try
        {  
            if(Auth::guard('api')->check())
            {          
                $input = $request->all();  
                $auth_user = Auth::guard('api')->user(); 
                $page = $input['page'];
                // $order= Order::where('order_status',0)->orderBy('created_at','desc')->get();
                $order = Order::where('user_id',$auth_user->id)->whereIn('order_type',[4,5])->where('order_status',0)->orderBy('created_at','desc')->get();
                
                $order->map(function($pro) use ($auth_user){

                    $order_details = $pro->OrderDetails->sortByDesc('created_at')->values();
                    $order_details->map(function($order_details){

                        $order_details->order_detail_id =($order_details->order_detail_id) ?$order_details->order_detail_id : '';

                        $order_details->order_id =($order_details->order_id) ?$order_details->order_id : '';

                        $order_details->service_id =($order_details->service_id) ?$order_details->service_id : '';

                        $order_details->service_detail_id =($order_details->service_detail_id) ?$order_details->service_detail_id : '';

                        $order_details->order_original_price =($order_details->order_original_price) ?$order_details->order_original_price : '';

                        $order_details->order_discount_price =($order_details->order_discount_price) ?$order_details->order_discount_price : '';
                        
                        $order_details->order_quantity =($order_details->order_quantity) ?$order_details->order_quantity : '';

                        $order_details->order_unit =($order_details->order_unit) ?$order_details->order_unit : '';

                        $order_details->order_details_status =($order_details->order_details_status) ?$order_details->order_details_status : 0;
                    });
                    // $order_details->makeHidden(['created_at','updated_at']);
                    $pro->order_details =$order_details;
                }); 

                // echo "<pre>";
                // print_r($order);die;
                $order_data = $this->OrderListResponse($order);
                // $result = $this->ResponseWithPagination($page,$order_data);
                // return $this->sendResponse($result, __('messages.api.order.order_get_success')); 
                return $this->ResponseWithPaginationorder($page,$order_data, __('messages.api.order.order_get_success'));
            
            }
            else
            {                
                return $this->sendError(__('messages.api.authentication_err_message'), config('global.null_object'),401,false);
            }
           
        }
        catch(\Exception $e)
        {
            $auth_user = Auth::guard('api')->user();
            $this->serviceLogError($service_name = 'OlderOrderList',$user_id = $auth_user->id,$message = $e->getMessage(),$requested_field = json_encode($request->all()),$response_data=$e);
            return $this->sendError($e->getMessage(), config('global.null_object'),401,false);
        }
    }
    
    public function UpdateOrderStatus(Request $request)
    {
        try
        {
            if(Auth::guard('api')->check())
            {
                $input = $request->all();
                $auth_user = Auth::guard('api')->user();

                $check_order= Order::where('user_id',$auth_user->id)->where('order_id',$input['order_id'])->where('order_status',0)->first();

                if($check_order !=''){               

                    Order::where('order_id',$input['order_id'])->where('user_id',$auth_user->id)->update(['order_type' =>$input['order_type'],'cancel_reason' =>$input['cancel_reason']]);

                
                $check_order_detail= Order::where('user_id',$auth_user->id)->where('order_id',$input['order_id'])->with('OrderDetails')->where('order_status',0)->first();

                foreach($check_order_detail->OrderDetails as $detail){
                    $orderdetail = array(
                        'order_detail_id'      => $detail->order_detail_id,
                        'order_id' =>   $detail->order_id,
                        'service_id' => $detail->service_id,
                        'service_detail_id'  => $detail->service_detail_id,
                        'order_original_price' =>$detail->order_original_price,
                        'order_discount_price' =>$detail->order_discount_price,
                        'order_quantity' =>$detail->order_quantity,
                        'order_unit' =>$detail->order_unit,
                        'order_details_status' =>$detail->order_details_status,
                        'created_at' =>$detail->created_at,
                        'updated_at' =>$detail->updated_at,

                    );
                }
                
                $check_order_detail->order_details = $orderdetail;
                // echo "<pre>";
                // print_r( $check_order_detail);die;

                if($check_order_detail->order_type == 5){
                    $order_data = $this->OrderResponse($check_order_detail);
                    return $this->sendResponse($order_data, __('messages.api.order.order_cancel_success'));  
                }
                else{
                    $order_data = $this->OrderResponse($check_order_detail);
                    return $this->sendResponse($order_data, __('messages.api.order.order_status_update_success'));     
                }
            }
            else{
                return $this->sendError(__('messages.api.order.order_not_found'), config('global.null_object'),226,false);
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
            $this->serviceLogError($service_name = 'UpdateOrderStatus',$user_id = $auth_user->id,$message = $e->getMessage(),$requested_field = json_encode($request->all()),$response_data=$e);
            return $this->sendError($e->getMessage(), config('global.null_object'),401,false);
        }
    }
}
