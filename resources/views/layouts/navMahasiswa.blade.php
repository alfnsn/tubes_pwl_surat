<header id="header" class="header bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 sticky-top">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between h-16">
        <!-- Logo -->
        <div class="d-flex align-items-center">
            <a href="{{ route(Auth::user()->role->name . '.dashboard') }}" class="logo d-flex align-items-center">
                <img src="https://kompaspedia.kompas.id/wp-content/uploads/2021/07/logo_universitas-kristen-maranatha.png"
                    alt="IMG">
                <h1 class="sitename ms-2">Dashboard</h1>
            </a>
        </div>

        <!-- Navigation Links -->
        <div class="d-flex align-items-center ms-auto"> <!-- Pastikan semua elemen di kanan -->
            <nav id="navmenu" class="navmenu d-flex align-items-center me-4">
                <ul class="d-flex align-items-center mb-0">
                    @isset(Auth::user()->role->name)
                        @if(Auth::user()->role->name === 'Mahasiswa')
                        <li class="me-4">
                            <a href="{{ route('riwayat-pengajuan') }}">Riwayat Pengajuan</a>
                        </li>
                        @elseif(Auth::user()->role->name === 'Kaprodi')
                        <li class="me-4">
                            <a href="{{ route('pengajuan-riwayat') }}">Riwayat Pengajuan</a>
                        </li>
                        @endif
                    @endisset
                    <li class="position-relative me-4 dropdown">
                        <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-bell" style="font-size: 30px; color: #4b84f7;"></i>
                            @php
                                $userId = Auth::id();
                                $notificationCount = DB::table('notifikasi')
                                    ->where('tujuan', $userId)
                                    ->where('status', 'unread')
                                    ->count();
                            @endphp
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ $notificationCount }}
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            @php
                                $notifications = App\Models\Notifikasi::with('user')
                                    ->where('tujuan', $userId)
                                    ->where('status', 'unread') // Only fetch unread notifications
                                    ->orderBy('created_at', 'desc')
                                    ->get();
                            @endphp
                            @foreach($notifications as $notification)
                                <li class="dropdown-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <p><strong>From:</strong> {{ $notification->user->name }}</p>
                                        <p><strong>Message:</strong> {{ $notification->pesan }}</p>
                                    </div>
                                    <div class="notification-actions">
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#notificationsModal" class="btn-icon">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <form method="POST" action="{{ route('notifications.markAsRead', $notification->idnotifikasi) }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn-icon">
                                                <i class="fa fa-check"></i>
                                            </button>
                                        </form>
                                    </div>
                                </li>
                            @endforeach
                            @if($notifications->isEmpty())
                                <li class="dropdown-item text-center">
                                    Belum ada pesan
                                </li>
                            @endif
                        </ul>
                    </li>
                </ul>
            </nav>

            <!-- User Dropdown -->
            <div class="dropdown">
                <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" color:
                    black;">
                    {{ Auth::user()->id }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
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
            <li class="list-group-item"><a href="{{ route(Auth::user()->role->name . '.dashboard') }}">Dashboard</a>
            </li>
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

<!-- Notifications Modal -->
<div class="modal fade" id="notificationsModal" tabindex="-1" aria-labelledby="notificationsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="notificationsModalLabel">Notifications</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @php
                    $notifications = App\Models\Notifikasi::with('user')
                        ->where('tujuan', $userId)
                        ->where('status', 'unread') // Only fetch unread notifications
                        ->orderBy('created_at', 'desc')
                        ->get();
                @endphp
                @foreach($notifications as $notification)
                    <div class="notification-item">
                        <p><strong>From:</strong> {{ $notification->user->name }}</p>
                        <p><strong>Message:</strong> {{ $notification->pesan }}</p>
                        <form method="POST" action="{{ route('notifications.markAsRead', $notification->idnotifikasi) }}">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-primary">Mark as Read</button>
                        </form>
                        <hr>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<style>
    .btn-icon {
        border: none;
        background: none;
        cursor: pointer;
    }
    .btn-icon:hover {
        color: inherit;
    }
    .btn-icon:focus {
        outline: none;
        box-shadow: none;
    }
    .notification-actions {
        display: flex;
        gap: 0.5rem;
    }
</style>