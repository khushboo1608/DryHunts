<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\UserAuthMaster;
use App\Models\UserOrganizationMaster;
use App\Models\RegisterLinkClick;
use DB;
class UserController extends Controller
{
	public function __construct() 
	{
		$this->middleware('auth');
	}
	public function index()
	{
		return view('web.profile');               
	}

	public function userdata()
	{
		$user_count = User::where('is_disable',0)->count();
		$user_data = User::get();
		$current_timezone = isset($input['current_timezone']) ? $input['current_timezone'] : config('global.current_time_zone');
		date_default_timezone_set($current_timezone);
		$current_date = date('Y-m-d');
		// $online_count = User::withCount(['UserAuthMaster'])->count();
		$online_count = User::where(function($q)use($current_date){
			$q->orwhereHas('UserAuthMaster', function ($qr) use ($current_date) {
				$qr->whereDate('updated_at',$current_date);
			});                   
		})->orderBy('created_at','desc')->count();    
		// die;
        $offline_count =  $user_count - $online_count;          
		// $registerlink_count = RegisterLinkClick::where('is_disable',0)->count();
        // return view('web.userdata',compact('online_count','user_count','offline_count','registerlink_count'));
		return view('web.userdata',compact('online_count','user_count','offline_count'));
		// return view('web.userdata');               
	}

	public function update_profile(Request $request)
	{
		$input = $request->all();
		$auth_user = Auth::user();
		$profile_image = '';
		if($request->image64 != "")
		{   
			if (strpos($input['image64'], 'data:image/jpeg;base64') !== false)
			{
				$this->RemoveImage($name = $auth_user->profile_image,$path = config('global.file_path.user_profile'));
				$profile_image = $this->UploadImageBase64($file = $request->image64,$path = config('global.file_path.user_profile'));
			}
			else
			{
				$profile_image = $request->image64;
			}
		}
		$input['profile_image'] = $profile_image;
		$input['location'] = $input['address'];
		$input['first_name'] = $input['organization_name'];
		$organization_update['organization_name'] = $input['organization_name'];
		$organization_update['registration_id'] = $input['registration_id'];
		$organization_update['contact_no'] = $input['contact_number'];
		$user = User::find($auth_user->id);
		$user->fill($input);
		$user->save();
		UserOrganizationMaster::where('user_id',$auth_user->id)->update($organization_update);
		return redirect()->back()->with('message', __('messages.web.user.profile_update_success'));
	}
	public function change_password(Request $request)
	{
		return view('web.change-password');     
	}
	public function check_old_password(Request $request)
	{
		$auth_user = Auth::user();
	}
}
