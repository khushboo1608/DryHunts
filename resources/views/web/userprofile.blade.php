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
                    <h3 class="form-h3">Update Profile</h3>
                    <form id="post-form" method="post" action="{{ route('saveProfile')}}" enctype="multipart/form-data">
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
                                <input type="hidden" name="id" id="id"  value="{{$UserData->id}}"> 
                        <div class="checkout__input--list mb-20 form-group">
                            <input id="name" type="text" class="checkout__input--field border-radius-5  @error('name') is-invalid @enderror" name="name" placeholder="Enter Your Name" required  autofocus value="{{$UserData->name}}">
                        </div>
                        <div class="checkout__input--list mb-20 form-group">
                            <input id="email" type="email" class="checkout__input--field border-radius-5  @error('email') is-invalid @enderror" name="email" autofocus value="{{$UserData->email}}" placeholder="Enter Your Email" required  autofocus>
                        </div>

                        <!-- <div class="checkout__input--list mb-20 form-group">
                            <input class="checkout__input--field border-radius-5" placeholder="Enter Your Password" id="password" name="password" type="password" minlength="6" >
                        </div> -->
                        <div class="checkout__input--list mb-20 form-group">
                            <input class="checkout__input--field border-radius-5 @error('phone') is-invalid @enderror" placeholder="Enter Your Phone" id="phone" name="phone" value="{{$UserData->phone}}" maxlength="10" type="number" required disabled>
                        </div>
                        <div class="checkout__input--list mb-20 form-group">
                            <input class="checkout__input--field border-radius-5 padding-11" id="imageurl" name="imageurl"  type="file" accept="image/png, image/jpeg, image/jpg">
                        </div>
                        <div class="checkout__input--list mb-20 form-group">
                            <select name="state_id" id="state_id" class="checkout__input--field border-radius-5 @error('state_id') is-invalid @enderror" required>
                            <option selected="true" disabled="disabled">Select State</option>   
                                @if(isset($master_data) && isset($master_data['state']))
                                    @foreach ($master_data['state'] as $item)
                                    <option value="{{ $item['state_id'] }}" {{ ( $item['state_id'] == $UserData['state_id']) ? 'selected' : '' }}> {{$item['state_name']}} </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="checkout__input--list mb-20 form-group">
                            <select name="district_id" id="district_id" class="checkout__input--field border-radius-5 @error('district_id') is-invalid @enderror" required>
                            <option value="0">--Select District--</option>
                                      @foreach($master_data['district'] as $list)
                                          @if( $UserData['district_id']==$list['district_id'])
                                              <option selected value="{{$list['district_id']}}">{{$list['district_name']}}</option>
                                          @else
                                              <option  value="{{$list['district_id']}}">{{$list['district_name']}}</option>
                                          @endif
                                      @endforeach
                            </select>
                        </div>
                        <div class="checkout__input--list mb-20 form-group">
                            <select name="taluka_id" id="taluka_id" class="checkout__input--field border-radius-5 @error('taluka_id') is-invalid @enderror" required>
                            <option value="0">--Select Taluka--</option>
                                      @foreach($master_data['taluka'] as $list)
                                          @if( $UserData['taluka_id']==$list['taluka_id'])
                                              <option selected value="{{$list['taluka_id']}}">{{$list['taluka_name']}}</option>
                                          @else
                                              <option  value="{{$list['taluka_id']}}">{{$list['taluka_name']}}</option>
                                          @endif
                                      @endforeach
                            </select>
                        </div>
                        <div class="checkout__input--list mb-20 form-group">
                            <select name="pincode_id" id="pincode_id" class="checkout__input--field border-radius-5 @error('pincode_id') is-invalid @enderror" required>
                            <option value="0">--Select Pincode--</option>
                                      @foreach($master_data['pincode'] as $list)
                                          @if( $UserData['pincode_id']==$list['pincode_id'])
                                              <option selected value="{{$list['pincode_id']}}">{{$list['pincode']}}</option>
                                          @else
                                              <option  value="{{$list['pincode_id']}}">{{$list['pincode']}}</option>
                                          @endif
                                      @endforeach
                            </select>
                        </div>
                        <div class="checkout__input--list mb-20 form-group">
                            <input class="checkout__input--field border-radius-5 @error('gst_number') is-invalid @enderror" placeholder="Enter Your GST Number" id="gst_number" name="gst_number" type="text" required value="{{$UserData->gst_number}}">
                        </div>
                        <button type="submit" class="primary__btn w-200" id="submit" value="Submit">Submit</button>
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
        $('#post-form').validate({ // initialize the plugin
            rules: {
                imageurl: {
                    accept:"jpg,png,jpeg",
                },
                name:{
                    noSpace: true,
                    required: true
                    },
                state_id:{
                    noSpace: true,
                    required: true,
                    },
                district_id:{
                    noSpace: true,
                    required: true,
                    },
                taluka_id:{
                    noSpace: true,
                    required: true,
                    },
                pincode_id:{
                    noSpace: true,
                    required: true,
                    },
                email: {
                    noSpace: true,
                    required: true,
                    email: true
                },
                password: {
                    noSpace:true,
                },
                phone:{
                    noSpace: true,
                    required: true,
                    },
                gst_number:{
                    noSpace: true,
                    required: true,
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
                imageurl:{
                    required: "{{__('messages.web.user.profile_photo_required')}}",
                    // accept:"Please upload jpg,png,jpeg image only",
                },
                name:{
                    required: "{{__('messages.web.user.name_required')}}"
                    },
                state_id:{
                    required: "{{__('messages.web.user.state_id_required')}}"
                    },
                district_id:{
                    required: "{{__('messages.web.user.district_id_required')}}"
                    },
                taluka_id:{
                    required: "{{__('messages.web.user.taluka_id_required')}}"
                    },
                pincode_id:{
                    required: "{{__('messages.web.user.pincode_id_required')}}"
                    },
                email: {
                    required: "{{__('messages.web.user.email_required')}}",
                    email: "{{__('messages.web.user.email_format')}}"
                },
                password: {
                    required: "{{__('messages.web.user.password_required')}}"
                },
                phone:{
                    required: "{{__('messages.web.user.phone_number_required')}}"
                    },
                gst_number:{
                    required: "{{__('messages.web.user.gst_number_required')}}"
                }
            },
            submitHandler: function(form){
              
                    form.submit();
            },
            
        });
    });

    // Listen for changes in the first dropdown
    // $('#district_id').html("<option value='' selected disabled>--Select District--</option>");
      $('#state_id').on('change', function() {
        // alert('This works');
          var selectedValue = $(this).val();
            
          // Make an Ajax request
          $.ajax({
              // url: '/admin/advertisementbanner/get-dropdown-options',
              url : '{{url("/get-dropdown-options")}}',
              type: 'GET',
              data: { selectedValue: selectedValue },
              success: function(data) {
                  // Clear existing options in the second dropdown
                  $('#district_id').empty();
                  $('#district_id').html("<option value='' selected disabled >--Select District--</option>");
                  // Populate the second dropdown with the retrieved options
                  $.each(data, function(key, value) {
                      $('#district_id').append($('<option>', {
                          value: key,
                          text: value
                      }));
                  });
              }
          });
      });

      
    //   $('#taluka_id').html("<option value='' selected disabled>--Select Taluka--</option>");
      $('#district_id').on('change', function() {
          var selectedValue1 = $(this).val();

          // Make an Ajax request
          $.ajax({
              // url: '/admin/advertisementbanner/get-dropdown-options',
              url : '{{url("get-dropdown-taluka-options")}}',
              type: 'GET',
              data: { selectedValue1: selectedValue1 },
              success: function(data) {
                  // Clear existing options in the second dropdown
                  $('#taluka_id').empty();
                  $('#taluka_id').html("<option value='' selected disabled >--Select Taluka--</option>");
                  // Populate the second dropdown with the retrieved options
                  $.each(data, function(key, value) {
                      $('#taluka_id').append($('<option>', {
                          value: key,
                          text: value
                      }));
                  });
              }
          });
      });

      
    //   $('#pincode_id').html("<option value='' selected disabled>--Select Pincode--</option>");
      $('#taluka_id').on('change', function() {
          var selectedValue2 = $(this).val();

          // Make an Ajax request
          $.ajax({
              // url: '/admin/advertisementbanner/get-dropdown-options',
              url : '{{url("get-dropdown-pincode-options")}}',
              type: 'GET',
              data: { selectedValue2: selectedValue2 },
              success: function(data) {
                  // Clear existing options in the second dropdown
                  $('#pincode_id').empty();
                  $('#pincode_id').html("<option value='' selected disabled >--Select Pincode --</option>");
                  // Populate the second dropdown with the retrieved options
                  $.each(data, function(key, value) {
                      $('#pincode_id').append($('<option>', {
                          value: key,
                          text: value
                      }));
                  });
              }
          });
      });
</script>
@endsection
