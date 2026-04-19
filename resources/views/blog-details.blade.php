@extends('layouts.app')

@section('title', $artikel->judul . ' - E-Magazine')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-8">
            <div class="single-post">
                <div class="feature-img mb-4">
                    <img class="img-fluid" src="{{ asset('assets/img/blog/' . $artikel->gambar) }}" alt="{{ $artikel->judul }}">
                </div>
                <div class="blog_details">
                    <h2>{{ $artikel->judul }}</h2>
                    <ul class="blog-info-link mt-3 mb-4">
                        <li><a href="#"><i class="fa fa-user"></i> {{ $artikel->penulis }}</a></li>
                        <li><i class="fa fa-calendar"></i> {{ $artikel->tanggal_publish }}</li>
                        <li><i class="fa fa-tag"></i> {{ $artikel->kategori }}</li>
                        <li><i class="fa fa-eye"></i> {{ $artikel->views }} views</li>
                    </ul>
                    <div class="content">
                        <p class="lead mb-4">{{ $artikel->excerpt }}</p>
                        <div class="article-content">
                            {!! $artikel->konten !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 sidebar">
                <div class="widgets-container">
                    <div class="recent-posts-widget widget-item">
                        <h3 class="widget-title">Artikel Terkait</h3>
                        
                        @php
                            $relatedPosts = \App\Models\Artikel::where('id', '!=', $artikel->id)
                                ->where('kategori', $artikel->kategori)
                                ->limit(4)
                                ->get();
                        @endphp
                        
                        @foreach($relatedPosts as $post)
                        <div class="post-item">
                            <img src="{{ asset('assets/img/blog/' . $post->gambar) }}" alt="{{ $post->judul }}" class="flex-shrink-0">
                            <div>
                                <h4><a href="{{ route('blog.details', $post->id) }}">{{ $post->judul }}</a></h4>
                                <time datetime="{{ $post->tanggal_publish }}">{{ $post->tanggal_publish }}</time>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="categories-widget widget-item">
                        <h3 class="widget-title">Kategori</h3>
                        <ul class="mt-3">
                            <li><a href="#">Ekstrakurikuler <span>(5)</span></a></li>
                            <li><a href="#">Business <span>(3)</span></a></li>
                            <li><a href="#">Technology <span>(8)</span></a></li>
                            <li><a href="#">Leadership <span>(2)</span></a></li>
                            <li><a href="#">Innovation <span>(4)</span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection