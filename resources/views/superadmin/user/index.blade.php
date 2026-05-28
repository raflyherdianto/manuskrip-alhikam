@extends('layouts.superadmin')

@section('page-title', 'Manajemen User')

@section('content')
<div class="dashboard-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-content">
            <h2>
                <i class="bi bi-people-fill"></i>
                Manajemen User
            </h2>
            <p>Kelola daftar user yang terdaftar di sistem</p>
        </div>
    </div>

    <!-- Statistics Cards -->
    @if(auth()->user()->role !== 'admin')
    <div class="stats-grid">
        <div class="stat-card stat-primary">
            <div class="stat-icon">
                <i class="bi bi-people-fill"></i>
            </div>
            <div class="stat-content">
                <h3>{{ number_format($totalUsers) }}</h3>
                <p>Total User</p>
            </div>
        </div>

        <div class="stat-card stat-info">
            <div class="stat-icon">
                <i class="bi bi-mortarboard-fill"></i>
            </div>
            <div class="stat-content">
                <h3>{{ number_format($userMahasiswa) }}</h3>
                <p>Mahasiswa</p>
            </div>
        </div>

        <div class="stat-card stat-success">
            <div class="stat-icon">
                <i class="bi bi-person-workspace"></i>
            </div>
            <div class="stat-content">
                <h3>{{ number_format($userDosen) }}</h3>
                <p>Dosen</p>
            </div>
        </div>

        <div class="stat-card stat-warning">
            <div class="stat-icon">
                <i class="bi bi-shield-fill-check"></i>
            </div>
            <div class="stat-content">
                <h3>{{ number_format($userSuperadmin) }}</h3>
                <p>Superadmin</p>
            </div>
        </div>
    </div>
    @else
    <div class="stats-grid">
        <div class="stat-card stat-info" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#mahasiswaAngkatanModal">
            <div class="stat-icon">
                <i class="bi bi-mortarboard-fill"></i>
            </div>
            <div class="stat-content">
                <h3>{{ number_format($userMahasiswa) }}</h3>
                <p>Mahasiswa</p>
            </div>
        </div>

        <div class="stat-card stat-primary">
            <div class="stat-icon">
                <i class="bi bi-gender-male"></i>
            </div>
            <div class="stat-content">
                <h3>{{ number_format($userLakiLaki) }}</h3>
                <p>Laki-laki</p>
            </div>
        </div>

        <div class="stat-card stat-danger">
            <div class="stat-icon">
                <i class="bi bi-gender-female"></i>
            </div>
            <div class="stat-content">
                <h3>{{ number_format($userPerempuan) }}</h3>
                <p>Perempuan</p>
            </div>
        </div>

        <div class="stat-card stat-warning">
            <div class="stat-icon">
                <i class="bi bi-exclamation-triangle-fill"></i>
            </div>
            <div class="stat-content">
                <h3>{{ number_format($userBelumVerified) }}</h3>
                <p>Belum Terverifikasi</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Data Table Card Dosen -->
    @if(auth()->user()->role !== 'admin')
    <div class="content-card">
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h5>
                <i class="bi bi-table"></i>
                Daftar Dosen
            </h5>
            <div>
                <button type="button" class="btn btn-success btn-sm me-2" data-bs-toggle="modal" data-bs-target="#uploadCsvDosenModal">
                    <i class="bi bi-file-earmark-arrow-up" style="color: white;"></i> Upload CSV
                </button>
                <button type="button" class="btn btn-primary btn-sm" id="btnAddDosen">
                    <i class="bi bi-plus-circle" style="color: white;"></i> Tambah Dosen
                </button>
            </div>
        </div>
        <div class="card-body">
            <!-- Search Bar -->
            <div class="search-container mb-4">
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" id="searchInputDosen" class="form-control" placeholder="Cari dosen..." value="{{ request('search_dosen') }}">
                </div>
            </div>

            <div id="tableContainerDosen">
                <div class="table-responsive">
                    <table class="table table-hover" id="usersTableDosen">
                        <thead>
                            <tr>
                                <th style="width: 5%;">No</th>
                                <th style="width: 20%;">
                                    <span class="sortable-header-dosen" data-sort="name">
                                        Nama
                                        <i class="bi bi-arrow-down-up" id="sort-icon-dosen-name"></i>
                                    </span>
                                </th>
                                <th style="width: 20%;">
                                    <span class="sortable-header-dosen" data-sort="email">
                                        Email
                                        <i class="bi bi-arrow-down-up" id="sort-icon-dosen-email"></i>
                                    </span>
                                </th>
                                <th style="width: 15%;">
                                    <span class="sortable-header-dosen" data-sort="jurusan_id">
                                        Jurusan
                                        <i class="bi bi-arrow-down-up" id="sort-icon-dosen-jurusan_id"></i>
                                    </span>
                                </th>
                                <th style="width: 10%;">
                                    <span class="sortable-header-dosen" data-sort="verified">
                                        Verifikasi
                                        <i class="bi bi-arrow-down-up" id="sort-icon-dosen-verified"></i>
                                    </span>
                                </th>
                                <th style="width: 30%;" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tableBodyDosen">
                            @forelse($usersDosen as $index => $user)
                            <tr>
                                <td>{{ ($usersDosen->currentPage() - 1) * $usersDosen->perPage() + $index + 1 }}</td>
                                <td>
                                    <strong>{{ $user->name }}</strong>
                                </td>
                                <td>
                                    <small>{{ $user->email }}</small>
                                </td>
                                <td>
                                    <small>{{ $user->jurusan->nama ?? '-' }}</small>
                                </td>
                                <td>
                                    @if($user->verified)
                                        <span class="badge bg-success">Sudah</span>
                                    @else
                                        <span class="badge bg-warning">Belum</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button type="button" class="btn btn-info btn-detail" data-id="{{ $user->id }}">
                                            <i class="bi bi-eye"></i> Detail
                                        </button>
                                        <button type="button" class="btn btn-warning btn-edit" data-id="{{ $user->id }}">
                                            <i class="bi bi-pencil"></i> Edit
                                        </button>
                                        <button type="button" class="btn btn-danger btn-delete" data-id="{{ $user->id }}" data-name="{{ $user->name }}">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <i class="bi bi-inbox" style="font-size: 3rem; color: var(--gray-400);"></i>
                                    <p class="mt-2 text-muted">
                                        @if(request('search_dosen'))
                                            Tidak ada hasil untuk "{{ request('search_dosen') }}"
                                        @else
                                            Belum ada data dosen
                                        @endif
                                    </p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($usersDosen->hasPages())
                <div class="pagination-container mt-4" id="paginationContainerDosen">
                    <div class="pagination-info">
                        Menampilkan {{ $usersDosen->firstItem() }} - {{ $usersDosen->lastItem() }} dari {{ $usersDosen->total() }} data
                    </div>
                    <div class="pagination-links">
                        {{ $usersDosen->links('vendor.pagination.custom') }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    @endif

    <!-- Data Table Card Mahasiswa -->
    <div class="content-card" style="margin-top: var(--space-8);">
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h5>
                <i class="bi bi-table"></i>
                Daftar Mahasiswa
            </h5>
            <div>
                <button type="button" class="btn btn-success btn-sm me-2" data-bs-toggle="modal" data-bs-target="#uploadCsvMahasiswaModal">
                    <i class="bi bi-file-earmark-arrow-up" style="color: white;"></i> Upload CSV
                </button>
                <button type="button" class="btn btn-primary btn-sm" id="btnAddMahasiswa">
                    <i class="bi bi-plus-circle" style="color: white;"></i> Tambah Mahasiswa
                </button>
            </div>
        </div>
        <div class="card-body">
            <!-- Search Bar -->
            <div class="search-container mb-4">
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" id="searchInputMahasiswa" class="form-control" placeholder="Cari mahasiswa..." value="{{ request('search_mahasiswa') }}">
                </div>
            </div>

            <div id="tableContainerMahasiswa">
                <div class="table-responsive">
                    <table class="table table-hover" id="usersTableMahasiswa">
                        <thead>
                            <tr>
                                <th style="width: 5%;">No</th>
                                <th style="width: 20%;">
                                    <span class="sortable-header-mahasiswa" data-sort="name">
                                        Nama
                                        <i class="bi bi-arrow-down-up" id="sort-icon-mahasiswa-name"></i>
                                    </span>
                                </th>
                                <th style="width: 20%;">
                                    <span class="sortable-header-mahasiswa" data-sort="email">
                                        Email
                                        <i class="bi bi-arrow-down-up" id="sort-icon-mahasiswa-email"></i>
                                    </span>
                                </th>
                                <th style="width: 15%;">
                                    <span class="sortable-header-mahasiswa" data-sort="jurusan_id">
                                        Jurusan
                                        <i class="bi bi-arrow-down-up" id="sort-icon-mahasiswa-jurusan_id"></i>
                                    </span>
                                </th>
                                <th style="width: 10%;">
                                    <span class="sortable-header-mahasiswa" data-sort="verified">
                                        Verifikasi
                                        <i class="bi bi-arrow-down-up" id="sort-icon-mahasiswa-verified"></i>
                                    </span>
                                </th>
                                <th style="width: 30%;" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tableBodyMahasiswa">
                            @forelse($usersMahasiswa as $index => $user)
                            <tr>
                                <td>{{ ($usersMahasiswa->currentPage() - 1) * $usersMahasiswa->perPage() + $index + 1 }}</td>
                                <td>
                                    <strong>{{ $user->name }}</strong>
                                </td>
                                <td>
                                    <small>{{ $user->email }}</small>
                                </td>
                                <td>
                                    <small>{{ $user->jurusan->nama ?? '-' }}</small>
                                </td>
                                <td>
                                    @if($user->verified)
                                        <span class="badge bg-success">Sudah</span>
                                    @else
                                        <span class="badge bg-warning">Belum</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button type="button" class="btn btn-info btn-detail" data-id="{{ $user->id }}">
                                            <i class="bi bi-eye"></i> Detail
                                        </button>
                                        <button type="button" class="btn btn-warning btn-edit" data-id="{{ $user->id }}">
                                            <i class="bi bi-pencil"></i> Edit
                                        </button>
                                        <button type="button" class="btn btn-danger btn-delete" data-id="{{ $user->id }}" data-name="{{ $user->name }}">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <i class="bi bi-inbox" style="font-size: 3rem; color: var(--gray-400);"></i>
                                    <p class="mt-2 text-muted">
                                        @if(request('search_mahasiswa'))
                                            Tidak ada hasil untuk "{{ request('search_mahasiswa') }}"
                                        @else
                                            Belum ada data mahasiswa
                                        @endif
                                    </p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($usersMahasiswa->hasPages())
                <div class="pagination-container mt-4" id="paginationContainerMahasiswa">
                    <div class="pagination-info">
                        Menampilkan {{ $usersMahasiswa->firstItem() }} - {{ $usersMahasiswa->lastItem() }} dari {{ $usersMahasiswa->total() }} data
                    </div>
                    <div class="pagination-links">
                        {{ $usersMahasiswa->links('vendor.pagination.custom') }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal Mahasiswa per Angkatan -->
@if(auth()->user()->role === 'admin')
<div class="modal fade" id="mahasiswaAngkatanModal" tabindex="-1" aria-labelledby="mahasiswaAngkatanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mahasiswaAngkatanModalLabel">
                    <i class="bi bi-pie-chart-fill"></i>
                    Detail Mahasiswa per Angkatan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="list-group">
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <i class="bi bi-people-fill text-primary me-2"></i>
                            <strong>Angkatan 2021</strong>
                        </div>
                        <span class="badge bg-primary rounded-pill">{{ number_format($userAngkatan2021) }} mahasiswa</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <i class="bi bi-people-fill text-success me-2"></i>
                            <strong>Angkatan 2022</strong>
                        </div>
                        <span class="badge bg-success rounded-pill">{{ number_format($userAngkatan2022) }} mahasiswa</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <i class="bi bi-people-fill text-info me-2"></i>
                            <strong>Angkatan 2023</strong>
                        </div>
                        <span class="badge bg-info rounded-pill">{{ number_format($userAngkatan2023) }} mahasiswa</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <i class="bi bi-people-fill text-warning me-2"></i>
                            <strong>Angkatan 2024</strong>
                        </div>
                        <span class="badge bg-warning rounded-pill">{{ number_format($userAngkatan2024) }} mahasiswa</span>
                    </div>
                </div>
                <div class="mt-3 p-3 bg-light rounded">
                    <div class="d-flex justify-content-between align-items-center">
                        <strong><i class="bi bi-calculator me-2"></i>Total Keseluruhan</strong>
                        <span class="badge bg-dark rounded-pill">{{ number_format($userMahasiswa) }} mahasiswa</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Detail Modal -->
@include('superadmin.user.detail-modal')

<!-- Edit Modal -->
@include('superadmin.user.edit-modal')

<!-- Add Dosen Modal -->
@include('superadmin.user.add-modal-dosen')

<!-- Add Mahasiswa Modal -->
@include('superadmin.user.add-modal-mahasiswa')

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
    cursor: pointer;
}

.sortable-header:hover {
    color: var(--primary);
}

.sortable-header i {
    font-size: 0.875rem;
}

.sortable-header-dosen {
    color: var(--gray-700);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: var(--space-2);
    transition: var(--transition);
    cursor: pointer;
}

.sortable-header-dosen:hover {
    color: var(--primary);
}

.sortable-header-dosen i {
    font-size: 0.875rem;
}

.sortable-header-mahasiswa {
    color: var(--gray-700);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: var(--space-2);
    transition: var(--transition);
    cursor: pointer;
}

.sortable-header-mahasiswa:hover {
    color: var(--primary);
}

.sortable-header-mahasiswa i {
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

.detail-group {
    margin-bottom: var(--space-4);
}

.detail-group label {
    display: block;
    font-weight: 600;
    color: var(--gray-700);
    margin-bottom: var(--space-2);
    font-size: 0.875rem;
}

.detail-group p {
    margin: 0;
    color: var(--gray-600);
    font-size: 0.9375rem;
}

.pagination-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem 0;
    border-top: 1px solid var(--gray-200);
}

.pagination-info {
    color: var(--gray-600);
    font-size: 0.875rem;
}

.pagination-links {
    display: flex;
    gap: 0.5rem;
}

.pagination-links nav {
    display: flex;
}

.pagination-links .pagination {
    display: flex;
    gap: 0.5rem;
    margin: 0;
    padding: 0;
    list-style: none;
}

.pagination-links .page-item {
    display: flex;
}

.pagination-links .page-link {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0.5rem;
    min-width: 38px;
    height: 38px;
    border: 1px solid var(--gray-300);
    border-radius: var(--radius-md);
    color: var(--gray-700);
    text-decoration: none;
    transition: var(--transition);
    font-size: 0.875rem;
}

.pagination-links .page-link:hover {
    background: var(--gray-100);
    border-color: var(--gray-400);
}

.pagination-links .page-item.active .page-link {
    background: var(--primary);
    border-color: var(--primary);
    color: var(--white);
}

.pagination-links .page-item.disabled .page-link {
    opacity: 0.5;
    cursor: not-allowed;
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

#btnAddDosen,
#btnAddMahasiswa {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    white-space: nowrap;
}

#btnAddDosen i,
#btnAddMahasiswa i {
    color: var(--white);
    font-size: 1rem;
}

@media (max-width: 768px) {
    #btnAddDosen,
    #btnAddMahasiswa {
        padding: 0.5rem 0.75rem;
        font-size: 0.813rem;
        gap: 0.375rem;
    }

    #btnAddDosen i,
    #btnAddMahasiswa i {
        font-size: 0.875rem;
    }
}

@media (max-width: 480px) {
    #btnAddDosen,
    #btnAddMahasiswa {
        padding: 0.4rem 0.65rem;
        font-size: 0.75rem;
        gap: 0.3rem;
    }

    #btnAddDosen i,
    #btnAddMahasiswa i {
        font-size: 0.813rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Dynamic route based on user role
    const userRole = '{{ auth()->user()->role }}';
    const baseRoute = userRole === 'superadmin' ? 'superadmin.kelola-user' : 'admin.kelola-user';
    const baseUrl = userRole === 'superadmin' ? '/superadmin/kelola-user' : '/admin/kelola-user';
    const prodiUrl = userRole === 'superadmin' ? '/superadmin/kelola-prodi/by-jurusan' : '/admin/kelola-prodi/by-jurusan';

    // ============================================
    // SUB JURUSAN DYNAMIC LOADING
    // ============================================
    function loadProdiOptions(jurusanId, selectElement, selectedProdiId = null) {
        selectElement.innerHTML = '<option value="">Pilih Program Studi</option>';
        selectElement.disabled = true;

        if (!jurusanId) {
            return;
        }

        fetch(`${prodiUrl}/${jurusanId}`)
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    data.forEach(subJurusan => {
                        const option = document.createElement('option');
                        option.value = subJurusan.id;
                        option.textContent = subJurusan.nama;
                        if (selectedProdiId && subJurusan.id == selectedProdiId) {
                            option.selected = true;
                        }
                        selectElement.appendChild(option);
                    });
                    selectElement.disabled = false;
                } else {
                    selectElement.innerHTML = '<option value="">Tidak ada Program Studi</option>';
                }
            })
            .catch(error => {
                console.error('Error loading sub jurusan:', error);
                selectElement.innerHTML = '<option value="">Gagal memuat Program Studi</option>';
            });
    }

    // Event listener for Mahasiswa Jurusan change
    const addMahasiswaJurusanSelect = document.getElementById('addMahasiswaJurusan');
    if (addMahasiswaJurusanSelect) {
        addMahasiswaJurusanSelect.addEventListener('change', function() {
            loadProdiOptions(this.value, document.getElementById('addMahasiswaProdi'));
        });
    }

    // Event listener for Edit Jurusan change
    const editJurusanSelect = document.getElementById('editJurusan');
    if (editJurusanSelect) {
        editJurusanSelect.addEventListener('change', function() {
            loadProdiOptions(this.value, document.getElementById('editProdi'));
        });
    }

    // Load sub jurusan when modal opens for admin (default jurusan is set)
    @if(auth()->user()->role === 'admin')
    const adminJurusanId = '{{ auth()->user()->jurusan_id }}';
    document.getElementById('addMahasiswaModal').addEventListener('shown.bs.modal', function() {
        loadProdiOptions(adminJurusanId, document.getElementById('addMahasiswaProdi'));
    });
    @endif

    // ============================================
    // TABEL DOSEN
    // ============================================
    let searchTimeoutDosen;
    let currentSortByDosen = 'created_at';
    let currentSortOrderDosen = 'desc';
    let currentSearchDosen = '{{ request('search_dosen', '') }}';
    let currentPageDosen = {{ $usersDosen->currentPage() }};

    // Function to load Dosen data
    function loadDataDosen(search = '', page = 1, updateUrl = false) {
        const url = new URL('{{ route(auth()->user()->role === 'superadmin' ? 'superadmin.kelola-user' : 'admin.kelola-user') }}');
        if (search) url.searchParams.set('search_dosen', search);
        url.searchParams.set('page_dosen', page);

        // Keep mahasiswa search params
        const mahasiswaSearchInput = document.getElementById('searchInputMahasiswa');
        const currentSearchMahasiswa = mahasiswaSearchInput ? mahasiswaSearchInput.value.trim() : '';
        if (currentSearchMahasiswa) url.searchParams.set('search_mahasiswa', currentSearchMahasiswa);
        url.searchParams.set('page_mahasiswa', currentPageMahasiswa);

        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newTableContainer = doc.getElementById('tableContainerDosen');
            if (newTableContainer) {
                document.getElementById('tableContainerDosen').innerHTML = newTableContainer.innerHTML;
            }

            currentSearchDosen = search;
            currentPageDosen = page;

            // Update sort icons
            updateSortIconsDosen(currentSortByDosen, currentSortOrderDosen);

            if (updateUrl) {
                const finalUrl = new URL('{{ route(auth()->user()->role === 'superadmin' ? 'superadmin.kelola-user' : 'admin.kelola-user') }}');
                if (search) finalUrl.searchParams.set('search_dosen', search);
                if (currentSearchMahasiswa) finalUrl.searchParams.set('search_mahasiswa', currentSearchMahasiswa);
                window.history.pushState({}, '', finalUrl);
            }

            attachSortListenersDosen();
            attachPaginationListenersDosen();
            attachEventListeners();
        });
    }

    // Update sort icons for Dosen
    function updateSortIconsDosen(sortBy, sortOrder) {
        document.querySelectorAll('.sortable-header-dosen i').forEach(icon => {
            icon.className = 'bi bi-arrow-down-up';
        });

        const activeIcon = document.querySelector(`#sort-icon-dosen-${sortBy}`);
        if (activeIcon) {
            activeIcon.className = sortOrder === 'asc' ? 'bi bi-arrow-up' : 'bi bi-arrow-down';
        }
    }

    // Search Input with Debounce for Dosen
    const searchInputDosen = document.getElementById('searchInputDosen');
    if (searchInputDosen) {
        searchInputDosen.addEventListener('input', function(e) {
            clearTimeout(searchTimeoutDosen);
            const searchValue = e.target.value.trim();
            searchTimeoutDosen = setTimeout(() => {
                loadDataDosen(searchValue, 1, true);
            }, 500);
        });
    }

    // Sort Headers for Dosen
    function attachSortListenersDosen() {
        document.querySelectorAll('.sortable-header-dosen').forEach(header => {
            header.addEventListener('click', function(e) {
                e.preventDefault();
                const sortBy = this.getAttribute('data-sort');
                let sortOrder = 'asc';

                if (currentSortByDosen === sortBy) {
                    sortOrder = currentSortOrderDosen === 'asc' ? 'desc' : 'asc';
                }

                currentSortByDosen = sortBy;
                currentSortOrderDosen = sortOrder;

                sortTableDosen(sortBy, sortOrder);
            });
        });
    }

    // Client-side table sorting for Dosen
    function sortTableDosen(sortBy, sortOrder) {
        const tbody = document.getElementById('tableBodyDosen');
        if (!tbody) return;

        const rows = Array.from(tbody.querySelectorAll('tr')).filter(row => row.cells.length > 1);

        rows.sort((a, b) => {
            let aVal, bVal;

            switch(sortBy) {
                case 'name':
                    aVal = a.cells[1].textContent.trim().toLowerCase();
                    bVal = b.cells[1].textContent.trim().toLowerCase();
                    break;
                case 'email':
                    aVal = a.cells[2].textContent.trim().toLowerCase();
                    bVal = b.cells[2].textContent.trim().toLowerCase();
                    break;
                case 'jurusan_id':
                    aVal = a.cells[3].textContent.trim().toLowerCase();
                    bVal = b.cells[3].textContent.trim().toLowerCase();
                    break;
                case 'verified':
                    aVal = a.cells[4].textContent.trim().toLowerCase();
                    bVal = b.cells[4].textContent.trim().toLowerCase();
                    break;
                default:
                    return 0;
            }

            if (aVal < bVal) return sortOrder === 'asc' ? -1 : 1;
            if (aVal > bVal) return sortOrder === 'asc' ? 1 : -1;
            return 0;
        });

        tbody.innerHTML = '';
        rows.forEach(row => tbody.appendChild(row));

        updateSortIconsDosen(sortBy, sortOrder);
        attachEventListeners();
    }

    // Pagination Links for Dosen
    function attachPaginationListenersDosen() {
        const paginationContainer = document.getElementById('paginationContainerDosen');
        if (!paginationContainer) return;

        paginationContainer.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const url = new URL(this.href);
                const page = url.searchParams.get('page_dosen') || 1;
                loadDataDosen(currentSearchDosen, page, false);
            });
        });
    }

    // ============================================
    // TABEL MAHASISWA
    // ============================================
    let searchTimeoutMahasiswa;
    let currentSortByMahasiswa = 'created_at';
    let currentSortOrderMahasiswa = 'desc';
    let currentSearchMahasiswa = '{{ request('search_mahasiswa', '') }}';
    let currentPageMahasiswa = {{ $usersMahasiswa->currentPage() }};

    // Function to load Mahasiswa data
    function loadDataMahasiswa(search = '', page = 1, updateUrl = false) {
        const url = new URL('{{ route(auth()->user()->role === 'superadmin' ? 'superadmin.kelola-user' : 'admin.kelola-user') }}');
        if (search) url.searchParams.set('search_mahasiswa', search);
        url.searchParams.set('page_mahasiswa', page);

        // Keep dosen search params
        const dosenSearchInput = document.getElementById('searchInputDosen');
        const currentSearchDosen = dosenSearchInput ? dosenSearchInput.value.trim() : '';
        if (currentSearchDosen) url.searchParams.set('search_dosen', currentSearchDosen);
        url.searchParams.set('page_dosen', currentPageDosen);

        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newTableContainer = doc.getElementById('tableContainerMahasiswa');
            document.getElementById('tableContainerMahasiswa').innerHTML = newTableContainer.innerHTML;

            currentSearchMahasiswa = search;
            currentPageMahasiswa = page;

            updateSortIconsMahasiswa(currentSortByMahasiswa, currentSortOrderMahasiswa);

            if (updateUrl) {
                const finalUrl = new URL('{{ route(auth()->user()->role === 'superadmin' ? 'superadmin.kelola-user' : 'admin.kelola-user') }}');
                if (search) finalUrl.searchParams.set('search_mahasiswa', search);
                if (currentSearchDosen) finalUrl.searchParams.set('search_dosen', currentSearchDosen);
                window.history.pushState({}, '', finalUrl);
            }

            attachSortListenersMahasiswa();
            attachPaginationListenersMahasiswa();
            attachEventListeners();
        });
    }

    // Update sort icons for Mahasiswa
    function updateSortIconsMahasiswa(sortBy, sortOrder) {
        document.querySelectorAll('.sortable-header-mahasiswa i').forEach(icon => {
            icon.className = 'bi bi-arrow-down-up';
        });

        const activeIcon = document.querySelector(`#sort-icon-mahasiswa-${sortBy}`);
        if (activeIcon) {
            activeIcon.className = sortOrder === 'asc' ? 'bi bi-arrow-up' : 'bi bi-arrow-down';
        }
    }

    // Search Input with Debounce for Mahasiswa
    const searchInputMahasiswa = document.getElementById('searchInputMahasiswa');
    if (searchInputMahasiswa) {
        searchInputMahasiswa.addEventListener('input', function(e) {
            clearTimeout(searchTimeoutMahasiswa);
            const searchValue = e.target.value.trim();
            searchTimeoutMahasiswa = setTimeout(() => {
                loadDataMahasiswa(searchValue, 1, true);
            }, 500);
        });
    }

    // Sort Headers for Mahasiswa
    function attachSortListenersMahasiswa() {
        document.querySelectorAll('.sortable-header-mahasiswa').forEach(header => {
            header.addEventListener('click', function(e) {
                e.preventDefault();
                const sortBy = this.getAttribute('data-sort');
                let sortOrder = 'asc';

                if (currentSortByMahasiswa === sortBy) {
                    sortOrder = currentSortOrderMahasiswa === 'asc' ? 'desc' : 'asc';
                }

                currentSortByMahasiswa = sortBy;
                currentSortOrderMahasiswa = sortOrder;

                sortTableMahasiswa(sortBy, sortOrder);
            });
        });
    }

    // Client-side table sorting for Mahasiswa
    function sortTableMahasiswa(sortBy, sortOrder) {
        const tbody = document.getElementById('tableBodyMahasiswa');
        const rows = Array.from(tbody.querySelectorAll('tr')).filter(row => row.cells.length > 1);

        rows.sort((a, b) => {
            let aVal, bVal;

            switch(sortBy) {
                case 'name':
                    aVal = a.cells[1].textContent.trim().toLowerCase();
                    bVal = b.cells[1].textContent.trim().toLowerCase();
                    break;
                case 'email':
                    aVal = a.cells[2].textContent.trim().toLowerCase();
                    bVal = b.cells[2].textContent.trim().toLowerCase();
                    break;
                case 'jurusan_id':
                    aVal = a.cells[3].textContent.trim().toLowerCase();
                    bVal = b.cells[3].textContent.trim().toLowerCase();
                    break;
                case 'verified':
                    aVal = a.cells[4].textContent.trim().toLowerCase();
                    bVal = b.cells[4].textContent.trim().toLowerCase();
                    break;
                default:
                    return 0;
            }

            if (aVal < bVal) return sortOrder === 'asc' ? -1 : 1;
            if (aVal > bVal) return sortOrder === 'asc' ? 1 : -1;
            return 0;
        });

        tbody.innerHTML = '';
        rows.forEach(row => tbody.appendChild(row));

        updateSortIconsMahasiswa(sortBy, sortOrder);
        attachEventListeners();
    }

    // Pagination Links for Mahasiswa
    function attachPaginationListenersMahasiswa() {
        const paginationContainer = document.getElementById('paginationContainerMahasiswa');
        if (!paginationContainer) return;

        paginationContainer.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const url = new URL(this.href);
                const page = url.searchParams.get('page_mahasiswa') || 1;
                loadDataMahasiswa(currentSearchMahasiswa, page, false);
            });
        });
    }

    // ============================================
    // SHARED EVENT LISTENERS
    // ============================================
    function attachEventListeners() {
        // Detail Button
        document.querySelectorAll('.btn-detail').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');

                fetch(`${baseUrl}/${id}`)
                    .then(response => response.json())
                    .then(user => {
                        document.getElementById('detailName').textContent = user.name;
                        document.getElementById('detailEmail').textContent = user.email;
                        document.getElementById('detailNim').textContent = user.nim || '-';
                        document.getElementById('detailNip').textContent = user.nip || '-';
                        document.getElementById('detailRole').textContent = user.role.charAt(0).toUpperCase() + user.role.slice(1);
                        document.getElementById('detailJenisKelamin').textContent = user.jenis_kelamin === 'L' ? 'Laki-laki' : user.jenis_kelamin === 'P' ? 'Perempuan' : '-';
                        document.getElementById('detailAngkatan').textContent = user.angkatan || '-';
                        document.getElementById('detailJurusan').textContent = user.jurusan ? user.jurusan.nama : '-';
                        document.getElementById('detailProdi').textContent = user.prodi ? user.prodi.nama : '-';
                        document.getElementById('detailVerified').innerHTML = user.verified
                            ? '<span class="badge bg-success">Terverifikasi</span>'
                            : '<span class="badge bg-warning">Belum Terverifikasi</span>';
                        document.getElementById('detailCreatedAt').textContent = new Date(user.created_at).toLocaleDateString('id-ID', {
                            day: 'numeric',
                            month: 'long',
                            year: 'numeric'
                        });

                        // Show/hide NIM, NIP, and Program Studi based on role
                        if (user.role === 'admin') {
                            // Dosen - show NIP and Program Studi, hide NIM
                            document.getElementById('detailNipRow').style.display = 'block';
                            document.getElementById('detailNimRow').style.display = 'none';
                            document.getElementById('detailProdiRow').style.display = 'block';
                        } else if (user.role === 'user') {
                            // Mahasiswa - show NIM and Program Studi, hide NIP
                            document.getElementById('detailNipRow').style.display = 'none';
                            document.getElementById('detailNimRow').style.display = 'block';
                            document.getElementById('detailProdiRow').style.display = 'block';
                        }

                        const detailModal = new bootstrap.Modal(document.getElementById('detailModal'));
                        detailModal.show();
                    });
            });
        });

        // Edit Button
        document.querySelectorAll('.btn-edit').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');

                fetch(`${baseUrl}/${id}`)
                    .then(response => response.json())
                    .then(user => {
                        document.getElementById('editUserId').value = user.id;
                        document.getElementById('editUserRole').value = user.role;
                        document.getElementById('editName').value = user.name;
                        document.getElementById('editEmail').value = user.email;
                        document.getElementById('editJenisKelamin').value = user.jenis_kelamin || '';
                        document.getElementById('editJurusan').value = user.jurusan_id || '';
                        document.getElementById('editVerified').value = user.verified ? '1' : '0';
                        document.getElementById('editPassword').value = '';
                        document.getElementById('editPasswordConfirmation').value = '';

                        // Load sub jurusan options based on jurusan and set selected value
                        if (user.jurusan_id) {
                            loadProdiOptions(user.jurusan_id, document.getElementById('editProdi'), user.prodi_id);
                        } else {
                            document.getElementById('editProdi').innerHTML = '<option value="">Pilih Program Studi</option>';
                        }

                        // Show/hide fields based on role
                        if (user.role === 'admin') {
                            // Dosen
                            document.getElementById('editNipRow').style.display = 'flex';
                            document.getElementById('editNimRow').style.display = 'none';
                            document.getElementById('editAngkatanRow').style.display = 'none';
                            document.getElementById('editProdiRow').style.display = 'block';
                            document.getElementById('editNip').value = user.nip || '';
                            // Always show Jurusan for Dosen (even for admin role user)
                            document.getElementById('editJurusanContainer').style.display = 'block';
                            document.getElementById('editJurusan').disabled = false;
                        } else if (user.role === 'user') {
                            // Mahasiswa
                            document.getElementById('editNipRow').style.display = 'none';
                            document.getElementById('editNimRow').style.display = 'flex';
                            document.getElementById('editAngkatanRow').style.display = 'block';
                            document.getElementById('editProdiRow').style.display = 'block';
                            document.getElementById('editNim').value = user.nim || '';
                            document.getElementById('editAngkatan').value = user.angkatan || '';

                            document.getElementById('editJurusanContainer').style.display = 'block';

                            // Disable Jurusan field for admin role user when editing mahasiswa
                            @if(auth()->user()->role === 'admin')
                            document.getElementById('editJurusan').disabled = true;
                            // Set jurusan_id to current admin's jurusan
                            document.getElementById('editJurusan').value = '{{ auth()->user()->jurusan_id }}';
                            document.getElementById('editJurusanHidden').value = '{{ auth()->user()->jurusan_id }}';
                            @else
                            document.getElementById('editJurusan').disabled = false;
                            @endif
                        }

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

                if(confirm(`Apakah Anda yakin ingin menghapus user "${name}"?`)) {
                    fetch(`${baseUrl}/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if(data.success) {
                            // Reload both tables
                            location.reload();
                        } else {
                            alert(data.message || 'Gagal menghapus user');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat menghapus user');
                    });
                }
            });
        });
    }

    // Initial setup
    @if(auth()->user()->role !== 'admin')
    attachSortListenersDosen();
    attachPaginationListenersDosen();
    @endif
    attachSortListenersMahasiswa();
    attachPaginationListenersMahasiswa();
    attachEventListeners();

    // ============================================
    // ADD DOSEN
    // ============================================
    @if(auth()->user()->role !== 'admin')
    const addDosenModal = new bootstrap.Modal(document.getElementById('addDosenModal'));
    const btnAddDosen = document.getElementById('btnAddDosen');
    if (btnAddDosen) {
        btnAddDosen.addEventListener('click', function() {
            document.getElementById('addDosenForm').reset();
            document.getElementById('addDosenProdi').innerHTML = '<option value="">Pilih Jurusan Dahulu</option>';
            document.getElementById('addDosenProdi').disabled = true;
            addDosenModal.show();
        });
    }

    // Add Dosen Jurusan change event for Program Studi
    const addDosenJurusanSelect = document.getElementById('addDosenJurusan');
    if (addDosenJurusanSelect) {
        addDosenJurusanSelect.addEventListener('change', function() {
            loadProdiOptions(this.value, document.getElementById('addDosenProdi'));
        });
    }

    // Add Dosen Form Submit
    const addDosenForm = document.getElementById('addDosenForm');
    if (addDosenForm) {
        addDosenForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const data = {
                name: document.getElementById('addDosenName').value,
                nip: document.getElementById('addDosenNip').value,
                email: document.getElementById('addDosenEmail').value,
                password: document.getElementById('addDosenPassword').value,
                role: 'admin',
                jenis_kelamin: document.getElementById('addDosenJenisKelamin').value || null,
                jurusan_id: document.getElementById('addDosenJurusan').value || null,
                prodi_id: document.getElementById('addDosenProdi').value || null,
                nim: document.getElementById('addDosenNim').value || null,
                angkatan: document.getElementById('addDosenAngkatan').value,
                verified: document.getElementById('addDosenVerified').value === '1'
            };

            fetch(baseUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    addDosenModal.hide();
                    location.reload();
                } else {
                    alert(data.message || 'Gagal menambahkan dosen');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menambahkan dosen');
            });
        });
    }
    @endif

    // ============================================
    // ADD MAHASISWA
    // ============================================
    const addMahasiswaModal = new bootstrap.Modal(document.getElementById('addMahasiswaModal'));
    document.getElementById('btnAddMahasiswa').addEventListener('click', function() {
        document.getElementById('addMahasiswaForm').reset();
        @if(auth()->user()->role === 'admin')
        // Set default jurusan for admin role
        document.getElementById('addMahasiswaJurusan').value = '{{ auth()->user()->jurusan_id }}';
        @endif
        addMahasiswaModal.show();
    });

    // Add Mahasiswa Form Submit
    document.getElementById('addMahasiswaForm').addEventListener('submit', function(e) {
        e.preventDefault();

        @if(auth()->user()->role === 'admin')
        // For admin role, use hidden input value
        const jurusanId = document.getElementById('addMahasiswaJurusanHidden').value;
        @else
        // For superadmin, use select value
        const jurusanId = document.getElementById('addMahasiswaJurusan').value || null;
        @endif

        const data = {
            name: document.getElementById('addMahasiswaName').value,
            nim: document.getElementById('addMahasiswaNim').value,
            email: document.getElementById('addMahasiswaEmail').value,
            password: document.getElementById('addMahasiswaPassword').value,
            role: 'user',
            jenis_kelamin: document.getElementById('addMahasiswaJenisKelamin').value || null,
            angkatan: document.getElementById('addMahasiswaAngkatan').value || null,
            jurusan_id: jurusanId,
            prodi_id: document.getElementById('addMahasiswaProdi').value || null,
            nip: document.getElementById('addMahasiswaNip').value || null,
            verified: document.getElementById('addMahasiswaVerified').value === '1'
        };

        fetch(baseUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                addMahasiswaModal.hide();
                location.reload();
            } else {
                alert(data.message || 'Gagal menambahkan mahasiswa');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menambahkan mahasiswa');
        });
    });

    // Edit Form Submit
    document.getElementById('editForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const id = document.getElementById('editUserId').value;
        const role = document.getElementById('editUserRole').value;
        const password = document.getElementById('editPassword').value;
        const passwordConfirmation = document.getElementById('editPasswordConfirmation').value;

        if (password && password !== passwordConfirmation) {
            alert('Password dan konfirmasi password tidak cocok');
            return;
        }

        @if(auth()->user()->role === 'admin')
        // For admin role editing mahasiswa, use hidden input value
        const jurusanId = role === 'user' && document.getElementById('editJurusanHidden').value
            ? document.getElementById('editJurusanHidden').value
            : document.getElementById('editJurusan').value;
        @else
        // For superadmin, use select value
        const jurusanId = document.getElementById('editJurusan').value;
        @endif

        const data = {
            name: document.getElementById('editName').value,
            email: document.getElementById('editEmail').value,
            role: role,
            jenis_kelamin: document.getElementById('editJenisKelamin').value,
            jurusan_id: jurusanId,
            prodi_id: document.getElementById('editProdi').value || null,
            verified: document.getElementById('editVerified').value
        };

        // Add role-specific fields
        if (role === 'admin') {
            // Dosen
            data.nip = document.getElementById('editNip').value;
            data.angkatan = 'Dosen';
        } else if (role === 'user') {
            // Mahasiswa
            data.nim = document.getElementById('editNim').value;
            data.angkatan = document.getElementById('editAngkatan').value;
        }

        if (password) {
            data.password = password;
            data.password_confirmation = passwordConfirmation;
        }

        fetch(`${baseUrl}/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                bootstrap.Modal.getInstance(document.getElementById('editModal')).hide();
                // Reload both tables
                location.reload();
            } else {
                alert(data.message || 'Gagal memperbarui user');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat memperbarui user');
        });
    });
});
</script>

<!-- Upload CSV Dosen Modal -->
<div class="modal fade" id="uploadCsvDosenModal" tabindex="-1" aria-labelledby="uploadCsvDosenModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadCsvDosenModalLabel">
                    <i class="bi bi-file-earmark-arrow-up"></i>
                    Upload CSV Dosen
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="uploadCsvDosenForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>Format CSV:</strong> File harus berformat CSV dengan header berikut:
                        <code>name,nip,email,password,jenis_kelamin,jurusan_id</code>
                    </div>

                    <div class="mb-3">
                        <label for="csvDosenFile" class="form-label">Pilih File CSV <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" id="csvDosenFile" name="csv_file" accept=".csv" required>
                        <div class="form-text">File CSV maksimal 5MB</div>
                    </div>

                    <div class="card">
                        <div class="card-header bg-light">
                            <strong><i class="bi bi-file-earmark-text me-2"></i>Contoh Format CSV Dosen:</strong>
                        </div>
                        <div class="card-body">
                            <pre class="mb-0" style="font-size: 11px; overflow-x: auto;">name,nip,email,password,jenis_kelamin,jurusan_id
"Dr. H. M. Lukman, M.Ag.",'19850101001,dosen1@gmail.com,password123,L,1
"Dr. Hj. Rahmawati, M.E.",'19880202002,dosen2@gmail.com,password123,P,2</pre>
                        </div>
                        <div class="card-footer bg-light">
                            <button type="button" class="btn btn-sm btn-primary" id="downloadFormatDosen">
                                <i class="bi bi-download"></i> Download Format
                            </button>
                        </div>
                    </div>

                    <div class="alert alert-warning mt-3">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <strong>Catatan:</strong>
                        <ul class="mb-0 mt-2">
                            <li>Field <code>nip</code> wajib diisi untuk dosen (gunakan prefix ' untuk mempertahankan format angka)</li>
                            <li>Field <code>email</code> dan <code>password</code> wajib diisi</li>
                            <li><code>jurusan_id</code>: ID jurusan (angka) wajib diisi</li>
                            <li><code>jenis_kelamin</code>: L = Laki-laki, P = Perempuan wajib diisi</li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-upload"></i> Upload
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Upload CSV Mahasiswa Modal -->
<div class="modal fade" id="uploadCsvMahasiswaModal" tabindex="-1" aria-labelledby="uploadCsvMahasiswaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadCsvMahasiswaModalLabel">
                    <i class="bi bi-file-earmark-arrow-up"></i>
                    Upload CSV Mahasiswa
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="uploadCsvMahasiswaForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>Format CSV:</strong> File harus berformat CSV dengan header berikut:
                        <code>name,nim,email,password,jenis_kelamin,angkatan,jurusan_id,prodi_id</code>
                    </div>

                    <div class="mb-3">
                        <label for="csvMahasiswaFile" class="form-label">Pilih File CSV <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" id="csvMahasiswaFile" name="csv_file" accept=".csv" required>
                        <div class="form-text">File CSV maksimal 5MB</div>
                    </div>

                    <div class="card">
                        <div class="card-header bg-light">
                            <strong><i class="bi bi-file-earmark-text me-2"></i>Contoh Format CSV Mahasiswa:</strong>
                        </div>
                        <div class="card-body">
                            <pre class="mb-0" style="font-size: 11px; overflow-x: auto;">name,nim,email,password,jenis_kelamin,angkatan,jurusan_id,prodi_id
"Ahmad Fauzi",'20210001,mahasiswa1@gmail.com,password123,L,2021,2,1
"Siti Aminah",'20220002,mahasiswa2@gmail.com,password123,P,2022,1,3</pre>
                        </div>
                        <div class="card-footer bg-light">
                            <button type="button" class="btn btn-sm btn-primary" id="downloadFormatMahasiswa">
                                <i class="bi bi-download"></i> Download Format
                            </button>
                        </div>
                    </div>

                    <div class="alert alert-warning mt-3">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <strong>Catatan:</strong>
                        <ul class="mb-0 mt-2">
                            <li>Field <code>nim</code> wajib diisi untuk mahasiswa (gunakan prefix ' untuk mempertahankan format angka)</li>
                            <li>Field <code>email</code> dan <code>password</code> bisa dikosongkan</li>
                            <li><code>jurusan_id</code>: ID jurusan (angka) wajib diisi</li>
                            <li><code>prodi_id</code>: ID program studi (angka) opsional, harus sesuai dengan jurusan_id</li>
                            <li><code>angkatan</code>: Angkatan (tahun, misal: 2021, 2022) wajib diisi</li>
                            <li><code>jenis_kelamin</code>: L = Laki-laki, P = Perempuan wajib diisi</li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-upload"></i> Upload
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Upload CSV Dosen Handler
document.getElementById('uploadCsvDosenForm')?.addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalBtnText = submitBtn.innerHTML;
    const userRole = '{{ auth()->user()->role }}';
    const uploadRoute = userRole === 'superadmin' ? '{{ route('superadmin.kelola-user.upload-csv-dosen') }}' : '{{ route('admin.kelola-user.upload-csv-dosen') }}';

    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Uploading...';

    fetch(uploadRoute, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalBtnText;

        if (data.success) {
            let message = data.message;
            if (data.errors && data.errors.length > 0) {
                message += '\n\nDetail error:\n' + data.errors.join('\n');
            }
            alert(message);
            bootstrap.Modal.getInstance(document.getElementById('uploadCsvDosenModal')).hide();
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalBtnText;
        console.error('Error:', error);
        alert('Terjadi kesalahan saat mengupload file');
    });
});

// Upload CSV Mahasiswa Handler
document.getElementById('uploadCsvMahasiswaForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalBtnText = submitBtn.innerHTML;
    const userRole = '{{ auth()->user()->role }}';
    const uploadRoute = userRole === 'superadmin' ? '{{ route('superadmin.kelola-user.upload-csv-mahasiswa') }}' : '{{ route('admin.kelola-user.upload-csv-mahasiswa') }}';

    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Uploading...';

    fetch(uploadRoute, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalBtnText;

        if (data.success) {
            let message = data.message;
            if (data.errors && data.errors.length > 0) {
                message += '\n\nDetail error:\n' + data.errors.join('\n');
            }
            alert(message);
            bootstrap.Modal.getInstance(document.getElementById('uploadCsvMahasiswaModal')).hide();
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalBtnText;
        console.error('Error:', error);
        alert('Terjadi kesalahan saat mengupload file');
    });
});

// Download Format CSV Mahasiswa
document.getElementById('downloadFormatMahasiswa').addEventListener('click', function() {
    const csvContent = `name,nim,email,password,jenis_kelamin,angkatan,jurusan_id,prodi_id
"Ahmad Fauzi",'20210001,mahasiswa1@gmail.com,password123,L,2021,2,1
"Siti Aminah",'20220002,mahasiswa2@gmail.com,password123,P,2022,1,3`;

    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    const url = URL.createObjectURL(blob);

    link.setAttribute('href', url);
    link.setAttribute('download', 'format_mahasiswa.csv');
    link.style.visibility = 'hidden';

    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
});

// Download Format CSV Dosen
document.getElementById('downloadFormatDosen').addEventListener('click', function() {
    const csvContent = `name,nip,email,password,jenis_kelamin,jurusan_id
"Dr. H. M. Lukman, M.Ag.",'19850101001,dosen1@gmail.com,password123,L,1
"Dr. Hj. Rahmawati, M.E.",'19880202002,dosen2@gmail.com,password123,P,2`;

    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    const url = URL.createObjectURL(blob);

    link.setAttribute('href', url);
    link.setAttribute('download', 'format_dosen.csv');
    link.style.visibility = 'hidden';

    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
});
</script>

@endsection
