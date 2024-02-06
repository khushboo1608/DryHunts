<?php

namespace App\Http\Controllers\Admin;
use App\DataTables\ServiceDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\ServiceDetails;
use Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;

use App\Exports\ServiceDataExport;
use Maatwebsite\Excel\Facades\Excel;
use File;
use Validator;

class AdminServiceController extends Controller
{
    public function __construct(ServiceDataTable $dataTable)
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
                return '<input type="checkbox" id="checkbox'.$data->service_id.'"  value="'.$data->service_id.'"  name="service_ids[]" class="service_ids" />';
            })
            ->editColumn('imageurl', function ($data) {
                $imageurl = $this->GetImage($file_name = $data->service_single_image,$path=config('global.file_path.service_image'));
                
                if($imageurl == '')
                {
                    $imageurl = config('global.no_image.no_image');
                }
                return $imageurl;
            })
            
            ->addColumn('category_name', function($data){
                return $data->CategoryData->category_name;
            })
  
            ->addColumn('service_status', function ($data) {
                $btn1='';
                $checked = ($data['service_status'] == 1) ? "" : "checked";
                $title =  ($data['service_status'] == 1) ? "Disable" : "Enable";
                if($data['service_status'] == 1){
                    $btn1 = '<button type="button"  class="btn btn-danger btn-sm deletegym" onclick="Status(\''.$data->service_id .'\','.$data->service_status.')">'.$title.' </i>
                    </button>';
                }
                else{
                    $btn1 = '<button type="button"  class="btn btn-success btn-sm deletegym" onclick="Status(\''.$data->service_id .'\','.$data->service_status.')" >'.$title.' </i>
                    </button>';  
                }               
                return $btn1;
            })
            ->addColumn('action', function($data){

                $url=route("admin.service");
                $btn = '<a href="'.$url.'/edit/'.$data->service_id .'"  style="color: white !important" ><button type="button" class="edit btn btn-primary btn-sm editPost"  title="edit"><i class="fa fa-edit"></i>
                </button></a>&nbsp;&nbsp;<button type="button"  class="btn btn-danger btn-sm deletePost" onclick="DeleteService(\''.$data->service_id .'\')" title="edit"><i class="fa fa-trash"></i>
                </button>';
                 return $btn;
         })
            ->rawColumns(['action','service_status','service_feature', 'checkbox'])
            ->make(true);
        }
        return view('admin.service.index');
    }       

    public function add_service(Request $request)
    {
        $data['category'] = Category::orderBy('category_name')->where('category_status',0)->get();
        return view('admin.service.addservice')->with(['master_data' => $data]);
        // return view('admin.service.addservice');
    }

    public function saveservice(Request $request)
    {
        // echo "<pre>";
        // print_r($request->all());die;

        $input = $request->all();
        $message="";
        $imageurl = '';
        $service_multiple_image =[];
        $multiple_image ='';
        if($input['id'] !=''){
            // echo 'in';die;
            $services=Service::with('ServiceDetails')->where(['service_id'=>$input['id']])->first();
            if($request->imageurl != "")
            {   
                $imageurl = $this->UploadImage($file = $request->imageurl,$path = config('global.file_path.service_image'));
            }
            else{
                $imageurl =$services->service_single_image;
            }
            if(isset($request->service_multiple_image))
            {
                if($request->service_multiple_image != "")
                {   
                    foreach ($request->service_multiple_image as $key => $value) {
                        $service_multiple_image[] = $this->UploadImage($file = $value,$path = config('global.file_path.service_image'));
                        }
                    $multiple_image = implode(',',$service_multiple_image);
                }
                else
                {
                    $multiple_image = $services->service_multiple_image;
                }
            }
            else{
                $multiple_image ='';
            }
            $arr2 = explode(",",$multiple_image);
            
            if($services->service_multiple_image !=''){
                $arr1 = explode(",",$services->service_multiple_image);
            }
            else{
                $arr1 =[];
            }
            $arr2 = array_filter($arr2, 'strlen');
            if(count($arr1)> 0){
                $newarray = array_merge($arr1, $arr2);
                $newarray1 = implode(',', $newarray);                    
            }
            else{
                $newarray1 = implode(',', $arr2);                   
            }
            $is_popular = 0;
            if($request->is_popular == 'on')
                {   
                    $is_popular = 1;
                }
                else{
                    $is_popular = 0;
                }
            $input['is_popular'] = $is_popular;
            $input['service_single_image'] = $imageurl;
            $input['service_multiple_image'] = $newarray1;
            $input['service_price'] = 0;
            // echo "<pre>";
            // print_r($input);die;
            $service = Service::find($input['id']);
            $service->fill($input);
            $service->save();

            $service_original_price =$request->service_original_price;
            $service_discount_price =$request->service_discount_price;
            $service_unit =$request->service_unit;
            $service_quantity =$request->service_quantity;
            $service_detail_id =$request->service_detail_id;


            // echo "<pre>";
            // print_r($service_detail_id);die;

            $detailData = ServiceDetails::where('service_id',$input['id'])->get(); 
            if(count($detailData)>0)
            {
                // ServiceDetails::where('service_id',$input['id'])->update(['service_detail_status'=>1]); 
              
               
                foreach ($service_original_price as $index => $value) {

                //     echo "<pre>";
                // print_r($value);

                if(!empty($service_detail_id[$index])){
                    $detaildata = ServiceDetails::where('service_detail_id',$service_detail_id[$index])->first();
                    if($detaildata->service_detail_id !=''){
                        // echo 'if';
                        $detaildata = ServiceDetails::where('service_detail_id',$detaildata->service_detail_id)->update(['service_original_price'=>$service_original_price[$index],'service_discount_price'=>$service_discount_price[$index],'service_unit'=> $service_unit[$index],'service_quantity'  => 0]); 
                    }
                    else{
                        // echo 'else';
                        $service_detail_id  = $this->GenerateUniqueRandomString($table='service_details', $column="service_detail_id", $chars=32);

                        $service_detail_input = [
                            'service_detail_id'      => $service_detail_id,
                            'service_id'           => $input['id'],
                            'service_original_price' => $service_original_price[$index],
                            'service_discount_price'  =>$service_discount_price[$index],
                            'service_unit'  => $service_unit[$index],
                            'service_quantity'  => 0
                        ];
                                        
                        ServiceDetails::create($service_detail_input);
                    }
                }
                else{
                    $service_detail_id  = $this->GenerateUniqueRandomString($table='service_details', $column="service_detail_id", $chars=32);

                        $service_detail_input = [
                            'service_detail_id'      => $service_detail_id,
                            'service_id'           => $input['id'],
                            'service_original_price' => $service_original_price[$index],
                            'service_discount_price'  =>$service_discount_price[$index],
                            'service_unit'  => $service_unit[$index],
                            'service_quantity'  => 0
                        ];
                                        
                        ServiceDetails::create($service_detail_input);
                }

            
                }
                // die;
            }
            else{
                foreach ($service_original_price as $index => $value) {
                    $service_detail_id  = $this->GenerateUniqueRandomString($table='service_details', $column="service_detail_id", $chars=32);

                    $service_detail_input = [
                        'service_detail_id'      => $service_detail_id,
                        'service_id'           => $input['id'],
                        'service_original_price' => $service_original_price[$index],
                        'service_discount_price'  =>$service_discount_price[$index],
                        'service_unit'  => $service_unit[$index],
                        'service_quantity'  => 0
                    ];
                                    
                    ServiceDetails::create($service_detail_input);
            
                }
            }
            // die;
            $message="Data Updated Successfully";

        }else{
            
            if($request->imageurl != "")
            {   
                $imageurl = $this->UploadImage($file = $request->imageurl,$path = config('global.file_path.service_image'));
            }
            else{
                $imageurl =$request->imageurl;
            }
            if($request->service_multiple_image != "")
            {   
                foreach ($request->service_multiple_image as $key => $value) {
                    $service_multiple_image[] = $this->UploadImage($file = $value,$path = config('global.file_path.service_image'));
                    }
                $multiple_image = implode(',',$service_multiple_image); 
            }
            $is_popular = 0;
            if($request->is_popular == 'on')
                {   
                    $is_popular = 1;
                }
            $input['is_popular'] = $is_popular;
            $input['service_single_image'] = $imageurl;
            $input['service_multiple_image'] = $multiple_image;
            $service_id  = $this->GenerateUniqueRandomString($table='service', $column="service_id", $chars=32);
            $input['service_id'] = $service_id;
            // echo "<pre>";
            // print_r($input);die;
            $input['service_price'] = 0;       
            $service = Service::create($input);
    
            $service_original_price =$request->service_original_price;
            $service_discount_price =$request->service_discount_price;
            $service_unit =$request->service_unit;
            $service_quantity =$request->service_quantity;
            // echo "<pre>";
            // print_r($request->service_original_price);die;
            foreach ($service_original_price as $index => $value) {
                $service_detail_id  = $this->GenerateUniqueRandomString($table='service_details', $column="service_detail_id", $chars=32);

                $service_detail_input = [
                    'service_detail_id'      => $service_detail_id,
                    'service_id'           => $service->service_id,
                    'service_original_price' => $service_original_price[$index],
                    'service_discount_price'  =>$service_discount_price[$index],
                    'service_unit'  => $service_unit[$index],
                    'service_quantity'  => 0
                ];
                ServiceDetails::create($service_detail_input);        
            }
            $message="Data Insert Successfully";
        } 

        Session::flash('message', $message);      
        return redirect('admin/service');

    }

    public function service_status(Request $request)
    {
        // echo $request->is_disable;die;
        $service_id  = $request->id;
        Service::where('service_id',$service_id )->update(['service_status' => $request->is_disable]);

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

    public function service_featured(Request $request)
    {
        // echo $request->is_disable;die;
        $service_id  = $request->id;
        Service::where('service_id',$service_id )->update(['service_feature' => $request->is_disable]);

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

    public function service_delete(Request $request)
    {
        $service_id  = $request->id;
        Service::where('service_id',$service_id )->delete();
        ServiceDetails::where('service_id',$service_id)->delete();  
        return Response::json(['result' => true,'message'=> 'service deleted..!']);
    }

    public function servicefileExport() 
    {
        return Excel::download(new ServiceDataExport, 'service-collection.xlsx');
    } 
    
    public function service_multi_status(Request $request)
    {
        $action=$request->action;

        // print_r($request->id);die;

			if(!empty($request->id)) {
                $ids=$request->id;
			}
			if($action=='enable'){				
                Service::whereIn('service_id',$ids)->update(['service_status' => 0]);
                $msg = __('Enable successfully');
                $text = "Enabled";

			}else if($action=='disable'){

			    Service::whereIn('service_id',$ids)->update(['service_status' => 1]);
                $msg = __('Disable successfully');
                $text = "Disable";
				
			}else if($action=='delete'){
				
				Service::whereIn('service_id',$ids)->delete();
                $msg = __('Deleted successfully');
                $text = "Deleted";
			}
        return Response::json(['result' => true,'message'=>$msg,'text' =>$text]);
    }

    public function service_data_edit($id)
    {       
        
        // echo $id;die;
        // $serviceData=Service::with('ServiceDetails')->where('service_id',$id)->first();
       
            $serviceData =  Service::with(['ServiceDetails' => function($q) use($id) {
                // Query the name field in status table
                    $q->where('service_detail_status', '!=', '1'); 
                    $q->orderBy('created_at', 'asc');
                }])->where('service_id',$id)->where('service_status',0)->first();

        // echo "<pre>";
        // print_r($serviceData);die;
        $serviceData->imageurl = $this->GetImage($file_name = $serviceData->service_single_image,$path=config('global.file_path.service_image')); 

        // $data->service_multiple_image = $data->service_multiple_image;
        $service_gallery = [];
        if(isset($serviceData->service_multiple_image))
        {  
            $service_multiple_image = explode(',',$serviceData->service_multiple_image);
            foreach ($service_multiple_image as $key => $val) {
                $service_gallery[] = $this->GetImage($val,$path=config('global.file_path.service_image'));
            }
        } 
        $serviceData->service_multiple_image = $service_gallery; 

        // return view('admin.service.edit')->with(['serviceData' => $data]);
        $master_data['category'] = Category::orderBy('category_name')->where('category_status',0)->get();
        return view('admin.service.edit',compact('serviceData','master_data'));
    }
   
    public function delete_img($id,$img_id)
    {        
        $ServiceData=Service::where('service_id',$id)->first();
        $img = explode(",", $ServiceData->service_multiple_image);
        $image ='';
        foreach (array_keys($img, $img_id) as $key) {
            unset($img[$key]);
        }
              
        if(count($img)>0){

            $image = implode(',', $img);
        }
        else{
            $image =  NULL;
        }
        Service::where('service_id',$id)->update(['service_multiple_image' => $image]);  
        return $this->service_data_edit($id);
    }
    public function delete_variation($id)
    {        
        // echo $id;die;
        ServiceDetails::where('service_detail_id',$id)->update(['service_detail_status' =>1]);  
        $ServiceDetailData=ServiceDetails::where('service_detail_id',$id)->first();
        
        return $this->service_data_edit($ServiceDetailData->service_id);
    }
}
