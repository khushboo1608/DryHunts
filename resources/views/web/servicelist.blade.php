@extends('layouts.app')
@section('content')
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KNK2NX9"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
@include('layouts.header')
<section class="shop__section section--padding">
      <div class="container-fluid">
        <div class="row">
          <div class="col-xl-9 col-lg-8 shop__sidebar--widget-data">
            <div class="shop__product--wrapper">
              <div class="tab_content">
                <div id="product_grid" class="tab_pane active show">
                  <div class="product__section--inner product__grid--inner">
                 
                    <div class="row row-cols-xxl-3 row-cols-xl-3 row-cols-lg-3 row-cols-md-3 row-cols-2 mb--n30">
                    @if(isset($master_data) && isset($master_data['service']))

                    <?php 
                    // echo count($master_data['service']);die;
                    ?>
                      @if(count($master_data['service']) > 0)
                        @foreach ($master_data['service'] as $item)
                          <div class="col mb-30">
                          
                            <div class="product__items">
                              <div class="product__items--thumbnail product-lists">
                              @php
                                    $data = app('App\Http\Controllers\Controller');
                                    $img1= $data->GetImage($file_name = $item['service_single_image'],$path=config('global.file_path.service_image'));
                                    @endphp
                                <a class="product__items--link" href="{{ url('servicedetails/'.$item['service_id']) }}">
                                  <img class="product__items--img product__primary--img" src="{{$img1}}" alt="product-img">
                                </a>
                                <!-- <div class="product__badge">
                                  <span class="product__badge--items sale">New</span>
                                </div> -->
                              </div>
                              <div class="product__items--content responsive-product text-center">
                                
                                <h3 class="product__items--content__title h4">
                                  <a href="#">{{$item['service_name']}}</a>
                                </h3>
                                <div class="product__items--price">
                                  <span class="current__price">₹ {{$item['ServiceDetails'][0]['service_discount_price']}}</span>
                                  <span class="old__price">₹ {{$item['ServiceDetails'][0]['service_original_price']}}</span>
                                </div>
                              </div>
                            </div>
                          
                          </div>
                        @endforeach
                        
                      @else
                      <div class="col mb-30" style="text-align: center;position: absolute;left: 0;right: 0;margin: 0px 50%;font-size: 30px;">No data found.</div>
                       
                      @endif
                    @endif
                    </div>
                    
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
@include('layouts.footer')
@endsection

