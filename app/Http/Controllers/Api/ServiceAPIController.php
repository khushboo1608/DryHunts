<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseAPIController as BaseAPIController;
use App\Models\User;
use App\Models\Service;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\DashboardAPIController;
use Validator;
use Illuminate\Support\Str;

class ServiceAPIController extends BaseAPIController
{
    public function ServiceList(Request $request)
    {        
        try
        {  
            if(Auth::guard('api')->check())
            {          
                $input = $request->all();  
                $auth_user = Auth::guard('api')->user(); 
                $page = $input['page'];
                $service = Service::where('category_id',$input['category_id'])->where('service_status',0)->orderBy('created_at','desc')->get();
                $service->map(function($pro) use ($auth_user){

                    $pro->category_name = $pro->CategoryData->category_name;

                    $service_details = $pro->ServiceDetails->sortByDesc('created_at')->values();
                    $service_details->map(function($service_details){
                        $service_details->service_original_price =($service_details->service_original_price) ?$service_details->service_original_price : '';

                        $service_details->service_discount_price =($service_details->service_discount_price) ?$service_details->service_discount_price : '';

                        $service_details->service_unit =($service_details->service_unit) ?$service_details->service_unit : '';

                        $service_original_price =$service_details->service_original_price;
                        $service_discount_price =$service_details->service_discount_price;

                        if($service_discount_price >0){
                            $servicediscountPercentage = (($service_original_price - $service_discount_price) / $service_original_price) * 100;
                            
                            $servicediscountPercentage = round($servicediscountPercentage, 2);  
                        }
                        else{
                            $servicediscountPercentage = 0;  
                        }  
                        $service_details->service_percentage =$servicediscountPercentage;
                    });
                    $service_details->makeHidden(['created_at','updated_at']);
                    $pro->service_details =$service_details;
                });  
                $data_service = $this->ServiceListResponse($service);
                $result = $this->ResponseWithPagination($page,$data_service);
                return $this->sendResponse($result, __('messages.api.service.service_get_success')); 
            
            }
            else
            {                
                return $this->sendError(__('messages.api.authentication_err_message'), config('global.null_object'),401,false);
            }
           
        }
        catch(\Exception $e)
        {
            $auth_user = Auth::guard('api')->user();
            $this->serviceLogError($service_name = 'ServiceList',$user_id = $auth_user->id,$message = $e->getMessage(),$requested_field = json_encode($request->all()),$response_data=$e);
            return $this->sendError($e->getMessage(), config('global.null_object'),401,false);
        }
    }

    public function ServiceSingleDetails(Request $request)
    {        
        try
        {  
            if(Auth::guard('api')->check())
            {          
                $input = $request->all();  
                $auth_user = Auth::guard('api')->user(); 
                $service_id          = $input['service_id'];
                $service = Service::where('service_status',0)->where('service_id',$service_id)->first();
                    $service->category_name   = $service->CategoryData->category_name;
                    $service_details = $service->ServiceDetails->sortByDesc('created_at')->values();
                    $service_details->map(function($service_details){
                        $service_details->service_original_price =($service_details->service_original_price) ?$service_details->service_original_price : '';

                        $service_details->service_discount_price =($service_details->service_discount_price) ?$service_details->service_discount_price : '';

                        $service_details->service_unit =($service_details->service_unit) ?$service_details->service_unit : '';

                        $service_original_price =$service_details->service_original_price;
                        $service_discount_price =$service_details->service_discount_price;

                        if($service_discount_price >0){
                            $servicediscountPercentage = (($service_original_price - $service_discount_price) / $service_original_price) * 100;         
                            $servicediscountPercentage = round($servicediscountPercentage, 2);  
                        }
                        else{
                            $servicediscountPercentage = 0;  
                        }  
                        $service_details->service_percentage =$servicediscountPercentage;
                    });
                    $service_details->makeHidden(['created_at','updated_at']);
                    $service->service_details =$service_details;
                $result = $this->ServiceResponse($service);
                return $this->sendResponse($result, __('messages.api.service.service_get_success')); 
            
            }
            else
            {                
                return $this->sendError(__('messages.api.authentication_err_message'), config('global.null_object'),401,false);
            }
           
        }
        catch(\Exception $e)
        {
            $auth_user = Auth::guard('api')->user();
            $this->serviceLogError($service_name = 'ServiceSingleDetails',$user_id = $auth_user->id,$message = $e->getMessage(),$requested_field = json_encode($request->all()),$response_data=$e);
            return $this->sendError($e->getMessage(), config('global.null_object'),401,false);
        }
    }

    public function ServiceSearch(Request $request)
    {        
        try
        {
            if(Auth::guard('api')->check())
            {
                $input = $request->all();   
                
                $auth_user = Auth::guard('api')->user();           
                              
                    $page           = $input['page'];
                    $search_word = $request->search_word;

                    $service  = Service::where('service_status',0)->get();
                    $service->map(function($pro) use ($auth_user){

                        $pro->category_name = $pro->CategoryData->category_name;
    
                        $service_details = $pro->ServiceDetails->sortByDesc('created_at')->values();
                        $service_details->map(function($service_details){
                            $service_details->service_original_price =($service_details->service_original_price) ?$service_details->service_original_price : '';
    
                            $service_details->service_discount_price =($service_details->service_discount_price) ?$service_details->service_discount_price : '';
    
                            $service_details->service_unit =($service_details->service_unit) ?$service_details->service_unit : '';
    
                            $service_original_price =$service_details->service_original_price;
                            $service_discount_price =$service_details->service_discount_price;
    
                            if($service_discount_price >0){
                                $servicediscountPercentage = (($service_original_price - $service_discount_price) / $service_original_price) * 100;
                                
                                $servicediscountPercentage = round($servicediscountPercentage, 2);  
                            }
                            else{
                                $servicediscountPercentage = 0;  
                            }  
                            $service_details->service_percentage =$servicediscountPercentage;
                        });
                        $service_details->makeHidden(['created_at','updated_at']);
                        $pro->service_details =$service_details;
                    });  
                    $data_service = $this->ServiceListResponse($service);
                    if($search_word != '')
                    {
                        if(count($data_service) > 0)
                        {
                            $data_service = array_filter($data_service, function ($var) use ($search_word) {
                                return (stripos($var['service_name'], $search_word) !== false);
                            });
                        }
                    }
                 
                    $keys = array_column($data_service, 'created_at');
                    // array_multisort($keys, SORT_DESC, $data_service);
                    $result = $this->ResponseWithPagination($page,$data_service);
                    return $this->sendResponse($result, __('messages.api.service.service_get_success'));                
            }
            else
            {
                return $this->sendError(__('messages.api.authentication_err_message'), config('global.null_object'),401,false);
            }
        }
        catch(\Exception $e)
        {
            $auth_user = Auth::guard('api')->user();
            $this->serviceLogError($service_name = 'ServiceSearch',$user_id = $auth_user->id,$message = $e->getMessage(),$requested_field = json_encode($request->all()),$response_data=$e);
            return $this->sendError($e->getMessage(), config('global.null_object'),401,false);
        }
    }

    public function PopularServiceList(Request $request)
    {        
        try
        {  
            if(Auth::guard('api')->check())
            {          
                $input = $request->all();  
                $auth_user = Auth::guard('api')->user(); 
                // $page = $input['page'];
                $service = Service::where('is_popular',1)->where('service_status',0)->orderBy('created_at','desc')->get();
                $service->map(function($pro) use ($auth_user){

                    $pro->category_name = $pro->CategoryData->category_name;

                    $service_details = $pro->ServiceDetails->sortByDesc('created_at')->values();
                    $service_details->map(function($service_details){
                        $service_details->service_original_price =($service_details->service_original_price) ?$service_details->service_original_price : '';

                        $service_details->service_discount_price =($service_details->service_discount_price) ?$service_details->service_discount_price : '';

                        $service_details->service_unit =($service_details->service_unit) ?$service_details->service_unit : '';

                        $service_original_price =$service_details->service_original_price;
                        $service_discount_price =$service_details->service_discount_price;

                        if($service_discount_price >0){
                            $servicediscountPercentage = (($service_original_price - $service_discount_price) / $service_original_price) * 100;
                            
                            $servicediscountPercentage = round($servicediscountPercentage, 2);  
                        }
                        else{
                            $servicediscountPercentage = 0;  
                        }  
                        $service_details->service_percentage =$servicediscountPercentage;
                    });
                    $service_details->makeHidden(['created_at','updated_at']);
                    $pro->service_details =$service_details;
                });  
                $result = $this->ServiceListResponse($service);
                // $result = $this->ResponseWithPagination($page,$data_service);
                return $this->sendResponse($result, __('messages.api.service.service_get_success')); 
            
            }
            else
            {                
                return $this->sendError(__('messages.api.authentication_err_message'), config('global.null_object'),401,false);
            }
           
        }
        catch(\Exception $e)
        {
            $auth_user = Auth::guard('api')->user();
            $this->serviceLogError($service_name = 'PopularServiceList',$user_id = $auth_user->id,$message = $e->getMessage(),$requested_field = json_encode($request->all()),$response_data=$e);
            return $this->sendError($e->getMessage(), config('global.null_object'),401,false);
        }
    }

    public function CategoryServiceList(Request $request)
    {        
        try
        {  
            if(Auth::guard('api')->check())
            {          
                $input = $request->all();  
                $auth_user = Auth::guard('api')->user(); 
                $service = Service::where('category_id',$input['category_id'])->where('service_status',0)->orderBy('created_at','desc')->get();
               
                $data_service = $this->CategoryServiceListResponse($service);
                return $this->sendResponse($data_service, __('messages.api.service.service_get_success')); 
            
            }
            else
            {                
                return $this->sendError(__('messages.api.authentication_err_message'), config('global.null_object'),401,false);
            }
           
        }
        catch(\Exception $e)
        {
            $auth_user = Auth::guard('api')->user();
            $this->serviceLogError($service_name = 'CategoryServiceList',$user_id = $auth_user->id,$message = $e->getMessage(),$requested_field = json_encode($request->all()),$response_data=$e);
            return $this->sendError($e->getMessage(), config('global.null_object'),401,false);
        }
    }



    
}
