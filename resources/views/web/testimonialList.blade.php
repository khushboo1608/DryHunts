@extends('layouts.app')
@section('style')
   <style>
    .radio-btns{
    display: flex;
    gap: 3rem;
    }
   </style>
@endsection
@section('content')
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KNK2NX9"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
@include('layouts.header')
    <section class="blog__section section--padding">
      <div class="container-fluid">
        <div class="radio-btns">        
            <div>
                <input type="radio" id="Product" value="Product" name="radio">
                <label for="Product" class="work-label">Filter by Product</label>
            </div>            
            <div>
                <input type="radio" id="Region" value="Region" name="radio">
                <label for="Region">Filter by Region</label>
            </div>        
        </div>

        <div id="filter_product" style="display: none;">
        <form action="{{url('testimonialList/filterproductdata')}}" class="form form-horizontal" method="post">
            @csrf
                <div class="form-group row">
                    <label for="category_id" class="col-sm-2 col-form-label">Category Name:-</label>
                    <div class="col-md-6">
                      <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true" name="category_id" id="category_id">
                      <option selected="true" disabled="disabled">Choose Category </option>
                          
                          @if(isset($master_data) && isset($master_data['category']))
                              @foreach ($master_data['category'] as $item)
                                  <option value="{{$item['category_id']}}">{{$item['category_name']}}</option>
                              @endforeach
                          @endif
                      </select>                
                    </div>
                  </div>
                  <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Service :-</label>
                      <div class="col-md-6">
                        <select name="service_id" id="service_id" class="form-control select2 filter" required="true">
                          <option selected="true" disabled="disabled">Choose Service</option>
                        </select>
                      </div>
                    </div> 
                    <button type="submit" name="submit" class="banner__items--content__link primary__btn style2">Filter</button>
            </form>
                <!-- </div>  -->
        </div>

        <div id="filter_region" style="display: none;">
        <form action="{{url('testimonialList/filterregiondata')}}" class="form form-horizontal" method="post">
        @csrf
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">State :-</label>
                    <div class="col-md-6">
                    <select name="state_id" id="state_id" class="form-control select2 filter" required="true">
                        <option selected="true" disabled="disabled">Choose State</option>
                        
                            @if(isset($master_data) && isset($master_data['state']))
                                @foreach ($master_data['state'] as $item)
                                    <option value="{{$item['state_id']}}">{{$item['state_name']}}</option>
                                @endforeach
                            @endif
                    </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">District :-</label>
                    <div class="col-md-6">
                    <select name="district_id" id="district_id" class="form-control select2 filter" required="true">
                        <option selected="true" disabled="disabled">Choose District</option>
                    </select>
                    </div>
                </div>                   
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Taluka :-</label>
                    <div class="col-md-6">
                    <select name="taluka_id" id="taluka_id" class="form-control select2 filter" required="true">
                        <option selected="true" disabled="disabled">Choose Taluka</option>                      
                    </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Pincode :-</label>
                    <div class="col-md-6">
                    <select name="pincode_id" id="pincode_id" class="form-control select2 filter" required="true">
                        <option selected="true" disabled="disabled">Choose Pincode</option>
                    </select>
                    </div>
                </div>  
                <button type="submit" name="submit" class="banner__items--content__link primary__btn style2">Filter</button>
            </form>
        </div>
        <div class="section__heading text-center mb-30">
          <h2 class="section__heading--maintitle">Testimonial List</h2>
        </div>
       
        <div class="blog__section_details row row-cols-lg-3 row-cols-md-2 row-cols-sm-2 row-cols-1 mb--n28">
        @if(isset($master_data['testimonial']))
              @foreach ($master_data['testimonial'] as $item)
          <div class="col mb-28">
            <div class="blog__items">
              <div class="blog__thumbnail">
           
                <a class="blog__thumbnail--link display-block" href="{{ url('testimonialDetails/'.$item['testimonial_id']) }}"><img class="blog__thumbnail--img display-block" src="{{$item['testimonial_image']}}" alt="blog-img"></a>
              </div>
              <div class="blog__content">
                <ul class="blog__content--meta d-flex">
                  <li class="blog__content--meta__text">
                    <svg class="blog__content--meta__icon" xmlns="http://www.w3.org/2000/svg" width="12.569" height="13.966" viewBox="0 0 12.569 13.966">
                      <path data-name="Icon material-date-range" d="M8.69,9.285h-1.4v1.4h1.4Zm2.793,0h-1.4v1.4h1.4Zm2.793,0h-1.4v1.4h1.4Zm1.4-4.888h-.7V3h-1.4V4.4H7.991V3h-1.4V4.4H5.9a1.39,1.39,0,0,0-1.39,1.4L4.5,15.569a1.4,1.4,0,0,0,1.4,1.4h9.776a1.4,1.4,0,0,0,1.4-1.4V5.793A1.4,1.4,0,0,0,15.673,4.4Zm0,11.173H5.9V7.888h9.776Z" transform="translate(-4.5 -3)" fill="currentColor"></path>
                    </svg>{{date('j F, Y',strtotime($item['created_at']))}}
                  </li>
                </ul>
                <h3 class="blog__content--title h4">
                  <a href="{{ url('testimonialDetails/'.$item['testimonial_id']) }}">{{$item['testimonial_title']}}
                  </a>
                </h3>
                <p class="blog__content--desc">
                {!! Str::words(strip_tags($item['testimonial_description']), 20) !!}
                </p>
                <a class="blog__content--btn primary__btn" href="{{ url('testimonialDetails/'.$item['testimonial_id']) }}">Read more
                </a>
              </div>
            </div>
          </div>
          @endforeach
        @endif
        </div>
      </div>
    </section>
@include('layouts.footer')
@endsection
@section('scripts')
<script type="text/javascript">

    $('input[type="radio"]').click(function(){
    
    if($(this).attr("value")=="Product"){
        $("#filter_product").show();
        $("#filter_region").hide();
    }
    if($(this).attr("value")=="Region"){
        $("#filter_region").show();
        $("#filter_product").hide();
    }        
    });

    // Listen for changes in the first dropdown
      $('#district_id').html("<option value='' selected disabled>--Select District--</option>");
      $('#state_id').on('change', function() {
          var selectedValue = $(this).val();

          // Make an Ajax request
          $.ajax({
              // url: '/admin/advertisementbanner/get-dropdown-options',
              url : '{{url("/testimonialList/get-options")}}',
              type: 'GET',
              data: { selectedValue: selectedValue },
              success: function(data) {
                  // Clear existing options in the second dropdown
                  $('#district_id').empty();
                  $('#district_id').html("<option value='' selected disabled >--Select District--</option>");
                  // Populate the second dropdown with the retrieved options
                  $.each(data, function(key, value) {
                      $('#district_id').append($('<option>', {
                          value: key,
                          text: value
                      }));
                  });
              }
          });
      });

      
      $('#taluka_id').html("<option value='' selected disabled>--Select Taluka--</option>");
      $('#district_id').on('change', function() {
          var selectedValue1 = $(this).val();

          // Make an Ajax request
          $.ajax({
              // url: '/admin/advertisementbanner/get-dropdown-options',
              url : '{{url("/testimonialList/get-taluka-options")}}',
              type: 'GET',
              data: { selectedValue1: selectedValue1 },
              success: function(data) {
                  // Clear existing options in the second dropdown
                  $('#taluka_id').empty();
                  $('#taluka_id').html("<option value='' selected disabled >--Select Taluka--</option>");
                  // Populate the second dropdown with the retrieved options
                  $.each(data, function(key, value) {
                      $('#taluka_id').append($('<option>', {
                          value: key,
                          text: value
                      }));
                  });
              }
          });
      });

      
      $('#pincode_id').html("<option value='' selected disabled>--Select Pincode--</option>");
      $('#taluka_id').on('change', function() {
          var selectedValue2 = $(this).val();

          // Make an Ajax request
          $.ajax({
              // url: '/admin/advertisementbanner/get-dropdown-options',
              url : '{{url("/testimonialList/get-pincode-options")}}',
              type: 'GET',
              data: { selectedValue2: selectedValue2 },
              success: function(data) {
                  // Clear existing options in the second dropdown
                  $('#pincode_id').empty();
                  $('#pincode_id').html("<option value='' selected disabled >--Select Pincode --</option>");
                  // Populate the second dropdown with the retrieved options
                  $.each(data, function(key, value) {
                      $('#pincode_id').append($('<option>', {
                          value: key,
                          text: value
                      }));
                  });
              }
          });
      });

      
      $('#service_id').html("<option value='' selected disabled>--Select Service--</option>");
      $('#category_id').on('change', function() {
          var selectedValue3 = $(this).val();

          // Make an Ajax request
          $.ajax({
              // url: '/admin/advertisementbanner/get-dropdown-options',
              url : '{{url("/testimonialList/get-service-options")}}',
              type: 'GET',
              data: { selectedValue3: selectedValue3 },
              success: function(data) {
                  // Clear existing options in the second dropdown
                  $('#service_id').empty();
                  $('#service_id').html("<option value='' selected disabled >--Select Service --</option>");
                  // Populate the second dropdown with the retrieved options
                  $.each(data, function(key, value) {
                      $('#service_id').append($('<option>', {
                          value: key,
                          text: value
                      }));
                  });
              }
          });
      });

      </script>
@endsection