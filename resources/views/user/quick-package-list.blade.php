@extends('layouts.user')

@section('title', 'Latihan Cepat')
@section('page-title', 'Latihan Cepat')
@section('breadcrumb')
    <a href="{{ route('home') }}" class="text-purple-600">Home</a> / Latihan Cepat
@endsection

@section('content')
<div class="mb-8">
    <h1 class="text-2xl md:text-3xl font-bold text-gray-800">⚡ Latihan Cepat</h1>
    <p class="text-gray-500 mt-1">Pilih paket latihan cepat sesuai kebutuhan Anda</p>
</div>

<!-- Sistem Penilaian Info -->
<div class="bg-gradient-to-r from-purple-50 to-indigo-50 rounded-xl p-4 mb-8">
    <div class="flex items-start gap-3">
        <div class="text-2xl">📊</div>
        <div>
            <h3 class="font-semibold text-gray-800">Sistem Penilaian</h3>
            <div class="grid md:grid-cols-3 gap-3 mt-2 text-sm">
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

<!-- TWK Packages -->
<div class="mb-10">
    <div class="flex items-center gap-2 mb-4">
        <div class="w-1 h-8 bg-red-500 rounded-full"></div>
        <h2 class="text-xl font-bold text-gray-800">🇮🇩 Paket Cepat TWK</h2>
    </div>
    
    @php $twkPackages = $packagesByCategory['twk'] ?? collect(); @endphp
    @if($twkPackages->count() > 0)
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach($twkPackages as $package)
        <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden">
            <div class="bg-gradient-to-r from-red-500 to-red-600 p-4 text-white">
                <div class="text-3xl mb-2">⚡</div>
                <h3 class="font-bold text-lg">{{ $package->name }}</h3>
                <p class="text-xs opacity-90 mt-1">{{ $package->total_questions }} Soal</p>
            </div>
            <div class="p-5">
                <p class="text-gray-600 text-sm mb-4">{{ $package->description ?: 'Paket latihan cepat TWK untuk menguji wawasan kebangsaan Anda.' }}</p>
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-2 text-sm text-gray-500">
                        <i class="fas fa-check-circle text-green-500"></i>
                        <span>Penilaian: Benar=5</span>
                    </div>
                </div>
                <a href="{{ route('quick-packages.start', $package->id) }}" class="block text-center bg-red-500 text-white py-2 rounded-xl hover:bg-red-600 transition font-medium">
                    🚀 Mulai Latihan
                </a>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="bg-gray-100 rounded-xl p-6 text-center text-gray-500">
        <i class="fas fa-bolt text-3xl mb-2 block"></i>
        Belum ada paket cepat TWK. Silakan hubungi admin.
    </div>
    @endif
</div>

<!-- TIU Packages -->
<div class="mb-10">
    <div class="flex items-center gap-2 mb-4">
        <div class="w-1 h-8 bg-blue-500 rounded-full"></div>
        <h2 class="text-xl font-bold text-gray-800">🧠 Paket Cepat TIU</h2>
    </div>
    
    @php $tiuPackages = $packagesByCategory['tiu'] ?? collect(); @endphp
    @if($tiuPackages->count() > 0)
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach($tiuPackages as $package)
        <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-4 text-white">
                <div class="text-3xl mb-2">⚡</div>
                <h3 class="font-bold text-lg">{{ $package->name }}</h3>
                <p class="text-xs opacity-90 mt-1">{{ $package->total_questions }} Soal</p>
            </div>
            <div class="p-5">
                <p class="text-gray-600 text-sm mb-4">{{ $package->description ?: 'Paket latihan cepat TIU untuk mengasah kemampuan intelegensi.' }}</p>
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-2 text-sm text-gray-500">
                        <i class="fas fa-check-circle text-green-500"></i>
                        <span>Penilaian: Benar=5</span>
                    </div>
                </div>
                <a href="{{ route('quick-packages.start', $package->id) }}" class="block text-center bg-blue-500 text-white py-2 rounded-xl hover:bg-blue-600 transition font-medium">
                    🚀 Mulai Latihan
                </a>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="bg-gray-100 rounded-xl p-6 text-center text-gray-500">
        <i class="fas fa-bolt text-3xl mb-2 block"></i>
        Belum ada paket cepat TIU. Silakan hubungi admin.
    </div>
    @endif
</div>

<!-- TKP Packages -->
<div class="mb-10">
    <div class="flex items-center gap-2 mb-4">
        <div class="w-1 h-8 bg-green-500 rounded-full"></div>
        <h2 class="text-xl font-bold text-gray-800">💼 Paket Cepat TKP</h2>
    </div>
    
    @php $tkpPackages = $packagesByCategory['tkp'] ?? collect(); @endphp
    @if($tkpPackages->count() > 0)
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach($tkpPackages as $package)
        <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden">
            <div class="bg-gradient-to-r from-green-500 to-green-600 p-4 text-white">
                <div class="text-3xl mb-2">⚡</div>
                <h3 class="font-bold text-lg">{{ $package->name }}</h3>
                <p class="text-xs opacity-90 mt-1">{{ $package->total_questions }} Soal</p>
            </div>
            <div class="p-5">
                <p class="text-gray-600 text-sm mb-4">{{ $package->description ?: 'Paket latihan cepat TKP untuk mengukur karakteristik pribadi.' }}</p>
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-2 text-sm text-gray-500">
                        <i class="fas fa-chart-line text-green-500"></i>
                        <span>Penilaian: Skala 1-5</span>
                    </div>
                </div>
                <a href="{{ route('quick-packages.start', $package->id) }}" class="block text-center bg-green-500 text-white py-2 rounded-xl hover:bg-green-600 transition font-medium">
                    🚀 Mulai Latihan
                </a>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="bg-gray-100 rounded-xl p-6 text-center text-gray-500">
        <i class="fas fa-bolt text-3xl mb-2 block"></i>
        Belum ada paket cepat TKP. Silakan hubungi admin.
    </div>
    @endif
</div>

<!-- Motivasi -->
<div class="mt-8 bg-gradient-to-r from-purple-600 to-indigo-600 rounded-2xl p-6 text-white text-center">
    <i class="fas fa-quote-left text-3xl opacity-50 mb-3 block"></i>
    <p class="text-lg">"Latihan rutin setiap hari adalah kunci sukses menghadapi ujian CPNS"</p>
    <p class="text-purple-200 mt-2 text-sm">- Semangat! Latihan sekarang -</p>
</div>
@endsection