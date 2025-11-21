<ul class="navbar-nav bg-gradient-success sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('guru.dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-chalkboard-teacher"></i>
        </div>
        <div class="sidebar-brand-text mx-3">E-Magazine Guru</div>
    </a>

    <hr class="sidebar-divider my-0">

    <li class="nav-item {{ request()->routeIs('guru.dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('guru.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">Artikel</div>

    <li class="nav-item {{ request()->routeIs('guru.artikel.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('guru.artikel.index') }}">
            <i class="fas fa-fw fa-newspaper"></i>
            <span>Artikel</span></a>
    </li>

    <li class="nav-item {{ request()->routeIs('guru.komentar.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('guru.komentar.index') }}">
            <i class="fas fa-fw fa-comments"></i>
            <span>Komentar</span></a>
    </li>

    <li class="nav-item {{ request()->routeIs('guru.poster.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('guru.poster.index') }}">
            <i class="fas fa-fw fa-image"></i>
            <span>Poster Siswa</span></a>
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