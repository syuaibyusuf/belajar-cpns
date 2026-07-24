@extends('layouts.user')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@push('styles')
<style>
    .menu-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }
    .menu-card::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(139,92,246,0.08) 0%, transparent 50%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .menu-card:hover::after { opacity: 1; }
    .menu-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 25px -12px rgba(139, 92, 246, 0.2);
    }
    .menu-icon-wrap {
        transition: all 0.3s ease;
    }
    .menu-card:hover .menu-icon-wrap {
        transform: scale(1.12);
    }
    .progress-bar {
        transition: width 1s ease;
    }
    .recent-material-card {
        transition: all 0.3s ease;
        border: 1px solid #f0f0f0;
        border-radius: 16px;
        background: white;
        overflow: hidden;
    }
    .recent-material-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 24px -8px rgba(0,0,0,0.08);
        border-color: #c4b5fd;
    }
    .category-badge {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.03em;
    }
    .category-twk { background: #fee2e2; color: #dc2626; }
    .category-tiu { background: #dbeafe; color: #2563eb; }
    .category-tkp { background: #dcfce7; color: #16a34a; }
    .material-title {
        font-size: 15px;
        font-weight: 600;
        color: #1f2937;
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
    .btn-read:hover { gap: 8px; color: #7c3aed; }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-6px); }
    }
    .float-anim { animation: float 3s ease-in-out infinite; }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(18px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .fade-in-up { animation: fadeInUp 0.5s ease-out forwards; }
    .d1 { animation-delay: 0.05s; }
    .d2 { animation-delay: 0.1s; }
    .d3 { animation-delay: 0.15s; }
    .d4 { animation-delay: 0.2s; }

    .stat-card {
        transition: all 0.3s ease;
    }
    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 20px -8px rgba(0,0,0,0.06);
    }
</style>
@endpush

@section('content')
<!-- 1. WELCOME BANNER -->
<div class="bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-600 rounded-2xl p-6 md:p-8 mb-8 text-white shadow-xl relative overflow-hidden">
    <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/5 rounded-full blur-2xl"></div>
    <div class="absolute -bottom-8 -left-8 w-32 h-32 bg-white/5 rounded-full blur-xl"></div>
    <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <span class="text-3xl float-anim">🎯</span>
                <h1 class="text-2xl md:text-3xl font-bold">Selamat Datang!</h1>
            </div>
            <p class="text-purple-100 text-sm md:text-base">Terus semangat belajar dan raih impianmu menjadi ASN</p>
        </div>
        <div class="flex gap-3">
            <div class="bg-white/15 backdrop-blur-md rounded-xl px-5 py-3 text-center border border-white/10">
                <div class="text-2xl font-bold">{{ $totalDikerjakan ?? 0 }}</div>
                <div class="text-[11px] text-purple-200 mt-0.5">Soal Dikerjakan</div>
            </div>
            <div class="bg-white/15 backdrop-blur-md rounded-xl px-5 py-3 text-center border border-white/10">
                <div class="text-2xl font-bold">{{ $totalSoal ?? 0 }}</div>
                <div class="text-[11px] text-purple-200 mt-0.5">Total Soal</div>
            </div>
        </div>
    </div>
</div>

<!-- 2. QUICK MENU -->
<div class="mb-10">
    <div class="flex items-center gap-2 mb-4">
        <span class="w-1.5 h-6 bg-purple-600 rounded-full"></span>
        <h2 class="text-lg font-bold text-gray-800">Menu Cepat</h2>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <a href="{{ route('packages.index') }}" class="menu-card fade-in-up d1 bg-white rounded-2xl p-5 shadow-sm border border-gray-100 text-center">
            <div class="menu-icon-wrap w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center text-white text-2xl mx-auto mb-3 shadow-lg shadow-purple-200">
                <i class="fas fa-bolt"></i>
            </div>
            <h3 class="font-bold text-gray-800 text-sm">Latihan Soal</h3>
            <p class="text-xs text-gray-400 mt-1">Kerjakan soal per paket</p>
            <div class="mt-3 text-purple-600 text-xs font-semibold group-hover:opacity-100">Mulai <i class="fas fa-arrow-right ml-1 text-[10px]"></i></div>
        </a>

        <a href="{{ route('materi.index') }}" class="menu-card fade-in-up d2 bg-white rounded-2xl p-5 shadow-sm border border-gray-100 text-center">
            <div class="menu-icon-wrap w-16 h-16 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-2xl flex items-center justify-center text-white text-2xl mx-auto mb-3 shadow-lg shadow-blue-200">
                <i class="fas fa-book-open"></i>
            </div>
            <h3 class="font-bold text-gray-800 text-sm">Materi Belajar</h3>
            <p class="text-xs text-gray-400 mt-1">Pelajari materi lengkap</p>
            <div class="mt-3 text-blue-600 text-xs font-semibold">Lihat <i class="fas fa-arrow-right ml-1 text-[10px]"></i></div>
        </a>

        <a href="{{ route('tryouts.index') }}" class="menu-card fade-in-up d3 bg-white rounded-2xl p-5 shadow-sm border border-gray-100 text-center">
            <div class="menu-icon-wrap w-16 h-16 bg-gradient-to-br from-amber-500 to-orange-500 rounded-2xl flex items-center justify-center text-white text-2xl mx-auto mb-3 shadow-lg shadow-amber-200">
                <i class="fas fa-trophy"></i>
            </div>
            <h3 class="font-bold text-gray-800 text-sm">Try Out CAT</h3>
            <p class="text-xs text-gray-400 mt-1">Simulasi 110 soal</p>
            <div class="mt-3 text-amber-600 text-xs font-semibold">Mulai <i class="fas fa-arrow-right ml-1 text-[10px]"></i></div>
        </a>

        <a href="{{ route('feedback.page') }}" class="menu-card fade-in-up d4 bg-white rounded-2xl p-5 shadow-sm border border-gray-100 text-center">
            <div class="menu-icon-wrap w-16 h-16 bg-gradient-to-br from-emerald-500 to-teal-500 rounded-2xl flex items-center justify-center text-white text-2xl mx-auto mb-3 shadow-lg shadow-emerald-200">
                <i class="fas fa-comment-dots"></i>
            </div>
            <h3 class="font-bold text-gray-800 text-sm">Saran & Masukan</h3>
            <p class="text-xs text-gray-400 mt-1">Bantu kami lebih baik</p>
            <div class="mt-3 text-emerald-600 text-xs font-semibold">Kirim <i class="fas fa-arrow-right ml-1 text-[10px]"></i></div>
        </a>
    </div>
</div>

<!-- 3. PROGRESS + STATS -->
<div class="grid lg:grid-cols-5 gap-6 mb-8">
    <div class="lg:col-span-3 bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between mb-5">
            <div class="flex items-center gap-2">
                <span class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center text-purple-600"><i class="fas fa-chart-line text-sm"></i></span>
                <h2 class="font-bold text-gray-800">Progres Belajar</h2>
            </div>
            <span class="text-xs text-gray-400 bg-gray-50 px-3 py-1 rounded-full border">Target {{ $totalSoal ?? 0 }} soal</span>
        </div>

        @php $totalProgress = $totalSoal > 0 ? round(($totalDikerjakan ?? 0) / $totalSoal * 100) : 0; @endphp
        <div class="mb-6">
            <div class="flex justify-between text-sm text-gray-600 mb-1.5">
                <span class="font-medium">Keseluruhan</span>
                <span class="font-bold {{ $totalProgress >= 80 ? 'text-emerald-600' : ($totalProgress >= 50 ? 'text-amber-600' : 'text-gray-600') }}">{{ $totalProgress }}%</span>
            </div>
            <div class="w-full bg-gray-100 rounded-full h-3 overflow-hidden shadow-inner">
                <div class="h-full rounded-full transition-all duration-1000 ease-out
                    {{ $totalProgress >= 80 ? 'bg-gradient-to-r from-emerald-500 to-green-500' : ($totalProgress >= 50 ? 'bg-gradient-to-r from-amber-400 to-orange-500' : 'bg-gradient-to-r from-purple-500 to-pink-500') }}"
                    style="width: {{ $totalProgress }}%"></div>
            </div>
            <p class="text-xs text-gray-400 mt-1.5">{{ $totalDikerjakan ?? 0 }} dari {{ $totalSoal ?? 0 }} soal telah dikerjakan</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            @foreach(['twk' => ['TWK', '🇮🇩', 'red', 'from-red-500 to-rose-500', 'bg-red-50'],
                     'tiu' => ['TIU', '🧠', 'blue', 'from-blue-500 to-cyan-500', 'bg-blue-50'],
                     'tkp' => ['TKP', '💼', 'emerald', 'from-emerald-500 to-teal-500', 'bg-emerald-50']] as $cat => [$label, $icon, $color, $gradient, $bgColor])
            @php $cd = $statistik[$cat] ?? ['persentase' => 0, 'dikerjakan' => 0, 'total' => 0, 'nilai' => 0]; @endphp
            <div class="stat-card {{ $bgColor }} rounded-xl p-3.5">
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center gap-1.5">
                        <span>{{ $icon }}</span>
                        <span class="font-semibold text-gray-700 text-sm">{{ $label }}</span>
                    </div>
                    <span class="text-xs font-bold text-{{ $color }}-600">{{ $cd['persentase'] }}%</span>
                </div>
                <div class="w-full bg-white/60 rounded-full h-2 mb-2">
                    <div class="bg-gradient-to-r {{ $gradient }} h-2 rounded-full progress-bar" style="width: {{ $cd['persentase'] }}%"></div>
                </div>
                <div class="flex justify-between text-[11px] text-gray-500">
                    <span>{{ $cd['dikerjakan'] }}/{{ $cd['total'] }} soal</span>
                    <span>Nilai: {{ $cd['nilai'] }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- TEST TERAKHIR -->
    <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center gap-2 mb-5">
            <span class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center text-indigo-600"><i class="fas fa-clock-rotate text-sm"></i></span>
            <h2 class="font-bold text-gray-800">Test Terakhir</h2>
        </div>
        @if(!empty($recentTests))
        <div class="space-y-3">
            @foreach($recentTests as $cat => $test)
            @php
                $icons = ['twk' => '🇮🇩', 'tiu' => '🧠', 'tkp' => '💼'];
                $colors = ['twk' => ['bg' => 'bg-red-50', 'text' => 'text-red-600', 'bar' => 'bg-red-500'],
                           'tiu' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-600', 'bar' => 'bg-blue-500'],
                           'tkp' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-600', 'bar' => 'bg-emerald-500']];
                $c = $colors[$cat] ?? $colors['twk'];
                $scorePercent = $test['total'] > 0 ? round(($test['score'] / ($test['total'] * 5)) * 100) : 0;
            @endphp
            <div class="stat-card {{ $c['bg'] }} rounded-xl p-4">
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center gap-2">
                        <span class="text-lg">{{ $icons[$cat] }}</span>
                        <span class="font-semibold text-gray-700 text-sm uppercase">{{ $cat }}</span>
                    </div>
                    <span class="text-sm font-bold {{ $c['text'] }}">{{ $test['score'] }}/{{ $test['total'] * 5 }}</span>
                </div>
                <div class="w-full bg-white/70 rounded-full h-2">
                    <div class="{{ $c['bar'] }} h-2 rounded-full progress-bar" style="width: {{ $scorePercent }}%"></div>
                </div>
                <p class="text-[11px] text-gray-400 mt-1.5"><i class="far fa-clock mr-1"></i>{{ $test['date'] }}</p>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-8 text-gray-400">
            <i class="fas fa-inbox text-3xl block mb-2 text-gray-300"></i>
            <p class="text-sm">Belum ada test</p>
            <p class="text-xs mt-1">Mulai kerjakan soal sekarang!</p>
        </div>
        @endif
    </div>
</div>

<!-- 4. MATERI TERBARU -->
<div class="bg-white rounded-2xl shadow-sm p-6 mb-8 border border-gray-100">
    <div class="flex items-center justify-between mb-5">
        <div class="flex items-center gap-2">
            <span class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center text-purple-600"><i class="fas fa-graduation-cap text-sm"></i></span>
            <h2 class="font-bold text-gray-800">Materi Terbaru</h2>
        </div>
        <a href="{{ route('materi.index') }}" class="text-xs text-purple-600 font-medium hover:text-purple-700 transition">Lihat Semua <i class="fas fa-chevron-right ml-1 text-[10px]"></i></a>
    </div>

    @if(isset($materi) && $materi->count() > 0)
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($materi->take(3) as $item)
        @php
            $categoryIcons = ['twk' => '🇮🇩', 'tiu' => '🧠', 'tkp' => '💼'];
            $categoryNames = ['twk' => 'TWK', 'tiu' => 'TIU', 'tkp' => 'TKP'];
            $categoryClasses = ['twk' => 'category-twk', 'tiu' => 'category-tiu', 'tkp' => 'category-tkp'];
        @endphp
        <div class="recent-material-card p-4">
            <div class="flex items-center justify-between mb-3">
                <span class="category-badge {{ $categoryClasses[$item->category] }}">
                    {{ $categoryIcons[$item->category] }} {{ $categoryNames[$item->category] }}
                </span>
                <span class="text-[11px] text-gray-400 flex items-center gap-1">
                    <i class="far fa-calendar-alt"></i>
                    {{ $item->created_at->format('d M Y') }}
                </span>
            </div>
            <div class="material-title">{{ $item->title }}</div>
            <div class="mt-4 pt-3 border-t border-gray-50 flex items-center justify-between">
                <a href="{{ route('materi.detail', $item->id) }}" class="btn-read text-xs">
                    Baca <i class="fas fa-arrow-right text-[10px]"></i>
                </a>
                <span class="text-[11px] text-gray-300"><i class="far fa-file-lines"></i></span>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="text-center py-10 text-gray-400">
        <i class="fas fa-book-open text-4xl block mb-3 text-gray-300"></i>
        <p class="text-sm">Belum ada materi</p>
        <p class="text-xs mt-1">Materi akan segera hadir</p>
    </div>
    @endif
</div>

<!-- 5. TIPS + MOTIVASI -->
<div class="grid md:grid-cols-2 gap-5 mb-8">
    <div class="bg-gradient-to-br from-purple-50 to-indigo-50 rounded-2xl p-5 border border-purple-100">
        <div class="flex gap-3">
            <span class="text-2xl flex-shrink-0">💡</span>
            <div>
                <h3 class="font-bold text-gray-800 text-sm">Tips Hari Ini</h3>
                <p class="text-gray-600 text-sm mt-1 leading-relaxed">Bacalah soal dengan teliti sebelum menjawab. Kerjakan soal yang mudah terlebih dahulu, lalu lanjutkan ke soal yang lebih sulit.</p>
            </div>
        </div>
    </div>
    <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-2xl p-5 border border-amber-100">
        <div class="flex gap-3">
            <span class="text-2xl flex-shrink-0">🔥</span>
            <div>
                <h3 class="font-bold text-gray-800 text-sm">Semangat!</h3>
                <p class="text-gray-600 text-sm mt-1 leading-relaxed">Konsistensi adalah kunci sukses. Latihan 30 menit setiap hari lebih baik daripada 5 jam sekali seminggu.</p>
            </div>
        </div>
    </div>
</div>
@endsection