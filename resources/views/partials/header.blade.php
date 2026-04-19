<header id="header" class="header d-flex align-items-center position-relative">
  <div class="container position-relative d-flex align-items-center justify-content-between">

    <a href="{{ route('home') }}" class="logo d-flex align-items-center me-auto me-xl-0">
      <!-- Uncomment the line below if you also wish to use an image logo -->
      <!-- <img src="{{ asset('assets/img/logo.webp') }}" alt=""> -->
      <h1 class="sitename">E-magazine 666</h1>
    </a>

    <nav id="navmenu" class="navmenu">
      <ul>
        <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a></li>
        <li><a href="{{ route('about') }}">About</a></li>
        <li><a href="{{ route('category') }}">Category</a></li>
        <li><a href="{{ route('blog.details', 1) }}">Blog Details</a></li>
        <li><a href="{{ route('author.profile') }}">Author Profile</a></li>
        <li class="dropdown"><a href="#"><span>Pages</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
          <ul>
            <li><a href="{{ route('about') }}">About</a></li>
            <li><a href="{{ route('category') }}">Category</a></li>
            <li><a href="{{ route('blog.details', 1) }}">Blog Details</a></li>
            <li><a href="{{ route('author.profile') }}">Author Profile</a></li>
            <li><a href="{{ route('search.results') }}">Search Results</a></li>
            </li>
          </ul>
        </li>
        <li><a href="{{ route('contact') }}">Contact</a></li>
      </ul>
      <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
    </nav>

    <div class="header-social-links">
      <a href="#" class="twitter"><i class="bi bi-twitter-x"></i></a>
      <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
      <a href="https://www.instagram.com/smkbaktinusantara666/?next=%2F&hl=id" class="instagram"><i class="bi bi-instagram"></i></a>
    </div>

  </div>
</header>