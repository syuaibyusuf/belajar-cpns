<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>Hasil Test CPNS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        @media (max-width: 640px) {
            .result-card {
                border-radius: 1rem;
            }
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="container mx-auto px-3 md:px-4 py-4 md:py-8 max-w-4xl">
        <!-- Tombol Back -->
        <a href="{{ route('home') }}" class="inline-flex items-center text-purple-600 hover:text-purple-700 mb-4 text-sm md:text-base">
            ← Kembali ke Home
        </a>

        <!-- Card Hasil -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-6 md:mb-8">
            <div class="bg-gradient-to-r from-green-500 to-green-600 px-5 py-6 md:px-6 md:py-8 text-center text-white">
                <h1 class="text-2xl md:text-3xl font-bold mb-2">🎉 Hasil Test Anda</h1>
                <div class="text-5xl md:text-6xl font-bold my-3 md:my-4">{{ $score }} / {{ $total }}</div>
                <p class="text-lg md:text-xl">Nilai: {{ round(($score/$total)*100) }}%</p>
            </div>
            
            <div class="p-5 md:p-6">
                <div class="text-center mb-4 md:mb-6">
                    @if(($score/$total)*100 >= 80)
                        <p class="text-green-600 text-lg md:text-xl">🌟 Hebat! Pertahankan belajarmu!</p>
                    @elseif(($score/$total)*100 >= 60)
                        <p class="text-yellow-600 text-lg md:text-xl">📚 Lumayan, tingkatkan lagi!</p>
                    @else
                        <p class="text-red-600 text-lg md:text-xl">💪 Ayo belajar lebih giat lagi!</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Pembahasan Soal -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-5 py-3 md:px-6 md:py-4">
                <h2 class="text-lg md:text-xl font-bold text-white">📝 Pembahasan Soal</h2>
            </div>
            <div class="p-4 md:p-6 space-y-4 md:space-y-6">
                @foreach($results as $index => $result)
                <div class="border-b border-gray-200 pb-4 last:border-0">
                    <div class="flex items-start gap-2 md:gap-3">
                        <div class="flex-shrink-0 text-xl md:text-2xl">
                            @if($result['is_correct'])
                                <span>✅</span>
                            @else
                                <span>❌</span>
                            @endif
                        </div>
                        <div class="flex-grow">
                            <p class="font-semibold text-gray-800 text-sm md:text-base mb-2">
                                Soal {{ $index + 1 }}: {{ $result['question']->question_text }}
                            </p>
                            <p class="text-xs md:text-sm text-gray-600">
                                Jawaban Anda: <span class="font-bold uppercase">{{ $result['user_answer'] }}</span>
                                @if(!$result['is_correct'])
                                    <br>Jawaban benar: <span class="font-bold text-green-600 uppercase">{{ $result['question']->correct_answer }}</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="px-4 py-4 md:px-6 md:py-4 bg-gray-50 border-t flex flex-col md:flex-row gap-3">
                <a href="{{ route('test', $category) }}" 
                   class="block text-center bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition active:bg-blue-700">
                    🔄 Ulangi Test
                </a>
                <a href="{{ route('home') }}" 
                   class="block text-center bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600 transition active:bg-gray-700">
                    🏠 Kembali ke Home
                </a>
            </div>
        </div>
    </div>

    <script>
        // Hapus jawaban tersimpan setelah selesai
        localStorage.removeItem('exam_answers_{{ $category }}');
    </script>
</body>
</html>