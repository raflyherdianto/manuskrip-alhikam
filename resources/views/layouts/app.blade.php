<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('assets/img/logo-title.png') }}" type="image/png">
    <title>Manuskrip Digital Pesantren - Pesantren Mahasiswa Al-Hikam Malang</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inknut+Antiqua&display=swap" rel="stylesheet">

    <!-- Homepage Styles - Apply to all pages -->
    <link href="{{ asset('assets/css/homepage.css') }}?v=1.1" rel="stylesheet">

    <!-- Vite Assets - Will work in both dev and production -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

</head>
<body style="background: #efefef">
    <div class="d-flex flex-column">
        {{-- @if (Auth::check()) --}}
        @include('components.nav')
        {{-- @endif --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ul>
            </div>
         @endif
         @if (session('success'))
            <div class="position-fixed top-0 end-0 p-3" style="z-index: 1055">
                <div class="toast show bg-success text-white align-items-center border-0" role="alert">
                <div class="d-flex">
                    <div class="toast-body">
                    {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                </div>
            </div>
        @endif

        <div class="content" style="background: #efefef">
            @yield('content')
        </div>

        @include('components.footer')
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Homepage Scripts - Apply to all pages -->
<script src="{{ asset('assets/js/homepage.js') }}"></script>
<script src="{{ asset('assets/js/navbar.js') }}"></script>
</body>
</html>
