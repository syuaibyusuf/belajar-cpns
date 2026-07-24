@extends('layouts.user')

@section('title', 'Latihan Soal')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('latihan') }}" class="inline-flex items-center text-purple-600 hover:text-purple-700 transition">
            <i class="fas fa-arrow-left mr-2"></i> Kembali
        </a>
    </div>

    <div class="bg-gradient-to-r from-purple-600 to-indigo-600 rounded-2xl p-6 text-white mb-6">
        <h1 class="text-2xl font-bold mb-2">📝 Latihan Soal</h1>
        <p class="opacity-90">Total {{ $totalQuestions }} soal • Jawab dengan teliti</p>
        <div class="mt-3 flex items-center gap-2">
            <i class="fas fa-lightbulb text-yellow-300"></i>
            <span class="text-sm">Pilih jawaban yang paling tepat</span>
        </div>
    </div>

    <!-- Progress Bar -->
    <div class="bg-white rounded-xl shadow-sm p-4 mb-6">
        <div class="flex justify-between text-sm text-gray-600 mb-2">
            <span>Progress Mengerjakan</span>
            <span id="progressCount">0/{{ $totalQuestions }}</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
            <div id="progressBar" class="bg-gradient-to-r from-purple-500 to-pink-500 h-2 rounded-full transition-all duration-500" style="width: 0%"></div>
        </div>
    </div>

    <form method="POST" action="{{ route('submit', $category) }}" id="examForm">
        @csrf
        
        @foreach($questions as $index => $q)
        <div class="bg-white rounded-2xl shadow-sm mb-6 overflow-hidden question-card" data-index="{{ $index }}">
            <div class="bg-gray-50 px-6 py-4 border-b">
                <div class="flex justify-between items-center">
                    <span class="font-semibold text-gray-700">
                        <i class="fas fa-question-circle text-purple-500 mr-2"></i>
                        Soal {{ $index + 1 }} dari {{ $totalQuestions }}
                    </span>
                    <span class="text-xs text-gray-400">Poin: {{ $q->points ?? 1 }}</span>
                </div>
            </div>
            <div class="p-6">
                <p class="text-lg font-medium text-gray-800 mb-6">{{ $q->question_text }}</p>
                
                <div class="space-y-3">
                    @foreach(['a', 'b', 'c', 'd', 'e'] as $opt)
                    <label class="flex items-center p-4 border rounded-xl cursor-pointer hover:bg-purple-50 transition-all group">
                        <input type="radio" 
                               name="answers[{{ $index }}]" 
                               value="{{ $opt }}"
                               class="w-5 h-5 text-purple-600 focus:ring-purple-500"
                               onchange="saveAnswer({{ $index }}, '{{ $opt }}'); updateProgress()">
                        <span class="ml-4 text-gray-700 group-hover:text-purple-700 transition">
                            <span class="font-bold uppercase bg-gray-100 px-2 py-1 rounded text-sm mr-2">{{ $opt }}</span>
                            {{ $q->{'option_' . $opt} }}
                        </span>
                    </label>
                    @endforeach
                </div>
            </div>
        </div>
        @endforeach
        
        <div class="sticky bottom-4 bg-white rounded-xl shadow-lg p-4 border-t-4 border-purple-500">
            <button type="submit" class="w-full bg-gradient-to-r from-green-500 to-emerald-600 text-white py-3 rounded-xl font-bold hover:shadow-lg transition-all transform hover:scale-[1.02]">
                <i class="fas fa-check-circle mr-2"></i>
                Selesai & Lihat Hasil
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function saveAnswer(questionIndex, answer) {
        let answers = JSON.parse(localStorage.getItem('exam_answers_{{ $category }}') || '{}');
        answers[questionIndex] = answer;
        localStorage.setItem('exam_answers_{{ $category }}', JSON.stringify(answers));
    }

    function loadAnswers() {
        let savedAnswers = JSON.parse(localStorage.getItem('exam_answers_{{ $category }}') || '{}');
        for (let i in savedAnswers) {
            let radio = document.querySelector(`input[name="answers[${i}]"][value="${savedAnswers[i]}"]`);
            if (radio) radio.checked = true;
        }
        updateProgress();
    }

    function updateProgress() {
        let total = {{ $totalQuestions }};
        let savedAnswers = JSON.parse(localStorage.getItem('exam_answers_{{ $category }}') || '{}');
        let answered = Object.keys(savedAnswers).length;
        let progress = (answered / total) * 100;
        
        document.getElementById('progressBar').style.width = progress + '%';
        document.getElementById('progressCount').innerText = answered + '/' + total;
    }

    window.onload = function() {
        loadAnswers();
    }
</script>
@endpush
@endsection