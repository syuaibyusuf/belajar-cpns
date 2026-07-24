@extends('layouts.user')

@section('title', 'Hasil ' . $package->name)
@section('page-title', 'Hasil Test')

@section('content')
<div class="w-full max-w-4xl mx-auto">
    <!-- Result Card -->
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden mb-6">
        <div class="bg-gradient-to-r 
            @if($package->category == 'twk') from-red-500 to-red-600
            @elseif($package->category == 'tiu') from-blue-500 to-blue-600
            @else from-green-500 to-green-600 @endif 
            p-6 text-white text-center">
            <div class="text-5xl mb-3">
                @if($percentage >= 80) 🎉
                @elseif($percentage >= 60) 📚
                @else 💪 @endif
            </div>
            <h1 class="text-2xl font-bold mb-2">Hasil {{ $package->name }}</h1>
            <div class="text-6xl font-bold my-4">{{ round($percentage) }}%</div>
            <p class="text-lg">Skor: {{ $score }} / {{ $maxScore }}</p>
        </div>
        
        <div class="p-6">
            @php
                $correctCount = 0;
                $wrongCount = 0;
                if($package->category != 'tkp') {
                    foreach($results as $r) {
                        if($r['is_correct']) {
                            $correctCount++;
                        } else {
                            $wrongCount++;
                        }
                    }
                }
            @endphp
            
            <div class="grid grid-cols-3 gap-3 text-center mb-6">
                <div class="p-3 bg-purple-50 rounded-xl">
                    <div class="text-2xl font-bold text-purple-600">{{ count($results) }}</div>
                    <div class="text-xs text-gray-500 mt-1">Total Soal</div>
                </div>
                @if($package->category != 'tkp')
                <div class="p-3 bg-green-50 rounded-xl">
                    <div class="text-2xl font-bold text-green-600">{{ $correctCount }}</div>
                    <div class="text-xs text-gray-500 mt-1">Benar</div>
                </div>
                <div class="p-3 bg-red-50 rounded-xl">
                    <div class="text-2xl font-bold text-red-600">{{ $wrongCount }}</div>
                    <div class="text-xs text-gray-500 mt-1">Salah</div>
                </div>
                @else
                <div class="p-3 bg-green-50 rounded-xl">
                    <div class="text-2xl font-bold text-green-600">{{ round($score / $maxScore * 100) }}%</div>
                    <div class="text-xs text-gray-500 mt-1">Persentase</div>
                </div>
                <div class="p-3 bg-blue-50 rounded-xl">
                    <div class="text-2xl font-bold text-blue-600">{{ round($score / count($results), 1) }}</div>
                    <div class="text-xs text-gray-500 mt-1">Rata-rata/Soal</div>
                </div>
                @endif
            </div>
            
            <!-- Grafik Batang Perolehan Nilai -->
            <div class="mb-6">
                <h3 class="font-semibold text-gray-800 mb-3 text-sm">📊 Analisis Perolehan Nilai</h3>
                <div class="space-y-2">
                    @php
                        $totalQuestions = count($results);
                        $correctAnswers = 0;
                        $totalPoints = 0;
                        $maxPoints = 0;
                        foreach($results as $r) {
                            if($r['is_correct'] ?? false) $correctAnswers++;
                            $totalPoints += $r['points'];
                            $maxPoints += $r['max_points'];
                        }
                        $scorePercent = $totalQuestions > 0 ? round(($correctAnswers / $totalQuestions) * 100) : 0;
                    @endphp
                    <div>
                        <div class="flex justify-between text-xs text-gray-600 mb-0.5">
                            <span>🎯 Ketepatan Jawaban</span>
                            <span>{{ $correctAnswers }}/{{ $totalQuestions }} ({{ $scorePercent }}%)</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $scorePercent }}%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between text-xs text-gray-600 mb-0.5">
                            <span>⭐ Perolehan Poin</span>
                            <span>{{ $totalPoints }}/{{ $maxPoints }} ({{ round($percentage) }}%)</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-500 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Analisis Kelemahan -->
            @php
                $weakTopics = [];
                $wrongQuestions = [];
                foreach($results as $index => $r) {
                    if(!($r['is_correct'] ?? false) && $package->category != 'tkp') {
                        $wrongQuestions[] = [
                            'number' => $index + 1,
                            'text' => $r['question']->question_text,
                            'correct' => $r['correct_answer'],
                            'explanation' => $r['explanation']
                        ];
                    }
                }
                $weaknessCount = count($wrongQuestions);
            @endphp
            
            @if($weaknessCount > 0)
            <div class="bg-yellow-50 rounded-xl p-4 mb-6">
                <div class="flex items-start gap-3">
                    <div class="text-2xl">💡</div>
                    <div>
                        <h3 class="font-semibold text-gray-800">Analisis Kelemahan</h3>
                        <p class="text-sm text-gray-600 mt-1">Anda salah menjawab <strong>{{ $weaknessCount }}</strong> soal. Fokus pelajari materi berikut:</p>
                        <ul class="list-disc list-inside text-sm text-gray-600 mt-2 space-y-1">
                            @foreach(array_slice($wrongQuestions, 0, 3) as $wq)
                            <li>Soal No {{ $wq['number'] }}: {{ Str::limit($wq['text'], 60) }}</li>
                            @endforeach
                            @if($weaknessCount > 3)
                            <li>... dan {{ $weaknessCount - 3 }} soal lainnya</li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Saran Belajar -->
            <div class="bg-blue-50 rounded-xl p-4 mb-6">
                <div class="flex items-start gap-3">
                    <div class="text-2xl">📚</div>
                    <div>
                        <h3 class="font-semibold text-gray-800">Saran Belajar</h3>
                        <p class="text-sm text-gray-600 mt-1">
                            @if($percentage >= 80)
                                🌟 Hebat! Pertahankan prestasimu. Coba kerjakan paket soal dengan level lebih tinggi.
                            @elseif($percentage >= 60)
                                📚 Lumayan! Tingkatkan lagi dengan fokus pada soal yang salah. Ulangi test ini besok.
                            @else
                                💪 Jangan menyerah! Pelajari dulu materi dasar, lalu coba lagi. Konsistensi adalah kunci.
                            @endif
                        </p>
                        <div class="mt-3">
                            <a href="{{ route('packages.index') }}?category={{ $package->category }}" 
                               class="inline-block bg-blue-500 text-white px-4 py-1.5 rounded-lg text-sm hover:bg-blue-600 transition">
                                📦 Coba Paket Lain
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            
            <div class="flex gap-3 justify-center">
                <a href="{{ route('packages.start', $package->id) }}" class="bg-purple-600 text-white px-5 py-2 rounded-lg hover:bg-purple-700 transition">
                    🔄 Ulangi Test
                </a>
                <a href="{{ route('packages.index') }}" class="bg-gray-500 text-white px-5 py-2 rounded-lg hover:bg-gray-600 transition">
                    📦 Paket Lain
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
                            <span class="text-xs px-2 py-0.5 rounded-full {{ ($r['is_correct'] ?? false) || $package->category == 'tkp' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                                Poin: {{ $r['points'] }}/{{ $r['max_points'] }}
                            </span>
                            @if((!$r['is_correct'] ?? false) && $package->category != 'tkp')
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
                            <span class="font-medium {{ ($r['is_correct'] ?? false) || $package->category == 'tkp' ? 'text-blue-600' : 'text-red-600' }}">
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

@push('scripts')
<script>
    localStorage.removeItem('package_answers_{{ $package->id }}');
    localStorage.removeItem('package_flagged_{{ $package->id }}');
</script>
@endpush
@endsection