 <!-- Main Sidebar Container -->
 <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#"  class="brand-link">
      <img src="{{Helper::AppLogoImage()}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">{{Helper::AppName()}}</span>
    </a>

    <?php 
    $role = Session::get('AdminRole');
    // echo $role;die;
    ?>
 @if($role==3):
  <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          
            
          <li class="nav-item {{ Request::segment(2) == 'order'? 'active':'' }}">
            <a href="{{ url('admin/order')}}" class="nav-link">
            <i class="nav-icon fa fa-shopping-cart"></i> 
              <p>Order</p>
            </a>
          </li>    
          
        </ul>
      </nav>
      @else :
        <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item menu-open {{ Request::segment(2) == 'home'? 'active':'' }}">
            <a href="{{ url('admin/home')}}" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-item {{ Request::segment(2) == 'user'? 'active':'' }}">
            <a href="{{ url('admin/user')}}" class="nav-link">
              <i class="nav-icon  fa fa-user"></i>
              <p>Users</p>
            </a>
          </li>   
          <li class="nav-item {{ Request::segment(2) == 'subadmin'? 'active':'' }}">
            <a href="{{ url('admin/subadmin')}}" class="nav-link">
              <i class="nav-icon  fa fa-users"></i>
              <p>Sub Admin</p>
            </a>
          </li>    
          <li class="nav-item {{ Request::segment(2) == 'service'? 'active':'' }}">
            <a href="{{ url('admin/service')}}" class="nav-link">
            <i class="nav-icon fa fa-wrench"></i> 
              <p>Services</p>
            </a>
          </li>  
          <li class="nav-item {{ Request::segment(2) == 'banner'? 'active':'' }}">
            <a href="{{ url('admin/banner')}}" class="nav-link">
            <i class="nav-icon fa fa-image"></i> 
              <p>Banner</p>
            </a>
          </li>   
            
          <li class="nav-item {{ Request::segment(2) == 'order'? 'active':'' }}">
            <a href="{{ url('admin/order')}}" class="nav-link">
            <i class="nav-icon fa fa-shopping-cart"></i> 
              <p>Order</p>
            </a>
          </li>    
          
          <li class="nav-item {{ Request::segment(2) == 'category'? 'active':'' }}">
            <a href="{{ url('admin/category')}}" class="nav-link">
            <i class="nav-icon  fa fa-sitemap"></i> 
              <p>Category</p>
            </a>
          </li> 
          <li class="nav-item {{ Request::segment(2) == 'testimonial'? 'active':'' }}">
            <a href="{{ url('admin/testimonial')}}" class="nav-link">
            <i class="nav-icon fa fa-quote-left"></i> 
              <p>Testimonials</p>
            </a>
          </li>           
          <li class="nav-item ">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-city"></i>
              <p>
              State
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('admin/state')}}" class="nav-link">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>State</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('admin/district')}}" class="nav-link">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>District</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('admin/taluka')}}" class="nav-link">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Taluka</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('admin/pincode')}}" class="nav-link">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Pincode</p>
                </a>
              </li>              
            </ul>
          </li>    
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-cogs"></i>
              <p>
              Settings
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('admin/generalsetting')}}" class="nav-link">
                  <i class="fa fa-gear nav-icon"></i>
                  <p>General Settings</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('admin/setting')}}" class="nav-link">
                  <i class="fa fa-file-o nav-icon"></i>
                  <p>Page Settings</p>
                </a>
              </li>
            </ul>
          </li>  
        </ul>
      </nav>
      @endif;
      <!-- Sidebar Menu -->
 
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>