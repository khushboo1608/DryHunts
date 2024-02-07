<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseAPIController as BaseAPIController;
use App\Models\User;
use App\Models\Service;
use App\Models\Cart;
use App\Models\ServiceDetails;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\DashboardAPIController;
use Validator;
use Illuminate\Support\Str;

class CartAPIController extends BaseAPIController
{
    
    public function AddCart(Request $request)
    {
        try
        {  
            if(Auth::guard('api')->check())
            {          
                $input = $request->all();  

                // echo "<pre>";
                // print_r($input);die;
                $auth_user = Auth::guard('api')->user();

                if($auth_user->id!='' && $input['service_id'] !=''){
                    
                    $qry_service_check = ServiceDetails::where('service_id',$input['service_id'])->where('service_detail_id',$input['service_detail_id'])->where('service_detail_status',0)->first();

                    if($qry_service_check !=''){
                        // if($qry_service_check->service_stock > $qry_service_check->service_quantity)
                        // {
                        //     $in_stock = 1 ;
                        // }
                        // else
                        // {
                        //     $in_stock = 0 ;
                        // }
                        // if($in_stock == 1){
                            
                            $qry_service_check_cart = Cart::where('user_id',$auth_user->id)->where('service_id',$input['service_id'])->where('service_detail_id',$input['service_detail_id'])->where('cart_status',0)->first();
                            if($qry_service_check_cart !=''){
                                
                                if($input['cart_service_quantity']==0){
                                    // echo 'if';die;
                                    $delete = Cart::where('user_id',$auth_user->id)->where('service_id',$input['service_id'])->where('service_detail_id',$input['service_detail_id'])->delete();
                                    if ($delete > 0) {
                                        return $this->sendResponse(config('global.null_object'), __('messages.api.cart.cart_delete_success'));
                                    }
                                    else{
                                        return $this->sendError(__('messages.api.cart.some_error'), config('global.null_object'),226,false);                       
                                    }
                                }
                                else{
                                    
                                    // echo $qry_service_check->service_unit;die;
                                    if($input['cart_service_unit'] == $qry_service_check_cart->cart_service_unit){
                                       $new_qrt=$qry_service_check_cart->cart_service_quantity + $input['cart_service_quantity'];
                                    Cart::where('user_id',$auth_user->id)->where('service_id',$input['service_id'])->where('service_detail_id',$input['service_detail_id'])->update(['cart_service_quantity' => $new_qrt]); 

                                        $cartdata =Cart::where('cart_id',$qry_service_check_cart->cart_id)->where('cart_status',0)->first();
                                        
                                        $datacart = $this->CartResponse($cartdata);
                                        return $this->sendResponse($datacart, __('messages.api.cart.cart_updated_success'));
                                       
                                    }
                                    else{
                                        // echo 'else';die;
                                        $cart_id = $this->GenerateUniqueRandomString($table='carts', $column="cart_id", $chars=32);
                                        $input['cart_id'] = $cart_id;
                                        $input['user_id'] = $auth_user->id;
                                        $cart= Cart::create($input);
                                        $cart  = Cart::where('cart_id',$cart->cart_id)->where('cart_status',0)->first();
                                        $cart_data = $this->CartResponse($cart);
                                        return $this->sendResponse($cart_data, __('messages.api.cart.add_cart_success'));

                                    }                           
                                   

                                }

                            }
                            else{
                                $cart_id = $this->GenerateUniqueRandomString($table='carts', $column="cart_id", $chars=32);
                                    $input['cart_id'] = $cart_id;
                                    $input['user_id'] = $auth_user->id;
                                    $cart= Cart::create($input);
                                    $cart  = Cart::where('cart_id',$cart->cart_id)->where('cart_status',0)->first();
                                    $cart_data = $this->CartResponse($cart);
                                    return $this->sendResponse($cart_data, __('messages.api.cart.add_cart_success'));
                            }

                        //}
                        // else{
                        //     return $this->sendError(__('messages.api.cart.out_of_stock'), config('global.null_object'),226,false); 
                        // }
                        
                    }
                    else{
                        return $this->sendError(__('messages.api.cart.service_not_found'), config('global.null_object'),226,false);
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
            $this->serviceLogError($service_name = 'AddCart',$user_id = $auth_user->id,$message = $e->getMessage(),$requested_field = json_encode($request->all()),$response_data=$e);
            return $this->sendError($e->getMessage(), config('global.null_object'),401,false);
        }

    }
    
    public function CartList(Request $request)
    {        
        try
        {  
            if(Auth::guard('api')->check())
            {          
                $input = $request->all();  
                $auth_user = Auth::guard('api')->user(); 
                // $page = $input['page'];
                // echo "<pre>";
                // print_r($auth_user->id);die;
                $cart_data = Cart::with('ServiceData')->where('user_id',$auth_user->id)->where('cart_status',0)->orderBy('created_at','desc')->get();
                 
                $cart_data->map(function($post) use ($auth_user){
                    $post->category_name = $post->CategoryData->category_name;
                    $post->sub_categories_name = $post->SubCategoryData->sub_categories_name;
                    $post->service_name = $post->ServiceData->service_name;

                    $service_single_image = '';
                        if(isset($post->ServiceData->service_single_image))
                        {   
                            // echo 'in';die;
                            $service_single_imasge = $this->GetImage( $post->ServiceData->service_single_image,$path=config('global.file_path.service_image'));
                        } 
                        // dd($post->ServiceData->service_single_image);
                        // dd($path=config('global.file_path.service_image'));
                        $post->service_single_image =  $service_single_image;

                        $service_detail = ServiceDetails::where('service_detail_id',$post->service_detail_id)->first();
                        // $post->service_single_image =  $service_single_image;
                        // $post->service_unit = $service_detail->service_unit;
                });
                
                $result = $this->CartListResponse($cart_data);
                // $result = $this->ResponseWithPagination($page,$data_cart);
                return $this->sendResponsecart($result, __('messages.api.cart.cart_get_success')); 
            
            }
            else
            {                
                return $this->sendError(__('messages.api.authentication_err_message'), config('global.null_object'),401,false);
            }
           
        }
        catch(\Exception $e)
        {
            $auth_user = Auth::guard('api')->user();
            $this->serviceLogError($service_name = 'CartList',$user_id = $auth_user->id,$message = $e->getMessage(),$requested_field = json_encode($request->all()),$response_data=$e);
            return $this->sendError($e->getMessage(), config('global.null_object'),401,false);
        }
    }

    public function DeleteCart(Request $request)
    {
        try
        {
            $input = $request->all();  
            $CloseGym  = Cart::where('cart_id',$input['cart_id'])->where('cart_status', 0)->first();

            if($CloseGym)
            {
                Cart::where('cart_id', $input['cart_id'])->update(['cart_status' => 1]);    
                return $this->sendResponse(config('global.null_object'), __('messages.api.cart.cart_delete_success'));
            }
            else
            {
                return $this->sendError(__('messages.api.cart.cart_not_found'), config('global.null_object'),200,false);
            }
           
        }
        catch(\Exception $e)
        {
            $this->serviceLogError($service_name = 'DeleteCart',$user_id = 0,$message = $e->getMessage(),$requested_field = json_encode($request->all()),$response_data=$e);
            return $this->sendError($e->getMessage(), config('global.null_object'),401,false);
        }
    }

    public function CartQuantityUpdate(Request $request)
    {
        try
        {
            $input = $request->all();  
            $cart = Cart::where('cart_id',$input['cart_id'])->where('cart_status', 0)->first();

            if($cart)
            {
                Cart::where('cart_id', $input['cart_id'])->update(['cart_service_quantity' => $input['cart_quantity']]);    
                return $this->sendResponse(config('global.null_object'), __('messages.api.cart.cart_updated_success'));
            }
            else
            {
                return $this->sendError(__('messages.api.cart.cart_not_found'), config('global.null_object'),200,false);
            }
           
        }
        catch(\Exception $e)
        {
            $this->serviceLogError($service_name = 'CartQuantityUpdate',$user_id = 0,$message = $e->getMessage(),$requested_field = json_encode($request->all()),$response_data=$e);
            return $this->sendError($e->getMessage(), config('global.null_object'),401,false);
        }
    }

    
    
}
