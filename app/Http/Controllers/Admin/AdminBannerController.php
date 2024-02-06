<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
namespace App\Http\Controllers\Admin;
use App\DataTables\BannerDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Banner;
use Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use App\Exports\BannerExport;
use Maatwebsite\Excel\Facades\Excel;
use File;
class AdminBannerController extends Controller
{
    public function __construct(BannerDataTable $dataTable)
    {
        $this->middleware('is_admin');
        $this->dataTable = $dataTable;
    }


    public function index(Request $request)
    {
        if ($request->ajax()) {
            // print_r($data); die;
            return datatables()::of($this->dataTable->all($request))
            ->addIndexColumn()
            ->addColumn('checkbox', function ($data) {
                return '<input type="checkbox" id="checkbox'.$data->banner_id.'"  value="'.$data->banner_id.'"  name="banner_ids[]" class="banner_ids" />';
            })
            ->editColumn('imageurl', function ($data) {
                $imageurl = $this->GetImage($file_name = $data->banner_image,$path=config('global.file_path.banner_image'));
                
                if($imageurl == '')
                {
                    $imageurl = config('global.no_image.no_image');
                }
                return $imageurl;
            })
            ->addColumn('banner_status', function ($data) {
                $btn1='';
                $checked = ($data['banner_status'] == 1) ? "" : "checked";
                $title =  ($data['banner_status'] == 1) ? "Disable" : "Enable";
                if($data['banner_status'] == 1){
                    $btn1 = '<button type="button"  class="btn btn-danger btn-sm" onclick="Status(\''.$data->banner_id.'\','.$data->banner_status.')">'.$title.' </i>
                    </button>';
                }
                else{
                    $btn1 = '<button type="button"  class="btn btn-success btn-sm" onclick="Status(\''.$data->banner_id.'\','.$data->banner_status.')" >'.$title.' </i>
                    </button>';  
                }               
                return $btn1;
            })
            ->addColumn('action', function($data){

                $url=route("admin.banner");
                $btn = '<a href="'.$url.'/edit/'.$data->banner_id.'" style="color: white !important" ><button type="button" class="edit btn btn-primary btn-sm editPost"  title="edit"><i class="fa fa-edit"></i>
                </button></a>&nbsp;&nbsp;<button type="button"  class="btn btn-danger btn-sm deletePost" onclick="DeleteBanner(\''.$data->banner_id.'\')" title="edit"><i class="fa fa-trash"></i>
                </button>';

                 return $btn;
         })
            ->rawColumns(['action','banner_status','checkbox'])
            ->make(true);
        }
        return view('admin.banner.index');
    }
    
    public function add_banner(Request $request)
    {
        return view('admin.banner.addbanner');
    }

    public function savebanner(Request $request)
    {

        // echo "<pre>";
        // print_r($request->all());die;
        $bannerData = $request->all();
        $message="";
        $imageurl = '';
        if($bannerData['id'] !=''){
            $Banner=Banner::where(['banner_id'=>$bannerData['id']])->first();
            if($request->imageurl != "")
            {   
                $imageurl = $this->UploadImage($file = $request->imageurl,$path = config('global.file_path.banner_image'));
            }
            else{
                $imageurl =$Banner->banner_image;
            }
            $bannerData['banner_image'] = $imageurl;
            $banner = Banner::find($bannerData['id']);
            $banner->fill($bannerData);
            $banner->save();
            $message="Data Updated Successfully";

        }else{
            
            if($request->imageurl != "")
            {   
                $imageurl = $this->UploadImage($file = $request->imageurl,$path = config('global.file_path.banner_image'));
            }
            else{
                $imageurl =$request->imageurl;
            }
            $bannerData['banner_image'] = $imageurl;
            $banner_id = $this->GenerateUniqueRandomString($table='banners', $column="banner_id", $chars=32);
                $bannerData['banner_id'] = $banner_id;
            Banner::create($bannerData);
            $message="Data Insert Successfully";
        } 

        Session::flash('message', $message);      
        return redirect('admin/banner');

    }
    public function banner_status(Request $request)
    {
        // echo $request->is_disable;die;
        $banner_id  = $request->id;
        Banner::where('banner_id',$banner_id )->update(['banner_status' => $request->is_disable]);

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
    

    public function banner_delete(Request $request)
    {
        $banner_id  = $request->id;
        Banner::where('banner_id',$banner_id )->delete();
        return Response::json(['result' => true,'message'=> ' Banner deleted..!']);

    }
    public function bannerfileExport () 
    {
        return Excel::download(new BannerExport, 'banner-collection.xlsx');
    } 
    
    public function banner_multi_status(Request $request)
    {
        $action=$request->action;

			if(!empty($request->id)) {
                $ids=$request->id;
			}
			if($action=='enable'){				
                Banner::whereIn('banner_id',$ids )->update(['banner_status' => 0]);
                $msg = __('Enable successfully');
                $text = "Enabled";

			}else if($action=='disable'){

			    Banner::whereIn('banner_id',$ids )->update(['banner_status' => 1]);
                $msg = __('Disable successfully');
                $text = "Disable";
				
			}else if($action=='delete'){
				
				Banner::whereIn('banner_id',$ids )->delete();
                $msg = __('Deleted successfully');
                $text = "Deleted";
			}
        return Response::json(['result' => true,'message'=>$msg,'text' =>$text]);
    }

    public function banner_data_edit($id)
    {       
        $bannerData=Banner::where('banner_id',$id)->first();
        $bannerData->imageurl = $this->GetImage($file_name = $bannerData->banner_image,$path=config('global.file_path.banner_image'));
        return view('admin.banner.edit')->with(['bannerData' => $bannerData]);
    }
}
