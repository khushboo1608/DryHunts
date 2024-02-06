<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
namespace App\Http\Controllers\Admin;
use App\DataTables\TestimonialDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\District;
use App\Models\State;
use App\Models\Talukas;
use App\Models\Pincode;
use App\Models\Testimonial;
use App\Models\Service;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\ServiceDetails;
use Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use App\Exports\TestimonialExport;
use Maatwebsite\Excel\Facades\Excel;
use File;
class AdminTestimonialController extends Controller
{
    public function __construct(TestimonialDataTable $dataTable)
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
                return '<input type="checkbox" id="checkbox'.$data->testimonial_id.'"  value="'.$data->testimonial_id.'"  name="testimonial_ids[]" class="testimonial_ids" />';
            }) 
            ->editColumn('pincode', function ($data) {
                return $data->pincodeData->pincode;               
            })   
            ->editColumn('taluka_name', function ($data) {
                return $data->talukaData->taluka_name;               
            })      
            ->editColumn('district_name', function ($data) {
                return $data->districtData->district_name;               
            })       
            ->editColumn('state_name', function ($data) {
                return $data->stateData->state_name;               
            })
            ->addColumn('testimonial_status', function ($data) {
                $btn1='';
                $checked = ($data['testimonial_status'] == 1) ? "" : "checked";
                $title =  ($data['testimonial_status'] == 1) ? "Disable" : "Enable";
                if($data['testimonial_status'] == 1){
                    $btn1 = '<button type="button"  class="btn btn-danger btn-sm" onclick="Status(\''.$data->testimonial_id  .'\','.$data->testimonial_status.')">'.$title.' </i>
                    </button>';
                }
                else{
                    $btn1 = '<button type="button"  class="btn btn-success btn-sm" onclick="Status(\''.$data->testimonial_id  .'\','.$data->testimonial_status.')" >'.$title.' </i>
                    </button>';  
                }               
                return $btn1;
            })
            ->addColumn('action', function($data){

                $url=route("admin.testimonial");
                $btn = '<a href="'.$url.'/edit/'.$data->testimonial_id  .'" style="color: white !important" ><button type="button" class="edit btn btn-primary btn-sm editPost"  title="edit"><i class="fa fa-edit"></i>
                </button></a>&nbsp;&nbsp;<button type="button"  class="btn btn-danger btn-sm deletePost" onclick="DeleteTestimonial(\''.$data->testimonial_id  .'\')" title="edit"><i class="fa fa-trash"></i>
                </button>';

                 return $btn;
         })
            ->rawColumns(['action','testimonial_status','checkbox'])
            ->make(true);
        }
        return view('admin.testimonial.index');
    }
    
    public function add_testimonial(Request $request)
    {
        $data['state'] = State::orderBy('state_name')->where('state_status',0)->get();
        $data['district'] = District::orderBy('district_name')->where('district_status',0)->get();
        $data['taluka'] = Talukas::orderBy('taluka_name')->where('taluka_status',0)->get();
        $data['pincode'] = Pincode::orderBy('pincode')->where('pincode_status',0)->get();
        $data['category'] = Category::orderBy('category_name')->where('category_status',0)->get();
        return view('admin.testimonial.addtestimonial')->with(['master_data' => $data]);
        // return view('admin.testimonial.addtestimonial');
    }

    public function savetestimonial(Request $request)
    {
        $testimonialData = $request->all();
        // echo "<pre>";
        // print_r($testimonialData);die;
        $message="";
        $imageurl = '';
        if($testimonialData['id'] !=''){
            $Testimonial=Testimonial::where(['testimonial_id'=>$testimonialData['id']])->first();
            if($request->testimonial_image != "")
            {   
                $imageurl = $this->UploadImage($file = $request->testimonial_image,$path = config('global.file_path.testimonial_image'));
            }
            else{
                $imageurl =$Testimonial->testimonial_image;
            }
            $testimonialData['testimonial_image'] = $imageurl;

           
            $testimonial = Testimonial::find($testimonialData['id']);
            $testimonial->fill($testimonialData);
            $testimonial->save();
            $message="Data Updated Successfully";

        }else{
            
            if($request->testimonial_image != "")
            {   
                $imageurl = $this->UploadImage($file = $request->testimonial_image,$path = config('global.file_path.testimonial_image'));
            }
            else{
                $imageurl =$request->testimonial_image;
            }
            $testimonialData['testimonial_image'] = $imageurl;
            $testimonial_id = $this->GenerateUniqueRandomString($table='testimonials', $column="testimonial_id", $chars=32);
                $testimonialData['testimonial_id'] = $testimonial_id;
                Testimonial::create($testimonialData);
            $message="Data Insert Successfully";
        } 

        Session::flash('message', $message);      
        return redirect('admin/testimonial');

    }
    public function testimonial_status(Request $request)
    {
        // echo $request->is_disable;die;
        $testimonial_id  = $request->id;
        Testimonial::where('testimonial_id',$testimonial_id )->update(['testimonial_status' => $request->is_disable]);

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
    

    public function testimonial_delete(Request $request)
    {
        $testimonial_id  = $request->id;
        Testimonial::where('testimonial_id',$testimonial_id )->delete();
        return Response::json(['result' => true,'message'=> ' Testimonial deleted..!']);

    }
    public function testimonialfileExport () 
    {
        return Excel::download(new TestimonialExport, 'testimonial-collection.xlsx');
    } 
    
    public function testimonial_multi_status(Request $request)
    {
        $action=$request->action;

			if(!empty($request->id)) {
                $ids=$request->id;
			}
			if($action=='enable'){				
                Testimonial::whereIn('testimonial_id',$ids )->update(['testimonial_status' => 0]);
                $msg = __('Enable successfully');
                $text = "Enabled";

			}else if($action=='disable'){

			    Testimonial::whereIn('testimonial_id',$ids )->update(['testimonial_status' => 1]);
                $msg = __('Disable successfully');
                $text = "Disable";
				
			}else if($action=='delete'){
				
				Testimonial::whereIn('testimonial_id',$ids )->delete();
                $msg = __('Deleted successfully');
                $text = "Deleted";
			}
        return Response::json(['result' => true,'message'=>$msg,'text' =>$text]);
    }

    public function testimonial_data_edit($id)
    {       
        $testimonialData=Testimonial::where('testimonial_id',$id)->first();
        // echo "<pre>";
        // print_r($testimonialData);die;
        $master_data['state'] = State::orderBy('state_name')->where('state_status',0)->get();
        $master_data['district'] = District::where('state_id',$testimonialData->state_id)->orderBy('district_name')->where('district_status',0)->get();
        $master_data['taluka'] = Talukas::where('district_id',$testimonialData->district_id)->orderBy('taluka_name')->where('taluka_status',0)->get();
        $master_data['pincode'] = Pincode::where('taluka_id',$testimonialData->taluka_id)->orderBy('pincode')->where('pincode_status',0)->get();

        $master_data['category'] = Category::orderBy('category_name')->where('category_status',0)->get();
        $master_data['service'] = Service::where('category_id',$testimonialData->category_id)->orderBy('service_name')->where('service_status',0)->get();
        $testimonialData->testimonial_image = $this->GetImage($file_name = $testimonialData->testimonial_image,$path=config('global.file_path.testimonial_image'));
        // return view('admin.testimonial.edit')->with(['testimonialData' => $testimonialData]);
        return view('admin.testimonial.edit',compact('testimonialData','master_data'));
    }
    public function getDropdownOptions(Request $request)
    {
        $selectedValue = $request->input('selectedValue');
        $options  =District::where('state_id', $selectedValue)->where(['district_status'=>0])->pluck('district_name', 'district_id');
        return response()->json($options);
    }
    public function getDropdownTalukaOptions(Request $request)
    {
        $selectedValue1 = $request->input('selectedValue1');
        $options  =Talukas::where('district_id', $selectedValue1)->where(['taluka_status'=>0])->pluck('taluka_name', 'taluka_id');
        return response()->json($options);
    }

    public function getDropdownPincodeOptions(Request $request)
    {
        $selectedValue2 = $request->input('selectedValue2');
        $options  =Pincode::where('taluka_id', $selectedValue2)->where(['pincode_status'=>0])->pluck('pincode', 'pincode_id');
        return response()->json($options);
    }
    
    public function getDropdownServiceOptions(Request $request)
    {
        $selectedValue3 = $request->input('selectedValue3');
        $options  =Service::where('category_id', $selectedValue3)->where(['service_status'=>0])->pluck('service_name', 'service_id');
        return response()->json($options);
    }
    
    
}
