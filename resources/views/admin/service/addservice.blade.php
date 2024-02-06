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
            <h1>Service</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('admin/home')}}">Home</a></li>
              <li class="breadcrumb-item active">Service</li>
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
                <h3 class="card-title">Add Service</h3>
              </div>
              <div class="col-md-12 col-xs-12">
                    <div class="search_list">
                          <a href="{{url('admin/service')}}"><button type="button"  class="btn btn-primary waves-effect waves-light"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Back</button></a>                        
                    </div>
                </div>    
              </div>
              
              <!-- /.card-header -->
              <div class="card-body">
              <form class="form-horizontal" action="{{route('service.saveservice')}}" method="post" enctype="multipart/form-data">
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
                    <label for="service_name" class="col-sm-2 col-form-label">Service Name :-</label>
                    <div class="col-sm-6">
                      <input type="Text" class="form-control" id="service_name" name="service_name" placeholder="Service Name" required="true">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="service_description" class="col-sm-2 col-form-label">Service Description:-</label>
                    <div class="col-sm-6">
                      <!-- <textarea type="Text" class="form-control" id="service_description" name="service_description" placeholder="Service Description" required="true"></textarea> -->
                      <textarea name="service_description" id="service_description" class="form-control" placeholder="Service Description"></textarea>
                                <script src="https://cdn.ckeditor.com/4.5.6/standard/ckeditor.js"></script> 
                                <script>CKEDITOR.replace( 'service_description' );</script>
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <label for="imageurl" class="col-sm-2 col-form-label">Select Image :-</label>
                    <div class="col-sm-6">
                      <div class="fileupload_block">
                        <input name="imageurl"  type="file" value="fileupload" id="fileupload" required="true" accept="image/png, image/jpeg, image/jpg">
                        <div class="fileupload_img"><img type="image" src="{{asset('admin_assets/images/add-image.png')}}"  /></div>
                      </div>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="service_multiple_image" class="col-sm-2 col-form-label">Select Gallery Images :-</label>
                    <div class="col-sm-6">
                      <div class="fileupload_block">
                        <input type="file" name="service_multiple_image[]" value="fileupload" id="fileupload" multiple accept="image/png, image/jpeg, image/jpg">

                        <div class="fileupload_img"><img type="image" src="{{asset('admin_assets/images/add-image.png')}}"  /></div>
                      </div>
                    </div>
                  </div>
                  
                   <!-- <div class="form-group row">
                    <label for="service_price" class="col-sm-2 col-form-label">Service Price :-</label>
                    <div class="col-sm-6">
                      <input type="Text" class="form-control" id="service_price" name="service_price" placeholder="Service price" required="true">
                    </div>
                  </div> -->
                  <div class="form-group row">
                    <label for="service_sku" class="col-sm-2 col-form-label">Service SKU :-</label>
                    <div class="col-sm-6">
                      <input type="Text" class="form-control" id="service_sku" name="service_sku" placeholder="Service SKU" required="true">
                    </div>
                  </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Is Popular :-</label>
                      <div class="col-md-6">
                        <input type="checkbox" id="is_popular" name="is_popular" />
                      </div>
                    </div>  
                  
                  <div class="form-group row">
                    <!-- <label class="col-md-3 control-label">Other:-</label> -->
                      <div id="activity_div" >
                          <div class="row">
                              <!-- <div class="col-md-2 packate_div">
                                  <label>Quantity:</label> <i class="text-danger asterik"></i><input type="Text" class="form-control" id="service_quantity" name="service_quantity[]" placeholder="Service quantity" required="true">
                              </div> -->
                              <div class="col-md-2 packate_div">
                                  <label>Unit:</label> <i class="text-danger asterik"></i><input type="Text" class="form-control" id="service_unit" name="service_unit[]" placeholder="Service unit" required="true">
                              </div>
                              <div class="col-md-2 packate_div">
                                  <label>Orignal Price:</label> <i class="text-danger asterik"></i><input type="Text" class="form-control" id="service_original_price" name="service_original_price[]" placeholder="Service orignal price" required="true">
                              </div>
                              <div class="col-md-2 packate_div">
                                  <label >Discount Price:</label> <i class="text-danger asterik"></i>
                                  <input type="text" class="form-control"  name="service_discount_price[]" required=""  placeholder="Service discount price"/>
                              </div>
                              <div class="col-md-1 packate_div">
                                  <label>Add</label>
                                  <a id="add_activity" title="Add activity" style="cursor: pointer;"><i class="fa fa-plus-square-o fa-2x"></i></a>
                              </div>
                          </div>
                      </div>                      
                      <div id="activites"></div>
                  </div>                 
                  <div class="form-group row">
                      <div class="col-sm-6 col-md-offset-3 text-center">
                        <button type="submit" name="submit" class="btn btn-primary">Save</button>
                        <a class="btn btn-danger" href="{{url('admin/service')}}">Cancel</a>
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

$(document).ready(function(e) {
  $(document).on('click', '.remove_activity', function() {
      $(this).closest('.row').remove();    
  });

  $('#add_activity').on('click', function() {
      html = '<div class="row"><div class="col-md-2 packate_div"><label>Unit:</label> <i class="text-danger asterik"></i><input type="Text" class="form-control" id="service_unit" name="service_unit[]" placeholder="Service unit" required="true"></div><div class="col-md-2 packate_div"><label>Orignal Price:</label> <i class="text-danger asterik"></i><input type="Text" class="form-control" id="service_original_price" name="service_original_price[]" placeholder="Service orignal price" required="true"></div><div class="col-md-2 packate_div"><label >Discount Price:</label> <i class="text-danger asterik"></i><input type="text" class="form-control"  name="service_discount_price[]" required=""  placeholder="Service discount price"/></div><div class="col-md-1" style="display: grid;"><label>Remove</label><a class="remove_activity text-danger" title="Remove activity" style="cursor: pointer;"><i class="fa fa-times fa-2x"></i></a></div></div>';
      $('#activites').append(html);
    });



});
</script>
@endsection