@extends('layouts.app')
@section('content')
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KNK2NX9"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
@include('layouts.header')
<main class="main__content_wrapper">
    <section class="thank-you__page--area section--padding">
        <div class="container">
        @if (session('message'))
        <div class="alert alert-success" id="success_message" role="alert">
            {{ session('message') }}
        </div>
    @endif
            <img src="./assets/img/thank-you.jpg" class="thank-you">
            <!-- <h2 class="success-title text-center">Thank you! Your order have been scucessfully placed. We would love to serve you.</h2> -->
            <!-- <p class="sub-title-success text-center">Explore us and get amazing offers.</p>
            <div class="d-flex align-items-center justify-content-center gap-10">
             <div class="product__variant--list mb-30">
                <a href="#"><button class="variant__buy--now__btn primary__btn" id="gocheckout" type="submit">Explore
                     us</button> </a>
             </div>
             <div class="product__variant--list mb-30">
                  <a href="#"><button class="variant__buy--now__btn primary__btn pink-color" id="" type="submit">My
                     Order</button> </a>
             </div> -->
         </div>
        </div>
    </section>
</main>
@include('layouts.footer')
@endsection
