<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard Siswa') - E-Magazine</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .notification-bell {
            animation: ring 2s infinite;
        }
        @keyframes ring {
            0% { transform: rotate(0deg); }
            10% { transform: rotate(10deg); }
            20% { transform: rotate(-10deg); }
            30% { transform: rotate(10deg); }
            40% { transform: rotate(-10deg); }
            50% { transform: rotate(0deg); }
            100% { transform: rotate(0deg); }
        }
        .dropdown-menu .dropdown-item {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #f8f9fa;
        }
        .dropdown-menu .dropdown-item:last-child {
            border-bottom: none;
        }
        .dropdown-menu .dropdown-item:hover {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{ route('siswa.dashboard') }}">
                <i class="fas fa-graduation-cap"></i> E-Magazine Siswa
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('siswa.dashboard') }}">
                            <i class="fas fa-home"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('siswa.artikel.index') }}">
                            <i class="fas fa-newspaper"></i> Artikel Saya
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('siswa.artikel.create') }}">
                            <i class="fas fa-plus"></i> Buat Artikel
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('siswa.poster.create') }}">
                            <i class="fas fa-image"></i> Buat Poster
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('siswa.baca-artikel') }}">
                            <i class="fas fa-book-open"></i> Baca Artikel
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">
                            <i class="fas fa-globe"></i> Lihat Website
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown me-3">
                        <a class="nav-link position-relative" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown">
                            @php
                                $newPublishedArticles = App\Models\Artikel::where('id_user', Auth::id())
                                    ->where('status', 'published')
                                    ->where('updated_at', '>=', now()->subDays(7))
                                    ->count();
                                
                                $newPublishedPosters = App\Models\PosterSekolah::where('user_id', Auth::id())
                                    ->where('status', 'published')
                                    ->where('updated_at', '>=', now()->subDays(7))
                                    ->count();
                                
                                $newApprovedCount = App\Models\Artikel::where('id_user', Auth::id())
                                    ->where('status', 'approved')
                                    ->where('updated_at', '>=', now()->subDays(7))
                                    ->count();
                                
                                $newRejectedCount = App\Models\Artikel::where('id_user', Auth::id())
                                    ->where('status', 'rejected')
                                    ->where('updated_at', '>=', now()->subDays(7))
                                    ->count();
                                
                                $totalNotifications = $newPublishedArticles + $newPublishedPosters + $newApprovedCount + $newRejectedCount;
                            @endphp
                            <i class="fas fa-bell {{ $totalNotifications > 0 ? 'notification-bell' : '' }}"></i>
                            @if($totalNotifications > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ $totalNotifications }}
                                </span>
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" style="width: 350px;">
                            <li><h6 class="dropdown-header">Notifikasi</h6></li>
                            @php
                                $publishedArticles = App\Models\Artikel::where('id_user', Auth::id())
                                    ->where('status', 'published')
                                    ->where('updated_at', '>=', now()->subDays(7))
                                    ->latest('updated_at')
                                    ->take(2)
                                    ->get();
                                
                                $publishedPosters = App\Models\PosterSekolah::where('user_id', Auth::id())
                                    ->where('status', 'published')
                                    ->where('updated_at', '>=', now()->subDays(7))
                                    ->latest('updated_at')
                                    ->take(2)
                                    ->get();
                                
                                $approvedArticles = App\Models\Artikel::where('id_user', Auth::id())
                                    ->where('status', 'approved')
                                    ->where('updated_at', '>=', now()->subDays(7))
                                    ->latest('updated_at')
                                    ->take(2)
                                    ->get();
                                
                                $rejectedArticles = App\Models\Artikel::where('id_user', Auth::id())
                                    ->where('status', 'rejected')
                                    ->where('updated_at', '>=', now()->subDays(7))
                                    ->latest('updated_at')
                                    ->take(2)
                                    ->get();
                            @endphp
                            @if($publishedArticles->count() > 0)
                                @foreach($publishedArticles as $artikel)
                                    <li>
                                        <a class="dropdown-item" href="{{ route('blog.details', $artikel->id_artikel) }}">
                                            <div class="d-flex align-items-start">
                                                <i class="fas fa-check-circle text-success me-2 mt-1"></i>
                                                <div class="flex-grow-1">
                                                    <small class="fw-bold text-success">Artikel Dipublish!</small><br>
                                                    <small class="text-dark">{{ Str::limit($artikel->judul, 35) }}</small><br>
                                                    <small class="text-muted">{{ $artikel->updated_at->diffForHumans() }}</small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            @endif
                            @if($publishedPosters->count() > 0)
                                @foreach($publishedPosters as $poster)
                                    <li>
                                        <a class="dropdown-item" href="{{ route('home') }}">
                                            <div class="d-flex align-items-start">
                                                <i class="fas fa-image text-success me-2 mt-1"></i>
                                                <div class="flex-grow-1">
                                                    <small class="fw-bold text-success">Poster Dipublish!</small><br>
                                                    <small class="text-dark">{{ Str::limit($poster->judul, 35) }}</small><br>
                                                    <small class="text-muted">{{ $poster->updated_at->diffForHumans() }}</small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            @endif
                            @if($approvedArticles->count() > 0)
                                @foreach($approvedArticles as $artikel)
                                    <li>
                                        <a class="dropdown-item" href="{{ route('siswa.artikel.show', $artikel->id_artikel) }}">
                                            <div class="d-flex align-items-start">
                                                <i class="fas fa-clock text-info me-2 mt-1"></i>
                                                <div class="flex-grow-1">
                                                    <small class="fw-bold text-info">Artikel Disetujui!</small><br>
                                                    <small class="text-dark">{{ Str::limit($artikel->judul, 35) }}</small><br>
                                                    <small class="text-muted">{{ $artikel->updated_at->diffForHumans() }}</small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            @endif
                            @if($rejectedArticles->count() > 0)
                                @foreach($rejectedArticles as $artikel)
                                    <li>
                                        <a class="dropdown-item" href="{{ route('siswa.artikel.edit', $artikel->id_artikel) }}">
                                            <div class="d-flex align-items-start">
                                                <i class="fas fa-times-circle text-danger me-2 mt-1"></i>
                                                <div class="flex-grow-1">
                                                    <small class="fw-bold text-danger">Artikel Ditolak!</small><br>
                                                    <small class="text-dark">{{ Str::limit($artikel->judul, 35) }}</small><br>
                                                    <small class="text-muted">Klik untuk perbaiki</small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            @endif
                            @if($totalNotifications == 0)
                                <li><span class="dropdown-item-text text-muted">Tidak ada notifikasi baru</span></li>
                            @endif
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user"></i> {{ Auth::user()->nama }}
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('logout') }}">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>