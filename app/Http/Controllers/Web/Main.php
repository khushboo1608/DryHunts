<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Models\District;
use App\Models\State;
use App\Models\Talukas;
use App\Models\Pincode;
use Flash;
use Storage;
use App\Models\Settings;
use App\Models\User;
use App\Models\UserAuthMaster;
use App\Models\Category;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\Banner;

class Main extends Controller
{
    // public function __construct() 
    // {
    //     $this->middleware('guest');
    // }
    public function index()
    { 
        // echo 'in'; exit();
        // return view('auth.register');
        // return view('web.index');           

        $data['category'] = Category::orderBy('created_at','desc')->where('category_status',0)->get();
        $data['service'] = Service::where('is_popular',1)->where('service_status',0)->orderBy('created_at','desc')->get();
        $data['testimonial'] = Testimonial::where('testimonial_status',0)->orderBy('created_at','desc')->get();
        $data['banner'] = Banner::orderBy('banner_name')->where('banner_status',0)->get();
        return view('web.index')->with(['master_data' => $data]);
    }
    
    public function test()
    {
        echo "test";exit();
    }
    public function userlogin()
    { 
        // echo 'in'; exit();
        // return view('auth.register');
        return view('auth.login');     
    }
    public function userregister()
    { 
        // echo 'in'; exit();
        // return view('auth.register');
        $data['state'] = State::orderBy('state_name')->where('state_status',0)->get();
        return view('auth.register')->with(['master_data' => $data]); 
          
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

    public function servicelist($categoryId)
    { 
        // echo "<pre>";
        // print_r($categoryId);die;
        // echo 'in'; exit();

        $data['service'] = Service::where('category_id',$categoryId)->where('service_status',0)->orderBy('created_at','desc')->get();
        return view('web.servicelist')->with(['master_data' => $data]);
    }

    public function servicedetails($serviceId)
    { 
        $serviceData= Service::where('service_id',$serviceId)->where('service_status',0)->orderBy('created_at','desc')->first();
        return view('web.servicedetails')->with(['serviceData' => $serviceData]);
    }

    public function testimonialList()
    { 
        $data_testimonial = Testimonial::where('testimonial_status',0)->get();
        $data['testimonial'] = $this->GetTestimonialListData($data_testimonial);

        $data['state'] = State::orderBy('state_name')->where('state_status',0)->get();
        $data['district'] = District::orderBy('district_name')->where('district_status',0)->get();
        $data['taluka'] = Talukas::orderBy('taluka_name')->where('taluka_status',0)->get();
        $data['pincode'] = Pincode::orderBy('pincode')->where('pincode_status',0)->get();
        $data['category'] = Category::orderBy('category_name')->where('category_status',0)->get();
        // return view('admin.testimonial.addtestimonial')->with(['master_data' => $data]);

        return view('web.testimonialList')->with(['master_data' => $data]);
    }

    public function testimonialDetails($testimonialId)
    { 
        $testimonial= Testimonial::where('testimonial_id',$testimonialId)->where('testimonial_status',0)->orderBy('created_at','desc')->first();
        return view('web.testimonialdetails')->with(['testimonial' => $testimonial]);
    }
    public function getOptions(Request $request)
    {
        $selectedValue = $request->input('selectedValue');
        $options  =District::where('state_id', $selectedValue)->where(['district_status'=>0])->pluck('district_name', 'district_id');
        return response()->json($options);
    }
    public function getTalukaOptions(Request $request)
    {
        $selectedValue1 = $request->input('selectedValue1');
        $options  =Talukas::where('district_id', $selectedValue1)->where(['taluka_status'=>0])->pluck('taluka_name', 'taluka_id');
        return response()->json($options);
    }

    public function getPincodeOptions(Request $request)
    {
        $selectedValue2 = $request->input('selectedValue2');
        $options  =Pincode::where('taluka_id', $selectedValue2)->where(['pincode_status'=>0])->pluck('pincode', 'pincode_id');
        return response()->json($options);
    }
    
    public function getServiceOptions(Request $request)
    {
        $selectedValue3 = $request->input('selectedValue3');
        $options  =Service::where('category_id', $selectedValue3)->where(['service_status'=>0])->pluck('service_name', 'service_id');
        return response()->json($options);
    }

    
    public function filterproductdata(Request $request)
    { 
        // echo "<pre>";
        // print_r($request->all());die;
        $input = $request->all();    
          
        $query = Testimonial::query();
        
            if ($input['category_id']) {
                $query->where('category_id', $input['category_id']);
                
            }
            if ($input['service_id']) {
                $query->where('service_id', $input['service_id']);
            }
            $data_testimonial = $query->where('testimonial_status',0)->get();
             // $data_testimonial = $query->where('testimonial_status',0)->get();
        $data['testimonial'] = $this->GetTestimonialListData($data_testimonial);

        // $data_testimonial = Testimonial::where('testimonial_status',0)->get();
        // $data['testimonial'] = $this->GetTestimonialListData($data_testimonial);

        $data['state'] = State::orderBy('state_name')->where('state_status',0)->get();
        $data['district'] = District::orderBy('district_name')->where('district_status',0)->get();
        $data['taluka'] = Talukas::orderBy('taluka_name')->where('taluka_status',0)->get();
        $data['pincode'] = Pincode::orderBy('pincode')->where('pincode_status',0)->get();
        $data['category'] = Category::orderBy('category_name')->where('category_status',0)->get();
        // return view('admin.testimonial.addtestimonial')->with(['master_data' => $data]);

        return view('web.testimonialList')->with(['master_data' => $data]);
    }
    
    
    public function filterregiondata(Request $request)
    { 
        // echo "<pre>";
        // print_r($request->all());die;
        $input = $request->all();    
          
        $query = Testimonial::query();

        
        if ( $input['state_id']) {
            $query->where('state_id', $input['state_id']);                    
        }

        if ($input['district_id']) {
            $query->where('district_id', $input['district_id']);
        }
        if ($input['taluka_id']) {
            $query->where('taluka_id', $input['taluka_id']);
        }
        if ($input['pincode_id']) {
            $query->where('pincode_id', $input['pincode_id']);
        }
            $data_testimonial = $query->where('testimonial_status',0)->get();
             // $data_testimonial = $query->where('testimonial_status',0)->get();
        $data['testimonial'] = $this->GetTestimonialListData($data_testimonial);

        // $data_testimonial = Testimonial::where('testimonial_status',0)->get();
        // $data['testimonial'] = $this->GetTestimonialListData($data_testimonial);

        $data['state'] = State::orderBy('state_name')->where('state_status',0)->get();
        $data['district'] = District::orderBy('district_name')->where('district_status',0)->get();
        $data['taluka'] = Talukas::orderBy('taluka_name')->where('taluka_status',0)->get();
        $data['pincode'] = Pincode::orderBy('pincode')->where('pincode_status',0)->get();
        $data['category'] = Category::orderBy('category_name')->where('category_status',0)->get();
        // return view('admin.testimonial.addtestimonial')->with(['master_data' => $data]);

        return view('web.testimonialList')->with(['master_data' => $data]);
    }

    
    public function servicesearch(Request $request)
    { 
        // echo "<pre>";
        // print_r($request->all());die;
        $query = $request->input('query');

        $results['service'] = Service::where('service_name', 'LIKE', '%' . $query . '%')->where('service_status',0)->orderBy('created_at','desc')->get();

        // echo "<pre>";
        // print_r($results);die;
        return view('web.servicelist')->with(['master_data' => $results]);
    }
    

    public function aboutus()
    { 

        $SettingsData= Settings::first();
        return view('web.aboutus')->with(['SettingsData' => $SettingsData]);
    }

    public function privacypolicy()
    { 

        $SettingsData= Settings::first();
        return view('web.privacypolicy')->with(['SettingsData' => $SettingsData]);
    }
    public function contactus()
    { 

        // $SettingsData= Settings::first();
        // return view('web.contactus')->with(['SettingsData' => $SettingsData]);

        return view('web.contactus');
    }

    
    
    
    
}