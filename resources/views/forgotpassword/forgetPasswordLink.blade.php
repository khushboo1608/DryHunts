@extends('layouts.app')
@section('style')
<style>
    body {
        /* background-color: #d4590a; */
        color: #212529;
    }
    .invalid {
        color: #969696;
        display:block;
    }
    .valid {
        color: #0e0d0d;
    }
    #fpswd_info {
        display:block;
    }
</style>
    @endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12" style="text-align: center;">
            <img src="{{config('global.static_image.gray-text-logo')}}" alt="" style="height: 160px;
            border-radius: 50%; margin-top: 5%;">
           </div>
        <div class="col-md-8">
            <div class="card" style="margin-top: 5%;">
                <div class="card-header">{{ __('Reset Password') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('reset.password.post') }}" id="reset-form">
                        @csrf
                        @if (\Session::has('errormessage'))
                            <div class="alert alert-danger">
                                {!! \Session::get('errormessage') !!}
                            </div>
                            @elseif( isset($errormessage) != '' )
                            <div class="alert alert-danger">
                                {{$errormessage}}
                            </div>
                        @endif
                         <!-- @if (session('message'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('message') }}
                                    </div>
                                @endif -->
                        <input type="hidden" name="token" value="{{ isset($token) ? $token :'' }}">
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">New Password</label>
                            <div class="col-md-6">
                                <input type="password" id="password" minlength="6" class="form-control" name="password" required autofocus>
                                
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password</label>
                            <div class="col-md-6">
                                <input type="password" id="password-confirm" minlength="6" class="form-control" name="confirm_password" required autofocus>
                               
                            </div>
                        </div>
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="primary__btn w-200">
                                Reset Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

