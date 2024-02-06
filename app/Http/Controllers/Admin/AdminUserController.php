<?php

namespace App\Http\Controllers\Admin;
use App\DataTables\UserDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserAuthMaster;
use App\Models\District;
use App\Models\State;
use App\Models\Talukas;
use App\Models\Pincode;
use Response;
use Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use App\Exports\UserDataExport;
use Maatwebsite\Excel\Facades\Excel;
use File;

class AdminUserController extends Controller
{
    public function __construct(UserDataTable $dataTable)
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
            ->addColumn('is_verified', function ($data) {
                $btn1='';
                $checked = ($data['is_verified'] == 1) ? "" : "checked";
                $title =  ($data['is_verified'] == 0) ? "Disable" : "Enable";
                if($data['is_verified'] == 0){
                    $btn1 = '<button type="button"  class="btn btn-danger btn-sm" onclick="isverify(\''.$data->id.'\','.$data->is_verified.')">'.$title.' </i>
                    </button>';
                }
                else{
                    $btn1 = '<button type="button"  class="btn btn-success btn-sm" onclick="isverify(\''.$data->id.'\','.$data->is_verified.')" >'.$title.' </i>
                    </button>';  
                }               
                return $btn1;
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

                $url=route("admin.user");
                $btn = '<a href="'.$url.'/edit/'.$data->id.'" style="color: white !important" ><button type="button" class="edit btn btn-primary btn-sm editPost"  title="edit"><i class="fa fa-edit"></i>
                </button></a>&nbsp;&nbsp;<button type="button"  class="btn btn-danger btn-sm deletePost" onclick="DeleteUser(\''.$data->id.'\')" title="edit"><i class="fa fa-trash"></i>
                </button>';

                 return $btn;
         })
            ->rawColumns(['action','is_disable', 'checkbox','is_verified'])
            ->make(true);
        }
        return view('admin.user.index');
    }
    public function user_delete(Request $request)
    {
        $user_id = $request->id;
        $model=User::find($user_id);
        $model->delete();
        return Response::json(['result' => true,'message'=>
        'User deleted..!']);
    }
    public function user_details(Request $request)
    {    
      $SQL=User::where('id',$request->id)->get();
      $SQL[0]->imageurl_link = $this->GetImage($file_name = $SQL[0]->imageurl,$path=config('global.file_path.user_profile'));
      return json_encode($SQL[0]);
    }

    public function update_user_data(Request $request)
    {
        $userData = $request->all();
        $imageurl = '';
        if($request->image64 != "")
        {   
            $imageurl = $this->UploadImageBase64($file = $request->image64,$path = config('global.file_path.user_profile'));
        }
        else{
            $imageurl =$request->profileImage;
        }
        $userData['imageurl'] = $imageurl;
        $userData['location'] = $userData['address'];
        $userData['latitude'] = $userData['latitude'];
        $userData['longitude'] = $userData['longitude'];

        $random_latlong = $this->RandomLatLong($userData['latitude'],$userData['longitude']);
        $userData['random_latitude'] = $random_latlong['random_latitude'];
        $userData['random_longitude'] = $random_latlong['random_longitude'];

        $user = User::find($userData['id']);
        $user->fill($userData);
        $user->save();
        return Response::json(['result' => true,'message'=>__('messages.admin.user.edit_user_success')]);
    }
    public function user_data_edit($id)
    {       
        $UserData=User::where('id',$id)->first();
        $UserData->imageurl = $this->GetImage($file_name = $UserData->imageurl,$path=config('global.file_path.user_profile'));

        // echo "<pre>";
        // print_r($data); die;
        $master_data['state'] = State::orderBy('state_name')->where('state_status',0)->get();
        $master_data['district'] = District::orderBy('district_name')->where('district_status',0)->get();
        $master_data['taluka'] = Talukas::orderBy('taluka_name')->where('taluka_status',0)->get();
        $master_data['pincode'] = Pincode::orderBy('pincode')->where('pincode_status',0)->get();
        return view('admin.user.edit',compact('UserData','master_data'));
    
        // return view('admin.user.edit')->with(['UserData' => $data]);
    }
        
    public function add_user(Request $request,$id='')
    {       
        // if($id>0){
        //     $arr=User::where(['id'=>$id])->get();
        //     $result['name'] = $arr['0']->name;
        //     $result['email'] = $arr['0']->email;
        //     $result['password'] = $arr['0']->password;
        //     $result['phone'] = $arr['0']->phone;
        //     $result['imageurl'] = $arr['0']->imageurl;            
        //     $result['user_category'] = $arr['0']->user_category;
        //     $result['gender'] = $arr['0']->gender;
        //     $result['area_of_location'] = $arr['0']->area_of_location;
        //     $result['flat_no'] = $arr['0']->flat_no;
        //     $result['address'] = $arr['0']->address;
        //     $result['aadhar_number'] = $arr['0']->aadhar_number;            
        //     $result['id'] = $arr['0']->id;            
        //     $result['header_title'] = 'Edit';

        // }else{
        //     $result['name'] = '';
        //     $result['email'] = '';            
        //     $result['password'] = '';
        //     $result['phone'] = '';
        //     $result['imageurl'] = '';
        //     $result['user_category'] = '';
        //     $result['gender'] = '';
        //     $result['area_of_location'] = '';
        //     $result['flat_no'] = '';
        //     $result['address'] = '';
        //     $result['aadhar_number'] = '';
        //     $result['id'] = 0;
        //     $result['header_title'] = 'Add';
        // }

        // echo "<pre>";
        // print_r($result);
        // echo "</pre>";die;
        $data['state'] = State::orderBy('state_name')->where('state_status',0)->get();
        return view('admin.user.adduser')->with(['master_data' => $data]);

        // return view('admin.user.adduser',$result);
        
    }

    public function saveuser(Request $request)
    {
        $userData = $request->all();
        $message="";
        $imageurl = '';
        if($userData['id'] !=''){
            $user=User::where(['id'=>$userData['id']])->first();
            $rules = [
                'email' => 'unique:users,email,'.$userData['id'].',id',
                'phone' => 'unique:users,phone,'.$userData['id'].',id',
            ];
            
            // 'email' => 'required|string|email|max:255|unique:users,email,'.$user->id
            $messages = [
                'email.unique'    => 'User already exist with this email. Try another.',
                'phone.unique'     => 'User already exist with this Phone no. Try another.',
        
            ];
            $validator = Validator::make($userData, $rules,$messages);       

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
                $userData['imageurl'] = $imageurl;
                if($request->password !=''){
                    $userData['password'] = Hash::make($request->password);
                }
                else{
                    $userData['password'] = $user->password;
                }
                $user = User::find($userData['id']);
                $user->fill($userData);
                $user->save();
                $message="User Data Updated Successfully";
            }

        }else{
            $rules = array('email' => 'unique:users,email','phone' => 'unique:users,phone');
            $messages = [
                'email.unique'    => 'User already exist with this email. Try another.',
                'phone.unique'     => 'User already exist with this Phone no. Try another.',
        
            ];
            $validator = Validator::make($userData, $rules,$messages);

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
                    $imageurl =$request->image64;
                }
                $userData['imageurl'] = $imageurl;
                $userData['login_type'] = 2;
                // echo "<pre>";
                // print_r($userData);die;
                $userData['password'] = Hash::make($request->password);
                $user = User::create($userData);
                $token = $user->createToken(env('APP_NAME'));
                $user->token = $token->accessToken;
                $oauth_access_token_id = $token->token->id;
                $user_auth_id = $this->GenerateUniqueRandomString($table='user_auth_master', $column="user_auth_id", $chars=32);
                $auth_input = array(
                    'user_auth_id'      => $user_auth_id,
                    'user_id'           => $user->id,
                    'oauth_access_token_id' => $oauth_access_token_id,
                    'device_type'  => 3,
                    'device_token' => 'webTestToken',
                );
                $user_auth_token = UserAuthMaster::create($auth_input);
                $message="User Insert Successfully";
            }
        } 

        Session::flash('message', $message);      
        return redirect('admin/user');

    }

    public function user_status(Request $request)
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
    
    public function user_verified(Request $request)
    {
        // echo $request->is_disable;die;
        $user_id  = $request->id;
        User::where('id',$user_id )->update(['is_verified' => $request->is_verified]);

        if($request->is_verified == 1)
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

    public function userfileexport() 
    {
        return Excel::download(new UserDataExport, 'user-data-collection.xlsx');
    } 

    public function user_multi_status(Request $request)
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
