<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
namespace App\Http\Controllers\Admin;
use App\DataTables\PincodeDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\District;
use App\Models\State;
use App\Models\Talukas;
use App\Models\Pincode;
use Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use App\Exports\PincodeExport;
use Maatwebsite\Excel\Facades\Excel;
use File;
class AdminPincodeController extends Controller
{
    public function __construct(PincodeDataTable $dataTable)
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
                return '<input type="checkbox" id="checkbox'.$data->pincode_id.'"  value="'.$data->pincode_id.'"  name="pincode_ids[]" class="pincode_ids" />';
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
            ->addColumn('pincode_status', function ($data) {
                $btn1='';
                $checked = ($data['pincode_status'] == 1) ? "" : "checked";
                $title =  ($data['pincode_status'] == 1) ? "Disable" : "Enable";
                if($data['pincode_status'] == 1){
                    $btn1 = '<button type="button"  class="btn btn-danger btn-sm" onclick="Status(\''.$data->pincode_id  .'\','.$data->pincode_status.')">'.$title.' </i>
                    </button>';
                }
                else{
                    $btn1 = '<button type="button"  class="btn btn-success btn-sm" onclick="Status(\''.$data->pincode_id  .'\','.$data->pincode_status.')" >'.$title.' </i>
                    </button>';  
                }               
                return $btn1;
            })
            ->addColumn('action', function($data){

                $url=route("admin.pincode");
                $btn = '<a href="'.$url.'/edit/'.$data->pincode_id  .'"  style="color: white !important" ><button type="button" class="edit btn btn-primary btn-sm editPost"  title="edit"><i class="fa fa-edit"></i>
                </button></a>&nbsp;&nbsp;<button type="button"  class="btn btn-danger btn-sm deletePost" onclick="DeletePincode(\''.$data->pincode_id  .'\')" title="edit"><i class="fa fa-trash"></i>
                </button>';

                 return $btn;
         })
            ->rawColumns(['action','pincode_status','checkbox'])
            ->make(true);
        }
        return view('admin.pincode.index');
    }
    
    public function add_pincode(Request $request)
    {
        $data['state'] = State::orderBy('state_name')->where('state_status',0)->get();
        $data['district'] = District::orderBy('district_name')->where('district_status',0)->get();
        $data['taluka'] = Talukas::orderBy('taluka_name')->where('taluka_status',0)->get();
        return view('admin.pincode.addpincode')->with(['master_data' => $data]);
        // return view('admin.pincode.addpincode');
    }

    public function savepincode(Request $request)
    {
        $pincodeData = $request->all();
        $message="";
        $imageurl = '';
        if($pincodeData['id'] !=''){
            $Pincode=Pincode::where(['pincode_id'=>$pincodeData['id']])->first();
           
            $pincode = Pincode::find($pincodeData['id']);
            $pincode->fill($pincodeData);
            $pincode->save();
            $message="Data Updated Successfully";

        }else{
            
            $pincode_id = $this->GenerateUniqueRandomString($table='pincodes', $column="pincode_id", $chars=32);
                $pincodeData['pincode_id'] = $pincode_id;
                Pincode::create($pincodeData);
            $message="Data Insert Successfully";
        } 

        Session::flash('message', $message);      
        return redirect('admin/pincode');

    }
    public function pincode_status(Request $request)
    {
        // echo $request->is_disable;die;
        $pincode_id  = $request->id;
        Pincode::where('pincode_id',$pincode_id )->update(['pincode_status' => $request->is_disable]);

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
    

    public function pincode_delete(Request $request)
    {
        $pincode_id  = $request->id;
        Pincode::where('pincode_id',$pincode_id )->delete();
        return Response::json(['result' => true,'message'=> ' Pincode deleted..!']);

    }
    public function pincodefileExport () 
    {
        return Excel::download(new PincodeExport, 'pincode-collection.xlsx');
    } 
    
    public function pincode_multi_status(Request $request)
    {
        $action=$request->action;

			if(!empty($request->id)) {
                $ids=$request->id;
			}
			if($action=='enable'){				
                Pincode::whereIn('pincode_id',$ids )->update(['pincode_status' => 0]);
                $msg = __('Enable successfully');
                $text = "Enabled";

			}else if($action=='disable'){

			    Pincode::whereIn('pincode_id',$ids )->update(['pincode_status' => 1]);
                $msg = __('Disable successfully');
                $text = "Disable";
				
			}else if($action=='delete'){
				
				Pincode::whereIn('pincode_id',$ids )->delete();
                $msg = __('Deleted successfully');
                $text = "Deleted";
			}
        return Response::json(['result' => true,'message'=>$msg,'text' =>$text]);
    }

    public function pincode_data_edit($id)
    {       
        $pincodeData=Pincode::where('pincode_id',$id)->first();
        $master_data['state'] = State::orderBy('state_name')->where('state_status',0)->get();
     
        $master_data['district'] = District::where('state_id',$pincodeData->state_id)->orderBy('district_name')->where('district_status',0)->get();
        $master_data['taluka'] = Talukas::where('district_id',$pincodeData->district_id)->orderBy('taluka_name')->where('taluka_status',0)->get();
        // return view('admin.pincode.edit')->with(['pincodeData' => $pincodeData]);
        return view('admin.pincode.edit',compact('pincodeData','master_data'));
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
    
}
