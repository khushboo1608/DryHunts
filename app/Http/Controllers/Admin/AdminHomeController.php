<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminHomeController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('is_admin');
    }
    public function index(Request $request)
    {
        // echo 'in'; die;
        $role = $request->session()->get('AdminRole');
        // echo $role;die;
        $user_count = User::where('login_type',2)->count();
        // return view('home')->with(['user_count' => $user_count]); 
        $auth_user = Auth::guard('admin')->user();
        if( $role == 1){
            return view('admin/home',compact('user_count'));
        }
        elseif( $role == 3 || $role == 4 || $role !=2){
            return redirect('admin/order');
        }
        else{

            return view('admin/home',compact('user_count'));
        }
        // return view('admin/home');
    }
    public function profile(Request $request)
    {
        $auth_user = Auth::guard('admin')->user();
        $admin = $auth_user;

        // echo "<pre>";
        // print_r($auth_user);die;
        return view('admin.admin-user.profile',compact('admin'));
    }
    public function update_profile(Request $request)
    {
        // echo "<pre>";
        // print_r($request->all());die;
        $auth_user = Auth::guard('admin')->user();
        $admin = $auth_user;
        if( $auth_user->profile_image !=''){
            $this->RemoveImage($name = $auth_user->profile_image,$path = config('global.file_path.user_profile'));
        }
       
        $profile_image ='';
        if($request->imageurl != "")
        {   
            $profile_image = $this->UploadImage($file = $request->imageurl,$path = config('global.file_path.user_profile'));
        }
        else{
            if($auth_user->profile_image !=''){
                $profile_image =$auth_user->profile_image;
            }
        }
        $userData['imageurl'] = $profile_image;
        // echo "<pre>";
        // print_r($auth_user->id);die;
        $user = User::find($auth_user->id);
        $user->fill($userData);
        $user->save();
        return redirect('admin/profile')->with(['profile-update' =>__('messages.admin.user.update_profile_success')]);
    }
    public function check_old_password(Request $request)
    {
        $auth_user = auth()->user();
        $admin = $auth_user;
        $flag = "false";
        if (\Hash::check($request->old_password, $admin->password) == true)
        {
            $flag = "true";
        }
        return $flag;
    }
    public function change_password(Request $request)
    {
        $auth_user = auth()->user();
        $admin = $auth_user;
        $update_password = User::where('id',$admin->id)->update([
            'password' => bcrypt($request->new_password),
        ]);
        return redirect('admin/profile')->with(['profile-update' =>__('messages.admin.user.update_password_success')]);
    }
}
