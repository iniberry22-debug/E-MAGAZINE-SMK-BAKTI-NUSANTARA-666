<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Siswa - E-Magazine 666')</title>
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f0f4f8; }
        .sidebar { width: 240px; min-height: 100vh; background: #1a2e4a; position: fixed; top: 0; left: 0; z-index: 100; }
        .sidebar-brand { padding: 20px; background: #87CEEB; font-size: 1.1rem; font-weight: 700; color: #1a2e4a; display: flex; align-items: center; gap: 10px; }
        .sidebar-brand img { width: 35px; height: 35px; object-fit: contain; }
        .sidebar-menu { padding: 15px 0; }
        .sidebar-menu a { display: flex; align-items: center; gap: 10px; padding: 10px 20px; color: #adb5bd; text-decoration: none; font-size: 0.9rem; transition: all 0.2s; }
        .sidebar-menu a:hover, .sidebar-menu a.active { background: rgba(135,206,235,0.15); color: #87CEEB; border-left: 3px solid #87CEEB; }
        .sidebar-menu .menu-title { padding: 10px 20px 5px; font-size: 0.7rem; text-transform: uppercase; color: #6c757d; letter-spacing: 1px; }
        .main-content { margin-left: 240px; min-height: 100vh; }
        .topbar { background: #87CEEB; padding: 12px 25px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 8px rgba(0,0,0,0.1); position: sticky; top: 0; z-index: 99; }
        .topbar .page-title { font-weight: 600; color: #1a2e4a; font-size: 1rem; }
        .content-area { padding: 25px; }
        .card { border: none; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.07); }
        .card-header { background: white; border-bottom: 1px solid #f0f0f0; border-radius: 12px 12px 0 0 !important; padding: 15px 20px; }
        .stat-card { border-radius: 12px; padding: 20px; color: white; }
        .stat-card.blue { background: linear-gradient(135deg, #5BA3C9, #4682B4); }
        .stat-card.green { background: linear-gradient(135deg, #56ab2f, #a8e063); }
        .stat-card.orange { background: linear-gradient(135deg, #f7971e, #ffd200); }
        .stat-card.red { background: linear-gradient(135deg, #cb2d3e, #ef473a); }
        .stat-card .number { font-size: 2rem; font-weight: 700; }
        .stat-card .label { font-size: 0.85rem; opacity: 0.9; }
        .badge-status-published { background: #d4edda; color: #155724; padding: 3px 10px; border-radius: 20px; font-size: 0.75rem; }
        .badge-status-pending { background: #fff3cd; color: #856404; padding: 3px 10px; border-radius: 20px; font-size: 0.75rem; }
        .badge-status-draft { background: #e2e3e5; color: #383d41; padding: 3px 10px; border-radius: 20px; font-size: 0.75rem; }
        .badge-status-rejected { background: #f8d7da; color: #721c24; padding: 3px 10px; border-radius: 20px; font-size: 0.75rem; }
        .badge-status-approved { background: #cce5ff; color: #004085; padding: 3px 10px; border-radius: 20px; font-size: 0.75rem; }
        .table th { font-size: 0.8rem; text-transform: uppercase; color: #6c757d; font-weight: 600; }
        .table td { font-size: 0.88rem; vertical-align: middle; }
        .btn-action { padding: 4px 10px; font-size: 0.78rem; border-radius: 6px; }
    </style>
    @stack('styles')
</head>
<body>
<div class="sidebar">
    <div class="sidebar-brand">
        <img src="{{ asset('assets/img/logo.webp') }}" alt="Logo">
        E-Magazine 666
    </div>
    <div class="sidebar-menu">
        <div class="menu-title">Menu Siswa</div>
        <a href="{{ route('siswa.dashboard') }}" class="{{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <a href="{{ route('siswa.artikel.index') }}" class="{{ request()->routeIs('siswa.artikel*') ? 'active' : '' }}">
            <i class="bi bi-newspaper"></i> Artikel Saya
        </a>
        <a href="{{ route('siswa.poster.create') }}" class="{{ request()->routeIs('siswa.poster*') ? 'active' : '' }}">
            <i class="bi bi-image"></i> Upload Poster
        </a>
        <div class="menu-title" style="margin-top:10px;">Lainnya</div>
        <a href="{{ route('home') }}"><i class="bi bi-house"></i> Beranda</a>
        <a href="{{ route('logout') }}"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </div>
</div>
<div class="main-content">
    <div class="topbar">
        <span class="page-title">@yield('page-title', 'Dashboard')</span>
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-person-circle" style="font-size:1.3rem; color:#1a2e4a;"></i>
            <span style="font-size:0.9rem; font-weight:500; color:#1a2e4a;">{{ Auth::user()->nama }}</span>
        </div>
    </div>
    <div class="content-area">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" style="border-radius:10px;">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @yield('content')
    </div>
</div>
<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
@stack('scripts')
</body>
</html>
