<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Masjid Baiturrohim</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Scheherazade+New&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #e8f5e9, #a5d6a7);
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 1rem;
        }

        .login-card {
            background: white;
            border-radius: 1.5rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
            width: 100%;
            max-width: 400px;
            padding: 2rem;
            position: relative;
            animation: fadeInUp 0.8s ease;
        }

        .login-header {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .login-header h3 {
            font-weight: 700;
            color: #2e7d32;
        }

        .login-header small {
            color: #666;
            font-size: 0.9rem;
        }

        .form-control {
            border-radius: 10px;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
        }

        .btn-login {
            background: #2e7d32;
            color: white;
            border-radius: 10px;
            font-weight: 600;
            padding: 0.75rem;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            background: #1b5e20;
            transform: translateY(-2px);
        }

        .arabic-decor {
            font-family: 'Scheherazade New', serif;
            color: rgba(46, 125, 50, 0.7);
            font-size: 2.2rem;
            text-align: center;
            margin-bottom: 1rem;
        }

        .forgot-password {
            text-align: right;
            font-size: 0.9rem;
        }

        .forgot-password a {
            color: #2e7d32;
            text-decoration: none;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }

        @keyframes fadeInUp {
            from {
                transform: translateY(20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* 🌙 Responsif */
        @media (max-width: 480px) {
            .login-card {
                padding: 1.5rem;
            }

            .arabic-decor {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="arabic-decor">بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ</div>

        <div class="login-header">
            <h3>Login Admin</h3>
            <small>Masuk untuk mengelola website masjid</small>
        </div>

        @if(session('error'))
            <div class="alert alert-danger small">{{ session('error') }}</div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-semibold">Email</label>
                <div class="input-group">
                    <span class="input-group-text bg-success text-white"><i class="bi bi-envelope"></i></span>
                    <input type="email" name="email" class="form-control" placeholder="contoh@mail.com" required autofocus>
                </div>
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Password</label>
                <div class="input-group">
                    <span class="input-group-text bg-success text-white"><i class="bi bi-lock"></i></span>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="forgot-password mb-3">
                <a href="#">Lupa password?</a>
            </div>

            <button type="submit" class="btn btn-login w-100">
                <i class="bi bi-door-open me-1"></i> Masuk
            </button>
        </form>

        <div class="text-center mt-4">
            <small class="text-muted">Masjid Baiturrohim© {{ date('Y') }}</small>
        </div>
    </div>

</body>
</html>
