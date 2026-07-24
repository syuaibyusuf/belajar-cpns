@extends('layouts.user')

@section('title', $tryout->name)
@section('page-title', $tryout->name)
@section('breadcrumb')
    <a href="{{ route('home') }}" class="text-purple-600">Home</a> / 
    <a href="{{ route('tryouts.index') }}" class="text-purple-600">Try Out</a> / 
    {{ $tryout->name }}
@endsection

@section('content')
<style>
    .timer-box {
        background: linear-gradient(135deg, #1e1b4b 0%, #4c1d95 100%);
        transition: all 0.3s ease;
    }
    .timer-box.warning {
        background: linear-gradient(135deg, #991b1b 0%, #dc2626 100%);
        animation: pulse 1s infinite;
    }
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
    }
    .nav-sticky {
        position: sticky;
        top: 80px;
        height: fit-content;
    }
    .progress-category {
        transition: all 0.3s ease;
    }
    .nav-btn {
        transition: all 0.2s ease;
    }
    .nav-btn.answered {
        background-color: #10b981;
        color: white;
    }
    .nav-btn.current {
        background-color: #8b5cf6;
        color: white;
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(139, 92, 246, 0.4);
    }
    .question-card {
        animation: fadeIn 0.3s ease-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="max-w-7xl mx-auto">
    <!-- Header dengan Timer -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
        <div>
            <h1 class="text-xl md:text-2xl font-bold text-gray-800">{{ $tryout->name }}</h1>
            <p class="text-gray-500 text-sm">{{ $tryout->total_questions }} Soal (TWK {{ $tryout->total_questions_twk }}, TIU {{ $tryout->total_questions_tiu }}, TKP {{ $tryout->total_questions_tkp }})</p>
        </div>
        <div class="timer-box rounded-2xl px-6 py-3 text-white text-center shadow-lg">
            <div class="text-xs opacity-80">Sisa Waktu</div>
            <div id="timer" class="text-2xl md:text-3xl font-bold font-mono">{{ sprintf('%02d', floor($tryout->duration / 60)) }}:{{ sprintf('%02d', $tryout->duration % 60) }}:00</div>
        </div>
    </div>

    <!-- Progress per Kategori -->
    <div class="grid grid-cols-3 gap-3 mb-6">
        <div class="bg-red-50 rounded-xl p-3 text-center progress-category">
            <div class="text-lg">🇮🇩 TWK</div>
            <div class="text-2xl font-bold text-red-600" id="twkProgress">0/30</div>
            <div class="w-full bg-red-200 rounded-full h-1.5 mt-1">
                <div id="twkBar" class="bg-red-500 h-1.5 rounded-full" style="width: 0%"></div>
            </div>
        </div>
        <div class="bg-blue-50 rounded-xl p-3 text-center progress-category">
            <div class="text-lg">🧠 TIU</div>
            <div class="text-2xl font-bold text-blue-600" id="tiuProgress">0/35</div>
            <div class="w-full bg-blue-200 rounded-full h-1.5 mt-1">
                <div id="tiuBar" class="bg-blue-500 h-1.5 rounded-full" style="width: 0%"></div>
            </div>
        </div>
        <div class="bg-green-50 rounded-xl p-3 text-center progress-category">
            <div class="text-lg">💼 TKP</div>
            <div class="text-2xl font-bold text-green-600" id="tkpProgress">0/45</div>
            <div class="w-full bg-green-200 rounded-full h-1.5 mt-1">
                <div id="tkpBar" class="bg-green-500 h-1.5 rounded-full" style="width: 0%"></div>
            </div>
        </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-6">
        <!-- KOLOM KIRI: SOAL -->
        <div class="flex-1">
            <form method="POST" action="{{ route('tryouts.submit', $tryout->id) }}" id="examForm">
                @csrf
                
                @foreach($questions as $index => $q)
                @php
                    $categoryClass = $q->category == 'twk' ? 'red' : ($q->category == 'tiu' ? 'blue' : 'green');
                    $categoryName = $q->category == 'twk' ? 'TWK' : ($q->category == 'tiu' ? 'TIU' : 'TKP');
                    $questionNumber = $index + 1;
                @endphp
                <div class="question-card bg-white rounded-2xl shadow-sm mb-5 overflow-hidden" id="question-{{ $questionNumber }}" style="display: {{ $index == 0 ? 'block' : 'none' }}">
                    <div class="bg-{{ $categoryClass }}-50 px-5 py-3 border-b flex justify-between items-center">
                        <div class="flex items-center gap-2">
                            <span class="w-7 h-7 rounded-full bg-{{ $categoryClass }}-100 text-{{ $categoryClass }}-600 flex items-center justify-center text-sm font-bold">{{ $questionNumber }}</span>
                            <span class="font-medium text-gray-700">Soal {{ $questionNumber }}</span>
                            <span class="text-xs px-2 py-0.5 rounded-full bg-{{ $categoryClass }}-100 text-{{ $categoryClass }}-600">
                                {{ $categoryName }}
                            </span>
                        </div>
                    </div>
                    <div class="p-5">
                        <p class="text-gray-800 font-medium mb-4">{{ $q->question_text }}</p>
                        
                        @if($q->question_image)
                        <div class="mb-5 flex justify-center">
                            <img src="{{ $q->question_image }}" class="max-w-full max-h-64 rounded-lg border shadow-sm" alt="Gambar Soal">
                        </div>
                        @endif
                        
                        <div class="space-y-3">
                            @foreach(['a', 'b', 'c', 'd', 'e'] as $opt)
                            <label class="flex items-start p-3 border rounded-xl cursor-pointer hover:bg-purple-50 transition-all group">
                                <input type="radio" 
                                       name="answers[{{ $index }}]" 
                                       value="{{ $opt }}"
                                       class="w-4 h-4 mt-1 text-purple-600 focus:ring-purple-500"
                                       onchange="saveAnswer({{ $index }}, '{{ $opt }}', '{{ $q->category }}'); updateProgress()">
                                <div class="ml-3 flex-1">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <span class="font-semibold uppercase bg-gray-100 px-2 py-0.5 rounded text-sm">{{ $opt }}</span>
                                        <span class="text-gray-700 group-hover:text-purple-700 transition">{{ $q->{'option_' . $opt} }}</span>
                                    </div>
                                    @if($q->{'option_' . $opt . '_image'})
                                    <div class="mt-2">
                                        <img src="{{ $q->{'option_' . $opt . '_image'} }}" class="max-w-full max-h-32 rounded-lg border" alt="Gambar Opsi {{ strtoupper($opt) }}">
                                    </div>
                                    @endif
                                </div>
                            </label>
                            @endforeach
                        </div>

                        <!-- Navigasi Sebelumnya/Selanjutnya -->
                        <div class="flex gap-3 mt-5 pt-4 border-t">
                            <button type="button" onclick="prevQuestion()" class="flex-1 bg-gray-500 text-white py-2.5 rounded-lg text-sm hover:bg-gray-600 transition font-medium">
                                <i class="fas fa-chevron-left mr-1"></i> Sebelumnya
                            </button>
                            <button type="button" onclick="nextQuestion()" class="flex-1 bg-purple-600 text-white py-2.5 rounded-lg text-sm hover:bg-purple-700 transition font-medium">
                                Selanjutnya <i class="fas fa-chevron-right ml-1"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
                
                <!-- Submit Button -->
                <div class="mt-6">
                    <button type="submit" id="submitBtn" class="w-full bg-gradient-to-r from-green-500 to-emerald-600 text-white py-3 rounded-xl font-bold hover:shadow-lg transition-all">
                        <i class="fas fa-check-circle mr-2"></i>
                        Selesai & Lihat Hasil
                    </button>
                </div>
            </form>
        </div>

        <!-- KOLOM KANAN: NAVIGASI SOAL (STICKY) -->
        <div class="lg:w-80 flex-shrink-0">
            <div class="bg-white rounded-xl shadow-sm p-4 sticky top-24">
                <h3 class="font-semibold text-gray-700 text-sm mb-3 flex items-center gap-2">
                    <i class="fas fa-th-large text-purple-600"></i>
                    Navigasi Soal
                </h3>
                
                <!-- Grid Navigasi Soal -->
                <div class="grid grid-cols-5 gap-1.5 mb-4 max-h-96 overflow-y-auto p-1">
                    @for($i = 1; $i <= $tryout->total_questions; $i++)
                    @php
                        $twkEnd = $tryout->total_questions_twk;
                        $tiuEnd = $twkEnd + $tryout->total_questions_tiu;
                        $catColor = $i <= $twkEnd ? 'border-red-200 hover:border-red-400' : ($i <= $tiuEnd ? 'border-blue-200 hover:border-blue-400' : 'border-green-200 hover:border-green-400');
                    @endphp
                    <button type="button" 
                            onclick="goToQuestion({{ $i }})" 
                            id="nav-{{ $i }}"
                            class="nav-btn w-full aspect-square rounded-lg text-xs font-medium transition-all
                                   bg-gray-100 text-gray-600 border {{ $catColor }}
                                   hover:bg-purple-100">
                        {{ $i }}
                    </button>
                    @endfor
                </div>
                
                <!-- Progress Bar -->
                <div class="mb-4">
                    <div class="flex justify-between text-xs text-gray-600 mb-1">
                        <span>Progress Keseluruhan</span>
                        <span id="progressCount">0/{{ $tryout->total_questions }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                        <div id="progressBar" class="bg-gradient-to-r from-purple-500 to-pink-500 h-2 rounded-full transition-all" style="width: 0%"></div>
                    </div>
                </div>
                
                <!-- Tombol Lompat ke Soal Kosong -->
                <button type="button" onclick="goToNextUnanswered()" class="w-full bg-purple-100 text-purple-600 py-2 rounded-lg text-sm hover:bg-purple-200 transition mb-3">
                    <i class="fas fa-forward mr-1"></i> Lompat ke Soal Kosong
                </button>
                

            </div>
        </div>
    </div>
</div>

<script>
    let currentQuestion = 1;
    let totalQuestions = {{ $tryout->total_questions }};
    let twkTotal = {{ $tryout->total_questions_twk }};
    let tiuTotal = {{ $tryout->total_questions_tiu }};
    let tkpTotal = {{ $tryout->total_questions_tkp }};
    let twkEnd = twkTotal;
    let tiuEnd = twkEnd + tiuTotal;
    let answers = JSON.parse(localStorage.getItem('tryout_answers_{{ $tryout->id }}') || '{}');
    let timerInterval;
    let timeLeft = {{ $tryout->duration }} * 60; // dalam detik
    
    // Timer
    function updateTimerDisplay() {
        const hours = Math.floor(timeLeft / 3600);
        const minutes = Math.floor((timeLeft % 3600) / 60);
        const seconds = timeLeft % 60;
        const timerElement = document.getElementById('timer');
        if (timerElement) {
            timerElement.textContent = `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
            if (timeLeft <= 600) { // 10 menit tersisa
                timerElement.parentElement.classList.add('warning');
            }
        }
        if (timeLeft <= 0) {
            clearInterval(timerInterval);
            alert('Waktu habis! Test akan disubmit secara otomatis.');
            document.getElementById('examForm').submit();
        }
    }
    
    function startTimer() {
        updateTimerDisplay();
        timerInterval = setInterval(() => {
            if (timeLeft > 0) {
                timeLeft--;
                updateTimerDisplay();
                // Simpan waktu ke localStorage
                localStorage.setItem('tryout_time_{{ $tryout->id }}', timeLeft);
            } else {
                clearInterval(timerInterval);
                document.getElementById('examForm').submit();
            }
        }, 1000);
    }
    
    // Fungsi untuk update progress per kategori
    function updateCategoryProgress() {
        let twkAnswered = 0;
        let tiuAnswered = 0;
        let tkpAnswered = 0;
        
        for (let i = 1; i <= twkTotal; i++) {
            if (answers[i-1]) twkAnswered++;
        }
        for (let i = twkEnd + 1; i <= tiuEnd; i++) {
            if (answers[i-1]) tiuAnswered++;
        }
        for (let i = tiuEnd + 1; i <= totalQuestions; i++) {
            if (answers[i-1]) tkpAnswered++;
        }
        
        document.getElementById('twkProgress').innerText = twkAnswered + '/' + twkTotal;
        document.getElementById('tiuProgress').innerText = tiuAnswered + '/' + tiuTotal;
        document.getElementById('tkpProgress').innerText = tkpAnswered + '/' + tkpTotal;
        
        document.getElementById('twkBar').style.width = (twkAnswered / twkTotal) * 100 + '%';
        document.getElementById('tiuBar').style.width = (tiuAnswered / tiuTotal) * 100 + '%';
        document.getElementById('tkpBar').style.width = (tkpAnswered / tkpTotal) * 100 + '%';
    }
    
    function saveAnswer(index, answer, category) {
        answers[index] = answer;
        localStorage.setItem('tryout_answers_{{ $tryout->id }}', JSON.stringify(answers));
        updateNavStyle(index + 1, true);
        updateProgress();
        updateCategoryProgress();
    }
    
    function loadAnswers() {
        for(let i in answers) {
            let radio = document.querySelector(`input[name="answers[${i}]"][value="${answers[i]}"]`);
            if(radio) radio.checked = true;
            updateNavStyle(parseInt(i) + 1, true);
        }
        updateProgress();
        updateCategoryProgress();
    }
    
    function updateNavStyle(questionNumber, isAnswered) {
        let navBtn = document.getElementById(`nav-${questionNumber}`);
        if(navBtn) {
            if(isAnswered) {
                navBtn.classList.add('answered');
                navBtn.classList.remove('bg-gray-100', 'text-gray-600');
            } else {
                navBtn.classList.remove('answered');
                navBtn.classList.add('bg-gray-100', 'text-gray-600');
            }
        }
    }
    
    function updateProgress() {
        let answered = Object.keys(answers).length;
        let progress = (answered / totalQuestions) * 100;
        document.getElementById('progressBar').style.width = progress + '%';
        document.getElementById('progressCount').innerText = answered + '/' + totalQuestions;
    }
    
    function goToQuestion(questionNumber) {
        // Update current style
        document.querySelectorAll('.nav-btn').forEach(btn => {
            btn.classList.remove('current');
        });
        const currentNav = document.getElementById(`nav-${questionNumber}`);
        if (currentNav) currentNav.classList.add('current');
        
        // Tampilkan soal
        for(let i = 1; i <= totalQuestions; i++) {
            let q = document.getElementById(`question-${i}`);
            if(q) q.style.display = 'none';
        }
        let selected = document.getElementById(`question-${questionNumber}`);
        if(selected) selected.style.display = 'block';
        currentQuestion = questionNumber;
        
        // Scroll ke atas
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
    
    function goToNextUnanswered() {
        for(let i = 1; i <= totalQuestions; i++) {
            if(!answers[i-1]) {
                goToQuestion(i);
                return;
            }
        }
        alert('Semua soal sudah Anda jawab! Silakan selesaikan test.');
    }
    
    function nextQuestion() {
        if(currentQuestion < totalQuestions) {
            goToQuestion(currentQuestion + 1);
        } else {
            for(let i = 1; i <= totalQuestions; i++) {
                if(!answers[i-1]) {
                    goToQuestion(i);
                    return;
                }
            }
            alert('Anda telah mencapai soal terakhir. Silakan selesaikan test!');
        }
    }
    
    function prevQuestion() {
        if(currentQuestion > 1) {
            goToQuestion(currentQuestion - 1);
        }
    }
    
    // Confirm sebelum submit
    document.getElementById('examForm').addEventListener('submit', function(e) {
        const answered = Object.keys(answers).length;
        if (answered < totalQuestions) {
            if (!confirm(`Anda baru menjawab ${answered} dari ${totalQuestions} soal. Yakin ingin mengakhiri test?`)) {
                e.preventDefault();
            }
        }
    });
    
    window.onload = function() {
        loadAnswers();
        goToQuestion(1);
        
        // Load saved timer
        const savedTime = localStorage.getItem('tryout_time_{{ $tryout->id }}');
        if (savedTime) {
            timeLeft = parseInt(savedTime);
        }
        startTimer();
    }
    
    // Simpan timer sebelum page unload
    window.addEventListener('beforeunload', function() {
        localStorage.setItem('tryout_time_{{ $tryout->id }}', timeLeft);
    });
</script>
@endsection