<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseAPIController as BaseAPIController;
use App\Models\User;
use App\Models\Banner;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\DashboardAPIController;
use Validator;
use Illuminate\Support\Str;

class BannerAPIController extends BaseAPIController
{
   
    public function BannerList(Request $request)
    {    
        try
        {
                $input = $request->all();            
                              
                // $page           = $input['page'];                    
                $data_Banner = Banner::where('banner_status',0)->get();
                $result = $this->GetBannerData($data_Banner);
                // $keys = array_column($data_Banner, 'created_at');
                // $result = $this->ResponseWithPagination($page,$data_Banner);
                return $this->sendResponse($result, __('messages.api.banner.banner_get_success'));          
        }
        catch(\Exception $e)
        {
            $auth_user = Auth::guard('api')->user();
            $this->serviceLogError($service_name = 'BannerList',$user_id = 0,$message = $e->getMessage(),$requested_field = json_encode($request->all()),$response_data=$e);
            return $this->sendError($e->getMessage(), config('global.null_object'),401,false);
        }
    }

    
}
