@extends('admin.layouts.app')
@section('content')
{{-- Sidebar goes here --}}
    @include('admin.layouts.sidebar')
    {{-- Header goes here --}}
    @include('admin.layouts.header')
<!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Sub Admin</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('admin/home')}}">Home</a></li>
              <li class="breadcrumb-item active">Sub Admin</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
              
              <div class="col-md-5 col-xs-12">
                <h3 class="card-title">Edit Sub Admin</h3>
              </div>
              <div class="col-md-12 col-xs-12">
                    <div class="search_list">
                          <a href="{{url('admin/subadmin')}}"><button type="button"  class="btn btn-primary waves-effect waves-light"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Back</button></a>                        
                    </div>
                </div>    
              </div>
              
              <!-- /.card-header -->
              <div class="card-body">
              <form class="form-horizontal" action="{{route('subadmin.savesubadmin')}}" method="post" enctype="multipart/form-data">
              @csrf
              @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
              <input type="hidden" name="id" id="id"  value="{{$subadmin->id}}">   
                <div class="card-body">
                  <div class="form-group row">
                    <label for="name" class="col-sm-2 col-form-label">Name :-</label>
                    <div class="col-sm-6">
                    <input id="name" name="name" value="{{$subadmin->name}}" type="text" class="form-control" required="true">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="email" class="col-sm-2 col-form-label">Email :-</label>
                    <div class="col-sm-6">
                    <input id="email" name="email" value="{{$subadmin->email}}" type="email" class="form-control" required="true">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="password" class="col-sm-2 col-form-label">Password :-</label>
                    <div class="col-sm-6">
                    <input id="password" name="password" value="" type="password" minlength="6" class="form-control" >
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="phone " class="col-sm-2 col-form-label">Phone no. :-</label>
                    <div class="col-sm-6">
                    <input id="phone" name="phone" value="{{$subadmin->phone}}" maxlength="10" type="number" class="form-control" required="true">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="imageurl" class="col-sm-2 col-form-label">Select Image :-</label>
                    <div class="col-sm-6">
                      <div class="fileupload_block">
                      <input name="imageurl"  type="file" accept="image/png, image/jpeg, image/jpg" value="{{$subadmin->imageurl}}" id="imageurl"  >
                                @if(isset($subadmin) && isset($subadmin->imageurl))
                                @if($subadmin->imageurl !='')
                            <div class="fileupload_img"><img type="image" src="{{$subadmin->imageurl}}" style="height: 80px;width: 80px;margin-left: 20px;"/></div>
                            @else
                            <div class="fileupload_img"><img type="image" src="{{config('global.no_image.add_image');}}" /></div>
                            @endif
                          @endif
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">SubAdmin Type :-</label>
                    <div class="col-md-6">
                      <select name="login_type" id="login_type" class="form-control select2 filter" >
                      <option selected="true" disabled="disabled">Choose Sub Admin Type</option>
                         <option value="3" {{ 3 == $subadmin->login_type ? 'selected' : '' }}>District Admin</option>
                         <option value="4" {{ 4 == $subadmin->login_type ? 'selected' : '' }}>Taluka Admin</option>
                      </select>
                    </div>
                  </div>
                 
                  <div class="form-group row">
                      <label class="col-sm-2 col-form-label">State :-</label>
                      <div class="col-md-6">
                        <select name="state_id"  id="state_id" class="form-control select2 filter" >
                          <option selected="true" disabled="disabled">Choose State</option>
                          
                                @if(isset($master_data) && isset($master_data['state']))
                                @foreach ($master_data['state'] as $item)
                                        <option value="{{ $item['state_id'] }}" {{ ( $item['state_id'] == $subadmin['state_id']) ? 'selected' : '' }}> {{$item['state_name']}} </option>
                                    @endforeach
                                @endif
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">District :-</label>
                      <div class="col-md-6">
                        <select name="district_id"  id="district_id" class="form-control select2 filter" >
                        <option value="0">--Select District--</option>
                                      @foreach($master_data['district'] as $list)
                                          @if( $subadmin['district_id']==$list['district_id'])
                                              <option selected value="{{$list['district_id']}}">{{$list['district_name']}}</option>
                                          @else
                                              <option  value="{{$list['district_id']}}">{{$list['district_name']}}</option>
                                          @endif
                                      @endforeach
                            </select> 
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Taluka :-</label>
                      <div class="col-md-6">
                        <select name="taluka_id"  id="taluka_id" class="form-control select2 filter" >
                        <option value="0">--Select Taluka--</option>
                                      @foreach($master_data['taluka'] as $list)
                                          @if( $subadmin['taluka_id']==$list['taluka_id'])
                                              <option selected value="{{$list['taluka_id']}}">{{$list['taluka_name']}}</option>
                                          @else
                                              <option  value="{{$list['taluka_id']}}">{{$list['taluka_name']}}</option>
                                          @endif
                                      @endforeach
                            </select> 
                      </div>
                    </div>         
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Pincode :-</label>
                      <div class="col-md-6">
                        <select name="pincode_id"  id="pincode_id" class="form-control select2 filter" >
                        <option value="0">--Select Pincode--</option>
                                      @foreach($master_data['pincode'] as $list)
                                          @if( $subadmin['pincode_id']==$list['pincode_id'])
                                              <option selected value="{{$list['pincode_id']}}">{{$list['pincode']}}</option>
                                          @else
                                              <option  value="{{$list['pincode_id']}}">{{$list['pincode']}}</option>
                                          @endif
                                      @endforeach
                            </select> 
                      </div>
                    </div>  
                  <div class="form-group row">
                      <div class="col-sm-6 col-md-offset-3 text-center">
                        <button type="submit" name="submit" class="btn btn-primary">Save</button>
                        <a class="btn btn-danger" href="{{url('admin/subadmin')}}">Cancel</a>
                      </div>
                  </div>
                </div>

              </form>
                    <!-- </div> -->
                </div>
              </div>
              <!-- /.card-body -->
            </div>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
         {{-- Footer goes here --}}
         <!-- @include('admin.layouts.footer') -->
     </div>
 </div>
                    <!-- </div> -->
                </div>
              </div>
              <!-- /.card-body -->
            </div>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
         {{-- Footer goes here --}}
         <!-- @include('admin.layouts.footer') -->
     </div>
 </div>
@endsection
@section('scripts')
<script type="text/javascript">

    // Listen for changes in the first dropdown
      // $('#district_id').html("<option value='' selected disabled>--Select District--</option>");
      $('#state_id').on('change', function() {
          var selectedValue = $(this).val();

          // Make an Ajax request
          $.ajax({
              // url: '/admin/advertisementbanner/get-dropdown-options',
              url : '{{url("admin/testimonial/get-dropdown-options")}}',
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

      
      // $('#taluka_id').html("<option value='' selected disabled>--Select Taluka--</option>");
      $('#district_id').on('change', function() {
          var selectedValue1 = $(this).val();

          // Make an Ajax request
          $.ajax({
              // url: '/admin/advertisementbanner/get-dropdown-options',
              url : '{{url("admin/testimonial/get-dropdown-taluka-options")}}',
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

      
      // $('#pincode_id').html("<option value='' selected disabled>--Select Pincode--</option>");
      $('#taluka_id').on('change', function() {
          var selectedValue2 = $(this).val();

          // Make an Ajax request
          $.ajax({
              // url: '/admin/advertisementbanner/get-dropdown-options',
              url : '{{url("admin/testimonial/get-dropdown-pincode-options")}}',
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

      </script>
@endsection