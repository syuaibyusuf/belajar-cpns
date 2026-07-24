<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Test - Belajar CPNS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-100 font-[Inter]">
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <a href="{{ route('home') }}" class="inline-flex items-center text-purple-600 mb-6">← Kembali ke Home</a>

        <div class="bg-white rounded-xl shadow-lg p-8 text-center mb-8">
            <h1 class="text-3xl font-bold mb-4">🎉 Hasil Test Anda</h1>
            <div class="text-6xl font-bold text-purple-600 my-4">{{ round($percentage) }}%</div>
            <p>Skor: {{ $score }} / {{ $maxScore }}</p>
            
            @if($percentage >= 80)
                <p class="text-green-600 mt-4">🌟 Hebat! Pertahankan belajarmu!</p>
            @elseif($percentage >= 60)
                <p class="text-yellow-600 mt-4">📚 Lumayan, tingkatkan lagi!</p>
            @else
                <p class="text-red-600 mt-4">💪 Ayo belajar lebih giat lagi!</p>
            @endif
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <h2 class="text-xl font-bold mb-4">📝 Pembahasan Soal</h2>
            @foreach($results as $index => $r)
            <div class="border-b py-4">
                <div class="flex items-start gap-3">
                    <span class="text-2xl">{{ $r['is_correct'] ? '✅' : '❌' }}</span>
                    <div>
                        <p class="font-semibold">Soal {{ $index+1 }}: {{ $r['question']->question_text }}</p>
                        <p class="text-sm">Jawaban Anda: <strong>{{ strtoupper($r['user_answer']) }}</strong></p>
                        @if(!$r['is_correct'])
                        <p class="text-sm text-green-600">Jawaban benar: <strong>{{ strtoupper($r['correct_answer']) }}</strong></p>
                        @endif
                        @if($r['explanation'])
                        <p class="text-sm text-gray-500 mt-1">💡 {{ $r['explanation'] }}</p>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</body>
</html>