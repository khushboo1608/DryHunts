@extends('layouts.app')
@section('style')
{{-- <link rel="stylesheet" href="{{url('public/web/css/jquery-ui.css')}}">
<link rel="stylesheet" href="{{url('public/web/css/jquery-ui.multidatespicker.css')}}"> --}}
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<style>
    #upload-demo {
        width: 100%;
        height: 250px;
        padding-bottom: 25px;
    }
    #outer
    {
        width:100%;
        text-align: center;
    }
    .inner
    {
        display: inline-block;
    }
    .clockpicker-am-pm-block{
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .pm-button{
        min-width: 58px;
    }
    .am-button{
        min-width: 58px;
    }
    .clockpicker-popover .text-primary{
        color: #FF9500 !important;
    }
    .clockpicker-popover  .text-primary{
        color: #FF9500 !important;
    }
    .clockpicker-canvas line {
        stroke: #FF9500 !important;
    }
    .clockpicker-canvas-bearing, .clockpicker-canvas-fg {
        fill: #FF9500 !important;
    }
    .clockpicker-canvas-bg {
        fill: #FF9500 !important;
    }
    .clockpicker-tick.active, .clockpicker-tick:hover {
        background-color: rgb(255 149 0 / 50%) !important;
    }  
    .btn{
        display: inline-flex;
    }
</style>
@endsection
@section('content')
    <!-- <section class="banner_image"> -->
     <!-- <section > 
        <div class="banner_title">
            <h1>Create Event</h1>
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
                <h6>Create Event</h6>
            </div>
        </nav>
    </header>
    <section class="create_event">
        <div class="container">
            <div class="event_create_card">
                <form id="event-form" method="post" action="{{ url('event/insert_event')}}" enctype="multipart/form-data">
                    @csrf
                    @if (session('message'))
                        <div class="alert alert-success" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif
                    <div class="form-group upload_event_image">
                        <label for="">Upload Event Image </label>
                        <div class="upload_event_image_details" style="cursor: pointer;">
                            {{-- <img id="event_img" src="" alt="" style="width: 350px;height: 250px;display: none"> --}}
                            <img id="event_img" src="" alt="" style="width: 385px;height: 256px;display: none;border-radius:3%;object-fit: cover;">
                            <p id="event_img_txt">Upload Image</p>
                        </div>
                        <span id="image-error1" class="error invalid-feedback" style="font-weight: bold; display: none;">{{__('messages.web.only_image_validation')}}</span>
                        <input id="image" class="image" type="file" name="image" accept="image/png, image/jpg, image/jpeg">
                        <input id="image64" type="hidden" name="image64" class="image64">
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group label-floating">
                            <label for="title">Event Name</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Enter Event Name">
                        </div>
                    </div>                    
                    <div class="form-group">
                        <label for="">Recurring Scheduling Options</label>
                        <select class="form-control" id="selectRecurrence" name="selectRecurrence">
                          <option value="none" disabled="disabled">Choose Scheduling Option</option>
                          
                          <option value="1">Single </option>
                          <option value="2">Recurrence </option>
                          <option value="3">Range </option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group label-floating">
                            <label for="event_date" class="control-label">Date</label>
                            <input type="text" id="event_date" name="event_date" class="form-control" data-dtp="dtp_Xdd8H" placeholder="Date" autocomplete="off">
                        </div>
                        <div class="col-md-3 form-group label-floating">
                            <label for="event_start_time" class="control-label">Start Time</label>
                            {{-- <input type="text" id="event_start_time" name="event_start_time" class="form-control" data-dtp="dtp_Xdd8H" placeholder="Start Time">--}}
                            <input type="text" id="event_start_time" name="event_start_time" class="form-control" placeholder="Start Time">                            <span id="event_start_time-error1" class="error invalid-feedback" style="font-weight: bold;display: none">You can not select past time for event</span>
                        </div>
                        <div class="col-md-3 form-group label-floating">
                            <label for="event_end_time" class="control-label">End Time</label>
                            <input type="text" id="event_end_time" name="event_end_time" class="form-control" data-dtp="dtp_Xdd8H" placeholder="End Time">
                        </div>
                    </div>
                    <div class="row">
                         @if(isset($master_data) && isset($master_data['org']))
                               
                               
                        <div class="col-md-6 form-group label-floating">
                            <label for="org_name" class="control-label">Organizer's Name</label>
                            <input type="text"  id="org_name" name="org_name" class="form-control" data-dtp="dtp_Xdd8H" placeholder="Organizer's Name" value="{{$master_data['org']->user_org_data->organization_name}}" autocomplete="off">
                        </div>
                        <div class="col-md-3 form-group label-floating">
                            <label for="phone_no" class="control-label">Phone Number</label>
                           <input type="text"  id="phone_no" name="phone_no" class="form-control" placeholder="Phone Number" value="{{$master_data['org']->user_org_data->contact_no}}">                            <span id="event_start_time-error1" class="error invalid-feedback" style="font-weight: bold;display: none">You can not select past time for event</span>
                        </div>
                        <div class="col-md-3 form-group label-floating">
                            <label for="org_email" class="control-label">Email</label>
                            <input type="text"  id="org_email" name="org_email" class="form-control" data-dtp="dtp_Xdd8H" placeholder="Email" value="{{$master_data['org']->email}}">
                        </div>
                    </div>
                    @endif
                    <div class="row">
                        <div class="col-md-6 form-group" id="Repeatdiv" style="display: none">
                            <label for="">Repeat every</label>
                            <select class="form-control" id="selectRepeat" name="frequency">
                              <option value="1">Daily</option>
                              <option value="2">Weekly</option>
                              <option value="3">Monthly</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group label-floating" id="weekdiv" style="display: none">
                            <label for="time" class="control-label">Repeat on</label>
                            <div class="weekly">
                                <label class="week_check">
                                    <input type="checkbox" name="frequency_day[]" value="0">
                                    <span class="checkmark">S</span>
                                </label>
                                <label class="week_check">
                                    <input type="checkbox" name="frequency_day[]" value="1">
                                    <span class="checkmark">M</span>
                                </label>   
                                <label class="week_check">
                                    <input type="checkbox" name="frequency_day[]" value="2">
                                    <span class="checkmark" >T</span>
                                </label>
                                <label class="week_check">
                                    <input type="checkbox" name="frequency_day[]" value="3">
                                    <span class="checkmark">W</span>
                                </label>
                                <label class="week_check">
                                    <input type="checkbox" name="frequency_day[]" value="4">
                                    <span class="checkmark">T</span>
                                </label>
                                <label class="week_check">
                                    <input type="checkbox" name="frequency_day[]" value="5">
                                    <span class="checkmark">F</span>
                                </label>
                                <label class="week_check">
                                    <input type="checkbox" name="frequency_day[]" value="6">
                                    <span class="checkmark">S</span>
                                </label>
                          </div>
                        </div>
                        <div class="col-md-6 form-group label-floating" id="monthdiv" style="display: none">
                            <label for="time" class="control-label">Repeat on</label>
                            <select class="form-control" id="exampleFormControlSelect1" name="frequency_month">
                                <option value="0">{{"Select day"}}</option>
                                @for($i = 1; $i<=31; $i++)
                                    <option value="{{$i}}">{{"Monthly on day".$i}}</option>
                                @endfor
                                {{-- <option >Monthly on day 1</option> --}}
                            </select>
                        </div>
                    </div>  
                    <div class="row">
                        <div class="col-md-12 form-group label-floating">
                            <label for="chklink">
                                <input type="checkbox" id="virtual_check" name="virtual_check" />
                                If Virtual Event
                            </label>
                        </div>
                    </div>                                        
                    <div class="row">
                        <div class="col-md-12 form-group label-floating" id="locationdiv" style="display: block">
                            <label for="">Location</label>
                            <input type="text" class="form-control" id="address" name="address" placeholder="Address">
                            <div id="map" style="display: none"></div>
                            <input type="hidden" name="latitude" id="latitude">
                            <input type="hidden" name="longitude" id="longitude">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group label-floating" id="event_link_div" style="display: none">
                            <label for="">Virtual Event Link</label>
                            <input type="text" class="form-control" id="event_link" name="event_link" placeholder="Virtual Event Link">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6 label-floating">
                            <label for="category_id">Choose Category</label>
                            <select class="form-control" id="category_id" name="category_id">
                                <option value="">Choose Category</option>
                                @if(isset($master_data) && isset($master_data['category']))
                                    @foreach ($master_data['category'] as $item)
                                        <option value="{{$item['category_id']}}">{{$item['category']}}</option>
                                    @endforeach
                                    <option value="other">Other</option>
                                @endif
                            </select>
                        </div>
                        <div class="col-md-3 form-group label-floating">
                            <label for="cost_type">Cost Type</label>
                            <select class="form-control" id="cost_type" name="cost_type">
                                <option value="1">Free</option>
                                <option value="2">Varies</option>
                                <option value="3">Actual cost or range</option>
                            </select>
                        </div>
                        <div class="col-md-3 form-group label-floating">
                            <label for="cost">Cost</label>
                            <input type="text" class="form-control" id="cost" name="cost" placeholder="Cost">
                        </div>
                    </div>
                    <div class="row" id="other_category_div" style="display: none">
                        <div class="form-group col-md-12 label-floating">
                            <label for="other_category">Other Category</label>
                            <input type="text" name="other_category" id="other_category" class="form-control" placeholder="Other Category">
                        </div>
                    </div>                    
                    <div class="row">
                        <div class="col-md-12 form-group label-floating">
                            <label for="description">Description </label>
                            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Type Here..."></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group label-floating">
                            <label for="chklink">
                                <input type="checkbox" id="reg_check" name="reg_check" />
                                If registration link
                            </label>
                        </div>
                    </div>                                        
                    <div class="row">
                        <div class="col-md-12 form-group label-floating" id="registration_div" style="display: none">
                            <label for="">Registration Link</label>
                            <input type="text" class="form-control" id="registration_link" name="registration_link" placeholder="Registration Link">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group label-floating">
                            <label for="age_id">Age</label>
                            <select class="form-control js-example-basic-multiple_age" id="age_id" name="age_id[]" multiple="multiple">
                                @if(isset($master_data) && isset($master_data['age']))
                                    @foreach ($master_data['age'] as $item)
                                        <option value="{{$item['age_id']}}">{{$item['age']}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-md-6 label-floating">
                            <label for="attendee_type_id">Choose Attendee Type(s) </label>
                            <select class="form-control js-example-basic-multiple_attendee_type" id="attendee_type_id" name="attendee_type_id[]" multiple="multiple">
                              {{-- <option value="1">All</option> --}}
                              <option value="2">Survivors</option>
                              <option value="3">Impacted</option>
                              <option value="4">Children</option>
                              <option value="5">Pets</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group label-floating">
                            <label for="">Tags</label>
                            <select class="form-control js-example-basic-multiple" id="tag_id" name="tag_id[]" multiple="multiple">
                                <option value="">Choose Tags(s)</option>
                                @if(isset($master_data) && isset($master_data['tag']))
                                    @foreach ($master_data['tag'] as $item)
                                        <option value="{{$item['tag_id']}}">{{$item['tag']}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="">Choose Cancer Type(s)</label>
                            <select class="form-control js-example-basic-multiple_cancer" id="cancer_type_id" name="cancer_type_id[]" multiple="multiple">
                                @if(isset($master_data) && isset($master_data['cancer_type']))
                                    @foreach ($master_data['cancer_type'] as $item)
                                        <option value="{{$item['cancer_type_id']}}">{{$item['cancer_type']}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>                                           
                    <div id="outer">
                        <a href="{{route('event')}}" data-inline="true" class="btn btn-primary mx-auto mt-5 inner">Cancel</a>
                        <button type="submit" data-inline="true" id="send_form" class="btn btn-primary mx-auto mt-5 inner">Save</button> 
                    </div>
                </form>
            </div>
        </div>
    </section>
    <div class="modal fade" id="cropImagePop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" style="width: 100%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"></h4>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.5.10/js/ripples.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.5.10/js/material.min.js"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyBzW6oaNiZ2CM6ct7hmRtp9EyI8Pv1qFNU&callback=initMap"></script>

<script type="text/javascript">
    jQuery.validator.addMethod("past_time", function(value, element)
    {
        var current_date = new Date();
        var selected_date = $('#event_date').val();
        var curr_day = ('0' + current_date.getDate()).slice(-2);
        var curr_month = ('0' + (current_date.getMonth()+1)).slice(-2);
        var curr_year = current_date.getFullYear();
        var curr_date = curr_year+'-'+curr_month+'-'+curr_day;
        var hour =  current_date.getHours();
        var minute =  current_date.getMinutes();
        var ampm = (hour >= 12) ? "PM" : "AM";
        if(curr_date == selected_date)
        {
            console.log('in');
            
            if (hour.toString().length < 2) hour = '0' + hour;
            if (minute.toString().length < 2) minute = '0' + minute;

            var current_time = hour +':'+ minute + ampm;
            var selected_start_time = moment($('#event_start_time').val(), 'hh:mm A').format('HH:mm');
            return selected_start_time > current_time;
        }
        return true;
    }, "Please select proper start time");

    jQuery.validator.addMethod("greater_than", function(value, element) {
        var current_date = new Date();
        var selected_date = $('#event_date').val();
        var curr_day = ('0' + current_date.getDate()).slice(-2);
        var curr_month = ('0' + (current_date.getMonth()+1)).slice(-2);
        var curr_year = current_date.getFullYear();
        var curr_date = curr_year+'-'+curr_month+'-'+curr_day;
        var hour =  current_date.getHours();
        var minute =  current_date.getMinutes();
        var ampm = (hour >= 12) ? "PM" : "AM"; 
        
        if(curr_date == selected_date)
        {
            console.log('if');
            if (hour.toString().length < 2) hour = '0' + hour;
            if (minute.toString().length < 2) minute = '0' + minute;

            var current_time = hour +':'+ minute + ampm;
            var selected_end_time = moment($('#event_end_time').val(), 'hh:mm A').format('HH:mm');
            var selected_start_time = moment($('#event_start_time').val(), 'hh:mm A').format('HH:mm');
            return selected_end_time > current_time && selected_start_time < selected_end_time ;
        }
        else
        {            
            var current_time = current_date.getHours()+':'+current_date.getMinutes();
            var selected_end_time = moment($('#event_end_time').val(), 'hh:mm A').format('HH:mm');
            var selected_start_time = moment($('#event_start_time').val(), 'hh:mm A').format('HH:mm');
            return selected_start_time < selected_end_time ;
        }
    }, "Please select proper end time");

    jQuery.validator.addMethod("virtual_link", function(value, element)
    {
        var checkbox_selected = $('input[name="virtual_check"]:checked');
        var txtval = $('#event_link').val();
        if(checkbox_selected == 1 || txtval != '')
        {            
            return true;
        }
    }, "Please enter virtual event link");

    jQuery.validator.addMethod("reg_link", function(value, element)
    {
        var checkbox_selected = $('input[name="reg_check"]:checked');
        var txtval = $('#registration').val();
        if(checkbox_selected == 1 || txtval != '')
        {            
            return true;
        }
    }, "Please enter registration link");

    jQuery.validator.addMethod("address_select", function(value, element)
    {
        var checkbox_selected = $('input[name="virtual_check"]:checked');
        if(checkbox_selected.length == 0){
            return true;
        }
    }, "Please enter event address");

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
    $(document).ready(function()
    {  
        $(".daterangepicker .drp-buttons .applyBtn").html('Save');
        $("#virtual_check").click(function () {
            if ($(this).is(":checked")) {
                $("#event_link_div").show();
                $("#locationdiv").hide();
            } else {
                $("#event_link_div").hide();
                $("#locationdiv").show();
            }
        });

        $("#reg_check").click(function () {
            if ($(this).is(":checked")) {
                $("#registration_div").show();
            } else {
                $("#registration_div").hide();
            }
        });

        $('input[name="event_date"]').daterangepicker({
                    "autoapply": true,
                    autoUpdateInput: false,
                    singleDatePicker: true,
                    minDate:new Date(),
                    locale: {
                        cancelLabel: 'Clear',
                        applyLabel: 'Select'
                    },
                });
                $('input[name="event_date"]').on('apply.daterangepicker', function(ev, picker) {
                    $(this).val(picker.startDate.format('YYYY-MM-DD') );
                });

                $('input[name="event_date"]').on('cancel.daterangepicker', function(ev, picker) {
                    $(this).val('');
                });  
                
            $('#selectRecurrence').on('change', function() {
            if ( this.value == '1')
            {
                $("#Repeatdiv").hide();
                $("#weekdiv").hide();
                
                $('input[name="event_date"]').val('');
                $('input[name="event_date"]').daterangepicker({
                    "autoapply": true,
                    autoUpdateInput: false,
                    singleDatePicker: true,
                    minDate:new Date(),
                    locale: {
                        cancelLabel: 'Clear',
                        applyLabel: 'Select'
                    },
                });
                $('input[name="event_date"]').on('apply.daterangepicker', function(ev, picker) {
                    $(this).val(picker.startDate.format('YYYY-MM-DD') );
                });

                $('input[name="event_date"]').on('cancel.daterangepicker', function(ev, picker) {
                    $(this).val('');
                }); 
            }
            else
            {
                $("#Repeatdiv").show();
                // $("#weekdiv").show();
                $("#weekdiv").hide();
                $('input[name="event_date"]').val('');
                $('input[name="event_date"]').daterangepicker({
                    "autoapply": true,
                    autoUpdateInput: false,
                    minDate:new Date(),
                    locale: {
                        cancelLabel: 'Clear',
                        applyLabel: 'Select'
                    },
                });
                $('input[name="event_date"]').on('apply.daterangepicker', function(ev, picker) {
                    $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
                });

                $('input[name="event_date"]').on('cancel.daterangepicker', function(ev, picker) {
                    $(this).val('');
                });  
            }            
        });  
        
        $('#selectRepeat').on('change', function() {
            if ( this.value == '2')
            {
                $("#weekdiv").show();
                $("#monthdiv").hide();
            }
            else if(this.value == '3')
            { 
                $("#weekdiv").hide();
                $("#monthdiv").show();
            }
            else{
                $("#weekdiv").hide();
                $("#monthdiv").hide();
            }            
        }); 

        $("#event_start_time").clockpicker({
            donetext: 'Okay',
            twelvehour: true,
            fromnow	:0,
            autoclose:true,
            afterDone: function() {
                // var shortText = $("#event_start_time").val().slice(0, -2);   
                // // console.log(shortText); 
                // $("#event_start_time").val(shortText);
            }
        });
        
        $("#event_end_time").clockpicker({
            donetext: 'Okay',
            twelvehour: true,
            fromnow	:0,
            autoclose:true,
            afterDone: function() {
                // var endtime = $("#event_end_time").val().slice(0, -2); 
                // // var time = $("#event_end_time").val();
                // // console.log(endtime);                        
                // $("#event_end_time").val(endtime);
            }
        });

        $('.js-example-basic-multiple').select2({
            placeholder: "Select a tag",
            tags: true,
        });
        $('.js-example-basic-multiple_cancer').select2({
            placeholder: "Select a cancer type",
            tags: true
        });
        $('.js-example-basic-multiple_age').select2({
            placeholder: "Select a age",
            tags: true
        });
        $('.js-example-basic-multiple_attendee_type').select2({
            placeholder: "Select a attendee type",
            tags: true
        });      
        $('#tag_id').on('select2:select', function (e) { 
            var select_val = $(e.currentTarget).val();
            var data = e.params.data.id;
            $('#tag_id-error').hide();
        });
        $('#cancer_type_id').on('select2:select', function (e) { 
            var select_val = $(e.currentTarget).val();
            var data = e.params.data.id;
            if(data == 'all')
            {
                $("#cancer_type_id > option").prop("selected","selected");
                // $('#cancer_type_id option[value="all"]').prop('selected', false);
                $("#cancer_type_id").trigger("change");
            }
            $('#cancer_type_id-error').hide();
        });
        $('#attendee_type_id').on('select2:select', function (e) { 
            var select_val = $(e.currentTarget).val();
            var data = e.params.data.id;
            if(data == '1')
            {
                $("#attendee_type_id > option").prop("selected","selected");
                $("#attendee_type_id").trigger("change");
            }
            $('#attendee_type_id-error').hide();
        });
        $('#age_id').on('select2:select', function (e) { 
            var select_val = $(e.currentTarget).val();
            var data = e.params.data.id;
            if(data == 'all')
            {
                $("#age_id > option").prop("selected","selected");
                $("#age_id").trigger("change");
            }
            $('#age_id-error').hide();
        });
        $('#category_id').on('change',function($q) {
            var val = $(this).val();
            if(val == 'other')
            {
                $('#other_category_div').show();
            }
            else
            {
                $('#other_category_div').hide();
            }
        });
        $("#cost").attr("readonly", true);
                $("#cost").val(0);
        $('#cost_type').on('change',function($q) {
            var val = $(this).val();
            console.log(val);
            if(val == '1' || val == '2')
            {
                $("#cost").attr("readonly", true);
                $("#cost").val(0);
            }
            else
            {
                $("#cost").attr("readonly", false);
                $("#cost").val(1);
            }
        });
        $('#event-form').validate({ // initialize the plugin
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
                },
                title:{
                    noSpace: true,
                    required: true
                },
                event_date:{
                    noSpace: true,
                    required: true,                   
                },
                event_start_time: {
                    noSpace: true,
                    required: true,
                    past_time:true
                },
                event_end_time: {
                    required: true,
                    noSpace:true,
                    greater_than:true
                },
                address:{
                    noSpace: true,
                    required: true,
                    // address_select: true,
                },
                event_link:{
                    virtual_link:true,
                    url: true
                },
                category_id:{
                    required: true
                },
                other_category:{
                    noSpace: true,
                    required: true,
                },
                "attendee_type_id[]":{
                    required: true
                },
                "age_id[]":{
                    required: true
                },
                cost_type:{
                    required: true,
                },
                cost:{
                    required: true,
                    number:true,
                    min:0,
                    maxlength:6
                },
                description:{
                    noSpace: true,
                    required: true
                },
                registration_link:{
                    reg_link:true,
                    url: true
                },
                
                "tag_id[]":{
                    required: true
                },
                "cancer_type_id[]" :{
                    required: true
                },
            },
            errorElement: 'span',
            errorPlacement: function (error, element) { 
                error.addClass('invalid-feedback');               
                element.closest('.form-group').append(error);
                $('.error').css("font-weight", "bold");            
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');                
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            },
            messages: {
                image64:{
                    required: "{{__('messages.web.event.photo_required')}}",
                },
                title:{
                    required: "{{__('messages.web.event.title_required')}}"
                },
                event_date:{
                    required: "{{__('messages.web.event.date_required')}}"
                },
                event_start_time: {
                    required: "{{__('messages.web.event.start_time_required')}}",
                },
                event_end_time: {
                    required: "{{__('messages.web.event.end_time_required')}}",
                },
                event_link:{
                    url: "{{__('messages.web.event.valid_link')}}",
                },
                address:{
                    required: "{{__('messages.web.event.address_required')}}"
                },
                category_id:{
                    required: "{{__('messages.web.event.category_required')}}"
                },
                other_category:{
                    required: "{{__('messages.web.event.other_category_required')}}"
                },
                "attendee_type_id[]":{
                    required: "{{__('messages.web.event.attendee_required')}}"
                },
                "age_id[]":{
                    required: "{{__('messages.web.event.age_required')}}"
                },
                cost:{
                    required: "{{__('messages.web.event.cost_required')}}",
                    min: "{{__('messages.web.event.valid_cost')}}",
                },
                cost_type:{
                    required: "{{__('messages.web.event.cost_type_required')}}",
                },
                description:{
                    required: "{{__('messages.web.event.description_required')}}"
                },
                registration_link:{
                    url: "{{__('messages.web.event.valid_link')}}",
                },
                "tag_id[]":{
                    required: "{{__('messages.web.event.tag_required')}}"
                },
                "cancer_type_id[]":{
                    required: "{{__('messages.web.event.cancer_type_required')}}"
                },               
            },
            submitHandler: function(form){
                
               var img = $('#image64').val();
               if(img != '')
               {
                    $("#send_form").attr("disabled", true);
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
    //  $('#upload-demo').croppie('destroy');
    var $uploadCrop,
    rawImg;
    $(".upload_event_image_details").click(function(e) {
        $("#image").click();
    });
    $("#image").change(function(){
        readFile(this);
    });
    function readFile(input)
    {
        var fileimagevariable=input.files[0];
        console.log(fileimagevariable);
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
            // alert('hi');
            $('#image64-error').hide();
            $('#image-error1').html('Please upload jpg,png,jpeg image only');
            $('#image-error1').show();
        }
    }
    $uploadCrop = $('#upload-demo').croppie({
        viewport: {
            width: 350,
            height: 250,
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
            // console.log(resp);
            $('#image-error1').hide();
            $('#image64-error').hide();
            $('#event_img_txt').hide();
            $('#event_img').attr('src', resp);
            $('#event_img').show();
            $('#image64').val(resp);
            $('#cropImagePop').modal('hide');
            // $('#image').val(''); 
        });
    });
    $('#cropImagePop').on('hidden.bs.modal', function () {
        $('#image').val(''); 
    })
</script>
@endsection