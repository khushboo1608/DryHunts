<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
namespace App\Http\Controllers\Admin;
use App\DataTables\GallaryDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Gallary;
use Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use App\Exports\GallaryExport;
use Maatwebsite\Excel\Facades\Excel;
use File;
class AdminGallaryController extends Controller
{
    public function __construct(GallaryDataTable $dataTable)
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
                return '<input type="checkbox" id="checkbox'.$data->gallary_id.'"  value="'.$data->gallary_id.'"  name="gallary_ids[]" class="gallary_ids" />';
            })
            ->editColumn('imageurl', function ($data) {
                $imageurl = $this->GetImage($file_name = $data->gallary_image,$path=config('global.file_path.gallary_image'));
                
                if($imageurl == '')
                {
                    $imageurl = config('global.no_image.no_image');
                }
                return $imageurl;
            })
            ->editColumn('gallary_url', function ($data) {
                $imageurl = $this->GetImage($file_name = $data->gallary_image,$path=config('global.file_path.gallary_image'));
                
                if($imageurl == '')
                {
                    $imageurl = config('global.no_image.no_image');
                }
                return $imageurl;
            })
            ->addColumn('gallary_status', function ($data) {
                $btn1='';
                $checked = ($data['gallary_status'] == 1) ? "" : "checked";
                $title =  ($data['gallary_status'] == 1) ? "Disable" : "Enable";
                if($data['gallary_status'] == 1){
                    $btn1 = '<button type="button"  class="btn btn-danger btn-sm" onclick="Status(\''.$data->gallary_id  .'\','.$data->gallary_status.')">'.$title.' </i>
                    </button>';
                }
                else{
                    $btn1 = '<button type="button"  class="btn btn-success btn-sm" onclick="Status(\''.$data->gallary_id  .'\','.$data->gallary_status.')" >'.$title.' </i>
                    </button>';  
                }               
                return $btn1;
            })
            ->addColumn('action', function($data){

                $url=route("admin.gallary");
                $btn = '<a href="'.$url.'/edit/'.$data->gallary_id  .'" style="color: white !important" ><button type="button" class="edit btn btn-primary btn-sm editPost"  title="edit"><i class="fa fa-edit"></i>
                </button></a>&nbsp;&nbsp;<button type="button"  class="btn btn-danger btn-sm deletePost" onclick="DeleteGallary(\''.$data->gallary_id  .'\')" title="edit"><i class="fa fa-trash"></i>
                </button>';

                 return $btn;
         })
            ->rawColumns(['action','gallary_status','checkbox'])
            ->make(true);
        }
        return view('admin.gallary.index');
    }
    
    public function add_gallary(Request $request)
    {
        return view('admin.gallary.addgallary');
    }

    public function savegallary(Request $request)
    {

        // echo "<pre>";
        // print_r($request->all());die;
        $gallaryData = $request->all();
        $message="";
        $imageurl = '';
        if($gallaryData['id'] !=''){
            $Gallary=Gallary::where(['gallary_id'=>$gallaryData['id']])->first();
            if($request->imageurl != "")
            {   
                $imageurl = $this->UploadImage($file = $request->imageurl,$path = config('global.file_path.gallary_image'));
            }
            else{
                $imageurl =$Gallary->gallary_image;
            }
            $gallaryData['gallary_image'] = $imageurl;
            $gallary = Gallary::find($gallaryData['id']);
            $gallary->fill($gallaryData);
            $gallary->save();
            $message="Data Updated Successfully";

        }else{
            
            if($request->imageurl != "")
            {   
                $imageurl = $this->UploadImage($file = $request->imageurl,$path = config('global.file_path.gallary_image'));
            }
            else{
                $imageurl =$request->imageurl;
            }
            $gallaryData['gallary_image'] = $imageurl;
            $gallary_id = $this->GenerateUniqueRandomString($table='gallaries', $column="gallary_id", $chars=32);
                $gallaryData['gallary_id'] = $gallary_id;
            Gallary::create($gallaryData);
            $message="Data Insert Successfully";
        } 

        Session::flash('message', $message);      
        return redirect('admin/gallary');

    }
    public function gallary_status(Request $request)
    {
        // echo $request->is_disable;die;
        $gallary_id  = $request->id;
        Gallary::where('gallary_id',$gallary_id )->update(['gallary_status' => $request->is_disable]);

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
    

    public function gallary_delete(Request $request)
    {
        $gallary_id  = $request->id;
        Gallary::where('gallary_id',$gallary_id )->delete();
        return Response::json(['result' => true,'message'=> ' Gallary deleted..!']);

    }
    public function gallaryfileExport () 
    {
        return Excel::download(new GallaryExport, 'gallary-collection.xlsx');
    } 
    
    public function gallary_multi_status(Request $request)
    {
        $action=$request->action;

			if(!empty($request->id)) {
                $ids=$request->id;
			}
			if($action=='enable'){				
                Gallary::whereIn('gallary_id',$ids )->update(['gallary_status' => 0]);
                $msg = __('Enable successfully');
                $text = "Enabled";

			}else if($action=='disable'){

			    Gallary::whereIn('gallary_id',$ids )->update(['gallary_status' => 1]);
                $msg = __('Disable successfully');
                $text = "Disable";
				
			}else if($action=='delete'){
				
				Gallary::whereIn('gallary_id',$ids )->delete();
                $msg = __('Deleted successfully');
                $text = "Deleted";
			}
        return Response::json(['result' => true,'message'=>$msg,'text' =>$text]);
    }

    public function gallary_data_edit($id)
    {       
        $gallaryData=Gallary::where('gallary_id',$id)->first();
        $gallaryData->imageurl = $this->GetImage($file_name = $gallaryData->gallary_image,$path=config('global.file_path.gallary_image'));
        return view('admin.gallary.edit')->with(['gallaryData' => $gallaryData]);
    }
}
