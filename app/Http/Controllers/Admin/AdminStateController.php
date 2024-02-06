<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
namespace App\Http\Controllers\Admin;
use App\DataTables\StateDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\State;
use Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use App\Exports\StateExport;
use Maatwebsite\Excel\Facades\Excel;
use File;
class AdminStateController extends Controller
{
    public function __construct(StateDataTable $dataTable)
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
                return '<input type="checkbox" id="checkbox'.$data->state_id.'"  value="'.$data->state_id.'"  name="state_ids[]" class="state_ids" />';
            })
            ->addColumn('state_status', function ($data) {
                $btn1='';
                $checked = ($data['state_status'] == 1) ? "" : "checked";
                $title =  ($data['state_status'] == 1) ? "Disable" : "Enable";
                if($data['state_status'] == 1){
                    $btn1 = '<button type="button"  class="btn btn-danger btn-sm" onclick="Status(\''.$data->state_id  .'\','.$data->state_status.')">'.$title.' </i>
                    </button>';
                }
                else{
                    $btn1 = '<button type="button"  class="btn btn-success btn-sm" onclick="Status(\''.$data->state_id  .'\','.$data->state_status.')" >'.$title.' </i>
                    </button>';  
                }               
                return $btn1;
            })
            ->addColumn('action', function($data){

                $url=route("admin.state");
                $btn = '<a href="'.$url.'/edit/'.$data->state_id  .'" style="color: white !important" ><button type="button" class="edit btn btn-primary btn-sm editPost"  title="edit"><i class="fa fa-edit"></i>
                </button></a>&nbsp;&nbsp;<button type="button"  class="btn btn-danger btn-sm deletePost" onclick="DeleteState(\''.$data->state_id  .'\')" title="edit"><i class="fa fa-trash"></i>
                </button>';

                 return $btn;
         })
            ->rawColumns(['action','state_status','checkbox'])
            ->make(true);
        }
        return view('admin.state.index');
    }
    
    public function add_state(Request $request)
    {
        return view('admin.state.addstate');
    }

    public function savestate(Request $request)
    {

        // echo "<pre>";
        // print_r($request->all());die;
        $stateData = $request->all();
        $message="";
        if($stateData['id'] !=''){
            $State=State::where(['state_id'=>$stateData['id']])->first();            
            $state = State::find($stateData['id']);
            $state->fill($stateData);
            $state->save();
            $message="Data Updated Successfully";

        }else{
            
            $state_id = $this->GenerateUniqueRandomString($table='states', $column="state_id", $chars=32);
                $stateData['state_id'] = $state_id;
            State::create($stateData);
            $message="Data Insert Successfully";
        } 

        Session::flash('message', $message);      
        return redirect('admin/state');

    }
    public function state_status(Request $request)
    {
        $state_id  = $request->id;
        State::where('state_id',$state_id )->update(['state_status' => $request->is_disable]);

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
    

    public function state_delete(Request $request)
    {
        $state_id  = $request->id;
        State::where('state_id',$state_id )->delete();
        return Response::json(['result' => true,'message'=> ' State deleted..!']);

    }
    public function statefileExport() 
    {
        return Excel::download(new StateExport, 'state-collection.xlsx');
    } 
    
    public function state_multi_status(Request $request)
    {
        $action=$request->action;

			if(!empty($request->id)) {
                $ids=$request->id;
			}
			if($action=='enable'){				
                State::whereIn('state_id',$ids )->update(['state_status' => 0]);
                $msg = __('Enable successfully');
                $text = "Enabled";

			}else if($action=='disable'){

			    State::whereIn('state_id',$ids )->update(['state_status' => 1]);
                $msg = __('Disable successfully');
                $text = "Disable";
				
			}else if($action=='delete'){
				
				State::whereIn('state_id',$ids )->delete();
                $msg = __('Deleted successfully');
                $text = "Deleted";
			}
        return Response::json(['result' => true,'message'=>$msg,'text' =>$text]);
    }

    public function state_data_edit($id)
    {       
        $stateData=State::where('state_id',$id)->first();
        return view('admin.state.edit')->with(['stateData' => $stateData]);
    }
}
