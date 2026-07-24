@extends('layouts.user')

@section('title', $package->name)
@section('page-title', $package->name)

@section('content')
<div class="w-full max-w-7xl mx-auto">
    <!-- Header -->
    <div class="mb-4">
<a href="{{ route('packages.index') }}?category={{ $package->category }}" class="text-purple-600 hover:underline text-sm">← Kembali ke Daftar Paket</a>        
</div>

    <div class="bg-gradient-to-r 
        @if($package->category == 'twk') from-red-500 to-red-600
        @elseif($package->category == 'tiu') from-blue-500 to-blue-600
        @else from-green-500 to-green-600 @endif 
        rounded-xl p-4 text-white mb-5">
        <div class="flex justify-between items-center">
            <div>
                <div class="text-2xl mb-1">
                    @if($package->category == 'twk') 🇮🇩
                    @elseif($package->category == 'tiu') 🧠
                    @else 💼 @endif
                </div>
                <h1 class="text-lg font-bold">{{ $package->name }}</h1>
                <p class="text-xs opacity-90">Total {{ $questions->count() }} soal • Tidak ada batas waktu</p>
            </div>
            <div class="text-right text-xs bg-white/20 px-2 py-1 rounded-full">
                @if($package->category == 'tkp') Skala 1-5 @else Benar = 5 poin @endif
            </div>
        </div>
    </div>

    <!-- Dua Kolom: Soal (Kiri) + Navigasi (Kanan) -->
    <div class="flex flex-col lg:flex-row gap-6">
        <!-- KOLOM KIRI: SOAL -->
        <div class="flex-1">
          <form method="POST" action="{{ route('packages.submit', $package->id) }}" id="examForm">
                @csrf
                
                @foreach($questions as $index => $q)
                <div class="bg-white rounded-xl shadow-sm mb-4 overflow-hidden" data-index="{{ $index }}" id="question-{{ $index }}" style="display: {{ $index == 0 ? 'block' : 'none' }}">
                    <div class="bg-gray-50 px-4 py-2 border-b flex justify-between items-center">
                        <div class="flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center text-xs font-bold">{{ $index + 1 }}</span>
                            <span class="font-medium text-gray-700 text-sm">Soal</span>
                        </div>
                        <div class="flex items-center gap-3">
                            @if($package->category != 'tkp')
                            <span class="text-xs text-gray-400">Poin: 5 jika benar</span>
                            @else
                            <span class="text-xs text-gray-400">Skala 1-5</span>
                            @endif
                            <button type="button" onclick="toggleFlag({{ $index }})" id="flag-btn-{{ $index }}" class="text-gray-400 hover:text-yellow-500 transition text-sm" title="Tandai ragu-ragu">
                                <i class="far fa-flag"></i>
                            </button>
                        </div>
                    </div>
                    <div class="p-4">
                        <p class="text-gray-800 font-medium text-sm mb-3">{{ $q->question_text }}</p>
                        
                        @if($q->question_image)
                        <div class="mb-3 flex justify-center">
                            <img src="{{ $q->question_image }}" class="max-w-full max-h-48 rounded-lg border">
                        </div>
                        @endif
                        
                        <div class="space-y-2">
                            @foreach(['a', 'b', 'c', 'd', 'e'] as $opt)
                            <label class="flex items-start p-2 border rounded-lg cursor-pointer hover:bg-purple-50 transition-all text-sm">
                                <input type="radio" 
                                       name="answers[{{ $index }}]" 
                                       value="{{ $opt }}"
                                       class="w-3.5 h-3.5 mt-0.5 text-purple-600"
                                       onchange="saveAnswer({{ $index }}, '{{ $opt }}'); updateProgress(); updateNavStyle({{ $index }}, true)">
                                <div class="ml-2 flex-1">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <span class="font-semibold uppercase bg-gray-100 px-1.5 py-0.5 rounded text-xs">{{ $opt }}</span>
                                        <span class="text-gray-700">{{ $q->{'option_' . $opt} }}</span>
                                        @if($package->category == 'tkp' && $q->{'score_' . $opt} > 0)
                                        <span class="text-xs bg-blue-100 text-blue-600 px-1.5 py-0.5 rounded-full">
                                            Nilai: {{ $q->{'score_' . $opt} }}
                                        </span>
                                        @endif
                                    </div>
                                    @if($q->{'option_' . $opt . '_image'})
                                    <div class="mt-1">
                                        <img src="{{ $q->{'option_' . $opt . '_image'} }}" class="max-w-full max-h-20 rounded border">
                                    </div>
                                    @endif
                                </div>
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endforeach
                
                <!-- Navigasi Buttons (Mobile) -->
                <div class="flex justify-between gap-3 mt-4 lg:hidden">
                    <button type="button" onclick="prevQuestion()" class="bg-gray-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-gray-600">
                        ◀ Sebelumnya
                    </button>
                    <button type="button" onclick="nextQuestion()" class="bg-purple-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-purple-700">
                        Selanjutnya ▶
                    </button>
                </div>
                
                <!-- Submit Button -->
                <div class="mt-5">
                    <button type="submit" class="w-full bg-gradient-to-r from-green-500 to-emerald-600 text-white py-2.5 rounded-xl font-bold text-sm hover:shadow-lg">
                        <i class="fas fa-check-circle mr-1"></i> Selesai & Lihat Hasil
                    </button>
                </div>
            </form>
        </div>

        <!-- KOLOM KANAN: NAVIGASI SOAL -->
        <div class="lg:w-80 flex-shrink-0">
            <div class="bg-white rounded-xl shadow-sm p-4 sticky top-24">
                <h3 class="font-semibold text-gray-700 text-sm mb-3 flex items-center gap-2">
                    <i class="fas fa-th-large text-purple-600"></i>
                    Navigasi Soal
                </h3>
                
                <!-- Grid Navigasi -->
                <div class="grid grid-cols-5 gap-2 mb-4" id="questionNav">
                    @for($i = 1; $i <= $questions->count(); $i++)
                    <button type="button" 
                            onclick="goToQuestion({{ $i-1 }})" 
                            id="nav-{{ $i-1 }}"
                            class="nav-btn w-full aspect-square rounded-lg text-sm font-medium transition-all
                                   bg-gray-100 text-gray-600 hover:bg-purple-100">
                        {{ $i }}
                    </button>
                    @endfor
                </div>
                
                <!-- Progress Bar -->
                <div class="mb-4">
                    <div class="flex justify-between text-xs text-gray-600 mb-1">
                        <span>Progress</span>
                        <span id="progressCount">0/{{ $questions->count() }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                        <div id="progressBar" class="bg-gradient-to-r from-purple-500 to-pink-500 h-2 rounded-full transition-all" style="width: 0%"></div>
                    </div>
                </div>
                
                <!-- Keterangan Warna -->
                <div class="text-xs text-gray-500 space-y-1 mb-4">
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 bg-green-500 rounded"></div>
                        <span>Sudah dijawab</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 bg-gray-200 rounded"></div>
                        <span>Belum dijawab</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 bg-gray-200 rounded border-2 border-yellow-400"></div>
                        <span>Ditandai ragu</span>
                    </div>
                </div>
                
                <!-- Tombol Lompat ke Soal Kosong -->
                <button type="button" onclick="goToNextUnanswered()" class="w-full bg-purple-100 text-purple-600 py-2 rounded-lg text-sm hover:bg-purple-200 transition mb-3">
                    <i class="fas fa-forward mr-1"></i> Lompat ke Soal Kosong
                </button>
                
                <!-- Navigasi Buttons (Desktop) -->
                <div class="flex gap-3">
                    <button type="button" onclick="prevQuestion()" class="flex-1 bg-gray-500 text-white py-2 rounded-lg text-sm hover:bg-gray-600">
                        ◀ Sebelumnya
                    </button>
                    <button type="button" onclick="nextQuestion()" class="flex-1 bg-purple-600 text-white py-2 rounded-lg text-sm hover:bg-purple-700">
                        Selanjutnya ▶
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let currentQuestion = 0;
    let totalQuestions = {{ $questions->count() }};
    let answers = JSON.parse(localStorage.getItem('package_answers_{{ $package->id }}') || '{}');
    let flagged = JSON.parse(localStorage.getItem('package_flagged_{{ $package->id }}') || '{}');
    
    function saveAnswer(index, answer) {
        answers[index] = answer;
        localStorage.setItem('package_answers_{{ $package->id }}', JSON.stringify(answers));
        updateProgress();
        updateNavStyle(index, true);
    }
    
    function toggleFlag(index) {
        flagged[index] = !flagged[index];
        localStorage.setItem('package_flagged_{{ $package->id }}', JSON.stringify(flagged));
        updateFlagStyle(index);
    }
    
    function updateFlagStyle(index) {
        let btn = document.getElementById(`flag-btn-${index}`);
        if(btn) {
            if(flagged[index]) {
                btn.innerHTML = '<i class="fas fa-flag text-yellow-500"></i>';
                btn.classList.add('text-yellow-500');
            } else {
                btn.innerHTML = '<i class="far fa-flag"></i>';
                btn.classList.remove('text-yellow-500');
            }
        }
        updateNavFlagStyle(index);
    }
    
    function updateNavFlagStyle(index) {
        let navBtn = document.getElementById(`nav-${index}`);
        if(navBtn && flagged[index]) {
            navBtn.classList.add('border-2', 'border-yellow-400');
        } else if(navBtn) {
            navBtn.classList.remove('border-2', 'border-yellow-400');
        }
    }
    
    function loadFlags() {
        for(let i in flagged) {
            if(flagged[i]) updateFlagStyle(parseInt(i));
        }
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
            navBtn.classList.remove('bg-gray-100', 'text-gray-600', 'bg-green-500', 'text-white');
            if(isAnswered) {
                navBtn.classList.add('bg-green-500', 'text-white');
            } else {
                navBtn.classList.add('bg-gray-100', 'text-gray-600');
            }
            if(flagged[index]) {
                navBtn.classList.add('border-2', 'border-yellow-400');
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
        // Scroll ke atas
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
    
    function goToNextUnanswered() {
        for(let i = 0; i < totalQuestions; i++) {
            if(!answers[i]) {
                goToQuestion(i);
                return;
            }
        }
        alert('Semua soal sudah Anda jawab!');
    }
    
    function nextQuestion() {
        if(currentQuestion < totalQuestions - 1) {
            goToQuestion(currentQuestion + 1);
        } else {
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
        loadFlags();
        goToQuestion(0);
    }
</script>
@endpush
@endsection