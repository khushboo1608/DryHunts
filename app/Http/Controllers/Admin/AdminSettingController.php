<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Settings;
use Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
class AdminSettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('is_admin');
    }
    public function index(Request $request)
    {
        // return view('admin.setting.index');
        $data=Settings::where('is_disable',0)->first();
        return view('admin.setting.index')->with(['SettingsData' => $data]);
    }

    public function GeneralSetting(Request $request)
    {
        $data=Settings::where('is_disable',0)->first();       
        return view('admin.setting.general')->with(['SettingsData' => $data]);
    }
    
    public function SaveGeneral(Request $request)
    {
        // echo "<pre>";
        // print_r($request->all()); die;
        $settingData = $request->all();

        $message="";
        $app_logo = '';
        $app_upi_image = '';

        if($settingData['id'] !=''){
            
            if(!isset($settingData['app_maintenance_status'])){
                $settingData['app_maintenance_status'] =2;
            }
            if(!isset($settingData['app_update_cancel_button'])){
                $settingData['app_update_cancel_button'] =2;
            }

            if(!isset($settingData['app_update_factor_button'])){
                $settingData['app_update_factor_button'] =2;
            }
            if(isset($request->app_logo)){
                if($request->app_logo != "")
                {   
                    $app_logo = $this->UploadImage($file = $request->app_logo,$path = config('global.file_path.app_logo'));
                }           
            
                $settingData['app_logo'] = $app_logo;
            }
            if(isset($request->app_upi_image)){
                if($request->app_upi_image != "")
                {   
                    $app_upi_image = $this->UploadImage($file = $request->app_upi_image,$path = config('global.file_path.app_upi_image'));
                }           
            
                $settingData['app_upi_image'] = $app_upi_image;
            }
            
            // echo "<pre>"; 
            //     print_r($settingData); die;
            $setting= Settings::find($settingData['id']);
            $setting->fill($settingData);
            $setting->save();
            // $message="Data Updated Successfully";

        }else{
            
            if($request->app_logo != "")
            {   
                $app_logo = $this->UploadImage($file = $request->app_logo,$path = config('global.file_path.app_logo'));
            }
            else{
                $app_logo =$request->app_logo;
            }
            $settingData['app_logo'] = $app_logo;
            $setting_id = $this->GenerateUniqueRandomString($table='settings', $column="setting_id", $chars=32);
                $settingData['setting_id'] = $setting_id;

                // echo "<pre>"; 
                // print_r($settingData); die;
                Settings::create($settingData);
            $message="Data Insert Successfully";
        } 

        // Session::flash('message', $message);      
        return redirect('admin/generalsetting');
        
    }

    public function SavePageSetting(Request $request)
    {
        // echo "<pre>";
        // print_r($request->all()); die;
        $settingData = $request->all();

        $message="";

        if($settingData['id'] !=''){            
            
            // echo "<pre>"; 
            //     print_r($settingData); die;
            $setting= Settings::find($settingData['id']);
            $setting->fill($settingData);
            $setting->save();
            // $message="Data Updated Successfully";

        }else{
                // echo "<pre>"; 
                // print_r($settingData); die;
            Settings::create($settingData);
            $message="Data Insert Successfully";
        } 

        // Session::flash('message', $message);      
        return redirect('admin/setting');
        
    }

    
   
}
