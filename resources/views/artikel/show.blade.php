@extends('layouts.app')

@section('title', $artikel->judul . ' - Masjid Al-Ikhlas')

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

    .article-hero {
        background: linear-gradient(135deg, rgba(46, 125, 50, 0.9) 0%, rgba(76, 175, 80, 0.8) 100%);
        color: white;
        padding: 80px 0 60px;
        position: relative;
        overflow: hidden;
    }

    .article-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }

    .article-header {
        position: relative;
        z-index: 2;
    }

    .article-image {
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        max-height: 500px;
        object-fit: cover;
        width: 100%;
        margin-bottom: 2rem;
    }

    .article-content {
        font-size: 1.125rem;
        line-height: 1.8;
        color: #2d3748;
    }

    .article-content h2 {
        color: var(--primary-green);
        margin: 2.5rem 0 1.5rem;
        font-weight: 700;
        font-size: 1.75rem;
    }

    .article-content h3 {
        color: var(--primary-green);
        margin: 2rem 0 1rem;
        font-weight: 600;
        font-size: 1.5rem;
    }

    .article-content p {
        margin-bottom: 1.5rem;
        text-align: justify;
    }

    .article-content blockquote {
        border-left: 4px solid var(--secondary-green);
        padding: 1.5rem 2rem;
        margin: 2rem 0;
        font-style: italic;
        color: #4a5568;
        background: var(--light-green);
        border-radius: 0 var(--border-radius) var(--border-radius) 0;
        position: relative;
    }

    .article-content blockquote::before {
        content: '"';
        font-size: 4rem;
        color: var(--secondary-green);
        position: absolute;
        left: 1rem;
        top: -1rem;
        opacity: 0.3;
        font-family: serif;
    }

    .article-content img {
        max-width: 100%;
        height: auto;
        border-radius: var(--border-radius);
        margin: 2rem 0;
        box-shadow: var(--box-shadow);
    }

    .article-content ul, .article-content ol {
        margin: 1.5rem 0;
        padding-left: 2rem;
    }

    .article-content li {
        margin-bottom: 0.5rem;
    }

    .article-meta {
        display: flex;
        align-items: center;
        gap: 2rem;
        margin-bottom: 2rem;
        flex-wrap: wrap;
    }

    .article-meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: white;
        font-size: 0.95rem;
    }

    .article-meta-item i {
        font-size: 1.1rem;
    }

    .author-card {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        padding: 2rem;
        margin: 3rem 0;
        border-left: 4px solid var(--secondary-green);
    }

    .author-info {
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

    .author-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid var(--light-green);
    }

    .share-buttons {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .share-btn {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        border: 2px solid #e2e8f0;
        border-radius: 25px;
        background: white;
        color: #4a5568;
        text-decoration: none;
        transition: var(--transition);
        font-weight: 500;
    }

    .share-btn:hover {
        transform: translateY(-2px);
        box-shadow: var(--box-shadow);
    }

    .share-btn.facebook:hover {
        background: #1877f2;
        color: white;
        border-color: #1877f2;
    }

    .share-btn.twitter:hover {
        background: #1da1f2;
        color: white;
        border-color: #1da1f2;
    }

    .share-btn.whatsapp:hover {
        background: #25d366;
        color: white;
        border-color: #25d366;
    }

    .share-btn.link:hover {
        background: var(--secondary-green);
        color: white;
        border-color: var(--secondary-green);
    }

    .related-article-card {
        border: none;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        transition: var(--transition);
        overflow: hidden;
        height: 100%;
        background: white;
    }

    .related-article-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15);
    }

    .related-article-image {
        height: 200px;
        object-fit: cover;
        transition: var(--transition);
        width: 100%;
    }

    .related-article-card:hover .related-article-image {
        transform: scale(1.08);
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

    @media (max-width: 768px) {
        .article-hero {
            padding: 60px 0 40px;
        }

        .article-meta {
            gap: 1rem;
        }

        .author-info {
            flex-direction: column;
            text-align: center;
        }

        .share-buttons {
            justify-content: center;
        }
    }
</style>
@endpush

@section('content')

<!-- Article Hero -->
<section class="article-hero mb-5">
    <div class="container">
        <div class="article-header">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h1 class="display-6 fw-bold mb-4">{{ $artikel->judul }}</h1>
                    <div class="article-meta justify-content-center">
                        <div class="article-meta-item">
                            <i class="bi bi-person"></i>
                            <span>{{ $artikel->penulis ?? 'Admin Masjid' }}</span>
                        </div>
                        <div class="article-meta-item">
                            <i class="bi bi-calendar"></i>
                            <span>{{ $artikel->tanggal_posting->translatedFormat('d F Y') }}</span>
                        </div>
                        <div class="article-meta-item">
                            <i class="bi bi-clock"></i>
                            <span>{{ $artikel->tanggal_posting->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container py-4">
    <div class="row justify-content-center">
        <!-- Article Content -->
        <div class="col-lg-8">
            <article class="article-content">
                @if($artikel->foto_cover)
                    <img src="{{ asset('storage/' . $artikel->foto_cover) }}"
                         alt="{{ $artikel->judul }}"
                         class="article-image">
                @endif

                {!! $artikel->isi !!}
            </article>

            <!-- Author Info -->
            <div class="author-card">
                <div class="author-info">
                    <div>
                        <h5 class="fw-bold text-success mb-2">{{ $artikel->penulis ?? 'Admin Masjid' }}</h5>
                        <p class="text-muted mb-2">Penulis artikel di Blog Masjid Al-Ikhlas. Berbagi ilmu dan inspirasi untuk kemajuan umat.</p>
                        <div class="d-flex gap-2">
                            <a href="#" class="btn btn-outline-success btn-sm">
                                <i class="bi bi-facebook"></i>
                            </a>
                            <a href="#" class="btn btn-outline-success btn-sm">
                                <i class="bi bi-twitter"></i>
                            </a>
                            <a href="#" class="btn btn-outline-success btn-sm">
                                <i class="bi bi-instagram"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Share Article -->
            <div class="d-flex flex-column gap-3 mt-5 pt-4 border-top">
                <h5 class="fw-bold text-success">Bagikan Artikel Ini</h5>
                <div class="share-buttons">
                    <a href="#" class="share-btn facebook">
                        <i class="bi bi-facebook"></i>
                        <span>Facebook</span>
                    </a>
                    <a href="#" class="share-btn twitter">
                        <i class="bi bi-twitter"></i>
                        <span>Twitter</span>
                    </a>
                    <a href="#" class="share-btn whatsapp">
                        <i class="bi bi-whatsapp"></i>
                        <span>WhatsApp</span>
                    </a>
                    <a href="#" class="share-btn link" id="copyLink">
                        <i class="bi bi-link-45deg"></i>
                        <span>Copy Link</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- About Widget -->
            <div class="sidebar-widget">
                <h4 class="widget-title">Tentang Penulis</h4>
                    <h6 class="fw-bold text-success">{{ $artikel->penulis ?? 'Admin Masjid' }}</h6>
                    <p class="text-muted small">
                        Penulis aktif di Blog Masjid Al-Ikhlas. Berbagi ilmu dan inspirasi melalui tulisan.
                    </p>
                </div>
            </div>

            <!-- Recent Posts -->
            <div class="sidebar-widget">
                <h4 class="widget-title">Artikel Terbaru</h4>
                <div class="recent-posts">
                    @foreach($artikel_terbaru as $artikel_item)
                        <div class="recent-post">
                            <img src="{{ $artikel_item->foto_cover ? asset('storage/' . $artikel_item->foto_cover) : asset('images/default-article.jpg') }}"
                                 alt="{{ $artikel_item->judul }}"
                                 class="recent-post-image">
                            <div class="recent-post-content">
                                <h6 class="fw-bold">
                                    <a href="{{ route('artikel.show', $artikel_item->slug) }}" class="text-dark text-decoration-none">
                                        {{ Str::limit($artikel_item->judul, 50) }}
                                    </a>
                                </h6>
                                <div class="recent-post-meta">
                                    <i class="bi bi-calendar"></i> {{ $artikel_item->tanggal_posting->format('d M Y') }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Related Articles -->
    @if($artikel_terkait->count() > 0)
        <div class="row mt-5">
            <div class="col-12">
                <h3 class="fw-bold text-success mb-4">Artikel Terkait</h3>
                <div class="row g-4">
                    @foreach($artikel_terkait as $related)
                        <div class="col-lg-4 col-md-6">
                            <div class="card related-article-card h-100">
                                <div class="position-relative">
                                    <img src="{{ $related->foto_cover ? asset('storage/' . $related->foto_cover) : asset('images/default-article.jpg') }}"
                                         class="card-img-top related-article-image"
                                         alt="{{ $related->judul }}">
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <h6 class="card-title fw-bold text-dark">
                                        <a href="{{ route('artikel.show', $related->slug) }}" class="text-dark text-decoration-none">
                                            {{ Str::limit($related->judul, 60) }}
                                        </a>
                                    </h6>
                                    <p class="card-text text-muted small flex-grow-1">
                                        {{ Str::limit(strip_tags($related->isi), 100) }}
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center mt-auto">
                                        <small class="text-muted">
                                            {{ $related->tanggal_posting->format('d M Y') }}
                                        </small>
                                        <a href="{{ route('artikel.show', $related->slug) }}" class="btn btn-outline-success btn-sm">
                                            Baca
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Copy link functionality
        const copyLinkBtn = document.getElementById('copyLink');
        if (copyLinkBtn) {
            copyLinkBtn.addEventListener('click', function(e) {
                e.preventDefault();
                const url = window.location.href;

                navigator.clipboard.writeText(url).then(function() {
                    const originalHTML = this.innerHTML;
                    this.innerHTML = '<i class="bi bi-check"></i><span>Link Disalin!</span>';
                    this.style.background = 'var(--secondary-green)';
                    this.style.color = 'white';
                    this.style.borderColor = 'var(--secondary-green)';

                    setTimeout(() => {
                        this.innerHTML = originalHTML;
                        this.style.background = '';
                        this.style.color = '';
                        this.style.borderColor = '';
                    }, 2000);
                }.bind(this));
            });
        }

        // Social share buttons
        const shareButtons = document.querySelectorAll('.share-btn:not(#copyLink)');
        shareButtons.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const url = encodeURIComponent(window.location.href);
                const title = encodeURIComponent('{{ $artikel->judul }}');
                const text = encodeURIComponent('{{ Str::limit(strip_tags($artikel->isi), 100) }}');

                let shareUrl;
                if (this.classList.contains('facebook')) {
                    shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
                } else if (this.classList.contains('twitter')) {
                    shareUrl = `https://twitter.com/intent/tweet?url=${url}&text=${title}`;
                } else if (this.classList.contains('whatsapp')) {
                    shareUrl = `https://wa.me/?text=${title}%20${url}`;
                }

                if (shareUrl) {
                    window.open(shareUrl, '_blank', 'width=600,height=400');
                }
            });
        });

        // Add reading time estimation
        const articleContent = document.querySelector('.article-content');
        if (articleContent) {
            const text = articleContent.textContent || articleContent.innerText;
            const wordCount = text.trim().split(/\s+/).length;
            const readingTime = Math.ceil(wordCount / 200); // 200 words per minute

            const readingTimeElement = document.createElement('div');
            readingTimeElement.className = 'article-meta-item';
            readingTimeElement.innerHTML = `<i class="bi bi-clock"></i><span>${readingTime} menit baca</span>`;

            const articleMeta = document.querySelector('.article-meta');
            if (articleMeta) {
                articleMeta.appendChild(readingTimeElement);
            }
        }
    });
</script>
@endpush
