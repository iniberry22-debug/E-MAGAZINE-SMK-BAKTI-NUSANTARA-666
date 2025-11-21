@extends('layouts.app')

@section('title', 'Home - E-Magazine')

@section('content')

    <!-- Poster Sekolah Section -->
    @if($posterSekolah->count() > 0)
    <section id="poster-sekolah" class="latest-posts section bg-light">
      <div class="container section-title" data-aos="fade-up">
        <span class="description-title">Poster & Pengumuman</span>
        <h2>Poster & Pengumuman</h2>
        <p>Poster dan pengumuman terbaru dari SMK Bakti Nusantara 666</p>
      </div>
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="position-relative">
          <div class="poster-slider-container overflow-hidden" style="width: 100%; max-width: 400px; margin: 0 auto;">
            <div class="poster-slider d-flex" id="posterSlider">
              @foreach($posterSekolah as $index => $poster)
              <div class="poster-slide flex-shrink-0" style="width: 100%;">
                <article class="card-post h-100">
                  <div class="post-img position-relative overflow-hidden">
                    <img src="{{ asset('uploads/' . $poster->foto) }}" class="img-fluid w-100" alt="{{ $poster->judul }}" loading="lazy" style="height: 250px; object-fit: cover;">
                    <div class="category-badge position-absolute top-0 start-0 m-2 bg-success text-white px-2 py-1 rounded">{{ $poster->kategori }}</div>
                  </div>
                  <div class="content p-3">
                    <h5 class="title mb-2">{{ $poster->judul }}</h5>
                    <div class="meta d-flex align-items-center text-muted small">
                      <i class="bi bi-person me-1"></i>
                      <span class="me-3">{{ $poster->user->nama ?? 'Siswa' }}</span>
                      <i class="bi bi-calendar me-1"></i>
                      <span>{{ $poster->created_at->format('d M Y') }}</span>
                    </div>
                  </div>
                </article>
              </div>
              @endforeach
            </div>
          </div>
          @if($posterSekolah->count() > 1)
          <button class="btn btn-primary position-absolute top-50 start-0 translate-middle-y" id="prevBtn" style="z-index: 10;">
            <i class="bi bi-chevron-left"></i>
          </button>
          <button class="btn btn-primary position-absolute top-50 end-0 translate-middle-y" id="nextBtn" style="z-index: 10;">
            <i class="bi bi-chevron-right"></i>
          </button>
          @endif
        </div>
      </div>
    </section>
    @endif

    <!-- Artikel Kegiatan Section -->
    @if($kegiatanPosts->count() > 0)
    <section id="artikel-kegiatan" class="latest-posts section">
      <div class="container section-title" data-aos="fade-up">
        <span class="description-title">Kegiatan Sekolah</span>
        <h2>Kegiatan Sekolah</h2>
        <p>Artikel tentang kegiatan dan aktivitas di SMK Bakti Nusantara 666</p>
      </div>
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4">
          @foreach($kegiatanPosts as $index => $artikel)
          <div class="col-lg-4" data-aos="fade-up" data-aos-delay="{{ 200 + ($index * 50) }}">
            <article class="card-post h-100">
              <div class="post-img position-relative overflow-hidden">
                <a href="{{ route('blog.details', $artikel->id_artikel) }}">
                  <img src="{{ asset($artikel->foto ? 'uploads/' . $artikel->foto : 'assets/img/blog/blog-post-square-1.webp') }}" class="img-fluid w-100" alt="Post image" loading="lazy">
                </a>
              </div>
              <div class="content">
                <div class="meta d-flex align-items-center flex-wrap gap-2">
                  <span class="cat-badge">{{ $artikel->kategori->nama_kategori ?? 'Kegiatan' }}</span>
                  <div class="d-flex align-items-center ms-auto">
                    <i class="bi bi-person"></i><span class="ps-2">{{ $artikel->user->nama ?? 'Admin' }}</span>
                  </div>
                </div>
                <h3 class="title">{{ $artikel->judul }}</h3>
                <p>{{ Str::substr(strip_tags($artikel->isi), 0, 100) }}</p>
                <a href="{{ route('blog.details', $artikel->id_artikel) }}" class="readmore"><span>Baca Selengkapnya</span><i class="bi bi-arrow-right"></i></a>
              </div>
            </article>
          </div>
          @endforeach
        </div>
      </div>
    </section>
    @endif

    <!-- Artikel Siswa Section -->
    @if($artikelSiswa->count() > 0)
    <section id="artikel-siswa" class="latest-posts section">
      <div class="container section-title" data-aos="fade-up">
        <span class="description-title">Karya Siswa</span>
        <h2>Karya Siswa</h2>
        <p>Artikel dan tulisan kreatif dari siswa-siswi SMK Bakti Nusantara 666</p>
      </div>
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4">
          @foreach($artikelSiswa as $index => $artikel)
          <div class="col-lg-4" data-aos="fade-up" data-aos-delay="{{ 200 + ($index * 50) }}">
            <article class="card-post h-100">
              <div class="post-img position-relative overflow-hidden">
                <a href="{{ route('blog.details', $artikel->id_artikel) }}">
                  <img src="{{ asset($artikel->foto ? 'uploads/' . $artikel->foto : 'assets/img/blog/blog-post-square-1.webp') }}" class="img-fluid w-100" alt="Post image" loading="lazy">
                </a>
              </div>
              <div class="content">
                <div class="meta d-flex align-items-center flex-wrap gap-2">
                  <span class="cat-badge">{{ $artikel->kategori->nama_kategori ?? 'Artikel Siswa' }}</span>
                  <div class="d-flex align-items-center ms-auto">
                    <i class="bi bi-person"></i><span class="ps-2">{{ $artikel->user->nama ?? 'Siswa' }}</span>
                  </div>
                </div>
                <h3 class="title">{{ $artikel->judul }}</h3>
                <p>{{ Str::substr(strip_tags($artikel->isi), 0, 100) }}</p>
                <a href="{{ route('blog.details', $artikel->id_artikel) }}" class="readmore"><span>Baca Selengkapnya</span><i class="bi bi-arrow-right"></i></a>
              </div>
            </article>
          </div>
          @endforeach
        </div>
      </div>
    </section>
    @endif

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const slider = document.getElementById('posterSlider');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    
    if (slider && prevBtn && nextBtn) {
        let currentSlide = 0;
        const totalSlides = slider.children.length;
        
        nextBtn.addEventListener('click', function() {
            if (currentSlide < totalSlides - 1) {
                currentSlide++;
            } else {
                currentSlide = 0;
            }
            slider.style.transform = `translateX(-${currentSlide * 100}%)`;
        });
        
        prevBtn.addEventListener('click', function() {
            if (currentSlide > 0) {
                currentSlide--;
            } else {
                currentSlide = totalSlides - 1;
            }
            slider.style.transform = `translateX(-${currentSlide * 100}%)`;
        });
        
        slider.style.transition = 'transform 0.3s ease';
    }
});
</script>
@endpush 