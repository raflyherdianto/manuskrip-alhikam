@extends('layouts.app')

@section('content')
<!-- Activity Dashboard CSS -->
<link href="{{ asset('assets/css/activity.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/activity-content.css') }}" rel="stylesheet">

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

<!-- Quill Text Editor CSS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<div class="activity-dashboard">
    <!-- Sidebar -->
    <aside class="activity-sidebar" id="activitySidebar">
        <!-- Sidebar Header -->
        <div class="sidebar-header">
            <h2 class="sidebar-title">Dashboard Mahasiswa</h2>
            <button class="sidebar-close" id="sidebarClose" aria-label="Close sidebar">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <!-- User Info -->
        <div class="sidebar-user">
            <div class="user-avatar">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div class="user-name">{{ Auth::user()->name }}</div>
            <div class="user-role">
                @if(Auth::user()->angkatan && Auth::user()->jurusan)
                    {{ Auth::user()->angkatan }} - {{ Auth::user()->jurusan->nama }}
                @else
                    {{ Auth::user()->angkatan ?? 'Mahasiswa' }}
                @endif
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="sidebar-nav">
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="{{ route('activity') }}" class="nav-link active">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('activity.profile') }}" class="nav-link">
                        <i class="bi bi-person-circle"></i>
                        <span>Profil</span>
                    </a>
                </li>
            </ul>
        </nav>
    </aside>

    <!-- Sidebar Overlay for Mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Main Content -->
    <main class="activity-main">
        <!-- Header with Menu Toggle -->
        <div class="activity-header">
            <button class="menu-toggle" id="menuToggle" aria-label="Toggle menu">
                <i class="bi bi-list"></i>
            </button>
            <h1 class="page-title">Dashboard</h1>
        </div>

        <!-- Dashboard Content -->
        <div class="dashboard-content">
            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="bi bi-file-earmark-text"></i>
                    </div>
                    <div class="stat-label">Total Manuskrip</div>
                    <div class="stat-value">{{ $totalKarya ?? 0 }}</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <div class="stat-label">Manuskrip Diterima</div>
                    <div class="stat-value">{{ $karyaDiterima ?? 0 }}</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    <div class="stat-label">Menunggu</div>
                    <div class="stat-value">{{ $karyaMenunggu ?? 0 }}</div>
                </div>

                <div class="stat-card clickable" id="tahunIniCard">
                    <div class="stat-icon">
                        <i class="bi bi-calendar-event"></i>
                    </div>
                    <div class="stat-label">Tahun Ini</div>
                    <div class="stat-value">{{ $karyaTahunIni ?? 0 }}</div>
                </div>
            </div>

            <!-- Activity Table -->
            <div class="activity-table-wrapper">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="table-title mb-0">
                        <i class="bi bi-list-ul me-2"></i>
                        <span>Semua Aktivitas</span>
                    </h3>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadKaryaModal">
                        <i class="bi bi-cloud-upload me-1"></i> Unggah Manuskrip
                    </button>
                </div>
                <div class="table-responsive">
                    <table id="activityTable" class="table table-bordered nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>Deskripsi</th>
                                <th>Kontributor</th>
                                <th>Revisi</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be loaded via AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Chart Section -->
            <div class="chart-container">
                <div class="chart-header">
                    <h3 class="chart-title">
                        <i class="bi bi-bar-chart-fill me-2"></i>
                        Statistik Manuskrip per Bulan
                    </h3>
                    <div class="chart-controls">
                        <label for="yearFilter" class="year-filter-label">Tahun:</label>
                        <select id="yearFilter" class="year-filter-select">
                            @php
                                $currentYear = date('Y');
                                $startYear = $currentYear - 5;
                            @endphp
                            @for ($y = $currentYear; $y >= $startYear; $y--)
                                <option value="{{ $y }}" {{ $y == $currentYear ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="chart-wrapper">
                    <canvas id="chartTahunan"></canvas>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Yearly History Modal -->
<div class="modal-overlay" id="yearlyHistoryModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">
                <i class="bi bi-calendar-check me-2"></i>
                Riwayat Manuskrip per Tahun
            </h3>
            <button class="modal-close" id="closeYearlyModal" aria-label="Close modal">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <div class="modal-body" id="yearlyHistoryContent">
            <div class="loading-spinner">
                <i class="bi bi-arrow-clockwise"></i>
                <span>Memuat data...</span>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- jQuery (required for DataTables) -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

<!-- Quill Text Editor JS -->
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<!-- Activity Dashboard JavaScript -->
<script src="{{ asset('assets/js/activity.js') }}"></script>

<script>
// Pass route to JavaScript
window.activityRoute = "{{ route('activity') }}";
</script>
<script src="{{ asset('assets/js/activity-content.js') }}"></script>

<!-- Include Modals -->
@include('activity.upload-modal')
@include('activity.detail-modal')
@include('activity.edit-modal')

@endsection
