<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
namespace App\Http\Controllers\Admin;
use App\DataTables\TalukaDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\District;
use App\Models\State;
use App\Models\Talukas;
use Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use App\Exports\TalukaExport;
use Maatwebsite\Excel\Facades\Excel;
use File;
class AdminTalukaController extends Controller
{
    public function __construct(TalukaDataTable $dataTable)
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
                return '<input type="checkbox" id="checkbox'.$data->taluka_id.'"  value="'.$data->taluka_id.'"  name="taluka_ids[]" class="taluka_ids" />';
            })     
            ->editColumn('district_name', function ($data) {
                return $data->districtData->district_name;               
            })       
            ->editColumn('state_name', function ($data) {
                return $data->stateData->state_name;               
            })
            ->addColumn('taluka_status', function ($data) {
                $btn1='';
                $checked = ($data['taluka_status'] == 1) ? "" : "checked";
                $title =  ($data['taluka_status'] == 1) ? "Disable" : "Enable";
                if($data['taluka_status'] == 1){
                    $btn1 = '<button type="button"  class="btn btn-danger btn-sm" onclick="Status(\''.$data->taluka_id  .'\','.$data->taluka_status.')">'.$title.' </i>
                    </button>';
                }
                else{
                    $btn1 = '<button type="button"  class="btn btn-success btn-sm" onclick="Status(\''.$data->taluka_id  .'\','.$data->taluka_status.')" >'.$title.' </i>
                    </button>';  
                }               
                return $btn1;
            })
            ->addColumn('action', function($data){

                $url=route("admin.taluka");
                $btn = '<a href="'.$url.'/edit/'.$data->taluka_id  .'"  style="color: white !important" ><button type="button" class="edit btn btn-primary btn-sm editPost"  title="edit"><i class="fa fa-edit"></i>
                </button></a>&nbsp;&nbsp;<button type="button"  class="btn btn-danger btn-sm deletePost" onclick="DeleteTaluka(\''.$data->taluka_id  .'\')" title="edit"><i class="fa fa-trash"></i>
                </button>';

                 return $btn;
         })
            ->rawColumns(['action','taluka_status','checkbox'])
            ->make(true);
        }
        return view('admin.taluka.index');
    }
    
    public function add_taluka(Request $request)
    {
        $data['state'] = State::orderBy('state_name')->where('state_status',0)->get();
        $data['district'] = District::orderBy('district_name')->where('district_status',0)->get();
        return view('admin.taluka.addtaluka')->with(['master_data' => $data]);
        // return view('admin.taluka.addtaluka');
    }

    public function savetaluka(Request $request)
    {
        $talukaData = $request->all();
        $message="";
        $imageurl = '';
        if($talukaData['id'] !=''){
            $Taluka=Talukas::where(['taluka_id'=>$talukaData['id']])->first();
          
            $taluka = Talukas::find($talukaData['id']);
            $taluka->fill($talukaData);
            $taluka->save();
            $message="Data Updated Successfully";

        }else{
            
            $taluka_id = $this->GenerateUniqueRandomString($table='talukas', $column="taluka_id", $chars=32);
                $talukaData['taluka_id'] = $taluka_id;
                Talukas::create($talukaData);
            $message="Data Insert Successfully";
        } 

        Session::flash('message', $message);      
        return redirect('admin/taluka');

    }
    public function taluka_status(Request $request)
    {
        // echo $request->is_disable;die;
        $taluka_id  = $request->id;
        Talukas::where('taluka_id',$taluka_id )->update(['taluka_status' => $request->is_disable]);

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
    

    public function taluka_delete(Request $request)
    {
        $taluka_id  = $request->id;
        Talukas::where('taluka_id',$taluka_id )->delete();
        return Response::json(['result' => true,'message'=> ' Taluka deleted..!']);

    }
    public function talukafileExport () 
    {
        return Excel::download(new TalukaExport, 'taluka-collection.xlsx');
    } 
    
    public function taluka_multi_status(Request $request)
    {
        $action=$request->action;

			if(!empty($request->id)) {
                $ids=$request->id;
			}
			if($action=='enable'){				
                Talukas::whereIn('taluka_id',$ids )->update(['taluka_status' => 0]);
                $msg = __('Enable successfully');
                $text = "Enabled";

			}else if($action=='disable'){

			    Talukas::whereIn('taluka_id',$ids )->update(['taluka_status' => 1]);
                $msg = __('Disable successfully');
                $text = "Disable";
				
			}else if($action=='delete'){
				
				Talukas::whereIn('taluka_id',$ids )->delete();
                $msg = __('Deleted successfully');
                $text = "Deleted";
			}
        return Response::json(['result' => true,'message'=>$msg,'text' =>$text]);
    }

    public function taluka_data_edit($id)
    {       
        $talukaData=Talukas::where('taluka_id',$id)->first();
        $master_data['state'] = State::orderBy('state_name')->where('state_status',0)->get();
        $master_data['district'] = District::where('state_id',$talukaData->state_id)->orderBy('district_name')->where('district_status',0)->get();
        // return view('admin.taluka.edit')->with(['talukaData' => $talukaData]);
        return view('admin.taluka.edit',compact('talukaData','master_data'));
    }
    public function getDropdownOptions(Request $request)
    {
        $selectedValue = $request->input('selectedValue');
        $options  =District::where('state_id', $selectedValue)->where(['district_status'=>0])->pluck('district_name', 'district_id');
        return response()->json($options);
    }
}
