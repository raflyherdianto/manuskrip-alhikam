<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Mahasiswa</title>
    <link rel="icon" href="{{ asset('assets/img/logo-title.png') }}" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --primary-color: #1F304B;
            --secondary-color: #4A90E2;
            --accent-color: #FFA500;
        }

        body {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-container {
            max-width: 450px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .login-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            overflow: hidden;
            animation: slideUp 0.5s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-header {
            background: var(--primary-color);
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .login-header img {
            width: 80px;
            height: 80px;
            margin-bottom: 1rem;
        }

        .login-body {
            padding: 2rem;
        }

        .form-control:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 0.2rem rgba(74, 144, 226, 0.25);
        }

        .btn-login {
            background: var(--secondary-color);
            border: none;
            padding: 0.75rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            background: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        @media (max-width: 576px) {
            .login-header {
                padding: 1.5rem;
            }

            .login-body {
                padding: 1.5rem;
            }

            .login-container {
                max-width: 100%;
            }
        }
    </style>
</head>
<body>
    <!-- Toast Container -->
    <div id="toastContainer" class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;"></div>

    <div class="container">
        <div class="login-container">
            <div class="login-card">
                <div class="login-header">
                    <img src="{{ asset('assets/img/logo-title.png') }}" alt="Logo">
                    <h4 class="mb-0">Manuskrip Digital</h4>
                    <p class="mb-0">Pesantren Mahasiswa Al-Hikam Malang</p>
                </div>

                <div class="login-body">
                    <h5 class="text-center mb-4">Login Mahasiswa</h5>

                    <form action="{{ route('login.post') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="bi bi-person-fill me-2"></i>NIM
                            </label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required autofocus>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                <i class="bi bi-lock-fill me-2"></i>Password
                            </label>
                            <input type="password" name="password" class="form-control" id="passwordInput" required>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="showPassword" onclick="togglePassword()">
                                <label class="form-check-label" for="showPassword">Tampilkan Password</label>
                            </div>
                            <a href="{{ route('password.request') }}" class="text-decoration-none">Lupa Password?</a>
                        </div>

                        <button type="submit" class="btn btn-login btn-primary w-100">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Login
                        </button>
                    </form>

                    <div class="text-center mt-3">
                        <a href="{{ route('home') }}" class="text-muted text-decoration-none">
                            <i class="bi bi-arrow-left me-1"></i>Kembali ke Beranda
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById("passwordInput");
            passwordInput.type = passwordInput.type === "text" ? "password" : "text";
        }

        // Toast notification function
        function showToast(message, type = 'danger') {
            const toastContainer = document.getElementById('toastContainer');
            const toastId = 'toast-' + Date.now();

            const iconClass = type === 'success' ? 'bi-check-circle-fill' :
                             type === 'info' ? 'bi-info-circle-fill' :
                             'bi-exclamation-triangle-fill';

            const bgClass = type === 'success' ? 'bg-success' :
                           type === 'info' ? 'bg-info' :
                           'bg-danger';

            const toastHtml = `
                <div id="${toastId}" class="toast align-items-center text-white ${bgClass} border-0" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            <i class="bi ${iconClass} me-2"></i>${message}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            `;

            toastContainer.insertAdjacentHTML('beforeend', toastHtml);

            const toastElement = document.getElementById(toastId);
            const toast = new bootstrap.Toast(toastElement, {
                autohide: true,
                delay: 5000
            });
            toast.show();

            toastElement.addEventListener('hidden.bs.toast', function () {
                toastElement.remove();
            });
        }

        // Show toast notifications on page load if there are messages
        document.addEventListener('DOMContentLoaded', function() {
            @if($errors->any())
                showToast("{{ $errors->first() }}", 'danger');
            @endif

            @if(session('success'))
                showToast("{{ session('success') }}", 'success');
            @endif

            @if(session('message'))
                showToast("{{ session('message') }}", 'info');
            @endif

            // Check for karya_intended in sessionStorage and store in hidden input
            const karyaIntended = sessionStorage.getItem('karya_intended');
            if (karyaIntended) {
                // Create hidden input to pass intended URL
                const form = document.querySelector('form');
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'intended_url';
                hiddenInput.value = karyaIntended;
                form.appendChild(hiddenInput);
                // Clear the sessionStorage
                sessionStorage.removeItem('karya_intended');
            }
        });
    </script>
</body>
</html>
