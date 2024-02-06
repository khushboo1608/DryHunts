@extends('layouts.app')
@section('style')
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropper/2.3.4/cropper.min.css" rel="stylesheet">
<style>
    #upload-demo {
        width: 100%;
        height: 250px;
        padding-bottom: 25px;
    }
    .cropper-crop-box, .cropper-view-box {
        border-radius: 50%;
    }
    .cropper-view-box {
        box-shadow: 0 0 0 1px #39f;
        outline: 0;
    }
    .cropper-face {
        background-color:inherit !important;
    }
    .cropper-dashed, .cropper-line {
        display:none !important;
    }
    .cropper-view-box {
        outline:inherit !important;
    }
    .cropper-point.point-se {
        top: calc(85% + 1px);
        right: 14%;
    }
    .cropper-point.point-sw {
        top: calc(85% + 1px);
        left: 14%;
    }
    .cropper-point.point-nw {
        top: calc(15% - 5px);
        left: 14%;
    }
    .cropper-point.point-ne {
        top: calc(15% - 5px);
        right: 14%;
    }
    .cropper-view-box {
        box-shadow: 0 0 0 1px #39f;
        outline: 0;
    }
    .cropper-face {
        background-color:inherit !important;
    }
    .cropper-dashed, .cropper-point.point-se, .cropper-point.point-sw, .cropper-point.point-nw,   .cropper-point.point-ne, .cropper-line {
        display:none !important;
    }
    .cropper-view-box {
        outline:inherit !important;
    } 
</style>
@endsection
@section('content')
<!-- <section class="banner_image"> -->
<!-- <section>
    <div class="banner_title">
        <h1>Edit Profile</h1>
    </div>
</section> -->
    <header>
        <nav class="main_navbar navbar navbar-expand-lg navbar-light ">
            <!-- <a href=" @if (Auth::check()) {{url('event')}} @else  @endif" class="navbar-brand"><img id = "mail_logo_id" class="main_logo" src="{{config('global.static_image.logo')}}" alt=""></a> -->
            <!-- <div class="dropdown ml-auto"> -->
            <div class="dropdown ">
                @if (Auth::check())
                    <a href="#" class="user_profile " id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="user_image"><img src="{{Helper::LoggedWebUserImage()}}" alt=""></div>
                        <div class="user_name"><h6> {{(Auth::user()->user_org_data) ?  Auth::user()->user_org_data->organization_name:''}}</h6></div>
                    </a>
                @endif
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="{{url('profile')}}">Edit Profile</a>
                    <a class="dropdown-item" href="{{url('userdata')}}">Users Data</a>
                    {{-- <a class="dropdown-item" href="{{url('change_password')}}">Change Password</a> --}}
                    <a class="dropdown-item" href="#"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();" >Log out</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        <input type="hidden" name="is_web" value = "1">
                        @csrf
                    </form>
                </div>
            </div>
            <div class="banner_title ml-auto">
                <h6>Edit Profile</h6>
            </div>
        </nav>
    </header>
<section class="create_event">
    <div class="container">
        <div class="event_create_card">
            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @endif
            <form id="edit-profile-form" method="post" action="{{ url('update_profile')}}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <div class="upload_photo">
                        <img id="profileImage" class="profileImage" name="profileImage" src="{{Helper::LoggedWebUserImage()}}" alt="">
                        <div class="edit_profile">
                            <img class="profileImage" src="{{config('global.static_image.edit-profile')}}" alt="">
                            <input id="image" class="image" type="file" name="image" accept="image/png, image/jpg, image/jpeg">
                            <input id="image64" type="hidden" name="image64" class="image64" value="{{(Auth::user()) ?  Auth::user()->profile_image:''}}">
                        </div>
                    </div>
                    <span id="image-error1" class="error invalid-feedback" style="font-weight: bold; display: none;">{{__('messages.web.only_image_validation')}}</span>
                </div>
                <div class="form-group">
                    <label for="">Organization Name</label>
                    <input type="text" class="form-control" id="organization_name" name="organization_name" placeholder="Organization Name" value="{{(Auth::user()->user_org_data) ?  Auth::user()->user_org_data->organization_name:''}}">
                </div>
                <div class="form-group">
                    <label for="">EIN</label>
                    <input type="text" class="form-control" id="registration_id" name="registration_id" placeholder="EIN" minlength="6" maxlength="10" value="{{(Auth::user()->user_org_data) ?  Auth::user()->user_org_data->registration_id:''}}">
                </div>
                <div class="form-group">
                    <label for="">Contact Number</label>
                    <input type="text" class="form-control" id="contact_number" name="contact_number" minlength="10" maxlength="15" placeholder="Contact Number" onkeypress="return isNumber(event)" value="{{(Auth::user()->user_org_data) ?  Auth::user()->user_org_data->contact_no:''}}">
                </div>
                <div class="form-group">
                    <label for="">Address</label>
                    <input type="text" class="form-control" id="address" name="address" placeholder="Address" value="{{(Auth::user()) ?  Auth::user()->location:''}}">
                    <div id="map" style="display: none"></div>
                    <input type="hidden" name="latitude" id="latitude" value="{{(Auth::user()) ?  Auth::user()->latitude:''}}">
                    <input type="hidden" name="longitude" id="longitude" value="{{(Auth::user()) ?  Auth::user()->longitude:''}}">
                </div>
                <div class="form-group">
                    <label for="">Description </label>
                    <textarea class="form-control" id="bio" name="bio" rows="3" placeholder="Type Here...">{{(Auth::user()) ?  Auth::user()->bio:''}}</textarea>
                </div>
                <button type="submit" class="btn btn-primary mx-auto mt-5"> Save</button>
            </form>
        </div>
    </div>
</section>
<div class="modal fade" id="cropImagePop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" style="width: 100%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                </h4>
            </div>
            <div class="modal-body">
                <div id="upload-demo" class="center-block"></div>
            </div>
            <div class="modal-footer" style="margin-top: 15%">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" id="cropImageBtn" class="btn btn-primary">Crop</button>
            </div>
        </div>
    </div>
</div>
@include('layouts.footer')
@endsection
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/0.8.1/cropper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyBzW6oaNiZ2CM6ct7hmRtp9EyI8Pv1qFNU&callback=initMap"></script>
<script>
    function initMap()
    {
        var map = new google.maps.Map(document.getElementById('map'), {
        mapTypeControl: false,
        center: {lat: 41.85, lng: -87.65},
        zoom: 7
        });
        new AutocompleteDirectionsHandler(map);
    }
    function AutocompleteDirectionsHandler(map)
    {
        this.map = map;
        var originInput = document.getElementById('address');
        var originAutocomplete = new google.maps.places.Autocomplete(
            originInput, {});
        google.maps.event.addListener(originAutocomplete, 'place_changed', function () {
            var place = originAutocomplete.getPlace();
            var lat = place.geometry.location.lat();
            var lng = place.geometry.location.lng();
            $("#latitude").val(lat);
            $("#longitude").val(lng);
        });
    }
    function isNumber(evt)
    {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
</script>
<script>
    $(document).ready(function ()
    {   
        setTimeout(function(){
         $("div.alert").remove();
        }, 3000 );     
        $('#edit-profile-form').validate({ // initialize the plugin
            ignore: ":hidden:not(.image64)",
            // onfocusout: false,
            invalidHandler: function(form, validator) {
                $('html, body').animate({
            scrollTop: $(validator.errorList[0].element).offset().top
        }, 1000);
            } ,
            rules: {
                image64: {
                    required: true,
                    // accept:"jpg,png,jpeg",
                },
                organization_name:{
                    noSpace: true,
                    required: true
                    },
                registration_id:{
                    noSpace: true,
                    required: true,
                    minlength:6,
                    maxlength:10
                    },
                contact_number:{
                    noSpace: true,
                    required: true,
                    minlength:10,
                    maxlength:15,
                    // number: true,
                    // validMobile:$('#contact_number').val()
                    },
                address:{
                    noSpace: true,
                    required: true
                },
                bio:{
                    required: true,
                    noSpace: true
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
                image64:{
                    required: "{{__('messages.web.user.profile_photo_required')}}",
                    // accept:"Please upload jpg,png,jpeg image only",
                },
                organization_name:{
                    required: "{{__('messages.web.user.organization_name_required')}}"
                    },
                registration_id:{
                    required: "{{__('messages.web.user.registration_id_required')}}"
                    },
                contact_number:{
                    required: "{{__('messages.web.user.contact_number_required')}}"
                    },
                address:{
                    required: "{{__('messages.web.user.address_required')}}"
                },
                bio:{
                    required: "{{__('messages.web.user.bio_required')}}"
                },
            },
            submitHandler: function(form){
               var img = $('#image64').val();
               if(img != '')
               {
                    $('#image-error1').hide();
                    form.submit();
               }
               else
               {
                    $('#image-error1').show();
               }                
            },            
        });
    });
    
    var $uploadCrop,
    rawImg;
    $(".profileImage").click(function(e) {
        $("#image").click();
    });
    $("#image").change(function(){
        readFile(this);
    });
    function readFile(input)
    {
        var fileimagevariable=input.files[0];
        // console.log(fileimagevariable);
        if(fileimagevariable.type.match('image.*'))
        {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                  
                    $('.upload-demo').addClass('ready');
                    $('#cropImagePop').modal('show');
                    rawImg = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        else
        {
            $('#image-error1').show();
        }
    }
    $uploadCrop = $('#upload-demo').croppie({
        viewport: {
            width: 250,
            height: 250,
            type:'circle'
        },
        boundary: {
            width: 400,
            height: 300
        },
        enforceBoundary: true,
        enableExif: true
    });
    $('#cropImagePop').on('shown.bs.modal', function () {
        $uploadCrop.croppie('bind', {
            url: rawImg
        }).then(function () {
        // console.log('jQuery bind complete');
        });
    });
    $('#cropImageBtn').on('click', function (ev) {
        $uploadCrop.croppie('result', {
            // type: 'base64',
            format: 'jpeg',
            // size: {width: 160, height: 100}
            type: "canvas", 
            size: 'viewport',
        }).then(function (resp) {
            console.log(resp);
            $('#image-error1').hide();
            $('#image64-error').hide();
            $('#profileImage').attr('src', resp);
            $('#image64').val(resp);
            $('#cropImagePop').modal('hide');
            // $('#image').val(''); 
        });
    });
    $('#cropImagePop').on('hidden.bs.modal', function () {
        $('#image').val(''); 
    })

//     let result = document.querySelector('#upload-demo'),
//     upload = document.querySelector('#image'),
//     cropped = document.querySelector('#image64'),
//     save = document.querySelector('#cropImageBtn'),
//     cropper = '';

//     // on change show image with crop options
// upload.addEventListener('change', (e) => {
//   if (e.target.files.length) {
// 		// start file reader
//     const reader = new FileReader();
//     reader.onload = (e)=> {
//       if(e.target.result){
//         $('.upload-demo').addClass('ready');
//         $('#cropImagePop').modal('show');
//         rawImg = e.target.result;
//         // create new image
//         let img = document.createElement('img');
//         img.id = 'image';
//         img.src = e.target.result
//         // clean result before
//         result.innerHTML = '';
//         // append new image
//         result.appendChild(img);
//         // init cropper
//         // cropper = new Cropper(img);
//         cropper = new Cropper(img, { 
//             aspectRatio: 250 / 250, 
//             minCropBoxWidth     : 250,
//             minCropBoxHeight    : 250,
//             minContainerWidth   : 440,
//             minContainerHeight  : 300,
//             minCanvasWidth      : 440,
//             minCanvasHeight     : 300,
//         });               
//       }
//     };
//     reader.readAsDataURL(e.target.files[0]);
//   }
// });

// // save on click
// save.addEventListener('click',(e)=>{
//   e.preventDefault();
//   // get result to data uri
//   let imgSrc = cropper.getCroppedCanvas({
//         width: 250,
//         height: 250
// 	}).toDataURL();
//     $('#profileImage').attr('src', imgSrc);
//     $('#image64').val(imgSrc);
//     $('#cropImagePop').modal('hide');
//     $('#image').val(''); 
// });
</script>
@endsection