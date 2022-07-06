  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">

      <!-- Left navbar links -->
      <ul class="navbar-nav">
          <li class="nav-item">
              <a class="nav-link" data-widget="pushmenu" role="button"><i class="fas fa-bars"></i></a>
          </li>

      </ul>
      <ul class="navbar-nav ml-auto">
          <!-- User Account: style can be found in dropdown.less -->

          <li class="dropdown user user-menu">
              {{-- <a class="nav-link" data-toggle="dropdown" href="#">
                  <i class="far fa-comments"></i>
                  <span class="badge badge-danger navbar-badge">3</span>
              </a> --}}
              @auth

                  <a href="#" class="nav-link" data-toggle="dropdown">
                      {{-- <img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image"> --}}
                      {{-- <i class="fas fa-circle-user"></i> --}}

                      <i class="fas fa-user"></i>
                      {{ Auth::user()->name }}
                      {{-- <span class="hidden-xs">Loguot</span> --}}
                  </a>
                  <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                      <a href="#" class="dropdown-item">
                          <!-- Message Start -->
                          <div class="media">
                              {{-- <img src=" {{ url('adminlte/dist/img/user1-128x128.jpg') }}" alt="User Avatar"
                                  class="img-size-50 mr-3 img-circle"> --}}
                                  <i class="fas fa-user fa-4x mr-3"></i>
                              <div class="media-body">
                                  <h3 class="dropdown-item-title">
                                    {{ Auth::user()->name }}
                                      {{-- <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span> --}}
                                  </h3>
                                  <p class="text-sm">{{ Auth::user()->email }}</p>
                                  {{-- <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p> --}}
                              </div>
                          </div>
                          <!-- Message End -->
                      </a>
                      <div class="dropdown-divider"></div>


                      <a href="{{ route('logout') }}" class="dropdown-item dropdown-footer">Sign Out</a>
                  </div>
                  {{-- <ul class="dropdown-menu">
                      <div class="card-body">
                          <div class="col-12">
                              <a href="{{ route('logout') }}" class="btn btn-primary btn-block">Sign In</a>
                          </div>
                          <div class="social-auth-links text-center mt-2 mb-3">
                              <div class="col-10">
                                  <a href="{{ route('logout') }}" class="btn btn-primary btn-block">Sign In</a>
                              </div>
                              <a href="#" class="btn btn-block btn-primary">
                                  <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
                              </a>
                              <a href="#" class="btn btn-block btn-danger">
                                  <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
                              </a>
                          </div>
                      </div>
                  </ul> --}}
              @endauth
              @guest
                  <a href="#" class="nav-link" data-toggle="dropdown">
                      {{-- <img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image"> --}}
                      {{-- <i class="fas fa-circle-user"></i> --}}
                      <i class="fas fa-user"></i>
                      <span class="hidden-xs">Login</span>
                  </a>
                  <ul class="dropdown-menu">
                      <div class="media-body">
                          <!-- /.login-logo -->
                          {{-- <div class="card card-outline card-primary"> --}}
                          {{-- <div class="card-header text-center">
                              <a href="../../index2.html" class="h1"><b>Admin</b>LTE</a>
                          </div> --}}
                          <div class="card-body">
                              <p class="login-box-msg">Sign in to start your session</p>

                              <form action="{{ route('login.perform') }}" method="post">
                                  <div class="input-group mb-3">
                                      <input type="email" class="form-control" placeholder="Email">
                                      <div class="input-group-append">
                                          <div class="input-group-text">
                                              <span class="fas fa-envelope"></span>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="input-group mb-3">
                                      <input type="password" class="form-control" placeholder="Password">
                                      <div class="input-group-append">
                                          <div class="input-group-text">
                                              <span class="fas fa-lock"></span>
                                          </div>
                                      </div>
                                  </div>

                                  <div class="row">
                                      {{-- <div class="col-8">
                                          <div class="icheck-primary">
                                              <input type="checkbox" id="remember">
                                              <label for="remember">
                                                  Remember Me
                                              </label>
                                          </div>
                                      </div> --}}
                                      <!-- /.col -->
                                      <div class="col-12">
                                          <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                                      </div>
                                      <!-- /.col -->
                                  </div>
                              </form>

                              {{-- <div class="social-auth-links text-center mt-2 mb-3">
                                  <a href="#" class="btn btn-block btn-primary">
                                      <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
                                  </a>
                                  <a href="#" class="btn btn-block btn-danger">
                                      <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
                                  </a>
                              </div> --}}
                              <!-- /.social-auth-links -->

                              <p class="mb-1">
                                  <a href="forgot-password.html">I forgot my password</a>
                              </p>
                              <p class="mb-0">
                                  <a href="register.html" class="text-center">Register a new membership</a>
                              </p>
                          </div>
                          <!-- /.card-body -->
                          {{-- </div> --}}
                          <!-- /.card -->
                      </div>
                  </ul>
              @endguest
          </li>
      </ul>

      <!-- Right navbar links -->
      {{-- <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src=" {{ url('adminlte/dist/img/user1-128x128.jpg') }}" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="{{ url('adminlte/dist/img/user1-128x128.jpg') }}" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="{{ url('adminlte/dist/img/user1-128x128.jpg') }}" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button"><i
            class="fas fa-th-large"></i></a>
      </li>
    </ul> --}}
  </nav>
  <!-- /.navbar -->
