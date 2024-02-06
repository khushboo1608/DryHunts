@extends('admin.layouts.app')
@section('style')
   <style>
   </style>
@endsection
@section('content')
{{-- Header goes here --}}
    @include('admin.layouts.header')
{{-- Sidebar goes here --}}
    @include('admin.layouts.sidebar')
    
<!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>General Settings</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('admin/home')}}">Home</a></li>
              <li class="breadcrumb-item active">General Settings</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">              
              <div class="col-md-5 col-xs-12">
                <h3 class="card-title"></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
            <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="custom-content-below-home-tab" data-toggle="pill" href="#general_settings" role="tab" aria-controls="custom-content-below-home" aria-selected="true">General Settings</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="custom-content-below-profile-tab" data-toggle="pill" href="#app_settings" role="tab" aria-controls="custom-content-below-profile" aria-selected="false">App Settings</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="custom-content-below-messages-tab" data-toggle="pill" href="#notification_settings" role="tab" aria-controls="custom-content-below-messages" aria-selected="false">Notification Settings</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="custom-content-below-settings-tab" data-toggle="pill" href="#delivery_settings" role="tab" aria-controls="custom-content-below-settings" aria-selected="false">Delivery Settings</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="custom-content-below-payment-settings-tab" data-toggle="pill" href="#payment_settings" role="tab" aria-controls="custom-content-below-payment-settings" aria-selected="false">Payment Settings</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="custom-content-below-banking-settings-tab" data-toggle="pill" href="#banking_settings" role="tab" aria-controls="custom-content-below-banking-settings" aria-selected="false">Banking Settings</a>
              </li>
              
            </ul>
            <div class="tab-content" id="custom-content-below-tabContent">
                <div class="tab-pane fade show active" id="general_settings" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
                    <form action="{{route('setting.savegeneral')}}" name="settings_from" method="post" class="form form-horizontal" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="id" value="{{ isset($SettingsData->setting_id) ? $SettingsData->setting_id : '' }}"> 
                        <div class="section">
                            <div class="section-body" style="padding: 1.25rem;">
                            <div class="form-group row">
                                <label for="app_name" class="col-sm-2 col-form-label">App Name :-</label>
                                <div class="col-sm-6">
                                <input type="Text" class="form-control" id="app_name" name="app_name" placeholder="App Name" required="true" value="{{ isset($SettingsData->app_name) ? $SettingsData->app_name : '' }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">App Logo :- <p class="control-label-help">(Recommended resolution: 100x100 Image)</p></label>
                                <div class="col-md-6">
                                <div class="fileupload_block">
                                    <input type="file" name="app_logo" id="fileupload" accept="image/png, image/jpeg, image/jpg"> 
                                    
                                    <?php 
                                    $img ='';
                                    if(isset($SettingsData->app_logo) && $SettingsData->app_logo !=''){
                                        $img =$SettingsData->app_logo; 
                                    }
                                    if($img !=''){
                                        $url = url('images/app/app_logo/' . $img);
                                    
                                    ?>
                                    
                        <div class="fileupload_img"><img type="image" src="{{$url}}" /></div>
                        <?php } else { ?>
                        <div class="fileupload_img"><img type="image" src="{{config('global.no_image.add_image');}}"  /></div>
                        <?php }?>
                        <input id="app_logo" type="hidden" name="app_logo_edit"  value="{{ isset($SettingsData->app_logo) ? $SettingsData->app_logo : '' }}">
                                </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">App Description :-</label>
                                <div class="col-md-6">
                            
                                <textarea name="app_description" id="app_description" class="form-control">{{ isset($SettingsData->app_description) ? $SettingsData->app_description : '' }}</textarea>
                                <script src="https://cdn.ckeditor.com/4.5.6/standard/ckeditor.js"></script> 
                                <script>CKEDITOR.replace( 'app_description' );</script>
                                </div>
                            </div>
                            <div class="form-group row">&nbsp;</div>                 
                            
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Contact :-</label>
                                <div class="col-md-6">
                                <input type="text" name="app_contact" id="app_contact" value="{{ isset($SettingsData->app_contact) ? $SettingsData->app_contact : '' }}" class="form-control">
                                </div>
                            </div>     
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Email :-</label>
                                <div class="col-md-6">
                                <input type="text" name="app_email" id="app_email" value="{{ isset($SettingsData->app_email) ? $SettingsData->app_email : '' }}" class="form-control">
                                </div>
                            </div>                 
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Website :-</label>
                                <div class="col-md-6">
                                <input type="text" name="app_website" id="app_website" value="{{ isset($SettingsData->app_website) ? $SettingsData->app_website : '' }}" class="form-control">
                                </div>
                            </div>                               
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">App Facebook :-</label>
                                <div class="col-md-6">
                                <input type="text" name="app_facebook" id="app_facebook" value="{{ isset($SettingsData->app_facebook) ? $SettingsData->app_facebook : '' }}" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">App Youtube :-</label>
                                <div class="col-md-6">
                                <input type="text" name="app_youtube" id="app_youtube" value="{{ isset($SettingsData->app_youtube) ? $SettingsData->app_youtube : '' }}" class="form-control">
                                </div>
                            </div>
                                
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">App Twitter :-</label>
                                <div class="col-md-6">
                                <input type="text" name="app_twitter" id="app_twitter" value="{{ isset($SettingsData->app_twitter) ? $SettingsData->app_twitter : '' }}" class="form-control">
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">App Instagram :-</label>
                                <div class="col-md-6">
                                <input type="text" name="app_instagram" id="app_instagram" value="{{ isset($SettingsData->app_instagram) ? $SettingsData->app_instagram : '' }}" class="form-control">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">App Whatsapp :-</label>
                                <div class="col-md-6">
                                <input type="text" name="app_whatsapp" id="app_whatsapp" value="{{ isset($SettingsData->app_whatsapp) ? $SettingsData->app_whatsapp : '' }}" class="form-control">
                                </div>
                            </div>
                                                            
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">App Linkedin :-</label>
                                <div class="col-md-6">
                                <input type="text" name="app_linkedin" id="app_linkedin" value="{{ isset($SettingsData->app_linkedin) ? $SettingsData->app_linkedin : '' }}" class="form-control">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-6 col-md-offset-3 text-center">
                                <button type="submit" name="submit" id="btngeneral" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade" id="app_settings" role="tabpanel" aria-labelledby="custom-content-below-profile-tab">
                    <form action="{{route('setting.savegeneral')}}" name="frmapp_settings" method="post" class="form form-horizontal" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="id" value="{{ isset($SettingsData->setting_id) ? $SettingsData->setting_id : '' }}"> 
                        <div class="section">
                            <div class="section-body" style="padding: 1.25rem;">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Maintenance :-</label>
                                <div class="col-md-6">
                                    <div class="row" style="margin-top: 15px">
                                    <input type="checkbox" id="chk_update" name="app_maintenance_status" value="1" {{ isset($SettingsData->setting_id) && $SettingsData->app_maintenance_status == 1 ? 'checked' : null }} class="cbx hidden" />
                                        <label for="chk_update" class="lbl" style="left:13px;"></label>
                                        <br />
                                    </div>
                                    </div>
                            </div>
                            <br />
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">New App Version Code :- <br /><span>
                                    (How to get version code)</span></label>
                                
                                <div class="col-md-6">
                                <input type="text" name="app_version" id="app_version" value="{{ isset($SettingsData->app_version) ? $SettingsData->app_version : '' }}" class="form-control">
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label"> Maintenance Description :- </label>
                                <div class="col-md-6">
                                <input type="text" name="app_maintenance_description" id="app_maintenance_description" value="{{ isset($SettingsData->app_maintenance_description) ? $SettingsData->app_maintenance_description : '' }}"  class="form-control">
                                </div>
                            </div>
                            
                            <div class="form-group row"> 
                                <label class="col-sm-2 col-form-label"> Update Description:- </label>
                                <div class="col-md-6">
                                <input type="text" name="app_update_description" id="app_update_description" value="{{ isset($SettingsData->app_update_description) ? $SettingsData->app_update_description : '' }}" class="form-control">
                                </div>
                            </div>
                                                
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Cancel Option :-<br /> ( Cancel button option will show in app update popup ) </label>
                                <div class="col-md-6">
                                    <input type="checkbox" id="chk_cancel_update" name="app_update_cancel_button" value="1" {{ isset($SettingsData->app_update_description) &&$SettingsData->app_update_cancel_button == 1 ? 'checked' : null }} class="cbx hidden"/>
                                        <label for="chk_cancel_update" class="lbl" style="left:13px;"></label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 col-md-offset-3 text-center">
                                <button type="submit" name="btn_app_settings" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade" id="notification_settings" role="tabpanel" aria-labelledby="custom-content-below-messages-tab">
                    <form action="{{route('setting.savegeneral')}}" name="settings_api" method="post" class="form form-horizontal" enctype="multipart/form-data" >
                        @csrf
                        <input type="hidden" name="id" id="id" value="{{ isset($SettingsData->setting_id) ? $SettingsData->setting_id : '' }}"> 
                        <div class="section">
                        <div class="section-body" style="padding: 1.25rem;">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">OneSignal App ID :-</label>
                            <div class="col-md-6">
                            <input type="text" name="onesignal_app_id" id="onesignal_app_id" value="{{ isset($SettingsData->onesignal_app_id) ? $SettingsData->onesignal_app_id : '' }}" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">OneSignal Rest Key:-</label>
                            <div class="col-md-6">
                                <input type="text" name="onesignal_rest_key" id="onesignal_rest_key" value="{{ isset($SettingsData->onesignal_rest_key) ? $SettingsData->onesignal_rest_key : '' }}" class="form-control">
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Server Key :-</label>
                            <div class="col-md-6">
                            
                            <textarea name="firebase_server_key" id="firebase_server_key"  rows="3" cols="4" class="form-control">{{ isset($SettingsData->firebase_server_key) ? $SettingsData->firebase_server_key : '' }}</textarea>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">2 Factor API Key :-</label>
                            <div class="col-md-6">
                                <input type="text" name="factor_apikey" id="factor_apikey" value="{{ isset($SettingsData->factor_apikey) ? $SettingsData->factor_apikey : '' }}" class="form-control">
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">2 Factor Option <br /> ( This button option will show in live or not 2 Factor ):-</label>
                            <div class="col-md-6">
                                <input type="checkbox" id="chk_factor_update" name="app_update_factor_button" value="1" {{ isset($SettingsData->app_update_factor_button) && $SettingsData->app_update_factor_button == 1 ? 'checked' : null }} class="cbx hidden">
                                    <label for="chk_factor_update" class="lbl" style="left:13px;"></label>
                            </div>
                        </div>                                                           
                        <div class="form-group row">
                        <div class="col-sm-6 col-md-offset-3 text-center">
                            <button type="submit" name="notification_submit" class="btn btn-primary">Save</button>
                        </div>
                        </div>
                        </div>
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade" id="delivery_settings" role="tabpanel" aria-labelledby="custom-content-below-settings-tab">
                    <form action="{{route('setting.savegeneral')}}" name="delivery_settings" method="post" class="form form-horizontal" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="id" value="{{ isset($SettingsData->setting_id) ? $SettingsData->setting_id : '' }}">
                        <div class="section">
                            <div class="section-body" style="padding: 1.25rem;">                                
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Agent Onboard Commission :-</label>
                                <div class="col-md-6">
                                <input type="text" name="agent_onboard_commission" id="agent_onboard_commission" value="{{ isset($SettingsData->agent_onboard_commission) ? $SettingsData->agent_onboard_commission : '' }}" class="form-control" required>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Agent Approve Commission :-</label>
                                <div class="col-md-6">
                                <input type="text" name="agent_approve_commission" id="agent_approve_commission" value="{{ isset($SettingsData->agent_approve_commission) ? $SettingsData->agent_approve_commission : '' }}" class="form-control">
                                </div>
                            </div> 
                            
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Reffer Earn Amount:-</label>
                                <div class="col-md-6">
                                <input type="text" name="reffer_earn_amount" id="reffer_earn_amount" value="{{ isset($SettingsData->reffer_earn_amount) ? $SettingsData->reffer_earn_amount : '' }}" class="form-control">
                                </div>
                            </div> 
                            
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Radius :-</label>
                                <div class="col-md-6">
                                <input type="text" name="radius" id="radius" value="{{ isset($SettingsData->radius) ? $SettingsData->radius : '' }}" class="form-control">
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Minimum Amount for Add in wallet :-</label>
                                <div class="col-md-6">
                                <input type="text" name="add_min_wallet_amount" id="add_min_wallet_amount" value="{{ isset($SettingsData->add_min_wallet_amount) ? $SettingsData->add_min_wallet_amount : '' }}" class="form-control">
                                </div>
                            </div>                         
                            
                            <div class="form-group row">
                                <div class="col-sm-6 col-md-offset-3 text-center">
                                <button type="submit" name="delivery_settings" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade" id="payment_settings" role="tabpanel" aria-labelledby="custom-content-below-payment-settings-tab">
                    <form action="{{route('setting.savegeneral')}}" name="payment_settings" method="post" class="form form-horizontal" enctype="multipart/form-data" >
                        @csrf
                        <input type="hidden" name="id" id="id" value="{{ isset($SettingsData->setting_id) ? $SettingsData->setting_id : '' }}">
                        <div class="section">
                            <div class="section-body" style="padding: 1.25rem;">                            
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Razorpay Key :-</label>
                                    <div class="col-md-6">
                                    <input type="text" name="razorpay_key" id="razorpay_key" value="{{ isset($SettingsData->razorpay_key) ? $SettingsData->razorpay_key : '' }}" class="form-control">
                                    </div>
                                </div>                                                  
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Map Key :-</label>
                                    <div class="col-md-6">
                                    <input type="text" name="map_api_key" id="map_api_key" value="{{ isset($SettingsData->map_api_key) ? $SettingsData->map_api_key : '' }}" class="form-control">
                                    </div>
                                </div>                               
                                <div class="form-group row">
                                    <div class="col-md-9 col-md-offset-3">
                                        <button type="submit" name="payment_settings" class="btn btn-primary">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade" id="banking_settings" role="tabpanel" aria-labelledby="custom-content-below-banking-settings-tab">
                    <form action="{{route('setting.savegeneral')}}" name="settings_banking_form" method="post" class="form form-horizontal" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="id" value="{{ isset($SettingsData->setting_id) ? $SettingsData->setting_id : '' }}">
                        <div class="section">
                            <div class="section-body" style="padding: 1.25rem;">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Address :-</label>
                                    <div class="col-md-6">
                                    <input type="text" name="app_address" id="app_address" value="{{ isset($SettingsData->app_address) ? $SettingsData->app_address : '' }}" class="form-control">
                                    </div>
                                </div>                                    
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">GSTIN :-</label>
                                    <div class="col-md-6">
                                    <input type="text" name="app_gstin" id="app_gstin" value="{{ isset($SettingsData->app_gstin) ? $SettingsData->app_gstin : '' }}" class="form-control">
                                    </div>
                                </div>                                
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">PAN No :-</label>
                                    <div class="col-md-6">
                                    <input type="text" name="app_pan" id="app_pan" value="{{ isset($SettingsData->app_pan) ? $SettingsData->app_pan : '' }}" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Bank Name :-</label>
                                    <div class="col-md-6">
                                    <input type="text" name="app_bank_name" id="app_bank_name" value="{{ isset($SettingsData->app_bank_name) ? $SettingsData->app_bank_name : '' }}" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Bank Account No :-</label>
                                    <div class="col-md-6">
                                    <input type="text" name="app_acount_no" id="app_acount_no" value="{{ isset($SettingsData->app_acount_no) ? $SettingsData->app_acount_no : '' }}" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">IFSC Code :-</label>
                                    <div class="col-md-6">
                                    <input type="text" name="app_ifsc" id="app_ifsc" value=" {{ isset($SettingsData->app_ifsc) ? $SettingsData->app_ifsc : '' }}" class="form-control">
                                    </div>
                                </div>                                
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Branch Name :-</label>
                                    <div class="col-md-6">
                                    <input type="text" name="app_branch" id="app_branch" value="{{ isset($SettingsData->app_branch) ? $SettingsData->app_branch : '' }}" class="form-control">
                                    </div>
                                </div>                            
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">App Upi Image :- <p class="control-label-help">(Recommended resolution: 200x200 Image)</p></label>
                                    <div class="col-md-6">
                                        <div class="fileupload_block">
                                            <input type="file" name="app_upi_image" id="fileupload" accept="image/png, image/jpeg, image/jpg">
                                <?php 
                                $img1 ='';
                                if(isset($SettingsData->app_upi_image) && $SettingsData->app_upi_image !=''){
                                    $img1 =$SettingsData->app_upi_image; 
                                }
                                if($img1 !=''){
                                    $url = url('images/app/app_upi_image/' . $img1);
                                
                                ?>
                                <div class="fileupload_img"><img type="image" src="{{$url}}"  /></div>
                                <?php } else { ?>
                                <div class="fileupload_img"><img type="image" src="{{config('global.no_image.app_upi_image');}}"   /></div>
                                <?php } ?>
                                    <input id="app_upi_image" type="hidden" name="app_upi_image_edit"  value="{{ isset($SettingsData->app_upi_image) ? $SettingsData->app_upi_image : '' }}">
                                        </div>
                                    </div>
                                </div>                                
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Notes Description :-</label>
                                    <div class="col-md-6">                                
                                    <textarea name="app_notes_desc" id="app_notes_desc" class="form-control">{{ isset($SettingsData->app_notes_desc) ? $SettingsData->app_notes_desc : '' }}</textarea>
                                    <script src="https://cdn.ckeditor.com/4.5.6/standard/ckeditor.js"></script> 
                                    <script>CKEDITOR.replace( 'app_notes_desc' );</script>
                                    </div>
                                </div>
                                <div class="form-group row">&nbsp;</div>
                                <div class="form-group row">
                                    <div class="col-sm-6 col-md-offset-3 text-center">
                                        <button type="submit" name="banking_submit" class="btn btn-primary">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                
            </div>
          </div>
              <!-- /.card-body -->
            </div>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
         {{-- Footer goes here --}}
         @include('admin.layouts.footer')
     </div>
 </div>
@endsection
@section('scripts')
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script src="https://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script type="text/javascript">

</script>
@endsection