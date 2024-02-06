@extends('layouts.app')

@section('content')
@include('layouts.header')
    <section class="hero__slider--section">
      <div class="hero__slider--inner hero__slider--activation swiper swiper-fade swiper-initialized swiper-horizontal swiper-pointer-events">
        <div class="hero__slider--wrapper swiper-wrapper" id="swiper-wrapper-0e5b7bada10e7f4c9" aria-live="polite" style="transition-duration: 0ms;">

          <div class="swiper-slide hero_swiper_slider swiper-slide-duplicate swiper-slide-prev swiper-slide-duplicate-next" data-swiper-slide-index="1" role="group" aria-label="2 / 2" style="width: 1349px; opacity: 1; transform: translate3d(0px, 0px, 0px); transition-duration: 0ms;">
          @if(isset($master_data) && isset($master_data['banner']))
           @foreach ($master_data['banner'] as $item)
            <div class="hero__slider--items hero__slider--bg slider1">
            @php
                  $foo = app('App\Http\Controllers\Controller');
                  $imgbanner= $foo->GetImage($file_name = $item['banner_image'],$path=config('global.file_path.banner_image'));
                  @endphp
            
              <img class="hero_slider_banner_desk" src="{{$imgbanner}}" data-sizes="auto" srcset="{{$imgbanner}}">
              <img class="hero_slider_banner_mobile" src="{{$imgbanner}}" data-sizes="auto" srcset="{{$imgbanner}}">
              <div class="container-fluid sem-height">
                <div class="hero__slider--items__inner">
                  <div class="row row-cols-1">
                    <div class="col">
                      <div class="slider__content">
                        <h2 class="slider__content--maintitle text-white h1">
                          demo text
                        </h2>
                        <p class="slider__content--desc text-white mb-35 d-sm-2-none">
                          demo details
                        </p>
                        <a href="#"><button class="primary__btn" id="check_pincode" type="submit">
                            View More
                          </button></a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            @endforeach
     @endif
          </div>
       </div>
        <div class="swiper__nav--btn swiper-button-next" tabindex="0" role="button" aria-label="Next slide" aria-controls="swiper-wrapper-0e5b7bada10e7f4c9"></div>
        <div class="swiper__nav--btn swiper-button-prev" tabindex="0" role="button" aria-label="Previous slide" aria-controls="swiper-wrapper-0e5b7bada10e7f4c9"></div>
      <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span></div>
    </section>
    <section class="blog__section section--padding pt-5">
      <div class="container-fluid">
        <div class="section__heading text-center mb-30">
          <h2 class="section__heading--maintitle">
            Category
          </h2>
        </div>
        
        <div class="blog__section--inner shop__swiper--activation swiper swiper-initialized swiper-horizontal swiper-pointer-events">
        
          <div class="swiper-wrapper" id="swiper-wrapper-e10e64410d1c0ba474" aria-live="polite" style="transform: translate3d(0px, 0px, 0px);">
          @if(isset($master_data) && isset($master_data['category']))
           @foreach ($master_data['category'] as $item)
            <div class="swiper-slide swiper-slide-active" role="group" aria-label="1 / 1" style="width: 225px; margin-right: 30px;">
              <a href="{{ url('servicelist/'.$item['category_id']) }}" class="blog__items w-100">
                <div class="blog__thumbnail product-blog">
                  <div class="blog__thumbnail--link display-block">
                  @php
                  $foo = app('App\Http\Controllers\Controller');
                  $img= $foo->GetImage($file_name = $item['category_image'],$path=config('global.file_path.category_image'));
                  @endphp
                    <img class="blog__thumbnail--img display-block" src="{{$img}}" alt="blog-img">
                  </div>
                </div>
                <div class="blog__content">
                  <h3 class="text-center blog__content--title h4">{{$item['category_name']}}</h3>
                </div>
              </a>
            </div>
            @endforeach
            @endif
          </div>
          <div class="swiper__nav--btn swiper-button-next swiper-button-disabled swiper-button-lock" tabindex="-1" role="button" aria-label="Next slide" aria-controls="swiper-wrapper-e10e64410d1c0ba474" aria-disabled="true"></div>
          <div class="swiper__nav--btn swiper-button-prev swiper-button-disabled swiper-button-lock" tabindex="-1" role="button" aria-label="Previous slide" aria-controls="swiper-wrapper-e10e64410d1c0ba474" aria-disabled="true"></div>
        <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span></div>
      
      </div>
      
    </section>
    <section class="product__section section--padding pt-0 most-popular">
        <div class="container-fluid">
            <div class="section__heading text-center mb-40">
                <h2 class="section__heading--maintitle">Most Popular Items</h2>
            </div>
            
            <div class="product__section--inner product__swiper--column4 swiper swiper-initialized swiper-horizontal swiper-pointer-events">
               
            <div class="swiper__nav--btn swiper-button-prev" tabindex="0" role="button" aria-label="Previous slide" aria-controls="swiper-wrapper-77192d5d75473c08"></div>
                @if(isset($master_data) && isset($master_data['service']))
              @foreach ($master_data['service'] as $item)
                <div class="swiper-wrapper" id="swiper-wrapper-77192d5d75473c08" aria-live="polite" style="transform: translate3d(0px, 0px, 0px);"><div class="swiper-slide swiper-slide-duplicate swiper-slide-active swiper-slide-duplicate-next" data-swiper-slide-index="0" role="group" aria-label="1 / 1" style="width: 292.75px; margin-right: 30px;">
                
                        <div class="product__items">
                            <div class="product__items--thumbnail">
                                <a class="product__items--link" href="{{ url('servicedetails/'.$item['service_id']) }}">
                                @php
                                $data = app('App\Http\Controllers\Controller');
                                $img1= $data->GetImage($file_name = $item['service_single_image'],$path=config('global.file_path.service_image'));
                                @endphp
                                    <img class="product__items--img product__primary--img" src="{{$img1}}" alt="product-img">
                                    
                                </a>
                            </div>
                            <div class="product__items--content home-product text-center">
                                
                                <h3 class="product__items--content__title h4"><a href="{{ url('servicedetails/'.$item['service_id']) }}">{{$item['service_name']}}</a>
                                </h3>
                                <div class="product__items--price">
                                    <span class="current__price">₹ {{$item['ServiceDetails'][0]['service_discount_price']}}</span>
                                    <span class="old__price">₹ {{$item['ServiceDetails'][0]['service_original_price']}}</span>
                                </div>

                            </div>
                        </div>                     
                    </div> 
                      @endforeach
                    @endif 
                  
                <div class="swiper__nav--btn swiper-button-next" tabindex="0" role="button" aria-label="Next slide" aria-controls="swiper-wrapper-77192d5d75473c08"></div>            
            <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span></div>            
        </div>
    </section>
    <section class="banner__section section--padding pt-0">
        <div class="container-fluid">
            <div class="row row-cols-lg-3 row-cols-md-2 row-cols-sm-2 row-cols-1 mb--n28">
                <div class="col mb-28">
                    <div class="banner__items">
                        <a class="banner__items--thumbnail position__relative" href="shop.html"><img class="banner__items--thumbnail__img" src="assets/img/banner/banner6.webp" alt="banner-img">
                            <div class="banner__items--content__style2 right">
                                <h2 class="banner__items--content__style2--title">Single Stylish <br>
                                    Mini Chair </h2>
                                <span class="banner__items--content__link primary__btn style2">Order Now</span>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col mb-28">
                    <div class="banner__items">
                        <a class="banner__items--thumbnail position__relative" href="shop.html"><img class="banner__items--thumbnail__img" src="assets/img/banner/banner7.webp" alt="banner-img">
                            <div class="banner__items--content__style2 right">
                                <h2 class="banner__items--content__style2--title">New Furniture <br>
                                    Tree Planet </h2>
                                <span class="banner__items--content__link primary__btn style2">Order Now</span>  
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col mb-28">
                    <div class="banner__items">
                        <a class="banner__items--thumbnail position__relative" href="shop.html"><img class="banner__items--thumbnail__img" src="assets/img/banner/banner8.webp" alt="banner-img">
                            <div class="banner__items--content__style2">
                                <h2 class="banner__items--content__style2--title">Single Stylish <br>
                                    Mini Chair </h2>
                                <span class="banner__items--content__link primary__btn style2">Order Now</span>   
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="blog__section section--padding pt-0">
        <div class="container-fluid">
            <div class="section__heading text-center mb-30">
                <h2 class="section__heading--maintitle">Clients Testimonial</h2>
                <a href="{{ url('testimonialList') }}" class="banner__items--content__link primary__btn style2">View All</a>
            </div>
            <div class="blog__section--inner blog__swiper--activation swiper swiper-initialized swiper-horizontal swiper-pointer-events">
            <div class="swiper__nav--btn swiper-button-prev" tabindex="0" role="button" aria-label="Previous slide" aria-controls="swiper-wrapper-d0e109415eb271cc6"></div>
            @if(isset($master_data) && isset($master_data['testimonial']))
              @foreach ($master_data['testimonial'] as $item)
                <div class="swiper-wrapper" id="swiper-wrapper-d0e109415eb271cc6" aria-live="polite" style="transform: translate3d(0px, 0px, 0px);">
                <div class="swiper-slide swiper-slide-duplicate swiper-slide-active swiper-slide-duplicate-next" data-swiper-slide-index="0" role="group" aria-label="1 / 1" style="width: 395px; margin-right: 30px;">
               
                        <div class="blog__items">
                        
                        @php
                                $data = app('App\Http\Controllers\Controller');
                                $img2= $data->GetImage($file_name = $item['testimonial_image'],$path=config('global.file_path.testimonial_image'));
                                @endphp
                            <div class="blog__thumbnail">
                                <a class="blog__thumbnail--link display-block" href="{{ url('testimonialDetails/'.$item['testimonial_id']) }}"><img class="blog__thumbnail--img display-block" src="{{$img2}}" alt="blog-img"></a>
                            </div>
                            <div class="blog__content">
                                <ul class="blog__content--meta d-flex">
                                    <li class="blog__content--meta__text">
                                        <svg class="blog__content--meta__icon" xmlns="http://www.w3.org/2000/svg" width="12.569" height="13.966" viewBox="0 0 12.569 13.966">
                                            <path data-name="Icon material-date-range" d="M8.69,9.285h-1.4v1.4h1.4Zm2.793,0h-1.4v1.4h1.4Zm2.793,0h-1.4v1.4h1.4Zm1.4-4.888h-.7V3h-1.4V4.4H7.991V3h-1.4V4.4H5.9a1.39,1.39,0,0,0-1.39,1.4L4.5,15.569a1.4,1.4,0,0,0,1.4,1.4h9.776a1.4,1.4,0,0,0,1.4-1.4V5.793A1.4,1.4,0,0,0,15.673,4.4Zm0,11.173H5.9V7.888h9.776Z" transform="translate(-4.5 -3)" fill="currentColor"></path>
                                        </svg>{{date('j F, Y',strtotime($item['created_at']))}}</li>
                                </ul>
                                <h3 class="blog__content--title h4"><a href="{{ url('testimonialDetails/'.$item['testimonial_id']) }}"> {{$item['testimonial_title']}}</a></h3>
                                <p class="blog__content--desc"> {!! Str::words(strip_tags($item['testimonial_description']), 20) !!} </p>
                               
                                <a class="blog__content--btn primary__btn" href="{{ url('testimonialDetails/'.$item['testimonial_id']) }}">Read more </a>
                            </div>
                        </div>
                    </div>                  
                    @endforeach
                    @endif 
                    
                <div class="swiper__nav--btn swiper-button-next" tabindex="0" role="button" aria-label="Next slide" aria-controls="swiper-wrapper-d0e109415eb271cc6"></div>
              
            <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span></div>
        </div>
    </section>

@include('layouts.footer')
@endsection
