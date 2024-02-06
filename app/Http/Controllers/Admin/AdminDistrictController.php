<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
namespace App\Http\Controllers\Admin;
use App\DataTables\DistrictDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\District;
use App\Models\State;

use Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use App\Exports\DistrictExport;
use Maatwebsite\Excel\Facades\Excel;
use File;
class AdminDistrictController extends Controller
{
    public function __construct(DistrictDataTable $dataTable)
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
                return '<input type="checkbox" id="checkbox'.$data->district_id.'"  value="'.$data->district_id.'"  name="district_ids[]" class="district_ids" />';
            })            
            ->editColumn('state_name', function ($data) {
                return $data->stateData->state_name;               
            })
            ->addColumn('district_status', function ($data) {
                $btn1='';
                $checked = ($data['district_status'] == 1) ? "" : "checked";
                $title =  ($data['district_status'] == 1) ? "Disable" : "Enable";
                if($data['district_status'] == 1){
                    $btn1 = '<button type="button"  class="btn btn-danger btn-sm" onclick="Status(\''.$data->district_id  .'\','.$data->district_status.')">'.$title.' </i>
                    </button>';
                }
                else{
                    $btn1 = '<button type="button"  class="btn btn-success btn-sm" onclick="Status(\''.$data->district_id  .'\','.$data->district_status.')" >'.$title.' </i>
                    </button>';  
                }               
                return $btn1;
            })
            ->addColumn('action', function($data){

                $url=route("admin.district");
                $btn = '<a href="'.$url.'/edit/'.$data->district_id  .'" style="color: white !important" ><button type="button" class="edit btn btn-primary btn-sm editPost"  title="edit"><i class="fa fa-edit"></i>
                </button></a>&nbsp;&nbsp;<button type="button"  class="btn btn-danger btn-sm deletePost" onclick="DeleteDistrict(\''.$data->district_id  .'\')" title="edit"><i class="fa fa-trash"></i>
                </button>';

                 return $btn;
         })
            ->rawColumns(['action','district_status','checkbox'])
            ->make(true);
        }
        return view('admin.district.index');
    }
    
    public function add_district(Request $request)
    {
        $data['state'] = State::orderBy('state_name')->where('state_status',0)->get();
        return view('admin.district.adddistrict')->with(['master_data' => $data]);
        // return view('admin.district.adddistrict');
    }

    public function savedistrict(Request $request)
    {
        $districtData = $request->all();
        $message="";
        if($districtData['id'] !=''){
            $District=District::where(['district_id'=>$districtData['id']])->first();
            $district = District::find($districtData['id']);
            $district->fill($districtData);
            $district->save();
            $message="Data Updated Successfully";

        }else{
            
            $district_id = $this->GenerateUniqueRandomString($table='districts', $column="district_id", $chars=32);
                $districtData['district_id'] = $district_id;
            District::create($districtData);
            $message="Data Insert Successfully";
        } 

        Session::flash('message', $message);      
        return redirect('admin/district');

    }
    public function district_status(Request $request)
    {
        $district_id  = $request->id;
        District::where('district_id',$district_id )->update(['district_status' => $request->is_disable]);

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
    

    public function district_delete(Request $request)
    {
        $district_id  = $request->id;
        District::where('district_id',$district_id )->delete();
        return Response::json(['result' => true,'message'=> ' District deleted..!']);

    }
    public function districtfileExport () 
    {
        return Excel::download(new DistrictExport, 'district-collection.xlsx');
    } 
    
    public function district_multi_status(Request $request)
    {
        $action=$request->action;

			if(!empty($request->id)) {
                $ids=$request->id;
			}
			if($action=='enable'){				
                District::whereIn('district_id',$ids )->update(['district_status' => 0]);
                $msg = __('Enable successfully');
                $text = "Enabled";

			}else if($action=='disable'){

			    District::whereIn('district_id',$ids )->update(['district_status' => 1]);
                $msg = __('Disable successfully');
                $text = "Disable";
				
			}else if($action=='delete'){
				
				District::whereIn('district_id',$ids )->delete();
                $msg = __('Deleted successfully');
                $text = "Deleted";
			}
        return Response::json(['result' => true,'message'=>$msg,'text' =>$text]);
    }

    public function district_data_edit($id)
    {       
        $districtData=District::where('district_id',$id)->first();
        $master_data['state'] = State::orderBy('state_name')->where('state_status',0)->get();
        return view('admin.district.edit',compact('districtData','master_data'));
    }
}
