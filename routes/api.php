<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserAPIController; 
use App\Http\Controllers\Api\DashboardAPIController; 
use App\Http\Controllers\Api\SettingAPIController;
use App\Http\Controllers\Api\CategoryAPIController;
use App\Http\Controllers\Api\ServiceAPIController;
use App\Http\Controllers\Api\CartAPIController;
use App\Http\Controllers\Api\BannerAPIController;
use App\Http\Controllers\Api\OrderAPIController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('Registration',     [UserAPIController::class, 'Registration']);
Route::post('Login',            [UserAPIController::class, 'Login']);
// Route::post('ForgotPassword',   [UserAPIController::class,'ForgotPassword']);
Route::get('TestNotification',  [NotificationAPIController::class,'TestNotification']);
Route::get('TestFunction',      [NotificationAPIController::class,'TestFunction']);

//forgot password
Route::post('ForgotPassword',   [UserAPIController::class,'ForgotPassword']);
Route::get('reset-password/{token}',            [UserAPIController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password',                   [UserAPIController::class, 'submitResetPasswordForm'])->name('reset.password.post');

//ChangePassword
Route::post('ChangePassword',   [UserAPIController::class,'ChangePassword']);

 //Settings
 Route::get('SettingList',     [SettingAPIController::class,'SettingList']); 

//BannerList
Route::get('BannerList',     [BannerAPIController::class,'BannerList']);

//StateList
Route::get('StateList',     [SettingAPIController::class,'StateList']);

//District
Route::post('DistrictList',     [SettingAPIController::class,'DistrictList']);

//Taluka
Route::post('TalukaList',     [SettingAPIController::class,'TalukaList']);

//Pincode
Route::post('PincodeList',     [SettingAPIController::class,'PincodeList']);

//Testimonial
Route::get('TestimonialList',     [SettingAPIController::class,'TestimonialList']);
Route::post('TestimonialFilter',  [SettingAPIController::class,'TestimonialFilter']);

Route::middleware('auth:api')->group( function () {
    // user
    Route::post('VerifyOtp',     [UserAPIController::class,'VerifyOtp']);
    Route::post('ProfileSetup',     [UserAPIController::class,'ProfileSetup']);
    Route::get('GetUserProfile',   [UserAPIController::class,'GetUserProfile']);
    Route::post('ProfileUpdate',   [UserAPIController::class,'ProfileUpdate']);
    
    Route::post('ChangePassword',   [UserAPIController::class,'ChangePassword']);
    Route::get('Logout',            [UserAPIController::class,'Logout']);
    Route::post('NearByUsers',      [UserAPIController::class,'NearByUsers']);
    Route::post('UpdateDeviceToken',[UserAPIController::class,'UpdateDeviceToken']);
    Route::post('NearByActivity',      [UserAPIController::class,'NearByActivity']);
    
    //Category
    Route::post('CategoryList',     [CategoryAPIController::class,'CategoryList']); 

    //Service
    Route::post('ServiceList',     [ServiceAPIController::class,'ServiceList']); 
    Route::post('ServiceSingleDetails',     [ServiceAPIController::class,'ServiceSingleDetails']); 
    Route::post('ServiceSearch',     [ServiceAPIController::class,'ServiceSearch']);     
    Route::get('PopularServiceList',     [ServiceAPIController::class,'PopularServiceList']); 
    Route::post('CategoryServiceList',     [ServiceAPIController::class,'CategoryServiceList']); 
    
    //cart
    Route::post('AddCart',     [CartAPIController::class,'AddCart']); 
    Route::get('CartList',     [CartAPIController::class,'CartList']); 
    Route::post('DeleteCart',     [CartAPIController::class,'DeleteCart']); 
    Route::post('CartQuantityUpdate',     [CartAPIController::class,'CartQuantityUpdate']);
    

   //Order   
   Route::post('AddOrder',     [OrderAPIController::class,'AddOrder']); 
   Route::post('OrderList',     [OrderAPIController::class,'OrderList']); 
   Route::post('SingleOrderGet',     [OrderAPIController::class,'SingleOrderGet']); 
   Route::post('UpcomingOrderList',     [OrderAPIController::class,'UpcomingOrderList']); 
   Route::post('OlderOrderList',     [OrderAPIController::class,'OlderOrderList']); 
   Route::post('UpdateOrderStatus',     [OrderAPIController::class,'UpdateOrderStatus']); 
   
});