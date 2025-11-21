<header id="header" class="header d-flex align-items-center position-relative">
  <div class="container position-relative d-flex align-items-center justify-content-between">

    <div class="d-flex align-items-center me-auto">
      <a href="{{ route('home') }}" class="logo d-flex align-items-center">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="{{ asset('assets/img/logo.webp') }}" alt=""> -->
        <h1 class="sitename">E-magazine 666</h1>
      </a>
    </div>

    <nav id="navmenu" class="navmenu d-flex align-items-center">
      <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
    </nav>

    <div class="d-flex align-items-center">
      <div class="dropdown me-3">
        <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
          <i class="bi bi-search"></i> Pencarian
        </button>
        <div class="dropdown-menu p-3" style="width: 350px;">
          <form method="GET" action="{{ route('search.results') }}">
            <div class="mb-2">
              <input type="text" name="q" class="form-control form-control-sm" placeholder="Cari berdasarkan judul..." value="{{ request('q') }}">
            </div>
            <div class="mb-2">
              <select name="category" class="form-select form-select-sm">
                <option value="">Semua Kategori</option>
                @php $categories = \App\Models\Kategori::all(); @endphp
                @foreach($categories as $cat)
                  <option value="{{ $cat->nama_kategori }}" {{ request('category') == $cat->nama_kategori ? 'selected' : '' }}>
                    {{ $cat->nama_kategori }}
                  </option>
                @endforeach
              </select>
            </div>
            <div class="mb-2">
              <input type="date" name="date" class="form-control form-control-sm" value="{{ request('date') }}">
            </div>
            <button type="submit" class="btn btn-primary btn-sm w-100">
              <i class="bi bi-search"></i> Cari
            </button>
          </form>
        </div>
      </div>
      
      @auth
        <div class="dropdown me-2">
          <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
            <i class="bi bi-person-circle me-1"></i>{{ Auth::user()->nama }}
          </button>
          <ul class="dropdown-menu">
            @if(Auth::user()->role == 'siswa')
              <li><a class="dropdown-item" href="{{ route('siswa.dashboard') }}"><i class="bi bi-house-door me-2"></i>Dashboard</a></li>
            @elseif(Auth::user()->role == 'guru')
              <li><a class="dropdown-item" href="{{ route('guru.dashboard') }}"><i class="bi bi-house-door me-2"></i>Dashboard</a></li>
            @elseif(Auth::user()->role == 'admin')
              <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="bi bi-house-door me-2"></i>Dashboard</a></li>
            @endif
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="{{ route('logout') }}"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
          </ul>
        </div>
      @else
        <a href="{{ route('login') }}" class="btn btn-primary">
          <i class="bi bi-lock me-1"></i>Login
        </a>
      @endauth
      
      <div class="header-social-links d-none">
        <a href="#" class="tiktok"><i class="bi bi-tiktok"></i></a>
        <a href="https://www.facebook.com/share/1M5FHqW712/" class="facebook"><i class="bi bi-facebook"></i></a>
        <a href="https://www.instagram.com/smkbaktinusantara666/?next=%2F&hl=id" class="instagram"><i class="bi bi-instagram"></i></a>
        @auth
          @if(Auth::user()->role == 'admin')
            <a href="{{ route('admin.dashboard') }}" class="text-decoration-none text-dark me-4">Dashboard Admin</a>
          @elseif(Auth::user()->role == 'guru')
            <a href="{{ route('guru.dashboard') }}" class="text-decoration-none text-dark me-4">Dashboard Guru</a>
          @endif
        @endauth
      </div>
    </div>

  </div>
</header>