@extends('admin.layouts.app')

@section('style')
   <style>
    #example1 {
        width: unset !important;
    }
   </style>
@endsection
@section('content')
{{-- Header goes here --}}
    @include('admin.layouts.header')
{{-- Sidebar goes here --}}
    @include('admin.layouts.sidebar')
    
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
                <h3 class="card-title">Manage Pincode</h3>
              </div>
              <div class="col-md-12 col-xs-12">
                    <div class="search_list">
                        <div class="add_btn_primary">
                            <a href="{{url('admin/add_pincode')}}">Add Pincode</a> &nbsp;&nbsp;
                        </div>
                    </div>
                </div>    
              </div>
              <div class="col-lg-12">
                    <div class="search_list">
                        <div class="add_btn_primary">
                            <a href="{{route('pincodefile-export')}}">CSV Export</a> &nbsp;&nbsp;
                        </div>
                    </div>
                </div> 
                <div class="col-lg-12">
                    <div class="checkbox" style="width: 95px;margin-top: 5px;float: left;right: 103px;position: absolute;">
                        <input type="checkbox"  id="checkall">
                        <label for="checkall">
                        Select All
                        </label>
                    </div>
                    <form method="post">
                        <div class="dropdown" style="float:right">
                            <button class="btn btn-primary dropdown-toggle btn_delete" type="button" data-toggle="dropdown" style="margin-right: 10px;">Action
                            <span class="caret"></span></button>
                            <ul class="dropdown-menu" style="right:0;left:auto;">
                                <li><a href="javascript:void(0)" class="actions" name="enable" data-action="enable">Enable</a></li>
                                <li><a href="javascript:void(0)" class="actions" name="disable" data-action="disable">Disable</a></li>
                                <li><a href="javascript:void(0)" class="actions" name="delete" data-action="delete">Delete !</a></li>
                            </ul>
                        </div>
                    </form>
                </div>
          <!-- </div>  -->
              
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row mrg-top">
                  <div class="col-md-12">
                        <div class="col-md-12 col-sm-12">
                            @if(session()->has('message')) 
                             <div class="alert alert-success alert-dismissible" role="alert"> 
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                                </button>
                                {{session('message')}}</a> 
                            </div>
                            @endif   
                        </div>
                  </div>
                </div>
              
                    <!-- <div class="col-sm-12"> -->
                    <table id="example1" class="table table-bordered table-striped dataTable dtr-inline" aria-describedby="example1_info">
                    <thead>
                        <tr>
                            <th></th>
                            <th>No</th>
                            <th>Pincode Name</th>
                            <th>Taluka Name </th>
                            <th>District Name </th>
                            <th>State Name </th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
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
         @include('admin.layouts.footer')
     </div>
 </div>
@endsection
@section('scripts')
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script src="https://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
 <!--Data Table-->
 <script type="text/javascript"  src=" https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
 
 <!-- <script type="text/javascript"  src="https://gyrocode.github.io/jquery-datatables-checkboxes/1.2.7/js/dataTables.checkboxes.min.js"></script> -->
 <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">
    var table;

    $(function () {
    
        var table = $('#example1').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{url('admin/pincode') }}",
            
            'columnDefs': [
                {
                    'targets': 0,
                    'checkboxes': {
                        'selectRow': true
                    }
                }
            ],
            'select': {
                'style': 'multi'
            },
            "order": [[ 1, 'asc' ]],
            columns: [
            {data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},  
                {data: 'pincode', name: 'pincode'},
                {data: 'taluka_name', name: 'taluka_name'},                
                {data: 'district_name', name: 'district_name'},                
                {data: 'state_name', name: 'state_name'},                
                {data: 'pincode_status', name: 'pincode_status'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    
    });
    function DeletePincode(pincodeId)
    {
        swal({
            title: "Are you sure ??",
            text: "You will not be able to recover this Pincode!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
          if (willDelete) {
                var delurl = "{{url('admin/pincode_delete')}}";
                $.ajax({
                    url: delurl,
                    type: "post",
                    data: {"_token": "{{ csrf_token() }}",'id': pincodeId},
                    dataType: 'json',
                    success: function (data) {
                        if (data.result == true)
                        {
                            swal("Deleted!", data.message, "success");
                            $('#example1').DataTable().ajax.reload();
                        } else {
                            swal(data.message);
                        }
                    },
                    error: function (request, status, error) {
                        if(request.status == 419)
                        {
                            location.href = "{{url('admin/pincode')}}";
                        }
                    }
                });
            }
        });
    }

    function Status(pincodeId,status)
    {
        console.log(status);
        if(status == 0)
        {
            var btn_text = 'Disable';            
            var status = 1;
        }
        else
        {
            var btn_text = 'Enable';
            var status = 0;
        }
        swal({
            title: "Are you sure ?",
            text: "You want to "+btn_text+" this Pincode!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
          if (willDelete) {
                var delurl = "{{url('admin/pincode_status')}}";
                $.ajax({
                    url: delurl,
                    type: "post",
                    data: {"_token": "{{ csrf_token() }}",'id': pincodeId,'is_disable':status},
                    dataType: 'json',
                    success: function (data) {
                        if (data.result == true)
                        {
                            swal(data.text, data.message, "success");
                            $('#example1').DataTable().ajax.reload();
                        } else {
                            swal(data.message);
                        }
                    },
                    error: function (request, status, error) {
                        if(request.status == 419)
                        {
                            location.href = "{{url('admin/pincode')}}";
                        }
                    }
                });
            }
        });
    }

    $(".actions").click(function(e){
      e.preventDefault();

      var _ids = $.map($('.pincode_ids:checked'), function(c){return c.value; });
      var _action=$(this).data("action");
      
     
      if(_ids!='')
      {
        swal({
            title: "Action: "+$(this).text(),
            text: "Do you really want to perform?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
          if (willDelete) {
                var delurl = "{{url('admin/pincode_multi_status')}}";
                $.ajax({
                    url: delurl,
                    type: "post",
                    data: {"_token": "{{ csrf_token() }}",'id': _ids,'action':_action},
                    dataType: 'json',
                    success: function (data) {
                        if (data.result == true)
                        {
                            swal(data.text, data.message, "success");
                            // $('#example1').DataTable().ajax.reload();
                            location.reload();
                        } else {
                            swal(data.message);
                        }
                    },
                    error: function (request, status, error) {
                        if(request.status == 419)
                        {
                            location.href = "{{url('admin/pincode')}}";
                        }
                    }
                });
            }
        });
      }
      else{
        swal({title: 'Sorry no pincode selected!', type: 'info'});
      }
    });

    $("#checkall").click(function () {

      totalItems=0;

      $('input:checkbox').not(this).prop('checked', this.checked);
      $.each($("input[name='pincode_ids[]']:checked"), function(){
        totalItems=totalItems+1;
      });

    });
</script>
@endsection