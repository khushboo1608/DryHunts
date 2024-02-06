<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseAPIController as BaseAPIController;
use App\Models\User;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\DashboardAPIController;
use Validator;
use Illuminate\Support\Str;

class CategoryAPIController extends BaseAPIController
{
    public function CategoryList(Request $request)
    {        
        try
        {  
            if(Auth::guard('api')->check())
            {          
                $input = $request->all();  
                $auth_user = Auth::guard('api')->user(); 
                // $page           = $input['page'];
                $category = Category::where('category_status',0)->orderBy('created_at','desc')->get();
                $result = $this->CategoryListResponse($category);
                // $result = $this->ResponseWithPagination($page,$data_category);
                return $this->sendResponse($result, __('messages.api.category.category_get_success'));  
            
            }
            else
            {                
                return $this->sendError(__('messages.api.authentication_err_message'), config('global.null_object'),401,false);
            }
           
        }
        catch(\Exception $e)
        {
            $auth_user = Auth::guard('api')->user();
            $this->serviceLogError($service_name = 'CategoryList',$user_id = $auth_user->id,$message = $e->getMessage(),$requested_field = json_encode($request->all()),$response_data=$e);
            return $this->sendError($e->getMessage(), config('global.null_object'),401,false);
        }
    }

    public function SubCategoryList(Request $request)
    {        
        try
        {  
            if(Auth::guard('api')->check())
            {          
                $input = $request->all();  
                $auth_user = Auth::guard('api')->user(); 
                $page           = $input['page'];
                $category = SubCategory::where('category_id',$input['category_id'])->where('sub_category_status',0)->orderBy('created_at','desc')->get();
                $data_category = $this->SubCategoryListResponse($category);
                $result = $this->ResponseWithPagination($page,$data_category);
                return $this->sendResponse($result, __('messages.api.category.sub_category_get_success'));  
            
            }
            else
            {                
                return $this->sendError(__('messages.api.authentication_err_message'), config('global.null_object'),401,false);
            }
           
        }
        catch(\Exception $e)
        {
            $auth_user = Auth::guard('api')->user();
            $this->serviceLogError($service_name = 'SubCategoryList',$user_id = $auth_user->id,$message = $e->getMessage(),$requested_field = json_encode($request->all()),$response_data=$e);
            return $this->sendError($e->getMessage(), config('global.null_object'),401,false);
        }
    }

    
}
