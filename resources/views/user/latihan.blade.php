@extends('layouts.user')

@section('title', 'Latihan Soal')
@section('page-title', 'Latihan Soal')
@section('breadcrumb')
    <a href="{{ route('home') }}" class="text-purple-600">Home</a> / Latihan Soal
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-8 text-center">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">📝 Pilih Kategori Latihan</h1>
        <p class="text-gray-500 mt-2">Pilih kategori paket soal yang ingin Anda kerjakan</p>
    </div>

    <!-- Sistem Penilaian Info -->
    <div class="bg-gradient-to-r from-purple-50 to-indigo-50 rounded-2xl p-5 mb-10">
        <div class="flex items-start gap-3">
            <div class="text-3xl">📊</div>
            <div>
                <h3 class="font-semibold text-gray-800">Sistem Penilaian</h3>
                <div class="grid md:grid-cols-3 gap-3 mt-3 text-sm">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 bg-red-500 rounded-full"></span>
                        <span><strong>TWK</strong> : Benar = 5 poin, Salah = 0</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 bg-blue-500 rounded-full"></span>
                        <span><strong>TIU</strong> : Benar = 5 poin, Salah = 0</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 bg-green-500 rounded-full"></span>
                        <span><strong>TKP</strong> : Skala 1-5 (nilai ditentukan admin)</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pilih Kategori -->
    <div class="grid md:grid-cols-3 gap-6">
        <a href="{{ route('packages.index') }}?category=twk" 
           class="group bg-gradient-to-r from-red-500 to-red-600 rounded-2xl p-8 text-white text-center hover:shadow-2xl transition-all duration-300 hover:-translate-y-2">
            <div class="text-6xl mb-4">🇮🇩</div>
            <h2 class="text-2xl font-bold mb-2">TWK</h2>
            <p class="text-red-100 text-sm">Tes Wawasan Kebangsaan</p>
            <div class="mt-5 text-sm bg-white/20 inline-block px-4 py-2 rounded-full group-hover:bg-white/30 transition">
                Lihat Paket →
            </div>
        </a>

        <a href="{{ route('packages.index') }}?category=tiu" 
           class="group bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl p-8 text-white text-center hover:shadow-2xl transition-all duration-300 hover:-translate-y-2">
            <div class="text-6xl mb-4">🧠</div>
            <h2 class="text-2xl font-bold mb-2">TIU</h2>
            <p class="text-blue-100 text-sm">Tes Intelegensi Umum</p>
            <div class="mt-5 text-sm bg-white/20 inline-block px-4 py-2 rounded-full group-hover:bg-white/30 transition">
                Lihat Paket →
            </div>
        </a>

        <a href="{{ route('packages.index') }}?category=tkp" 
           class="group bg-gradient-to-r from-green-500 to-green-600 rounded-2xl p-8 text-white text-center hover:shadow-2xl transition-all duration-300 hover:-translate-y-2">
            <div class="text-6xl mb-4">💼</div>
            <h2 class="text-2xl font-bold mb-2">TKP</h2>
            <p class="text-green-100 text-sm">Tes Karakteristik Pribadi</p>
            <div class="mt-5 text-sm bg-white/20 inline-block px-4 py-2 rounded-full group-hover:bg-white/30 transition">
                Lihat Paket →
            </div>
        </a>
    </div>
</div>
@endsection