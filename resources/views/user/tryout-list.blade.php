@extends('layouts.user')

@section('title', 'Try Out CPNS')
@section('page-title', 'Try Out CPNS')
@section('breadcrumb')
    <a href="{{ route('home') }}" class="text-purple-600">Home</a> / Try Out
@endsection

@section('content')
<div class="w-full">
    <!-- Header -->
    <div class="mb-8 text-center">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2 flex items-center justify-center gap-2">
            <i class="fas fa-trophy text-yellow-500"></i>
            Try Out CPNS
        </h1>
        <p class="text-gray-500">Simulasi ujian CPNS dengan 110 soal (30 TWK + 35 TIU + 45 TKP)</p>
    </div>

    <!-- Info Sistem Penilaian -->
    <div class="bg-gradient-to-r from-purple-50 to-indigo-50 rounded-2xl p-5 mb-8">
        <div class="flex items-start gap-3">
            <div class="text-3xl">📊</div>
            <div>
                <h3 class="font-semibold text-gray-800">Sistem Penilaian Try Out</h3>
                <div class="grid md:grid-cols-3 gap-4 mt-3 text-sm">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 bg-red-500 rounded-full"></span>
                        <span><strong>TWK (30 Soal)</strong> : Benar = 5 poin, Maksimal 150</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 bg-blue-500 rounded-full"></span>
                        <span><strong>TIU (35 Soal)</strong> : Benar = 5 poin, Maksimal 175</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 bg-green-500 rounded-full"></span>
                        <span><strong>TKP (45 Soal)</strong> : Skala 1-5, Maksimal 225</span>
                    </div>
                </div>
                <div class="mt-3 p-3 bg-white/50 rounded-lg">
                    <p class="text-sm font-semibold">🎯 Total Maksimal: 550 Poin</p>
                    <p class="text-xs text-gray-600 mt-1">Waktu pengerjaan: 100 menit</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Try Out -->
    @if($tryouts->count() > 0)
    <div class="grid md:grid-cols-2 gap-6">
        @foreach($tryouts as $tryout)
        @php
            $participants = rand(500, 3000);
            $rating = (rand(40, 50) / 10);
        @endphp
        <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden">
            <div class="bg-gradient-to-r from-purple-600 to-indigo-600 p-5 text-white">
                <div class="flex justify-between items-start">
                    <div>
                        <div class="text-3xl mb-2">🎯</div>
                        <h3 class="font-bold text-lg">{{ $tryout->name }}</h3>
                        <p class="text-xs opacity-90 mt-1">{{ $tryout->total_questions }} Soal • ⏱️ {{ $tryout->duration }} Menit</p>
                    </div>
                    <span class="text-xs bg-white/20 px-2 py-1 rounded-full">Try Out</span>
                </div>
            </div>
            <div class="p-5">
                <p class="text-gray-600 text-sm mb-4">{{ Str::limit($tryout->description ?: 'Simulasi ujian CPNS dengan 110 soal lengkap TWK, TIU, dan TKP.', 100) }}</p>
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3 text-sm text-gray-500">
                        <span><i class="fas fa-users mr-1"></i> {{ number_format($participants) }} peserta</span>
                        <span><i class="fas fa-star text-yellow-400 mr-1"></i> {{ $rating }}</span>
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-2 text-center text-xs mb-4">
                    <div class="p-2 bg-red-50 rounded-lg">
                        <span class="font-bold text-red-600">🇮🇩 30</span>
                        <span class="text-gray-500 block">TWK</span>
                    </div>
                    <div class="p-2 bg-blue-50 rounded-lg">
                        <span class="font-bold text-blue-600">🧠 35</span>
                        <span class="text-gray-500 block">TIU</span>
                    </div>
                    <div class="p-2 bg-green-50 rounded-lg">
                        <span class="font-bold text-green-600">💼 45</span>
                        <span class="text-gray-500 block">TKP</span>
                    </div>
                </div>
                <a href="{{ route('tryouts.start', $tryout->id) }}" class="block text-center bg-gradient-to-r from-purple-600 to-indigo-600 text-white py-2 rounded-xl hover:shadow-lg transition font-medium">
                    🚀 Mulai Try Out
                </a>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="bg-gray-100 rounded-2xl p-12 text-center">
        <i class="fas fa-trophy text-5xl text-gray-400 mb-3 block"></i>
        <p class="text-gray-500">Belum ada Try Out. Silakan hubungi admin.</p>
        <a href="{{ route('latihan') }}" class="inline-block mt-4 text-purple-600 hover:underline">← Kembali ke Latihan</a>
    </div>
    @endif
</div>
@endsection