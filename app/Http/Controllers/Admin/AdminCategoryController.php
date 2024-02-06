<?php

namespace App\Http\Controllers\Admin;
use App\DataTables\CategoryDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use App\Exports\CategoryExport;
use Maatwebsite\Excel\Facades\Excel;
use File;

class AdminCategoryController extends Controller
{
    public function __construct(CategoryDataTable $dataTable)
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
                return '<input type="checkbox" id="checkbox'.$data->category_id.'"  value="'.$data->category_id.'"  name="category_ids[]" class="category_ids" />';
            })
            ->editColumn('imageurl', function ($data) {
                $imageurl = $this->GetImage($file_name = $data->category_image,$path=config('global.file_path.category_image'));
                
                if($imageurl == '')
                {
                    $imageurl = config('global.no_image.no_image');
                }
                return $imageurl;
            })
            ->addColumn('category_status', function ($data) {
                $btn1='';
                $checked = ($data['category_status'] == 1) ? "" : "checked";
                $title =  ($data['category_status'] == 1) ? "Disable" : "Enable";
                if($data['category_status'] == 1){
                    $btn1 = '<button type="button"  class="btn btn-danger btn-sm" onclick="Status(\''.$data->category_id  .'\','.$data->category_status.')">'.$title.' </i>
                    </button>';
                }
                else{
                    $btn1 = '<button type="button"  class="btn btn-success btn-sm" onclick="Status(\''.$data->category_id  .'\','.$data->category_status.')" >'.$title.' </i>
                    </button>';  
                }               
                return $btn1;
            })
            ->addColumn('action', function($data){

                $url=route("admin.category");
                $btn = '<a href="'.$url.'/edit/'.$data->category_id  .'" style="color: white !important" ><button type="button" class="edit btn btn-primary btn-sm editPost"  title="edit"><i class="fa fa-edit"></i>
                </button></a>&nbsp;&nbsp;<button type="button"  class="btn btn-danger btn-sm deletePost" onclick="DeleteCategory(\''.$data->category_id  .'\')" title="edit"><i class="fa fa-trash"></i>
                </button>';

                 return $btn;
         })
            ->rawColumns(['action','category_status','checkbox'])
            ->make(true);
        }
        return view('admin.category.index');
    }
    
    public function add_category(Request $request)
    {
        return view('admin.category.addcategory');
    }

    public function savecategory(Request $request)
    {

        // echo "<pre>";
        // print_r($request->all());die;
        $categoryData = $request->all();
        $message="";
        $imageurl = '';
        if($categoryData['id'] !=''){
            $Category=Category::where(['category_id'=>$categoryData['id']])->first();
            if($request->imageurl != "")
            {   
                $imageurl = $this->UploadImage($file = $request->imageurl,$path = config('global.file_path.category_image'));
            }
            else{
                $imageurl =$Category->category_image;
            }
            $categoryData['category_image'] = $imageurl;
            $category = Category::find($categoryData['id']);
            $category->fill($categoryData);
            $category->save();
            $message="Data Updated Successfully";

        }else{
            
            if($request->imageurl != "")
            {   
                $imageurl = $this->UploadImage($file = $request->imageurl,$path = config('global.file_path.category_image'));
            }
            else{
                $imageurl =$request->imageurl;
            }
            $categoryData['category_image'] = $imageurl;
            $category_id = $this->GenerateUniqueRandomString($table='categories', $column="category_id", $chars=32);
                $categoryData['category_id'] = $category_id;
            Category::create($categoryData);
            $message="Data Insert Successfully";
        } 

        Session::flash('message', $message);      
        return redirect('admin/category');

    }
    public function category_status(Request $request)
    {
        // echo $request->is_disable;die;
        $category_id  = $request->id;
        Category::where('category_id',$category_id )->update(['category_status' => $request->is_disable]);

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
    

    public function category_delete(Request $request)
    {
        $category_id  = $request->id;
        Category::where('category_id',$category_id )->delete();
        return Response::json(['result' => true,'message'=> ' Category deleted..!']);

    }
    public function categoryfileExport () 
    {
        return Excel::download(new CategoryExport, 'category-collection.xlsx');
    } 
    
    public function category_multi_status(Request $request)
    {
        $action=$request->action;

			if(!empty($request->id)) {
                $ids=$request->id;
			}
			if($action=='enable'){				
                Category::whereIn('category_id',$ids )->update(['category_status' => 0]);
                $msg = __('Enable successfully');
                $text = "Enabled";

			}else if($action=='disable'){

			    Category::whereIn('category_id',$ids )->update(['category_status' => 1]);
                $msg = __('Disable successfully');
                $text = "Disable";
				
			}else if($action=='delete'){
				
				Category::whereIn('category_id',$ids )->delete();
                $msg = __('Deleted successfully');
                $text = "Deleted";
			}
        return Response::json(['result' => true,'message'=>$msg,'text' =>$text]);
    }

    public function category_data_edit($id)
    {       
        $categoryData=Category::where('category_id',$id)->first();
        $categoryData->imageurl = $this->GetImage($file_name = $categoryData->category_image,$path=config('global.file_path.category_image'));
        return view('admin.category.edit',compact('categoryData'));
        // return view('admin.category.edit')->with(['categoryData' => $data]);
    }
}
