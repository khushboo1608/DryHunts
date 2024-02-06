@extends('layouts.app')
@section('content')
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KNK2NX9"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
@include('layouts.header')
<main class="main__content_wrapper">
    <div class="container" style="margin-top: 50px; margin-bottom:50px;">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-sm-12 col-md-12 col-lg-6">
                <div class="main-address-box text-center">
                    <h3 class="form-h3">Login</h3>
                    <!-- <form id="submitForm" name="submitForm" method="post" enctype="multipart/form-data"> -->
                    <form method="post" id="login-form" action="{{ url('login') }}" name="login-form">
                    <input type="hidden" name="login_type" value="web">
                                @csrf
                                @if (session('message'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('message') }}
                                    </div>
                                @endif
                                @if (session('error'))
                                    <div class="alert alert-danger" role="alert">
                                        {{ session('error') }}
                                    </div>
                                @endif

                                <div class="checkout__input--list mb-20 form-group">
                                    <input id="email" type="text" class="checkout__input--field border-radius-5  @error('email') is-invalid @enderror" name="email" placeholder="Email/Phone no." value="{{ old('email') }}" required autocomplete="email" autofocus>
                                </div>

                                <div class="checkout__input--list mb-20 form-group">
                                    <input id="password" type="password"  class="checkout__input--field border-radius-5  @error('password') is-invalid @enderror" name="password" placeholder="Enter Your Password" required  autofocus>
                                </div>
                        <button type="submit" class="primary__btn w-200" name="submit" value="Submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@include('layouts.footer')
@endsection
@section('scripts')
<script>
    $(document).ready(function ()
    {
        // $('.pace-done').css('background','#f3f3f4');
        $('#login-form').validate({ // initialize the plugin
            rules: {
                email: {
                    noSpace: true,
                    required: true,
                    // email: true
                },
                password: {
                    required: true,
                    noSpace:true
                },
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
                email: {
                    required: "{{__('messages.web.user.email_required')}}",
                    email: "{{__('messages.web.user.email_format')}}"
                },
                password: {
                    required: "{{__('messages.web.user.password_required')}}",
                   
                }
            }
        });

        setTimeout(function(){
            $("div.alert").remove();
        }, 5000 ); // 5 secs
   
    });  
</script>
@endsection
