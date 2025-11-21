@extends('layouts.app')

@section('title', 'Login - E-Magazine')

@section('content')
<div class="login-container">
    <div class="login-card">
        <div class="login-header">
            <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="login-logo">
            <h2>E-Magazine 666</h2>
            <p>Silakan masuk ke akun Anda</p>
        </div>
        
        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="login-form">
            @csrf
            <div class="form-group">
                <div class="input-group">
                    <span class="input-icon"><i class="bi bi-person"></i></span>
                    <input type="text" name="username" placeholder="Username" required>
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-icon"><i class="bi bi-lock"></i></span>
                    <input type="password" name="password" placeholder="Password" required>
                </div>
            </div>
            <button type="submit" class="login-btn">
                <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
            </button>
        </form>
        
        <div class="login-footer">
            <a href="{{ route('home') }}" class="back-link">
                <i class="bi bi-arrow-left me-1"></i>Kembali ke Beranda
            </a>
        </div>
    </div>
</div>

<style>
.login-container {
    min-height: 100vh;
    background: linear-gradient(135deg, #87CEEB 0%, #4682B4 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

.login-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    padding: 40px;
    width: 100%;
    max-width: 400px;
    text-align: center;
}

.login-header {
    margin-bottom: 30px;
}

.login-logo {
    width: 100px;
    height: auto;
    margin-bottom: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.login-header h2 {
    color: #2d465e;
    margin-bottom: 5px;
    font-weight: 700;
}

.login-header p {
    color: #666;
    margin: 0;
}

.form-group {
    margin-bottom: 20px;
}

.input-group {
    position: relative;
    display: flex;
    align-items: center;
}

.input-icon {
    position: absolute;
    left: 15px;
    color: #87CEEB;
    z-index: 2;
}

.input-group input {
    width: 100%;
    padding: 15px 15px 15px 45px;
    border: 2px solid #e9ecef;
    border-radius: 10px;
    font-size: 16px;
    transition: all 0.3s ease;
}

.input-group input:focus {
    outline: none;
    border-color: #87CEEB;
    box-shadow: 0 0 0 3px rgba(135, 206, 235, 0.1);
}

.login-btn {
    width: 100%;
    padding: 15px;
    background: linear-gradient(135deg, #87CEEB, #4682B4);
    color: white;
    border: none;
    border-radius: 10px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-bottom: 20px;
}

.login-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(135, 206, 235, 0.4);
}

.back-link {
    color: #666;
    text-decoration: none;
    font-size: 14px;
    transition: color 0.3s ease;
}

.back-link:hover {
    color: #87CEEB;
}

@media (max-width: 480px) {
    .login-card {
        padding: 30px 20px;
    }
    
    .login-logo {
        width: 80px;
        height: auto;
    }
}
</style>
@endsection