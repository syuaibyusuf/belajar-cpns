@extends('layouts.user')

@section('title', 'Dashboard')

@section('content')
<!-- Welcome Banner -->
<div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 rounded-2xl p-6 md:p-8 mb-8 text-white shadow-xl pulse-glow">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold mb-2">Selamat Datang, Pejuang ASN! 🎯</h1>
            <p class="text-purple-100">Persiapkan dirimu menjadi Aparatur Sipil Negara yang profesional</p>
        </div>
        <div class="bg-white/20 backdrop-blur rounded-xl px-4 py-2 text-center">
            <div class="text-2xl font-bold">{{ $totalDikerjakan ?? 0 }}</div>
            <div class="text-xs opacity-80">Soal Dikerjakan</div>
        </div>
    </div>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-2xl p-5 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100">
        <div class="bg-purple-100 w-12 h-12 rounded-xl flex items-center justify-center mb-3">
            <i class="fas fa-book text-purple-600 text-xl"></i>
        </div>
        <div class="text-2xl font-bold text-gray-800">{{ $totalSoal ?? 0 }}</div>
        <div class="text-sm text-gray-500 mt-1">Total Soal</div>
    </div>
    
    <div class="bg-white rounded-2xl p-5 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100">
        <div class="bg-blue-100 w-12 h-12 rounded-xl flex items-center justify-center mb-3">
            <i class="fas fa-check-circle text-blue-600 text-xl"></i>
        </div>
        <div class="text-2xl font-bold text-gray-800">{{ $totalDikerjakan ?? 0 }}</div>
        <div class="text-sm text-gray-500 mt-1">Soal Dikerjakan</div>
    </div>
    
    <div class="bg-white rounded-2xl p-5 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100">
        <div class="bg-green-100 w-12 h-12 rounded-xl flex items-center justify-center mb-3">
            <i class="fas fa-chart-line text-green-600 text-xl"></i>
        </div>
        <div class="text-2xl font-bold text-gray-800">{{ round($rataNilai ?? 0) }}%</div>
        <div class="text-sm text-gray-500 mt-1">Rata-rata Nilai</div>
    </div>
    
    <div class="bg-white rounded-2xl p-5 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100">
        <div class="bg-orange-100 w-12 h-12 rounded-xl flex items-center justify-center mb-3">
            <i class="fas fa-trophy text-orange-600 text-xl"></i>
        </div>
        <div class="text-2xl font-bold text-gray-800">ASN</div>
        <div class="text-sm text-gray-500 mt-1">Target</div>
    </div>
</div>

<!-- Progress Cards -->
<div class="grid md:grid-cols-3 gap-6 mb-8">
    @foreach(['twk' => ['name' => 'Tes Wawasan Kebangsaan', 'icon' => '🇮🇩', 'color' => 'red'],
              'tiu' => ['name' => 'Tes Intelegensi Umum', 'icon' => '🧠', 'color' => 'blue'],
              'tkp' => ['name' => 'Tes Karakteristik Pribadi', 'icon' => '💼', 'color' => 'green']] as $key => $cat)
    <div class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden group">
        <div class="bg-{{ $cat['color'] }}-50 p-5">
            <div class="flex justify-between items-start">
                <div>
                    <span class="text-3xl">{{ $cat['icon'] }}</span>
                    <h3 class="font-bold text-gray-800 mt-2">{{ $cat['name'] }}</h3>
                </div>
                <div class="text-2xl font-bold text-{{ $cat['color'] }}-600">{{ $statistik[$key]['persentase'] ?? 0 }}%</div>
            </div>
        </div>
        <div class="p-5">
            <div class="w-full bg-gray-200 rounded-full h-2 mb-3">
                <div class="bg-{{ $cat['color'] }}-500 h-2 rounded-full transition-all duration-700" style="width: {{ $statistik[$key]['persentase'] ?? 0 }}%"></div>
            </div>
            <div class="flex justify-between text-sm text-gray-500 mb-4">
                <span>{{ $statistik[$key]['dikerjakan'] ?? 0 }}/{{ $statistik[$key]['total'] ?? 0 }} soal</span>
                <span>Nilai: {{ $statistik[$key]['nilai'] ?? 0 }}%</span>
            </div>
            <a href="{{ route('test', $key) }}" class="flex items-center justify-center gap-2 w-full bg-{{ $cat['color'] }}-500 text-white py-2.5 rounded-xl hover:bg-{{ $cat['color'] }}-600 transition-all group-hover:scale-105 duration-300">
                <i class="fas fa-play text-sm"></i>
                <span>Mulai Latihan</span>
            </a>
        </div>
    </div>
    @endforeach
</div>

<!-- Recent Materials -->
<div class="bg-white rounded-2xl shadow-sm p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-gray-800">
            <i class="fas fa-graduation-cap text-purple-600 mr-2"></i>
            Materi Terbaru
        </h2>
        <a href="#" class="text-purple-600 text-sm hover:underline">Lihat Semua →</a>
    </div>
    
    @if(isset($materi) && $materi->count() > 0)
    <div class="grid md:grid-cols-2 gap-4">
        @foreach($materi as $item)
        <a href="{{ route('materi.detail', $item->id) }}" class="flex items-center gap-4 p-4 border border-gray-100 rounded-xl hover:shadow-md transition-all hover:border-purple-200 group">
            <div class="w-12 h-12 bg-gradient-to-br from-purple-100 to-purple-50 rounded-xl flex items-center justify-center text-2xl">
                @php
                    $icons = ['twk' => '🇮🇩', 'tiu' => '🧠', 'tkp' => '💼'];
                @endphp
                {{ $icons[$item->category] ?? '📖' }}
            </div>
            <div class="flex-1">
                <h3 class="font-semibold text-gray-800 group-hover:text-purple-600 transition">{{ $item->title }}</h3>
                <div class="flex items-center gap-2 mt-1">
                    <span class="text-xs px-2 py-0.5 rounded-full 
                        @if($item->category == 'twk') bg-red-100 text-red-600
                        @elseif($item->category == 'tiu') bg-blue-100 text-blue-600
                        @else bg-green-100 text-green-600 @endif">
                        {{ strtoupper($item->category) }}
                    </span>
                    <span class="text-xs text-gray-400">
                        <i class="far fa-clock mr-1"></i>
                        {{ $item->created_at->diffForHumans() }}
                    </span>
                </div>
            </div>
            <i class="fas fa-arrow-right text-gray-300 group-hover:text-purple-600 transition"></i>
        </a>
        @endforeach
    </div>
    @else
    <div class="text-center py-12">
        <div class="text-6xl mb-4">📚</div>
        <h3 class="text-lg font-semibold text-gray-700 mb-2">Belum Ada Materi</h3>
        <p class="text-gray-500 text-sm mb-4">Silakan login sebagai admin untuk menambahkan materi belajar</p>
        <a href="{{ url('/admin/login') }}" class="inline-flex items-center gap-2 bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition">
            <i class="fas fa-lock"></i>
            Login Admin
        </a>
    </div>
    @endif
</div>