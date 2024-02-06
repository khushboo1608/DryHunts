@extends('layouts.app')
@section('content')
<!-- <section class="banner_image"> -->
<section>
    <div class="banner_title">
        <h1>Change Password</h1>
    </div>
</section>
<section class="create_event">
    <div class="container">
        <div class="event_create_card main_form form_wrapper">
            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @endif
            <form id="change-password-form" method="post" action="{{ url('update_password')}}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <div class="upload_photo">
                        <img id="profileImage" class="profileImage" name="profileImage" src="{{Helper::LoggedWebUserImage()}}" alt="">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="old_password">Old Password</label>
                        <input type="text" class="form-control" id="old_password" name="old_password" placeholder="Old password" >
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="new_password">New Password </label>
                        <input type="text" class="form-control" id="new_password" name="new_password" placeholder="New password" >
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="confirm_password">Confirm Password</label>
                        <input type="text" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm password">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mx-auto mt-5"> Save</button>
            </form>
        </div>
    </div>
</section>
@include('layouts.footer')
@endsection
@section('scripts')
<script>
    $(document).ready(function ()
    {      
        setTimeout(function(){
         $("div.alert").remove();
        }, 3000 ); 
          
        $('#change-password-form').validate({ // initialize the plugin
            
            rules: {
                old_password: {
                    noSpace: true,
                    required: true,
                    remote: {
                        url: "{{url('/check_old_password')}}",
                        type: 'post',
                        data: {
                            _token: '{{csrf_token()}}',
                        }
                    }
                },
                new_password:{
                    noSpace: true,
                    required: true,
                    notEqual: "#old_password",
                    ValidPassword:true
                },
                confirm_password:{
                    noSpace: true,
                    required: true,
                    equalTo: "#new_password",
                    ValidPassword:true
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
                old_password:{
                    required: "{{__('messages.web.user.old_password_required')}}",
                },
                new_password:{
                    required: "{{__('messages.web.user.new_password_required')}}"
                    },
                confirm_password:{
                    required: "{{__('messages.web.user.confirm_password_required')}}"
                    },
            },
            
        });
    });
    
    
</script>
@endsection