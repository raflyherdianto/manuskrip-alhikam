@extends('layouts.superadmin')

@section('page-title', 'Manajemen Manuskrip')

@section('content')
<!-- Toast Container -->
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
    <div id="successToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                <i class="bi bi-check-circle-fill me-2"></i>
                <span id="toastMessage"></span>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<div class="dashboard-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-content">
            <h2>
                <i class="bi bi-folder-fill"></i>
                Manajemen Manuskrip
            </h2>
            <p>Kelola daftar manuskrip yang tersedia di sistem</p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card stat-primary">
            <div class="stat-icon">
                <i class="bi bi-folder-fill"></i>
            </div>
            <div class="stat-content">
                <h3>{{ number_format($totalKarya) }}</h3>
                <p>Total Manuskrip</p>
            </div>
        </div>

        <div class="stat-card stat-success">
            <div class="stat-icon">
                <i class="bi bi-check-circle-fill"></i>
            </div>
            <div class="stat-content">
                <h3>{{ number_format($karyaTerpublish) }}</h3>
                <p>Manuskrip Terpublish</p>
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

        <div class="stat-card stat-secondary">
            <div class="stat-icon">
                <i class="bi bi-archive-fill"></i>
            </div>
            <div class="stat-content">
                <h3>{{ number_format($karyaDiarsipkan) }}</h3>
                <p>Diarsipkan</p>
            </div>
        </div>

        <div class="stat-card stat-info" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#downloadModal">
            <div class="stat-icon">
                <i class="bi bi-download"></i>
            </div>
            <div class="stat-content">
                {{-- <h3><i class="bi bi-file-earmark-excel"></i></h3> --}}
                <p>Download Laporan</p>
            </div>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="content-card">
        <div class="card-header">
            <h5>
                <i class="bi bi-table"></i>
                Daftar Manuskrip
            </h5>
        </div>
        <div class="card-body">
            <!-- Filter Buttons -->
            <div class="filter-buttons mb-3">
                <button type="button" class="btn btn-filter {{ request('status') == 'Terpublish' ? 'active' : '' }}" data-status="Terpublish">
                    <i class="bi bi-check-circle"></i> Terpublish
                </button>
                <button type="button" class="btn btn-filter {{ request('status') == 'Menunggu' ? 'active' : '' }}" data-status="Menunggu">
                    <i class="bi bi-clock-history"></i> Menunggu
                </button>
                <button type="button" class="btn btn-filter {{ request('status') == 'Arsip' ? 'active' : '' }}" data-status="Arsip">
                    <i class="bi bi-archive"></i> Arsip
                </button>
                <button type="button" class="btn btn-filter {{ !request('status') ? 'active' : '' }}" data-status="">
                    <i class="bi bi-list"></i> Semua
                </button>
            </div>

            <!-- Search Bar -->
            <div class="search-container mb-4">
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" id="searchInput" class="form-control" placeholder="Cari manuskrip..." value="{{ request('search') }}">
                </div>
            </div>

            <div id="tableContainer">
                <div class="table-responsive">
                    <table class="table table-hover" id="karyasTable">
                        <thead>
                            <tr>
                                <th style="width: 5%;">No</th>
                                <th style="width: 30%;">
                                    <a href="javascript:void(0)" class="sortable-header" data-sort="title">
                                        Judul Manuskrip
                                        <i class="bi bi-arrow-{{ request('sort_by') == 'title' && request('sort_order') == 'asc' ? 'up' : (request('sort_by') == 'title' ? 'down' : 'down-up') }}" id="sort-icon-title"></i>
                                    </a>
                                </th>
                                <th style="width: 15%;">
                                    <a href="javascript:void(0)" class="sortable-header" data-sort="user_id">
                                        Penulis
                                        <i class="bi bi-arrow-{{ request('sort_by') == 'user_id' && request('sort_order') == 'asc' ? 'up' : (request('sort_by') == 'user_id' ? 'down' : 'down-up') }}" id="sort-icon-user_id"></i>
                                    </a>
                                </th>
                                <th style="width: 15%;">
                                    <a href="javascript:void(0)" class="sortable-header" data-sort="jenis_karya_id">
                                        Jenis Manuskrip
                                        <i class="bi bi-arrow-{{ request('sort_by') == 'jenis_karya_id' && request('sort_order') == 'asc' ? 'up' : (request('sort_by') == 'jenis_karya_id' ? 'down' : 'down-up') }}" id="sort-icon-jenis_karya_id"></i>
                                    </a>
                                </th>
                                <th style="width: 10%;">
                                    <a href="javascript:void(0)" class="sortable-header" data-sort="status">
                                        Status
                                        <i class="bi bi-arrow-{{ request('sort_by') == 'status' && request('sort_order') == 'asc' ? 'up' : (request('sort_by') == 'status' ? 'down' : 'down-up') }}" id="sort-icon-status"></i>
                                    </a>
                                </th>
                                <th style="width: 10%;">
                                    <a href="javascript:void(0)" class="sortable-header" data-sort="date">
                                        Dibuat
                                        <i class="bi bi-arrow-{{ request('sort_by') == 'date' && request('sort_order') == 'asc' ? 'up' : (request('sort_by') == 'date' ? 'down' : 'down-up') }}" id="sort-icon-date"></i>
                                    </a>
                                </th>
                                <th style="width: 15%;" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            @forelse($karyas as $index => $karya)
                            <tr>
                                <td>{{ ($karyas->currentPage() - 1) * $karyas->perPage() + $index + 1 }}</td>
                                <td>
                                    <strong>{{ Str::limit($karya->title, 50) }}</strong>
                                </td>
                                <td>
                                    <small>{{ $karya->user->name ?? '-' }}</small>
                                </td>
                                <td>
                                    <small>{{ $karya->jenisKarya->nama ?? '-' }}</small>
                                </td>
                                <td>
                                    @if($karya->status == 'Terpublish')
                                        <span class="badge bg-success">{{ $karya->status }}</span>
                                    @elseif($karya->status == 'Menunggu')
                                        <span class="badge bg-warning">{{ $karya->status }}</span>
                                    @else
                                        <span class="badge bg-danger">{{ $karya->status }}</span>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted">
                                        <i class="bi bi-calendar3"></i>
                                        {{ \Carbon\Carbon::parse($karya->date)->format('d M Y') }}
                                    </small>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        @if (auth()->user()->role === 'superadmin')
                                            <button type="button" class="btn btn-info btn-detail" data-id="{{ $karya->id }}">
                                                <i class="bi bi-eye"></i> Detail
                                            </button>
                                            <button type="button" class="btn btn-warning btn-edit" data-id="{{ $karya->id }}">
                                                <i class="bi bi-pencil"></i> Edit
                                            </button>
                                            <button type="button" class="btn btn-danger btn-delete" data-id="{{ $karya->id }}" data-name="{{ $karya->title }}">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        @endif
                                        @if (auth()->user()->role === 'admin')
                                            <button type="button" class="btn btn-info btn-detail" data-id="{{ $karya->id }}">
                                                <i class="bi bi-eye"></i> Detail
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <i class="bi bi-inbox" style="font-size: 3rem; color: var(--gray-400);"></i>
                                    <p class="mt-2 text-muted">
                                        @if(request('search'))
                                            Tidak ada hasil untuk "{{ request('search') }}"
                                        @else
                                            Belum ada data manuskrip
                                        @endif
                                    </p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($karyas->hasPages())
                <div class="pagination-container mt-4" id="paginationContainer">
                    <div class="pagination-info">
                        Menampilkan {{ $karyas->firstItem() }} - {{ $karyas->lastItem() }} dari {{ $karyas->total() }} data
                    </div>
                    <div class="pagination-links">
                        {{ $karyas->links('vendor.pagination.custom') }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    @if(auth()->user()->role !== 'admin')
    <!-- Page Header Jenis Karya -->
    <div class="page-header" style="margin-top: var(--space-8);">
        <div class="page-header-content">
            <h2>
                <i class="bi bi-bookmark-fill"></i>
                Manajemen Jenis Manuskrip
            </h2>
            <p>Kelola daftar jenis manuskrip yang tersedia di sistem</p>
        </div>
    </div>

    <!-- Statistics Cards Jenis Karya -->
    <div class="stats-grid">
        <div class="stat-card stat-info">
            <div class="stat-icon">
                <i class="bi bi-bookmark-fill"></i>
            </div>
            <div class="stat-content">
                <h3>{{ number_format($jenisKaryas->total()) }}</h3>
                <p>Total Jenis Manuskrip</p>
            </div>
        </div>
    </div>

    <!-- Data Table Card Jenis Karya -->
    <div class="content-card">
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h5>
                <i class="bi bi-table"></i>
                Daftar Jenis Manuskrip
            </h5>
            <button type="button" class="btn btn-primary btn-sm" id="btnAddJenisKarya">
                <i class="bi bi-plus-circle"></i> Tambah Jenis Manuskrip
            </button>
        </div>
        <div class="card-body">
            <!-- Search Bar -->
            <div class="search-container mb-4">
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" id="searchJenisKaryaInput" class="form-control" placeholder="Cari jenis manuskrip..." value="">
                </div>
            </div>

            <!-- Data Table -->
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th>Nama Jenis Manuskrip</th>
                            <th style="width: 15%;">Jumlah Manuskrip</th>
                            <th style="width: 20%;" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="jenisKaryaTableBody">
                        @forelse($jenisKaryas as $index => $jenisKarya)
                        <tr>
                            <td>{{ $jenisKaryas->firstItem() + $index }}</td>
                            <td>
                                <strong>{{ $jenisKarya->nama }}</strong>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $jenisKarya->karyas_count }} manuskrip</span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-info btn-detail-jenis-karya" data-id="{{ $jenisKarya->id }}">
                                        <i class="bi bi-eye"></i> Detail
                                    </button>
                                    <button type="button" class="btn btn-warning btn-edit-jenis-karya" data-id="{{ $jenisKarya->id }}">
                                        <i class="bi bi-pencil"></i> Edit
                                    </button>
                                    <button type="button" class="btn btn-danger btn-delete-jenis-karya" data-id="{{ $jenisKarya->id }}" data-name="{{ $jenisKarya->nama }}">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4">
                                <i class="bi bi-inbox" style="font-size: 3rem; color: var(--gray-400);"></i>
                                <p class="mt-2 text-muted">
                                    Belum ada data jenis manuskrip
                                </p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($jenisKaryas->hasPages())
            <div class="pagination-container mt-4">
                <div class="pagination-info">
                    Menampilkan {{ $jenisKaryas->firstItem() }} - {{ $jenisKaryas->lastItem() }} dari {{ $jenisKaryas->total() }} data
                </div>
                <div class="pagination-links">
                    {{ $jenisKaryas->links('vendor.pagination.custom') }}
                </div>
            </div>
            @endif
        </div>
    </div>
    @endif
</div>

<!-- Detail Modal -->
@include('superadmin.karya.detail-modal')

<!-- Edit Modal -->
@include('superadmin.karya.edit-modal')

<!-- Download Modal -->
<div class="modal fade" id="downloadModal" tabindex="-1" aria-labelledby="downloadModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="downloadModalLabel">
                    <i class="bi bi-download me-2"></i>Download Laporan Manuskrip
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="downloadForm">
                    <div class="mb-3">
                        <label for="downloadYear" class="form-label">Pilih Tahun</label>
                        <select class="form-select" id="downloadYear" name="year" required>
                            <option value="">-- Pilih Tahun --</option>
                            @foreach($availableYears as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        Laporan akan berisi data manuskrip dengan status <strong>Terpublish</strong> dan dikelompokkan per jurusan dalam sheet terpisah.
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="btnDownload">
                    <i class="bi bi-download me-1"></i>Download
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Jenis Karya Modals -->
@include('superadmin.jenis-karya.detail-modal')
@include('superadmin.jenis-karya.edit-modal')
@include('superadmin.jenis-karya.add-modal')

<style>
.page-header {
    background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
    border-radius: var(--radius-xl);
    padding: var(--space-8);
    margin-bottom: var(--space-6);
    color: var(--white);
}

.page-header-content h2 {
    margin: 0 0 var(--space-2) 0;
    font-size: 1.875rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: var(--space-3);
}

.page-header-content p {
    margin: 0;
    opacity: 0.9;
}

.stat-card[data-bs-toggle="modal"] {
    transition: all 0.3s ease;
}

.stat-card[data-bs-toggle="modal"]:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
}

.stat-card[data-bs-toggle="modal"] .stat-icon {
    transition: all 0.3s ease;
}

.stat-card[data-bs-toggle="modal"]:hover .stat-icon {
    transform: scale(1.1);
}

.search-container {
    margin-bottom: var(--space-4);
}

.search-form .input-group {
    display: flex;
    gap: 0;
}

.input-group-text {
    background: var(--white);
    border: 2px solid var(--gray-300);
    border-right: none;
    border-radius: var(--radius-md) 0 0 var(--radius-md);
    padding: var(--space-3) var(--space-4);
    color: var(--gray-600);
}

.search-form .form-control {
    border: 2px solid var(--gray-300);
    border-left: none;
    border-right: none;
    padding: var(--space-3) var(--space-4);
    font-size: 0.875rem;
}

.search-form .form-control:focus {
    border-color: var(--primary);
    box-shadow: none;
    outline: none;
}

.search-form .btn {
    border-radius: 0 var(--radius-md) var(--radius-md) 0;
    padding: var(--space-3) var(--space-5);
    font-weight: 500;
}

.search-form .btn-secondary {
    border-radius: var(--radius-md);
    margin-left: var(--space-2);
}

.table-responsive {
    overflow-x: auto;
}

.table {
    width: 100%;
    margin-bottom: 0;
}

.table thead th {
    background: var(--gray-100);
    color: var(--gray-700);
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.05em;
    padding: var(--space-4);
    border: none;
}

.sortable-header {
    color: var(--gray-700);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: var(--space-2);
    transition: var(--transition);
}

.sortable-header:hover {
    color: var(--primary);
}

.sortable-header i {
    font-size: 0.875rem;
}

.table tbody td {
    padding: var(--space-4);
    vertical-align: middle;
    border-bottom: 1px solid var(--gray-200);
}

.table-hover tbody tr {
    transition: var(--transition);
}

.table-hover tbody tr:hover {
    background: var(--gray-50);
}

.btn-group-sm .btn {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
    border-radius: var(--radius-md);
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
}

.btn-group-sm .btn i {
    font-size: 0.875rem;
}

.btn-info {
    background: var(--info);
    color: var(--white);
    border: none;
}

.btn-info:hover {
    background: #2563eb;
    color: var(--white);
}

.btn-warning {
    background: var(--warning);
    color: var(--white);
    border: none;
}

.btn-warning:hover {
    background: #d97706;
    color: var(--white);
}

.btn-danger {
    background: var(--danger);
    color: var(--white);
    border: none;
}

.btn-danger:hover {
    background: #dc2626;
    color: var(--white);
}

@media (max-width: 768px) {
    .btn-group-sm {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
        width: 100%;
    }

    .btn-group-sm .btn {
        padding: 0.35rem 0.5rem;
        font-size: 0.75rem;
        width: 100%;
        justify-content: center;
    }
}

.badge {
    padding: 0.375rem 0.75rem;
    font-size: 0.75rem;
    font-weight: 600;
    border-radius: var(--radius-md);
}

.filter-buttons {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.btn-filter {
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
    font-weight: 500;
    border: 2px solid var(--gray-300);
    background: var(--white);
    color: var(--gray-700);
    border-radius: var(--radius-md);
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-filter:hover {
    background: var(--gray-50);
    border-color: var(--primary);
    color: var(--primary);
    transform: translateY(-1px);
}

.btn-filter.active {
    background: var(--primary);
    border-color: var(--primary);
    color: var(--white);
    box-shadow: 0 2px 8px rgba(99, 102, 241, 0.3);
}

.btn-filter i {
    font-size: 1rem;
}

@media (max-width: 768px) {
    .filter-buttons {
        gap: 0.375rem;
    }

    .btn-filter {
        padding: 0.4rem 0.75rem;
        font-size: 0.813rem;
        gap: 0.375rem;
    }

    .btn-filter i {
        font-size: 0.875rem;
    }
}

.pagination-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
    padding: 1.25rem 0;
    margin-top: 1rem;
    border-top: 1px solid var(--gray-200);
}

.pagination-info {
    color: var(--gray-600);
    font-size: 0.875rem;
    font-weight: 500;
    white-space: nowrap;
    flex-shrink: 0;
}

.pagination-links {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    flex: 1;
    min-width: 0;
}

.pagination-links nav {
    display: flex;
    width: 100%;
    justify-content: flex-end;
}

.pagination-links .pagination {
    margin: 0;
    display: flex;
    flex-wrap: wrap;
    gap: 0.25rem;
    list-style: none;
    padding: 0;
    align-items: center;
    justify-content: flex-end;
}

.pagination-links .page-item {
    display: flex;
    margin: 0;
}

.pagination-links .page-link {
    color: var(--gray-700);
    background: var(--white);
    border: 1px solid var(--gray-300);
    border-radius: var(--radius-md);
    padding: 0.5rem;
    font-weight: 500;
    font-size: 0.875rem;
    transition: all 0.2s ease;
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 36px;
    height: 36px;
    line-height: 1;
    white-space: nowrap;
}

.pagination-links .page-link:hover:not(.disabled) {
    background: var(--primary);
    border-color: var(--primary);
    color: var(--white);
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(99, 102, 241, 0.2);
}

.pagination-links .page-item.active .page-link {
    background: var(--primary);
    border-color: var(--primary);
    color: var(--white);
    font-weight: 600;
    box-shadow: 0 2px 4px rgba(99, 102, 241, 0.3);
    cursor: default;
}

.pagination-links .page-item.disabled .page-link {
    color: var(--gray-400);
    background: var(--gray-50);
    border-color: var(--gray-200);
    cursor: not-allowed;
    opacity: 0.6;
    pointer-events: none;
}

.pagination-links .page-link svg {
    width: 14px;
    height: 14px;
    flex-shrink: 0;
    display: block;
}

@media (max-width: 768px) {
    .pagination-container {
        flex-direction: column;
        align-items: center;
        gap: 1rem;
        padding: 1rem 0;
    }

    .pagination-info {
        text-align: center;
        order: 2;
        width: 100%;
    }

    .pagination-links {
        justify-content: center;
        order: 1;
        width: 100%;
    }

    .pagination-links nav {
        justify-content: center;
    }

    .pagination-links .pagination {
        justify-content: center;
    }

    .pagination-links .page-link {
        padding: 0.4rem;
        min-width: 34px;
        height: 34px;
        font-size: 0.8125rem;
    }

    .pagination-links .page-link svg {
        width: 13px;
        height: 13px;
    }
}

@media (max-width: 480px) {
    .pagination-links .pagination {
        gap: 0.25rem;
    }

    .pagination-links .page-link {
        padding: 0.35rem;
        min-width: 30px;
        height: 30px;
        font-size: 0.75rem;
    }

    .pagination-links .page-link svg {
        width: 12px;
        height: 12px;
    }

    .pagination-info {
        font-size: 0.8125rem;
    }
}

#btnAddJenisKarya {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    white-space: nowrap;
}

#btnAddJenisKarya i {
    color: var(--white);
    font-size: 1rem;
}

@media (max-width: 768px) {
    #btnAddJenisKarya {
        padding: 0.5rem 0.75rem;
        font-size: 0.813rem;
        gap: 0.375rem;
    }

    #btnAddJenisKarya i {
        font-size: 0.875rem;
    }
}

@media (max-width: 480px) {
    #btnAddJenisKarya {
        padding: 0.4rem 0.65rem;
        font-size: 0.75rem;
        gap: 0.3rem;
    }

    #btnAddJenisKarya i {
        font-size: 0.813rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let searchTimeout;
    let currentSortBy = '{{ request('sort_by', 'date') }}';
    let currentSortOrder = '{{ request('sort_order', 'desc') }}';
    let currentSearch = '{{ request('search', '') }}';
    let currentStatus = '{{ request('status', '') }}';
    let currentPage = {{ $karyas->currentPage() }};

    const userRole = '{{ auth()->user()->role }}';
    const baseRoute = userRole === 'admin' ? 'admin.kelola-karya' : 'superadmin.kelola-karya';
    const baseUrl = userRole === 'admin' ? '/admin/kelola-manuskrip' : '/superadmin/kelola-manuskrip';

    // Toast function
    function showToast(message) {
        const toastElement = document.getElementById('successToast');
        const toastMessage = document.getElementById('toastMessage');
        toastMessage.textContent = message;
        const toast = new bootstrap.Toast(toastElement);
        toast.show();
    }

    // Function to load data
    function loadData(search = '', sortBy = 'date', sortOrder = 'desc', page = 1, status = '', updateUrl = false) {
        const url = new URL(baseUrl, window.location.origin);
        if (search) url.searchParams.set('search', search);
        if (status) url.searchParams.set('status', status);
        url.searchParams.set('sort_by', sortBy);
        url.searchParams.set('sort_order', sortOrder);
        url.searchParams.set('page', page);

        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newTableContainer = doc.getElementById('tableContainer');
            if (newTableContainer) {
                document.getElementById('tableContainer').innerHTML = newTableContainer.innerHTML;
            }

            // Update URL only if needed (not for sort operations)
            if (updateUrl) {
                const displayUrl = new URL(baseUrl, window.location.origin);
                if (search) displayUrl.searchParams.set('search', search);
                if (status) displayUrl.searchParams.set('status', status);
                if (page > 1) displayUrl.searchParams.set('page', page);
                window.history.pushState({}, '', displayUrl);
            }

            // Re-attach event listeners
            attachEventListeners();
            attachPaginationListeners();
            attachSortListeners();
            attachFilterListeners();
        });
    }

    // Filter buttons
    function attachFilterListeners() {
        document.querySelectorAll('.btn-filter').forEach(button => {
            button.addEventListener('click', function() {
                const status = this.getAttribute('data-status');
                currentStatus = status;
                currentPage = 1;

                // Update active state
                document.querySelectorAll('.btn-filter').forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');

                loadData(currentSearch, currentSortBy, currentSortOrder, currentPage, currentStatus, true);
            });
        });
    }

    // Search input with debounce
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const searchValue = this.value.trim();

            searchTimeout = setTimeout(() => {
                currentSearch = searchValue;
                currentPage = 1;

                // If search is empty, reset to default sort
                if (!searchValue) {
                    currentSortBy = 'date';
                    currentSortOrder = 'desc';
                }

                loadData(currentSearch, currentSortBy, currentSortOrder, currentPage, currentStatus, true);
            }, 500);
        });
    }

    // Sort headers
    function attachSortListeners() {
        document.querySelectorAll('.sortable-header').forEach(header => {
            header.addEventListener('click', function(e) {
                e.preventDefault();
                const sortBy = this.getAttribute('data-sort');

                if (currentSortBy === sortBy) {
                    currentSortOrder = currentSortOrder === 'asc' ? 'desc' : 'asc';
                } else {
                    currentSortBy = sortBy;
                    currentSortOrder = 'asc';
                }

                currentPage = 1;
                loadData(currentSearch, currentSortBy, currentSortOrder, currentPage, currentStatus, false);
            });
        });
    }

    // Pagination listeners
    function attachPaginationListeners() {
        document.querySelectorAll('.pagination a').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const url = new URL(this.href);
                const page = url.searchParams.get('page') || 1;
                currentPage = parseInt(page);
                loadData(currentSearch, currentSortBy, currentSortOrder, currentPage, currentStatus, true);
            });
        });
    }

    // Event listeners for table actions
    function attachEventListeners() {
        // Detail Button
        document.querySelectorAll('.btn-detail').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                
                // Show modal and loading state immediately
                const detailModal = new bootstrap.Modal(document.getElementById('detailModal'));
                document.getElementById('detailLoading').style.display = 'block';
                document.getElementById('detailContent').style.display = 'none';
                detailModal.show();

                fetch(`${baseUrl}/${id}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('detailTitle').textContent = data.title;
                        document.getElementById('detailUser').textContent = data.user ? data.user.name : '-';
                        document.getElementById('detailJenisKarya').textContent = data.jenis_karya?.nama || '-';
                        document.getElementById('detailKategori').textContent = data.kategori?.nama || '-';

                        // Strip HTML tags from description
                        const tempDiv = document.createElement('div');
                        tempDiv.innerHTML = data.description;
                        document.getElementById('detailDescription').textContent = tempDiv.textContent || tempDiv.innerText || '-';

                        document.getElementById('detailPembimbing').textContent = data.pembimbing?.name || '-';
                        document.getElementById('detailLanguage').textContent = data.language?.nama || '-';
                        document.getElementById('detailStatus').textContent = data.status;
                        document.getElementById('detailDate').textContent = new Date(data.date).toLocaleDateString('id-ID', {
                            day: 'numeric',
                            month: 'long',
                            year: 'numeric'
                        });

                        // Render files
                        const filesContainer = document.getElementById('detailFiles');
                        if (data.files && data.files.length > 0) {
                            let filesHtml = '<div class="file-list">';
                            data.files.forEach(file => {
                                const fileName = file.file_path.split('/').pop();
                                filesHtml += `
                                    <div class="file-item">
                                        <i class="bi bi-file-earmark-text file-icon"></i>
                                        <div class="file-info">
                                            <p class="file-name">${fileName}</p>
                                        </div>
                                        <a href="/files/${fileName}/download" class="btn-download" target="_blank">
                                            <i class="bi bi-eye"></i> Lihat Manuskrip
                                        </a>
                                    </div>
                                `;
                            });
                            filesHtml += '</div>';
                            filesContainer.innerHTML = filesHtml;
                        } else {
                            filesContainer.innerHTML = '<p class="text-muted">Tidak ada file</p>';
                        }

                        // Switch states
                        document.getElementById('detailLoading').style.display = 'none';
                        document.getElementById('detailContent').style.display = 'flex';
                    })
                    .catch(error => {
                        console.error('Error loading detail:', error);
                        document.getElementById('detailLoading').innerHTML = `
                            <div class="text-danger">
                                <i class="bi bi-exclamation-triangle-fill" style="font-size: 2rem;"></i>
                                <p class="mt-2 mb-0">Gagal memuat detail manuskrip.</p>
                            </div>
                        `;
                    });
            });
        });

        // Edit Button
        document.querySelectorAll('.btn-edit').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                fetch(`${baseUrl}/${id}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('editKaryaId').value = data.id;

                        const editStatusSelect = document.getElementById('editStatus');
                        const pilihStatusOption = editStatusSelect.querySelector('option[value=""]');
                        const menungguOption = editStatusSelect.querySelector('option[value="Menunggu"]');

                        // Jika status saat ini adalah "Menunggu"
                        if (data.status === 'Menunggu') {
                            // Tampilkan option "Pilih Status" dan sembunyikan "Menunggu"
                            pilihStatusOption.style.display = 'block';
                            menungguOption.style.display = 'none';
                            editStatusSelect.value = ''; // Set ke "Pilih Status"
                        } else {
                            // Untuk status lain, sembunyikan "Pilih Status" dan sembunyikan "Menunggu"
                            pilihStatusOption.style.display = 'none';
                            menungguOption.style.display = 'none';
                            editStatusSelect.value = data.status;
                        }

                        document.getElementById('editKeterangan').value = data.keterangan || '';
                        const editModal = new bootstrap.Modal(document.getElementById('editModal'));
                        editModal.show();
                    });
            });
        });

        // Delete Button
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');

                if(confirm(`Apakah Anda yakin ingin menghapus manuskrip "${name}"?`)) {
                    fetch(`${baseUrl}/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if(data.success) {
                            showToast('Manuskrip berhasil dihapus');
                            loadData(currentSearch, currentSortBy, currentSortOrder, currentPage, currentStatus, false);
                        }
                    });
                }
            });
        });
    }

    // Initial setup
    attachSortListeners();
    attachPaginationListeners();
    attachEventListeners();
    attachFilterListeners();

    // Edit Form Submit
    document.getElementById('editForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const id = document.getElementById('editKaryaId').value;
        const status = document.getElementById('editStatus').value;
        const keterangan = document.getElementById('editKeterangan').value;

        fetch(`${baseUrl}/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                status: status,
                keterangan: keterangan
            })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                bootstrap.Modal.getInstance(document.getElementById('editModal')).hide();
                showToast('Status manuskrip berhasil diperbarui');
                loadData(currentSearch, currentSortBy, currentSortOrder, currentPage, currentStatus, false);
            }
        });
    });

    // Download Report Handler
    document.getElementById('btnDownload').addEventListener('click', function() {
        const year = document.getElementById('downloadYear').value;

        if (!year) {
            alert('Silakan pilih tahun terlebih dahulu!');
            return;
        }

        // Create download link
        const downloadUrl = `${baseUrl}/export-excel?year=${year}`;
        window.location.href = downloadUrl;

        // Close modal
        bootstrap.Modal.getInstance(document.getElementById('downloadModal')).hide();

        // Reset form
        document.getElementById('downloadForm').reset();

        showToast('Download laporan dimulai...');
    });

    // ==================== JENIS KARYA MANAGEMENT ====================
    @if(auth()->user()->role !== 'admin')
    const addJenisKaryaModal = new bootstrap.Modal(document.getElementById('addJenisKaryaModal'));
    const editJenisKaryaModal = new bootstrap.Modal(document.getElementById('editJenisKaryaModal'));
    const detailJenisKaryaModal = new bootstrap.Modal(document.getElementById('detailJenisKaryaModal'));

    // Add Jenis Karya Button
    const btnAddJenisKarya = document.getElementById('btnAddJenisKarya');
    if (btnAddJenisKarya) {
        btnAddJenisKarya.addEventListener('click', function() {
            document.getElementById('addJenisKaryaForm').reset();
            addJenisKaryaModal.show();
        });
    }

    // Add Jenis Karya Form Submit
    document.getElementById('addJenisKaryaForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const nama = document.getElementById('addJenisKaryaNama').value;

        fetch('/superadmin/kelola-jenis-karya', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ nama: nama })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                addJenisKaryaModal.hide();
                location.reload();
            }
        })
        .catch(error => console.error('Error:', error));
    });

    // Detail Jenis Karya Button
    document.querySelectorAll('.btn-detail-jenis-karya').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');

            fetch(`/superadmin/kelola-jenis-karya/${id}`)
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        const jenisKarya = data.data;
                        document.getElementById('detailJenisKaryaNama').textContent = jenisKarya.nama;
                        document.getElementById('detailJenisKaryaCount').textContent = jenisKarya.karyas_count + ' manuskrip';
                        document.getElementById('detailJenisKaryaCreated').textContent = new Date(jenisKarya.created_at).toLocaleDateString('id-ID', {
                            day: 'numeric',
                            month: 'long',
                            year: 'numeric'
                        });
                        document.getElementById('detailJenisKaryaUpdated').textContent = new Date(jenisKarya.updated_at).toLocaleDateString('id-ID', {
                            day: 'numeric',
                            month: 'long',
                            year: 'numeric'
                        });
                        detailJenisKaryaModal.show();
                    }
                });
        });
    });

    // Edit Jenis Karya Button
    document.querySelectorAll('.btn-edit-jenis-karya').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');

            fetch(`/superadmin/kelola-jenis-karya/${id}`)
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        const jenisKarya = data.data;
                        document.getElementById('editJenisKaryaId').value = jenisKarya.id;
                        document.getElementById('editJenisKaryaNama').value = jenisKarya.nama;
                        editJenisKaryaModal.show();
                    }
                });
        });
    });

    // Edit Jenis Karya Form Submit
    document.getElementById('editJenisKaryaForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const id = document.getElementById('editJenisKaryaId').value;
        const nama = document.getElementById('editJenisKaryaNama').value;

        fetch(`/superadmin/kelola-jenis-karya/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ nama: nama })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                editJenisKaryaModal.hide();
                location.reload();
            }
        })
        .catch(error => console.error('Error:', error));
    });

    // Delete Jenis Karya Button
    document.querySelectorAll('.btn-delete-jenis-karya').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');

            if(confirm(`Apakah Anda yakin ingin menghapus jenis manuskrip "${name}"?`)) {
                fetch(`/superadmin/kelola-jenis-karya/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        location.reload();
                    } else {
                        alert(data.message || 'Gagal menghapus jenis manuskrip');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menghapus jenis manuskrip');
                });
            }
        });
    });
    @endif
});
</script>
@endsection
