@extends('admin.layouts.app')

@section('style')
   <style>
    #user {
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
            <h1>Users</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('admin/home')}}">Home</a></li>
              <li class="breadcrumb-item active">Users</li>
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
                <h3 class="card-title">Manage Users</h3>
                <div class="col-md-12 col-xs-12">
                    <div class="search_list">
                        <div class="add_btn_primary">
                            <a href="{{url('admin/add_user')}}">Add User</a> &nbsp;&nbsp;
                        </div>
                    </div>
                </div>   
              </div> 
              <div class="col-lg-12">
                  <div class="search_list">
                      <div class="add_btn_primary">
                          <a href="{{route('userfile-export')}}">CSV Export</a> &nbsp;&nbsp;
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
              
              <!-- /.card-header -->
              <div class="card-body">
                    <!-- <div class="col-sm-12"> -->
                    <table id="user" class="table table-bordered table-striped dataTable dtr-inline" aria-describedby="example1_info">.
                    <thead>
                        <tr>
                          <th></th>
                            <th>No</th>
                            <th>Name</th>
                            <th>Image</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Is Verified </th>
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
    <!-- <script type="text/javascript"  src=" https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script> -->

    <!-- <script src="{{url('public/admin/js/datatables/datatables.min.js')}}"></script>
<script src="{{url('public/admin/js/datatables/dataTables.bootstrap4.min.js')}}"></script> -->

 <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">
    var table;

    $(function () {
    
      var table = $('#user').DataTable({
          processing: true,
          serverSide: true,
         
          ajax: "{{url('admin/user') }}",
          "order": [[ 1, 'asc' ]],
          columns: [
            {data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
              {data: 'id', name: 'id'},
              {data: 'name', name: 'name'},
              {data: 'imageurl', name: 'imageurl', orderable: false, searchable: false,render:function (data, type, row) {return  "<img style='height:50px;width:50px;border-radius: 25px;' src='"+data+"'>"}},
              {data: 'email', name: 'email'},
              {data: 'phone', name: 'phone'},
              {data: 'is_verified', name: 'is_verified'},              
              {data: 'is_disable', name: 'is_disable'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ]
      });
    
    });
    function DeleteUser(UserId)
    {
        swal({
            title: "Are you sure ??",
            text: "You will not be able to recover this user!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
          if (willDelete) {
                var delurl = "{{url('admin/user_delete')}}";
                $.ajax({
                    url: delurl,
                    type: "post",
                    data: {"_token": "{{ csrf_token() }}",'id': UserId},
                    dataType: 'json',
                    success: function (data) {
                        if (data.result == true)
                        {
                            swal("Deleted!", data.message, "success");
                            $('#user').DataTable().ajax.reload();
                        } else {
                            swal(data.message);
                        }
                    },
                    error: function (request, status, error) {
                        if(request.status == 419)
                        {
                            location.href = "{{url('admin/user')}}";
                        }
                    }
                });
            }
        });
    }
    function Status(UserId,status)
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
            text: "You want to "+btn_text+" this user!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
          if (willDelete) {
                var delurl = "{{url('admin/user_status')}}";
                $.ajax({
                    url: delurl,
                    type: "post",
                    data: {"_token": "{{ csrf_token() }}",'id': UserId,'is_disable':status},
                    dataType: 'json',
                    success: function (data) {
                        if (data.result == true)
                        {
                            swal(data.text, data.message, "success");
                            $('#user').DataTable().ajax.reload();
                        } else {
                            swal(data.message);
                        }
                    },
                    error: function (request, status, error) {
                        if(request.status == 419)
                        {
                            location.href = "{{url('admin/user')}}";
                        }
                    }
                });
            }
        });
    }

    function isverify(UserId,status)
    {
        console.log(status);
        if(status == 0)
        {
            
            var btn_text = 'Enable';         
            var status = 1;
        }
        else
        {
            var btn_text = 'Disable';   
            var status = 0;
        }
        swal({
            title: "Are you sure ?",
            text: "You want to "+btn_text+" this user!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
          if (willDelete) {
                var delurl = "{{url('admin/user_verified')}}";
                $.ajax({
                    url: delurl,
                    type: "post",
                    data: {"_token": "{{ csrf_token() }}",'id': UserId,'is_verified':status},
                    dataType: 'json',
                    success: function (data) {
                        if (data.result == true)
                        {
                            swal(data.text, data.message, "success");
                            $('#user').DataTable().ajax.reload();
                        } else {
                            swal(data.message);
                        }
                    },
                    error: function (request, status, error) {
                        if(request.status == 419)
                        {
                            location.href = "{{url('admin/user')}}";
                        }
                    }
                });
            }
        });
    }
    $(".actions").click(function(e){
      e.preventDefault();

      var _ids = $.map($('.user_ids:checked'), function(c){return c.value; });
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
                var delurl = "{{url('admin/user_multi_status')}}";
                $.ajax({
                    url: delurl,
                    type: "post",
                    data: {"_token": "{{ csrf_token() }}",'id': _ids,'action':_action},
                    dataType: 'json',
                    success: function (data) {
                        if (data.result == true)
                        {
                            swal(data.text, data.message, "success");
                            // $('#user').DataTable().ajax.reload();
                            location.reload();
                        } else {
                            swal(data.message);
                        }
                    },
                    error: function (request, status, error) {
                        if(request.status == 419)
                        {
                            location.href = "{{url('admin/user')}}";
                        }
                    }
                });
            }
        });
      }
      else{
        swal({title: 'Sorry no user selected!', type: 'info'});
      }
    });

    $("#checkall").click(function () {

      totalItems=0;

      $('input:checkbox').not(this).prop('checked', this.checked);
      $.each($("input[name='user_ids[]']:checked"), function(){
        totalItems=totalItems+1;
      });

    });
</script>
@endsection