<header id="header" class="header bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 sticky-top">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between h-16">
        <!-- Logo -->
        <div class="d-flex align-items-center">
            <a href="{{ route(Auth::user()->role->name . '.dashboard') }}" class="logo d-flex align-items-center">
                <img src="https://kompaspedia.kompas.id/wp-content/uploads/2021/07/logo_universitas-kristen-maranatha.png"
                    alt="IMG">
                <h1 class="sitename ms-2 d-none d-lg-block">Dashboard</h1>
            </a>
        </div>

        <!-- Mobile Menu Toggle -->
        <button class="mobile-nav-toggle d-lg-none btn btn-outline-secondary" id="mobile-menu-button">
            <i class="bi bi-list"></i>
        </button>

        <!-- Navigation Links (Hidden on Mobile) -->
        <div class="d-flex align-items-center ms-auto d-none d-lg-flex" id="desktop-menu">
            <nav id="navmenu" class="d-flex align-items-center me-4">
                <ul class="d-flex align-items-center mb-0" style="list-style: none;">
                    @isset(Auth::user()->role->name)
                        @if (Auth::user()->role->name === 'Mahasiswa')
                            <li class="me-4">
                                <a href="{{ route('riwayat-pengajuan') }}">Riwayat Pengajuan</a>
                            </li>
                        @elseif(Auth::user()->role->name === 'Kaprodi')
                            <li class="me-4">
                                <a href="{{ route('pengajuan-riwayat') }}">Riwayat Pengajuan</a>
                            </li>
                        @elseif(Auth::user()->role->name === 'MO')
                            <li class="me-4">
                                <a href="{{ route('pengajuan-riwayat-mo') }}">Riwayat Pengajuan</a>
                            </li>
                        @endif
                    @endisset
                </ul>
            </nav>

            <!-- Nav Item - Alerts -->
            <li class="nav-item dropdown no-arrow mx-1">
                <a class="nav-link notif-baru" href="#" id="alertsDropdown" role="button" data-toggle="dropdown"
                    data-bs-proper="static" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-bell fa-fw" style="position: relative; font-size: 25px;">
                        @php
                            $userId = Auth::id();
                            $notificationCount = DB::table('notifikasi')
                                ->where('tujuan', $userId)
                                ->where('status', 'unread')
                                ->count();
                        @endphp
                        @if ($notificationCount >= 0)
                            <span class="badge badge-danger badge-counter position-absolute"
                                style="top: -4px; right: -1px; font-size: 10px; !important">{{ $notificationCount }}</span>
                        @endif
                    </i>
                </a>
                <div class="dropdown-list dropdown-menu dropdown-menu-end shadow animated--grow-in"
                    aria-labelledby="alertsDropdown">
                    <h6 class="dropdown-header">Notifikasi</h6>
                    @php
                        $userId = Auth::id();
                        $notifications = App\Models\Notifikasi::with('user')
                            ->where('tujuan', $userId)
                            ->where('status', 'unread')
                            ->orderBy('created_at', 'desc')
                            ->take(5)
                            ->get();
                        $allNotifications = App\Models\Notifikasi::with('user')
                            ->where('tujuan', $userId)
                            ->orderBy('created_at', 'desc')
                            ->get();
                    @endphp
                    @foreach ($notifications as $notification)
                        @php
                            $bgClass = 'bg-warning'; // Default class
                            $iconClass = 'fas fa-exclamation-triangle'; // Default icon
                            if (str_contains($notification->pesan, 'Kaprodi menyetujui permintaan Anda')) {
                                $bgClass = 'bg-success';
                                $iconClass = 'fas fa-check-circle';
                            } elseif (str_contains($notification->pesan, 'Kaprodi menolak permintaan Anda')) {
                                $bgClass = 'bg-warning';
                                $iconClass = 'fas fa-times-circle';
                            } elseif (str_contains($notification->pesan, 'MO telah membuatkan surat anda')) {
                                $bgClass = 'bg-primary';
                                $iconClass = 'fas fa-envelope';
                            }
                        @endphp
                        <a class="dropdown-item d-flex align-items-center" href="#" data-bs-toggle="modal"
                            data-bs-target="#notificationsModal" data-message="{{ $notification->pesan }}"
                            data-sender="{{ $notification->user->name }}" data-id="{{ $notification->idnotifikasi }}">
                            <div class="{{ $bgClass }} d-flex justify-content-center align-items-center"
                                style="border-radius: 50%; width: 2rem; height: 2rem;">
                                <i class="{{ $iconClass }} text-white"></i>
                            </div>
                            <div style="margin-left: 0.5rem">
                                <div class="small text-gray-800"><strong>From: {{ $notification->user->name }}
                                    </strong>
                                </div>
                                {{ $notification->pesan }}
                            </div>
                        </a>
                    @endforeach
                    @if ($notifications->isEmpty())
                        <a class="dropdown-item d-flex align-items-center" href="#">
                            Belum ada pesan
                        </a>
                    @endif
                    <a class="dropdown-item text-center small text-gray-500" href="#" data-bs-toggle="modal"
                        data-bs-target="#allNotificationsModal">Show All Notifications</a>
                </div>
            </li>

            <!-- User Dropdown -->
            <div class="dropdown">
                <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    {{ Auth::user()->id }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        @if (Auth::user()->role->name === 'Mahasiswa')
                            <a class="dropdown-item" href="{{ route('mahasiswa.profile') }}">Edit Profile</a>
                        @elseif(Auth::user()->role->name === 'Kaprodi')
                            <a class="dropdown-item" href="{{ route('kaprodi.profile') }}">Edit Profile</a>
                        @elseif(Auth::user()->role->name === 'MO')
                            <a class="dropdown-item" href="{{ route('mo.profile') }}">Edit Profile</a>
                        @else
                            <a class="dropdown-item" href="#">Unknown Role</a>
                        @endif
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">Log Out</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="d-lg-none d-none">
        <ul class="list-group">
            @isset(Auth::user()->role->name)
                @if (Auth::user()->role->name === 'Mahasiswa')
                    <li class="me-4">
                        <a href="{{ route('riwayat-pengajuan') }}">Riwayat Pengajuan</a>
                    </li>
                @elseif(Auth::user()->role->name === 'Kaprodi')
                    <li class="me-4">
                        <a href="{{ route('pengajuan-riwayat') }}">Riwayat Pengajuan</a>
                    </li>
                @elseif(Auth::user()->role->name === 'MO')
                    <li class="me-4">
                        <a href="{{ route('pengajuan-riwayat-mo') }}">Riwayat Pengajuan</a>
                    </li>
                @endif
            @endisset
            <!-- Nav Item - Alerts -->
            <li class="nav-item dropdown no-arrow mx-1">
                <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-bell fa-fw"></i>
                    @php
                        $userId = Auth::id();
                        $notificationCount = DB::table('notifikasi')
                            ->where('tujuan', $userId)
                            ->where('status', 'unread')
                            ->count();
                    @endphp
                    <span class="badge badge-danger badge-counter">{{ $notificationCount }}</span>
                </a>
                <div class="dropdown-list dropdown-menu dropdown-menu-end shadow animated--grow-in"
                    aria-labelledby="alertsDropdown">
                    <h6 class="dropdown-header">Notifikasi</h6>
                    @php
                        $notifications = App\Models\Notifikasi::with('user')
                            ->where('tujuan', $userId)
                            ->where('status', 'unread')
                            ->orderBy('created_at', 'desc')
                            ->take(5)
                            ->get();
                        $allNotifications = App\Models\Notifikasi::with('user')
                            ->where('tujuan', $userId)
                            ->orderBy('created_at', 'desc')
                            ->get();
                    @endphp
                    @foreach ($notifications as $notification)
                        @php
                            $bgClass = 'bg-warning'; // Default class
                            $iconClass = 'fas fa-exclamation-triangle'; // Default icon
                            if (str_contains($notification->pesan, 'Kaprodi menyetujui permintaan Anda')) {
                                $bgClass = 'bg-success';
                                $iconClass = 'fas fa-check-circle';
                            } elseif (str_contains($notification->pesan, 'Kaprodi menolak permintaan Anda')) {
                                $bgClass = 'bg-warning';
                                $iconClass = 'fas fa-times-circle';
                            } elseif (str_contains($notification->pesan, 'MO telah membuatkan surat anda')) {
                                $bgClass = 'bg-primary';
                                $iconClass = 'fas fa-envelope';
                            }
                        @endphp
                        <a class="dropdown-item d-flex align-items-center" href="#" data-bs-toggle="modal"
                            data-bs-target="#notificationsModal" data-message="{{ $notification->pesan }}"
                            data-sender="{{ $notification->user->name }}"
                            data-id="{{ $notification->idnotifikasi }}">
                            <div class="{{ $bgClass }} d-flex justify-content-center align-items-center"
                                style="border-radius: 50%; width: 2rem; height: 2rem;">
                                <i class="{{ $iconClass }} text-white"></i>
                            </div>
                            <div style="margin-left: 0.5rem">
                                <div class="small text-gray-800"><strong>From: {{ $notification->user->name }}
                                    </strong>
                                </div>
                                {{ $notification->pesan }}
                            </div>
                        </a>
                    @endforeach
                    @if ($notifications->isEmpty())
                        <a class="dropdown-item d-flex align-items-center" href="#">
                            Belum ada pesan
                        </a>
                    @endif
                    <a class="dropdown-item text-center small text-gray-500" href="#" data-bs-toggle="modal"
                        data-bs-target="#allNotificationsModal">Show All Notifications</a>
                </div>
            </li>

            <!-- User Dropdown -->
            <div class="dropdown">
                <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    {{ Auth::user()->id }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        @if (Auth::user()->role->name === 'Mahasiswa')
                            <a class="dropdown-item" href="{{ route('mahasiswa.profile') }}">Edit Profile</a>
                        @elseif(Auth::user()->role->name === 'Kaprodi')
                            <a class="dropdown-item" href="{{ route('kaprodi.profile') }}">Edit Profile</a>
                        @elseif(Auth::user()->role->name === 'MO')
                            <a class="dropdown-item" href="{{ route('mo.profile') }}">Edit Profile</a>
                        @else
                            <a class="dropdown-item" href="#">Unknown Role</a>
                        @endif
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">Log Out</button>
                        </form>
                    </li>
                </ul>
            </div>
        </ul>
    </div>
</header>

<!-- Notifications Modal -->
<div class="modal fade" id="notificationsModal" tabindex="-1" aria-labelledby="notificationsModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="notificationsModalLabel">Notification</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>From:</strong> <span id="modalSender"></span></p>
                <p><strong>Message:</strong> <span id="modalMessage"></span></p>
                <form method="POST" action="" id="markAsReadForm">
                    @csrf
                    <button type="submit" class="btn-sm btn-primary">Mark as Read</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- All Notifications Modal -->
<div class="modal fade" id="allNotificationsModal" tabindex="-1" aria-labelledby="allNotificationsModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="allNotificationsModalLabel">All Notifications</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @foreach ($allNotifications as $notification)
                    @php
                        $bgClass = 'bg-warning'; // Default class
                        $iconClass = 'fas fa-exclamation-triangle'; // Default icon
                        if (str_contains($notification->pesan, 'Kaprodi menyetujui permintaan Anda')) {
                            $bgClass = 'bg-success';
                            $iconClass = 'fas fa-check-circle';
                        } elseif (str_contains($notification->pesan, 'Kaprodi menolak permintaan Anda')) {
                            $bgClass = 'bg-warning';
                            $iconClass = 'fas fa-times-circle';
                        } elseif (str_contains($notification->pesan, 'MO telah membuatkan surat anda')) {
                            $bgClass = 'bg-primary';
                            $iconClass = 'fas fa-envelope';
                        }
                    @endphp
                    <div class="d-flex align-items-center mb-3">
                        <div class="{{ $bgClass }} d-flex justify-content-center align-items-center"
                            style="border-radius: 50%; width: 2rem; height: 2rem;">
                            <i class="{{ $iconClass }} text-white"></i>
                        </div>
                        <div style="margin-left: 0.5rem">
                            <div class="small text-gray-800"><strong>From: {{ $notification->user->name }} </strong>
                            </div>
                            {{ $notification->pesan }}
                        </div>
                        <button class="btn-sm btn-primary ms-auto" data-bs-toggle="modal"
                            data-bs-target="#notificationsModal" data-message="{{ $notification->pesan }}"
                            data-sender="{{ $notification->user->name }}"
                            data-id="{{ $notification->idnotifikasi }}">
                            View
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const notificationsModal = document.getElementById('notificationsModal');
        notificationsModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const message = button.getAttribute('data-message');
            const sender = button.getAttribute('data-sender');
            const notificationId = button.getAttribute('data-id'); // Get notification ID

            const modalMessage = notificationsModal.querySelector('#modalMessage');
            const modalSender = notificationsModal.querySelector('#modalSender');
            const markAsReadForm = notificationsModal.querySelector('#markAsReadForm');

            modalMessage.textContent = message;
            modalSender.textContent = sender;
            markAsReadForm.action =
                `/notifications/${notificationId}/markAsRead`; // Set form action dynamically
        });

        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('d-none');
        });

        // Debugging dropdown toggle
        const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
        dropdownToggles.forEach(toggle => {
            toggle.addEventListener('click', function() {
                console.log('Dropdown clicked:', this);
            });
        });

        // Ensure Bootstrap dropdown is initialized
        const dropdownElements = document.querySelectorAll('.dropdown-toggle');
        dropdownElements.forEach(dropdown => {
            new bootstrap.Dropdown(dropdown);
        });

        // Ensure modal backdrop is removed when modal is closed
        const modals = document.querySelectorAll('.modal');
        modals.forEach(modal => {
            modal.addEventListener('hidden.bs.modal', function() {
                const backdrops = document.querySelectorAll('.modal-backdrop');
                backdrops.forEach(backdrop => backdrop.remove());
            });
        });
    });
</script>

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

    .dropdown-menu {
        max-width: 1200px !important;
        word-wrap: break-word;
        overflow-wrap: break-word;
        white-space: normal;
        right: 1% !important;
        left: auto !important;
        transform: translateY(1%) !important;
        margin-top: 50px !important;
    }

    @media (min-width: 992px) {
        .dropdown-menu {
            max-width: 800px !important;
        }
    }

    @media (max-width: 992px) {
        .dropdown-menu {
            max-width: 90% !important;
            right: auto !important;
            left: 0 !important;
            transform: translateY(0) !important;
            margin-top: 2.5rem !important;
            word-wrap: break-word !important;
            overflow-wrap: break-word !important;
            white-space: normal !important;
        }

        .dropdown-item {
            white-space: normal !important;
            /* Ensure text wraps within the dropdown */
            word-wrap: break-word !important;
            overflow-wrap: break-word !important;
        }
    }

    .dropdown-item p {
        margin-bottom: 0;
        white-space: normal;
    }

    .nav-item.dropdown.no-arrow {
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .modal-backdrop {
        background-color: rgba(0, 0, 0, 0.3) !important;
    }

    .modal-dialog {
        max-width: 800px !important;
    }

    .mobile-nav-toggle i {
        color: black !important;
    }

    .bi-x::before {
        color: black !important;
    }
</style>
