<ul class="navbar-nav bg-gradient-success sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-newspaper"></i>
        </div>
        <div class="sidebar-brand-text mx-3">E-Magazine Admin</div>
    </a>

    <hr class="sidebar-divider my-0">

    <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">Management</div>

    <li class="nav-item {{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.kategori.index') }}">
            <i class="fas fa-fw fa-tags"></i>
            <span>Kelola Kategori</span></a>
    </li>

    <li class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.users.index') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Kelola User</span></a>
    </li>

    <li class="nav-item {{ request()->routeIs('admin.artikel.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.artikel.index') }}">
            <i class="fas fa-fw fa-check-circle"></i>
            <span>Verifikasi Artikel</span></a>
    </li>

    <li class="nav-item {{ request()->routeIs('admin.poster.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.poster.index') }}">
            <i class="fas fa-fw fa-image"></i>
            <span>Publish Poster</span></a>
    </li>

    <li class="nav-item {{ request()->routeIs('admin.comments') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.comments') }}">
            <i class="fas fa-fw fa-comments"></i>
            <span>Kelola Komentar</span></a>
    </li>

    <li class="nav-item {{ request()->routeIs('admin.likes') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.likes') }}">
            <i class="fas fa-fw fa-heart"></i>
            <span>Kelola Likes</span></a>
    </li>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">Reports</div>

    <li class="nav-item {{ request()->routeIs('admin.reports') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.reports') }}">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Laporan</span></a>
    </li>

    <hr class="sidebar-divider">

    <li class="nav-item">
        <a class="nav-link" href="{{ route('home') }}">
            <i class="fas fa-fw fa-globe"></i>
            <span>Lihat Website</span></a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>