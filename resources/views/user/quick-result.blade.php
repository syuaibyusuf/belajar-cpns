@extends('layouts.user')

@section('title', 'Hasil ' . $package->name)
@section('page-title', 'Hasil Test')

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Result Card -->
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden mb-6">
        <div class="bg-gradient-to-r 
            @if($package->category == 'twk') from-red-500 to-red-600
            @elseif($package->category == 'tiu') from-blue-500 to-blue-600
            @else from-green-500 to-green-600 @endif 
            p-6 text-white text-center">
            <div class="text-5xl mb-3">⚡</div>
            <h1 class="text-2xl font-bold mb-2">Hasil {{ $package->name }}</h1>
            <div class="text-6xl font-bold my-4">{{ round($percentage) }}%</div>
            <p class="text-lg">Skor: {{ $score }} / {{ $maxScore }}</p>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-3 gap-3 text-center mb-6">
                <div class="p-3 bg-purple-50 rounded-xl">
                    <div class="text-2xl font-bold text-purple-600">{{ $questions->count() }}</div>
                    <div class="text-xs text-gray-500 mt-1">Total Soal</div>
                </div>
                @if($package->category != 'tkp')
                <div class="p-3 bg-green-50 rounded-xl">
                    <div class="text-2xl font-bold text-green-600">
                        {{ $results->filter(fn($r) => $r['is_correct'])->count() }}
                    </div>
                    <div class="text-xs text-gray-500 mt-1">Benar</div>
                </div>
                <div class="p-3 bg-red-50 rounded-xl">
                    <div class="text-2xl font-bold text-red-600">
                        {{ $results->filter(fn($r) => !$r['is_correct'])->count() }}
                    </div>
                    <div class="text-xs text-gray-500 mt-1">Salah</div>
                </div>
                @else
                <div class="p-3 bg-green-50 rounded-xl">
                    <div class="text-2xl font-bold text-green-600">{{ round($score / $maxScore * 100) }}%</div>
                    <div class="text-xs text-gray-500 mt-1">Persentase</div>
                </div>
                <div class="p-3 bg-blue-50 rounded-xl">
                    <div class="text-2xl font-bold text-blue-600">{{ round($score / $questions->count(), 1) }}</div>
                    <div class="text-xs text-gray-500 mt-1">Rata-rata/Soal</div>
                </div>
                @endif
            </div>
            
            @if($percentage >= 80)
                <div class="text-center text-green-600 font-medium">🌟 Hebat! Pertahankan belajarmu!</div>
            @elseif($percentage >= 60)
                <div class="text-center text-yellow-600 font-medium">📚 Lumayan, tingkatkan lagi!</div>
            @else
                <div class="text-center text-red-600 font-medium">💪 Ayo belajar lebih giat lagi!</div>
            @endif
            
            <div class="flex gap-3 mt-6 justify-center">
                <a href="{{ route('quick-packages.start', $package->id) }}" class="bg-purple-600 text-white px-5 py-2 rounded-lg hover:bg-purple-700 transition">
                    🔄 Ulangi Test
                </a>
                <a href="{{ route('quick-packages.index') }}" class="bg-gray-500 text-white px-5 py-2 rounded-lg hover:bg-gray-600 transition">
                    ⚡ Paket Lain
                </a>
            </div>
        </div>
    </div>

    <!-- Pembahasan Soal -->
    <div class="bg-white rounded-2xl shadow-sm p-6">
        <h2 class="font-bold text-lg text-gray-800 mb-4 flex items-center gap-2">
            <i class="fas fa-chalkboard-user text-purple-600"></i>
            Pembahasan Soal
        </h2>
        
        <div class="space-y-4">
            @foreach($results as $index => $r)
            <div class="border-b border-gray-100 pb-4 last:border-0">
                <div class="flex gap-3">
                    <div class="flex-shrink-0">
                        @if($package->category == 'tkp')
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
                            <span class="text-xs px-2 py-0.5 rounded-full {{ $r['is_correct'] || $package->category == 'tkp' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                                Poin: {{ $r['points'] }}/{{ $r['max_points'] }}
                            </span>
                            @if(!$r['is_correct'] && $package->category != 'tkp')
                            <span class="text-xs text-green-600 bg-green-50 px-2 py-0.5 rounded-full">
                                Jawaban: {{ strtoupper($r['correct_answer']) }}
                            </span>
                            @endif
                        </div>
                        <p class="text-gray-800 text-sm">{{ $r['question']->question_text }}</p>
                        
                        <!-- Gambar Soal di Pembahasan -->
                        @if($r['question']->question_image)
                        <div class="mt-2">
                            <img src="{{ $r['question']->question_image }}" class="max-w-full max-h-32 rounded-lg border" alt="Gambar Soal">
                        </div>
                        @endif
                        
                        <p class="text-sm mt-2">
                            <span class="text-gray-500">Jawaban Anda:</span>
                            <span class="font-medium {{ $r['is_correct'] || $package->category == 'tkp' ? 'text-blue-600' : 'text-red-600' }}">
                                {{ strtoupper($r['user_answer']) }}. 
                                @php
                                    $optMap = ['a' => 'option_a', 'b' => 'option_b', 'c' => 'option_c', 'd' => 'option_d', 'e' => 'option_e'];
                                    $optField = $optMap[$r['user_answer']] ?? 'option_a';
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

@push('scripts')
<script>
    localStorage.removeItem('quick_package_answers_{{ $package->id }}');
</script>
@endpush
@endsection