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
            <h1>Request</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('admin/home')}}">Home</a></li>
              <li class="breadcrumb-item active">Request</li>
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
                <h3 class="card-title">Edit Request</h3>
              </div>
              <div class="col-md-12 col-xs-12">
                    <div class="search_list">
                          <a href="{{url('admin/order')}}"><button type="button"  class="btn btn-primary waves-effect waves-light"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Back</button></a>                        
                    </div>
                </div>    
              </div>
              
              <!-- /.card-header -->
              <div class="card-body">
              <form class="form-horizontal" action="{{route('order.saveorder')}}" method="post" enctype="multipart/form-data">
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
              <input type="hidden" name="id" id="id" value="{{$orderData->order_id}}">  
              <input type="hidden" name="user_id" id="user_id" value="{{$orderData->user_id}}">  
                <div class="card-body">
                <div class="form-group row">
                <label class="col-md-2 control-label">User Details:-</label>
                <div class="col-md-3">
                  <input type="text" value="{{$orderData->User->name}}" class="form-control" readonly>
                </div>
                <div class="col-md-3">
                  <input type="text" value="{{$orderData->User->phone}}" class="form-control" readonly>
                </div>
              </div>
              <div class="form-group">
                  <label class="col-md-2 control-label">Service details :-</label>
                  <div class="col-md-10">
                    <table id="t01" style="width:100%" border=1>
                      <tr>
                        <th>Service Name</th>
                        <th>SKU Code</th>
                        <th>Image</th>
                        <th>Variation</th>
                        <th>Price</th>
                      </tr>       
                      <tbody>   
                      @foreach($orderData->OrderDetails as $details)

                      <?php 
                      $service_single_image =url(config('global.file_path.service_image')).'/'.$details->ServiceData->service_single_image;
                      // echo $path;die;
                      ?>
                     
                      <input type="hidden" name="order_detail_id []" id="order_detail_id " value="{{$details->order_detail_id }}"> 
                      <tr>
                        
                            <td>
                              <!-- <div class="cart__content">  -->
                              <h4 class="cart__content--title"> {{$details->ServiceData->service_name}} </h4>
                            </td>
                            <td>
                                <span class="cart__content--variant">{{$details->ServiceData->service_sku}} </span><br>
                                      
                              <!-- </div> -->
                            </td>
                              <td>
                                <div class="cart__thumbnail">
                                  <?php if($service_single_image != "") { ?>
                                  <span class="category_img"><img style="height: 50px;width: 50px;" src="{{$service_single_image}}"/></span><?php } ?>
                                </div><br>
                              </td>
                              <td>
                                <span class="cart__content--variant">{{$details->order_quantity}} {{$details->order_unit}} </span><br>
                                      
                              <!-- </div> -->
                            </td>
                                    
                        <td>{{$details->order_discount_price}}</td>
                      </tr> 
                        @endforeach                       
                      </tbody>
                    </table>
                  </div>
                </div> 
                  <div class="form-group row">
                    <label for="order_discount_amount" class="col-sm-2 col-form-label">Request Total Amount :-</label>
                    <div class="col-sm-6">
                      <input type="Text" class="form-control" id="order_discount_amount" name="order_discount_amount" placeholder="Request Cancel Reason"  value="{{$orderData->order_discount_amount}}">
                    </div>
                  </div>
                  @php
                                  $timezone = 'Asia/Kolkata';
                                  $currentTime = $details->created_at->timezone($timezone);
                              @endphp
                <div class="form-group row">
                <label class="col-md-2 control-label">Created Date :-</label>
                @if(isset($details) && isset($currentTime)) 
                            
                <div class="col-md-3">
                  <input type="text" value="{{$currentTime->format('d/m/Y') }}" class="form-control" readonly>
                </div>
                <div class="col-md-3">
                  <input type="text" value="{{$currentTime->format('H:i:s a') }}" class="form-control" readonly>
                </div>
                @endif
              </div>
                  <div class="form-group row">
                    <label for="quotation_remark" class="col-sm-2 col-form-label">Remark :-</label>
                    <div class="col-sm-6">
                      <input type="Text" class="form-control" id="quotation_remark" name="quotation_remark" placeholder="Remark"  value="{{$orderData->quotation_remark}}">
                    </div>
                  </div>
                  
                  <!-- <div class="form-group row">
                    <label for="quotation_pdf" class="col-sm-2 col-form-label">Select Quotation PDF:-</label>
                    <div class="col-sm-6">
                      <div class="fileupload_block">
                        <input name="quotation_pdf"  type="file" value="fileupload" id="fileupload"  accept="application/pdf">
                          @if(isset($orderData) && isset($orderData->quotation_pdf))
                              @if($orderData->quotation_pdf !='')
                            <div class="fileupload_img" style="margin-left: 20px;">{{$orderData->quotation_pdf}}</div>
                            @else
                            <div class="fileupload_img"><img type="image" src="{{asset('admin_assets/images/add-image.png')}}" /></div>
                            @endif
                          @endif
                      </div>
                    </div>
                  </div> -->
                  <div class="form-group row">
                    <label class="col-md-2 control-label">Request Status :-</label>
                    <div class="col-md-3">
                      <select name="order_type" id="order_type" style="width:280px; height:25px;" class="select2" >
                        @if(isset($orderData) && isset($orderData->order_type)) 
                         <option value="1" {{ 1 == $orderData->order_type ? 'selected' : '' }}>Pending</option>
                         <option value="2" {{ 2 == $orderData->order_type ? 'selected' : '' }}>Accepted</option>
                         <option value="3" {{ 3 == $orderData->order_type ? 'selected' : '' }}>Work In Progress</option>
                         <option value="4" {{ 4 == $orderData->order_type ? 'selected' : '' }}>Completed</option>
                         <option value="5" {{ 5 == $orderData->order_type ? 'selected' : '' }}>Cancelled</option>
                      </select>
                        @endif
                    </div>
                  </div>
                  <!-- <div class="form-group row">
                    <label for="cancel_reason" class="col-sm-2 col-form-label">Order Cancel Reason :-</label>
                    <div class="col-sm-6">
                      <input type="Text" class="form-control" id="cancel_reason" name="cancel_reason" placeholder="Order Cancel Reason"  value="{{$orderData->cancel_reason}}">
                    </div>
                  </div> -->
                  <div class="form-group row">
                      <div class="col-sm-6 col-md-offset-3 text-center">
                        <button type="submit" name="submit" class="btn btn-primary">Save</button>
                        <a class="btn btn-danger" href="{{url('admin/order')}}">Cancel</a>
                      </div>
                  </div>
                </div>
              </form>
                    <!-- </div> -->
                </div>
                <div class="form-group">
                  <label class="col-md-2 control-label">Request Log :-</label>
                  <div class="col-md-10">
                    <table id="t01" style="width:100%" border=1>
                      <tr>
                        <th>Id</th>
                        <th>User Name</th>
                        <th>description</th>
                        <th>Date</th>
                      </tr>       
                      <tbody>   
                      @if(isset($master_data) && !empty($master_data)) 
                      @foreach($master_data as $details)
                      <tr>
                        <?php 
                        // echo "<pre>";
                        // print_r($details->UserData->name);die;
                        ?>
                        
                            <td>
                              <h4 class="cart__content--title">{{ $loop->iteration }} </h4>
                              
                            </td>
                            <td>
                                <span class="cart__content--variant">{{$details->UserData->name}}</span><br>
                            </td>
                              <td>{{$details->description}}
                              </td>
                              <td>
                              @php
                                  $timezone = 'Asia/Kolkata';
                                  $currentTime = $details->created_at->timezone($timezone);
                                  
                              @endphp
                              {{ date('F j, Y, g:i a',strtotime($currentTime))}}
                            </td>
                      </tr> 
                        @endforeach  
                        @endif                     
                      </tbody>
                    </table>
                  </div>
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