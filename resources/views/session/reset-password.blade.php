<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="icon" href="{{ asset('assets/img/logo-title.png') }}" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #1F304B 0%, #4A90E2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
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
            padding: 2rem;
        }

        .password-strength {
            height: 5px;
            border-radius: 3px;
            transition: all 0.3s;
        }

        @media (max-width: 576px) {
            .login-card {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <div class="login-card">
                <div class="text-center mb-4">
                    <i class="bi bi-shield-lock-fill text-primary" style="font-size: 3rem;"></i>
                    <h4 class="mt-3">Reset Password</h4>
                    <p class="text-muted">Masukkan password baru Anda</p>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        {{ $errors->first() }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('password.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <input type="hidden" name="email" value="{{ $email }}">

                    <div class="mb-3">
                        <label class="form-label">
                            <i class="bi bi-envelope-fill me-2"></i>Email
                        </label>
                        <input type="email" class="form-control" value="{{ $email }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            <i class="bi bi-lock-fill me-2"></i>Password Baru
                        </label>
                        <input type="password" name="password" id="password" class="form-control" required minlength="6">
                        <small class="text-muted">Minimal 6 karakter</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            <i class="bi bi-lock-fill me-2"></i>Konfirmasi Password
                        </label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                    </div>

                    <div class="form-check mb-3">
                        <input type="checkbox" class="form-check-input" id="showPasswords" onclick="togglePasswords()">
                        <label class="form-check-label" for="showPasswords">Tampilkan Password</label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-check-circle-fill me-2"></i>Reset Password
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePasswords() {
            const password = document.getElementById("password");
            const passwordConfirmation = document.getElementById("password_confirmation");
            const type = password.type === "password" ? "text" : "password";
            password.type = type;
            passwordConfirmation.type = type;
        }
    </script>
</body>
</html>
