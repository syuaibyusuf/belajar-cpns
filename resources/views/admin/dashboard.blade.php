@extends('layouts.admin')

@section('title', 'Dashboard')
@section('header', 'Dashboard Admin')

@push('styles')
<style>
    .stat-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    .stat-icon {
        transition: all 0.3s ease;
    }
    .stat-card:hover .stat-icon {
        transform: scale(1.1) rotate(-5deg);
    }
    .menu-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }
    .menu-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(255,255,255,0.15) 0%, transparent 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .menu-card:hover::before {
        opacity: 1;
    }
    .menu-card:hover {
        transform: translateY(-6px) scale(1.02);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }
    .menu-icon {
        transition: all 0.3s ease;
    }
    .menu-card:hover .menu-icon {
        transform: scale(1.15);
    }
    .recent-item {
        transition: all 0.2s ease;
    }
    .recent-item:hover {
        background: linear-gradient(135deg, #f5f3ff 0%, #ede9fe 100%);
        transform: translateX(4px);
    }
    .badge-category {
        font-size: 0.65rem;
        letter-spacing: 0.05em;
    }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .fade-in-up {
        animation: fadeInUp 0.5s ease-out forwards;
    }
    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.2s; }
    .delay-3 { animation-delay: 0.3s; }
    .delay-4 { animation-delay: 0.4s; }
    .delay-5 { animation-delay: 0.5s; }
</style>
@endpush

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
    <div class="stat-card fade-in-up delay-1 bg-white rounded-2xl p-5 shadow-sm border-l-4 border-purple-500 cursor-default">
        <div class="flex items-center gap-4">
            <div class="stat-icon w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center text-purple-600 text-xl">
                <i class="fas fa-book"></i>
            </div>
            <div>
                <div class="text-2xl font-bold text-gray-800">{{ $totalMateri ?? 0 }}</div>
                <div class="text-xs text-gray-500 font-medium uppercase tracking-wide">Total Materi</div>
            </div>
        </div>
    </div>
    <div class="stat-card fade-in-up delay-2 bg-white rounded-2xl p-5 shadow-sm border-l-4 border-blue-500 cursor-default">
        <div class="flex items-center gap-4">
            <div class="stat-icon w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600 text-xl">
                <i class="fas fa-question-circle"></i>
            </div>
            <div>
                <div class="text-2xl font-bold text-gray-800">{{ $totalSoal ?? 0 }}</div>
                <div class="text-xs text-gray-500 font-medium uppercase tracking-wide">Total Soal</div>
            </div>
        </div>
    </div>
    <div class="stat-card fade-in-up delay-3 bg-white rounded-2xl p-5 shadow-sm border-l-4 border-indigo-500 cursor-default">
        <div class="flex items-center gap-4">
            <div class="stat-icon w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center text-indigo-600 text-xl">
                <i class="fas fa-box"></i>
            </div>
            <div>
                <div class="text-2xl font-bold text-gray-800">{{ $totalPackages ?? 0 }}</div>
                <div class="text-xs text-gray-500 font-medium uppercase tracking-wide">Total Paket</div>
            </div>
        </div>
    </div>
    <div class="stat-card fade-in-up delay-4 bg-white rounded-2xl p-5 shadow-sm border-l-4 border-emerald-500 cursor-default">
        <div class="flex items-center gap-4">
            <div class="stat-icon w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center text-emerald-600 text-xl">
                <i class="fas fa-users"></i>
            </div>
            <div>
                <div class="text-2xl font-bold text-gray-800">{{ $totalUserSessions ?? 0 }}</div>
                <div class="text-xs text-gray-500 font-medium uppercase tracking-wide">User Aktif</div>
            </div>
        </div>
    </div>
    <div class="stat-card fade-in-up delay-5 bg-white rounded-2xl p-5 shadow-sm border-l-4 border-orange-500 cursor-default">
        <div class="flex items-center gap-4">
            <div class="stat-icon w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center text-orange-600 text-xl">
                <i class="fas fa-clipboard-list"></i>
            </div>
            <div>
                <div class="text-2xl font-bold text-gray-800">{{ $totalTestDiikuti ?? 0 }}</div>
                <div class="text-xs text-gray-500 font-medium uppercase tracking-wide">Test Diikuti</div>
            </div>
        </div>
    </div>
</div>

<!-- Menu Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
    <a href="{{ route('admin.materi.index') }}" class="menu-card group bg-white rounded-2xl p-6 shadow-sm border border-purple-100">
        <div class="menu-icon w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center text-white text-2xl shadow-lg shadow-purple-200 mb-4">
            <i class="fas fa-book"></i>
        </div>
        <h3 class="font-bold text-lg text-gray-800 group-hover:text-purple-600 transition-colors">Manajemen Materi</h3>
        <p class="text-sm text-gray-500 mt-1">Tambah, edit, hapus materi belajar</p>
        <div class="mt-4 flex items-center text-sm text-purple-600 font-medium opacity-0 group-hover:opacity-100 transition-all transform translate-x-[-10px] group-hover:translate-x-0">
            Kelola <i class="fas fa-arrow-right ml-2 text-xs"></i>
        </div>
    </a>

    <a href="{{ route('admin.soal.index') }}" class="menu-card group bg-white rounded-2xl p-6 shadow-sm border border-blue-100">
        <div class="menu-icon w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center text-white text-2xl shadow-lg shadow-blue-200 mb-4">
            <i class="fas fa-question-circle"></i>
        </div>
        <h3 class="font-bold text-lg text-gray-800 group-hover:text-blue-600 transition-colors">Manajemen Soal</h3>
        <p class="text-sm text-gray-500 mt-1">Tambah, edit, hapus soal dengan gambar</p>
        <div class="mt-4 flex items-center text-sm text-blue-600 font-medium opacity-0 group-hover:opacity-100 transition-all transform translate-x-[-10px] group-hover:translate-x-0">
            Kelola <i class="fas fa-arrow-right ml-2 text-xs"></i>
        </div>
    </a>

    <a href="{{ route('admin.packages.index') }}" class="menu-card group bg-white rounded-2xl p-6 shadow-sm border border-emerald-100">
        <div class="menu-icon w-14 h-14 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl flex items-center justify-center text-white text-2xl shadow-lg shadow-emerald-200 mb-4">
            <i class="fas fa-box"></i>
        </div>
        <h3 class="font-bold text-lg text-gray-800 group-hover:text-emerald-600 transition-colors">Manajemen Paket</h3>
        <p class="text-sm text-gray-500 mt-1">Buat paket soal 10-50 soal per kategori</p>
        <div class="mt-4 flex items-center text-sm text-emerald-600 font-medium opacity-0 group-hover:opacity-100 transition-all transform translate-x-[-10px] group-hover:translate-x-0">
            Kelola <i class="fas fa-arrow-right ml-2 text-xs"></i>
        </div>
    </a>

    <a href="{{ route('admin.tryouts.index') }}" class="menu-card group bg-white rounded-2xl p-6 shadow-sm border border-amber-100">
        <div class="menu-icon w-14 h-14 bg-gradient-to-br from-amber-500 to-orange-600 rounded-2xl flex items-center justify-center text-white text-2xl shadow-lg shadow-amber-200 mb-4">
            <i class="fas fa-trophy"></i>
        </div>
        <h3 class="font-bold text-lg text-gray-800 group-hover:text-amber-600 transition-colors">Try Out (110 Soal)</h3>
        <p class="text-sm text-gray-500 mt-1">30 TWK + 35 TIU + 45 TKP</p>
        <div class="mt-4 flex items-center text-sm text-amber-600 font-medium opacity-0 group-hover:opacity-100 transition-all transform translate-x-[-10px] group-hover:translate-x-0">
            Kelola <i class="fas fa-arrow-right ml-2 text-xs"></i>
        </div>
    </a>
</div>

<!-- Grafik + Statistik Kategori -->
<div class="grid lg:grid-cols-2 gap-6 mb-8">
    <!-- Grafik Aktivitas -->
    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between mb-5">
            <h2 class="font-bold text-gray-800 flex items-center gap-2">
                <span class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center text-purple-600"><i class="fas fa-chart-line text-sm"></i></span>
                Aktivitas User
            </h2>
            <span class="text-xs text-gray-400 bg-gray-100 px-3 py-1 rounded-full">7 Hari Terakhir</span>
        </div>
        <canvas id="activityChart" height="120"></canvas>
    </div>

    <!-- Statistik per Kategori -->
    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between mb-5">
            <h2 class="font-bold text-gray-800 flex items-center gap-2">
                <span class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center text-indigo-600"><i class="fas fa-layer-group text-sm"></i></span>
                Statistik Soal
            </h2>
            <span class="text-xs text-gray-400 bg-gray-100 px-3 py-1 rounded-full">Per Kategori</span>
        </div>
        <div class="space-y-4">
            @foreach(['twk' => ['TWK', 'red', 'bg-red-500', 'bg-red-100', 'text-red-600'], 'tiu' => ['TIU', 'blue', 'bg-blue-500', 'bg-blue-100', 'text-blue-600'], 'tkp' => ['TKP', 'emerald', 'bg-emerald-500', 'bg-emerald-100', 'text-emerald-600']] as $key => [$label, $color, $bar, $bg, $text])
            @php
                $total = $statsByCategory[$key] ?? 0;
                $max = max(1, max($statsByCategory['twk'] ?? 0, $statsByCategory['tiu'] ?? 0, $statsByCategory['tkp'] ?? 0));
                $percent = round(($total / $max) * 100);
            @endphp
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full {{ $bar }}"></span>
                        <span class="text-sm font-medium text-gray-700">{{ $label }}</span>
                    </div>
                    <span class="text-sm font-bold {{ $text }}">{{ $total }} soal</span>
                </div>
                <div class="w-full h-2.5 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full rounded-full transition-all duration-1000 {{ $bar }}" style="width: {{ $percent }}%"></div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="mt-5 pt-4 border-t border-gray-100 grid grid-cols-3 gap-3 text-center">
            <div>
                <div class="text-lg font-bold text-red-600">{{ round($avgScores['twk'] ?? 0, 1) }}</div>
                <div class="text-xs text-gray-400">Rata-rata TWK</div>
            </div>
            <div>
                <div class="text-lg font-bold text-blue-600">{{ round($avgScores['tiu'] ?? 0, 1) }}</div>
                <div class="text-xs text-gray-400">Rata-rata TIU</div>
            </div>
            <div>
                <div class="text-lg font-bold text-emerald-600">{{ round($avgScores['tkp'] ?? 0, 1) }}</div>
                <div class="text-xs text-gray-400">Rata-rata TKP</div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Data + Top Wrong Questions -->
<div class="grid lg:grid-cols-2 gap-6">
    <!-- Materi Terbaru -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h2 class="font-bold text-gray-800 flex items-center gap-2">
                <span class="w-7 h-7 bg-purple-100 rounded-lg flex items-center justify-center text-purple-600 text-xs"><i class="fas fa-book"></i></span>
                Materi Terbaru
            </h2>
            <a href="{{ route('admin.materi.index') }}" class="text-xs text-purple-600 hover:text-purple-700 font-medium">Lihat Semua <i class="fas fa-chevron-right ml-1 text-[10px]"></i></a>
        </div>
        <div class="p-2">
            @forelse(($latestMaterials ?? []) as $m)
            <div class="recent-item flex items-center justify-between px-4 py-3 rounded-xl">
                <div class="flex items-center gap-3 min-w-0">
                    <span class="w-8 h-8 rounded-lg bg-purple-100 text-purple-600 flex items-center justify-center text-xs font-bold flex-shrink-0">{{ $loop->iteration }}</span>
                    <span class="text-sm font-medium text-gray-700 truncate">{{ $m->title }}</span>
                </div>
                <span class="text-xs text-gray-400 flex-shrink-0 ml-2">{{ $m->created_at->diffForHumans() }}</span>
            </div>
            @empty
            <p class="text-gray-400 text-center py-8 text-sm">
                <i class="fas fa-book-open text-2xl block mb-2 text-gray-300"></i>
                Belum ada materi
            </p>
            @endforelse
        </div>
    </div>

    <!-- Soal Terbaru -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h2 class="font-bold text-gray-800 flex items-center gap-2">
                <span class="w-7 h-7 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600 text-xs"><i class="fas fa-question-circle"></i></span>
                Soal Terbaru
            </h2>
            <a href="{{ route('admin.soal.index') }}" class="text-xs text-blue-600 hover:text-blue-700 font-medium">Lihat Semua <i class="fas fa-chevron-right ml-1 text-[10px]"></i></a>
        </div>
        <div class="p-2">
            @forelse(($latestQuestions ?? []) as $q)
            <div class="recent-item flex items-center justify-between px-4 py-3 rounded-xl">
                <div class="flex items-center gap-3 min-w-0">
                    <span class="w-8 h-8 rounded-lg
                        @if($q->category == 'twk') bg-red-100 text-red-600
                        @elseif($q->category == 'tiu') bg-blue-100 text-blue-600
                        @else bg-emerald-100 text-emerald-600 @endif
                        flex items-center justify-center text-xs font-bold flex-shrink-0 uppercase">{{ $q->category }}</span>
                    <span class="text-sm text-gray-700 truncate">{{ Str::limit($q->question_text, 35) }}</span>
                </div>
                <span class="text-xs text-gray-400 flex-shrink-0 ml-2">{{ $q->created_at->diffForHumans() }}</span>
            </div>
            @empty
            <p class="text-gray-400 text-center py-8 text-sm">
                <i class="fas fa-question text-2xl block mb-2 text-gray-300"></i>
                Belum ada soal
            </p>
            @endforelse
        </div>
    </div>
</div>

@push('scripts')
<script>
    const ctx = document.getElementById('activityChart').getContext('2d');
    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(139, 92, 246, 0.3)');
    gradient.addColorStop(1, 'rgba(139, 92, 246, 0.0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($activityData['labels'] ?? ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min']) !!},
            datasets: [{
                label: 'Test Dikerjakan',
                data: {!! json_encode($activityData['values'] ?? [0, 0, 0, 0, 0, 0, 0]) !!},
                borderColor: '#8b5cf6',
                backgroundColor: gradient,
                borderWidth: 3,
                pointBackgroundColor: '#8b5cf6',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6,
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        font: { size: 11 }
                    },
                    grid: { color: 'rgba(0,0,0,0.05)' }
                },
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 11 } }
                }
            }
        }
    });
</script>
@endpush
@endsection