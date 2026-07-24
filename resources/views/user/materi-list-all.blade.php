@extends('layouts.user')

@section('title', 'Semua Materi')
@section('page-title', 'Semua Materi')
@section('breadcrumb')
    <a href="{{ route('home') }}" class="text-purple-600">Home</a> / Semua Materi
@endsection

@section('content')
<style>
    .filter-card {
        transition: all 0.3s ease;
        cursor: pointer;
        border-radius: 16px;
        padding: 18px 12px;
        text-align: center;
        background: white;
        border: 1px solid #f0f0f0;
        display: block;
        text-decoration: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
    }
    .filter-card:hover {
        transform: translateY(-4px);
        border-color: #e9d5ff;
        box-shadow: 0 10px 25px -12px rgba(139, 92, 246, 0.2);
    }
    .filter-card.active {
        border-color: #8b5cf6;
        background: linear-gradient(135deg, #faf5ff 0%, #f3e8ff 100%);
    }
    .filter-card.active .icon {
        transform: scale(1.05);
    }
    .filter-card.active .title {
        color: #8b5cf6;
    }
    .filter-card .icon {
        font-size: 36px;
        margin-bottom: 12px;
        display: block;
        transition: transform 0.2s ease;
    }
    .filter-card .title {
        font-size: 14px;
        font-weight: 600;
        color: #374151;
        display: block;
        margin-bottom: 4px;
    }
    .filter-card .count {
        font-size: 12px;
        font-weight: 500;
        color: #9ca3af;
        display: block;
        margin-bottom: 12px;
    }
    .filter-card .link-text {
        font-size: 11px;
        font-weight: 500;
        color: #8b5cf6;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: gap 0.2s ease;
    }
    .filter-card:hover .link-text {
        gap: 8px;
    }
    
    /* Material Card - TANPA ISI */
    .material-card {
        transition: all 0.3s ease;
        border: 1px solid #f0f0f0;
        border-radius: 16px;
        background: white;
        overflow: hidden;
    }
    .material-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        border-color: #e9d5ff;
    }
    .category-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }
    .category-twk { background: #fee2e2; color: #dc2626; }
    .category-tiu { background: #dbeafe; color: #2563eb; }
    .category-tkp { background: #dcfce7; color: #16a34a; }
    .date-text {
        font-size: 12px;
        color: #9ca3af;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .material-title {
        font-size: 16px;
        font-weight: 600;
        color: #1f2937;
        margin: 12px 0;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .btn-read {
        font-size: 13px;
        font-weight: 500;
        color: #8b5cf6;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: gap 0.2s;
    }
    .btn-read:hover {
        gap: 8px;
        color: #7c3aed;
    }
    .fade-in {
        animation: fadeIn 0.4s ease-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="w-full">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">📚 Semua Materi Belajar</h1>
        <p class="text-gray-500 mt-1">Pelajari semua materi TWK, TIU, dan TKP di sini</p>
    </div>

    <!-- Filter Cards -->
    @php
        $selectedFilter = request()->get('filter', 'all');
        $twkCount = $allMateri->where('category', 'twk')->count();
        $tiuCount = $allMateri->where('category', 'tiu')->count();
        $tkpCount = $allMateri->where('category', 'tkp')->count();
        $totalCount = $allMateri->count();
    @endphp
    
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
        <a href="{{ route('materi.index') }}?filter=all" 
           class="filter-card {{ $selectedFilter == 'all' ? 'active' : '' }}">
            <span class="icon">📊</span>
            <span class="title">Semua</span>
            <span class="count">{{ $totalCount }} Materi</span>
            <span class="link-text">Lihat semua →</span>
        </a>
        <a href="{{ route('materi.index') }}?filter=twk" 
           class="filter-card {{ $selectedFilter == 'twk' ? 'active' : '' }}">
            <span class="icon">🇮🇩</span>
            <span class="title">TWK</span>
            <span class="count">{{ $twkCount }} Materi</span>
            <span class="link-text">Lihat semua →</span>
        </a>
        <a href="{{ route('materi.index') }}?filter=tiu" 
           class="filter-card {{ $selectedFilter == 'tiu' ? 'active' : '' }}">
            <span class="icon">🧠</span>
            <span class="title">TIU</span>
            <span class="count">{{ $tiuCount }} Materi</span>
            <span class="link-text">Lihat semua →</span>
        </a>
        <a href="{{ route('materi.index') }}?filter=tkp" 
           class="filter-card {{ $selectedFilter == 'tkp' ? 'active' : '' }}">
            <span class="icon">💼</span>
            <span class="title">TKP</span>
            <span class="count">{{ $tkpCount }} Materi</span>
            <span class="link-text">Lihat semua →</span>
        </a>
    </div>

    <!-- Stats Ringkas -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-xl p-4 text-center shadow-sm">
            <div class="text-2xl font-bold text-purple-600">{{ $materi->count() }}</div>
            <div class="text-xs text-gray-500">Materi Ditampilkan</div>
        </div>
        <div class="bg-white rounded-xl p-4 text-center shadow-sm">
            <div class="text-2xl font-bold text-red-600">{{ $materi->where('category', 'twk')->count() }}</div>
            <div class="text-xs text-gray-500">Materi TWK</div>
        </div>
        <div class="bg-white rounded-xl p-4 text-center shadow-sm">
            <div class="text-2xl font-bold text-blue-600">{{ $materi->where('category', 'tiu')->count() }}</div>
            <div class="text-xs text-gray-500">Materi TIU</div>
        </div>
        <div class="bg-white rounded-xl p-4 text-center shadow-sm">
            <div class="text-2xl font-bold text-green-600">{{ $materi->where('category', 'tkp')->count() }}</div>
            <div class="text-xs text-gray-500">Materi TKP</div>
        </div>
    </div>

    <!-- Daftar Materi (TANPA ISI) -->
    @if($materi->count() > 0)
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5 fade-in">
        @foreach($materi as $item)
        @php
            $icons = ['twk' => '🇮🇩', 'tiu' => '🧠', 'tkp' => '💼'];
            $categoryNames = ['twk' => 'TWK', 'tiu' => 'TIU', 'tkp' => 'TKP'];
            $categoryClasses = ['twk' => 'category-twk', 'tiu' => 'category-tiu', 'tkp' => 'category-tkp'];
            $borderColors = ['twk' => 'hover:border-red-200', 'tiu' => 'hover:border-blue-200', 'tkp' => 'hover:border-green-200'];
        @endphp
        <div class="material-card p-4 {{ $borderColors[$item->category] }}">
            <div class="flex items-center justify-between mb-3">
                <div class="flex items-center gap-2">
                    <span class="text-xl">{{ $icons[$item->category] }}</span>
                    <span class="category-badge {{ $categoryClasses[$item->category] }}">
                        {{ $categoryNames[$item->category] }}
                    </span>
                </div>
                <div class="date-text">
                    <i class="far fa-calendar-alt"></i>
                    <span>{{ $item->created_at->format('d M Y') }}</span>
                </div>
            </div>
            <h3 class="material-title">{{ $item->title }}</h3>
            <div class="mt-4 pt-3 border-t border-gray-100">
                <a href="{{ route('materi.detail', $item->id) }}" class="btn-read">
                    Baca Selengkapnya <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="bg-white rounded-xl p-12 text-center border border-dashed border-gray-200">
        <i class="fas fa-book-open text-5xl text-gray-300 mb-3 block"></i>
        <p class="text-gray-400">Belum ada materi.</p>
        <a href="{{ route('latihan') }}" class="inline-block mt-4 text-purple-600">← Kembali ke Latihan</a>
    </div>
    @endif
</div>
@endsection