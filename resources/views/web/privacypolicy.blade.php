@extends('layouts.app')
@section('content')
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KNK2NX9"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
@include('layouts.header')
<main class="main__content_wrapper">
    <div class="container" style="margin-top: 50px; margin-bottom:50px;">
        <!-- <div class="row justify-content-center">
            <div class="col-xl-6 col-sm-12 col-md-12 col-lg-6">-->
                <!-- <div class="main-address-box text-center">  -->
                    <!-- <h3 class="form-h3">Privacy Policy</h3> -->
                    <h1 class="success-title text-center">Privacy Policy</h1>
                    <!-- <div class="blog__details--content"> -->
                    <p class="sub-title-success text-center"> {!! $SettingsData->app_privacy_policy !!}
                </p>
                           
                            
                        <!-- </div> -->
                <!-- </div>
            </div>
        </div> -->
    </div>
</main>
@include('layouts.footer')
@endsection
