<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - E-Magazine 666</title>
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #87CEEB 0%, #5BA3C9 50%, #4682B4 100%);
            min-height: 100vh;
        }

        /* Header */
        .top-header {
            background: rgba(135, 206, 235, 0.9);
            padding: 12px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            backdrop-filter: blur(5px);
        }
        .top-header .brand {
            font-size: 1.4rem;
            font-weight: 700;
            color: #1a2e4a;
            text-decoration: none;
        }
        .top-header .btn-search {
            background: transparent;
            border: 1.5px solid #1a6fa8;
            color: #1a6fa8;
            border-radius: 20px;
            padding: 5px 16px;
            font-size: 0.85rem;
            margin-right: 10px;
        }
        .top-header .btn-login {
            background: #1a6fa8;
            border: none;
            color: white;
            border-radius: 20px;
            padding: 5px 20px;
            font-size: 0.85rem;
        }

        /* Login Card */
        .login-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 60px);
            padding: 30px;
        }
        .login-card {
            background: white;
            border-radius: 20px;
            padding: 45px 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.15);
            text-align: center;
        }
        .login-card .logo {
            width: 80px;
            height: 80px;
            object-fit: contain;
            margin-bottom: 15px;
        }
        .login-card h2 {
            font-size: 1.6rem;
            font-weight: 700;
            color: #1a2e4a;
            margin-bottom: 5px;
        }
        .login-card .subtitle {
            color: #888;
            font-size: 0.9rem;
            margin-bottom: 30px;
        }
        .input-group-custom {
            position: relative;
            margin-bottom: 15px;
        }
        .input-group-custom .icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #87CEEB;
            font-size: 1rem;
        }
        .input-group-custom input {
            width: 100%;
            padding: 13px 15px 13px 42px;
            border: 1.5px solid #e0e0e0;
            border-radius: 10px;
            font-size: 0.95rem;
            outline: none;
            transition: border-color 0.2s;
        }
        .input-group-custom input:focus {
            border-color: #87CEEB;
        }
        .btn-masuk {
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, #5BA3C9, #4682B4);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            margin-top: 10px;
            cursor: pointer;
            transition: opacity 0.2s;
        }
        .btn-masuk:hover { opacity: 0.9; }
        .back-link {
            display: block;
            margin-top: 15px;
            color: #888;
            font-size: 0.85rem;
            text-decoration: none;
        }
        .back-link:hover { color: #4682B4; }
    </style>
</head>
<body>

<!-- Header -->
<div class="top-header">
    <a href="{{ route('home') }}" class="brand">E-magazine 666</a>
    <div>
        <button class="btn-search"><i class="bi bi-search me-1"></i> Pencarian</button>
        <button class="btn-login"><i class="bi bi-lock me-1"></i> Login</button>
    </div>
</div>

<!-- Login Card -->
<div class="login-wrapper">
    <div class="login-card">
        <img src="{{ asset('assets/img/logo.webp') }}" alt="Logo" class="logo">
        <h2>E-Magazine 666</h2>
        <p class="subtitle">Silakan masuk ke akun Anda</p>

        @if($errors->any())
            <div class="alert alert-danger text-start mb-3" style="border-radius:10px; font-size:0.85rem;">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="input-group-custom">
                <i class="bi bi-person icon"></i>
                <input type="email" name="email" placeholder="Username" value="{{ old('email') }}" required>
            </div>
            <div class="input-group-custom">
                <i class="bi bi-lock icon"></i>
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit" class="btn-masuk">
                <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
            </button>
        </form>

        <a href="{{ route('home') }}" class="back-link">← Kembali ke Beranda</a>
    </div>
</div>

</body>
</html>
