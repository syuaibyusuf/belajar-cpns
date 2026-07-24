@extends('layouts.user')

@section('title', $categoryInfo['name'])
@section('page-title', $categoryInfo['name'])
@section('breadcrumb')
    <a href="{{ route('home') }}" class="text-purple-600">Home</a> / 
    <a href="{{ route('materi.index') }}" class="text-purple-600">Materi</a> / 
    {{ $categoryInfo['name'] }}
@endsection

@section('content')
<style>
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
    .quick-test-btn {
        transition: all 0.3s ease;
    }
    .quick-test-btn:hover {
        transform: translateX(4px);
    }
</style>

<div class="max-w-5xl mx-auto">
    <!-- Header -->
    <div class="flex items-center gap-3 mb-6">
        <div class="text-5xl">{{ $categoryInfo['icon'] }}</div>
        <div>
            <h1 class="text-2xl font-bold text-gray-800">{{ $categoryInfo['name'] }}</h1>
            <p class="text-gray-500 text-sm mt-1">Pelajari semua materi {{ $categoryInfo['name'] }} untuk persiapan ujian</p>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-3 gap-3 mb-6">
        <div class="bg-white rounded-xl p-3 text-center shadow-sm">
            <div class="text-xl font-bold text-{{ $categoryInfo['color'] }}-600">{{ $materiList->count() }}</div>
            <div class="text-xs text-gray-500">Total Materi</div>
        </div>
        <div class="bg-white rounded-xl p-3 text-center shadow-sm">
            <div class="text-xl font-bold text-{{ $categoryInfo['color'] }}-600">{{ rand(500, 3000) }}</div>
            <div class="text-xs text-gray-500">Total Dibaca</div>
        </div>
        <div class="bg-white rounded-xl p-3 text-center shadow-sm">
            <div class="text-xl font-bold text-{{ $categoryInfo['color'] }}-600">4.8</div>
            <div class="text-xs text-gray-500">Rating ⭐</div>
        </div>
    </div>

    <!-- Quick Test Button -->
    <div class="bg-gradient-to-r from-{{ $categoryInfo['color'] }}-50 to-{{ $categoryInfo['color'] }}-100 rounded-xl p-4 mb-6 flex justify-between items-center">
        <div>
            <span class="text-sm font-semibold text-{{ $categoryInfo['color'] }}-700">🚀 Siap Uji Pemahaman?</span>
            <p class="text-xs text-gray-500 mt-0.5">Kerjakan soal latihan setelah belajar</p>
        </div>
        <a href="{{ route('packages.index') }}?category={{ $category }}" class="quick-test-btn bg-{{ $categoryInfo['color'] }}-500 text-white px-4 py-2 rounded-lg hover:bg-{{ $categoryInfo['color'] }}-600 transition text-sm">
            Mulai Test →
        </a>
    </div>

    <!-- Daftar Materi (TANPA ISI) -->
    @if($materiList->count() > 0)
    <div class="space-y-4">
        @foreach($materiList as $item)
        <div class="material-card p-4">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-3">
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="text-xl">{{ $categoryInfo['icon'] }}</span>
                        <span class="category-badge category-{{ $categoryInfo['color'] }}">
                            {{ strtoupper($category) }}
                        </span>
                    </div>
                    <h3 class="font-semibold text-gray-800 text-md">{{ $item->title }}</h3>
                </div>
                <div class="flex items-center gap-4">
                    <div class="date-text">
                        <i class="far fa-calendar-alt"></i>
                        <span>{{ $item->created_at->format('d M Y') }}</span>
                    </div>
                    <a href="{{ route('materi.detail', $item->id) }}" class="btn-read">
                        Baca <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="bg-white rounded-xl p-12 text-center border border-dashed border-gray-200">
        <i class="fas fa-book-open text-5xl text-gray-300 mb-3 block"></i>
        <p class="text-gray-400">Belum ada materi untuk kategori {{ $categoryInfo['name'] }}</p>
        <a href="{{ route('latihan') }}" class="inline-block mt-4 text-purple-600">← Kembali ke Latihan</a>
    </div>
    @endif

    <!-- Tips Belajar -->
    <div class="mt-8 bg-gradient-to-r from-{{ $categoryInfo['color'] }}-50 to-{{ $categoryInfo['color'] }}-100 rounded-xl p-5">
        <h3 class="font-semibold text-gray-800 mb-2">💡 Tips Belajar {{ $categoryInfo['name'] }}</h3>
        <ul class="space-y-1 text-sm text-gray-600">
            @if($category == 'twk')
            <li><i class="fas fa-check-circle text-green-500 mr-2"></i> Pahami sejarah dan makna setiap sila Pancasila</li>
            <li><i class="fas fa-check-circle text-green-500 mr-2"></i> Hafalkan pasal-pasal penting dalam UUD 1945</li>
            <li><i class="fas fa-check-circle text-green-500 mr-2"></i> Pelajari lambang negara dan filosofinya</li>
            @elseif($category == 'tiu')
            <li><i class="fas fa-check-circle text-green-500 mr-2"></i> Perbanyak kosa kata untuk soal sinonim/antonim</li>
            <li><i class="fas fa-check-circle text-green-500 mr-2"></i> Latih kemampuan hitung cepat untuk soal numerik</li>
            <li><i class="fas fa-check-circle text-green-500 mr-2"></i> Biasakan mencari pola dalam deret angka</li>
            @else
            <li><i class="fas fa-check-circle text-green-500 mr-2"></i> Pilih jawaban yang mencerminkan integritas tinggi</li>
            <li><i class="fas fa-check-circle text-green-500 mr-2"></i> Utamakan pelayanan publik dan kerja sama tim</li>
            <li><i class="fas fa-check-circle text-green-500 mr-2"></i> Jawab dengan konsisten sesuai nilai-nilai ASN</li>
            @endif
        </ul>
    </div>
</div>
@endsection