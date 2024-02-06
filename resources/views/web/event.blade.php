@extends('layouts.app')
@section('style')
   <style>
       .form-control {
            padding: 10px 43px 10px 20px !important;
        }
        
        /* Important part */
        .modal-dialog{
            overflow-y: initial !important
        }
        .modal-body{
            margin-top:20px;
            height: 70vh;
            overflow-y: auto;
        }
        .modal-dialog {
        width: 100%;
        margin: auto;
        }
        .modal{
        width: 100%; /* respsonsive width */
        /* margin-left:-40%; width/2)  */
        padding-top: 60px;
        }
        b, strong {
            color: black;
            font-size: 14px;
            font-weight: 800 !important;

        }
        p {
        font-size: 13px;
        }
        body{

            color: #212529;
        }
        .modal-ku {
            width: 750px;
            margin: auto;
        }
        /* TextRun SCXW253780193 BCX7 */
   </style>
@endsection
@section('content')
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
            <h6>Community Events</h6>
        </div>
    </nav>
</header>
    <!-- <section class="banner_image"> -->
    <!-- <section>
        <div class="banner_title">
            <h1>Community Events</h1>
        </div>
    </section> -->
    @if (session('message'))
        <div class="alert alert-success" id="success_message" role="alert">
            {{ session('message') }}
        </div>
    @endif
    @if(isset($event_data) && count($event_data) > 0)
        <section class="event_list">
            <div class="container">
                <div class="filter_nav">
                    <div class="form-group mb-0">
                        <input type="text" class="form-control search" id="search_keyword" name="search_keyword" placeholder="Search">
                    </div>
                    <a href="{{url('event/create_event')}}" class="btn btn-primary create_event_button">Create Event</a>
                </div>
                <div class="row" id="event_list">
                    @include('web.list-event')
                </div>
            </div>
        </section>
    @else
        <section class="event_list">
            <div class="container">
                <div class="filter_nav">
                    <div class="form-group mb-0"></div>
                    <a href="{{url('event/create_event')}}" class="btn btn-primary create_event_button">Create Event</a>
                </div>
                <span style="margin-top: 1%"><center><h1 style="color: #737373">No Community Events Found</h1></center></span>
            </div>
        </section>
    @endif
 <!-- Modal -->
        
    <div class="modal fade " id="tosModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <input type="hidden" name="is_tos_checked" id="is_tos_checked" value="{{ $is_tos_checked ? $is_tos_checked : '' }}">
                <div class="modal-body" id="tos">
                    @if(isset($tos) && $tos !='')          
                    {!!html_entity_decode($tos)!!}
                    @endif
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="acceptbtn">Accept</button>
                </div>
            </div>
        </div>
    </div>
@include('layouts.footer')

@endsection

@section('scripts')

 
<script type="text/javascript">
    var page = 1;
	$(window).scroll(function() {
	    if($(window).scrollTop() + $(window).height() >= $(document).height()) {
            var total_row = "{{$total_row}}";
            var per_page = 9;
            var pages = Math.ceil(total_row/per_page);
            console.log(pages+'__'+page);
            if(page < pages )
	        { 
                page++;
	            loadMoreData(page,'load');
            }
	    }
	});
    $(document).ready(function()
    {  
        var is_check = $('#is_tos_checked').val();
        if(is_check == 0){
            $('#tosModal').modal({backdrop: 'static', keyboard: false}, 'show');
            // $('.modal-body div').first().css("text-align", "center");
            $('.modal-body div:first-child').css("text-align", "center");
        }
        else{
            $('#tosModal').modal('hide');
        }
        $('#search_keyword').on('input',function(){
            loadMoreData(page,'search');
        });
        setTimeout(function() {
            $('#success_message').hide();
        }, 3000);
    });
	function loadMoreData(page,action)
    {
        
        var search = $('#search_keyword').val();
        if(search == '')
        {
            page = 1;
        }
	    $.ajax(
	        {
	            url: '?page=' + page + '&search_item='+search,
	            type: "get",
	            beforeSend: function()
	            {
	                $('.ajax-load').show();
	            }
	        })
	        .done(function(data)
	        {
                console.log(data);
	            if(data.html == ""){
	                $('.ajax-load').html("No more records found");
	                return;
	            }
	            $('.ajax-load').hide();
                if(action == 'load')
                {
                    $("#event_list").append(data.html);
                }
	            else
                {
                    $("#event_list").html(data.html);
                }
	        })
	        .fail(function(jqXHR, ajaxOptions, thrownError)
	        {
	              alert('server not responding...');
	        });
	} 
    
$('#acceptbtn').on('click', function() {
    
    $.ajax({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
        type: "post",
        data: {
            'is_tos_checked': 1
        },
        url: "{{url('/event/tos_accepted')}}",
        dataType: "JSON",
        success: function(data) {
            if(data.Data == true){
                // alert('true');
                // setTimeout(function() {
                    location.reload();
                // }, 5000);
            }
            else{
                // alert('false');
            }
        }
    });
    return false;
});
</script>
@endsection