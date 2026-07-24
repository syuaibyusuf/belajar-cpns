@extends('layouts.user')

@section('title', 'Paket Soal')
@section('page-title', 'Paket Soal')
@section('breadcrumb')
    <a href="{{ route('home') }}" class="text-purple-600">Home</a> / 
    <a href="{{ route('latihan') }}" class="text-purple-600">Latihan</a> / 
    Paket Soal
@endsection

@section('content')
<style>
    /* Filter Card - Seperti Menu Cepat Dashboard */
    .filter-card {
        transition: all 0.3s ease;
        cursor: pointer;
        border-radius: 16px;
        padding: 20px 12px;
        text-align: center;
        background: white;
        border: 1px solid #f0f0f0;
        display: block;
        text-decoration: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
    }
    
    .filter-card:hover {
        transform: translateY(-5px);
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
    
    .filter-card.active .link-text {
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
    
    /* Package Card */
    .package-card {
        transition: all 0.3s ease;
        border: 1px solid #f0f0f0;
    }
    .package-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        border-color: transparent;
    }
    
    /* Badge Level */
    .badge-hard { background: #fee2e2; color: #dc2626; }
    .badge-medium { background: #fef3c7; color: #d97706; }
    .badge-easy { background: #dcfce7; color: #16a34a; }
    .badge {
        border-radius: 20px;
        padding: 4px 12px;
        font-size: 11px;
        font-weight: 500;
    }
    
    /* Progress Bar */
    .progress-track {
        height: 6px;
        background: #f3f4f6;
        border-radius: 3px;
        overflow: hidden;
    }
    .progress-fill {
        height: 100%;
        border-radius: 3px;
        transition: width 0.3s ease;
    }
    .progress-fill.twk { background: linear-gradient(90deg, #f87171, #dc2626); }
    .progress-fill.tiu { background: linear-gradient(90deg, #60a5fa, #2563eb); }
    .progress-fill.tkp { background: linear-gradient(90deg, #4ade80, #16a34a); }
    .progress-fill.all { background: linear-gradient(90deg, #c084fc, #8b5cf6); }
    
    /* Stat Chip */
    .stat-chip {
        background: #f9fafb;
        border-radius: 20px;
        padding: 4px 12px;
        font-size: 12px;
        color: #4b5563;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    
    /* Button */
    .btn-primary {
        background: #8b5cf6;
        color: white;
        border-radius: 12px;
        padding: 8px 20px;
        font-size: 13px;
        font-weight: 500;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .btn-primary:hover {
        background: #7c3aed;
        transform: scale(1.02);
    }
    
    .cat-icon {
        width: 48px;
        height: 48px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }
    .cat-icon.twk { background: #fee2e2; color: #dc2626; }
    .cat-icon.tiu { background: #dbeafe; color: #2563eb; }
    .cat-icon.tkp { background: #dcfce7; color: #16a34a; }
    
    .badge-new {
        background: #f3e8ff;
        color: #9333ea;
        border-radius: 20px;
        padding: 4px 12px;
        font-size: 11px;
        font-weight: 500;
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
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">📦 Paket Soal</h1>
        <p class="text-gray-500 mt-1">Pilih paket soal yang ingin Anda kerjakan</p>
    </div>

    <!-- Filter Cards - Seperti Menu Cepat Dashboard -->
    @php
        $selectedCategory = request()->get('category', 'all');
        $twkCount = $packagesByCategory['twk']->count();
        $tiuCount = $packagesByCategory['tiu']->count();
        $tkpCount = $packagesByCategory['tkp']->count();
        $totalCount = $twkCount + $tiuCount + $tkpCount;
    @endphp
    
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
        <a href="{{ route('packages.index') }}?category=all" 
           class="filter-card {{ $selectedCategory == 'all' ? 'active' : '' }}">
            <span class="icon">📊</span>
            <span class="title">Semua</span>
            <span class="count">{{ $totalCount }} Paket</span>
            <span class="link-text">Lihat semua →</span>
        </a>
        <a href="{{ route('packages.index') }}?category=twk" 
           class="filter-card {{ $selectedCategory == 'twk' ? 'active' : '' }}">
            <span class="icon">🇮🇩</span>
            <span class="title">TWK</span>
            <span class="count">{{ $twkCount }} Paket</span>
            <span class="link-text">Lihat semua →</span>
        </a>
        <a href="{{ route('packages.index') }}?category=tiu" 
           class="filter-card {{ $selectedCategory == 'tiu' ? 'active' : '' }}">
            <span class="icon">🧠</span>
            <span class="title">TIU</span>
            <span class="count">{{ $tiuCount }} Paket</span>
            <span class="link-text">Lihat semua →</span>
        </a>
        <a href="{{ route('packages.index') }}?category=tkp" 
           class="filter-card {{ $selectedCategory == 'tkp' ? 'active' : '' }}">
            <span class="icon">💼</span>
            <span class="title">TKP</span>
            <span class="count">{{ $tkpCount }} Paket</span>
            <span class="link-text">Lihat semua →</span>
        </a>
    </div>

    <!-- ========== SEMUA PAKET ========== -->
    @if($selectedCategory == 'all')
        <div class="mb-4">
            <div class="flex items-center justify-between mb-5">
                <div class="flex items-center gap-2">
                    <div class="w-1 h-5 bg-purple-500 rounded-full"></div>
                    <span class="text-sm font-medium text-gray-700">📋 Semua Paket</span>
                    <span class="text-xs bg-purple-100 text-purple-600 px-2 py-0.5 rounded-full">{{ $allPackages->count() }} paket</span>
                </div>
                <div class="text-xs text-gray-400">
                    <i class="fas fa-clock mr-1"></i> Diurutkan dari terbaru
                </div>
            </div>
            
            @if($allPackages->count() > 0)
            <div class="space-y-4 fade-in">
                @foreach($allPackages as $package)
                @php
                    $filledCount = $package->questions()->where('question_text', '!=', '')->count();
                    $progressPercent = ($filledCount / $package->total_questions) * 100;
                    
                    if($package->total_questions >= 40) {
                        $level = 'Hard';
                        $levelBadge = 'badge-hard';
                    } elseif($package->total_questions >= 20) {
                        $level = 'Medium';
                        $levelBadge = 'badge-medium';
                    } else {
                        $level = 'Easy';
                        $levelBadge = 'badge-easy';
                    }
                    
                    $catClass = $package->category == 'twk' ? 'twk' : ($package->category == 'tiu' ? 'tiu' : 'tkp');
                    $catIcon = $package->category == 'twk' ? '🇮🇩' : ($package->category == 'tiu' ? '🧠' : '💼');
                    $isNew = $package->created_at->diffInHours(now()) < 24;
                    $rating = number_format(rand(40, 50) / 10, 1);
                    $participants = rand(500, 3000);
                    $timeAgo = $package->created_at->diffForHumans();
                @endphp
                <div class="package-card bg-white rounded-xl p-4 hover:shadow-md transition-all border border-gray-100">
                    <div class="flex flex-col md:flex-row gap-4">
                        <div class="cat-icon {{ $catClass }} flex-shrink-0">
                            {{ $catIcon }}
                        </div>
                        <div class="flex-1">
                            <div class="flex flex-wrap items-center justify-between gap-2 mb-2">
                                <div class="flex flex-wrap items-center gap-2">
                                    <h3 class="font-semibold text-gray-800">{{ $package->name }}</h3>
                                    @if($isNew)<span class="badge-new">✨ Baru</span>@endif
                                    <span class="badge {{ $levelBadge }}">{{ $level }}</span>
                                </div>
                                <span class="text-xs text-gray-400"><i class="far fa-clock mr-1"></i> {{ $timeAgo }}</span>
                            </div>
                            
                            <div class="flex flex-wrap gap-3 mb-3">
                                <span class="stat-chip"><i class="fas fa-layer-group text-purple-400"></i> {{ $package->total_questions }} Soal</span>
                                <span class="stat-chip"><i class="fas fa-star text-yellow-400"></i> {{ $rating }}</span>
                                <span class="stat-chip"><i class="fas fa-users text-blue-400"></i> {{ number_format($participants) }} peserta</span>
                                <span class="stat-chip"><i class="fas fa-bullseye text-green-400"></i> Target {{ $package->total_questions >= 40 ? '85%' : ($package->total_questions >= 20 ? '75%' : '65%') }}</span>
                            </div>
                            
                            <div class="mb-3">
                                <div class="flex justify-between text-xs text-gray-500 mb-1">
                                    <span>Progress</span>
                                    <span>{{ round($progressPercent) }}% ({{ $filledCount }}/{{ $package->total_questions }})</span>
                                </div>
                                <div class="progress-track">
                                    <div class="progress-fill {{ $catClass }}" style="width: {{ $progressPercent }}%"></div>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-3">
                                <a href="{{ route('packages.start', $package->id) }}" class="btn-primary">
                                    ▶️ Mulai Test
                                </a>
                                <button onclick="savePackage({{ $package->id }})" class="btn-outline">
                                    <i class="far fa-bookmark mr-1"></i> Simpan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-12 bg-gray-50 rounded-xl">
                <div class="text-5xl mb-3">📦</div>
                <p class="text-gray-400">Belum ada paket soal</p>
            </div>
            @endif
        </div>

    <!-- ========== FILTER TWK ========== -->
    @elseif($selectedCategory == 'twk')
        @php $packages = $packagesByCategory['twk']; @endphp
        <div>
            <div class="flex items-center gap-2 mb-5">
                <div class="w-1 h-5 bg-red-500 rounded-full"></div>
                <span class="text-sm font-medium text-gray-700">🔴 TWK - Tes Wawasan Kebangsaan</span>
                <span class="text-xs bg-red-100 text-red-600 px-2 py-0.5 rounded-full">{{ $packages->count() }} paket</span>
            </div>
            @include('user.partials.package-items', ['packages' => $packages, 'catClass' => 'twk'])
        </div>

    <!-- ========== FILTER TIU ========== -->
    @elseif($selectedCategory == 'tiu')
        @php $packages = $packagesByCategory['tiu']; @endphp
        <div>
            <div class="flex items-center gap-2 mb-5">
                <div class="w-1 h-5 bg-blue-500 rounded-full"></div>
                <span class="text-sm font-medium text-gray-700">🔵 TIU - Tes Intelegensi Umum</span>
                <span class="text-xs bg-blue-100 text-blue-600 px-2 py-0.5 rounded-full">{{ $packages->count() }} paket</span>
            </div>
            @include('user.partials.package-items', ['packages' => $packages, 'catClass' => 'tiu'])
        </div>

    <!-- ========== FILTER TKP ========== -->
    @elseif($selectedCategory == 'tkp')
        @php $packages = $packagesByCategory['tkp']; @endphp
        <div>
            <div class="flex items-center gap-2 mb-5">
                <div class="w-1 h-5 bg-green-500 rounded-full"></div>
                <span class="text-sm font-medium text-gray-700">🟢 TKP - Tes Karakteristik Pribadi</span>
                <span class="text-xs bg-green-100 text-green-600 px-2 py-0.5 rounded-full">{{ $packages->count() }} paket</span>
            </div>
            @include('user.partials.package-items', ['packages' => $packages, 'catClass' => 'tkp'])
        </div>
    @endif

    <!-- Tips Section -->
    <div class="mt-10 bg-gradient-to-r from-purple-50 to-indigo-50 rounded-xl p-4 border border-purple-100">
        <div class="flex items-start gap-3">
            <div class="text-xl">💡</div>
            <div>
                <h3 class="font-medium text-gray-700 text-sm">Tips Mengerjakan Paket Soal</h3>
                <p class="text-gray-500 text-xs mt-0.5">Kerjakan soal dengan tenang, baca pertanyaan dengan teliti, dan gunakan fitur bookmark untuk paket favorit.</p>
            </div>
        </div>
    </div>
</div>

<script>
    function savePackage(id) {
        let saved = JSON.parse(localStorage.getItem('saved_packages') || '[]');
        if(!saved.includes(id)) {
            saved.push(id);
            localStorage.setItem('saved_packages', JSON.stringify(saved));
            alert('✅ Paket berhasil disimpan!');
        } else {
            alert('📚 Paket sudah tersimpan sebelumnya');
        }
    }
</script>
@endsection