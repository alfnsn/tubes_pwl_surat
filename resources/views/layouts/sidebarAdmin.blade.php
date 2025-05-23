<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center"
        href="{{ route(Auth::user()->role->name . '.dashboard') }}">
        <div class="sidebar-brand-icon">
            <img src="https://kompaspedia.kompas.id/wp-content/uploads/2021/07/logo_universitas-kristen-maranatha.png"
                alt="IMG"
                style="max-width: 50px; height: auto; transform: rotate(0); filter: brightness(0) invert(1);">
        </div>
        <div class="sidebar-brand-text mx-3"> Maranatha</div>
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
        <div id="collapsePengguna" class="collapse {{ request()->routeIs('pengguna.*') ? 'show' : '' }}"
            aria-labelledby="headingPengguna" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Daftar Pengguna:</h6>
                <a class="collapse-item {{ request()->routeIs('pengguna.mahasiswa') ? 'active' : '' }}"
                    href="{{ route('pengguna.mahasiswa') }}">Mahasiswa</a>
                <a class="collapse-item {{ request()->routeIs('pengguna.kaprodi') ? 'active' : '' }}"
                    href="{{ route('pengguna.kaprodi') }}">Kaprodi</a>
                <a class="collapse-item {{ request()->routeIs('pengguna.mo') ? 'active' : '' }}"
                    href="{{ route('pengguna.mo') }}">MO</a>
                <a class="collapse-item {{ request()->routeIs('pengguna.admin') ? 'active' : '' }}"
                    href="{{ route('pengguna.admin') }}">Admin</a>
                <a class="collapse-item {{ request()->routeIs('pengguna.dosen') ? 'active' : '' }}"
                    href="{{ route('pengguna.dosen') }}">Dosen</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Program Studi -->
    <li class="nav-item {{ request()->routeIs('admin.studyProgram') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.studyProgram') }}">
            <i class="fas fa-fw fa-book"></i>
            <span>Program Studi</span>
        </a>
    </li>

    <!-- Nav Item - Mata Kuliah -->
    <li class="nav-item {{ request()->routeIs('admin.mataKuliah') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.mataKuliah') }}">
            <i class="fas fa-fw fa-book"></i>
            <span>Mata Kuliah</span>
        </a>
    </li>

    {{-- <!-- Nav Item - Charts -->
    <li class="nav-item {{ request()->routeIs('charts') ? 'active' : '' }}">
        <a class="nav-link" href="charts.html">
            <i class="fas fa-fw fa-book"></i>
            <span>Program Studi</span></a>
    </li> --}}

    {{-- <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
            aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-book"></i>
            <span>Program Studi </span>
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
    </li> --}}

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Surat
    </div>

    <!-- Nav Item - Surat Keterangan Lulus -->
    <li class="nav-item {{ request()->routeIs('keterangan-lulus-admin') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('keterangan-lulus-admin') }}">
            <i class="fas fa-fw fa-graduation-cap"></i>
            <span>Surat Keterangan Lulus</span>
        </a>
    </li>

    <!-- Nav Item - Surat Keterangan Aktif -->
    <li class="nav-item {{ request()->routeIs('keterangan-aktif-admin') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('keterangan-aktif-admin') }}">
            <i class="fas fa-fw fa-check-circle"></i>
            <span>Surat Keterangan Aktif</span>
        </a>
    </li>

    <!-- Nav Item - Surat Laporan Hasil Studi -->
    <li class="nav-item {{ request()->routeIs('laporan-hasil-studi-admin') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('laporan-hasil-studi-admin') }}">
            <i class="fas fa-fw fa-chart-bar"></i> <!-- Updated icon -->
            <span>Surat Laporan Hasil Studi</span>
        </a>
    </li>

    <!-- Nav Item - Surat Pengantar Mata Kuliah -->
    <li class="nav-item {{ request()->routeIs('pengantar-tugas-mata-kuliah-admin') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('pengantar-tugas-mata-kuliah-admin') }}">
            <i class="fas fa-fw fa-book-open"></i> <!-- Updated icon -->
            <span>Surat Pengantar Mata Kuliah</span>
        </a>
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
