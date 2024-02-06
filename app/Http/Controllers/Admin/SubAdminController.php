<?php

namespace App\Http\Controllers\Admin;
use App\DataTables\SubAdminDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Response;
use Validator;
use App\Models\District;
use App\Models\State;
use App\Models\Talukas;
use App\Models\Pincode;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use App\Exports\SubAdminDataExport;
use Maatwebsite\Excel\Facades\Excel;
use File;

class SubAdminController extends Controller
{
    public function __construct(SubAdminDataTable $dataTable)
    {
        $this->middleware('is_admin');
        $this->dataTable = $dataTable;
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // print_r($data); die;
            return datatables()::of($this->dataTable->all($request))
            ->addColumn('checkbox', function ($data) {
                return '<input type="checkbox" id="checkbox'.$data->id.'"  value="'.$data->id.'"  name="user_ids[]" class="user_ids" />';
            })
            ->editColumn('imageurl', function ($data) {
                $imageurl = $this->GetImage($file_name = $data->imageurl,$path=config('global.file_path.user_profile'));
                
                if($imageurl == '')
                {
                    $imageurl = config('global.no_image.no_user');
                }
                return $imageurl;
            })
            ->addColumn('is_disable', function ($data) {
                $btn1='';
                $checked = ($data['is_disable'] == 1) ? "" : "checked";
                $title =  ($data['is_disable'] == 1) ? "Disable" : "Enable";
                if($data['is_disable'] == 1){
                    $btn1 = '<button type="button"  class="btn btn-danger btn-sm" onclick="Status(\''.$data->id.'\','.$data->is_disable.')">'.$title.' </i>
                    </button>';
                }
                else{
                    $btn1 = '<button type="button"  class="btn btn-success btn-sm" onclick="Status(\''.$data->id.'\','.$data->is_disable.')" >'.$title.' </i>
                    </button>';  
                }               
                return $btn1;
            })
            ->addColumn('action', function($data){

                $url=route("admin.subadmin");
                $btn = '<a href="'.$url.'/edit/'.$data->id.'" style="color: white !important" ><button type="button" class="edit btn btn-primary btn-sm editPost"  title="edit"><i class="fa fa-edit"></i>
                </button></a>&nbsp;&nbsp;<button type="button"  class="btn btn-danger btn-sm deletePost" onclick="DeleteUser(\''.$data->id.'\')" title="edit"><i class="fa fa-trash"></i>
                </button>';

                 return $btn;
         })
            ->rawColumns(['action','is_disable', 'checkbox'])
            ->make(true);
        }
        return view('admin.subadmin.index');
    }
    public function subadmin_delete(Request $request)
    {
        $user_id = $request->id;
        $model=User::find($user_id);
        $model->delete();
        return Response::json(['result' => true,'message'=>
        'User deleted..!']);
    }
    public function subadmin_details(Request $request)
    {    
      $SQL=User::where('id',$request->id)->get();
      $SQL[0]->imageurl_link = $this->GetImage($file_name = $SQL[0]->imageurl,$path=config('global.file_path.user_profile'));
      return json_encode($SQL[0]);
    }

    public function update_subadmin_data(Request $request)
    {
        $subadmin = $request->all();
        $imageurl = '';
        if($request->image64 != "")
        {   
            $imageurl = $this->UploadImageBase64($file = $request->image64,$path = config('global.file_path.user_profile'));
        }
        else{
            $imageurl =$request->profileImage;
        }
        $subadmin['imageurl'] = $imageurl;
        $subadmin['location'] = $subadmin['address'];
        $subadmin['latitude'] = $subadmin['latitude'];
        $subadmin['longitude'] = $subadmin['longitude'];

        $random_latlong = $this->RandomLatLong($subadmin['latitude'],$subadmin['longitude']);
        $subadmin['random_latitude'] = $random_latlong['random_latitude'];
        $subadmin['random_longitude'] = $random_latlong['random_longitude'];

        $user = User::find($subadmin['id']);
        $user->fill($subadmin);
        $user->save();
        return Response::json(['result' => true,'message'=>__('messages.admin.user.edit_user_success')]);
    }
    public function subadmin_data_edit($id)
    {       
        $subadmin=User::where('id',$id)->first();
        $subadmin->imageurl = $this->GetImage($file_name = $subadmin->imageurl,$path=config('global.file_path.user_profile'));

        // echo "<pre>";
        // print_r($data); die;
        $master_data['state'] = State::orderBy('state_name')->where('state_status',0)->get();
        $master_data['district'] = District::orderBy('district_name')->where('district_status',0)->get();
        $master_data['taluka'] = Talukas::orderBy('taluka_name')->where('taluka_status',0)->get();
        $master_data['pincode'] = Pincode::orderBy('pincode')->where('pincode_status',0)->get();
        return view('admin.subadmin.edit',compact('subadmin','master_data'));
        // return view('admin.subadmin.edit')->with(['UserData' => $data]);
    }
        
    public function add_subadmin(Request $request)
    {       
        $data['state'] = State::orderBy('state_name')->where('state_status',0)->get();
        return view('admin.subadmin.addsubadmin')->with(['master_data' => $data]);
        // return view('admin.subadmin.addsubadmin',$result);
        
    }

    public function savesubadmin(Request $request)
    {
        $subadmin = $request->all();
        $message="";
        $imageurl = '';
        if($subadmin['id'] !=''){
            $user=User::where(['id'=>$subadmin['id']])->first();
            $rules = [
                'email' => 'unique:users,email,'.$subadmin['id'].',id',
                'phone' => 'unique:users,phone,'.$subadmin['id'].',id',
            ];
            
            // 'email' => 'required|string|email|max:255|unique:users,email,'.$user->id
            $messages = [
                'email.unique'    => 'User already exist with this email. Try another.',
                'phone.unique'     => 'User already exist with this Phone no. Try another.',
        
            ];
            $validator = Validator::make($subadmin, $rules,$messages);       

            if ($validator->fails())
            {
                // echo 'in'; die;
                $errors = $validator->errors()->first();                
                return redirect()->back()->with('error',$errors);
            }
            else
            {
                if($request->imageurl != "")
                {   
                    $imageurl = $this->UploadImage($file = $request->imageurl,$path = config('global.file_path.user_profile'));
                }
                else{
                    $imageurl =$user->imageurl;
                }
                $subadmin['imageurl'] = $imageurl;
                if($request->password !=''){
                    $subadmin['password'] = Hash::make($request->password);
                }
                else{
                    $subadmin['password'] = $user->password;
                }
                $user = User::find($subadmin['id']);
                $user->fill($subadmin);
                $user->save();
                $message="Sub Admin Data Updated Successfully";
            }

        }else{
            $rules = array('email' => 'unique:users,email','phone' => 'unique:users,phone');
            $messages = [
                'email.unique'    => 'User already exist with this email. Try another.',
                'phone.unique'     => 'User already exist with this Phone no. Try another.',
        
            ];
            $validator = Validator::make($subadmin, $rules,$messages);

            if ($validator->fails())
            {
                $errors = $validator->errors()->first();                
                return redirect()->back()->with('error',$errors);
            }
            else
            {
            
                if($request->imageurl != "")
                {   
                    $imageurl = $this->UploadImage($file = $request->imageurl,$path = config('global.file_path.user_profile'));
                }
                else{
                    $imageurl =$request->imageurl;
                }
                $subadmin['imageurl'] = $imageurl;
                // $subadmin['login_type'] = 2;
                // echo "<pre>";
                // print_r($subadmin);die;
                $subadmin['password'] = Hash::make($request->password);
                User::create($subadmin);
                $message="Sub Admin Insert Successfully";
            }
        } 

        Session::flash('message', $message);      
        return redirect('admin/subadmin');

    }

    public function subadmin_status(Request $request)
    {
        // echo $request->is_disable;die;
        $user_id  = $request->id;
        User::where('id',$user_id )->update(['is_disable' => $request->is_disable]);

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

    public function subadminfileexport() 
    {
        return Excel::download(new SubAdminDataExport, 'subadmin-data-collection.xlsx');
    } 

    public function subadmin_multi_status(Request $request)
    {
        $action=$request->action;

			if(!empty($request->id)) {
                $ids=$request->id;
			}
			if($action=='enable'){				
                User::whereIn('id',$ids )->update(['is_disable' => 0]);
                $msg = __('Enable successfully');
                $text = "Enabled";

			}else if($action=='disable'){

			    User::whereIn('id',$ids )->update(['is_disable' => 1]);
                $msg = __('Disable successfully');
                $text = "Disable";
				
			}else if($action=='delete'){
				
				User::whereIn('id',$ids )->delete();
                $msg = __('Deleted successfully');
                $text = "Deleted";
			}
        return Response::json(['result' => true,'message'=>$msg,'text' =>$text]);
    }
}
