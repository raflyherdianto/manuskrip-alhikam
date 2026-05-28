<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('assets/img/logo-title.png') }}" type="image/png">
    <title>{{ Auth::user()->role === 'admin' ? 'Admin' : 'Superadmin' }} - Pesantren Mahasiswa Al-Hikam Malang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/superadmin.css') }}">
</head>
<body>
    <!-- Mobile Menu Toggle -->
    <button class="mobile-menu-toggle" id="mobileMenuToggle">
        <i class="bi bi-list"></i>
    </button>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="logo-container">
                <img src="{{ asset('assets/img/logo-title.png') }}" alt="Logo" class="logo-img">
                <div class="logo-text">
                    <h5>Manuskrip Digital</h5>
                    <span>{{ Auth::user()->role === 'superadmin' ? 'Superadmin' : 'Admin' }} Panel</span>
                </div>
            </div>
        </div>

        <nav class="sidebar-nav">
            <ul class="nav-list">
                <li class="nav-item">
                    <a href="{{ Auth::user()->role === 'superadmin' ? route('superadmin.dashboard') : route('admin.dashboard') }}" class="nav-link {{ request()->is('superadmin/dashboard') || request()->is('admin/dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ Auth::user()->role === 'superadmin' ? route('superadmin.kelola-user') : route('admin.kelola-user') }}" class="nav-link {{ request()->is('superadmin/kelola-user*') || request()->is('admin/kelola-user*') ? 'active' : '' }}">
                        <i class="bi bi-people-fill"></i>
                        <span>Manajemen User</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ Auth::user()->role === 'superadmin' ? route('superadmin.kelola-karya') : route('admin.kelola-karya') }}" class="nav-link {{ request()->is('superadmin/kelola-karya*') || request()->is('admin/kelola-karya*') ? 'active' : '' }}">
                        <i class="bi bi-folder-fill"></i>
                        <span>Manajemen Manuskrip</span>
                    </a>
                </li>
                @if(Auth::user()->role === 'superadmin')
                <li class="nav-item">
                    <a href="{{ route('superadmin.kelola-jurusan') }}" class="nav-link {{ request()->is('superadmin/kelola-jurusan*') ? 'active' : '' }}">
                        <i class="bi bi-building"></i>
                        <span>Manajemen Jurusan</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('superadmin.kelola-kategori') }}" class="nav-link {{ request()->is('superadmin/kelola-kategori*') ? 'active' : '' }}">
                        <i class="bi bi-book-fill"></i>
                        <span>Manajemen Kategori</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('superadmin.kelola-bahasa') }}" class="nav-link {{ request()->is('superadmin/kelola-bahasa*') ? 'active' : '' }}">
                        <i class="bi bi-translate"></i>
                        <span>Manajemen Bahasa</span>
                    </a>
                </li>
                @endif
                {{-- <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="bi bi-bar-chart-fill"></i>
                        <span>Laporan & Statistik</span>
                    </a>
                </li> --}}
            </ul>
        </nav>

        <div class="sidebar-footer">
            <div class="user-profile">
                <div class="user-avatar">
                    <i class="bi bi-person-circle"></i>
                </div>
                <div class="user-info">
                    <h6>{{ Auth::user()->name ?? 'Superadmin' }}</h6>
                    <span>{{ Auth::user()->email ?? '' }}</span>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST" class="mt-3">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content" id="mainContent">
        <!-- Top Bar -->
        <div class="topbar">
            <div class="topbar-left">
                <h4 class="page-title">@yield('page-title', 'Dashboard')</h4>
            </div>
            <div class="topbar-right">
                <button class="topbar-btn" id="notificationBtn" data-bs-toggle="modal" data-bs-target="#notificationModal">
                    <i class="bi bi-bell-fill"></i>
                    @php
                        $currentUser = Auth::user();
                        $isAdmin = $currentUser->role === 'admin';
                        $jurusanId = $currentUser->jurusan_id;

                        if ($isAdmin && $jurusanId) {
                            $unreadCount = DB::table('notifications')
                                ->whereNull('read_at')
                                ->whereRaw("JSON_EXTRACT(data, '$.karya_id') IN (
                                    SELECT k.id
                                    FROM karyas k
                                    INNER JOIN users u ON k.user_id = u.id
                                    WHERE u.jurusan_id = ?
                                )", [$jurusanId])
                                ->count();
                        } else {
                            $unreadCount = DB::table('notifications')->whereNull('read_at')->count();
                        }
                    @endphp
                    @if($unreadCount > 0)
                        <span class="badge">{{ $unreadCount }}</span>
                    @endif
                </button>
                <div class="user-menu">
                    <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name ?? 'SA' }}&background=6366f1&color=fff" alt="User" class="user-avatar-small">
                </div>
            </div>
        </div>

        <!-- Content Area -->
        <div class="content-area">
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <strong>Terjadi kesalahan!</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <strong>Berhasil!</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Overlay for mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Notification Modal -->
    <div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="notificationModalLabel">
                        <i class="bi bi-bell-fill me-2"></i>Riwayat Notifikasi
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="notificationList">
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-sm btn-primary" id="markAllReadBtn">Tandai Semua Dibaca</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/js/superadmin.js') }}"></script>

    <script>
        // Load notifications when modal is opened
        document.getElementById('notificationModal').addEventListener('show.bs.modal', function() {
            loadNotifications();
        });

        function loadNotifications() {
            // Determine the correct route based on user role
            const isAdmin = {{ Auth::user()->role === 'admin' ? 'true' : 'false' }};
            const notificationsUrl = isAdmin ? '/admin/notifications' : '/superadmin/notifications';

            fetch(notificationsUrl)
                .then(response => response.json())
                .then(data => {
                    const notificationList = document.getElementById('notificationList');

                    if (data.length === 0) {
                        notificationList.innerHTML = '<div class="text-center text-muted py-4">Belum ada notifikasi</div>';
                        return;
                    }

                    let html = '<div class="list-group list-group-flush">';
                    data.forEach(notification => {
                        const isRead = notification.read_at !== null;
                        const timeAgo = notification.time_ago || 'Baru saja';

                        let iconHtml = '';
                        if (notification.type === 'published') {
                            iconHtml = '<i class="bi bi-check-circle-fill text-success me-2"></i>';
                        } else if (notification.type === 'new') {
                            iconHtml = '<i class="bi bi-exclamation-triangle-fill text-warning me-2"></i>';
                        }

                        html += `
                            <div class="list-group-item ${!isRead ? 'bg-light' : ''}">
                                <div class="d-flex w-100 justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center mb-1">
                                            ${iconHtml}
                                            <h6 class="mb-0">${notification.title}</h6>
                                        </div>
                                        <p class="mb-1 small">${notification.message}</p>
                                        <small class="text-muted">${timeAgo}</small>
                                    </div>
                                    ${!isRead ? '<span class="badge bg-primary rounded-pill ms-2">Baru</span>' : ''}
                                </div>
                            </div>
                        `;
                    });
                    html += '</div>';

                    notificationList.innerHTML = html;
                })
                .catch(error => {
                    console.error('Error loading notifications:', error);
                    document.getElementById('notificationList').innerHTML =
                        '<div class="alert alert-danger">Gagal memuat notifikasi</div>';
                });
        }

        function formatTimeAgo(date) {
            const seconds = Math.floor((new Date() - date) / 1000);

            const intervals = {
                tahun: 31536000,
                bulan: 2592000,
                minggu: 604800,
                hari: 86400,
                jam: 3600,
                menit: 60,
                detik: 1
            };

            for (const [name, secondsInInterval] of Object.entries(intervals)) {
                const interval = Math.floor(seconds / secondsInInterval);
                if (interval >= 1) {
                    return `${interval} ${name} yang lalu`;
                }
            }

            return 'Baru saja';
        }

        // Mark all as read
        document.getElementById('markAllReadBtn').addEventListener('click', function() {
            // Determine the correct route based on user role
            const isAdmin = {{ Auth::user()->role === 'admin' ? 'true' : 'false' }};
            const markReadUrl = isAdmin ? '/admin/notifications/mark-read' : '/superadmin/notifications/mark-read';

            fetch(markReadUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    loadNotifications();
                    // Update badge
                    const badge = document.querySelector('#notificationBtn .badge');
                    if (badge) badge.remove();
                }
            })
            .catch(error => console.error('Error marking as read:', error));
        });
    </script>
</body>
</html>
