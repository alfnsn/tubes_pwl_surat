<header id="header" class="header bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 sticky-top">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between h-16">
        <!-- Logo -->
        <div class="d-flex align-items-center">
            <a href="{{ route(Auth::user()->role->name . '.dashboard') }}" class="logo d-flex align-items-center">
                <img src="https://kompaspedia.kompas.id/wp-content/uploads/2021/07/logo_universitas-kristen-maranatha.png" alt="IMG">
                <h1 class="sitename ms-2">Dashboard</h1>
            </a>
        </div>

        <!-- Navigation Links -->
        <div class="d-flex align-items-center ms-auto"> <!-- Pastikan semua elemen di kanan -->
            <nav id="navmenu" class="navmenu d-flex align-items-center me-4">
                <ul class="d-flex align-items-center mb-0">
                    <li class="me-4">
                        <a href="#team">Riwayat Pengajuan</a>
                    </li>
                    <li class="position-relative me-4">
                        <a href="#notifications">
                            <i class="fa fa-bell" style="font-size: 30px; color: #4b84f7;"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                5
                            </span>
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- User Dropdown -->
            <div class="dropdown">
                <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" color: black;">
                    {{ Auth::user()->id }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">Log Out</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Mobile Menu Toggle -->
        <button class="mobile-nav-toggle d-lg-none btn btn-outline-secondary" id="mobile-menu-button">
            <i class="bi bi-list"></i>
        </button>
    </div>

    <!-- Responsive Navigation Menu -->
    <div id="mobile-menu" class="d-lg-none d-none">
        <ul class="list-group">
            <li class="list-group-item"><a href="{{ route(Auth::user()->role->name . '.dashboard') }}">Dashboard</a></li>
            <li class="list-group-item"><a href="#about">About</a></li>
            <li class="list-group-item"><a href="#services">Services</a></li>
            <li class="list-group-item"><a href="#portfolio">Portfolio</a></li>
            <li class="list-group-item"><a href="#team">Team</a></li>
            <li class="list-group-item"><a href="#contact">Contact</a></li>
            <li class="list-group-item">
                <a href="{{ route('profile.edit') }}">Profile</a>
            </li>
            <li class="list-group-item">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-link">Log Out</button>
                </form>
            </li>
        </ul>
    </div>
</header>