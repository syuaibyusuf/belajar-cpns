@extends('layouts.user')

@section('title', $package->name)
@section('page-title', $package->name)

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <a href="{{ route('quick-packages.index') }}" class="text-purple-600 hover:underline">← Kembali ke Daftar Paket Cepat</a>
    </div>

    <div class="bg-gradient-to-r 
        @if($package->category == 'twk') from-red-500 to-red-600
        @elseif($package->category == 'tiu') from-blue-500 to-blue-600
        @else from-green-500 to-green-600 @endif 
        rounded-2xl p-5 text-white mb-6">
        <div class="flex justify-between items-center">
            <div>
                <div class="text-3xl mb-2">⚡</div>
                <h1 class="text-xl font-bold">{{ $package->name }}</h1>
                <p class="text-sm opacity-90 mt-1">Total {{ $questions->count() }} soal • Tidak ada batas waktu</p>
            </div>
            <div class="text-right">
                <div class="text-sm bg-white/20 px-3 py-1 rounded-full">
                    @if($package->category == 'tkp')
                        Skala 1-5
                    @else
                        Benar = 5 poin
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Progress Bar -->
    <div class="bg-white rounded-xl shadow-sm p-4 mb-6">
        <div class="flex justify-between text-sm text-gray-600 mb-2">
            <span><i class="fas fa-list-check mr-1"></i> Progress Mengerjakan</span>
            <span id="progressCount">0/{{ $questions->count() }}</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2.5 overflow-hidden">
            <div id="progressBar" class="bg-gradient-to-r from-purple-500 to-pink-500 h-2.5 rounded-full transition-all duration-500" style="width: 0%"></div>
        </div>
    </div>

    <!-- Navigasi Soal + Tombol Lompat ke Soal Kosong -->
    <div class="bg-white rounded-xl shadow-sm p-4 mb-6">
        <div class="flex justify-between items-center mb-3">
            <h3 class="font-semibold text-gray-700 text-sm">📌 Navigasi Soal</h3>
            <button type="button" onclick="goToNextUnanswered()" class="text-sm bg-purple-100 text-purple-600 px-3 py-1 rounded-lg hover:bg-purple-200 transition">
                <i class="fas fa-forward mr-1"></i> Lompat ke Soal Kosong
            </button>
        </div>
        <div class="grid grid-cols-5 sm:grid-cols-10 gap-2" id="questionNav">
            @for($i = 1; $i <= $questions->count(); $i++)
            <button type="button" 
                    onclick="goToQuestion({{ $i-1 }})" 
                    id="nav-{{ $i-1 }}"
                    class="nav-btn w-8 h-8 rounded-lg text-sm font-medium transition-all
                           bg-gray-100 text-gray-600 hover:bg-purple-100">
                {{ $i }}
            </button>
            @endfor
        </div>
    </div>

    <form method="POST" action="{{ route('quick-packages.submit', $package->id) }}" id="examForm">
        @csrf
        
        @foreach($questions as $index => $q)
        <div class="bg-white rounded-2xl shadow-sm mb-5 overflow-hidden question-card" data-index="{{ $index }}" id="question-{{ $index }}" style="display: {{ $index == 0 ? 'block' : 'none' }}">
            <div class="bg-gray-50 px-5 py-3 border-b flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <span class="w-7 h-7 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center text-sm font-bold">{{ $index + 1 }}</span>
                    <span class="font-medium text-gray-700">Soal</span>
                </div>
                @if($package->category != 'tkp')
                <span class="text-xs text-gray-400">Poin: {{ $q->points ?? 5 }} jika benar</span>
                @else
                <span class="text-xs text-gray-400">Skala 1-5</span>
                @endif
            </div>
            <div class="p-5">
                <!-- Teks Soal -->
                <p class="text-gray-800 font-medium mb-4">{{ $q->question_text }}</p>
                
                <!-- Gambar Soal -->
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
                               onchange="saveAnswer({{ $index }}, '{{ $opt }}'); updateProgress(); updateNavStyle({{ $index }}, true)">
                        <div class="ml-3 flex-1">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="font-semibold uppercase bg-gray-100 px-2 py-0.5 rounded text-sm">{{ $opt }}</span>
                                <span class="text-gray-700 group-hover:text-purple-700 transition">{{ $q->{'option_' . $opt} }}</span>
                                @if($package->category == 'tkp' && $q->{'score_' . $opt} > 0)
                                <span class="text-xs bg-blue-100 text-blue-600 px-2 py-0.5 rounded-full">
                                    Nilai: {{ $q->{'score_' . $opt} }}
                                </span>
                                @endif
                            </div>
                            <!-- Gambar Opsi -->
                            @if($q->{'image_' . $opt})
                            <div class="mt-2">
                                <img src="{{ $q->{'image_' . $opt} }}" class="max-w-full max-h-32 rounded-lg border" alt="Gambar Opsi {{ strtoupper($opt) }}">
                            </div>
                            @endif
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>
        </div>
        @endforeach
        
        <!-- Navigasi Buttons -->
        <div class="flex justify-between gap-3 mt-4">
            <button type="button" onclick="prevQuestion()" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition">
                ◀ Sebelumnya
            </button>
            <button type="button" onclick="nextQuestion()" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 transition">
                Selanjutnya ▶
            </button>
        </div>
        
        <!-- Submit Button -->
        <div class="mt-6">
            <button type="submit" class="w-full bg-gradient-to-r from-green-500 to-emerald-600 text-white py-3 rounded-xl font-bold hover:shadow-lg transition-all">
                <i class="fas fa-check-circle mr-2"></i>
                Selesai & Lihat Hasil
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    let currentQuestion = 0;
    let totalQuestions = {{ $questions->count() }};
    let answers = JSON.parse(localStorage.getItem('quick_package_answers_{{ $package->id }}') || '{}');
    
    function saveAnswer(index, answer) {
        answers[index] = answer;
        localStorage.setItem('quick_package_answers_{{ $package->id }}', JSON.stringify(answers));
        updateProgress();
        updateNavStyle(index, true);
    }
    
    function loadAnswers() {
        for(let i in answers) {
            let radio = document.querySelector(`input[name="answers[${i}]"][value="${answers[i]}"]`);
            if(radio) radio.checked = true;
            updateNavStyle(i, true);
        }
        updateProgress();
    }
    
    function updateNavStyle(index, isAnswered) {
        let navBtn = document.getElementById(`nav-${index}`);
        if(navBtn) {
            if(isAnswered) {
                navBtn.classList.remove('bg-gray-100', 'text-gray-600');
                navBtn.classList.add('bg-green-500', 'text-white');
            } else {
                navBtn.classList.remove('bg-green-500', 'text-white');
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
    
    function goToQuestion(index) {
        for(let i = 0; i < totalQuestions; i++) {
            let q = document.getElementById(`question-${i}`);
            if(q) q.style.display = 'none';
        }
        let selected = document.getElementById(`question-${index}`);
        if(selected) selected.style.display = 'block';
        currentQuestion = index;
    }
    
    function goToNextUnanswered() {
        for(let i = 0; i < totalQuestions; i++) {
            if(!answers[i]) {
                goToQuestion(i);
                return;
            }
        }
        // Jika semua sudah dijawab, beri notifikasi
        alert('Semua soal sudah Anda jawab! Silakan selesaikan test.');
    }
    
    function nextQuestion() {
        if(currentQuestion < totalQuestions - 1) {
            // Cek apakah soal selanjutnya sudah dijawab? Langsung pindah
            goToQuestion(currentQuestion + 1);
        } else if(currentQuestion == totalQuestions - 1) {
            // Jika sudah di soal terakhir, cari soal yang belum dijawab
            for(let i = 0; i < totalQuestions; i++) {
                if(!answers[i]) {
                    goToQuestion(i);
                    return;
                }
            }
            alert('Anda telah mencapai soal terakhir. Silakan selesaikan test!');
        }
    }
    
    function prevQuestion() {
        if(currentQuestion > 0) {
            goToQuestion(currentQuestion - 1);
        }
    }
    
    window.onload = function() {
        loadAnswers();
        goToQuestion(0);
    }
</script>
@endpush
@endsection