<?php

namespace App\Helper;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Settings;
use App\Models\Service;
use App\Models\Cart;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class Helper 
{
	public static function LoggedUserImage()
	{
		$auth_user = Auth::guard('admin')->user();
		$data = $auth_user->toArray();

		// echo "<pre>";
		// print_r($auth_user);die;
		if(isset($data['imageurl']))
		{
			if(file_exists(public_path(config('global.file_path.user_profile').'/'.$data['imageurl'])))
			{
				$Image = url('public/'.config('global.file_path.user_profile')).'/'.$data['imageurl'];
			}
			else
			{	
				$Image = config('global.no_image.no_user');
			}
		}
		else
		{
			$Image = config('global.no_image.no_user');
		}
		return $Image;
	}

	public static function LoggedWebUserImage()
	{
		$auth_user = Auth::guard('web')->user();
		$data = $auth_user->toArray();
		if(isset($data['imageurl']))
		{
			$con = new Controller();
			$Image = $con->GetImage($data['imageurl'],$path=config('global.file_path.user_profile'));
			if($Image == '')
			{
				$Image = config('global.no_image.no_user');
			}
		}
		else
		{
			$Image = config('global.no_image.no_user');
		}
		return $Image;
	}

	public static function AppLogoImage()
	{
		$setting =  Settings::first();
		if(isset($setting->app_logo))
		{
			if(file_exists(public_path(config('global.file_path.app_logo').'/'.$setting->app_logo)))
			{
				$Image = url('public/'.config('global.file_path.app_logo')).'/'.$setting->app_logo;
			}
			else
			{	
				$Image = config('global.no_image.no_image');
			}
		}
		else
		{
			$Image = config('global.no_image.no_image');
		}
		return $Image;
	}

	public static function AppName()
	{
		$setting =  Settings::first();
		if(isset($setting->app_name))
		{
			// echo 'if';die;
			
			if($setting->app_name !='')
			{
				$Name = $setting->app_name;
			}
			else
			{	
				$Name = env('APP_NAME');
			}
		}
		else
		{
			// echo env('APP_NAME'); die;
			$Name = env('APP_NAME');
		}
		return $Name;
	}

	
	public static function ServiceImage()
	{
		$auth_user = Auth::guard('admin')->user();
		$data = $auth_user->toArray();

		// echo "<pre>";
		// print_r($data);die;
		if(isset($data['imageurl']))
		{
			if(file_exists(public_path(config('global.file_path.user_profile').'/'.$data['imageurl'])))
			{
				$Image = url('public/'.config('global.file_path.user_profile')).'/'.$data['imageurl'];
			}
			else
			{	
				$Image = config('global.no_image.no_user');
			}
		}
		else
		{
			$Image = config('global.no_image.no_user');
		}
		return $Image;
	}

	public static function readMoreHelper($story_desc, $chars = 38)
	{
		// $story_desc = substr($story_desc,0,$chars);  
		// $story_desc = substr($story_desc,0,strrpos($story_desc,' '));  
		// $story_desc = $story_desc."...";  
		$story_desc = (strlen($story_desc) > $chars) ?substr($story_desc,0,$chars)."...":$story_desc;
		return $story_desc;  
	}

	
	public static function CartCount($id)
	{
		$cart_count = Cart::where('user_id',$id)->where('cart_status',0)->count();
		
		return $cart_count;
	}

}
?>