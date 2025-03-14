<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ asset('assetsadmin/index.html') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->routeIs('Admin.dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('Admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        DATAMASTER
    </div>

    <!-- Nav Item - Pengguna -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePengguna"
            aria-expanded="true" aria-controls="collapsePengguna">
            <i class="fas fa-fw fa-users"></i>
            <span>Pengguna</span>
        </a>
        <div id="collapsePengguna" class="collapse {{ request()->routeIs('pengguna.*') ? 'show' : '' }}" aria-labelledby="headingPengguna"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Daftar Pengguna:</h6>
                <a class="collapse-item {{ request()->routeIs('pengguna.mahasiswa') ? 'active' : '' }}" href="{{ route('pengguna.mahasiswa') }}">Mahasiswa</a>
                <a class="collapse-item {{ request()->routeIs('pengguna.kaprodi') ? 'active' : '' }}" href="{{ route('pengguna.kaprodi') }}">Kaprodi</a>
                <a class="collapse-item {{ request()->routeIs('pengguna.mo') ? 'active' : '' }}" href="{{ route('pengguna.mo') }}">MO</a>
                <a class="collapse-item {{ request()->routeIs('pengguna.admin') ? 'active' : '' }}" href="{{ route('pengguna.admin') }}">Admin</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
            aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Utilities</span>
        </a>
        <div id="collapseUtilities" class="collapse {{ request()->routeIs('utilities.*') ? 'show' : '' }}" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Custom Utilities:</h6>
                <a class="collapse-item {{ request()->routeIs('utilities.color') ? 'active' : '' }}" href="utilities-color.html">Colors</a>
                <a class="collapse-item {{ request()->routeIs('utilities.border') ? 'active' : '' }}" href="utilities-border.html">Borders</a>
                <a class="collapse-item {{ request()->routeIs('utilities.animation') ? 'active' : '' }}" href="utilities-animation.html">Animations</a>
                <a class="collapse-item {{ request()->routeIs('utilities.other') ? 'active' : '' }}" href="utilities-other.html">Other</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Addons
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
            aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-fw fa-folder"></i>
            <span>Pages</span>
        </a>
        <div id="collapsePages" class="collapse {{ request()->routeIs('pages.*') ? 'show' : '' }}" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Login Screens:</h6>
                <a class="collapse-item {{ request()->routeIs('pages.login') ? 'active' : '' }}" href="login.html">Login</a>
                <a class="collapse-item {{ request()->routeIs('pages.register') ? 'active' : '' }}" href="register.html">Register</a>
                <a class="collapse-item {{ request()->routeIs('pages.forgot-password') ? 'active' : '' }}" href="forgot-password.html">Forgot Password</a>
                <div class="collapse-divider"></div>
                <h6 class="collapse-header">Other Pages:</h6>
                <a class="collapse-item {{ request()->routeIs('pages.404') ? 'active' : '' }}" href="404.html">404 Page</a>
                <a class="collapse-item {{ request()->routeIs('pages.blank') ? 'active' : '' }}" href="blank.html">Blank Page</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Charts -->
    <li class="nav-item {{ request()->routeIs('charts') ? 'active' : '' }}">
        <a class="nav-link" href="charts.html">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Charts</span></a>
    </li>

    <!-- Nav Item - Tables -->
    <li class="nav-item {{ request()->routeIs('tables') ? 'active' : '' }}">
        <a class="nav-link" href="tables.html">
            <i class="fas fa-fw fa-table"></i>
            <span>Tables</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

    <!-- Sidebar Message -->
    {{-- <div class="sidebar-card d-none d-lg-flex">
        <img class="sidebar-card-illustration mb-2" src="{{ asset('assetsadmin/img/undraw_rocket.svg') }}" alt="...">
        <p class="text-center mb-2"><strong>SB Admin Pro</strong> is packed with premium features, components, and more!</p>
        <a class="btn btn-success btn-sm" href="https://startbootstrap.com/theme/sb-admin-pro">Upgrade to Pro!</a>
    </div> --}}

</ul>
