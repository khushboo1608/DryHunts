@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row" style="margin-top: 15%;">
        <div class="col-lg-12" style="text-align: center;">
           <img src="{{config('global.static_image.admin_logo')}}">
        </div>
        <div class="col-lg-12" style="margin-top: 3%;">
            <h3 style="text-align: center;justify-content: center">{{__('messages.web.landing_page.title')}}</h3>
        </div>
    </div>
</div>
@endsection
