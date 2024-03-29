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
            <h1>Pincode</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('admin/home')}}">Home</a></li>
              <li class="breadcrumb-item active">Pincode</li>
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
                <h3 class="card-title">Add Pincode</h3>
              </div>
              <div class="col-md-12 col-xs-12">
                    <div class="search_list">
                          <a href="{{url('admin/pincode')}}"><button type="button"  class="btn btn-primary waves-effect waves-light"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Back</button></a>                        
                    </div>
                </div>    
              </div>
              
              <!-- /.card-header -->
              <div class="card-body">
              <form class="form-horizontal" action="{{route('pincode.savepincode')}}" method="post" enctype="multipart/form-data">
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
              <input type="hidden" name="id" id="id" value="">   
                <div class="card-body">
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
                          
                                <!-- @if(isset($master_data) && isset($master_data['district']))

                                    @foreach ($master_data['district'] as $item)
                                        <option value="{{$item['district_id']}}">{{$item['district_name']}}</option>
                                    @endforeach
                                @endif -->
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Taluka :-</label>
                      <div class="col-md-6">
                        <select name="taluka_id" id="taluka_id" class="form-control select2 filter" required="true">
                          <option selected="true" disabled="disabled">Choose Taluka</option>
                          
                                <!-- @if(isset($master_data) && isset($master_data['district']))

                                    @foreach ($master_data['district'] as $item)
                                        <option value="{{$item['district_id']}}">{{$item['district_name']}}</option>
                                    @endforeach
                                @endif -->
                        </select>
                      </div>
                    </div>
                <div class="form-group row">
                    <label for="pincode" class="col-sm-2 col-form-label">Pincode Name :-</label>
                    <div class="col-sm-6">
                      <input type="Text" class="form-control" id="pincode" name="pincode" placeholder="Pincode Name" required="true">
                    </div>
                  </div>                                   

                  <div class="form-group row">
                      <div class="col-sm-6 col-md-offset-3 text-center">
                        <button type="submit" name="submit" class="btn btn-primary">Save</button>
                        <a class="btn btn-danger" href="{{url('admin/pincode')}}">Cancel</a>
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
      $('#district_id').html("<option value='' selected disabled>--Select District--</option>");
      $('#state_id').on('change', function() {
          var selectedValue = $(this).val();

          // Make an Ajax request
          $.ajax({
              // url: '/admin/advertisementbanner/get-dropdown-options',
              url : '{{url("admin/pincode/get-dropdown-options")}}',
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
              url : '{{url("admin/pincode/get-dropdown-taluka-options")}}',
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

      </script>
@endsection