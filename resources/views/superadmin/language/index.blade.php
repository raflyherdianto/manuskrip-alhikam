@extends('layouts.superadmin')

@section('page-title', 'Manajemen Bahasa')

@section('content')
<div class="dashboard-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-content">
            <h2>
                <i class="bi bi-translate"></i>
                Manajemen Bahasa
            </h2>
            <p>Kelola daftar bahasa yang tersedia di sistem</p>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="content-card">
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h5>
                <i class="bi bi-table"></i>
                Daftar Bahasa
            </h5>
            <button type="button" class="btn btn-primary btn-sm" id="btnAddLanguage">
                <i class="bi bi-plus-circle" style="color: white;"></i> Tambah Bahasa
            </button>
        </div>
        <div class="card-body">
            <!-- Search Bar -->
            <div class="search-container mb-4">
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" id="searchInput" class="form-control" placeholder="Cari bahasa..." value="{{ request('search') }}">
                </div>
            </div>

            <div id="tableContainer">
                <div class="table-responsive">
                    <table class="table table-hover" id="languagesTable">
                        <thead>
                            <tr>
                                <th style="width: 5%;">No</th>
                                <th style="width: 50%;">
                                    <a href="javascript:void(0)" class="sortable-header" data-sort="nama">
                                        Nama Bahasa
                                        <i class="bi bi-arrow-{{ request('sort_by') == 'nama' && request('sort_order') == 'asc' ? 'up' : (request('sort_by') == 'nama' ? 'down' : 'down-up') }}" id="sort-icon-nama"></i>
                                    </a>
                                </th>
                                <th style="width: 20%;">
                                    <a href="javascript:void(0)" class="sortable-header" data-sort="created_at">
                                        Dibuat
                                        <i class="bi bi-arrow-{{ (request('sort_by') == 'created_at' || !request('sort_by')) && request('sort_order') == 'asc' ? 'up' : ((request('sort_by') == 'created_at' || !request('sort_by')) ? 'down' : 'down-up') }}" id="sort-icon-created_at"></i>
                                    </a>
                                </th>
                                <th style="width: 25%;" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            @forelse($languages as $index => $language)
                            <tr>
                                <td>{{ ($languages->currentPage() - 1) * $languages->perPage() + $index + 1 }}</td>
                                <td>
                                    <strong>{{ $language->nama }}</strong>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        <i class="bi bi-calendar3"></i>
                                        {{ $language->created_at->format('d M Y') }}
                                    </small>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button type="button" class="btn btn-info btn-detail" data-id="{{ $language->id }}">
                                            <i class="bi bi-eye"></i> Detail
                                        </button>
                                        <button type="button" class="btn btn-warning btn-edit" data-id="{{ $language->id }}">
                                            <i class="bi bi-pencil"></i> Edit
                                        </button>
                                        <button type="button" class="btn btn-danger btn-delete" data-id="{{ $language->id }}" data-name="{{ $language->nama }}">
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
                                        @if(request('search'))
                                            Tidak ada hasil untuk "{{ request('search') }}"
                                        @else
                                            Belum ada data bahasa
                                        @endif
                                    </p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($languages->hasPages())
                <div class="pagination-container mt-4" id="paginationContainer">
                    <div class="pagination-info">
                        Menampilkan {{ $languages->firstItem() }} - {{ $languages->lastItem() }} dari {{ $languages->total() }} data
                    </div>
                    <div class="pagination-links">
                        {{ $languages->links('vendor.pagination.custom') }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Detail Modal -->
@include('superadmin.language.detail-modal')

<!-- Edit Modal -->
@include('superadmin.language.edit-modal')

<!-- Add Modal -->
@include('superadmin.language.add-modal')

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
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let searchTimeout;
    let currentSortBy = '{{ request('sort_by', 'created_at') }}';
    let currentSortOrder = '{{ request('sort_order', 'desc') }}';
    let currentSearch = '{{ request('search', '') }}';
    let currentPage = {{ $languages->currentPage() }};

    // Function to load data
    function loadData(search = '', sortBy = 'created_at', sortOrder = 'desc', page = 1, updateUrl = false) {
        const url = new URL('{{ route('superadmin.kelola-bahasa') }}');
        if (search) url.searchParams.set('search', search);
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
            document.getElementById('tableContainer').innerHTML = newTableContainer.innerHTML;

            // Update URL only if needed (not for sort operations)
            if (updateUrl) {
                const displayUrl = new URL('{{ route('superadmin.kelola-bahasa') }}');
                if (search) displayUrl.searchParams.set('search', search);
                if (page > 1) displayUrl.searchParams.set('page', page);
                window.history.pushState({}, '', displayUrl);
            }

            // Re-attach event listeners
            attachEventListeners();
            attachPaginationListeners();
            attachSortListeners();
        });
    }

    // Search input with debounce
    const searchInput = document.getElementById('searchInput');
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        const searchValue = this.value.trim();

        searchTimeout = setTimeout(() => {
            currentSearch = searchValue;
            currentPage = 1;

            // If search is empty, reset to default sort
            if (!searchValue) {
                currentSortBy = 'created_at';
                currentSortOrder = 'desc';
            }

            loadData(currentSearch, currentSortBy, currentSortOrder, currentPage, true);
        }, 500);
    });

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
                loadData(currentSearch, currentSortBy, currentSortOrder, currentPage, false);
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
                loadData(currentSearch, currentSortBy, currentSortOrder, currentPage, true);
            });
        });
    }

    // Event listeners for table actions
    function attachEventListeners() {
        // Detail Button
        document.querySelectorAll('.btn-detail').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                fetch(`/superadmin/kelola-bahasa/${id}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('detailNama').textContent = data.nama;
                        document.getElementById('detailCreated').textContent = new Date(data.created_at).toLocaleDateString('id-ID', {
                            day: 'numeric',
                            month: 'long',
                            year: 'numeric'
                        });
                        document.getElementById('detailUpdated').textContent = new Date(data.updated_at).toLocaleDateString('id-ID', {
                            day: 'numeric',
                            month: 'long',
                            year: 'numeric'
                        });
                        const detailModal = new bootstrap.Modal(document.getElementById('detailModal'));
                        detailModal.show();
                    });
            });
        });

        // Edit Button
        document.querySelectorAll('.btn-edit').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                fetch(`/superadmin/kelola-bahasa/${id}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('editLanguageId').value = data.id;
                        document.getElementById('editNama').value = data.nama;
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

                if(confirm(`Apakah Anda yakin ingin menghapus bahasa "${name}"?`)) {
                    fetch(`/superadmin/kelola-bahasa/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        loadData(currentSearch, currentSortBy, currentSortOrder, currentPage, false);
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

    // Add Button
    const addLanguageModal = new bootstrap.Modal(document.getElementById('addLanguageModal'));
    document.getElementById('btnAddLanguage').addEventListener('click', function() {
        document.getElementById('addLanguageForm').reset();
        addLanguageModal.show();
    });

    // Add Form Submit
    document.getElementById('addLanguageForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const nama = document.getElementById('addLanguageNama').value;

        fetch('/superadmin/kelola-bahasa', {
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
                addLanguageModal.hide();
                loadData(currentSearch, currentSortBy, currentSortOrder, currentPage, false);
            }
        })
        .catch(error => console.error('Error:', error));
    });

    // Edit Form Submit
    document.getElementById('editForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const id = document.getElementById('editLanguageId').value;
        const nama = document.getElementById('editNama').value;

        fetch(`/superadmin/kelola-bahasa/${id}`, {
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
                bootstrap.Modal.getInstance(document.getElementById('editModal')).hide();
                loadData(currentSearch, currentSortBy, currentSortOrder, currentPage, false);
            }
        });
    });
});
</script>
@endsection
