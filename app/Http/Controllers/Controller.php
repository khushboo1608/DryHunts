<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Str;
use Storage;
use DB;
use App\Models\User;
use App\Models\UserAuthMaster;
use App\Models\BookingDetails;
use App\Models\Booking;
use DateTime;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public function UploadImage($file,$path)
    {
        if($file)
        {  
            $fname = $file->getClientOriginalName();
            $image_name = time().'_'.$fname;

            // echo $path;die;
            $local_path = public_path($path);
            $file->move($local_path, $image_name);
            return $image_name;   
        }
        else
        {
            return '';
        }
    }
    
    public function UploadImageBase64($base64file,$path)
    {
        $data = $base64file;
        $image_name = time().'.png';
        list($type, $data) = explode(';', $data);
        list(, $data)      = explode(',', $data);
        $data = base64_decode($data);
        if($data)
        {      
            if(env('IMAGE_UPLOAD_PATH') == 'FOLDER')
            {   
                $local_path = public_path($path);
                file_put_contents($local_path.'/'.$image_name,$data);
                return $image_name;
            }
            else
            {
                return '';
            }
        }
        else
        {
            return '';
        }
    }
    
    public function GetImage($file_name,$path)
    {
        if($file_name != '')
        {
            if(file_exists(public_path($path.'/'.$file_name)))
			{
				return url('public').'/'.$path.'/'.$file_name; 
			}
			else
			{
                return '';
			}
        }
        else
        {
            return '';
        }
    }
    
    public static function GenerateUniqueRandomString($table, $column, $chars)
    {
        $unique = false;
        do{
            $randomStr = Str::random($chars);
            $match = DB::table($table)->where($column, $randomStr)->first();
            if($match)
            {
                continue;
            }
            $unique = true;
        }
        while(!$unique);
        return $randomStr;
    }
    
    public function SentMobileVerificationCode($mobile , $opt)
    {
        $YourAPIKey =env('SMS_API_KEY');
        $agent= 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';
        
         $url = "https://2factor.in/API/V1/$YourAPIKey/SMS/$mobile/$opt/sentotp" ;
        

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERAGENT =>$agent,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30000,                  
        ));
        $response = curl_exec($curl);
        $result = json_decode($response);

        $err = curl_error($curl);
        curl_close($curl);
        if($err)
        {
            return array('flag'=>'error','data'=>$err);
        }
        else
        {            
            return array('flag'=>'success','data'=>$result);
        }
    }

    public function UserResponse($response)
    {
        $imageurl = '';
        if(isset($response->imageurl))
        {   
            $imageurl = $this->GetImage($response->imageurl,$path=config('global.file_path.user_profile'));
        }
        $data = [
            'user_id'           => (int)$response->id,
            'login_type'         => (isset($response->login_type) && $response->login_type != null) ? $response->login_type : '',
            'email'             => (isset($response->email) && $response->email != null) ? $response->email : '',
            'name'        => (isset($response->name) && $response->name != null) ? $response->name : '',
            'phone'             => (isset($response->phone) && $response->phone != null) ? $response->phone : '',
            'otp'             => (isset($response->otp) && $response->otp != null) ? $response->otp :0,
            'state_id'             => (isset($response->state_id) && $response->state_id != null) ? $response->state_id :"",
            'district_id'             => (isset($response->district_id) && $response->district_id != null) ? $response->district_id :"",
            'taluka_id'             => (isset($response->taluka_id) && $response->taluka_id != null) ? $response->taluka_id :"",
            'pincode_id'             => (isset($response->pincode_id) && $response->pincode_id != null) ? $response->pincode_id :"",
            'gst_number'             => (isset($response->gst_number) && $response->gst_number != null) ? $response->gst_number :0,
            'wallet'             => (isset($response->wallet) && $response->wallet != null) ? $response->wallet :0,            
            'is_verified'             => (isset($response->is_verified) && $response->is_verified != null) ? $response->is_verified : 0,
            'imageurl'     => $imageurl,
            'Authorization'     => (isset($response->token) &&$response->token != null) ? 'Bearer '.$response->token : '',
            'firebase_uid'      => (isset($response->firebase_uid) && $response->firebase_uid != null) ? $response->firebase_uid : '',
            'is_disable'=> (isset($response->is_disable) && $response->is_disable != null) ? $response->is_disable : 0,
        ];
        return $data;
    }

    public function RemoveImage($name,$path)
    {        
        $file = $path.'/'.$name;
        if($name !=''){
            Storage::disk('public')->delete($file);
        }
        
    }
    public function ResponseWithPagination($page,$data)
    {
        $per_page = env('PER_PAGE');
        $current_page = ($page == 0) ? 1 : $page;
        // $response['total_page'] = round(count($data)/10,2);
        $response['total_record'] = count($data);
        $response['data_list'] = array_slice($data , ($current_page * $per_page) - $per_page, $per_page);
        return $response;
    }

    public function ResponseWithPaginationorder($page,$data,$message)
    {
        $per_page = env('PER_PAGE');
        $current_page = ($page == 0) ? 1 : $page;
        // $response['total_page'] = round(count($data)/10,2);
        $response['total_record'] = count($data);
        $response['data_list'] = array_slice($data , ($current_page * $per_page) - $per_page, $per_page);
        $response['success'] = true;
        $response['message'] = $message;
        return $response;
    }
         
    public function getLocalTime($str, $timezone) {
        $datetime = date("Y-m-d H:i:s" , $str);
        $given = new \DateTime($datetime, new \DateTimeZone("UTC"));
        $given->setTimezone(new \DateTimeZone($timezone));
        return $given->format("Y-m-d H:i:s");
    }

    public function CategoryResponse($response)
    {
        $category_image = '';
        if(isset($response->category_image))
        {   
            $category_image = $this->GetImage($response->category_image,$path=config('global.file_path.category_image'));
        } 

        $created_at =$this->getLocalTime(strtotime($response->created_at), 'Asia/Kolkata');
        $updated_at =  $this->getLocalTime(strtotime($response->updated_at), 'Asia/Kolkata'); 
        $data = [
            'category_id'           => ($response->category_id ) ? $response->category_id  : '',
            'category_image'  =>$category_image,    
            'category_name'        => ($response->category_name) ? $response->category_name : '',
            'created_at'            => $created_at,
            'updated_at'            => $updated_at,
            'category_status'            => ($response->category_status) ? $response->category_status:0,
        ];
        return $data;
    }

    public function SubCategoryResponse($response)
    {
        $subcategory_image = '';
        if(isset($response->sub_categories_image))
        {   
            $subcategory_image = $this->GetImage($response->sub_categories_image, $path = config('global.file_path.sub_category_image'));
        } 
    
        $created_at = $this->getLocalTime(strtotime($response->created_at), 'Asia/Kolkata');
        $updated_at = $this->getLocalTime(strtotime($response->updated_at), 'Asia/Kolkata'); 
    
        $data = [
            'sub_categories_id'      => ($response->sub_categories_id ) ? $response->sub_categories_id  : '',
            'category_id'            => ($response->category_id ) ? $response->category_id  : '',
            'category_name'          => ($response->category_name) ? $response->category_name : '',       
            'sub_categories_name'    => ($response->sub_categories_name) ? $response->sub_categories_name : '',
            'sub_categories_image'   => $subcategory_image,
            'created_at'             => $created_at,
            'updated_at'             => $updated_at,
            'sub_categories_status'  => ($response->sub_categories_status) ? $response->sub_categories_status : 0,
        ];
    
        return $data;
    }

    public function CategoryListResponse($response)
    {
        $data = [];
        if(count($response) > 0)
        {
            foreach($response as $key=>$value)
            { 
                $category_image = '';
                if(isset($value->category_image))
                {   
                    $category_image = $this->GetImage($value->category_image,$path=config('global.file_path.category_image'));
                } 
        
                $created_at =$this->getLocalTime(strtotime($value->created_at), 'Asia/Kolkata');
                $updated_at =  $this->getLocalTime(strtotime($value->updated_at), 'Asia/Kolkata'); 

                $arr = [
                    'category_id'           => ($value->category_id ) ? $value->category_id  : '',
                    'category_image'  =>$category_image,    
                    'category_name'        => ($value->category_name) ? $value->category_name : '',
                    'created_at'            => $created_at,
                    'updated_at'            => $updated_at,
                    'category_status'            => ($value->category_status) ? $value->category_status:0,
                ];
                array_push($data,$arr);
            }
        }
        return $data;
    }

    public function ServiceResponse($response)
    {
        $service_single_image = '';
        if(isset($response->service_single_image))
        {   
            $service_single_image = $this->GetImage($response->service_single_image,$path=config('global.file_path.service_image'));
        } 
        $service_multiple_image = [];
        if(isset($response->service_multiple_image))
        {  
            $multi_images = explode(',',$response->service_multiple_image);
            foreach ($multi_images as $key => $val) {
                $service_multiple_image[] = $this->GetImage($val,$path=config('global.file_path.service_image'));
            }
        } 
    
        $created_at =$this->getLocalTime(strtotime($response->created_at), 'Asia/Kolkata');
        $updated_at =  $this->getLocalTime(strtotime($response->updated_at), 'Asia/Kolkata'); 
        $data = [
                'service_id'           => ($response->service_id) ? $response->service_id : '',
                'category_id'           => ($response->category_id ) ? $response->category_id  : '',
                'category_name'        => ($response->category_name) ? $response->category_name : '',  
                'sub_categories_id'           => ($response->sub_categories_id ) ? $response->sub_categories_id  : '',
                'sub_categories_name'        => ($response->sub_categories_name) ? $response->sub_categories_name : '',                          
                'service_name' => ($response->service_name ) ? $response->service_name  : '',
                'service_description' => ($response->service_description ) ? $response->service_description  : '',
                'service_single_image'  =>$service_single_image,   
                'service_multiple_image'=>$service_multiple_image, 
                'service_price'           => ($response->service_price ) ? $response->service_price  :0,
                'service_sku'           => ($response->service_sku) ? $response->service_sku : '',
                'is_popular'              => ($response->is_popular) ? $response->is_popular:0,
         
                'service_details'           => ($response->service_details ) ? $response->service_details  :0,
                'created_at'            => $created_at,
                'updated_at'            => $updated_at,
                'service_status'            => ($response->service_status) ? $response->service_status:0,
            ];
        return $data;
    }

    public function ServiceListResponse($response)
    {
        $data = [];
        if(count($response) > 0)
        {
            foreach($response as $key=>$value)
            { 
                $service_single_image = '';
                if(isset($value->service_single_image))
                {   
                    $service_single_image = $this->GetImage($value->service_single_image,$path=config('global.file_path.service_image'));
                } 
        
                $service_multiple_image = [];
                if(isset($value->service_multiple_image))
                {  
                    $multi_images = explode(',',$value->service_multiple_image);
                    foreach ($multi_images as $key => $val) {
                        $service_multiple_image[] = $this->GetImage($val,$path=config('global.file_path.service_image'));
                    }
                } 


                $created_at =$this->getLocalTime(strtotime($value->created_at), 'Asia/Kolkata');
                $updated_at =  $this->getLocalTime(strtotime($value->updated_at), 'Asia/Kolkata'); 

                $arr = [
                    'service_id'           => ($value->service_id) ? $value->service_id : '',
                    'category_id'           => ($value->category_id ) ? $value->category_id  : '',
                    'category_name'        => ($value->category_name) ? $value->category_name : '',
                    'sub_categories_id'           => ($value->sub_categories_id ) ? $value->sub_categories_id  : '',
                    'sub_categories_name'        => ($value->sub_categories_name) ? $value->sub_categories_name : '',
                    'service_name' => ($value->service_name ) ? $value->service_name  : '',
                    'service_description' => ($value->service_description ) ? $value->service_description  : '',
                    'service_single_image'  =>$service_single_image,   
                    'service_multiple_image'=>$service_multiple_image, 
                    'service_price'           => ($value->service_price ) ? $value->service_price  :0,
                    'service_sku'           => ($value->service_sku) ? $value->service_sku : '',
                    'is_popular'              => ($value->is_popular) ? $value->is_popular:0,
                   
                    'service_details'           => ($value->service_details ) ? $value->service_details  :0,
                    'created_at'            => $created_at,
                    'updated_at'            => $updated_at,
                    'service_status'            => ($value->service_status) ? $value->service_status:0,
                ];
                array_push($data,$arr);
            }
        }
        return $data;
    }

    public function CategoryServiceListResponse($response)
    {
        $data = [];
        if(count($response) > 0)
        {
            foreach($response as $key=>$value)
            { 

                $created_at =$this->getLocalTime(strtotime($value->created_at), 'Asia/Kolkata');
                $updated_at =  $this->getLocalTime(strtotime($value->updated_at), 'Asia/Kolkata'); 

                $arr = [
                    'service_id'           => ($value->service_id) ? $value->service_id : '',
                    'service_name' => ($value->service_name ) ? $value->service_name  : '',
                ];
                array_push($data,$arr);
            }
        }
        return $data;
    }
    
    public static function generateUniqueOrderId($table, $column)
    {
        $unique = false;
        do{
            $code = random_int(10000, 99990);
            $order_id = 'DH-'.$code;
            $match = DB::table($table)->where($column, $order_id)->first();
            if($match)
            {
                continue;
            }
            $unique = true;
        }
        while(!$unique);
        return $order_id;
    }

    public function OrderResponse($response)
    {
        $quotation_pdf = '';
        if(isset($response->quotation_pdf))
        {   
            $quotation_pdf = $this->GetImage($response->quotation_pdf,$path=config('global.file_path.order_quotation'));
        }  
        $originalAmount =$response->order_amount;
        $discountedAmount =$response->order_discount_amount;

        if($discountedAmount >0){
              $discountPercentage = (($originalAmount - $discountedAmount) / $originalAmount) * 100;
            
                $discountPercentage = round($discountPercentage, 2);  
            }
            else{
               $discountPercentage = 0;  
            }  

        $created_at =$this->getLocalTime(strtotime($response->created_at), 'Asia/Kolkata');
        $updated_at =  $this->getLocalTime(strtotime($response->updated_at), 'Asia/Kolkata'); 
        $data = [
                'order_id'           => ($response->order_id) ? $response->order_id : '',
                'user_id'           => ($response->user_id ) ? $response->user_id  : '',
                'rate'        => ($response->rate) ? $response->rate : 0,               
                'rate_comment' => ($response->rate_comment ) ? $response->rate_comment  : '',
                'order_amount' => ($response->order_amount ) ? $response->order_amount  : 0,
                'order_discount_amount'           => ($response->order_discount_amount ) ? $response->order_discount_amount  :0,
                'discountpercentage'             =>"$discountPercentage",
                'payment_type'           => ($response->payment_type) ? $response->payment_type : '',
                'payment_transection_id'           => ($response->payment_transection_id) ? $response->payment_transection_id : '',
                'order_type'           => ($response->order_type) ? $response->order_type : '',
                'cancel_reason'           => ($response->cancel_reason) ? $response->cancel_reason : '',
                'order_details'           => ($response->order_details ) ? $response->order_details  :'',
                'created_at'            => $created_at,
                'updated_at'            => $updated_at,
                'request_for' => ($response->request_for) ? $response->request_for:0,
                'quotation_pdf'=> $quotation_pdf,
                'quotation_remark'=> ($response->quotation_remark) ? $response->quotation_remark:'',
                'order_status'            => ($response->order_status) ? $response->order_status:0,
            ];
        return $data;
    }

    public function OrderListResponse($response)
    {
        $data = [];
        if(count($response) > 0)
        {
            foreach($response as $key=>$value)
            {
                $quotation_pdf = '';
                if(isset($value->quotation_pdf))
                {   
                    $quotation_pdf = $this->GetImage($value->quotation_pdf,$path=config('global.file_path.order_quotation'));
                }    
                $originalAmount =$value->order_amount;
                $discountedAmount =$value->order_discount_amount;
        
                if($discountedAmount >0){
                      $discountPercentage = (($originalAmount - $discountedAmount) / $originalAmount) * 100;
                    
                        $discountPercentage = round($discountPercentage, 2);  
                    }
                    else{
                       $discountPercentage = 0;  
                    }  

                $created_at =$this->getLocalTime(strtotime($value->created_at), 'Asia/Kolkata');
                $updated_at =  $this->getLocalTime(strtotime($value->updated_at), 'Asia/Kolkata'); 

                $arr = [
                    'order_id'           => ($value->order_id) ? $value->order_id : '',
                    'user_id'           => ($value->user_id ) ? $value->user_id  : '',
                    'rate'        => ($value->rate) ? $value->rate : 0,               
                    'rate_comment' => ($value->rate_comment ) ? $value->rate_comment  : '',
                    'order_amount' => ($value->order_amount ) ? $value->order_amount  : 0,
                    'order_discount_amount'           => ($value->order_discount_amount ) ? $value->order_discount_amount  :0,
                    'discountpercentage'             => number_format($discountPercentage, 2, '.', ''),
                    'payment_type'           => ($value->payment_type) ? $value->payment_type : '',
                    'payment_transection_id'           => ($value->payment_transection_id) ? $value->payment_transection_id : '',
                    'order_type'           => ($value->order_type) ? $value->order_type : '',
                    'cancel_reason'           => ($value->cancel_reason) ? $value->cancel_reason : '',
                    'order_details'           => ($value->order_details ) ? $value->order_details  :'',
                    'created_at'            => $created_at,
                    'updated_at'            => $updated_at,
                    'request_for' => ($value->request_for) ? $value->request_for:0,
                    'quotation_pdf'=> $quotation_pdf,
                    'quotation_remark'=> ($value->quotation_remark) ? $value->quotation_remark:'',
                    'order_status'            => ($value->order_status) ? $value->order_status:0,
                ];
                array_push($data,$arr);
            }
        }
        return $data;
    }
    
    public function CartResponse($response)
    {
        $cart_service_original_price =$response->cart_service_original_price;
        $cart_service_discount_price =$response->cart_service_discount_price;

        if($cart_service_discount_price >0){
            $cartdiscountPercentage = (($cart_service_original_price - $cart_service_discount_price) / $cart_service_original_price) * 100;
            
                $cartdiscountPercentage = round($cartdiscountPercentage, 2);  
            }
            else{
            $cartdiscountPercentage = 0;  
            }  

        $created_at =$this->getLocalTime(strtotime($response->created_at), 'Asia/Kolkata');
        $updated_at =  $this->getLocalTime(strtotime($response->updated_at), 'Asia/Kolkata'); 
        $data = [
            'cart_id'           => ($response->cart_id) ? $response->cart_id: '',
            'user_id'           => ($response->user_id) ? $response->user_id: '',
            'service_id'           => ($response->service_id) ? $response->service_id: '',
            'service_name'           => ($response->service_name) ? $response->service_name: '',
            'service_single_image'           => ($response->service_single_image) ? $response->service_single_image: '',                    
            'service_detail_id'           => ($response->service_detail_id) ? $response->service_detail_id: '',
            'service_unit'           => ($response->cart_service_unit) ? $response->cart_service_unit: '',
            'cart_service_quantity'           => ($response->cart_service_quantity) ? $response->cart_service_quantity: '',
            'cart_service_original_price'           => ($response->cart_service_original_price) ? $response->cart_service_original_price: '',   
            'cart_service_discount_price'        => ($response->cart_service_discount_price) ? $response->cart_service_discount_price : '',
            'cart_percentage'             =>$cartdiscountPercentage,
            'created_at'            => $created_at,
            'updated_at'            => $updated_at,
            'cart_status'            => ($response->cart_status) ? $response->cart_status:0,
        ];
        return $data;
    }

    public function CartListResponse($response)
    {
        $data = [];
        if(count($response) > 0)
        {
            foreach($response as $key=>$value)
            {
                $created_at =$this->getLocalTime(strtotime($value->created_at), 'Asia/Kolkata');
                $updated_at =  $this->getLocalTime(strtotime($value->updated_at), 'Asia/Kolkata'); 

                $cart_service_original_price =$value->cart_service_original_price;
                $cart_service_discount_price =$value->cart_service_discount_price;

                if($cart_service_discount_price >0){
                    $cartdiscountPercentage = (($cart_service_original_price - $cart_service_discount_price) / $cart_service_original_price) * 100;
                    
                        $cartdiscountPercentage = round($cartdiscountPercentage, 2);  
                    }
                    else{
                    $cartdiscountPercentage = 0;  
                    }  


                $arr = [
                    'cart_id'           => ($value->cart_id) ? $value->cart_id: '',
                    'user_id'           => ($value->user_id) ? $value->user_id: '',
                    'service_id'           => ($value->service_id) ? $value->service_id: '',
                    'service_name'           => ($value->service_name) ? $value->service_name: '',
                    'service_single_image'           => ($value->service_single_image) ? $value->service_single_image: '',                    
                    'service_detail_id'           => ($value->service_detail_id) ? $value->service_detail_id: '',
                    'service_unit'           => ($value->cart_service_unit) ? $value->cart_service_unit: '',
                    'cart_service_quantity'           => ($value->cart_service_quantity) ? $value->cart_service_quantity: '',
                    'cart_service_original_price'           => ($value->cart_service_original_price) ? $value->cart_service_original_price: '',   
                    'cart_service_discount_price'        => ($value->cart_service_discount_price) ? $value->cart_service_discount_price : '',
                    'cart_percentage'             =>$cartdiscountPercentage,
                    'created_at'            => $created_at,
                    'updated_at'            => $updated_at,
                    'cart_status'            => ($value->cart_status) ? $value->cart_status:0,
                ];
                array_push($data,$arr);
            }
        }
        return $data;
    }
       
    public function GetBannerData($response)
    {
        $data2 = [];
        if(count($response) > 0)
        {
            foreach($response as $key=>$value)
            { 
                
                $banner_image = $this->GetImage($file_name = $value->banner_image,$path=config('global.file_path.banner_image'));

                $created_at =$this->getLocalTime(strtotime($value->created_at), 'Asia/Kolkata');
                $arr = [
                    'banner_id'           => ($value->banner_id) ? $value->banner_id   : '',
                    'banner_image'  =>$banner_image,
                    'is_clickable'=>($value->is_clickable) ? $value->is_clickable : 0,
                    'created_at'            => $created_at,
                    'banner_status'            => ($value->banner_status) ? $value->banner_status:0,
                ];
                array_push($data2,$arr);
            }
        }
        return $data2;
    }

    public function SettingResponse($response)
    {
        $app_logo = '';
        if(isset($response->app_logo))
        {   
            $app_logo = $this->GetImage($response->app_logo,$path=config('global.file_path.app_logo'));
        } 
        $app_upi_image = '';
        if(isset($response->app_upi_image))
        {   
            $app_upi_image = $this->GetImage($response->app_upi_image,$path=config('global.file_path.app_upi_image'));
        } 
      

        $created_at =$this->getLocalTime(strtotime($response->created_at), 'Asia/Kolkata');
         $updated_at =  $this->getLocalTime(strtotime($response->updated_at), 'Asia/Kolkata'); 
        $data = [
            'setting_id'           => ($response->setting_id) ? $response->setting_id : '',
            'email_from'           => ($response->email_from) ? $response->email_from : '',  
            'firebase_server_key'           => ($response->firebase_server_key) ? $response->firebase_server_key : '',  
            'app_logo'  =>$app_logo,    
            'onesignal_app_id'        => ($response->onesignal_app_id) ? $response->onesignal_app_id : '',
            'onesignal_rest_key'        => ($response->onesignal_rest_key) ? $response->onesignal_rest_key : '',

            'app_name'        => ($response->app_name) ? $response->app_name : '',
            'app_email'        => ($response->app_email) ? $response->app_email : '',
            'app_author'        => ($response->app_author) ? $response->app_author : '',
            'app_contact'        => ($response->app_contact) ? $response->app_contact : '',
            'app_website'        => ($response->app_website) ? $response->app_website : '',
            'app_description'        => ($response->app_description) ? $response->app_description : '',
            'app_developed_by'        => ($response->app_developed_by) ? $response->app_developed_by : '',

            'app_privacy_policy'        => ($response->app_privacy_policy) ? $response->app_privacy_policy : '',
            'app_terms_condition'        => ($response->app_terms_condition) ? $response->app_terms_condition : '',
            'app_cancellation_refund'        => ($response->app_cancellation_refund) ? $response->app_cancellation_refund : '',
            'app_about_us'        => ($response->app_about_us) ? $response->app_about_us : '',

            'app_contact_us'        => ($response->app_contact_us) ? $response->app_contact_us : '',
            'agent_onboard_commission'        => (int)($response->agent_onboard_commission) ? $response->agent_onboard_commission : 0,

            'agent_approve_commission'        => (int)($response->agent_approve_commission) ? $response->agent_approve_commission : '',
            'add_min_wallet_amount'        => (int)($response->add_min_wallet_amount) ? $response->add_min_wallet_amount : '',
            'contribution'        =>(int)($response->contribution) ? $response->contribution : '',
            'radius'        =>(int) ($response->radius) ? $response->radius : '',
            'reffer_earn_amount'        =>(int) ($response->reffer_earn_amount) ? $response->reffer_earn_amount : '',
            'app_version'        => ($response->app_version) ? $response->app_version : '',
            'app_update_status'        => ($response->app_update_status) ? $response->app_update_status : '',
            'app_maintenance_status'        => ($response->app_maintenance_status) ? $response->app_maintenance_status : '',
            'app_update_description'        => ($response->app_update_description) ? $response->app_update_description : '',

            'app_update_cancel_button'        => ($response->app_update_cancel_button) ? $response->app_update_cancel_button : '',
            'app_update_factor_button'        => ($response->app_update_factor_button) ? $response->app_update_factor_button : '',
            'factor_apikey'        => ($response->factor_apikey) ? $response->factor_apikey : '',
            'app_address'        => ($response->app_address) ? $response->app_address : '',
            'app_gstin'        => ($response->app_gstin) ? $response->app_gstin : '',

            
            'app_pan'        => ($response->app_pan) ? $response->app_pan : '',
            'app_bank_name'        => ($response->app_bank_name) ? $response->app_bank_name : '',
            'app_acount_no'        => ($response->app_acount_no) ? $response->app_acount_no : '',
            'app_ifsc'        => ($response->app_ifsc) ? $response->app_ifsc : '',
            'app_branch'        => ($response->app_branch) ? $response->app_branch : '',

            'app_upi_image'        => $app_upi_image,
            'app_notes_desc'        => ($response->app_notes_desc) ? $response->app_notes_desc : '',
            'map_api_key'        => ($response->map_api_key) ? $response->map_api_key : '',
            'razorpay_key'        => ($response->razorpay_key) ? $response->razorpay_key : '',
            'cash_on_delivery_available'        => ($response->cash_on_delivery_available) ? $response->cash_on_delivery_available : '',

            'gst_charge'        => ($response->gst_charge) ? $response->gst_charge : '',

            'app_facebook'        => ($response->app_facebook) ? $response->app_facebook : '',
            'app_youtube'        => ($response->app_youtube) ? $response->app_youtube : '',
            'app_twitter'        => ($response->app_twitter) ? $response->app_twitter : '',
            'app_instagram'        => ($response->app_instagram) ? $response->app_instagram : '',
            'app_whatsapp'        => ($response->app_whatsapp) ? $response->app_whatsapp : '',
            'app_linkedin'        => ($response->app_linkedin) ? $response->app_linkedin : '',


            'created_at'            => $created_at,
            'updated_at'            => $updated_at,
            // 'created_at'            => ($response->created_at) ? $response->created_at : '',
            'banner_status'            => ($response->is_disable) ? $response->is_disable:0,
        ];
        return $data;
    }
    public function SendIOSPushNotification($device_token_arr,$data)
    {
        try
        {
            $SERVER_API_KEY = env('FIREBASE_SERVER_KEY');
            $data = [
                "registration_ids" => $device_token_arr, // for multiple device ids
                "notification" => array(
                    "title"                     => $data['title'], 
                    "message"                   => $data['message'],
                    "receiver_id"               => $data['receiver_id'],
                    "conversation_id"           => ($data['conversation_id'] == '')? '' : $data['conversation_id'],
                    "notification_type"         => $data['notification_type'],
                    "receiver_firebase_uid"     => ($data['receiver_firebase_uid'] == '') ? 'test' : $data['receiver_firebase_uid'],
                    "receiver_name"             => $data['receiver_name'],
                    "receiver_imageurl"    => $data['receiver_imageurl']
                )
            ];
            $dataString = json_encode($data);
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
            curl_close($ch);
            return $response;
        }
        catch (\Exception $e)
        {
            echo $this->sendError($e->getMessage(), config('global.null_object'),401,false); die;
        }
    }
    
    public function SendAndroidPushNotification($device_token_arr,$data)
    {
        try {
            $fcmUrl = 'https://fcm.googleapis.com/fcm/send';

            $data = [
                "registration_ids" => $device_token_arr, // for multiple device ids
                "notification" => array(
                    "title"                     => $data['title'], 
                    "message"                   => $data['message'],
                    "receiver_id"               => $data['receiver_id'],
                    "conversation_id"           => ($data['conversation_id'] == '')? '' : $data['conversation_id'],
                    "notification_type"         => $data['notification_type'],
                    "receiver_firebase_uid"     => ($data['receiver_firebase_uid'] == '') ? 'test' : $data['receiver_firebase_uid'],
                    "receiver_name"             => $data['receiver_name'],
                    "receiver_imageurl"    => $data['receiver_imageurl']
                )
            ];
            $dataString = json_encode($data);
            $headers = [
                'Authorization: key='.env('FIREBASE_SERVER_KEY'),
                'Content-Type: application/json'
            ];    
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$fcmUrl);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
            $result = curl_exec($ch);
            curl_close($ch);
            return $result;
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), config('global.null_object'),401,false);
        }
    }

    public function WebPushNotificationFirebase($DevicesToken,$Title, $Body,$Badge)
    {
        try {
            $data = [
                "to" => $DevicesToken,
                "data" => [
                    "badge" => $Badge +1,
                    "sound"=> "default"
                ],
                "notification" =>
                    [
                        "title" => $Title,
                        "body" => $Body,
                        "icon" => "http://3.14.184.45/public/images/Notification.png",
                        "sound"=> ""
                    ],
            ];

            $dataString = json_encode($data);
            
            $serverkey = env('FIREBASE_SERVER_KEY');
            $headers = [
                'Authorization: key='.$serverkey,
                'Content-Type: application/json',
            ];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
            $response = curl_exec($ch);
            return $response;
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), config('global.null_object'),401,false);
        }
    }

    public function NotificationResponse($response)
    {
        $data = [];
        if(count($response) > 0)
        {
            foreach($response as $key=>$value)
            {    
                $created_at =$this->getLocalTime(strtotime($value->created_at), 'Asia/Kolkata');           
                $arr = array(
                    'notification_id'                => $value->notification_id,
                    'sender_id'                      => (int)$value->sender_id,
                    'receiver_id'                    => (int)$value->receiver_id,
                    'notification_title'             => (isset($value->notification_title) && $value->notification_title != null) ? $value->notification_title : '',
                    'notification_text'              => (isset($value->notification_text) && $value->notification_text != null) ? $value->notification_text : '',  
                    'notification_type'              => (int) $value->notification_type ,
                    'is_view'                        => $value->is_view,
                    'user_id'                        => (isset($value->user_id) && $value->user_id != null) ? $value->user_id : '',
                    'gym_id'                     => (isset($value->gym_id) && $value->gym_id != null) ? $value->gym_id : '',
                    'agent_id'                     => (isset($value->agent_id) && $value->agent_id != null) ? $value->agent_id : '',
                    'booking_id'                     => (isset($value->booking_id) && $value->booking_id != null) ? $value->booking_id : '',
                    'first_name'                     => (isset($value->first_name) && $value->first_name != null) ? $value->first_name : '',
                    'last_name'                      => (isset($value->last_name) && $value->last_name != null) ? $value->last_name : '',
                    'imageurl'                  => $this->GetImage($value->imageurl,$path=config('global.file_path.user_profile')),
                    'is_disable'                     => $value->is_disable,
                    'created_at'            => $created_at,
                );
                array_push($data,$arr);
            }
        }
        return $data;
    }

    public function GetStateData($response)
    {
        $data2 = [];
        if(count($response) > 0)
        {
            foreach($response as $key=>$value)
            { 

                $created_at =$this->getLocalTime(strtotime($value->created_at), 'Asia/Kolkata');
                $arr = [
                    'state_id'           => ($value->state_id) ? $value->state_id   : '',
                    'state_name'           => ($value->state_name) ? $value->state_name   : '',
                    'created_at'            => $created_at,
                    'state_status'            => ($value->state_status) ? $value->state_status:0,
                ];
                array_push($data2,$arr);
            }
        }
        return $data2;
    }
    public function GetDistrictListData($response)
    {
        $data2 = [];
        if(count($response) > 0)
        {
            foreach($response as $key=>$value)
            { 

                $created_at =$this->getLocalTime(strtotime($value->created_at), 'Asia/Kolkata');
                $arr = [
                    'district_id' =>($value->district_id) ? $value->district_id   : '',
                    'district_name' =>($value->district_name) ? $value->district_name   : '',
                    'state_id'           => ($value->state_id) ? $value->state_id   : '',
                    'state_name'           => ($value->stateData->state_name) ? $value->stateData->state_name   : '',
                    'created_at'            => $created_at,
                    'district_status'            => ($value->district_status) ? $value->district_status:0,
                ];
                array_push($data2,$arr);
            }
        }
        return $data2;
    }
    
    public function GetTalukaListData($response)
    {
        $data2 = [];
        if(count($response) > 0)
        {
            foreach($response as $key=>$value)
            { 

                $created_at =$this->getLocalTime(strtotime($value->created_at), 'Asia/Kolkata');
                $arr = [
                    'taluka_id' =>($value->taluka_id) ? $value->taluka_id   : '',
                    'taluka_name' =>($value->taluka_name) ? $value->taluka_name   : '',
                    'district_id'           => ($value->district_id) ? $value->district_id   : '',
                    'district_name'           => ($value->districtData->district_name) ? $value->districtData->district_name   : '',
                    'state_id'           => ($value->state_id) ? $value->state_id   : '',
                    'state_name'           => ($value->stateData->state_name) ? $value->stateData->state_name   : '',
                    'created_at'            => $created_at,
                    'taluka_status'            => ($value->taluka_status) ? $value->taluka_status:0,
                ];
                array_push($data2,$arr);
            }
        }
        return $data2;
    }

    public function GetPincodeListData($response)
    {
        $data2 = [];
        if(count($response) > 0)
        {
            foreach($response as $key=>$value)
            { 

                $created_at =$this->getLocalTime(strtotime($value->created_at), 'Asia/Kolkata');
                $arr = [
                    'pincode_id' =>($value->pincode_id) ? $value->pincode_id   : '',
                    'pincode' =>($value->pincode) ? $value->pincode   : '',
                    'taluka_id' =>($value->taluka_id) ? $value->taluka_id   : '',
                    'taluka_name' =>($value->talukaData->taluka_name) ? $value->talukaData->taluka_name   : '',
                    'district_id'           => ($value->district_id) ? $value->district_id   : '',
                    'district_name'           => ($value->districtData->district_name) ? $value->districtData->district_name   : '',
                    'state_id'           => ($value->state_id) ? $value->state_id   : '',
                    'state_name'           => ($value->stateData->state_name) ? $value->stateData->state_name   : '',
                    'created_at'            => $created_at,
                    'pincode_status'            => ($value->pincode_status) ? $value->pincode_status:0,
                ];
                array_push($data2,$arr);
            }
        }
        return $data2;
    }

    public function GetTestimonialListData($response)
    {
        $data2 = [];
        if(count($response) > 0)
        {
            foreach($response as $key=>$value)
            { 

                $testimonial_image = $this->GetImage($file_name = $value->testimonial_image,$path=config('global.file_path.testimonial_image'));

                $created_at =$this->getLocalTime(strtotime($value->created_at), 'Asia/Kolkata');
                $arr = [
                    'testimonial_id' =>($value->testimonial_id) ? $value->testimonial_id   : '',
                    'testimonial_title' =>($value->testimonial_title) ? $value->testimonial_title   : '',
                    'testimonial_description' =>($value->testimonial_description) ? $value->testimonial_description   : '',                    
                    'testimonial_image' => $testimonial_image,
                    'pincode_id' =>($value->pincode_id) ? $value->pincode_id   : '',
                    'pincode' =>($value->pincodeData->pincode) ? $value->pincodeData->pincode : '',
                    'taluka_id' =>($value->taluka_id) ? $value->taluka_id   : '',
                    'taluka_name' =>($value->talukaData->taluka_name) ? $value->talukaData->taluka_name   : '',
                    'district_id'           => ($value->district_id) ? $value->district_id   : '',
                    'district_name'           => ($value->districtData->district_name) ? $value->districtData->district_name   : '',
                    'state_id'           => ($value->state_id) ? $value->state_id   : '',
                    'state_name'           => ($value->stateData->state_name) ? $value->stateData->state_name   : '',
                    
                    'category_id'           => ($value->category_id) ? $value->category_id   : '',
                    'service_id'           => ($value->service_id) ? $value->service_id   : '',
                    
                    'created_at'            => $created_at,
                    'testimonial_status'            => ($value->testimonial_status) ? $value->testimonial_status:0,
                ];
                array_push($data2,$arr);
            }
        }
        return $data2;
    }

    public function NotificationListResponse($response)
    {
        // INSERT INTO `notifications`(`notifications_id`, `notification_click`, `notification_type`, `no_type`, `user_id`, `order_id`, `notification_title`, `notification_msg`, `notification_image`, `notification_status`, `created_at`, `updated_at`)
        $notification_image = '';
        if(isset($response->notification_image))
        {   
            $notification_image = $this->GetImage($response->notification_image,$path=config('global.file_path.notification_image'));
        } 

        $created_at =$this->getLocalTime(strtotime($response->created_at), 'Asia/Kolkata');
        $updated_at =  $this->getLocalTime(strtotime($response->updated_at), 'Asia/Kolkata'); 
        $data = [
            'notifications_id'           => ($response->notifications_id ) ? $response->notifications_id  : '',
            'notification_image'  =>  $notification_image,    
            'notification_click'        => ($response->notification_click) ? $response->notification_click : '',
            'notification_type'        => ($response->notification_type) ? $response->notification_type : '',
            'no_type'        => ($response->no_type) ? $response->no_type : '',
            'user_id'        => ($response->user_id) ? $response->user_id : '',
            'order_id'        => ($response->order_id) ? $response->order_id : '',
            'notification_title'        => ($response->notification_title) ? $response->notification_title : '',
            'notification_msg'        => ($response->notification_msg) ? $response->notification_msg : '',
            'created_at'            => $created_at,
            'updated_at'            => $updated_at,
            'notification_status'            => ($response->notification_status) ? $response->notification_status:0,
        ];
        return $data;
    }



    
}


