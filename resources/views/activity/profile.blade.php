@extends('layouts.app')

@section('content')
<!-- Activity Dashboard CSS -->
<link href="{{ asset('assets/css/activity.css') }}" rel="stylesheet">

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
                    <a href="{{ route('activity') }}" class="nav-link">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('activity.profile') }}" class="nav-link active">
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
            <h1 class="page-title">Profil Pengguna</h1>
        </div>

        <!-- Dashboard Content -->
        <div class="dashboard-content">
            <!-- Verification Alert for Unverified Users -->
            @if(!Auth::user()->verified)
            <div class="alert alert-warning alert-dismissible fade show" role="alert" style="border-left: 4px solid #ffc107; background-color: #fff3cd; margin-bottom: 1.5rem;">
                <div style="display: flex; align-items: start; gap: 1rem;">
                    <div style="font-size: 1.5rem; color: #856404;">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                    </div>
                    <div style="flex: 1;">
                        <h5 style="color: #856404; margin: 0 0 0.5rem 0; font-weight: 600;">
                            <i class="bi bi-shield-exclamation"></i> Akun Belum Terverifikasi
                        </h5>
                        <p style="margin: 0; color: #856404; line-height: 1.6;">
                            Untuk mengaktifkan akun Anda, silakan verifikasi dengan mengubah <strong>email</strong> dan <strong>password</strong> Anda.
                            Klik tombol <strong>"Edit Profil"</strong> di bawah ini untuk memperbarui informasi akun Anda.
                        </p>
                        <small style="display: block; margin-top: 0.5rem; color: #856404;">
                            <i class="bi bi-info-circle"></i> Setelah Anda mengubah email dan password, akun Anda akan diverifikasi secara otomatis.
                        </small>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <!-- Session Warning Message -->
            @if(session('warning'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                {{ session('warning') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <!-- User Profile Info -->
            <div class="profile-section">
                <div class="profile-header">
                    <div class="profile-avatar-large">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="profile-info">
                        <h2>{{ Auth::user()->name }}</h2>
                        <p>{{ Auth::user()->email }}</p>
                    </div>
                </div>

                <!-- Edit Profile Button -->
                <div class="profile-actions">
                    <button type="button" class="btn-edit-profile" id="btnEditProfile">
                        <i class="bi bi-pencil-square me-2"></i>
                        Edit Profil
                    </button>
                </div>

                <div class="profile-details">
                    @if(Auth::user()->nim)
                    <div class="profile-field">
                        <label class="profile-label">NIM</label>
                        <div class="profile-value">{{ Auth::user()->nim }}</div>
                    </div>
                    @endif

                    @if(Auth::user()->nip)
                    <div class="profile-field">
                        <label class="profile-label">NIP</label>
                        <div class="profile-value">{{ Auth::user()->nip }}</div>
                    </div>
                    @endif

                    <div class="profile-field">
                        <label class="profile-label">Angkatan</label>
                        <div class="profile-value">
                            @if(Auth::user()->angkatan && Auth::user()->jurusan)
                                {{ Auth::user()->angkatan }} - {{ Auth::user()->jurusan->nama }}
                            @else
                                {{ Auth::user()->angkatan ?? '-' }}
                            @endif
                        </div>
                    </div>

                    <div class="profile-field">
                        <label class="profile-label">Jenis Kelamin</label>
                        <div class="profile-value">
                            @if(Auth::user()->jenis_kelamin == 'L')
                                Laki-laki
                            @elseif(Auth::user()->jenis_kelamin == 'P')
                                Perempuan
                            @else
                                {{ Auth::user()->jenis_kelamin ?? '-' }}
                            @endif
                        </div>
                    </div>

                    <div class="profile-field">
                        <label class="profile-label">Status</label>
                        <div class="profile-value">
                            @if(Auth::user()->verified)
                                <span style="color: #28a745;">✓ Terverifikasi</span>
                            @else
                                <span style="color: #dc3545;">✗ Belum Terverifikasi</span>
                            @endif
                        </div>
                    </div>

                    <div class="profile-field">
                        <label class="profile-label">Profil terakhir diubah</label>
                        <div class="profile-value">{{ \Carbon\Carbon::parse(Auth::user()->updated_at)->locale('id')->translatedFormat('d F Y') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Edit Profile Modal -->
<div class="modal-overlay" id="editProfileModal">
    <div class="modal-container">
        <div class="modal-header">
            <h3 class="modal-title">Edit Profil</h3>
            <button type="button" class="modal-close" id="closeEditModal" aria-label="Close">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <form id="editProfileForm" method="POST" action="{{ route('activity.profile.update') }}">
            @csrf
            @method('PATCH')

            <div class="modal-body">
                <div class="form-group">
                    <label for="edit_email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="edit_email" name="email" value="{{ Auth::user()->email }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Ubah Password (opsional)</label>
                    <input type="password" class="form-control" id="edit_password" name="password" placeholder="Kosongkan jika tidak ingin mengubah">
                </div>

                <div class="form-group">
                    <label for="edit_password_confirmation" class="form-label">Konfirmasi Password</label>
                    <input type="password" class="form-control" id="edit_password_confirmation" name="password_confirmation" placeholder="Konfirmasi password baru">
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-cancel" id="cancelEditModal">Batal</button>
                <button type="submit" class="btn-submit">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<!-- Activity Dashboard JavaScript -->
<script src="{{ asset('assets/js/activity.js') }}"></script>

@endsection
