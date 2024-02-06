<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseAPIController as BaseAPIController;
use App\Models\User;
use App\Models\Settings;
use App\Models\State;
use App\Models\District;
use App\Models\Talukas;
use App\Models\Pincode;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\DashboardAPIController;
use Validator;
use Illuminate\Support\Str;

class SettingAPIController extends BaseAPIController
{
    public function SettingList(Request $request)
    {        
        try
        {            
            $input = $request->all();  
            $setting = Settings::where('is_disable',0)->orderBy('created_at','desc')->first();
            $data_setting = $this->SettingResponse($setting);
            // $keys = array_column($data_complaint, 'created_at');
            // $result = $this->ResponseWithPagination($page,$data_complaint);
            return $this->sendResponse($data_setting, __('messages.api.setting.setting_get_success'));                
           
        }
        catch(\Exception $e)
        {
            $auth_user = Auth::guard('api')->user();
            $this->serviceLogError($service_name = 'SettingList',$user_id = 0,$message = $e->getMessage(),$requested_field = json_encode($request->all()),$response_data=$e);
            return $this->sendError($e->getMessage(), config('global.null_object'),401,false);
        }
    }

    public function StateList(Request $request)
    {    
        try
        {
                $input = $request->all();            
                              
                // $page           = $input['page'];                    
                $data_state = State::where('state_status',0)->get();
                $result = $this->GetStateData($data_state);
                // $keys = array_column($data_state, 'created_at');
                // $result = $this->ResponseWithPagination($page,$data_state);
                return $this->sendResponse($result, __('messages.api.state.state_get_success'));          
        }
        catch(\Exception $e)
        {
            $auth_user = Auth::guard('api')->user();
            $this->serviceLogError($service_name = 'StateList',$user_id = 0,$message = $e->getMessage(),$requested_field = json_encode($request->all()),$response_data=$e);
            return $this->sendError($e->getMessage(), config('global.null_object'),401,false);
        }
    }
    public function DistrictList(Request $request)
    {    
        try
        {
                $input = $request->all();            
                                                
                $data_district = District::where('state_id',$input['state_id'])->where('district_status',0)->get();
                $result = $this->GetDistrictListData($data_district);
                return $this->sendResponse($result, __('messages.api.district.district_get_success'));          
        }
        catch(\Exception $e)
        {
            $auth_user = Auth::guard('api')->user();
            $this->serviceLogError($service_name = 'DistrictList',$user_id = 0,$message = $e->getMessage(),$requested_field = json_encode($request->all()),$response_data=$e);
            return $this->sendError($e->getMessage(), config('global.null_object'),401,false);
        }
    }
    
    public function TalukaList(Request $request)
    {    
        try
        {
                $input = $request->all();            
                                                
                $data_taluka = Talukas::where('district_id',$input['district_id'])->where('taluka_status',0)->get();
                $result = $this->GetTalukaListData($data_taluka);
                return $this->sendResponse($result, __('messages.api.taluka.taluka_get_success'));          
        }
        catch(\Exception $e)
        {
            $auth_user = Auth::guard('api')->user();
            $this->serviceLogError($service_name = 'TalukaList',$user_id = 0,$message = $e->getMessage(),$requested_field = json_encode($request->all()),$response_data=$e);
            return $this->sendError($e->getMessage(), config('global.null_object'),401,false);
        }
    }
    public function PincodeList(Request $request)
    {    
        try
        {
            $input = $request->all();            
                                            
            $data_pincode = Pincode::where('taluka_id',$input['taluka_id'])->where('pincode_status',0)->get();
            $result = $this->GetPincodeListData($data_pincode);
            return $this->sendResponse($result, __('messages.api.pincode.pincode_get_success'));          
        }
        catch(\Exception $e)
        {
            $auth_user = Auth::guard('api')->user();
            $this->serviceLogError($service_name = 'PincodeList',$user_id = 0,$message = $e->getMessage(),$requested_field = json_encode($request->all()),$response_data=$e);
            return $this->sendError($e->getMessage(), config('global.null_object'),401,false);
        }
    }

    public function TestimonialList(Request $request)
    {    
        try
        {
            $input = $request->all();            
                                            
            $data_testimonial = Testimonial::where('testimonial_status',0)->get();
            $result = $this->GetTestimonialListData($data_testimonial);
            return $this->sendResponse($result, __('messages.api.testimonial.testimonial_get_success'));          
        }
        catch(\Exception $e)
        {
            $auth_user = Auth::guard('api')->user();
            $this->serviceLogError($service_name = 'TestimonialList',$user_id = 0,$message = $e->getMessage(),$requested_field = json_encode($request->all()),$response_data=$e);
            return $this->sendError($e->getMessage(), config('global.null_object'),401,false);
        }
    }
    
    public function TestimonialFilter(Request $request)
    {   
        try
        {
            
            $input = $request->all();    
            //  dd($input);
            
            $query = Testimonial::query();

            if ($input['category_id']) {
                $query->where('category_id', $input['category_id']);
                
            }
            if ($input['service_id']) {
                $query->where('service_id', $input['service_id']);
            }

            if ( $input['state_id']) {
                $query->where('state_id', $input['state_id']);                    
            }

            if ($input['district_id']) {
                $query->where('district_id', $input['district_id']);
            }
            if ($input['taluka_id']) {
                $query->where('taluka_id', $input['taluka_id']);
            }
            if ($input['pincode_id']) {
                $query->where('pincode_id', $input['pincode_id']);
            }

            $data_testimonial = $query->where('testimonial_status',0)->get();
            $result = $this->GetTestimonialListData($data_testimonial);
            return $this->sendResponse($result, __('messages.api.testimonial.testimonial_get_success'));           
                  
        }
        catch(\Exception $e)
        {
            $auth_user = Auth::guard('api')->user();
            $this->serviceLogError($service_name = 'TestimonialFilter',$user_id = 0,$message = $e->getMessage(),$requested_field = json_encode($request->all()),$response_data=$e);
            return $this->sendError($e->getMessage(), config('global.null_object'),401,false);
        }
    }

    
}
