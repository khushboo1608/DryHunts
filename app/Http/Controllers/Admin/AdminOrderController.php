<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
namespace App\Http\Controllers\Admin;
use App\DataTables\OrderDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ActivityLog;
use Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use App\Exports\OrderExport;
use Maatwebsite\Excel\Facades\Excel;
use File;
use Illuminate\Support\Facades\Auth;

class AdminOrderController extends Controller
{
    public function __construct(OrderDataTable $dataTable)
    {
        $this->middleware('is_admin');
        $this->dataTable = $dataTable;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            
            return datatables()::of($this->dataTable->all($request))
            ->addIndexColumn()
            ->addColumn('checkbox', function ($data) {
                return '<input type="checkbox" id="checkbox'.$data->order_id.'"  value="'.$data->order_id.'"  name="order_ids[]" class="order_ids" />';
            })
            ->addColumn('user_name', function($data){
                // print_r($data->User); die;
                return $data->User->name;
            })
            
            ->editColumn('created_at', function ($data) {
                $date =$this->getLocalTime(strtotime($data->created_at), 'Asia/Kolkata');
                // $date = date('d M, Y h:iA', strtotime($data->created_at ));
                return $date;
            })
            ->editColumn('request_for', function ($data) {
                $checked = ($data['request_for'] == 1) ? "Quotation" : "Maintenance";
                return $checked;
            })
            ->editColumn('order_type', function ($data) {
                $order_type = '';
                if($data->order_type == 1){
                    $order_type ='pending';
                }
                else if($data->order_type == 2){
                    $order_type ='accepted';
                }
                else if($data->order_type == 3){
                    $order_type ='work in progress';
                }
                else if($data->order_type == 4){
                    $order_type ='completed';
                }
                else{
                    $order_type ='cancelled';
                }
                return $order_type; 
            })
            ->editColumn('payment_type', function ($data) {
                $payment_type = '';
                if($data->payment_type == 1){
                    $payment_type ='COD';
                }
                else if($data->payment_type == 2){
                    $payment_type ='Online Payment';
                }
                else if($data->payment_type == 3){
                    $payment_type ='Wallet';
                }
                return $payment_type; 
            })
            ->addColumn('order_status', function ($data) {
                $btn1='';
                $checked = ($data['order_status'] == 1) ? "" : "checked";
                $title =  ($data['order_status'] == 1) ? "Disable" : "Enable";
                if($data['order_status'] == 1){
                    $btn1 = '<button type="button"  class="btn btn-danger btn-sm" onclick="Status(\''.$data->order_id  .'\','.$data->order_status.')">'.$title.' </i>
                    </button>';
                }
                else{
                    $btn1 = '<button type="button"  class="btn btn-success btn-sm" onclick="Status(\''.$data->order_id  .'\','.$data->order_status.')" >'.$title.' </i>
                    </button>';  
                }               
                return $btn1;
            })
            ->addColumn('action', function($data){

                $url=route("admin.order");
                $btn = '<a href="'.$url.'/edit/'.$data->order_id  .'" style="color: white !important" ><button type="button" class="edit btn btn-primary btn-sm editPost"  title="edit"><i class="fa fa-edit"></i>
                </button></a>&nbsp;&nbsp;<button type="button"  class="btn btn-danger btn-sm deletePost" onclick="DeleteOrder(\''.$data->order_id  .'\')" title="edit"><i class="fa fa-trash"></i>
                </button>';                
                 return $btn;
         })
            ->rawColumns(['action','order_status','checkbox'])
            ->make(true);
        }
        return view('admin.order.index');
    }
    
    public function add_order(Request $request)
    {
        return view('admin.order.addorder');
    }

    public function saveorder(Request $request)
    {
        $auth_user = Auth::guard('admin')->user();
        $orderData = $request->all();
        $message="";
        $quotation_pdf = '';
        if($orderData['id'] !=''){
            $Order=Order::where(['order_id'=>$orderData['id']])->first();
            if($request->quotation_pdf != "")
            {   
                $quotation_pdf = $this->UploadImage($file = $request->quotation_pdf,$path = config('global.file_path.order_quotation'));
            }
            else{
                $quotation_pdf =$Order->quotation_pdf;
            }

            // echo "<pre>";
            // print_r($orderData);die;
            $description = '';
            if($orderData['order_type'] == 1){
                $description ='Hello!a request with Request ID "'. $orderData['id'].'" is PENDING to get accepted by Admin.';
            }
            else if($orderData['order_type'] == 2){
                $description =' The request with Request ID  "'. $orderData['id'].'"has been ACCEPTED by Admin.';                    
            }
            else if($orderData['order_type'] == 3){
                $description = 'The request with Request ID  "'. $orderData['id'].'" is now INPROGRESS.';                   
            }
            else if($orderData['order_type'] == 4){
                $description ='The request with Request ID  "'. $orderData['id'].'" has been COMPLETED by Admin.';                }
            else{
                $description ='The request with Request ID  "'. $orderData['id'].'" has been CANCELLED by Admin.';
            }

            $activity_log_id = $this->GenerateUniqueRandomString($table='activity_logs', $column="activity_log_id", $chars=32);
            $input1['activity_log_id'] = $activity_log_id;
            $input1['user_id'] = $auth_user->id;
            $input1['order_id'] = $orderData['id'];
            $input1['description'] = $description;
            $ActivityLog= ActivityLog::create($input1);
            $orderData['quotation_pdf'] = $quotation_pdf;
            $order = Order::find($orderData['id']);
            $order->fill($orderData);
            $order->save();
            $message="Data Updated Successfully";

        }else{
            
            if($request->quotation_pdf != "")
            {   
                $quotation_pdf = $this->UploadImage($file = $request->quotation_pdf,$path = config('global.file_path.order_quotation'));
            }
            else{
                $quotation_pdf =$request->quotation_pdf;
            }
            $orderData['order_quotation'] = $quotation_pdf;
            $order_id = $this->GenerateUniqueRandomString($table='orders', $column="order_id", $chars=32);
            $orderData['order_id'] = $order_id;
            Order::create($orderData);
            $message="Data Insert Successfully";
        } 

        Session::flash('message', $message);      
        return redirect('admin/order');
    }
    public function order_status(Request $request)
    {
        // echo $request->is_disable;die;
        $order_id  = $request->id;
        Order::where('order_id',$order_id )->update(['order_status' => $request->is_disable]);

        if($request->is_disable == 0)
        {
            $msg = __('Enable successfully');
            $text = "Enabled";
        }
        else
        {
            $msg = __('Disable successfully');
            $text = "Disabled";           
        }
        return Response::json(['result' => true,'message'=>$msg,'text' =>$text]);
    }
    
    public function order_delete(Request $request)
    {
        $order_id  = $request->id;
        Order::where('order_id',$order_id )->delete();
        return Response::json(['result' => true,'message'=> ' Order deleted..!']);

    }
    public function orderfileExport() 
    {
        return Excel::download(new OrderExport, 'order-collection.xlsx');
    } 
    
    public function order_multi_status(Request $request)
    {
        $action=$request->action;
        if(!empty($request->id)) {
            $ids=$request->id;
        }
        if($action=='enable'){				
            Order::whereIn('order_id',$ids )->update(['order_status' => 0]);
            $msg = __('Enable successfully');
            $text = "Enabled";

        }else if($action=='disable'){

            Order::whereIn('order_id',$ids )->update(['order_status' => 1]);
            $msg = __('Disable successfully');
            $text = "Disable";
            
        }else if($action=='delete'){
            
            Order::whereIn('order_id',$ids )->delete();
            $msg = __('Deleted successfully');
            $text = "Deleted";
        }
        return Response::json(['result' => true,'message'=>$msg,'text' =>$text]);
    }

    public function order_data_edit($id)
    {       
        $orderData=Order::where('order_id',$id)->first();
        $orderData->imageurl = $this->GetImage($file_name = $orderData->order_quotation,$path=config('global.file_path.order_quotation'));       
        $master_data =  ActivityLog::where('order_id',$id)->orderBy('created_at','asc')->get();
        return view('admin.order.edit',compact('orderData','master_data'));
        // return view('admin.order.edit')->with(['orderData' => $orderData]);
    }
}
