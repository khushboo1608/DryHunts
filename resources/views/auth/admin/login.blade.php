@extends('admin.layouts.app')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div >
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <!-- <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">General Form</li> -->
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
<section class="content">
      <div class="container-fluid">
        <div class="row" style="justify-content: center;">

          <!-- left column -->
          <div class="col-md-6">
          
            <!-- Horizontal Form -->
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Login Form</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form class="form-horizontal" action="{{ route('login') }}" method="post" id="admin-login-form" name="admin-login-form">
              @if(session()->has('message')) 
                <div class="input-group" style="border:0px;">
                  <div class="alert alert-danger  alert-dismissible col-sm-12" role="alert">
                  {{session('message')}}
                </div>
              </div>
              @endif   
                        
            @csrf
                <div class="card-body">
                  <div class="form-group row">
                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                      <input type="email" class="form-control" id="email" name="email" placeholder="Email" required="true">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="password" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                      <input type="password" class="form-control" minlength="6" id="password"  name="password" placeholder="password" required="true">
                    </div>
                  </div>
                  <!-- <div class="form-group row">
                    <div class="offset-sm-2 col-sm-10">
                      <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck2">
                        <label class="form-check-label" for="exampleCheck2">Remember me</label>
                      </div>
                    </div>
                  </div> -->
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-info">Sign in</button>
                </div>
                <!-- /.card-footer -->
                
              @if(session()->has('error'))
                  <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                      {{session('error')}}
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">×</span>
                      </button>
                  </div>
              @endif

              </form>
            </div>
            <!-- /.card -->

          </div>
          <!--/.col (left) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('scripts')
<script>
    $(document).ready(function ()
    {
        // $('.pace-done').css('background','#f3f3f4');
        $('#admin-login-form').validate({ // initialize the plugin
            rules: {
                email: {
                    noSpace: true,
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    noSpacePassword:true
                },
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
               
                error.addClass('invalid-feedback');
                $('#invalid-feedback_email').hide();
                $('#invalid-feedback_password').hide();
                // element.closest('.input-group').append(error);
                // $('.error').css("font-weight", "bold");
                if(element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
                
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            },
            messages: {
                email: {
                    required: "{{__('messages.admin.user.email_required')}}",
                    email: "{{__('messages.admin.user.email_format')}}"
                },
                password: {
                    required: "{{__('messages.admin.user.password_required')}}",
                }
            }
        });

        setTimeout(function(){
            $("div.alert").remove();
        }, 5000 ); // 5 secs
    });  
</script>
@endsection