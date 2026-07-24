@extends('layouts.user')

@section('title', 'Latihan Soal')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl md:text-3xl font-bold text-gray-800">📝 Latihan Soal</h1>
    <p class="text-gray-500 mt-1">Pilih kategori latihan yang ingin Anda kerjakan</p>
</div>

<div class="grid md:grid-cols-3 gap-6">
    @foreach($categories as $key => $cat)
    <div class="group bg-white rounded-2xl shadow-sm hover:shadow-2xl transition-all duration-500 overflow-hidden hover:-translate-y-2">
        <div class="relative h-32 bg-gradient-to-br 
            @if($key == 'twk') from-red-400 to-red-600
            @elseif($key == 'tiu') from-blue-400 to-blue-600
            @else from-green-400 to-green-600 @endif">
            <div class="absolute inset-0 bg-black/20"></div>
            <div class="absolute bottom-4 left-4 text-white">
                <div class="text-5xl mb-2">{{ $cat['icon'] }}</div>
                <h3 class="text-xl font-bold">{{ $cat['name'] }}</h3>
            </div>
        </div>
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <span class="text-sm text-gray-500">
                    <i class="fas fa-question-circle mr-1"></i>
                    Latihan Soal
                </span>
            </div>
            <div class="space-y-3">
                <a href="{{ route('test', $key) }}?limit=10" 
                   class="flex items-center justify-between w-full bg-{{ $cat['color'] }}-50 text-{{ $cat['color'] }}-700 px-4 py-3 rounded-xl hover:bg-{{ $cat['color'] }}-100 transition-all group-hover:shadow-md">
                    <span>📝 Latihan Cepat (10 Soal)</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
                <a href="{{ route('test', $key) }}?limit=20&difficulty=hard" 
                   class="flex items-center justify-between w-full border border-gray-200 px-4 py-3 rounded-xl hover:border-{{ $cat['color'] }}-300 hover:bg-{{ $cat['color'] }}-50 transition-all">
                    <span>🔥 Try Out (20 Soal)</span>
                    <i class="fas fa-trophy text-yellow-500"></i>
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Motivasi -->
<div class="mt-12 bg-gradient-to-r from-purple-600 to-indigo-600 rounded-2xl p-6 text-white text-center">
    <i class="fas fa-quote-left text-3xl opacity-50 mb-3 block"></i>
    <p class="text-lg">"Keberhasilan bukanlah milik orang yang pintar, tapi milik mereka yang terus berusaha"</p>
    <p class="text-purple-200 mt-2 text-sm">- Semangat Belajar CPNS -</p>
</div>
@endsection