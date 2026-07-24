<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>Test CPNS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        /* Untuk touch-friendly */
        input[type="radio"] {
            width: 20px;
            height: 20px;
            cursor: pointer;
        }
        label {
            cursor: pointer;
            -webkit-tap-highlight-color: transparent;
        }
        .option-label:active {
            background-color: #f3f4f6;
        }
        /* Sticky submit button */
        .sticky-submit {
            position: sticky;
            bottom: 0;
            z-index: 40;
        }
        /* Untuk smooth scroll */
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="container mx-auto px-3 md:px-4 py-3 md:py-8 max-w-3xl">
        <!-- Header -->
        <div class="mb-4 md:mb-6">
            <a href="{{ route('home') }}" class="inline-flex items-center text-purple-600 hover:text-purple-700 mb-3 text-sm md:text-base">
                ← Kembali
            </a>
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl p-3 md:p-4 text-white">
                <h1 class="text-lg md:text-xl font-bold">📝 Latihan Soal {{ strtoupper($category) }}</h1>
                <p class="text-xs md:text-sm opacity-90">Jawab semua soal dengan teliti</p>
                <div class="text-right text-xs md:text-sm mt-1">
                    Total: {{ count($questions) }} soal
                </div>
            </div>
        </div>

        <!-- Progress Bar Sederhana -->
        <div class="bg-white rounded-lg shadow p-2 mb-4">
            <div class="flex justify-between text-xs text-gray-600 mb-1 px-1">
                <span>Progress</span>
                <span id="progressCount">0/{{ count($questions) }}</span>
            </div>
            <div class="bg-gray-200 rounded-full h-2 overflow-hidden">
                <div id="progressBar" class="bg-green-500 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
            </div>
        </div>

        <form method="POST" action="{{ route('submit', $category) }}" id="examForm">
            @csrf
            
            @foreach($questions as $index => $question)
            <div class="bg-white rounded-xl shadow-lg mb-4 md:mb-6 overflow-hidden" id="question-{{ $index }}">
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-4 py-3 md:px-6 md:py-4">
                    <h2 class="text-white font-bold text-sm md:text-base">
                        Soal {{ $index + 1 }} dari {{ count($questions) }}
                    </h2>
                </div>
                <div class="p-4 md:p-6">
                    <p class="text-base md:text-lg font-semibold text-gray-800 mb-4 md:mb-6">
                        {{ $question->question_text }}
                    </p>
                    
                    <div class="space-y-2 md:space-y-3">
                        @foreach(['a', 'b', 'c', 'd', 'e'] as $option)
                        <label class="option-label flex items-center p-3 md:p-4 border rounded-lg hover:bg-gray-50 transition active:bg-gray-100 cursor-pointer">
                            <input type="radio" 
                                   name="answers[{{ $index }}]" 
                                   value="{{ $option }}"
                                   class="w-5 h-5 text-blue-600"
                                   onchange="saveAnswer({{ $index }}, '{{ $option }}'); updateProgress()">
                            <span class="ml-3 text-gray-700 text-sm md:text-base">
                                <span class="font-bold uppercase">{{ $option }}.</span> 
                                {{ $question->{'option_' . $option} }}
                            </span>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach
            
            <!-- Sticky Submit Button untuk HP -->
            <div class="sticky-submit bg-white rounded-xl shadow-lg p-3 md:p-4 border-t-4 border-green-500 mt-4">
                <button type="submit" 
                        class="w-full bg-green-500 text-white py-3 md:py-3 rounded-lg font-bold hover:bg-green-600 transition active:bg-green-700 text-base md:text-lg">
                    ✅ Selesai & Lihat Hasil
                </button>
            </div>
        </form>
    </div>

    <script>
        // Simpan jawaban di localStorage
        function saveAnswer(questionIndex, answer) {
            let answers = JSON.parse(localStorage.getItem('exam_answers_{{ $category }}') || '{}');
            answers[questionIndex] = answer;
            localStorage.setItem('exam_answers_{{ $category }}', JSON.stringify(answers));
        }

        // Load jawaban yang tersimpan
        function loadAnswers() {
            let savedAnswers = JSON.parse(localStorage.getItem('exam_answers_{{ $category }}') || '{}');
            for (let i in savedAnswers) {
                let radio = document.querySelector(`input[name="answers[${i}]"][value="${savedAnswers[i]}"]`);
                if (radio) radio.checked = true;
            }
            updateProgress();
        }

        // Update progress bar
        function updateProgress() {
            let total = {{ count($questions) }};
            let savedAnswers = JSON.parse(localStorage.getItem('exam_answers_{{ $category }}') || '{}');
            let answered = Object.keys(savedAnswers).length;
            let progress = (answered / total) * 100;
            
            document.getElementById('progressBar').style.width = progress + '%';
            document.getElementById('progressCount').innerText = answered + '/' + total;
        }

        // Load saat halaman dibuka
        window.onload = function() {
            loadAnswers();
        }
    </script>
</body>
</html>