<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('home') }}" class="brand-link">
        {{-- <a href="{{ config('app.url', '/') }}" class="brand-link"> --}}
        <!--<img src="{{ asset('adminlte/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
         style="opacity: .8">-->
        {{-- <i class="fas fa-laptop-code fa-1x"></i> --}}
        <i class="fas fa-file-invoice-dollar"></i>
        <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <!--<div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{ asset('adminlte/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">Alexander Pierce</a>
      </div>
    </div>-->
        @section('sidebar')
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                    <li class="nav-item has-treeview {{ request()->segment(2) == 'parameter' ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->segment(2) == 'parameter' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>
                                Parameter
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('allparameter') }}"
                                    class="nav-link {{ request()->is('admin/parameter/allparameter') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>View Parameter</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('parameterAddForm') }}"
                                    class="nav-link {{ request()->is('admin/parameter/parameterAddForm') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Add Parameter</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview {{ request()->segment(2) == 'contract' ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->segment(2) == 'contract' ? 'active' : '' }}">
                            <i class="nav-icon far fa-calendar-alt"></i>
                            <p>
                                Contract
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('contractView') }}"
                                    class="nav-link {{ request()->is('admin/contract/contractView') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>View Contract</p>
                                </a>
                            </li>
                            {{-- <li class="nav-item">
                                <a href="{{ route('contractAddForm') }}" class="nav-link {{ request()->is('admin/parameter/contractAddForm') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Add Date Contract</p>
                                </a>
                            </li> --}}
                        </ul>
                    </li>
                    <li class="nav-item has-treeview {{ request()->segment(2) == 'billing' ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->segment(2) == 'billing' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-book"></i>
                            <p>
                                Billing
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('allBillings') }}"
                                    class="nav-link {{ request()->is('admin/billing/allBillings') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>View Billing</p>
                                </a>
                            </li>
                            {{-- <li class="nav-item">
                                <a href="{{ route('billingAuto') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Auto Billing</p>
                                </a>
                            </li> --}}
                            <li class="nav-item">
                                <a href="{{ route('billingManualAuto') }}"
                                    class="nav-link {{ request()->is('admin/billing/billingManualAuto') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Adjust Billing</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('billingManualAdd') }}"
                                    class="nav-link {{ request()->is('admin/billing/billingManualAdd') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Manual Add Billing</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item has-treeview {{ request()->segment(2) == 'data' ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->segment(2) == 'data' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-table"></i>
                            <p>
                                Data
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('viewData') }}"
                                    class="nav-link {{ request()->is('admin/data/viewData') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>View Data</p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('viewGain') }}"
                                    class="nav-link {{ request()->is('admin/data/viewGain') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>View Gain</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview {{ request()->segment(2) == 'users' ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->segment(2) == 'users' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Manage Users
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('viewUsers') }}"
                                    class="nav-link {{ request()->is('admin/users/viewUsers') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>View Users</p>
                                </a>
                            </li>
                        </ul>
                        {{-- <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('userEdit') }}"
                                    class="nav-link {{ request()->is('admin/users/userEdit') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Edit User</p>
                                </a>
                            </li>
                        </ul> --}}
                    </li>

                    {{-- <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Starter Pages
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="#" class="nav-link active">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Active Page</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Inactive Page</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                                Simple Link
                                <span class="right badge badge-danger">New</span>
                            </p>
                        </a>
                    </li> --}}
                </ul>
            </nav>
        @show
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
