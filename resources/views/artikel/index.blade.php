@extends('layouts.app')

@section('title', 'Artikel - Masjid Al-Ikhlas')

@push('styles')
<style>
    :root {
        --primary-green: #2e7d32;
        --secondary-green: #4caf50;
        --light-green: #e8f5e9;
        --text-dark: #1b1b1b;
        --border-radius: 12px;
        --box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        --transition: all 0.3s ease;
    }

    .hero-artikel {
        background: linear-gradient(135deg, rgba(46, 125, 50, 0.9) 0%, rgba(76, 175, 80, 0.8) 100%),
                    url('{{ asset('images/artikel-bg.jpg') }}') center/cover no-repeat;
        color: white;
        padding: 100px 0 80px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .hero-artikel::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.3);
    }

    .hero-content {
        position: relative;
        z-index: 2;
    }

    .article-card {
        border: none;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        transition: var(--transition);
        overflow: hidden;
        height: 100%;
        background: white;
    }

    .article-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
    }

    .article-image {
        height: 240px;
        object-fit: cover;
        transition: var(--transition);
        width: 100%;
    }

    .article-card:hover .article-image {
        transform: scale(1.08);
    }

    .article-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: var(--secondary-green);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-size: 0.8rem;
        font-weight: 600;
        backdrop-filter: blur(10px);
    }

    .article-meta {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
        flex-wrap: wrap;
    }

    .article-meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #666;
        font-size: 0.9rem;
    }

    .article-meta-item i {
        color: var(--secondary-green);
    }

    .category-badge {
        background: var(--light-green);
        color: var(--primary-green);
        padding: 0.3rem 0.8rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
        display: inline-block;
        margin-bottom: 1rem;
    }

    .sidebar-widget {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    .widget-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--primary-green);
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 3px solid var(--light-green);
        position: relative;
    }

    .widget-title::after {
        content: '';
        position: absolute;
        bottom: -3px;
        left: 0;
        width: 50px;
        height: 3px;
        background: var(--secondary-green);
    }

    .recent-post {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        padding: 1rem 0;
        border-bottom: 1px solid #f0f0f0;
        transition: var(--transition);
    }

    .recent-post:last-child {
        border-bottom: none;
    }

    .recent-post:hover {
        transform: translateX(5px);
    }

    .recent-post-image {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
        flex-shrink: 0;
    }

    .recent-post-content h6 {
        margin-bottom: 0.5rem;
        line-height: 1.4;
    }

    .recent-post-meta {
        font-size: 0.8rem;
        color: #666;
    }

    .search-box {
        position: relative;
        margin-bottom: 1rem;
    }

    .search-box input {
        width: 100%;
        padding: 0.75rem 1rem 0.75rem 3rem;
        border: 2px solid #e0e0e0;
        border-radius: 25px;
        transition: var(--transition);
    }

    .search-box input:focus {
        border-color: var(--secondary-green);
        box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
    }

    .search-box i {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #666;
    }

    .pagination {
        justify-content: center;
        margin-top: 3rem;
    }

    .page-link {
        color: var(--primary-green);
        border: 1px solid #dee2e6;
        margin: 0 0.25rem;
        border-radius: 8px;
        padding: 0.75rem 1rem;
        transition: var(--transition);
    }

    .page-item.active .page-link {
        background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
        border-color: var(--primary-green);
        color: white;
    }

    .page-link:hover {
        color: var(--primary-green);
        background-color: var(--light-green);
        border-color: var(--secondary-green);
    }

    .featured-article {
        position: relative;
        border-radius: var(--border-radius);
        overflow: hidden;
        margin-bottom: 3rem;
        box-shadow: var(--box-shadow);
    }

    .featured-article img {
        width: 100%;
        height: 400px;
        object-fit: cover;
    }

    .featured-content {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(transparent, rgba(0, 0, 0, 0.8));
        color: white;
        padding: 2rem;
    }

    .featured-badge {
        background: var(--secondary-green);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-size: 0.8rem;
        font-weight: 600;
        display: inline-block;
        margin-bottom: 1rem;
    }

    @media (max-width: 768px) {
        .hero-artikel {
            padding: 80px 0 60px;
        }

        .article-image {
            height: 200px;
        }

        .featured-article img {
            height: 300px;
        }

        .featured-content {
            padding: 1.5rem;
        }
    }
</style>
@endpush

@section('content')

<!-- Hero Section -->
<section class="hero-artikel mb-5">
    <div class="container">
        <div class="hero-content">
            <h1 class="display-5 fw-bold mb-3">Artikel & Berita</h1>
            <p class="lead mb-4">Kumpulan artikel islami, berita masjid, dan tulisan bermanfaat untuk menambah wawasan keislaman</p>
        </div>
    </div>
</section>

<div class="container py-4">
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Featured Article -->
            @if($artikels->count() > 0)
                @php $featured = $artikels->first(); @endphp
                <div class="featured-article">
                    <img src="{{ $featured->foto_cover ? asset('storage/' . $featured->foto_cover) : asset('images/default-article.jpg') }}"
                         alt="{{ $featured->judul }}">
                    <div class="featured-content">
                        <span class="featured-badge">Featured</span>
                        <h2 class="h3 fw-bold mb-3">{{ $featured->judul }}</h2>
                        <div class="d-flex flex-wrap gap-3 text-white-50">
                            <span><i class="bi bi-person me-1"></i>{{ $featured->penulis ?? 'Admin Masjid' }}</span>
                            <span><i class="bi bi-calendar me-1"></i>{{ $featured->tanggal_posting->format('d M Y') }}</span>
                        </div>
                        <a href="{{ route('artikel.show', $featured->slug) }}" class="btn btn-success mt-3">
                            Baca Selengkapnya
                        </a>
                    </div>
                </div>
            @endif

            <!-- Articles Grid -->
            <div class="row g-4">
                @forelse($artikels->skip(1) as $artikel)
                    <div class="col-lg-6">
                        <div class="card article-card h-100">
                            <div class="position-relative">
                                <img src="{{ $artikel->foto_cover ? asset('storage/' . $artikel->foto_cover) : asset('images/default-article.jpg') }}"
                                     class="card-img-top article-image"
                                     alt="{{ $artikel->judul }}">
                                <div class="article-badge">
                                    {{ $artikel->tanggal_posting->format('d M') }}
                                </div>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <div class="article-meta">
                                    <div class="article-meta-item">
                                        <i class="bi bi-person"></i>
                                        <span>{{ $artikel->penulis ?? 'Admin Masjid' }}</span>
                                    </div>
                                    <div class="article-meta-item">
                                        <i class="bi bi-clock"></i>
                                        <span>{{ $artikel->tanggal_posting->diffForHumans() }}</span>
                                    </div>
                                </div>

                                <h5 class="card-title fw-bold text-dark mb-3">
                                    <a href="{{ route('artikel.show', $artikel->slug) }}" class="text-dark text-decoration-none">
                                        {{ Str::limit($artikel->judul, 70) }}
                                    </a>
                                </h5>

                                <p class="card-text text-muted flex-grow-1">
                                    {{ Str::limit(strip_tags($artikel->isi), 120) }}
                                </p>

                                <div class="d-flex justify-content-between align-items-center mt-auto pt-3 border-top">
                                    <a href="{{ route('artikel.show', $artikel->slug) }}" class="btn btn-outline-success btn-sm">
                                        Baca Selengkapnya
                                    </a>
                                    <small class="text-muted">
                                        <i class="bi bi-eye me-1"></i>1.2k
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="text-center py-5">
                            <i class="bi bi-journal-text display-1 text-muted mb-3"></i>
                            <h4 class="text-muted">Belum ada artikel</h4>
                            <p class="text-muted">Silakan kembali lagi nanti untuk membaca artikel terbaru.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($artikels->hasPages())
                <div class="d-flex justify-content-center mt-5">
                    {{ $artikels->links() }}
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- About Widget -->
            <div class="sidebar-widget">
                <h4 class="widget-title">Tentang Blog</h4>
                <p class="text-muted mb-3">
                    Blog resmi Masjid Al-Ikhlas menyajikan artikel islami, berita kegiatan,
                    dan tulisan bermanfaat untuk meningkatkan keimanan dan ketakwaan.
                </p>
                <div class="d-flex gap-2">
                    <a href="#" class="btn btn-outline-success btn-sm">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="#" class="btn btn-outline-success btn-sm">
                        <i class="bi bi-instagram"></i>
                    </a>
                    <a href="#" class="btn btn-outline-success btn-sm">
                        <i class="bi bi-youtube"></i>
                    </a>
                    <a href="#" class="btn btn-outline-success btn-sm">
                        <i class="bi bi-telegram"></i>
                    </a>
                </div>
            </div>

            <!-- Recent Posts -->
            <div class="sidebar-widget">
                <h4 class="widget-title">Artikel Terbaru</h4>
                <div class="recent-posts">
                    @foreach($artikel_terbaru as $artikel)
                        <div class="recent-post">
                            <img src="{{ $artikel->foto_cover ? asset('storage/' . $artikel->foto_cover) : asset('images/default-article.jpg') }}"
                                 alt="{{ $artikel->judul }}"
                                 class="recent-post-image">
                            <div class="recent-post-content">
                                <h6 class="fw-bold">
                                    <a href="{{ route('artikel.show', $artikel->slug) }}" class="text-dark text-decoration-none">
                                        {{ Str::limit($artikel->judul, 50) }}
                                    </a>
                                </h6>
                                <div class="recent-post-meta">
                                    <i class="bi bi-calendar"></i> {{ $artikel->tanggal_posting->format('d M Y') }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {

        // Add hover effects to recent posts
        const recentPosts = document.querySelectorAll('.recent-post');
        recentPosts.forEach(post => {
            post.addEventListener('mouseenter', function() {
                this.style.backgroundColor = 'var(--light-green)';
                this.style.paddingLeft = '0.5rem';
            });

            post.addEventListener('mouseleave', function() {
                this.style.backgroundColor = '';
                this.style.paddingLeft = '';
            });
        });
    });
</script>
@endpush
