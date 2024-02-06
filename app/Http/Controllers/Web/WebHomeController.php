<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\UserAuthMaster;
use App\Models\Category;
use App\Models\Service;
use App\Models\ServiceDetails;
use App\Models\Testimonial;
use App\Models\Banner;
use App\Models\ActivityLog;
use DB;
use Validator;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\District;
use App\Models\State;
use App\Models\Talukas;
use App\Models\Pincode;
use Response;

class WebHomeController extends Controller
{
	public function __construct() 
	{
		$this->middleware('auth');
	}

	public function index()
	{
		// return view('web.index');    
		
        $data['category'] = Category::orderBy('created_at','desc')->where('category_status',0)->get();
        $data['service'] = Service::where('is_popular',1)->where('service_status',0)->orderBy('created_at','desc')->get();
        $data['testimonial'] = Testimonial::where('testimonial_status',0)->orderBy('created_at','desc')->get();
        $data['banner'] = Banner::orderBy('banner_name')->where('banner_status',0)->get();
        return view('web.index')->with(['master_data' => $data]);           
	}
	public function thankyou()
    { 
        // echo 'in'; exit();
        // return view('auth.register');
        return view('web.thankyou');     
    }
    public function servicelist($categoryId)
    { 
        // echo "<pre>";
        // print_r($categoryId);die;
        // echo 'in'; exit();

        $data['service'] = Service::where('category_id',$categoryId)->where('service_status',0)->orderBy('created_at','desc')->get();
        return view('web.servicelist')->with(['master_data' => $data]);
    }

    public function servicedetails($serviceId)
    { 
        $serviceData= Service::where('service_id',$serviceId)->where('service_status',0)->orderBy('created_at','asc')->first();
        return view('web.servicedetails')->with(['serviceData' => $serviceData]);
    }
    
    public function addtocart(Request $request)
    { 
        // echo "<pre>";
        // print_r($request->all());die;
        $input = $request->all();  
        $auth_user = Auth::user();
        // echo "<pre>";
        // print_r($auth_user);die;
        $qry_service_check_cart = Cart::where('user_id',$auth_user->id)->where('service_id',$input['service_id'])->where('service_detail_id',$input['service_detail_id'])->where('cart_status',0)->first();

        if($qry_service_check_cart !=''){
            
            if($input['cart_service_quantity']==0){
                // echo 'if';die;
                $delete = Cart::where('user_id',$auth_user->id)->where('service_id',$input['service_id'])->where('service_detail_id',$input['service_detail_id'])->delete();
                if ($delete > 0) {
                    // return Response::json(['result' => true,'message'=> ' Cart deleted..!']);
                }
                else{
                    return Response::json(['result' => true,'message'=> 'Some error occured.!']);                     
                }
            }
            else{
                
                // echo $qry_service_check->service_unit;die;
                if($input['cart_service_unit'] == $qry_service_check_cart->cart_service_unit){
                    $new_qrt=$qry_service_check_cart->cart_service_quantity + $input['cart_service_quantity'];
                Cart::where('user_id',$auth_user->id)->where('service_id',$input['service_id'])->where('service_detail_id',$input['service_detail_id'])->update(['cart_service_quantity' => $new_qrt]); 

                    $cartdata =Cart::where('cart_id',$qry_service_check_cart->cart_id)->where('cart_status',0)->first();
                 
                    $cart_data = $this->CartResponse($cartdata);
                    return Response::json(['result' => true,'message'=> 'cart data updated successfully.!','cart_data'=> $cart_data]);   
                    // return view('web.cart')->with(['cart_data' => $cart_data]); 
                    
                }
                else{
                    // echo 'else';die;
                    $cart_id = $this->GenerateUniqueRandomString($table='carts', $column="cart_id", $chars=32);
                    $input['cart_id'] = $cart_id;
                    $input['user_id'] = $auth_user->id;
                    $cart= Cart::create($input);
                    $cart  = Cart::where('cart_id',$cart->cart_id)->where('cart_status',0)->first();
                    $cart_data = $this->CartResponse($cart);
                    // return view('web.cart')->with(['cart_data' => $cart_data]); 
                    return Response::json(['result' => true,'message'=> 'cart data added successfully.','cart_data'=> $cart_data]); 

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
                // return view('web.cart')->with(['cart_data' => $cart_data]);
                return Response::json(['result' => true,'message'=> 'cart data added successfully.','cart_data'=> $cart_data]); 
        }
    }

    public function cart()
	{
		// return view('web.index');    
		$auth_user = Auth::user();
        // echo "<pre>";
        // print_r($auth_user);die;
        $cart_data = Cart::with('ServiceData')->where('user_id',$auth_user->id)->where('cart_status',0)->orderBy('created_at','desc')->get();
                 
        $cart_data->map(function($post) use ($auth_user){
            $post->service_name = $post->ServiceData->service_name;

            $service_single_image = '';
                if(isset($post->ServiceData->service_single_image))
                {   
                    // echo 'in';die;
                    $service_single_image = $this->GetImage( $post->ServiceData->service_single_image,$path=config('global.file_path.service_image'));
                } 
        
                $post->service_single_image =  $service_single_image;

                $service_detail = ServiceDetails::where('service_detail_id',$post->service_detail_id)->first();
                // $post->service_single_image =  $service_single_image;
                // $post->service_unit = $service_detail->service_unit;
        });
        
        $result = $this->CartListResponse($cart_data);
        return view('web.cart')->with(['cart_data' => $result]);   
        // return view('web.cart');       
	}
    
    public function addorder(Request $request)
    { 
        // echo "<pre>";
        // print_r($request->all());die;
        $input = $request->all();  
        $auth_user = Auth::user();
        // echo "<pre>";
        // print_r($auth_user);die;

        if($auth_user->id!='' && $input['order_amount'] !='' && $input['order_discount_amount'] !=''){

            $check_cart = Cart::where('user_id',$auth_user->id)->where('cart_status',0)->orderBy('created_at','desc')->get();
            
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

                            $service_id = $pro->ServiceData->service_id;
                            $ServiceDetails = $pro->ServiceData->ServiceDetails;
                            $ServiceDetailsarray= $ServiceDetails->sortByDesc('created_at')->values();
                                $order_detail_id = $this->GenerateUniqueRandomString($table='order_details', $column="order_detail_id", $chars=32);
                                    
                                $detailinput = array(
                                    'order_detail_id'      => $order_detail_id,
                                    'order_id' =>  $Order->order_id,
                                    'service_id' => $service_id,
                                    'service_detail_id'  => $pro->service_detail_id,
                                    'order_original_price' =>$pro->cart_service_original_price,
                                    'order_discount_price' =>$pro->cart_service_discount_price,
                                    'order_quantity' =>$pro->cart_service_quantity,
                                    'order_unit' =>$pro->cart_service_unit,

                                );
                                $OrderDetail = OrderDetail::create($detailinput);
                      
                            
                        });  

                        //------------------- activity log -----------------

                        $activity_log_id = $this->GenerateUniqueRandomString($table='activity_logs', $column="activity_log_id", $chars=32);
                        $input1['activity_log_id'] = $activity_log_id;
                        $input1['user_id'] = $auth_user->id;
                        $input1['order_id'] = $Order->order_id;
                        $input1['description'] = 'Hello! a request with Request ID "'. $Order->order_id.'" is PENDING to get accepted by Admin.';
                        $ActivityLog= ActivityLog::create($input1);

                        $check_order_detail= Order::where('order_id',$Order->order_id)->with('OrderDetails')->where('order_status',0)->first();
                        $orderdetail =[];
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
                        // print_r( $orderdetail);die;
                        // $check_order_detail->order_details = $orderdetail;
                        Cart::where('user_id',$auth_user->id)->delete();
                        $order_data = $this->OrderResponse($check_order_detail);
                        return Response::json(['result' => true,'message'=> 'order data added successfully.','cart_data'=> $order_data]); 

        }
        else{
                return Response::json(['result' => false,'message'=> ' Some error occured.!']); 
        }
    }
    
    public function orderthankyou()
    { 
        return view('web.orderthankyou');     
    }

    public function myorder()
    { 
        $auth_user = Auth::user();
        $order= Order::where('user_id',$auth_user->id)->where('order_status',0)->orderBy('created_at','desc')->get();

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
        $order_data = $this->OrderListResponse($order);
        return view('web.myorder')->with(['order_data' => $order_data]);
    }

    public function orderdetails($orderId)
    { 
        $check_order_detail= Order::where('order_id',$orderId)->with('OrderDetails')->where('order_status',0)->first();

        foreach($check_order_detail->OrderDetails as $detail){
            $service = Service::where('service_status',0)->where('service_id',$detail->service_id)->first();
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

        $order_data = $this->OrderResponse($check_order_detail);
        return view('web.orderdetails')->with(['orderData' => $order_data]);
    }

    public function deletecart(Request $request)
    { 
        $input = $request->all(); 
        $CloseGym  = Cart::where('cart_id',$input['cart_id'])->where('cart_status', 0)->first();
        if($CloseGym)
        {
            Cart::where('cart_id', $input['cart_id'])->update(['cart_status' => 1]);
            return Response::json(['result' => true,'message'=> 'cart data deleted successfully.']);
        }
        else
        {
            return Response::json(['result' => false,'message'=> 'cart data not found.']);
        }
   
    }
    
   
    public function ordercancle(Request $request)
    { 

        // echo "<pre>";
        // print_r($request->all());die;
        $input = $request->all(); 

        if($input['order_id'] !=''){

            Order::where('order_id', $input['order_id'])->update(['order_type' => 5]);
            $check_order_detail= Order::where('order_id',$input['order_id'])->with('OrderDetails')->where('order_status',0)->first();

            foreach($check_order_detail->OrderDetails as $detail){
                $service = Service::where('service_status',0)->where('service_id',$detail->service_id)->first();
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

            $order_data = $this->OrderResponse($check_order_detail);
            // return view('web.orderdetails')->with(['orderData' => $order_data]);
            return view('web.orderdetails')->with(['orderData' => $order_data]);
        }
        else{
            return redirect()->back()->with('error','Something want wrong!');
        }
        
    }

    
    public function updatequantity(Request $request)
    { 

        // echo "<pre>";
        // print_r($request->all());die;
        $input = $request->all(); 
        $cart_data = Cart::where('cart_id',$input['cart_id'])->where('cart_status', 0)->first();
        if($cart_data)
        {
            Cart::where('cart_id', $input['cart_id'])->update(['cart_service_quantity' => $input['cart_service_quantity']]);
            return Response::json(['result' => true,'message'=> 'cart quantity updated successfully.']);
        }
        else
        {
            return Response::json(['result' => false,'message'=> 'cart data not found.']);
        }

        
    }

    
    public function userProfile()
	{
		$auth_user = Auth::user();
        // return view('web.userprofile',compact('auth_user'));  

        $UserData=User::where('id',$auth_user->id)->first();
        $UserData->imageurl = $this->GetImage($file_name = $UserData->imageurl,$path=config('global.file_path.user_profile'));
        $master_data['state'] = State::orderBy('state_name')->where('state_status',0)->get();
        $master_data['district'] = District::orderBy('district_name')->where('district_status',0)->get();
        $master_data['taluka'] = Talukas::orderBy('taluka_name')->where('taluka_status',0)->get();
        $master_data['pincode'] = Pincode::orderBy('pincode')->where('pincode_status',0)->get();
        return view('web.userprofile',compact('UserData','master_data'));
	}
    
    public function saveProfile(Request $request)
	{
		$userData = $request->all();
        $message="";
        $imageurl = '';
        // if($userData['id'] !=''){
            $user=User::where(['id'=>$userData['id']])->first();
            $rules = [
                'email' => 'unique:users,email,'.$userData['id'].',id',
                'phone' => 'unique:users,phone,'.$userData['id'].',id',
            ];
            
            // 'email' => 'required|string|email|max:255|unique:users,email,'.$user->id
            $messages = [
                'email.unique'    => 'User already exist with this email. Try another.',
                'phone.unique'     => 'User already exist with this Phone no. Try another.',
        
            ];
            $validator = Validator::make($userData, $rules,$messages);       

            if ($validator->fails())
            {
                // echo 'in'; die;
                $errors = $validator->errors()->first();  
                
                $UserData=User::where(['id'=>$user->id])->first();
                $UserData->imageurl = $this->GetImage($file_name = $UserData->imageurl,$path=config('global.file_path.user_profile'));
                $master_data['state'] = State::orderBy('state_name')->where('state_status',0)->get();
                $master_data['district'] = District::orderBy('district_name')->where('district_status',0)->get();
                $master_data['taluka'] = Talukas::orderBy('taluka_name')->where('taluka_status',0)->get();
                $master_data['pincode'] = Pincode::orderBy('pincode')->where('pincode_status',0)->get();             
                return redirect()->back()->with('error',$errors);
                // Session::flash('error', $errors); 
                // return view('web.userprofile',compact('UserData','master_data'));
            }
            else
            {
                if($request->imageurl != "")
                {   
                    $imageurl = $this->UploadImage($file = $request->imageurl,$path = config('global.file_path.user_profile'));
                }
                else{
                    $imageurl =$user->imageurl;
                }
                $userData['imageurl'] = $imageurl;
                if($request->password !=''){
                    $userData['password'] = Hash::make($request->password);
                }
                else{
                    $userData['password'] = $user->password;
                }
                $user = User::find($userData['id']);
                $user->fill($userData);
                $user->save();
                $message="User Data Updated Successfully";

                $UserData=User::where(['id'=>$user->id])->first();
                $UserData->imageurl = $this->GetImage($file_name = $UserData->imageurl,$path=config('global.file_path.user_profile'));
                $master_data['state'] = State::orderBy('state_name')->where('state_status',0)->get();
                $master_data['district'] = District::orderBy('district_name')->where('district_status',0)->get();
                $master_data['taluka'] = Talukas::orderBy('taluka_name')->where('taluka_status',0)->get();
                $master_data['pincode'] = Pincode::orderBy('pincode')->where('pincode_status',0)->get();
                // Session::flash('message', $message); 
                
                // return view('web.userprofile',compact('UserData','master_data'));
            }
            return view('web.userprofile',compact('UserData','master_data')); 
        //}
	}
    
}
