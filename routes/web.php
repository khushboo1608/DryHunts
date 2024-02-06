<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\AdminHomeController; 
use App\Http\Controllers\Admin\AdminUserController; 
use App\Http\Controllers\Admin\AdminServiceController; 
use App\Http\Controllers\Admin\AdminSubCategoryController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\Admin\AdminBannerController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminStateController;
use App\Http\Controllers\Admin\AdminDistrictController;
use App\Http\Controllers\Admin\AdminTalukaController;
use App\Http\Controllers\Admin\AdminPincodeController;
use App\Http\Controllers\Admin\AdminTestimonialController;
use App\Http\Controllers\Admin\SubAdminController;
use App\Http\Controllers\Admin\AdminGallaryController;
use App\Http\Controllers\Web\Main;
use App\Http\Controllers\Web\WebHomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/',     [Main::class, 'index'])->name('home');
// Route::get('/test', [Main::class, 'test'])->name('test');
Route::get('/userlogin',     [Main::class, 'userlogin'])->name('userlogin');
// Route::get('/userregister',     [Main::class, 'userregister'])->name('userregister');

Route::get('/get-dropdown-options',[Main::class,'getDropdownOptions']);
    Route::get('/get-dropdown-taluka-options',[Main::class,'getDropdownTalukaOptions']);
    Route::get('/get-dropdown-pincode-options',[Main::class,'getDropdownPincodeOptions']);
    Route::get('/get-dropdown-service-options',[Main::class,'getDropdownServiceOptions']);

    Route::get('/servicesearch', [Main::class, 'servicesearch'])->name('servicesearch');
    Route::get('/servicelist/{id}',[Main::class,'servicelist']);
    Route::get('/servicedetails/{id}',[Main::class,'servicedetails']);
    Route::get('/testimonialList',[Main::class,'testimonialList']);
    Route::get('/testimonialDetails/{id}',[Main::class,'testimonialDetails']);

    Route::get('testimonialList/get-options',[Main::class,'getOptions']);
    Route::get('testimonialList/get-taluka-options',[Main::class,'getTalukaOptions']);
    Route::get('testimonialList/get-pincode-options',[Main::class,'getPincodeOptions']);
    Route::get('testimonialList/get-service-options',[Main::class,'getServiceOptions']);
    Route::post('testimonialList/filterproductdata',[Main::class,'filterproductdata']);
    Route::post('testimonialList/filterregiondata',[Main::class,'filterregiondata']);

    Route::get('aboutus',[Main::class,'aboutus']);
    Route::get('privacypolicy',[Main::class,'privacypolicy']);
    Route::get('contactus',[Main::class,'contactus']);
   
    // Route::get('/thankyou',[Main::class,'thankyou']);
Route::middleware('auth','preventBackHistoryWeb')->group( function () {
    // event  
    Route::get('/webhome',     [WebHomeController::class, 'index'])->name('webhome');
    Route::get('/userProfile',     [WebHomeController::class, 'userProfile'])->name('userProfile');
    
    Route::post('/saveProfile',     [WebHomeController::class, 'saveProfile'])->name('saveProfile');
    // Route::get('/servicelist/{id}',[WebHomeController::class,'servicelist']);
    // Route::get('/servicedetails/{id}',[WebHomeController::class,'servicedetails']);
    Route::get('/thankyou',[WebHomeController::class,'thankyou']);
    Route::get('/cart',     [WebHomeController::class, 'cart'])->name('cart');
    Route::post('/addtocart',[WebHomeController::class,'addtocart']);
    Route::post('/addorder',[WebHomeController::class,'addorder']); 
    Route::get('/orderthankyou',[WebHomeController::class,'orderthankyou']); 
    Route::get('/myorder',[WebHomeController::class,'myorder']);   
    Route::get('/orderdetails/{id}',[WebHomeController::class,'orderdetails']);     
    Route::post('/deletecart',[WebHomeController::class,'deletecart']);
   
    // Route::get('/testimonialList',[WebHomeController::class,'testimonialList']);
    Route::post('/ordercancle',[WebHomeController::class,'ordercancle']);
    Route::post('/updatequantity',[WebHomeController::class,'updatequantity']);
     
});

Route::group(['prefix' => 'admin'], function () {

    Route::middleware('is_admin')->group( function () { 
        // admin Route
        Route::get('/home',                       [AdminHomeController::class, 'index'])->name('admin.home');
        
        // district admin
        // Route::get('/districthome',                       [AdminHomeController::class, 'districtindex'])->name('admin.districthome');

        //profile
        Route::get('/profile',                      [AdminHomeController::class, 'profile'])->name('admin.profile');
        Route::post('/update_profile',              [AdminHomeController::class, 'update_profile'])->name('admin.update-profile');
        Route::post('/check_old_password',          [AdminHomeController::class, 'check_old_password'])->name('admin.check-old-password');
        Route::post('/change_password',             [AdminHomeController::class, 'change_password'])->name('admin.change-password');
        
        //User
        Route::get('/user',                       [AdminUserController::class, 'index'])->name('admin.user');
        Route::get('/add_user',    [AdminUserController::class,'add_user']);
        Route::post('user/saveuser',   [AdminUserController::class,'saveuser'])->name('user.saveuser');
        Route::post('/user_delete',    [AdminUserController::class, 'user_delete'])->name('admin.delete-user');
        Route::post('/user_status',  [AdminUserController::class, 'user_status'])->name('admin.user_status');
        Route::post('/user_verified',  [AdminUserController::class, 'user_verified'])->name('admin.user_verified');
        

        Route::post('/user_multi_status', [AdminUserController::class, 'user_multi_status'])->name('admin.user_multi_status');

        Route::post('/user_details',              [AdminUserController::class, 'user_details'])->name('admin.user-details');
        Route::get('user/userdatadetails/{id}',   [AdminUserController::class, 'user_data_details'])->name('userdatadetails');  
        Route::get('user/edit/{id}',   [AdminUserController::class, 'user_data_edit'])->name('userdataedit');
        Route::get('userfile-export',   [AdminUserController::class, 'userfileexport'])->name('userfile-export');        
       
       //Service
       Route::get('/service',    [AdminServiceController::class, 'index'])->name('admin.service');        
       Route::get('/add_service', [AdminServiceController::class,'add_service']);
       Route::post('service/saveservice',   [AdminServiceController::class,'saveservice'])->name('service.saveservice');
       Route::post('/service_delete', [AdminServiceController::class, 'service_delete'])->name('admin.service_delete');
      
       Route::post('/service_status',   [AdminServiceController::class, 'service_status'])->name('admin.service_status');
       Route::post('/service_featured', [AdminServiceController::class, 'service_featured'])->name('admin.service_featured');
       Route::get('service/edit/{id}',   [AdminServiceController::class, 'service_data_edit'])->name('service_data_edit');
       Route::get('servicefile-export', [AdminServiceController::class, 'servicefileExport'])->name('servicefile-export');       
       Route::post('/service_multi_status', [AdminServiceController::class, 'service_multi_status'])->name('admin.service_multi_status');
    //    Route::get('service/get-dropdown-options',[AdminServiceController::class,'getDropdownOptions']);
       Route::get('service/delete_img/{id}/{img_id}',   [AdminServiceController::class, 'delete_img'])->name('delete_img');
       Route::get('service/delete_variation/{id}',   [AdminServiceController::class, 'delete_variation'])->name('delete_variation');
  
       // Category
       Route::get('/category',   [AdminCategoryController::class, 'index'])->name('admin.category');  
       Route::get('/add_category',[AdminCategoryController::class,'add_category']);
       Route::post('category/savecategory',[AdminCategoryController::class,'savecategory'])->name('category.savecategory');        
       Route::post('/category_status',   [AdminCategoryController::class, 'category_status'])->name('admin.category_status');
       
       Route::post('/category_delete', [AdminCategoryController::class, 'category_delete'])->name('admin.category_delete');
       Route::get('categoryfile-export', [AdminCategoryController::class, 'categoryfileExport'])->name('categoryfile-export');       
       Route::post('/category_multi_status', [AdminCategoryController::class, 'category_multi_status'])->name('admin.category_multi_status');
       Route::get('category/edit/{id}',   [AdminCategoryController::class, 'category_data_edit'])->name('category_data_edit');
   

       //Settings
       Route::get('/setting',   [AdminSettingController::class, 'index'])->name('admin.setting');
       Route::post('setting/savepagesetting',[AdminSettingController::class,'SavePageSetting'])->name('setting.savepagesetting');
       Route::get('/generalsetting',      [AdminSettingController::class, 'GeneralSetting'])->name('admin.generalsetting');
       Route::post('setting/savegeneral',[AdminSettingController::class,'SaveGeneral'])->name('setting.savegeneral');

        // Banner
        Route::get('/banner',   [AdminBannerController::class, 'index'])->name('admin.banner');  
        Route::get('/add_banner',[AdminBannerController::class,'add_banner']);
        Route::post('banner/savebanner',[AdminBannerController::class,'savebanner'])->name('banner.savebanner');        
        Route::post('/banner_status',   [AdminBannerController::class, 'banner_status'])->name('admin.banner_status');

        Route::post('/banner_delete', [AdminBannerController::class, 'banner_delete'])->name('admin.banner_delete');
        Route::get('bannerfile-export', [AdminBannerController::class, 'bannerfileExport'])->name('bannerfile-export');       
        Route::post('/banner_multi_status', [AdminBannerController::class, 'banner_multi_status'])->name('admin.banner_multi_status');
        Route::get('banner/edit/{id}',   [AdminBannerController::class, 'banner_data_edit'])->name('banner_data_edit');

        // Order
        Route::get('/order',   [AdminOrderController::class, 'index'])->name('admin.order');  
        Route::get('/add_order',[AdminOrderController::class,'add_order']);
        Route::post('order/saveorder',[AdminOrderController::class,'saveorder'])->name('order.saveorder');        
        Route::post('/order_status',   [AdminOrderController::class, 'order_status'])->name('admin.order_status');

        Route::post('/order_delete', [AdminOrderController::class, 'order_delete'])->name('admin.order_delete');
        Route::get('orderfile-export', [AdminOrderController::class, 'orderfileExport'])->name('orderfile-export');       
        Route::post('/order_multi_status', [AdminOrderController::class, 'order_multi_status'])->name('admin.order_multi_status');
        Route::get('order/edit/{id}',   [AdminOrderController::class, 'order_data_edit'])->name('order_data_edit');

         // State
         Route::get('/state',   [AdminStateController::class, 'index'])->name('admin.state');  
         Route::get('/add_state',[AdminStateController::class,'add_state']);
         Route::post('state/savestate',[AdminStateController::class,'savestate'])->name('state.savestate');        
         Route::post('/state_status',   [AdminStateController::class, 'state_status'])->name('admin.state_status');
 
         Route::post('/state_delete', [AdminStateController::class, 'state_delete'])->name('admin.state_delete');
         Route::get('statefile-export', [AdminStateController::class, 'statefileExport'])->name('statefile-export');       
         Route::post('/state_multi_status', [AdminStateController::class, 'state_multi_status'])->name('admin.state_multi_status');
         Route::get('state/edit/{id}',   [AdminStateController::class, 'state_data_edit'])->name('state_data_edit');
 

         
         // District
         Route::get('/district',   [AdminDistrictController::class, 'index'])->name('admin.district');  
         Route::get('/add_district',[AdminDistrictController::class,'add_district']);
         Route::post('district/savedistrict',[AdminDistrictController::class,'savedistrict'])->name('district.savedistrict');        
         Route::post('/district_status',   [AdminDistrictController::class, 'district_status'])->name('admin.district_status');
 
         Route::post('/district_delete', [AdminDistrictController::class, 'district_delete'])->name('admin.district_delete');
         Route::get('districtfile-export', [AdminDistrictController::class, 'districtfileExport'])->name('districtfile-export');       
         Route::post('/district_multi_status', [AdminDistrictController::class, 'district_multi_status'])->name('admin.district_multi_status');
         Route::get('district/edit/{id}',   [AdminDistrictController::class, 'district_data_edit'])->name('district_data_edit');

   

          // Taluka
          Route::get('/taluka',   [AdminTalukaController::class, 'index'])->name('admin.taluka');  
          Route::get('/add_taluka',[AdminTalukaController::class,'add_taluka']);
          Route::post('taluka/savetaluka',[AdminTalukaController::class,'savetaluka'])->name('taluka.savetaluka');        
          Route::post('/taluka_status',   [AdminTalukaController::class, 'taluka_status'])->name('admin.taluka_status');
  
          Route::post('/taluka_delete', [AdminTalukaController::class, 'taluka_delete'])->name('admin.taluka_delete');
          Route::get('talukafile-export', [AdminTalukaController::class, 'talukafileExport'])->name('talukafile-export');       
          Route::post('/taluka_multi_status', [AdminTalukaController::class, 'taluka_multi_status'])->name('admin.taluka_multi_status');
          Route::get('taluka/edit/{id}',   [AdminTalukaController::class, 'taluka_data_edit'])->name('taluka_data_edit');
          Route::get('taluka/get-dropdown-options',[AdminTalukaController::class,'getDropdownOptions']);
 
        // Pincode

          Route::get('/pincode',   [AdminPincodeController::class, 'index'])->name('admin.pincode');  
          Route::get('/add_pincode',[AdminPincodeController::class,'add_pincode']);
          Route::post('pincode/savepincode',[AdminPincodeController::class,'savepincode'])->name('pincode.savepincode');        
          Route::post('/pincode_status',   [AdminPincodeController::class, 'pincode_status'])->name('admin.pincode_status');
  
          Route::post('/pincode_delete', [AdminPincodeController::class, 'pincode_delete'])->name('admin.pincode_delete');
          Route::get('pincodefile-export', [AdminPincodeController::class, 'pincodefileExport'])->name('pincodefile-export');       
          Route::post('/pincode_multi_status', [AdminPincodeController::class, 'pincode_multi_status'])->name('admin.pincode_multi_status');
          Route::get('pincode/edit/{id}',   [AdminPincodeController::class, 'pincode_data_edit'])->name('pincode_data_edit');
          Route::get('pincode/get-dropdown-options',[AdminPincodeController::class,'getDropdownOptions']);
          Route::get('pincode/get-dropdown-taluka-options',[AdminPincodeController::class,'getDropdownTalukaOptions']);
       
        // Testimonial
        Route::get('/testimonial',   [AdminTestimonialController::class, 'index'])->name('admin.testimonial');  
          Route::get('/add_testimonial',[AdminTestimonialController::class,'add_testimonial']);
          Route::post('testimonial/savetestimonial',[AdminTestimonialController::class,'savetestimonial'])->name('testimonial.savetestimonial');        
          Route::post('/testimonial_status',   [AdminTestimonialController::class, 'testimonial_status'])->name('admin.testimonial_status');
  
          Route::post('/testimonial_delete', [AdminTestimonialController::class, 'testimonial_delete'])->name('admin.testimonial_delete');
          Route::get('testimonialfile-export', [AdminTestimonialController::class, 'testimonialfileExport'])->name('testimonialfile-export');       
          Route::post('/testimonial_multi_status', [AdminTestimonialController::class, 'testimonial_multi_status'])->name('admin.testimonial_multi_status');
          Route::get('testimonial/edit/{id}',   [AdminTestimonialController::class, 'testimonial_data_edit'])->name('testimonial_data_edit');
          Route::get('testimonial/get-dropdown-options',[AdminTestimonialController::class,'getDropdownOptions']);
          Route::get('testimonial/get-dropdown-taluka-options',[AdminTestimonialController::class,'getDropdownTalukaOptions']);
          Route::get('testimonial/get-dropdown-pincode-options',[AdminTestimonialController::class,'getDropdownPincodeOptions']);
          Route::get('testimonial/get-dropdown-service-options',[AdminTestimonialController::class,'getDropdownServiceOptions']);

          
          //Subadmin
	        Route::get('/subadmin',   [SubAdminController::class, 'index'])->name('admin.subadmin');
          Route::get('/add_subadmin',    [SubAdminController::class,'add_subadmin']);
          Route::post('subadmin/savesubadmin',   [SubAdminController::class,'savesubadmin'])->name('subadmin.savesubadmin');
          Route::post('/subadmin_delete',    [SubAdminController::class, 'subadmin_delete'])->name('admin.delete-subadmin');
          Route::post('/subadmin_status',  [SubAdminController::class, 'subadmin_status'])->name('admin.subadmin_status');
          
          Route::post('/subadmin_multi_status', [SubAdminController::class, 'subadmin_multi_status'])->name('admin.subadmin_multi_status');
  
          Route::post('/subadmin_details',   [SubAdminController::class, 'subadmin_details'])->name('admin.subadmin-details');
          Route::get('subadmin/subadmindatadetails/{id}',   [SubAdminController::class, 'subadmin_data_details'])->name('subadmindatadetails');  
          Route::get('subadmin/edit/{id}',   [SubAdminController::class, 'subadmin_data_edit'])->name('subadmindataedit');
          Route::get('subadminfile-export',   [SubAdminController::class, 'subadminfileexport'])->name('subadminfile-export');  
          
            //  Gallary
        Route::get('/gallary',   [AdminGallaryController::class, 'index'])->name('admin.gallary');  
        Route::get('/add_gallary',[AdminGallaryController::class,'add_gallary']);
        Route::post('gallary/savegallary',[AdminGallaryController::class,'savegallary'])->name('gallary.savegallary');        
        Route::post('/gallary_status',   [AdminGallaryController::class, 'gallary_status'])->name('admin.gallary_status');

        Route::post('/gallary_delete', [AdminGallaryController::class, 'gallary_delete'])->name('admin.gallary_delete');
        Route::get('gallaryfile-export', [AdminGallaryController::class, 'gallaryfileExport'])->name('gallaryfile-export');       
        Route::post('/gallary_multi_status', [AdminGallaryController::class, 'gallary_multi_status'])->name('admin.gallary_multi_status');
        Route::get('gallary/edit/{id}',   [AdminGallaryController::class, 'gallary_data_edit'])->name('gallary_data_edit');
       
    });
});