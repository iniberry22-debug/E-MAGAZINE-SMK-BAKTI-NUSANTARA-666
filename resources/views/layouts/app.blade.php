<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'E-Magazine 666')</title>
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #f0f4f8; }

        /* Header */
        .top-header {
            background: #87CEEB;
            padding: 12px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
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
            cursor: pointer;
        }
        .top-header .btn-user {
            background: #1a6fa8;
            border: none;
            color: white;
            border-radius: 20px;
            padding: 5px 20px;
            font-size: 0.85rem;
            cursor: pointer;
        }

        /* Search Dropdown */
        .search-dropdown {
            display: none;
            position: absolute;
            top: 55px;
            right: 180px;
            background: white;
            border-radius: 12px;
            padding: 15px;
            width: 320px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            z-index: 200;
        }
        .search-dropdown.show { display: block; }

        /* User Dropdown */
        .user-dropdown {
            display: none;
            position: absolute;
            top: 55px;
            right: 30px;
            background: white;
            border-radius: 12px;
            padding: 8px 0;
            min-width: 180px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            z-index: 200;
        }
        .user-dropdown.show { display: block; }
        .user-dropdown a {
            display: block;
            padding: 8px 20px;
            color: #333;
            text-decoration: none;
            font-size: 0.9rem;
        }
        .user-dropdown a:hover { background: #f0f4f8; }
        .user-dropdown hr { margin: 5px 0; }

        main { min-height: calc(100vh - 120px); }

        footer {
            background: #87CEEB;
            text-align: center;
            padding: 15px;
            color: #1a2e4a;
            font-size: 0.85rem;
            margin-top: 40px;
        }
    </style>
    @stack('styles')
</head>
<body>

<!-- Header -->
<div class="top-header">
    <a href="{{ route('home') }}" class="brand">E-magazine 666</a>
    <div style="position:relative;">
        <!-- Search Button -->
        <button class="btn-search" onclick="toggleSearch()">
            <i class="bi bi-search me-1"></i> Pencarian <i class="bi bi-chevron-down ms-1" style="font-size:0.7rem;"></i>
        </button>

        <!-- Search Dropdown -->
        <div class="search-dropdown" id="searchDropdown">
            <form method="GET" action="{{ route('search.results') }}">
                <input type="text" name="q" class="form-control form-control-sm mb-2" placeholder="Cari artikel..." value="{{ request('q') }}">
                <select name="category" class="form-select form-select-sm mb-2">
                    <option value="">Semua Kategori</option>
                    @foreach(\App\Models\Kategori::all() as $cat)
                        <option value="{{ $cat->nama_kategori }}" {{ request('category') == $cat->nama_kategori ? 'selected' : '' }}>{{ $cat->nama_kategori }}</option>
                    @endforeach
                </select>
                <input type="date" name="date" class="form-control form-control-sm mb-2" value="{{ request('date') }}">
                <button type="submit" class="btn btn-primary btn-sm w-100">Cari</button>
            </form>
        </div>

        @auth
            <!-- User Button -->
            <button class="btn-user" onclick="toggleUser()">
                <i class="bi bi-person-circle me-1"></i>
                {{ Auth::user()->role == 'guru' ? 'Pembina Mading' : (Auth::user()->role == 'admin' ? 'Admin' : Auth::user()->nama) }}
                <i class="bi bi-chevron-down ms-1" style="font-size:0.7rem;"></i>
            </button>

            <!-- User Dropdown -->
            <div class="user-dropdown" id="userDropdown">
                @if(Auth::user()->role == 'admin')
                    <a href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
                @elseif(Auth::user()->role == 'guru')
                    <a href="{{ route('guru.dashboard') }}"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
                @else
                    <a href="{{ route('siswa.dashboard') }}"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
                @endif
                <hr>
                <a href="{{ route('logout') }}"><i class="bi bi-box-arrow-right me-2"></i>Logout</a>
            </div>
        @else
            <a href="{{ route('login') }}" class="btn-user"><i class="bi bi-lock me-1"></i> Login</a>
        @endauth
    </div>
</div>

<main>
    @yield('content')
</main>

<footer>
    <p>© {{ date('Y') }} E-Magazine SMK Bakti Nusantara 666. All rights reserved.</p>
</footer>

<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script>
    function toggleSearch() {
        document.getElementById('searchDropdown').classList.toggle('show');
        document.getElementById('userDropdown')?.classList.remove('show');
    }
    function toggleUser() {
        document.getElementById('userDropdown').classList.toggle('show');
        document.getElementById('searchDropdown').classList.remove('show');
    }
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.top-header')) {
            document.getElementById('searchDropdown')?.classList.remove('show');
            document.getElementById('userDropdown')?.classList.remove('show');
        }
    });
</script>
@stack('scripts')
</body>
</html>
