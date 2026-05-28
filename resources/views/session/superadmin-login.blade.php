<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Superadmin</title>
    <link rel="icon" href="{{ asset('assets/img/logo-title.png') }}" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --primary-color: #2C5F7C;
            --secondary-color: #3A7CA5;
            --accent-color: #4A90A4;
            --hover-color: #234E68;
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
            width: 100%;
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
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
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
            border-radius: 50%;
            background: white;
            padding: 0.5rem;
        }

        .login-header h4 {
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .login-body {
            padding: 2rem;
        }

        .login-body h5 {
            color: var(--primary-color);
            font-weight: 600;
        }

        .form-label {
            color: #495057;
            font-weight: 500;
        }

        .form-control {
            border-radius: 8px;
            padding: 0.65rem 0.75rem;
        }

        .form-control:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.2rem rgba(74, 144, 164, 0.25);
        }

        .btn-login {
            background: var(--accent-color);
            border: none;
            padding: 0.75rem;
            font-weight: 600;
            transition: all 0.3s ease;
            border-radius: 8px;
        }

        .btn-login:hover {
            background: var(--hover-color);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .text-decoration-none {
            color: var(--primary-color);
            transition: color 0.3s ease;
        }

        .text-decoration-none:hover {
            color: var(--accent-color);
        }

        @media (max-width: 576px) {
            .login-container {
                margin: 1rem auto;
                padding: 0 0.75rem;
            }

            .login-header {
                padding: 1.5rem 1rem;
            }

            .login-header img {
                width: 60px;
                height: 60px;
            }

            .login-header h4 {
                font-size: 1.25rem;
            }

            .login-header p {
                font-size: 0.875rem;
            }

            .login-body {
                padding: 1.5rem;
            }

            .login-body h5 {
                font-size: 1rem;
            }

            .form-label {
                font-size: 0.9rem;
            }

            .btn-login {
                padding: 0.65rem;
                font-size: 0.9rem;
            }
        }

        @media (max-width: 375px) {
            .login-body {
                padding: 1.25rem;
            }

            .form-control {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <!-- Toast Container -->
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
        @if($errors->any())
            <div class="toast show align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        {{ $errors->first() }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        @endif

        @if(session('success'))
            <div class="toast show align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        @endif
    </div>

    <div class="container">
        <div class="login-container">
            <div class="login-card">
                <div class="login-header">
                    <img src="{{ asset('assets/img/logo-title.png') }}" alt="Logo">
                    <h4 class="mb-0">Manuskrip Digital</h4>
                    <p class="mb-0">Pesantren Mahasiswa Al-Hikam Malang</p>
                </div>

                <div class="login-body">
                    <h5 class="text-center mb-4">
                        <i class="bi bi-person-gear me-2"></i>Login Superadmin
                    </h5>

                    <form action="{{ route('login.post') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="bi bi-envelope-fill me-2"></i>Email Superadmin
                            </label>
                            <input type="email" name="name" class="form-control" value="{{ old('name') }}" required autofocus>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                <i class="bi bi-shield-lock-fill me-2"></i>Password
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

                        <button type="submit" class="btn btn-login w-100" style="background: #4A90A4;">
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

        // Auto hide toast after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const toasts = document.querySelectorAll('.toast');
            toasts.forEach(function(toast) {
                setTimeout(function() {
                    const bsToast = new bootstrap.Toast(toast);
                    bsToast.hide();
                }, 5000);
            });
        });
    </script>
</body>
</html>
