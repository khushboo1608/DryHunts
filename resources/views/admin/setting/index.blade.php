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
                <a class="nav-link active" id="custom-content-below-about_us-tab" data-toggle="pill" href="#api_about_us" role="tab" aria-controls="custom-content-below-about_us" aria-selected="true">About us</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="custom-content-below-contact_us-tab" data-toggle="pill" href="#api_contact_us" role="tab" aria-controls="custom-content-below-contact_us" aria-selected="false">Contact us</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="custom-content-below-privacy_policy-tab" data-toggle="pill" href="#api_privacy_policy" role="tab" aria-controls="custom-content-below-privacy_policy" aria-selected="false">App Privacy Policy</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="custom-content-below-terms_condition-tab" data-toggle="pill" href="#api_terms_condition" role="tab" aria-controls="custom-content-below-terms_condition" aria-selected="false">App terms conditions</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="custom-content-below-cancellation_refund-settings-tab" data-toggle="pill" href="#api_cancellation_refund" role="tab" aria-controls="custom-content-below-cancellation_refund-settings" aria-selected="false">App Cancellation/Refund Policies</a>
              </li>
              
            </ul>
            <div class="tab-content" id="custom-content-below-tabContent">
                <div class="tab-pane fade show active" id="api_about_us" role="tabpanel" aria-labelledby="custom-content-below-about_us-tab">
                    <form action="{{route('setting.savepagesetting')}}" name="api_about_us" method="post" class="form form-horizontal" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="id" value="{{$SettingsData->setting_id}}"> 
                        <div class="section">
                            <div class="section-body" style="padding: 1.25rem;">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">App About us :-</label>
                                <div class="col-md-6">
                            
                                <textarea name="app_about_us" id="app_about_us" class="form-control">{{$SettingsData->app_about_us}}</textarea>
                                <script src="https://cdn.ckeditor.com/4.5.6/standard/ckeditor.js"></script>                                 
                                <script>CKEDITOR.replace( 'app_about_us' );</script>    
                                </div>
                            </div>               
                            <div class="form-group row">
                                <div class="col-sm-6 col-md-offset-3 text-center">
                                <button type="submit" name="btn_about_us" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade" id="api_contact_us" role="tabpanel" aria-labelledby="custom-content-below-contact_us-tab">
                    <form action="{{route('setting.savepagesetting')}}" name="api_contact_us" method="post" class="form form-horizontal" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="id" value="{{$SettingsData->setting_id}}"> 
                        <div class="section">
                            <div class="section-body" style="padding: 1.25rem;">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">App Contact us :-</label>
                                <div class="col-md-6">                                   
                                <textarea name="app_contact_us" id="app_contact_us" class="form-control">{{$SettingsData->app_contact_us}}</textarea>
                                <script src="https://cdn.ckeditor.com/4.5.6/standard/ckeditor.js"></script> 
                                <script>CKEDITOR.replace( 'app_contact_us' );</script>
                                </div>
                            </div>               
                            <div class="form-group row">
                                <div class="col-sm-6 col-md-offset-3 text-center">
                                <button type="submit" name="btn_contact_us" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade" id="api_privacy_policy" role="tabpanel" aria-labelledby="custom-content-below-privacy_policy-tab">
                    <form action="{{route('setting.savepagesetting')}}" name="api_privacy_policy" method="post" class="form form-horizontal" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="id" value="{{$SettingsData->setting_id}}"> 
                        <div class="section">
                            <div class="section-body" style="padding: 1.25rem;">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">App Privacy Policy :-</label>
                                <div class="col-md-6">
                            
                                <textarea name="app_privacy_policy" id="app_privacy_policy" class="form-control">{{$SettingsData->app_privacy_policy}}</textarea>
                                <script src="https://cdn.ckeditor.com/4.5.6/standard/ckeditor.js"></script> 
                                <script>CKEDITOR.replace( 'app_privacy_policy' );</script>
                                </div>
                            </div>               
                            <div class="form-group row">
                                <div class="col-sm-6 col-md-offset-3 text-center">
                                <button type="submit" name="btn_privacy_policy" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade" id="api_terms_condition" role="tabpanel" aria-labelledby="custom-content-below-terms_condition-tab">
                    <form action="{{route('setting.savepagesetting')}}" name="api_terms_condition" method="post" class="form form-horizontal" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="id" value="{{$SettingsData->setting_id}}"> 
                        <div class="section">
                            <div class="section-body" style="padding: 1.25rem;">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">App Terms & Condition :-</label>
                                <div class="col-md-6">
                            
                                <textarea name="app_terms_condition" id="app_terms_condition" class="form-control">{{$SettingsData->app_terms_condition}}</textarea>
                                <script src="https://cdn.ckeditor.com/4.5.6/standard/ckeditor.js"></script> 
                                <script>CKEDITOR.replace( 'app_terms_condition' );</script>
                                </div>
                            </div>               
                            <div class="form-group row">
                                <div class="col-sm-6 col-md-offset-3 text-center">
                                <button type="submit" name="btn_terms_condition" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade" id="api_cancellation_refund" role="tabpanel" aria-labelledby="custom-content-below-cancellation_refund-settings-tab">
                    <form action="{{route('setting.savepagesetting')}}" name="api_cancellation_refund" method="post" class="form form-horizontal" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="id" value="{{$SettingsData->setting_id}}"> 
                        <div class="section">
                            <div class="section-body" style="padding: 1.25rem;">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">App Cancellation/Refund Policies :-</label>
                                <div class="col-md-6">
                            
                                <textarea name="app_cancellation_refund" id="app_cancellation_refund" class="form-control">{{$SettingsData->app_cancellation_refund}}</textarea>
                                <script src="https://cdn.ckeditor.com/4.5.6/standard/ckeditor.js"></script> 
                                <script>CKEDITOR.replace( 'app_cancellation_refund' );</script>
                                </div>
                            </div>               
                            <div class="form-group row">
                                <div class="col-sm-6 col-md-offset-3 text-center">
                                <button type="submit" name="btn_cancellation_refund" class="btn btn-primary">Save</button>
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