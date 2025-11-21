@extends('layouts.app')

@section('title', 'Category - E-Magazine')

@section('content')
  <!-- Category Section Section -->
    <section id="category-section" class="category-section section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <span class="description-title">Category Section</span>
        <h2>Category Section</h2>
        <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <!-- Main Featured Post -->
        <div class="row gy-4 mb-5">
          <div class="col-lg-8">
            <article class="hero-post" data-aos="zoom-out" data-aos-delay="200">
              <div class="post-img">
                <img src="assets/img/blog/blog-post-5.webp" alt="" class="img-fluid" loading="lazy">
              </div>
              <div class="post-content">
                <div class="author-info">
                  <img src="assets/img/person/person-m-8.webp" alt="" class="author-avatar">
                  <div class="author-details">
                    <span class="author-name">Michael R.</span>
                    <span class="post-date">15 March 2024</span>
                  </div>
                </div>
                <h2 class="post-title">
                  <a href="blog-details.html">Lorem ipsum dolor sit amet, consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore</a>
                </h2>
                <p class="post-excerpt">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
                <div class="post-stats">
                  <span class="read-time"><i class="bi bi-clock"></i> 5 min read</span>
                  <span class="comments"><i class="bi bi-chat-dots"></i> 12 comments</span>
                </div>
              </div>
            </article>
          </div>

          <div class="col-lg-4">
            <div class="sidebar-posts">
              <article class="sidebar-post" data-aos="fade-left" data-aos-delay="300">
                <div class="post-img">
                  <img src="assets/img/blog/blog-post-8.webp" alt="" class="img-fluid" loading="lazy">
                </div>
                <div class="post-content">
                  <span class="post-category">Design</span>
                  <h4 class="title">
                    <a href="blog-details.html">Neque porro quisquam est qui dolorem ipsum quia dolor sit amet</a>
                  </h4>
                  <div class="post-meta">
                    <span class="post-date">22 February 2024</span>
                  </div>
                </div>
              </article>

              <article class="sidebar-post" data-aos="fade-left" data-aos-delay="400">
                <div class="post-img">
                  <img src="assets/img/blog/blog-post-4.webp" alt="" class="img-fluid" loading="lazy">
                </div>
                <div class="post-content">
                  <span class="post-category">Business</span>
                  <h4 class="title">
                    <a href="blog-details.html">Ut enim ad minima veniam quis nostrum exercitationem ullam</a>
                  </h4>
                  <div class="post-meta">
                    <span class="post-date">18 January 2024</span>
                  </div>
                </div>
              </article>

              <article class="sidebar-post" data-aos="fade-left" data-aos-delay="500">
                <div class="post-img">
                  <img src="assets/img/blog/blog-post-1.webp" alt="" class="img-fluid" loading="lazy">
                </div>
                <div class="post-content">
                  <span class="post-category">Lifestyle</span>
                  <h4 class="title">
                    <a href="blog-details.html">Excepteur sint occaecat cupidatat non proident sunt in culpa</a>
                  </h4>
                  <div class="post-meta">
                    <span class="post-date">10 December 2023</span>
                  </div>
                </div>
              </article>

              <article class="sidebar-post" data-aos="fade-left" data-aos-delay="600">
                <div class="post-img">
                  <img src="assets/img/blog/blog-post-3.webp" alt="" class="img-fluid" loading="lazy">
                </div>
                <div class="post-content">
                  <span class="post-category">Tech</span>
                  <h4 class="title">
                    <a href="blog-details.html">At vero eos et accusamus et iusto odio dignissimos ducimus</a>
                  </h4>
                  <div class="post-meta">
                    <span class="post-date">5 November 2023</span>
                  </div>
                </div>
              </article>
            </div>
          </div>
        </div>
@endsection