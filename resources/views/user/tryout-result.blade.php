@extends('layouts.user')

@section('title', 'Hasil ' . $tryout->name)
@section('page-title', 'Hasil Try Out')
@section('breadcrumb')
    <a href="{{ route('home') }}" class="text-purple-600">Home</a> / 
    <a href="{{ route('tryouts.index') }}" class="text-purple-600">Try Out</a> / 
    Hasil
@endsection

@section('content')
<style>
    .score-card {
        transition: all 0.3s ease;
    }
    .score-card:hover {
        transform: translateY(-3px);
    }
    .category-card {
        transition: all 0.3s ease;
    }
    .category-card:hover {
        transform: translateX(5px);
    }
</style>

<div class="max-w-4xl mx-auto">
    <!-- Result Header -->
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden mb-8">
        <div class="bg-gradient-to-r from-purple-600 to-indigo-600 p-6 text-white text-center">
            <div class="text-5xl mb-3">🎯</div>
            <h1 class="text-2xl font-bold mb-2">Hasil Try Out: {{ $tryout->name }}</h1>
            <p class="text-lg">Skor: {{ $score }} / {{ $maxScore }}</p>
            <p class="text-sm opacity-80 mt-1">Waktu pengerjaan: {{ $tryout->duration }} menit</p>
        </div>
        
        <div class="p-6">
            <!-- Statistik Ringkas -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-center mb-8">
                <div class="p-3 bg-purple-50 rounded-xl">
                    <div class="text-2xl font-bold text-purple-600">{{ $questions->count() }}</div>
                    <div class="text-xs text-gray-500 mt-1">Total Soal</div>
                </div>
                <div class="p-3 bg-green-50 rounded-xl">
                    <div class="text-2xl font-bold text-green-600">
                        {{ $results->filter(fn($r) => $r['is_correct'] && $r['category'] != 'tkp')->count() }}
                    </div>
                    <div class="text-xs text-gray-500 mt-1">Benar (TWK/TIU)</div>
                </div>
                <div class="p-3 bg-red-50 rounded-xl">
                    <div class="text-2xl font-bold text-red-600">
                        {{ $results->filter(fn($r) => !$r['is_correct'] && $r['category'] != 'tkp')->count() }}
                    </div>
                    <div class="text-xs text-gray-500 mt-1">Salah (TWK/TIU)</div>
                </div>
                <div class="p-3 bg-blue-50 rounded-xl">
                    <div class="text-2xl font-bold text-blue-600">{{ $score }}</div>
                    <div class="text-xs text-gray-500 mt-1">Total Poin</div>
                    <div class="text-xs text-gray-400">Rata-rata: {{ round($score / $questions->count(), 1) }}/soal</div>
                </div>
            </div>
            
            <!-- Status -->
            <div class="text-center text-gray-600 font-medium text-lg mb-4">
                📊 Total Poin: {{ $score }} / {{ $maxScore }}
            </div>
        </div>
    </div>

    <!-- Rincian Skor per Kategori -->
    <div class="bg-white rounded-2xl shadow-sm p-6 mb-8">
        <h2 class="font-bold text-lg text-gray-800 mb-4 flex items-center gap-2">
            <i class="fas fa-chart-pie text-purple-600"></i>
            Rincian Skor per Kategori
        </h2>
        
        <div class="space-y-4">
            <!-- TWK -->
            <div class="category-card bg-red-50 rounded-xl p-4">
                <div class="flex items-center gap-2 mb-2">
                    <span class="text-2xl">🇮🇩</span>
                    <span class="font-semibold text-gray-800">TWK ({{ $twkTotal }} Soal)</span>
                </div>
                <div class="flex items-center gap-4 text-sm">
                    <span class="text-gray-600">✅ <strong>{{ $twkCorrect }}</strong> Benar</span>
                    <span class="text-gray-600">❌ <strong>{{ $twkTotal - $twkCorrect }}</strong> Salah</span>
                </div>
            </div>
            
            <!-- TIU -->
            <div class="category-card bg-blue-50 rounded-xl p-4">
                <div class="flex items-center gap-2 mb-2">
                    <span class="text-2xl">🧠</span>
                    <span class="font-semibold text-gray-800">TIU ({{ $tiuTotal }} Soal)</span>
                </div>
                <div class="flex items-center gap-4 text-sm">
                    <span class="text-gray-600">✅ <strong>{{ $tiuCorrect }}</strong> Benar</span>
                    <span class="text-gray-600">❌ <strong>{{ $tiuTotal - $tiuCorrect }}</strong> Salah</span>
                </div>
            </div>
            
            <!-- TKP -->
            <div class="category-card bg-green-50 rounded-xl p-4">
                <div class="flex items-center gap-2 mb-2">
                    <span class="text-2xl">💼</span>
                    <span class="font-semibold text-gray-800">TKP ({{ $tkpTotal }} Soal)</span>
                </div>
                <div class="flex items-center gap-4 text-sm">
                    <span class="text-gray-600">⭐ Total Poin: <strong>{{ $tkpScore }}</strong> / {{ $tkpMax }}</span>
                    <span class="text-gray-400">(Rata-rata: {{ $tkpTotal > 0 ? round($tkpScore / $tkpTotal, 1) : 0 }}/5)</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Rekomendasi -->
    <div class="bg-gradient-to-r from-purple-50 to-indigo-50 rounded-2xl p-5 mb-8 border border-purple-100">
        <div class="flex items-start gap-3">
            <div class="text-3xl">💡</div>
            <div>
                <h3 class="font-semibold text-gray-800">Rekomendasi Belajar</h3>
                <p class="text-gray-600 text-sm mt-1">
                    @if($tiuCorrect < $tiuTotal * 0.7)
                    Fokus belajar pada kategori <strong>TIU</strong> yang masih rendah ({{ $tiuCorrect }}/{{ $tiuTotal }} benar). 
                    Perbanyak latihan soal deret angka, sinonim, dan antonim.
                    @elseif($twkCorrect < $twkTotal * 0.7)
                    Fokus belajar pada kategori <strong>TWK</strong> yang masih rendah ({{ $twkCorrect }}/{{ $twkTotal }} benar).
                    Pelajari kembali materi Pancasila, UUD 1945, dan Bhinneka Tunggal Ika.
                    @elseif($tkpScore < $tkpMax * 0.7)
                    Fokus belajar pada kategori <strong>TKP</strong> ({{ $tkpScore }}/{{ $tkpMax }} poin).
                    Pahami karakteristik dan nilai-nilai ASN.
                    @else
                    Pertahankan prestasimu! Coba kerjakan try out lain untuk menguji kemampuan.
                    @endif
                </p>
            </div>
        </div>
    </div>

    <!-- Tombol Aksi -->
    <div class="flex flex-wrap gap-3 justify-center mb-8">
        <a href="{{ route('tryouts.start', $tryout->id) }}" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 transition">
            🔄 Ulangi Try Out
        </a>
        <a href="{{ route('tryouts.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition">
            📦 Try Out Lain
        </a>
        <a href="{{ route('packages.index') }}" class="bg-green-500 text-white px-6 py-2 rounded-lg hover:bg-green-600 transition">
            📝 Latihan Soal
        </a>
    </div>

    <!-- Pembahasan Soal (Collapsible) -->
    <div class="bg-white rounded-2xl shadow-sm p-6">
        <h2 class="font-bold text-lg text-gray-800 mb-4 flex items-center gap-2 cursor-pointer" onclick="togglePembahasan()">
            <i class="fas fa-chevron-right text-purple-600 transition-transform" id="toggleIcon"></i>
            <i class="fas fa-chalkboard-user text-purple-600"></i>
            Pembahasan Soal
        </h2>
        
        <div id="pembahasanContent" class="hidden space-y-4">
            @foreach($results as $index => $r)
            <div class="border-b border-gray-100 pb-4 last:border-0">
                <div class="flex gap-3">
                    <div class="flex-shrink-0">
                        @if($r['category'] == 'tkp')
                            <span class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-sm font-bold">
                                {{ $r['points'] }}
                            </span>
                        @else
                            @if($r['is_correct'])
                                <span class="w-8 h-8 rounded-full bg-green-100 text-green-600 flex items-center justify-center text-sm">✅</span>
                            @else
                                <span class="w-8 h-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center text-sm">❌</span>
                            @endif
                        @endif
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1 flex-wrap">
                            <span class="text-sm font-medium text-gray-500">Soal {{ $index + 1 }}</span>
                            <span class="text-xs px-2 py-0.5 rounded-full 
                                @if($r['category'] == 'twk') bg-red-100 text-red-600
                                @elseif($r['category'] == 'tiu') bg-blue-100 text-blue-600
                                @else bg-green-100 text-green-600 @endif">
                                {{ strtoupper($r['category']) }}
                            </span>
                            <span class="text-xs px-2 py-0.5 rounded-full {{ $r['is_correct'] || $r['category'] == 'tkp' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                                Poin: {{ $r['points'] }}/{{ $r['max_points'] }}
                            </span>
                            @if(!$r['is_correct'] && $r['category'] != 'tkp')
                            <span class="text-xs text-green-600 bg-green-50 px-2 py-0.5 rounded-full">
                                Jawaban: {{ strtoupper($r['correct_answer']) }}
                            </span>
                            @endif
                        </div>
                        <p class="text-gray-800 text-sm">{{ $r['question']->question_text }}</p>
                        
                        @if($r['question']->question_image)
                        <div class="mt-2">
                            <img src="{{ $r['question']->question_image }}" class="max-w-full max-h-32 rounded-lg border">
                        </div>
                        @endif
                        
                        <p class="text-sm mt-2">
                            <span class="text-gray-500">Jawaban Anda:</span>
                            <span class="font-medium {{ $r['is_correct'] || $r['category'] == 'tkp' ? 'text-blue-600' : 'text-red-600' }}">
                                {{ strtoupper($r['user_answer']) }}. 
                                @php
                                    $optField = 'option_' . $r['user_answer'];
                                @endphp
                                {{ $r['question']->$optField ?? '-' }}
                            </span>
                        </p>
                        
                        @if($r['explanation'])
                        <div class="mt-2 p-3 bg-blue-50 rounded-lg text-sm text-blue-700">
                            <i class="fas fa-lightbulb mr-1"></i> {{ $r['explanation'] }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<script>
    function togglePembahasan() {
        const content = document.getElementById('pembahasanContent');
        const icon = document.getElementById('toggleIcon');
        if (content.classList.contains('hidden')) {
            content.classList.remove('hidden');
            icon.style.transform = 'rotate(90deg)';
        } else {
            content.classList.add('hidden');
            icon.style.transform = 'rotate(0deg)';
        }
    }
    
    // Clear localStorage setelah selesai
    localStorage.removeItem('tryout_answers_{{ $tryout->id }}');
    localStorage.removeItem('tryout_time_{{ $tryout->id }}');
</script>
@endsection