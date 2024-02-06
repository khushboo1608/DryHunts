@extends('layouts.app')
@section('style')
   <style>
       .user_h5{
            padding-left: 10px;
        }
        section.create_event { min-height: calc(100vh - 132px) !important; height: inherit !important; }
   </style>
@endsection
@section('content')
<!-- <section class="banner_image"> -->
<!-- <section>
    <div class="banner_title">
        <h1>Users Data</h1>
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
            <h6>Users Data</h6>
        </div>
    </nav>
</header>
<section class="create_event" style="height: 636px;">
    <div class="container">
        <div class="event_create_card">
            <div class="wrapper wrapper-content">
                <div class="row">
                    <div class="col-md-4">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title" style="background-color :#abdbe3;color:white">
                                <h5 class="user_h5">Total Users</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins" style="color: #AA0E3A;padding-left: 10px;">{{$user_count}}</h1>
                                <small>Total Users</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title" style="background-color :#abdbe3;color:white">
                                <h5 class="user_h5">Online Users</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins" style="color: #AA0E3A;padding-left: 10px;">{{$online_count}}</h1>
                                <small>Total Users</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title" style="background-color :#abdbe3;color:white">
                                <h5 class="user_h5">Offline Users</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins" style="color: #AA0E3A;padding-left: 10px;">{{$offline_count}}</h1>
                                <small>Total Users</small>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="col-md-3">
                        <div class="ibox float-e-margins">
                            
                            <div class="ibox-title" style="background-color :#abdbe3;color:white">
                                <h5 class="user_h5">Users Registerlink Count</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins" style="color: #AA0E3A;padding-left: 10px;">{{$offline_count}}</h1>
                                <small>Total Count</small>
                            </div>
                        </div>
                    </div> -->

                </div>
            </div>
        </div>
    </div>
</section>
@include('layouts.footer')
@endsection