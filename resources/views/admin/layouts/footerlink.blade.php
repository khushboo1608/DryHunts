<!-- <script src="{{url('public/admin/js/main/jquery-3.1.1.min.js')}}"></script>
<script src="{{url('public/admin/js/main/popper.min.js')}}"></script>
<script src="{{url('public/admin/js/main/bootstrap.js')}}"></script>
<script src="{{url('public/admin/js/main/inspinia.js')}}"></script>
<script src="{{url('public/admin/js/pace/pace.min.js')}}"></script>
<script src="{{url('public/admin/js/metisMenu/jquery.metisMenu.js')}}"></script>
<script src="{{url('public/admin/js/slimscroll/jquery.slimscroll.min.js')}}"></script>
<script src="{{url('public/admin/js/cropImage/croppie.js')}}"></script>


<script src="{{url('public/admin/js/cropImage/profile-croppie.js')}}"></script>

 -->

<!-- jQuery -->
<script src="{{ url('admin_assets/plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ url('admin_assets/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ url('admin_assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ url('admin_assets/plugins/chart.js/Chart.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ url('admin_assets/plugins/sparklines/sparkline.js') }}"></script>
<!-- JQVMap -->
<!-- <script src="{{ url('admin_assets/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ url('admin_assets/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script> -->
<!-- jQuery Knob Chart -->
<script src="{{ url('admin_assets/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ url('admin_assets/plugins/moment/moment.min.js') }}"></script>
<script src="{{ url('admin_assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ url('admin_assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ url('admin_assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ url('admin_assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ url('admin_assets/dist/js/adminlte.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<!-- <script src="{{ url('admin_assets/dist/js/demo.js') }}"></script> -->
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script src="{{ url('admin_assets/dist/js/pages/dashboard.js') }}"></script> -->
<!-- Form- Validation  -->
<script src="{{ url('public/admin_assets/js/form-validation/jquery.validate.js') }}"></script>
<script src="{{ url('public/admin_assets/js/form-validation/additional-methods.min.js') }}"></script>

<!-- <script src="{{ url('public/admincss/js/form-validation/jquery.validate.js') }}"></script>
<script src="{{ url('public/admincss/js/form-validation/additional-methods.min.js') }}"></script> -->
<!-- <script src="{{ url('public/admin/js/form-validation/custom-form-validation.js') }}"></script> -->

<script src="{{url('public/admin_dir/js/sweetalert/sweetalert.min.js') }}"></script>

<!-- DataTables  & Plugins -->
<script src="{{ url('admin_assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ url('admin_assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ url('admin_assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ url('admin_assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ url('admin_assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ url('admin_assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ url('admin_assets/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ url('admin_assets/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ url('admin_assets/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<script type="text/javascript"  src="https://gyrocode.github.io/jquery-datatables-checkboxes/1.2.7/js/dataTables.checkboxes.min.js"></script>


<script>
jQuery.validator.addMethod("noSpace", function(value, element) { 
    return value == '' || value.trim().length != 0;
}, "{{__('messages.no_space')}}");
jQuery.validator.addMethod("noSpacePassword", function(value, element) { 
    return value == '' || value.trim().length != 0;
}, "{{__('messages.no_space_password')}}");
jQuery.validator.addMethod("ValidPassword", function(value, element) {
    return this.optional(element) || /^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!@=*$#%]).*$/i.test(value);
}, "{{__('messages.valid_password')}}");


</script>
<!-- jQuery script -->
<script>
 $(document).ready(function() {
      // Check if a submenu is active
      if ($('.nav-link').hasClass('active')) {
        // Add a class to the main menu to keep it closed
        $('.nav-item').addClass('closed-menu');
        // Display the active submenu's parent
        $('.active').closest('.nav-treeview').css('display', 'block');
      }

      // Toggle the submenu on main menu click
      $('.nav-link').click(function() {
        $(this).closest('.nav-item').toggleClass('closed-menu');
        $(this).siblings('.nav-treeview').slideToggle();
      });
    });
</script>