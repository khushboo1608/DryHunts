<?php
namespace App\DataTables;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use DB;
class OrderDataTable
{
    public function all()
    {
        $auth_user = Auth::guard('admin')->user();
        // echo "<pre>";
        // print_r($auth_user);die;
        if($auth_user->login_type == 3){
            $data = Order::where('district_id',$auth_user->district_id)->orderBy('created_at','desc')->get();
        
        }
        elseif($auth_user->login_type == 4){
            $data = Order::where('taluka_id',$auth_user->taluka_id)->orderBy('created_at','desc')->get();
        }
        else{

            $data = Order::orderBy('created_at','desc')->get();
        }
        return $data;
    }
    
}
