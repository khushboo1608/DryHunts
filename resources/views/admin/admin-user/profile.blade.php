@extends('admin.layouts.app')
@section('content')
{{-- Sidebar goes here --}}
    @include('admin.layouts.sidebar')
    {{-- Header goes here --}}
    @include('admin.layouts.header')
<!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Profile</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('admin/home')}}">Home</a></li>
              <li class="breadcrumb-item active">Profile</li>
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
                <h3 class="card-title">Manage  Profile</h3>
              </div>
              <div class="col-md-12 col-xs-12">
                    <div class="search_list">
                          <a href="{{url('admin/home')}}"><button type="button"  class="btn btn-primary waves-effect waves-light"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Back</button></a>                        
                    </div>
                </div>    
              </div>
              
              <!-- /.card-header -->
              <div class="card-body">
              <div class="profile-wall-textbox">
                @if(Session::has('profile-update'))
                    <p id="msgs" class="alert alert-success">{{ Session::get('profile-update') }}</p>
                @endif 
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Profile Detail</h5>
                        </div>
                        <div>
                            <form action="{{ url('admin/update_profile') }}" method="POST" enctype="multipart/form-data" >
                                @csrf
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <label class="cabinet center-block">
                                        <figure>
                                            <img src="{{Helper::LoggedUserImage()}}"  class="gambar img-responsive img-thumbnail" id="item-img-output" name="item-img-output">
                                             <input type="hidden" name="image1" id="image1">
                                        </figure>
                                        <input name="imageurl"  type="file" value="fileupload" id="imageurl" required="true" style="margin-top: 10px !important; " accept="image/png, image/jpeg, image/jpg">
                                    </label>
                                    <div class="text-center profile-widget-social">
                                        <input type="submit" name="submit" value="Upload Image" class="btn btn-primary" id="uploadbtnImage" >
                                    </div>
                                </div>
                                <div class="modal fade" id="cropImagePop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel">
                                                </h4>
                                            </div>
                                            <div class="modal-body">
                                                <div id="upload-demo" class="center-block"></div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <button type="button" id="cropImageBtn" class="btn btn-primary">Crop</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Change Password</h5>
                        </div>
                        <div class="ibox-content">    
                            <form id="admin-change-password" name="admin-change-password" action="{{ url('admin/change_password') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label>Old  password:</label>
                                    <input placeholder="Enter Password" type="password" class="form-control" id="old_password" name="old_password">
                                </div>

                                <div class="form-group">
                                    <label>New  password:</label>
                                    <input placeholder="Enter New Password" type="password" class="form-control" id="new_password" name="new_password">
                                </div>

                                <div class="form-group">
                                    <label>Confirm  password:</label>
                                    <input placeholder="Enter Confirm Password" type="password" class="form-control" id="confirm_password" name="confirm_password">
                                </div>
                                <div class="profile-wall-action">
                                    <div class="wall-action-right">
                                        <button type="submit" class="btn btn-primary" id="chnge-submit">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
                    <!-- </div> -->
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
         <!-- @include('admin.layouts.footer') -->
     </div>
 </div>
                    <!-- </div> -->
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
         <!-- @include('admin.layouts.footer') -->
     </div>
 </div>
@endsection
@section('scripts')
<script src="{{ url('public/admin_assets/js/form-validation/custom-form-validation.js') }}"></script>
<script type="text/javascript">
     $(document).ready(function ()
    {
        // chnage password form validation
        $('#admin-change-password').validate({ // initialize the plugin
            rules: {
                old_password: {
                    noSpacePassword: true,
                    required: true,
                    remote: {
                        url: "{{url('admin/check_old_password')}}",
                        type: 'post',
                        data: {
                            _token: '{{csrf_token()}}',
                        }
                    }
                },
                new_password: {
                    noSpacePassword:true,
                    required: true,
                    notEqual: "#old_password",
                    // ValidPassword:true
                    
                },
                confirm_password: {
                    noSpacePassword: true,
                    required: true,
                    equalTo: "#new_password",
                    // ValidPassword:true
                }
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
               
                error.addClass('invalid-feedback');
               
                element.closest('.form-group').append(error);
                $('.error').css("font-weight", "bold");
                $('.error').css("color", "red");
                $('.error').css("float", "left");
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
                
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            },
            messages: {
                old_password: {
                    required: "{{__('messages.admin.user.old_password_required')}}",
                    remote: "{{__('messages.admin.user.current_password_not_match')}}"
                },
                new_password: {
                    required: "{{__('messages.admin.user.new_password_required')}}",
                },
                confirm_password: {
                    required: "{{__('messages.admin.user.confirm_password_required')}}",
                    equalTo: "{{__('messages.admin.user.confirm_new_password_not_match')}}",
                }
            }
        });
    });    
</script>
@endsection