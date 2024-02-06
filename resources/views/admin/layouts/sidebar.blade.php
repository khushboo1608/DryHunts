 <!-- Main Sidebar Container -->
 <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="{{Helper::AppLogoImage()}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">{{Helper::AppName()}}</span>
    </a>
    <?php 
    $role = Session::get('AdminRole');
    // echo $role;die;
    // echo Request::segment(2); die;
    ?>
 @if($role==3):
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
       
            <li class="nav-item">
            <a href="{{ url('admin/order')}}" class="nav-link {{ Request::segment(2) == 'order'? 'active':'' }}">
            <i class="nav-icon fa fa-shopping-cart"></i> 
              <p>Request</p>
            </a>
          </li>  
        </ul>
      </nav>
      @elseif($role==4):
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      
            <li class="nav-item">
            <a href="{{ url('admin/order')}}" class="nav-link {{ Request::segment(2) == 'order'? 'active':'' }}">
            <i class="nav-icon fa fa-shopping-cart"></i> 
              <p>Request</p>
            </a>
          </li>   
        </ul>
      </nav>
      @else :
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item menu-open ">
            <a href="{{ url('admin/home')}}" class="nav-link {{ Request::segment(2) == 'home'? 'active':'' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-item ">
            <a href="{{ url('admin/user')}}" class="nav-link {{ Request::segment(2) == 'user'? 'active':'' }}">
              <i class="nav-icon  fa fa-user"></i>
              <p>Users</p>
            </a>
          </li>   
          <li class="nav-item">
            <a href="{{ url('admin/subadmin')}}" class="nav-link {{ Request::segment(2) == 'subadmin'? 'active':'' }}">
              <i class="nav-icon  fa fa-users"></i>
              <p>Sub Admin</p>
            </a>
          </li>    
          <li class="nav-item">
            <a href="{{ url('admin/service')}}" class="nav-link {{ Request::segment(2) == 'service'? 'active':'' }}">
            <i class="nav-icon fa fa-wrench"></i> 
              <p>Services</p>
            </a>
          </li>  
          <li class="nav-item">
            <a href="{{ url('admin/banner')}}" class="nav-link {{ Request::segment(2) == 'banner'? 'active':'' }}">
            <i class="nav-icon fa fa-image"></i> 
              <p>Banner</p>
            </a>
          </li>   
          <li class="nav-item">
            <a href="{{ url('admin/gallary')}}" class="nav-link {{ Request::segment(2) == 'gallary'? 'active':'' }}">
            <i class="nav-icon fas fa-images"></i> 
              <p>Gallary</p>
            </a>
          </li>   
          
            
          <li class="nav-item">
            <a href="{{ url('admin/order')}}" class="nav-link {{ Request::segment(2) == 'order'? 'active':'' }}">
            <i class="nav-icon fa fa-shopping-cart"></i> 
              <p>Request</p>
            </a>
          </li>    
          
          <li class="nav-item">
            <a href="{{ url('admin/category')}}" class="nav-link {{ Request::segment(2) == 'category'? 'active':'' }}">
            <i class="nav-icon  fa fa-sitemap"></i> 
              <p>Category</p>
            </a>
          </li> 
          <li class="nav-item">
            <a href="{{ url('admin/testimonial')}}" class="nav-link {{ Request::segment(2) == 'testimonial'? 'active':'' }}">
            <i class="nav-icon fa fa-quote-left"></i> 
              <p>Testimonials</p>
            </a>
          </li>           
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-city"></i>
              <p>
              State
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('admin/state')}}" class="nav-link {{ Request::segment(2) == 'state'? 'active':'' }}">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>State</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('admin/district')}}" class="nav-link {{ Request::segment(2) == 'district'? 'active':'' }}">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>District</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('admin/taluka')}}" class="nav-link {{ Request::segment(2) == 'taluka'? 'active':'' }}">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Taluka</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('admin/pincode')}}" class="nav-link {{ Request::segment(2) == 'pincode'? 'active':'' }}">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Pincode</p>
                </a>
              </li>              
            </ul>
          </li>    
          <li class="nav-item ">
            <a href="#" class="nav-link " >
              <i class="nav-icon fa fa-cogs"></i>
              <p>
              Settings
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('admin/generalsetting')}}" class="nav-link {{ Request::segment(2) == 'generalsetting'? 'active':'' }}">
                  <i class="fa fa-gear nav-icon"></i>
                  <p>General Settings</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('admin/setting')}}" class="nav-link {{ Request::segment(2) == 'setting'? 'active':'' }}">
                  <i class="fa fa-file-o nav-icon"></i>
                  <p>Page Settings</p>
                </a>
              </li>
            </ul>
          </li>  
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
      @endif;
    </div>
    <!-- /.sidebar -->
  </aside>