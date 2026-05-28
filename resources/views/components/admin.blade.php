<style>
  .dropdown-menu {
    position: static !important;
    display: none;
  }

  .nav-item.dropdown:hover .dropdown-menu {
    display: block;
  }
</style>
<div class="sidebar d-flex flex-column flex-shrink-0 text-white"
     style="position: fixed; top: 0; bottom: 0; width: 250px; background: #1F304B; z-index: 1030;">
    <a href="/admin" class="mt-5  d-flex flex-column align-items-center justify-content-center text-white text-decoration-none text-center" style="margin: auto;">
        <div style="font-size: 24px;">Admin</div>
        <img class="logo-custom my-2" src="{{ asset('assets/img/logo-title.png') }}" style="width: 120px; height: 115px"  alt="Logo">
        <h6 class="mb-0">Repository Digital<br>Pesantren Al-Hikam</h6>
    </a>

  <hr class="my-4">
  <div class="collapse mx-3 mr-5 navbar-collapse d-flex justify-content-between" id="navbarSupportedContent">
    <ul class="nav w-100 nav-pills flex-column mb-auto">
      <li class="">
        <a class="nav-link text-white mt-1 d-flex gap-2" style="font-size: 18px" href="{{route('admin')}}"><i class="bi bi-house-door-fill"></i> Beranda</a>
      </li>
      <li class="">
        <a class="nav-link text-white mt-1 d-flex gap-2" style="font-size: 18px" href="{{route('karya')}}">
          <i class="bi bi-inbox"></i>
          Manuskrip Masuk
        </a>
      </li>
      <li class="nav-item dropdown position-relative">
        <a class="nav-link text-white mt-1 d-flex justify-content-between align-items-center"
          href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 18px;">
          <span class="d-flex gap-2 align-items-center">
            <i class="bi bi-patch-check-fill"></i>
            Verifikasi
          </span>
          <i class="bi bi-caret-down-fill"></i>
        </a>
        <ul class="dropdown-menu border-0 shadow w-100 mt-1 static-dropdown" style="background-color: #1F304B;">
          <li>
            <a class="dropdown-item text-white nav-link mt-1" href="{{route('konfirmasi')}}">
              <i class="bi bi-check-circle"></i>
              Konfirmasi
            </a>
          </li>
          <li>
            <a class="dropdown-item text-white nav-link mt-1" href="{{route('publikasi')}}">
              <i class="bi bi-upload"></i>
              Publikasi
            </a>
          </li>
        </ul>
      </li>
      <li class="">
        <a class="nav-link text-white mt-1 d-flex gap-2" style="font-size: 18px" href="{{route('arsip')}}"><i class="bi bi-archive"></i>
           Arsip Manuskrip</a>
      </li>
    </ul>
  </div>
  <hr>
    <div class=" my-4 mx-4 px-2 mt-4">
        <a href="#" class="nav-link fw-bold text-white" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="bi bi-box-arrow-left"></i> Logout
        </a>

        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
</div>
<style>
    .sidebar .dropdown-menu {
        width: 100%;
    }
      /* Ubah dropdown jadi mengalir dan tidak menutupi item di bawah */
  .static-dropdown {
    position: static !important;
    float: none;
    inset: unset !important;
    transform: none !important;
  }

  /* Tambahan styling agar menu tetap rapi */
  .dropdown-menu .dropdown-item:hover {
    background-color: #2c4a6b;
  }
</style>
