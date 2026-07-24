@extends('layouts.user')

@section('title', $materi->title)
@section('page-title', $materi->title)
@section('breadcrumb')
    <a href="{{ route('home') }}" class="text-purple-600">Home</a> / 
    <a href="{{ route('materi.index') }}" class="text-purple-600">Materi</a> / 
    <a href="{{ route('materi.by-category', $materi->category) }}" class="text-purple-600">{{ strtoupper($materi->category) }}</a> / 
    {{ Str::limit($materi->title, 30) }}
@endsection

@section('content')
<style>
    /* Warna sesuai kategori */
    @if($materi->category == 'twk')
        .hero-pattern { background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 50%, #fecaca 100%); }
        .progress-bar-read { background: linear-gradient(90deg, #ef4444, #dc2626); }
        .border-category { border-left-color: #ef4444; }
        .btn-latihan { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); }
        .btn-latihan:hover { background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%); }
        .text-category { color: #dc2626; }
        .bg-category-light { background: #fef2f2; }
        .tip-box { background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%); border-left-color: #ef4444; }
    @elseif($materi->category == 'tiu')
        .hero-pattern { background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 50%, #bfdbfe 100%); }
        .progress-bar-read { background: linear-gradient(90deg, #3b82f6, #2563eb); }
        .border-category { border-left-color: #3b82f6; }
        .btn-latihan { background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); }
        .btn-latihan:hover { background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); }
        .text-category { color: #2563eb; }
        .bg-category-light { background: #eff6ff; }
        .tip-box { background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); border-left-color: #3b82f6; }
    @else
        .hero-pattern { background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 50%, #bbf7d0 100%); }
        .progress-bar-read { background: linear-gradient(90deg, #10b981, #059669); }
        .border-category { border-left-color: #10b981; }
        .btn-latihan { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
        .btn-latihan:hover { background: linear-gradient(135deg, #059669 0%, #047857 100%); }
        .text-category { color: #059669; }
        .bg-category-light { background: #f0fdf4; }
        .tip-box { background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); border-left-color: #10b981; }
    @endif

    .hero-pattern {
        position: relative;
        overflow: hidden;
        border-radius: 1.5rem;
    }
    .info-card {
        transition: all 0.3s ease;
        background: white;
        border-radius: 16px;
        padding: 12px 24px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    .info-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px -12px rgba(0,0,0,0.15);
    }
    .action-card {
        transition: all 0.3s ease;
    }
    .action-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -12px rgba(0, 0, 0, 0.2);
    }
    .material-content {
        word-break: break-word;
        overflow-wrap: break-word;
        white-space: pre-line;  /* ← KUNCI: Agar enter (newline) terbaca */
        line-height: 1.8;
    }
    .material-content h1, .material-content h2 {
        font-size: 1.5rem;
        font-weight: bold;
        margin-top: 2rem;
        margin-bottom: 1rem;
        color: #1f2937;
        border-left: 4px solid;
        padding-left: 1rem;
        white-space: normal;
    }
    .material-content h3 {
        font-size: 1.25rem;
        font-weight: 600;
        margin-top: 1.5rem;
        margin-bottom: 0.75rem;
        color: #374151;
        white-space: normal;
    }
    .material-content p {
        margin-bottom: 1rem;
        color: #4b5563;
        word-break: break-word;
        overflow-wrap: break-word;
    }
    .material-content ul, .material-content ol {
        margin: 1rem 0;
        padding-left: 1.5rem;
        white-space: normal;
    }
    .material-content li {
        margin-bottom: 0.5rem;
        color: #4b5563;
    }
    .material-content blockquote {
        border-left: 4px solid;
        padding-left: 1rem;
        margin: 1rem 0;
        font-style: italic;
        color: #6b7280;
        white-space: normal;
    }
    .material-content img {
        max-width: 100%;
        height: auto;
        border-radius: 0.75rem;
        margin: 1.5rem auto;
        display: block;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    .progress-container {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 3px;
        background: #e5e7eb;
        z-index: 1000;
    }
    .progress-bar-read {
        width: 0%;
        height: 3px;
        transition: width 0.3s ease;
    }
    .lightbox {
        display: none;
        position: fixed;
        z-index: 1000;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.9);
        justify-content: center;
        align-items: center;
        cursor: pointer;
    }
    .lightbox img {
        max-width: 90%;
        max-height: 90%;
        object-fit: contain;
    }
    .lightbox.active {
        display: flex;
    }
    .tip-box {
        border-left: 4px solid;
        border-radius: 0.75rem;
        padding: 1.25rem;
        margin-top: 1.5rem;
    }
</style>

<!-- Progress Bar Baca -->
<div class="progress-container">
    <div class="progress-bar-read" id="readingProgress"></div>
</div>

<!-- Lightbox untuk gambar -->
<div id="lightbox" class="lightbox" onclick="closeLightbox()">
    <img id="lightboxImg" src="">
</div>

<div class="max-w-5xl mx-auto">
    <!-- Tombol Kembali -->
    <div class="mb-5">
        <a href="{{ route('materi.by-category', $materi->category) }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-800 transition group">
            <i class="fas fa-arrow-left group-hover:-translate-x-1 transition"></i>
            <span>Kembali ke Daftar Materi {{ strtoupper($materi->category) }}</span>
        </a>
    </div>

    <!-- Hero Section -->
    <div class="hero-pattern shadow-xl mb-8">
        <div class="p-6 md:p-8">
            <!-- Badge Kategori -->
            <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-3xl shadow-md">
                        @if($materi->category == 'twk') 🇮🇩
                        @elseif($materi->category == 'tiu') 🧠
                        @else 💼 @endif
                    </div>
                    <div>
                        <span class="text-sm bg-white/80 text-gray-700 px-3 py-1 rounded-full shadow-sm">
                            @if($materi->category == 'twk') TWK - Tes Wawasan Kebangsaan
                            @elseif($materi->category == 'tiu') TIU - Tes Intelegensi Umum
                            @else TKP - Tes Karakteristik Pribadi @endif
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Judul -->
            <h1 class="text-2xl md:text-4xl font-bold mb-4 leading-tight break-all text-gray-800">{{ $materi->title }}</h1>
            
            <!-- Thumbnail -->
            @if($materi->thumbnail)
            <div class="mt-4 flex justify-center">
                <img src="{{ asset('uploads/materi/' . $materi->thumbnail) }}" 
                     alt="Thumbnail {{ $materi->title }}"
                     class="rounded-xl shadow-lg max-w-full max-h-64 object-cover cursor-pointer"
                     onclick="openLightbox(this.src)">
            </div>
            @endif
            
            <!-- Info Cards (Tanggal Upload & Jenis Materi) -->
            <div class="flex flex-wrap justify-center gap-4 mt-6">
                <div class="info-card text-center">
                    <div class="text-2xl mb-1">📅</div>
                    <div class="text-sm font-medium text-gray-500">Tanggal Upload</div>
                    <div class="text-base font-bold text-gray-700">{{ $materi->created_at->translatedFormat('d F Y') }}</div>
                </div>
                <div class="info-card text-center">
                    <div class="text-2xl mb-1">🏷️</div>
                    <div class="text-sm font-medium text-gray-500">Jenis Materi</div>
                    <div class="text-base font-bold text-gray-700">
                        @if($materi->category == 'twk') TWK
                        @elseif($materi->category == 'tiu') TIU
                        @else TKP @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Konten Materi -->
    <div class="bg-white rounded-2xl shadow-sm p-6 md:p-8 mb-8">
        <div class="flex items-center gap-2 mb-5 pb-3 border-b border-gray-100">
            <i class="fas fa-book-open text-gray-600 text-xl"></i>
            <h2 class="text-xl font-bold text-gray-800">📖 Materi Pembahasan</h2>
        </div>
        
        <div class="material-content" id="materialContent">
            {!! $materi->getParsedContent() !!}
        </div>
        
        <!-- Tip Box -->
        <div class="tip-box mt-6">
            <div class="flex items-start gap-3">
                <div class="text-3xl">💡</div>
                <div>
                    <h3 class="font-semibold text-gray-800">Tips Belajar</h3>
                    <p class="text-gray-600 text-sm">Baca materi dengan teliti, catat poin-poin penting, dan klik gambar untuk memperbesar. Kerjakan soal latihan setelah selesai membaca.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Call to Action -->
    <div class="grid md:grid-cols-2 gap-5 mb-8">
        <div class="action-card rounded-2xl p-6 text-white btn-latihan">
            <div class="flex items-start justify-between">
                <div>
                    <div class="text-4xl mb-3">📝</div>
                    <h3 class="text-xl font-bold mb-2">Uji Pemahaman</h3>
                    <p class="text-sm opacity-90 mb-4">Selesai membaca? Yuk kerjakan soal latihan!</p>
                    <div class="flex items-center gap-2 text-sm mb-4">
                        <span class="bg-white/20 px-2 py-1 rounded-full">10-20 Soal</span>
                        <span class="bg-white/20 px-2 py-1 rounded-full">5 Poin/Soal</span>
                    </div>
                    <a href="{{ route('packages.index') }}?category={{ $materi->category }}" class="inline-flex items-center gap-2 bg-white text-gray-800 px-5 py-2 rounded-xl font-semibold hover:shadow-lg transition">
                        Mulai Latihan <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                <div class="text-6xl opacity-20 hidden md:block">
                    <i class="fas fa-pencil-alt"></i>
                </div>
            </div>
        </div>
        
        <div class="action-card bg-white border border-gray-100 rounded-2xl p-6 shadow-sm hover:shadow-lg transition">
            <div class="flex items-start justify-between">
                <div>
                    <div class="text-4xl mb-3">📚</div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Materi Lainnya</h3>
                    <p class="text-sm text-gray-500 mb-4">Pelajari materi lain dalam kategori yang sama</p>
                    <a href="{{ route('materi.by-category', $materi->category) }}" class="inline-flex items-center gap-2 bg-gray-100 text-gray-700 px-5 py-2 rounded-xl font-semibold hover:bg-gray-200 transition">
                        Lihat Semua <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                <div class="text-6xl opacity-20 hidden md:block">
                    <i class="fas fa-book"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Rekomendasi Materi Lain -->
    @if(isset($otherMateri) && $otherMateri->count() > 0)
    <div>
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                <i class="fas fa-star text-yellow-500"></i>
                Rekomendasi Materi Lainnya
            </h3>
            <a href="{{ route('materi.by-category', $materi->category) }}" class="text-gray-600 text-sm hover:underline">Lihat Semua →</a>
        </div>
        <div class="grid md:grid-cols-3 gap-4">
            @foreach($otherMateri as $item)
            @php
                $catColor = ['twk' => 'red', 'tiu' => 'blue', 'tkp' => 'green'];
                $catName = ['twk' => 'TWK', 'tiu' => 'TIU', 'tkp' => 'TKP'];
            @endphp
            <a href="{{ route('materi.detail', $item->id) }}" class="bg-white rounded-xl p-4 border border-gray-100 hover:shadow-md transition group">
                <div class="flex items-center gap-2 mb-2">
                    <span class="text-xl">
                        @if($item->category == 'twk') 🇮🇩
                        @elseif($item->category == 'tiu') 🧠
                        @else 💼 @endif
                    </span>
                    <span class="text-xs px-2 py-0.5 rounded-full bg-{{ $catColor[$item->category] }}-100 text-{{ $catColor[$item->category] }}-600">
                        {{ $catName[$item->category] }}
                    </span>
                </div>
                <h4 class="font-semibold text-gray-800 group-hover:text-gray-600 transition line-clamp-2 break-all">{{ $item->title }}</h4>
                <p class="text-gray-500 text-xs mt-2 line-clamp-2 break-all">{{ Str::limit(strip_tags($item->content), 60) }}</p>
                <div class="mt-3 text-gray-600 text-sm group-hover:underline">Baca →</div>
            </a>
            @endforeach
        </div>
    </div>
    @endif
</div>

<script>
    // Progress Bar Baca
    function updateReadingProgress() {
        const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
        const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const scrolled = (winScroll / height) * 100;
        const progressBar = document.getElementById('readingProgress');
        if(progressBar) {
            progressBar.style.width = scrolled + '%';
        }
    }
    
    window.addEventListener('scroll', updateReadingProgress);
    
    // Lightbox untuk gambar
    function openLightbox(src) {
        const lightbox = document.getElementById('lightbox');
        const lightboxImg = document.getElementById('lightboxImg');
        lightboxImg.src = src;
        lightbox.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
    
    function closeLightbox() {
        const lightbox = document.getElementById('lightbox');
        lightbox.classList.remove('active');
        document.body.style.overflow = '';
    }
    
    // Event listener untuk semua gambar di konten materi
    document.addEventListener('DOMContentLoaded', function() {
        const images = document.querySelectorAll('.material-content img');
        images.forEach(img => {
            img.style.cursor = 'pointer';
            img.addEventListener('click', function() {
                openLightbox(this.src);
            });
        });
    });
</script>
@endsection