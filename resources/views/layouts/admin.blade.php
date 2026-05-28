<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('assets/img/logo-title.png') }}" type="image/png">
    <title>Pesantren Mahasiswa Al-Hikam Malang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inknut+Antiqua&display=swap" rel="stylesheet">
    <style>
        /* Sidebar responsive */
.sidebar {
    position: fixed;
    top: 0;
    bottom: 0;
    left: -250px;
    width: 250px;
    background: #1F304B;
    z-index: 1050;
    transition: left 0.3s ease-in-out;
}

.sidebar.show {
    left: 0;
}

.content.with-sidebar {
    margin-left: 250px;
    transition: margin-left 0.3s ease-in-out;
}

@media (min-width: 768px) {
    .sidebar {
        left: 0;
    }
    .content {
        margin-left: 250px !important;
    }
}

@media (max-width: 767px) {
    .content {
        margin-left: 0 !important;
    }
}

    </style>
</head>
<body>
    <button class="btn btn-primary d-md-none position-fixed shadow" id="sidebarToggle"
        style="top: 60px; left: 15px; z-index: 1100;">
        <i class="bi bi-list"></i>
    </button>
    <div class="d-flex flex-row">

        @include('components.admin')
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

        <div class="content" style="background: #ffff; width: 100vw; margin-left: 250px;">
            @yield('admin')
        </div>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.querySelector('.sidebar');
        const content = document.querySelector('.content');
        const toggleBtn = document.getElementById('sidebarToggle');

        if (sidebar && toggleBtn) {
            toggleBtn.addEventListener('click', function () {
                sidebar.classList.toggle('show');
                if (content) {
                    content.classList.toggle('with-sidebar');
                }
            });
        }
    });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>
