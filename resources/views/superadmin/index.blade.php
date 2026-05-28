@extends('layouts.superadmin')

@section('page-title', 'Dashboard')

@section('content')
<div class="dashboard-container">
    <!-- Welcome Banner -->
    <div class="welcome-banner">
        <div class="welcome-content">
            <h1>Selamat Datang, {{ Auth::user()->name ?? 'Superadmin' }}! 👋</h1>
            <p>Kelola sistem Manuskrip Digital Pesantren dengan mudah dan efisien</p>
        </div>
        <div class="welcome-illustration">
            <i class="bi bi-rocket-takeoff-fill"></i>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card stat-primary">
            <div class="stat-icon">
                <i class="bi bi-people-fill"></i>
            </div>
            <div class="stat-content">
                <h3>{{ number_format($totalMahasiswa) }}</h3>
                <p>Total Mahasiswa</p>
            </div>
        </div>

        <div class="stat-card stat-success">
            <div class="stat-icon">
                <i class="bi bi-folder-fill"></i>
            </div>
            <div class="stat-content">
                <h3>{{ number_format($totalKarya) }}</h3>
                <p>Total Manuskrip</p>
            </div>
        </div>

        <div class="stat-card stat-warning">
            <div class="stat-icon">
                <i class="bi bi-clock-history"></i>
            </div>
            <div class="stat-content">
                <h3>{{ number_format($karyaMenunggu) }}</h3>
                <p>Manuskrip Menunggu Verifikasi</p>
            </div>
        </div>

        <div class="stat-card stat-info">
            <div class="stat-icon">
                <i class="bi bi-person-x-fill"></i>
            </div>
            <div class="stat-content">
                <h3>{{ number_format($userBelumVerifikasi) }}</h3>
                <p>User Belum Terverifikasi</p>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="content-grid">
        <!-- Recent Activity -->
        <div class="content-card">
            <div class="card-header">
                <h5>
                    <i class="bi bi-clock-history"></i>
                    Aktivitas Semua
                </h5>
                <a href="#" class="btn-text" data-bs-toggle="modal" data-bs-target="#notificationModal">Lihat Semua</a>
            </div>
            <div class="card-body">
                <div class="activity-list">
                    @forelse($activities as $activity)
                        @if($activity['type'] === 'new')
                            @php
                                $karya = \App\Models\Karya::find($activity['data']['karya_id']);
                                $user = isset($activity['data']['user_id']) ? \App\Models\User::find($activity['data']['user_id']) : null;

                                if ($karya) {
                                    $userName = $user ? $user->name : 'User';
                                    $createdAt = \Carbon\Carbon::parse($activity['created_at']);
                                }
                            @endphp

                            @if($karya)
                                <div class="activity-item">
                                    <div class="activity-icon activity-warning">
                                        <i class="bi bi-exclamation-triangle-fill"></i>
                                    </div>
                                    <div class="activity-content">
                                        <h6>Manuskrip baru menunggu verifikasi</h6>
                                        <p>{{ $userName }} mengunggah manuskrip baru "{{ $karya->title }}"</p>
                                        <span class="activity-time">{{ $createdAt->diffForHumans() }}</span>
                                    </div>
                                </div>
                            @endif
                        @elseif($activity['type'] === 'published')
                            @php
                                $karya = \App\Models\Karya::find($activity['data']['karya_id']);
                                $admin = \App\Models\User::find($activity['data']['admin_id']);

                                if ($karya && $admin) {
                                    // Clean admin name - skip titles
                                    $adminName = $admin->name;
                                    $titles = ['Ir.', 'Prof.', 'Dr.', 'dr.'];
                                    foreach ($titles as $title) {
                                        $adminName = preg_replace('/^' . preg_quote($title, '/') . '\s*/i', '', $adminName);
                                    }
                                    // Get first name only
                                    $firstName = explode(' ', trim($adminName))[0];

                                    $createdAt = \Carbon\Carbon::parse($activity['created_at']);
                                }
                            @endphp

                            @if($karya && $admin)
                                <div class="activity-item">
                                    <div class="activity-icon activity-success">
                                        <i class="bi bi-check-circle-fill"></i>
                                    </div>
                                    <div class="activity-content">
                                        <h6>Manuskrip baru dipublikasi</h6>
                                        <p>Dosen {{ $firstName }} telah mempublikasi manuskrip "{{ $karya->title }}"</p>
                                        <span class="activity-time">{{ $createdAt->diffForHumans() }}</span>
                                    </div>
                                </div>
                            @endif
                        @endif
                    @empty
                        <div class="text-center py-5">
                            <div class="mb-4">
                                <i class="bi bi-inbox" style="font-size: 4rem; color: #d1d5db;"></i>
                            </div>
                            <h5 class="text-muted mb-2" style="font-size: 1.1rem; font-weight: 600;">Belum Ada Aktivitas</h5>
                            <p class="text-muted mb-0" style="font-size: 0.95rem;">Aktivitas akan muncul di sini ketika ada manuskrip baru yang dipublikasi</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="content-card">
            <div class="card-header">
                <h5>
                    <i class="bi bi-lightning-charge-fill"></i>
                    Quick Actions
                </h5>
            </div>
            <div class="card-body">
                <div class="quick-actions">
                    @if(auth()->user()->role !== 'admin')
                    <a href="{{ route('superadmin.kelola-user') }}" class="action-btn action-primary">
                        <i class="bi bi-person-plus-fill"></i>
                        <span>Tambah User</span>
                    </a>
                    @endif
                    <a href="{{ auth()->user()->role === 'admin' ? route('admin.kelola-karya') : route('superadmin.kelola-karya') }}" class="action-btn action-info">
                        <i class="bi bi-folder-plus"></i>
                        <span>Kelola Manuskrip</span>
                    </a>
                    @if(auth()->user()->role !== 'admin')
                    <a href="{{ route('superadmin.kelola-jurusan') }}" class="action-btn action-warning">
                        <i class="bi bi-building-add"></i>
                        <span>Tambah Jurusan</span>
                    </a>
                    <a href="{{ route('superadmin.kelola-kategori') }}" class="action-btn action-danger">
                        <i class="bi bi-book-half"></i>
                        <span>Tambah Kategori</span>
                    </a>
                    @endif
                    {{-- <a href="#" class="action-btn action-purple">
                        <i class="bi bi-bar-chart-fill"></i>
                        <span>Lihat Laporan</span>
                    </a> --}}
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Analytics -->
    <div class="analytics-grid">
        @if(auth()->user()->role !== 'admin')
        <div class="content-card">
            <div class="card-header">
                <h5>
                    <i class="bi bi-pie-chart-fill"></i>
                    Distribusi Manuskrip per Jurusan
                </h5>
            </div>
            <div class="card-body">
                <div class="distribution-list">
                    @foreach($distribusiKarya as $index => $item)
                    <div class="distribution-item">
                        <div class="distribution-info">
                            <span class="distribution-label">
                                <span class="color-dot" style="background: {{ $colors[$index % count($colors)] }};"></span>
                                {{ $item->nama }}
                            </span>
                            <span class="distribution-value">{{ number_format($item->total) }}</span>
                        </div>
                        <div class="distribution-bar">
                            <div class="distribution-progress" style="width: {{ $item->percentage }}%; background: {{ $colors[$index % count($colors)] }};"></div>
                        </div>
                        <span class="distribution-percent">{{ $item->percentage }}%</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <div class="content-card">
            <div class="card-header">
                <h5>
                    <i class="bi bi-bookmark-fill"></i>
                    Distribusi Manuskrip per Jenis
                </h5>
            </div>
            <div class="card-body">
                <div class="distribution-list">
                    @foreach($distribusiJenis as $index => $item)
                    <div class="distribution-item">
                        <div class="distribution-info">
                            <span class="distribution-label">
                                <span class="color-dot" style="background: {{ $colors[$index % count($colors)] }};"></span>
                                {{ $item->nama }}
                            </span>
                            <span class="distribution-value">{{ number_format($item->total) }}</span>
                        </div>
                        <div class="distribution-bar">
                            <div class="distribution-progress" style="width: {{ $item->percentage }}%; background: {{ $colors[$index % count($colors)] }};"></div>
                        </div>
                        <span class="distribution-percent">{{ $item->percentage }}%</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection
