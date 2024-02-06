

  <!-- Preloader -->
  <!-- <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{Helper::AppLogoImage()}}" alt="AdminLTELogo" height="60" width="60">
  </div> -->

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <!-- <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li> -->
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>


      <!-- <li class="dropdown profile"> 
              <a href="profile.php" class="dropdown-toggle" data-toggle="dropdown">
              <img style="height: 50px;width: 50px;border-radius: 50%;" alt="image" class="profile-img" src="{{Helper::LoggedUserImage()}}"/>                 
                <div class="title">Profile</div>
              </a>
              <div class="dropdown-menu">
                <div class="profile-info">
                  <h4 class="username">Admin</h4>
                </div>
                <ul class="action">
                  <li><a href="{{url('admin/profile')}}">Profile</a></li>                  
                  <li><a href="{{url('admin/logout')}}">Logout</a></li>
                </ul>
              </div>
              
            </li> -->

      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <!-- <i class="far fa-comments"></i> -->
          <!-- <span class="badge badge-danger navbar-badge">3</span> -->
          <img style="border-radius: 50%;margin-top: -6px;height: 25px;width: 25px;border-radius: 50%;" alt="image" class="profile-img" src="{{Helper::LoggedUserImage()}}"/>
          <span>{{(Auth::user()) ?  Auth::user()->name:''}}</span>
        </a>
        <!-- <h5 class="user-heading">{{(Auth::user()) ?  Auth::user()->name:''}}</h5> -->
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="{{url('admin/profile')}}" class="dropdown-item">Profile </a>
          <div class="dropdown-divider"></div>
          <a href="{{url('admin/logout')}}" class="dropdown-item">Logout</a>
        </div>
      </li>
   
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <!-- <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li> -->
    </ul>
  </nav>
  <!-- /.navbar -->