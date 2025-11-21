@extends('layouts.app')

@section('title', ($artikel->judul ?? 'Detail') . ' - E-Magazine')

@section('content')
<div class="container">
    <!-- Back Button -->
    <div class="mb-3">
        <button onclick="history.back()" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </button>
    </div>
    
    <div class="row">
        <div class="col-lg-8">
            <div class="single-post">
                <div class="feature-img mb-4">
                    @php
                        $mainImage = 'assets/img/blog/blog-post-1.webp';
                        if (isset($artikel) && $artikel->foto) {
                            if (file_exists(public_path('uploads/' . $artikel->foto))) {
                                $mainImage = 'uploads/' . $artikel->foto;
                            } elseif (file_exists(public_path($artikel->foto))) {
                                $mainImage = $artikel->foto;
                            }
                        } elseif (isset($karya) && $karya->foto && file_exists(public_path($karya->foto))) {
                            $mainImage = $karya->foto;
                        }
                    @endphp
                    <img class="img-fluid" src="{{ asset($mainImage) }}" alt="{{ isset($artikel) ? $artikel->judul : $karya->judul }}" onerror="this.src='{{ asset('assets/img/blog/blog-post-1.webp') }}'">
                </div>
                <div class="blog_details">
                    <h2>{{ isset($artikel) ? $artikel->judul : $karya->judul }}</h2>
                    <ul class="blog-info-link mt-3 mb-4">
                        <li><a href="#"><i class="fa fa-user"></i> {{ isset($artikel) ? 'Admin' : $karya->penulis . ' - ' . $karya->kelas }}</a></li>
                        <li><i class="fa fa-calendar"></i> {{ isset($artikel) ? $artikel->tanggal : $karya->tanggal }}</li>
                        <li><i class="fa fa-tag"></i> {{ isset($artikel) ? ($artikel->kategori->nama_kategori ?? 'Umum') : $karya->kategori }}</li>
                    </ul>
                    <div class="content">
                        <div class="article-content">
                            {!! nl2br(e(isset($artikel) ? $artikel->isi : $karya->isi)) !!}
                        </div>
                    </div>
                    
                    <!-- Like & Share Section -->
                    <div class="engagement-section mt-4 mb-5">
                        <div class="d-flex align-items-center justify-content-between p-3 bg-light rounded">
                            <div class="like-section">
                                @auth
                                    <button id="likeBtn" class="btn btn-link p-0 text-decoration-none {{ $userLiked ? 'text-danger' : 'text-muted' }}" onclick="toggleLike()" style="font-size: 1.2rem;">
                                        <i class="bi {{ $userLiked ? 'bi-heart-fill' : 'bi-heart' }} me-2"></i>
                                        <span id="likeText">{{ $userLiked ? 'Disukai' : 'Suka' }}</span>
                                    </button>
                                @else
                                    <button class="btn btn-link p-0 text-decoration-none text-muted" onclick="alert('Silakan login terlebih dahulu!'); window.location.href='{{ route('login') }}';" style="font-size: 1.2rem;">
                                        <i class="bi bi-heart me-2"></i>
                                        <span>Suka</span>
                                    </button>
                                @endauth
                                <span class="ms-2 text-muted"><span id="likeCount">{{ $likesCount }}</span> orang menyukai ini</span>
                            </div>
                            <div class="share-section">
                                <button class="btn btn-outline-primary btn-sm me-2" onclick="shareArticle()">
                                    <i class="bi bi-share"></i> Bagikan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Comments Section -->
                <div class="comments-section mt-5">
                    <div class="comments-header d-flex align-items-center mb-4">
                        <h4 class="mb-0 me-3"><i class="bi bi-chat-dots me-2"></i>Komentar</h4>
                        <span class="badge bg-primary">{{ isset($artikel->comments) ? $artikel->comments->count() : (isset($karya->comments) ? $karya->comments->count() : 0) }}</span>
                    </div>
                    
                    <!-- Comment Form -->
                    <div class="comment-form-container mb-5">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-white border-0 pb-0">
                                <h6 class="mb-0 text-primary"><i class="bi bi-pencil-square me-2"></i>Tulis Komentar</h6>
                            </div>
                            <div class="card-body">
                                @if(session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif
                                @if(session('error'))
                                    <div class="alert alert-danger">{{ session('error') }}</div>
                                @endif
                                @if($errors->any())
                                    <div class="alert alert-danger">
                                        @foreach($errors->all() as $error)
                                            <div>{{ $error }}</div>
                                        @endforeach
                                    </div>
                                @endif
                                @php
                                    $formAction = '#';
                                    if (isset($artikel) && isset($artikel->id_artikel)) {
                                        try {
                                            $formAction = route('blog.comment', $artikel->id_artikel);
                                        } catch (Exception $e) {
                                            $formAction = '#';
                                        }
                                    } elseif (isset($artikel) && isset($artikel->id_kegiatan)) {
                                        try {
                                            $formAction = route('kegiatan.comment', $artikel->id_kegiatan);
                                        } catch (Exception $e) {
                                            $formAction = '#';
                                        }
                                    } elseif (isset($karya) && isset($karya->id_karya)) {
                                        try {
                                            $formAction = route('karya.comment', $karya->id_karya);
                                        } catch (Exception $e) {
                                            $formAction = '#';
                                        }
                                    }
                                @endphp
                                <!-- Debug: Form Action = {{ $formAction }} -->
                                <!-- Debug: Artikel ID = {{ $artikel->id_artikel ?? 'tidak ada' }} -->
                                <!-- Debug: Kegiatan ID = {{ $artikel->id_kegiatan ?? 'tidak ada' }} -->
                                <!-- Debug: Karya ID = {{ $karya->id_karya ?? 'tidak ada' }} -->
                                <!-- Debug: URL = {{ request()->url() }} -->
                                @auth
                                    <form action="{{ $formAction }}" method="POST">
                                        @csrf
                                        <div class="form-floating mb-3">
                                            <textarea name="comment" class="form-control" id="floatingComment" style="height: 120px" placeholder="Tulis komentar..." required></textarea>
                                            <label for="floatingComment"><i class="bi bi-chat-text me-2"></i>Komentar Anda</label>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary px-4">
                                                <i class="bi bi-send me-2"></i>Kirim Komentar
                                            </button>
                                        </div>
                                    </form>
                                @else
                                    <div class="text-center py-4">
                                        <p class="text-muted mb-3">Silakan login untuk memberikan komentar</p>
                                        <a href="{{ route('login') }}" class="btn btn-primary">
                                            <i class="bi bi-box-arrow-in-right me-2"></i>Login
                                        </a>
                                    </div>
                                @endauth
                            </div>
                        </div>
                    </div>
                    
                    <!-- Comments List -->
                    <div class="comments-list">
                        @php
                            $comments = isset($artikel->comments) ? $artikel->comments : (isset($karya->comments) ? $karya->comments : collect());
                        @endphp
                        @if($comments->count() > 0)
                            @foreach($comments as $comment)
                            <div class="comment-item mb-4">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="comment-avatar me-3">
                                                <div class="bg-gradient" style="background: linear-gradient(45deg, #007bff, #6f42c1); width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 1.2rem;">
                                                    {{ strtoupper(substr($comment->name, 0, 1)) }}
                                                </div>
                                            </div>
                                            <div class="comment-content flex-grow-1">
                                                <div class="d-flex align-items-center mb-2">
                                                    <h6 class="mb-0 me-3 text-primary">{{ $comment->name }}</h6>
                                                    <small class="text-muted">
                                                        <i class="bi bi-clock me-1"></i>
                                                        {{ $comment->created_at->diffForHumans() }}
                                                    </small>
                                                </div>
                                                <p class="mb-0 text-dark" style="line-height: 1.6;">{{ $comment->comment }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="text-center py-5">
                                <i class="bi bi-chat-dots text-muted" style="font-size: 3rem;"></i>
                                <p class="text-muted mt-3">Belum ada komentar. Jadilah yang pertama berkomentar!</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 sidebar">
                <div class="widgets-container">
                    <div class="recent-posts-widget widget-item">
                        <h3 class="widget-title">Artikel Terkait</h3>
                        
                        @foreach($relatedArticles as $related)
                        <div class="post-item">
                            @php
                                $relatedImage = 'assets/img/blog/blog-post-1.webp';
                                if ($related->foto) {
                                    if (file_exists(public_path('uploads/' . $related->foto))) {
                                        $relatedImage = 'uploads/' . $related->foto;
                                    } elseif (file_exists(public_path($related->foto))) {
                                        $relatedImage = $related->foto;
                                    }
                                }
                            @endphp
                            <img src="{{ asset($relatedImage) }}" alt="{{ $related->judul }}" class="flex-shrink-0" onerror="this.src='{{ asset('assets/img/blog/blog-post-1.webp') }}'">
                            <div>
                                @if(isset($artikel) && isset($artikel->id_artikel))
                                    <h4><a href="{{ route('blog.details', $related->id_artikel) }}">{{ $related->judul }}</a></h4>
                                @elseif(isset($artikel) && isset($artikel->id_kegiatan))
                                    <h4><a href="{{ route('kegiatan.details', $related->id_kegiatan) }}">{{ $related->judul }}</a></h4>
                                @elseif(isset($karya))
                                    <h4><a href="{{ route('karya.details', $related->id_karya) }}">{{ $related->judul }}</a></h4>
                                @endif
                                <time datetime="{{ $related->tanggal }}">{{ date('M d, Y', strtotime($related->tanggal)) }}</time>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="categories-widget widget-item">
                        <h3 class="widget-title">Kategori</h3>
                        <ul class="mt-3">
                            @foreach($categories as $category)
                            <li><a href="#">{{ $category->nama_kategori }} <span>({{ $category->artikel_count }})</span></a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
.like-animation {
    animation: likeHeart 0.6s ease-in-out;
}

@keyframes likeHeart {
    0% { transform: scale(1); }
    50% { transform: scale(1.3); }
    100% { transform: scale(1); }
}

.comment-item:hover .card {
    transform: translateY(-2px);
    transition: all 0.3s ease;
}

.engagement-section {
    border-left: 4px solid #007bff;
}
</style>

<script>
function toggleLike() {
    @guest
        alert('Silakan login terlebih dahulu!');
        window.location.href = '{{ route('login') }}';
        return;
    @endguest
    
    const btn = document.getElementById('likeBtn');
    if (!btn) return;
    
    btn.disabled = true;
    
    const likeUrl = '{{ isset($artikel) ? route('blog.like', $artikel->id_artikel) : '#' }}';
    
    if (likeUrl === '#') {
        alert('Error: URL tidak valid');
        btn.disabled = false;
        return;
    }
    
    fetch(likeUrl, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            alert(data.error);
            return;
        }
        
        const icon = btn.querySelector('i');
        const text = document.getElementById('likeText');
        const count = document.getElementById('likeCount');
        
        if (data.liked) {
            btn.className = 'btn btn-link p-0 text-decoration-none text-danger';
            icon.className = 'bi bi-heart-fill me-2';
            text.textContent = 'Disukai';
        } else {
            btn.className = 'btn btn-link p-0 text-decoration-none text-muted';
            icon.className = 'bi bi-heart me-2';
            text.textContent = 'Suka';
        }
        
        count.textContent = data.likes_count;
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan');
    })
    .finally(() => {
        btn.disabled = false;
    });
}

function shareArticle() {
    if (navigator.share) {
        navigator.share({
            title: '{{ isset($artikel) ? $artikel->judul : $karya->judul ?? "Artikel" }}',
            text: 'Baca artikel menarik ini!',
            url: window.location.href
        });
    } else {
        // Fallback: copy to clipboard
        navigator.clipboard.writeText(window.location.href).then(() => {
            alert('Link artikel berhasil disalin!');
        });
    }
}
</script>
@endsection