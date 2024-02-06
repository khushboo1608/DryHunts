@extends('layouts.app')
@section('content')
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KNK2NX9"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<meta name="csrf-token" content="{{ csrf_token() }}">
@include('layouts.header')
<main class="main__content_wrapper">
    <!-- Start product details section -->
    @if(isset($serviceData))
    <input type="hidden" name="service_id" id="service_id" value="{{$serviceData->service_id}}">
    <input type="hidden" name="category_id" id="category_id" value="{{$serviceData->category_id}}">
    <section class="product__details--section section--padding pt-0 mt-50">
    <div class="container">
        <div class="row row-cols-lg-2 row-cols-md-2 justify-content-center product-box">
        <div class="col">
            <div class="product__details--media">
            <div class="product__media--preview_1 swiper swiper-initialized swiper-horizontal swiper-pointer-events">
                <div class="swiper-wrapper">
                        <?php
                    $service_multiple_image = [];
                    $data1 = app('App\Http\Controllers\Controller');
                    $multi_images = explode(',',$serviceData->service_multiple_image);

                    
                   foreach ($multi_images as $item){
                    $service_multiple_image[] = $data1->GetImage($file_name = $item,$path=config('global.file_path.service_image'));
                   }
                 ?>
                @foreach ($service_multiple_image as $key => $val)
                <div class="swiper-slide">
            <div class="product__media--preview__items">
                <a class="product__media--preview__items--link"
                    data-gallery="product-media-preview">
                    <div class="product-img--main" data-scale="2.2"
                        data-image="{{$val}}" alt="product-media-img">
                        <div class="product-img--main__image" style="background-image: url({{$val}});"></div>
                    </div>
                </a>
            </div>
        </div>   
                <script>
                    $('.product-img--main')
                        .on('mouseover', function() {
                            $(this).children('.product-img--main__image').css({
                                'transform': 'scale(' + $(this).attr('data-scale') + ')'
                            });
                        })
                        .on('mouseout', function() {
                            $(this).children('.product-img--main__image').css({
                                'transform': 'scale(1)'
                            });
                        })
                        .on('mousemove', function(e) {
                            $(this).children('.product-img--main__image').css({
                                'transform-origin': ((e.pageX - $(this).offset().left) / $(
                                    this).width()) * 100 + '% ' + ((e.pageY - $(this)
                                    .offset().top) / $(this).height()) * 100 + '%'
                            });
                        })
                </script>
                 @endforeach  
                 </div>
                                    <div class="swiper__nav--btn swiper-button-next"></div>
                                    <div class="swiper__nav--btn swiper-button-prev"></div>
                                </div>
            
            <div class="product__media--nav_1 swiper swiper-initialized swiper-horizontal swiper-pointer-events swiper-free-mode swiper-thumbs">
                <div class="swiper-wrapper">
                    <?php
                    $service_multiple_image = [];
                    $data1 = app('App\Http\Controllers\Controller');
                    $multi_images = explode(',',$serviceData->service_multiple_image);

                    
                   foreach ($multi_images as $item){
                    $service_multiple_image[] = $data1->GetImage($file_name = $item,$path=config('global.file_path.service_image'));
                   }
                        
                //    echo "<pre>";
                //     print_r($service_multiple_image);die; 
                ?>
                @foreach ($service_multiple_image as $key => $val)
                <div class="swiper-slide">
                    <div class="product__media--nav__items">
                    <img class="product__media--nav__items--img" src="{{$val}}" alt="product-nav-img">
                    </div>					
                </div>
                    
                @endforeach
                </div>
                                    <div class="swiper__nav--btn swiper-button-next"></div>
                                    <div class="swiper__nav--btn swiper-button-prev"></div>
                                </div>
                            </div>
                        </div>
        
            <script>
                        $(function() {
                            swiper = new Swiper(
                                    ".product__media--nav_1", {
                                        loop: false,
                                        spaceBetween: 10,
                                        slidesPerView: 5,
                                        freeMode: !0,
                                        watchSlidesProgress: !0,
                                        breakpoints: {
                                            768: {
                                                slidesPerView: 5
                                            },
                                            480: {
                                                slidesPerView: 4
                                            },
                                            320: {
                                                slidesPerView: 3
                                            },
                                            200: {
                                                slidesPerView: 2
                                            },
                                            0: {
                                                slidesPerView: 1
                                            }
                                        },
                                        navigation: {
                                            nextEl: ".swiper-button-next",
                                            prevEl: ".swiper-button-prev"
                                        }
                                    }),
                                swiper2 = new Swiper(
                                    ".product__media--preview_1", {
                                        loop: false,
                                        spaceBetween: 10,
                                        thumbs: {
                                            swiper: swiper
                                        },
                                        navigation: {
                                            nextEl: ".swiper-button-next",
                                            prevEl: ".swiper-button-prev"
                                        }
                                    });
                        });
            </script>
        <div class="col max-1024">
            <div class="product__details--info">
            <form action="#" onsubmit="return validate()">
            
                <h2 class="product__details--info__title mb-15 text-left">
                {{$serviceData->service_name}}
                </h2>
                <div class="product__details--info__price mb-10">
                ₹
                <span class="current__price" id="current__price">{{$serviceData->ServiceDetails[0]['service_discount_price']}}</span>
                ₹<span class="old__price" id="old__price"> {{$serviceData->ServiceDetails[0]['service_original_price']}}</span>
                </div>
                <div class="product__details--info__rating mb-15">
                <p style="display: inline; font-size: 17px">
                    &nbsp; 4.8 ⭐| 212 Reviews&nbsp;
                </p>
                </div>
                <p class="product__details--info__desc mb-20">Curtain, in interior design, decorative fabric commonly hung to regulate the admission of light at windows and to prevent drafts from door or window openings.
                </p>

                <div class="product__variant--list">
                <fieldset class="variant__input--fieldset">
                    <div class="d-flex align-items-center mb-12">
                    <legend class="product__variant--title mb-0">
                        Size :
                    </legend>
                    <?php 
                    $ServiceDetails = $serviceData->ServiceDetails->sortBy('created_at')->values();
                    ?>
                    @foreach ($ServiceDetails as $key => $val1)
                    <!-- <input type="hidden" name="service_detail_id" id="service_detail_id" value="{{$val1->service_detail_id}}"> -->
                    <div class="d-flex align-items-center flex-wrap size-width">
                        <div class="size-wrappers">
                        <input class="size-input service" type="radio" name="size" id="size-{{$val1}}" value="{{$val1->service_unit}}" data-isprm="{{$val1->service_detail_id}}">
                        <label class="SizeSwatch" for="size-{{$val1}}">{{$val1->service_unit}}</label>
                        </div>
                        <!-- <div class="size-wrappers">
                        <input class="size-type" type="radio" name="size" id="size-3XL" value="3XL">
                        <label class="SizeSwatch" for="size-3XL">3XL</label>
                        </div> -->
                    </div>
                    @endforeach
                    </div>
                </fieldset>
                </div>
                           
                <div class="product__variant--list quantity d-flex align-items-center mb-20 ">
                    <div class="quantity__box">
                        <button type="button" class="quantity__value quickview__value--quantity decrease" aria-label="quantity value" value="Decrease Value">-</button>
                        <label>
                            <input type="number" class="quantity__number quickview__value--number" id="quantity" value="1" min="1">
                            <div id="custom_quantity"> </div>
                        </label>
                        <button type="button" class="quantity__value quickview__value--quantity increase" aria-label="quantity value" value="Increase Value">+</button>
                    </div>

                </div>
                <!-- <a class="variant__wishlist--icon mb-20" href="wishlist.html" title="Add to wishlist">
                <div class="wishlist-wrapper">
                    <svg class="quickview__variant--wishlist__svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <path d="M352.92 80C288 80 256 144 256 144s-32-64-96.92-64c-52.76 0-94.54 44.14-95.08 96.81-1.1 109.33 86.73 187.08 183 252.42a16 16 0 0018 0c96.26-65.34 184.09-143.09 183-252.42-.54-52.67-42.32-96.81-95.08-96.81z" fill="none" stroke="#0d0f26" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"></path>
                    </svg>
                    <svg class="quickview__variant--wishlist__svg wishlist-hover" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <path d="M352.92 80C288 80 256 144 256 144s-32-64-96.92-64c-52.76 0-94.54 44.14-95.08 96.81-1.1 109.33 86.73 187.08 183 252.42a16 16 0 0018 0c96.26-65.34 184.09-143.09 183-252.42-.54-52.67-42.32-96.81-95.08-96.81z" fill="var(--secondary-color)" stroke="var(--secondary-color)" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"></path>
                    </svg>
                </div>
                Add to Wishlist
                </a> -->
                <div class="d-flex align-items-center w-100 gap-10">
                @if (Auth::check())
                <div class="product__variant--list mb-30 w-100">
                      <button class="variant__buy--now__btn primary__btn" id="gocheckout" type="submit">
                        Add To Cart
                      </button>
                    </div>
                    </form>
               
                @else
                <div class="product__variant--list mb-30 w-100">
                    <a href="{{route('userlogin')}}" class="variant__buy--now__btn primary__btn">Login</a>
                    </div>
              @endif
              </div>
                <div class="icon_box">
                <div class="icon_items">
                    <svg width="64" height="65" viewBox="0 0 64 65" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M34.5087 46.9695C45.3089 46.9695 54.0642 38.2142 54.0642 27.414C54.0642 16.6137 45.3089 7.8584 34.5087 7.8584C23.7084 7.8584 14.9531 16.6137 14.9531 27.414C14.9531 38.2142 23.7084 46.9695 34.5087 46.9695Z" fill="white" stroke="var(--secondary-color)" stroke-width="2.12809" stroke-linecap="round"></path>
                    <path d="M26.6855 19.5913V21.5469M42.33 19.5913V21.5469" stroke="var(--secondary-color)" stroke-width="2.12809" stroke-linecap="round"></path>
                    <path d="M42.33 31.3252C41.3522 34.2585 38.8295 37.1919 34.5078 37.1919C30.186 37.1919 27.6633 34.2585 26.6855 31.3252" stroke="var(--secondary-color)" stroke-width="2.12809" stroke-linecap="round" stroke-linejoin="round"></path>
                    <path d="M18.3375 7.71035L14.1233 14.2929L7.54592 10.0786L7.54432 10.0776C5.89591 9.02557 5.43177 6.92273 6.48535 5.26313L6.48762 5.25952C6.96508 4.50072 7.71865 3.957 8.58938 3.74309C9.46011 3.52919 10.3799 3.66184 11.1546 4.11303L11.998 4.60423L12.56 3.80624C13.0753 3.07454 13.854 2.57066 14.7326 2.40026C15.6113 2.22986 16.5218 2.40618 17.2733 2.89221L17.2795 2.89621L17.2857 2.90013C17.6736 3.14341 18.0091 3.46147 18.2726 3.83576C18.5362 4.21005 18.7226 4.63307 18.8209 5.08015C18.9193 5.52722 18.9276 5.98941 18.8454 6.43975C18.7632 6.89009 18.5922 7.31957 18.3422 7.70313L18.3422 7.70311L18.3375 7.71035Z" stroke="var(--secondary-color)" stroke-width="2.12809"></path>
                    <path d="M58.2704 51.4403L58.2704 51.4403L58.2632 51.4449L52.6841 55.0737L48.849 49.6334L48.8479 49.6318C47.925 48.3275 48.2437 46.6539 49.5856 45.7738L49.5856 45.7738L49.5892 45.7714C50.2052 45.3639 50.9737 45.2006 51.7328 45.3278C52.4919 45.4551 53.168 45.8608 53.6212 46.4492L54.1948 47.1938L55.0045 46.7165C55.6425 46.3405 56.4188 46.2154 57.1698 46.3784C57.9207 46.5413 58.5741 46.9764 58.997 47.5819L59.0012 47.5879L59.0055 47.5939C59.226 47.9004 59.3799 48.2428 59.4604 48.6002C59.5409 48.9575 59.5469 49.324 59.479 49.679C59.4111 50.0339 59.2704 50.3721 59.0639 50.6742C58.8573 50.9763 58.5882 51.2372 58.2704 51.4403Z" stroke="var(--secondary-color)" stroke-width="2.12809"></path>
                    <path d="M36.931 58.9979L36.931 58.9978L36.9258 59.0047L33.9065 63.0007L29.8001 60.1324L29.7985 60.1314C28.8749 59.4887 28.6858 58.3143 29.3649 57.4084L29.3649 57.4084L29.3674 57.405C29.6784 56.9867 30.1512 56.6915 30.6903 56.5929C31.2295 56.4942 31.7787 56.6026 32.2212 56.8846L33.0139 57.3897L33.613 56.6655C33.9465 56.2623 34.4342 55.9906 34.9767 55.9178C35.5191 55.845 36.06 55.9786 36.4862 56.279L36.4923 56.2832L36.4983 56.2874C36.7182 56.4378 36.9016 56.6275 37.0399 56.8438C37.1781 57.06 37.269 57.2996 37.3088 57.5488C37.3485 57.7979 37.3365 58.0538 37.2724 58.3019C37.2083 58.5501 37.093 58.787 36.931 58.9979Z" stroke="var(--secondary-color)" stroke-width="2.12809"></path>
                    <path d="M60.6383 5.09618L60.6383 5.09616L60.6337 5.10347L57.9991 9.36288L53.6437 6.88886L53.6421 6.88793C52.6627 6.3339 52.3652 5.18224 52.9571 4.2171L52.9571 4.2171L52.9594 4.21346C53.23 3.76807 53.6734 3.43016 54.201 3.28183C54.7287 3.13349 55.2856 3.19032 55.7524 3.42998L56.5886 3.8592L57.1177 3.08242C57.4123 2.64997 57.8727 2.33412 58.4061 2.21118C58.9394 2.08826 59.4903 2.17094 59.9426 2.43044L59.949 2.4341L59.9555 2.43768C60.1884 2.56703 60.3886 2.73881 60.5464 2.94133C60.7041 3.14375 60.8169 3.37384 60.8797 3.61824C60.9424 3.86264 60.9542 4.11847 60.9135 4.37147C60.8728 4.62459 60.78 4.87114 60.6383 5.09618Z" stroke="var(--secondary-color)" stroke-width="2.12809"></path>
                    <path d="M23.347 47.5339L15.6493 58.6001L4.84322 50.5649L4.8417 50.5638C1.94941 48.4212 1.29377 44.4193 3.34662 41.4439L3.34904 41.4404C4.2801 40.0793 5.68561 39.1564 7.26498 38.8559C8.84423 38.5555 10.4866 38.8984 11.8461 39.8222L12.679 40.3882L13.29 39.5877C14.286 38.2827 15.7317 37.4368 17.3211 37.2175C18.9106 36.9982 20.5332 37.4209 21.8485 38.4077L21.8544 38.4121L21.8604 38.4165C22.5404 38.9121 23.1211 39.5428 23.5671 40.2729C24.0132 41.0031 24.3152 41.8172 24.4544 42.6676C24.5937 43.518 24.5673 44.3862 24.3774 45.221C24.1875 46.0558 23.8384 46.8395 23.3519 47.5269L23.3519 47.5268L23.347 47.5339Z" fill="white" stroke="var(--secondary-color)" stroke-width="2.12809"></path>
                    </svg>
                    <p>100k+ HAPPY CUSTOMERS</p>
                </div>
                <div class="icon_items">
                    <svg width="61" height="67" viewBox="0 0 61 67" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_710_8791)">
                        <path d="M26.7333 43.7246L34.9464 25.7927H24.0367V23.7121H37.383V25.4642L29.2246 43.7246H26.7333Z" fill="var(--secondary-color)"></path>
                        <path d="M23.3508 52.2303C23.3508 53.0553 23.1921 53.7451 22.8748 54.2995C22.5608 54.8506 22.1049 55.2665 21.507 55.547C20.9091 55.8243 20.1893 55.9629 19.3476 55.9629H17.2734V48.638H19.5731C20.3413 48.638 21.0077 48.775 21.5721 49.0489C22.1366 49.3194 22.5742 49.7219 22.8848 50.2563C23.1954 50.7874 23.3508 51.4454 23.3508 52.2303ZM21.7375 52.2704C21.7375 51.7293 21.6573 51.2851 21.497 50.9377C21.34 50.587 21.1062 50.3281 20.7956 50.1611C20.4883 49.9941 20.1075 49.9106 19.6533 49.9106H18.8266V54.6803H19.4929C20.2511 54.6803 20.8139 54.4782 21.1814 54.0741C21.5521 53.6699 21.7375 53.0687 21.7375 52.2704ZM30.0712 55.9629L29.5401 54.2194H26.8697L26.3386 55.9629H24.6652L27.2505 48.608H29.1493L31.7446 55.9629H30.0712ZM29.1693 52.9167L28.6383 51.2133C28.6049 51.0997 28.5598 50.9544 28.503 50.7774C28.4496 50.597 28.3944 50.415 28.3377 50.2313C28.2842 50.0442 28.2408 49.8822 28.2074 49.7453C28.174 49.8822 28.1272 50.0526 28.0671 50.2563C28.0103 50.4567 27.9552 50.6471 27.9018 50.8275C27.8483 51.0078 27.8099 51.1364 27.7865 51.2133L27.2605 52.9167H29.1693ZM35.6693 51.6542L37.1974 48.638H38.8708L36.4409 53.1121V55.9629H34.8978V53.1622L32.4678 48.638H34.1512L35.6693 51.6542ZM44.8347 53.9288C44.8347 54.363 44.7295 54.7404 44.5191 55.0611C44.3086 55.3817 44.0013 55.6289 43.5972 55.8026C43.1964 55.9763 42.7087 56.0631 42.1342 56.0631C41.8804 56.0631 41.6315 56.0464 41.3877 56.013C41.1472 55.9796 40.9151 55.9312 40.6913 55.8677C40.4709 55.8009 40.2604 55.7191 40.06 55.6222V54.1793C40.4074 54.3329 40.7681 54.4715 41.1422 54.5951C41.5163 54.7187 41.8871 54.7805 42.2545 54.7805C42.5083 54.7805 42.7121 54.7471 42.8657 54.6803C43.0227 54.6135 43.1363 54.5216 43.2064 54.4047C43.2765 54.2878 43.3116 54.1542 43.3116 54.0039C43.3116 53.8202 43.2498 53.6632 43.1262 53.533C43.0027 53.4027 42.8323 53.2808 42.6152 53.1672C42.4014 53.0537 42.1593 52.9317 41.8887 52.8015C41.7184 52.7213 41.533 52.6245 41.3326 52.5109C41.1322 52.394 40.9418 52.252 40.7614 52.085C40.5811 51.918 40.4324 51.7159 40.3155 51.4788C40.202 51.2383 40.1452 50.9511 40.1452 50.6171C40.1452 50.1795 40.2454 49.8054 40.4458 49.4948C40.6462 49.1841 40.9318 48.947 41.3025 48.7833C41.6766 48.6163 42.1175 48.5328 42.6252 48.5328C43.006 48.5328 43.3684 48.5779 43.7124 48.6681C44.0598 48.7549 44.4222 48.8819 44.7996 49.0489L44.2986 50.2563C43.9613 50.1194 43.659 50.0142 43.3918 49.9407C43.1246 49.8639 42.8524 49.8254 42.5751 49.8254C42.3814 49.8254 42.2161 49.8572 42.0791 49.9206C41.9422 49.9808 41.8386 50.0676 41.7685 50.1812C41.6983 50.2914 41.6633 50.42 41.6633 50.567C41.6633 50.7406 41.7134 50.8876 41.8136 51.0078C41.9171 51.1247 42.0708 51.2383 42.2745 51.3485C42.4816 51.4588 42.7388 51.5874 43.0461 51.7343C43.4202 51.9113 43.7392 52.0967 44.003 52.2904C44.2702 52.4808 44.4756 52.7063 44.6193 52.9668C44.7629 53.224 44.8347 53.5447 44.8347 53.9288Z" fill="var(--secondary-color)"></path>
                        <path d="M51.4743 3.45772H44.2437V1.12502C44.2437 0.805409 44.1167 0.498887 43.8907 0.272887C43.6647 0.0468875 43.3582 -0.0800781 43.0386 -0.0800781C42.719 -0.0800781 42.4125 0.0468875 42.1865 0.272887C41.9605 0.498887 41.8335 0.805409 41.8335 1.12502V3.45772H18.5491V1.12502C18.5491 0.805409 18.4221 0.498887 18.1961 0.272887C17.9701 0.0468875 17.6636 -0.0800781 17.344 -0.0800781C17.0244 -0.0800781 16.7179 0.0468875 16.4919 0.272887C16.2659 0.498887 16.1389 0.805409 16.1389 1.12502V3.45772H8.90831C7.31083 3.45963 5.77934 4.09507 4.64975 5.22466C3.52017 6.35425 2.88473 7.88574 2.88281 9.48322V57.4896C2.88473 59.0871 3.52017 60.6186 4.64975 61.7482C5.77934 62.8777 7.31083 63.5132 8.90831 63.5151H51.4743C53.072 63.5138 54.6038 62.8786 55.7335 61.7489C56.8633 60.6191 57.4985 59.0873 57.4998 57.4896V9.48322C57.4985 7.88555 56.8633 6.35368 55.7335 5.22396C54.6038 4.09423 53.072 3.459 51.4743 3.45772ZM55.0896 57.4896C55.0896 58.4484 54.7087 59.368 54.0307 60.046C53.3527 60.724 52.4331 61.1049 51.4743 61.1049H8.90831C7.94947 61.1049 7.02991 60.724 6.35191 60.046C5.67391 59.368 5.29301 58.4484 5.29301 57.4896V17.7639H55.0896V57.4896ZM55.0896 15.3537H5.29301V9.48322C5.29301 7.48757 6.90784 5.86792 8.90831 5.86792H16.1389V8.20061C16.1389 8.52023 16.2659 8.82675 16.4919 9.05275C16.7179 9.27875 17.0244 9.40571 17.344 9.40571C17.6636 9.40571 17.9701 9.27875 18.1961 9.05275C18.4221 8.82675 18.5491 8.52023 18.5491 8.20061V5.86792H41.8335V8.20061C41.8335 8.52023 41.9605 8.82675 42.1865 9.05275C42.4125 9.27875 42.719 9.40571 43.0386 9.40571C43.3582 9.40571 43.6647 9.27875 43.8907 9.05275C44.1167 8.82675 44.2437 8.52023 44.2437 8.20061V5.86792H51.4743C52.4331 5.86792 53.3527 6.24881 54.0307 6.92681C54.7087 7.60481 55.0896 8.52438 55.0896 9.48322V15.3537Z" fill="var(--secondary-color)" stroke="#F2F6FB" stroke-width="0.6413"></path>
                        <path d="M11.6272 56.974C12.4536 57.8004 12.4536 59.1404 11.6272 59.9669L9.27579 62.3182L11.6272 64.6696C12.4536 65.496 12.4536 66.836 11.6272 67.6625C10.8007 68.4889 9.46073 68.4889 8.63427 67.6625L4.78647 63.8147C3.96 62.9882 3.96 61.6482 4.78647 60.8218L8.63427 56.974M11.6272 56.974L8.63427 56.974M11.6272 56.974C10.8007 56.1475 9.46073 56.1475 8.63427 56.974M11.6272 56.974L8.63427 56.974" fill="var(--secondary-color)" stroke="#F2F6FB" stroke-width="2.5652" stroke-linecap="round" stroke-linejoin="round"></path>
                    </g>
                    <defs>
                        <clipPath id="clip0_710_8791">
                        <rect width="60" height="67" fill="white" transform="translate(0.333984)"></rect>
                        </clipPath>
                    </defs>
                    </svg>
                    <p>7 DAY NO QUESTION RETURN</p>
                </div>
                <div class="icon_items">
                    <svg width="61" height="67" viewBox="0 0 61 67" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M23.3462 48.626C23.3462 49.3844 23.289 50.1367 23.1747 50.883C23.0664 51.6293 22.8738 52.3335 22.5969 52.9955C22.3201 53.6516 21.9319 54.2354 21.4323 54.7469C20.9328 55.2525 20.2978 55.6497 19.5274 55.9386C18.757 56.2275 17.8242 56.372 16.7288 56.372C16.47 56.372 16.166 56.3599 15.817 56.3359C15.4679 56.3178 15.179 56.2877 14.9503 56.2456V54.0067C15.191 54.0668 15.4468 54.115 15.7177 54.1511C15.9885 54.1812 16.2623 54.1962 16.5392 54.1962C17.6406 54.1962 18.4892 54.0217 19.0851 53.6726C19.6869 53.3235 20.1082 52.839 20.349 52.2191C20.5957 51.5992 20.7372 50.883 20.7733 50.0705H20.6649C20.4904 50.3594 20.2828 50.6212 20.042 50.8559C19.8073 51.0846 19.5064 51.2682 19.1392 51.4066C18.7721 51.539 18.3056 51.6052 17.7399 51.6052C16.9876 51.6052 16.3315 51.4427 15.7718 51.1177C15.2181 50.7867 14.7878 50.3112 14.4808 49.6913C14.1799 49.0654 14.0294 48.3101 14.0294 47.4253C14.0294 46.4684 14.21 45.6498 14.5711 44.9697C14.9382 44.2836 15.4589 43.757 16.1329 43.3899C16.807 43.0227 17.6015 42.8391 18.5163 42.8391C19.1904 42.8391 19.8193 42.9565 20.4031 43.1912C20.9869 43.4199 21.4985 43.772 21.9379 44.2475C22.3832 44.723 22.7293 45.3248 22.9761 46.0531C23.2228 46.7813 23.3462 47.639 23.3462 48.626ZM18.5705 45.0781C18.0288 45.0781 17.5864 45.2646 17.2434 45.6378C16.9003 46.0109 16.7288 46.5948 16.7288 47.3892C16.7288 48.0272 16.8762 48.5327 17.1711 48.9059C17.4661 49.279 17.9144 49.4656 18.5163 49.4656C18.9316 49.4656 19.2927 49.3753 19.5996 49.1948C19.9066 49.0082 20.1443 48.7765 20.3129 48.4996C20.4874 48.2168 20.5747 47.9279 20.5747 47.633C20.5747 47.326 20.5325 47.0221 20.4483 46.7211C20.364 46.4202 20.2376 46.1464 20.0691 45.8996C19.9006 45.6528 19.6899 45.4542 19.4371 45.3038C19.1904 45.1533 18.9015 45.0781 18.5705 45.0781ZM37.6406 56.1914H34.4448L31.3753 51.199L28.3058 56.1914H25.3085L29.6871 49.3844L25.5884 42.9926H28.6759L31.5197 47.7413L34.3093 42.9926H37.3247L33.1809 49.5378L37.6406 56.1914ZM40.596 56.1914V42.9926H43.3947V53.8803H48.7482V56.1914H40.596Z" fill="var(--secondary-color)"></path>
                    <path d="M27.2465 39.4463H25.1333V33.3528H23.2234V31.6248H29.1511V33.3528H27.2465V39.4463ZM37.5878 35.5248C37.5878 36.1276 37.5147 36.6768 37.3685 37.1726C37.2258 37.6648 37.0011 38.0892 36.6944 38.4459C36.3877 38.8025 35.9935 39.0771 35.5121 39.2697C35.0306 39.4588 34.4546 39.5533 33.7841 39.5533C33.1278 39.5533 32.5589 39.4588 32.0774 39.2697C31.5995 39.0771 31.2054 38.8043 30.8951 38.4512C30.5848 38.0946 30.3548 37.6684 30.205 37.1726C30.0552 36.6768 29.9803 36.124 29.9803 35.5141C29.9803 34.701 30.114 33.9948 30.3815 33.3956C30.6526 32.7928 31.0699 32.3274 31.6334 31.9993C32.1969 31.6676 32.9174 31.5017 33.7948 31.5017C34.6864 31.5017 35.4104 31.6676 35.9668 31.9993C36.5268 32.331 36.9369 32.7982 37.1973 33.4009C37.4576 34.0037 37.5878 34.7117 37.5878 35.5248ZM32.2058 35.5248C32.2058 35.9956 32.2593 36.4004 32.3663 36.7393C32.4733 37.0781 32.6427 37.3384 32.8746 37.5203C33.1064 37.7022 33.4096 37.7932 33.7841 37.7932C34.1728 37.7932 34.4813 37.7022 34.7096 37.5203C34.9414 37.3384 35.1073 37.0781 35.2071 36.7393C35.3105 36.4004 35.3623 35.9956 35.3623 35.5248C35.3623 34.8187 35.2446 34.2605 35.0092 33.8503C34.7738 33.4402 34.369 33.2351 33.7948 33.2351C33.4131 33.2351 33.1046 33.3278 32.8692 33.5133C32.6374 33.6988 32.468 33.9627 32.361 34.3051C32.2576 34.6475 32.2058 35.0541 32.2058 35.5248Z" fill="var(--secondary-color)"></path>
                    <path d="M12.2242 24.4043V16.5828H14.3374V22.6977H17.3494V24.4043H12.2242ZM24.0574 24.4043L23.6723 22.9384H21.1311L20.7352 24.4043H18.4133L20.9652 16.5507H23.7846L26.3686 24.4043H24.0574ZM23.2336 21.2051L22.8965 19.9211C22.8609 19.782 22.8091 19.5841 22.7414 19.3273C22.6736 19.0669 22.6058 18.7994 22.5381 18.5248C22.4739 18.2466 22.424 18.0183 22.3883 17.84C22.3562 18.0183 22.3098 18.2395 22.2492 18.5034C22.1921 18.7638 22.1315 19.0223 22.0673 19.2791C22.0067 19.5359 21.9532 19.7499 21.9068 19.9211L21.5698 21.2051H23.2336ZM30.4392 16.5828C31.1489 16.5828 31.7392 16.6702 32.21 16.8449C32.6808 17.0161 33.0339 17.2729 33.2693 17.6153C33.5082 17.9577 33.6277 18.3839 33.6277 18.8939C33.6277 19.2114 33.5742 19.5003 33.4672 19.7606C33.3602 20.021 33.2069 20.2546 33.0071 20.4614C32.811 20.6647 32.5756 20.8431 32.3009 20.9964L34.58 24.4043H32.1832L30.5248 21.5582H29.9898V24.4043H27.8766V16.5828H30.4392ZM30.4071 18.1824H29.9898V19.9693H30.3857C30.7102 19.9693 30.976 19.8979 31.1828 19.7553C31.3897 19.6126 31.4931 19.3576 31.4931 18.9902C31.4931 18.737 31.4075 18.5391 31.2363 18.3964C31.0651 18.2537 30.7887 18.1824 30.4071 18.1824ZM39.0893 19.8248H42.465V24.0405C42.062 24.1796 41.6001 24.2937 41.0794 24.3829C40.5587 24.4685 40.013 24.5113 39.4424 24.5113C38.6898 24.5113 38.03 24.3651 37.4629 24.0726C36.8958 23.7801 36.4536 23.3361 36.1362 22.7405C35.8187 22.1413 35.66 21.3852 35.66 20.4721C35.66 19.6518 35.8169 18.9439 36.1308 18.3483C36.4447 17.7491 36.9065 17.2872 37.5164 16.9626C38.1299 16.6345 38.8806 16.4704 39.7687 16.4704C40.2573 16.4704 40.721 16.5168 41.1597 16.6095C41.5984 16.7023 41.98 16.82 42.3045 16.9626L41.6358 18.6211C41.3541 18.482 41.0616 18.3786 40.7584 18.3108C40.4553 18.2395 40.1289 18.2038 39.7794 18.2038C39.3122 18.2038 38.9359 18.309 38.6506 18.5194C38.3688 18.7299 38.1638 19.0116 38.0354 19.3647C37.907 19.7142 37.8428 20.1012 37.8428 20.5256C37.8428 21.0107 37.9105 21.4209 38.0461 21.7561C38.1851 22.0878 38.3867 22.341 38.6506 22.5158C38.9181 22.687 39.2409 22.7726 39.6189 22.7726C39.7437 22.7726 39.8953 22.7637 40.0737 22.7458C40.2555 22.728 40.3929 22.7066 40.4856 22.6816V21.4565H39.0893V19.8248ZM49.3604 24.4043H44.7167V16.5828H49.3604V18.2787H46.8299V19.5092H49.1731V21.2051H46.8299V22.6816H49.3604V24.4043Z" fill="var(--secondary-color)"></path>
                    <path d="M2.47656 1.10978H1.58635V2V59.5217C1.58635 63.039 4.4376 65.8902 7.95482 65.8902H53.1505C56.6677 65.8902 59.519 63.039 59.519 59.5217V2V1.10978H58.6287H2.47656Z" stroke="var(--secondary-color)" stroke-width="1.78043"></path>
                    <path opacity="0.9" d="M6.58594 7.36133H54.5207" stroke="var(--secondary-color)" stroke-width="1.36957" stroke-linecap="round" stroke-dasharray="2.74 4.11"></path>
                    </svg>
                    <p>MADE FOR PLUS SIZE ONLY</p>
                </div>
                </div>
                <div class="product__variant--list mb-15">
                <div class="product__details--info__meta">
                    <p class="product__details--info__meta--list">
                    <strong>Category Name :</strong>
                    <span>{{$serviceData->CategoryData->category_name}}</span>
                    </p>
                </div>
                </div>
                <div class="quickview__social d-flex align-items-center mb-15">
                <label class="quickview__social--title">Social Share:</label>
                <ul class="quickview__social--wrapper mt-0 d-flex">
                    <li class="quickview__social--list">
                    <a class="quickview__social--icon" target="_blank" href="https://www.facebook.com/">
                        <svg xmlns="http://www.w3.org/2000/svg" width="7.667" height="16.524" viewBox="0 0 7.667 16.524">
                        <path data-name="Path 237" d="M967.495,353.678h-2.3v8.253h-3.437v-8.253H960.13V350.77h1.624v-1.888a4.087,4.087,0,0,1,.264-1.492,2.9,2.9,0,0,1,1.039-1.379,3.626,3.626,0,0,1,2.153-.6l2.549.019v2.833h-1.851a.732.732,0,0,0-.472.151.8.8,0,0,0-.246.642v1.719H967.8Z" transform="translate(-960.13 -345.407)" fill="currentColor"></path>
                        </svg>
                        <span class="visually-hidden">Facebook</span>
                    </a>
                    </li>
                    <li class="quickview__social--list">
                    <a class="quickview__social--icon" target="_blank" href="https://twitter.com/">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16.489" height="13.384" viewBox="0 0 16.489 13.384">
                        <path data-name="Path 303" d="M966.025,1144.2v.433a9.783,9.783,0,0,1-.621,3.388,10.1,10.1,0,0,1-1.845,3.087,9.153,9.153,0,0,1-3.012,2.259,9.825,9.825,0,0,1-4.122.866,9.632,9.632,0,0,1-2.748-.4,9.346,9.346,0,0,1-2.447-1.11q.4.038.809.038a6.723,6.723,0,0,0,2.24-.376,7.022,7.022,0,0,0,1.958-1.054,3.379,3.379,0,0,1-1.958-.687,3.259,3.259,0,0,1-1.186-1.666,3.364,3.364,0,0,0,.621.056,3.488,3.488,0,0,0,.885-.113,3.267,3.267,0,0,1-1.374-.631,3.356,3.356,0,0,1-.969-1.186,3.524,3.524,0,0,1-.367-1.5v-.057a3.172,3.172,0,0,0,1.544.433,3.407,3.407,0,0,1-1.1-1.214,3.308,3.308,0,0,1-.4-1.609,3.362,3.362,0,0,1,.452-1.694,9.652,9.652,0,0,0,6.964,3.538,3.911,3.911,0,0,1-.075-.772,3.293,3.293,0,0,1,.452-1.694,3.409,3.409,0,0,1,1.233-1.233,3.257,3.257,0,0,1,1.685-.461,3.351,3.351,0,0,1,2.466,1.073,6.572,6.572,0,0,0,2.146-.828,3.272,3.272,0,0,1-.574,1.083,3.477,3.477,0,0,1-.913.8,6.869,6.869,0,0,0,1.958-.546A7.074,7.074,0,0,1,966.025,1144.2Z" transform="translate(-951.23 -1140.849)" fill="currentColor"></path>
                        </svg>
                        <span class="visually-hidden">Twitter</span>
                    </a>
                    </li>
                    <li class="quickview__social--list">
                    <a class="quickview__social--icon" target="_blank" href="https://www.skype.com/">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16.482" height="16.481" viewBox="0 0 16.482 16.481">
                        <path data-name="Path 284" d="M879,926.615a4.479,4.479,0,0,1,.622-2.317,4.666,4.666,0,0,1,1.676-1.677,4.482,4.482,0,0,1,2.317-.622,4.577,4.577,0,0,1,2.43.678,7.58,7.58,0,0,1,5.048.961,7.561,7.561,0,0,1,3.786,6.593,8,8,0,0,1-.094,1.206,4.676,4.676,0,0,1,.7,2.411,4.53,4.53,0,0,1-.622,2.326,4.62,4.62,0,0,1-1.686,1.686,4.626,4.626,0,0,1-4.756-.075,7.7,7.7,0,0,1-1.187.094,7.623,7.623,0,0,1-7.647-7.647,7.46,7.46,0,0,1,.094-1.187A4.424,4.424,0,0,1,879,926.615Zm4.107,1.714a2.473,2.473,0,0,0,.282,1.234,2.41,2.41,0,0,0,.782.829,5.091,5.091,0,0,0,1.215.565,15.981,15.981,0,0,0,1.582.424q.678.151.979.235a3.091,3.091,0,0,1,.593.235,1.388,1.388,0,0,1,.452.348.738.738,0,0,1,.16.481.91.91,0,0,1-.48.753,2.254,2.254,0,0,1-1.271.321,2.105,2.105,0,0,1-1.253-.292,2.262,2.262,0,0,1-.65-.838,2.42,2.42,0,0,0-.414-.546.853.853,0,0,0-.584-.17.893.893,0,0,0-.669.283.919.919,0,0,0-.273.659,1.654,1.654,0,0,0,.217.782,2.456,2.456,0,0,0,.678.763,3.64,3.64,0,0,0,1.158.574,5.931,5.931,0,0,0,1.639.235,5.767,5.767,0,0,0,2.072-.339,2.982,2.982,0,0,0,1.356-.961,2.306,2.306,0,0,0,.471-1.431,2.161,2.161,0,0,0-.443-1.375,3.009,3.009,0,0,0-1.2-.894,10.118,10.118,0,0,0-1.865-.575,11.2,11.2,0,0,1-1.309-.311,2.011,2.011,0,0,1-.8-.452.992.992,0,0,1-.3-.744,1.143,1.143,0,0,1,.565-.97,2.59,2.59,0,0,1,1.488-.386,2.538,2.538,0,0,1,1.074.188,1.634,1.634,0,0,1,.622.49,3.477,3.477,0,0,1,.414.753,1.568,1.568,0,0,0,.4.594.866.866,0,0,0,.574.2,1,1,0,0,0,.706-.254.828.828,0,0,0,.273-.631,2.234,2.234,0,0,0-.443-1.253,3.321,3.321,0,0,0-1.158-1.046,5.375,5.375,0,0,0-2.524-.527,5.764,5.764,0,0,0-2.213.386,3.161,3.161,0,0,0-1.422,1.083A2.738,2.738,0,0,0,883.106,928.329Z" transform="translate(-878.999 -922)" fill="currentColor"></path>
                        </svg>
                        <span class="visually-hidden">Skype</span>
                    </a>
                    </li>
                    <li class="quickview__social--list">
                    <a class="quickview__social--icon" target="_blank" href="https://www.youtube.com/">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16.49" height="11.582" viewBox="0 0 16.49 11.582">
                        <path data-name="Path 321" d="M967.759,1365.592q0,1.377-.019,1.717-.076,1.114-.151,1.622a3.981,3.981,0,0,1-.245.925,1.847,1.847,0,0,1-.453.717,2.171,2.171,0,0,1-1.151.6q-3.585.265-7.641.189-2.377-.038-3.387-.085a11.337,11.337,0,0,1-1.5-.142,2.206,2.206,0,0,1-1.113-.585,2.562,2.562,0,0,1-.528-1.037,3.523,3.523,0,0,1-.141-.585c-.032-.2-.06-.5-.085-.906a38.894,38.894,0,0,1,0-4.867l.113-.925a4.382,4.382,0,0,1,.208-.906,2.069,2.069,0,0,1,.491-.755,2.409,2.409,0,0,1,1.113-.566,19.2,19.2,0,0,1,2.292-.151q1.82-.056,3.953-.056t3.952.066q1.821.067,2.311.142a2.3,2.3,0,0,1,.726.283,1.865,1.865,0,0,1,.557.49,3.425,3.425,0,0,1,.434,1.019,5.72,5.72,0,0,1,.189,1.075q0,.095.057,1C967.752,1364.1,967.759,1364.677,967.759,1365.592Zm-7.6.925q1.49-.754,2.113-1.094l-4.434-2.339v4.66Q958.609,1367.311,960.156,1366.517Z" transform="translate(-951.269 -1359.8)" fill="currentColor"></path>
                        </svg>
                        <span class="visually-hidden">Youtube</span>
                    </a>
                    </li>
                </ul>
                </div>
            
            </form>
            </div>
        </div>
        </div>
    </div>
    </section>
    <!-- End product details section -->

    <!-- Start product details tab section -->
    <section class="product__details--tab__section section--padding">
    <div class="container">
        <div class="row row-cols-1">
        <div class="col">
            <ul class="product__details--tab d-flex mb-30">
        
            <li class="product__details--tab__list active" data-toggle="tab" data-target="#description">
                Description
            </li>				
        
            </ul>
            <div class="product__details--tab__inner border-radius-10">
            <div class="tab_content">               
                <div id="description" class="tab_pane active show">
                <div class="product__tab--content">{!! $serviceData->service_description !!}
                </div>
                </div>           
            </div>
            </div>        
            </div>
            
        </div>
        </div>
    
    </section>
    <!-- End product details tab section -->
    @endif
</main>
@include('layouts.footer')
@endsection

@section('scripts')
<script>
  const quantityWrapper = document.querySelectorAll(".quantity__box");
quantityWrapper && quantityWrapper.forEach((function(e) {
    let t = e.querySelector(".quantity__number"),
        i = e.querySelector(".increase"),
        s = e.querySelector(".decrease");
    i.addEventListener("click", (function() {
        let e = parseInt(t.value, 10);
        e = isNaN(e) ? 0 : e, e++, t.value = e
    })), s.addEventListener("click", (function() {
        let e = parseInt(t.value, 10);
        e = isNaN(e) ? 0 : e, e < 2 && (e = 2), e--, t.value = e
    }))
}));

var sizetype ='';
$(".service").change(function() {
        // alert($(".service:checked").val());
        sizetype = $(".service:checked").val();
    });


$("#gocheckout").on("click", function(e) {

    e.preventDefault();

    var product_price = $('#current__price').text();
    var product_discount_price = $('#old__price').text();
    var service_id = $('#service_id').val();
  
    // var sizetype = $(".size-type:checked").val();
    // alert($(".size-type:checked").val());
    // alert(sizetype);
    var quantity = $("#quantity").val();
    var service_detail_id = $('input[name="size"]:checked').data("isprm");

            if(sizetype == undefined)
            {  
                    alert('Please select size.');

            }
            else{
                $.ajax({
                    type: "POST",
                    url: "{{url('addtocart') }}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: {
                        cart_service_original_price: product_price,
                        cart_service_discount_price:product_discount_price,
                        cart_service_unit: sizetype,
                        cart_service_quantity: quantity,
                        service_id:service_id,
                        service_detail_id:service_detail_id
                    },
                    success: function(response) {
                    
                    console.log(response);
                    if(response.result == true)
                    {
                        location.href = "{{url('cart')}}";
                    }
                    }
                });
            }
    });

// });
</script>
@endsection