@extends('layouts.app')

@section('title', 'Hasil Pencarian - E-Magazine')

@section('content')

    <!-- Page Title -->
    <div class="page-title">
      <div class="heading">
        <div class="container">
          <div class="row d-flex justify-content-center text-center">
            <div class="col-lg-8">
              <h1 class="heading-title">Hasil Pencarian</h1>
              <p class="mb-0">Ditemukan {{ $paginator->total() }} hasil</p>
            </div>
          </div>
        </div>
      </div>
      <nav class="breadcrumbs">
        <div class="container">
          <ol>
            <li><a href="{{ route('home') }}">Home</a></li>
            <li class="current">Hasil Pencarian</li>
          </ol>
        </div>
      </nav>
    </div><!-- End Page Title -->

    <!-- Search Results Posts Section -->
    <section id="search-results-posts" class="search-results-posts section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4">

          @forelse($paginator as $result)
          <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
            <article class="card-post h-100">
              <div class="post-img position-relative overflow-hidden">
                @if($result->type == 'artikel')
                  <a href="{{ route('blog.details', $result->id) }}">
                    <img src="{{ asset($result->foto ? 'uploads/' . $result->foto : 'assets/img/blog/blog-post-square-1.webp') }}" class="img-fluid w-100" alt="Post image" loading="lazy">
                  </a>
                @else
                  <a href="{{ route('karya.details', $result->id) }}">
                    <img src="{{ asset('assets/img/blog/blog-post-square-1.webp') }}" class="img-fluid w-100" alt="Post image" loading="lazy">
                  </a>
                @endif
              </div>
              <div class="content">
                <div class="meta d-flex align-items-center flex-wrap gap-2">
                  <span class="cat-badge">{{ $result->kategori ?? 'Artikel' }}</span>
                  <div class="d-flex align-items-center ms-auto">
                    <i class="bi bi-person"></i><span class="ps-2">{{ $result->penulis ?? 'Admin' }}</span>
                  </div>
                </div>
                <h3 class="title">{{ $result->judul }}</h3>
                <p>{{ Str::limit(strip_tags($result->isi), 100) }}</p>
                @if($result->type == 'artikel')
                  <a href="{{ route('blog.details', $result->id) }}" class="readmore"><span>Baca Selengkapnya</span><i class="bi bi-arrow-right"></i></a>
                @else
                  <a href="{{ route('karya.details', $result->id) }}" class="readmore"><span>Baca Selengkapnya</span><i class="bi bi-arrow-right"></i></a>
                @endif
              </div>
            </article>
          </div>
          @empty
          <div class="col-12">
            <div class="text-center py-5">
              <h3>Tidak ada hasil ditemukan</h3>
              <p>Coba gunakan kata kunci yang berbeda</p>
            </div>
          </div>
          @endforelse

        </div>
        
        <!-- Pagination -->
        @if($paginator->hasPages())
        <div class="row">
          <div class="col-12">
            <div class="d-flex justify-content-center mt-4">
              {{ $paginator->appends(request()->query())->links('custom.pagination') }}
            </div>
          </div>
        </div>
        @endif
      </div>

    </section><!-- /Search Results Posts Section -->

@endsection