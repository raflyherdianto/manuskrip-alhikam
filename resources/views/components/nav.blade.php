<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<nav class="navbar navbar-expand-lg navbar-modern shadow-sm">
  <div class="container-fluid px-4 d-flex justify-content-between align-items-center">

    <!-- Logo -->
    <a class="navbar-brand d-flex align-items-center" href="/">
      <img class="logo-custom mx-3 w-20" src="{{ asset('assets/img/logo.png') }}" alt="Logo">
      <div class="d-flex flex-column">
        <div class="brand-title-custom">Manuskrip Digital Pesantren</div>
        <div class="brand-subtitle-custom">Pesantren Mahasiswa Al-Hikam Malang</div>
      </div>
    </a>

    <style>
      .brand-title-custom {
        background: linear-gradient(135deg, #0d7a50, #10b981);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-weight: 800;
        font-size: 1.25rem;
        white-space: nowrap;
        line-height: 1.2;
      }
      
      .brand-subtitle-custom {
        color: #718096;
        font-size: 0.75rem;
        font-weight: 600;
        white-space: nowrap;
        margin-top: 2px;
      }

      @media (max-width: 1200px) {
        .brand-title-custom {
          font-size: 1.1rem;
        }
        .brand-subtitle-custom {
          font-size: 0.7rem;
        }
      }

      @media (max-width: 575.98px) {
        .brand-title-custom {
          font-size: 1rem;
        }
        .brand-subtitle-custom {
          font-size: 0.65rem;
        }
        .logo-custom {
          width: 45px;
          margin-left: 0.5rem !important;
          margin-right: 0.5rem !important;
        }
      }
    </style>

    <!-- Toggle button for mobile -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Menu Navigasi -->
    <div class="collapse navbar-collapse justify-content-end" id="navbarMenu">
      <ul class="navbar-nav gap-2 fw-bold px-5 align-items-lg-center">
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('guide') ? 'active' : '' }}" href="{{ route('guide') }}">Panduan Unggah</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">Tentang Kami</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('faq') ? 'active' : '' }}" href="{{ route('faq') }}">FAQ</a>
        </li>

        @auth
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('activity') ? 'active' : '' }}" href="{{ route('activity') }}">Aktivitas</a>
          </li>
          <li class="nav-item">
            <form action="{{ route('logout') }}" method="POST" class="m-0">
              @csrf
              <button type="submit" class="btn btn-logout">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                  <polyline points="16 17 21 12 16 7"/>
                  <line x1="21" y1="12" x2="9" y2="12"/>
                </svg>
                <span>Logout</span>
              </button>
            </form>
          </li>
        @else
          <li class="nav-item">
            <a class="btn btn-login" href="{{ route('login') }}">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                <polyline points="10 17 15 12 10 7"/>
                <line x1="15" y1="12" x2="3" y2="12"/>
              </svg>
              <span>Login</span>
            </a>
          </li>
        @endauth
      </ul>
    </div>

  </div>
</nav>
<!-- Garis Biru -->
<div class="navbar-border"></div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Navbar Custom JS -->
<script src="{{ asset('assets/js/navbar.js') }}"></script>
