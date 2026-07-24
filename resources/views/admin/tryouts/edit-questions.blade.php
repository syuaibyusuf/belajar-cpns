@extends('layouts.admin')

@section('title', 'Buat Soal Try Out - Admin')
@section('header', '📝 Buat Soal Try Out: ' . $tryout->name)

@push('styles')
<style>
    .question-card {
        transition: all 0.3s ease;
        scroll-margin-top: 100px;
    }
    .question-card:hover {
        box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1);
    }
    .nav-btn {
        transition: all 0.2s ease;
    }
    .nav-btn.active {
        background-color: #8b5cf6;
        color: white;
    }
    .progress-bar {
        transition: width 0.3s ease;
    }
</style>
@endpush

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.tryouts.edit', $tryout->id) }}" class="text-purple-600 hover:underline">← Kembali ke Edit Try Out</a>
</div>

<div class="bg-white rounded-xl shadow-sm p-6">
    <div class="flex justify-between items-center mb-4">
        <div>
            <h1 class="text-2xl font-bold">📝 Buat Soal Try Out: {{ $tryout->name }}</h1>
            <p class="text-gray-500 mt-1">Buat 110 soal (30 TWK + 35 TIU + 45 TKP)</p>
        </div>
        <div class="text-right">
            <div class="text-sm text-gray-600">Progress Soal:</div>
            <div class="text-3xl font-bold" id="filledCount">0</div>
            <div class="text-xs text-gray-400">Target: 110 soal</div>
        </div>
    </div>

    <!-- Progress Bar -->
    <div class="mb-6">
        <div class="flex justify-between text-sm text-gray-600 mb-1">
            <span>Progress Pembuatan Soal</span>
            <span id="progressPercent">0%</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2.5">
            <div id="progressBarFill" class="bg-purple-600 h-2.5 rounded-full progress-bar" style="width: 0%"></div>
        </div>
    </div>

    <!-- Navigasi Cepat -->
    <div class="bg-gray-50 rounded-lg p-4 mb-6">
        <div class="flex flex-wrap gap-2 mb-3">
            <span class="text-sm font-semibold text-gray-700">Lompat ke:</span>
            <button onclick="goToQuestion(1)" class="nav-btn px-3 py-1 rounded-lg text-sm bg-red-100 text-red-700 hover:bg-red-200">TWK (1-30)</button>
            <button onclick="goToQuestion(31)" class="nav-btn px-3 py-1 rounded-lg text-sm bg-blue-100 text-blue-700 hover:bg-blue-200">TIU (31-65)</button>
            <button onclick="goToQuestion(66)" class="nav-btn px-3 py-1 rounded-lg text-sm bg-green-100 text-green-700 hover:bg-green-200">TKP (66-110)</button>
        </div>
        <div class="text-xs text-gray-500">
            💡 Petunjuk: Setiap soal memiliki kategori yang sudah ditentukan. Untuk TKP, isi nilai (1-5) setiap opsi.
        </div>
    </div>

    <form method="POST" action="{{ route('admin.tryouts.save-questions', $tryout->id) }}" id="questionsForm" enctype="multipart/form-data" novalidate>
        @csrf
        
        @foreach($questions as $index => $q)
        @php
            $categoryClass = $q->category == 'twk' ? 'red' : ($q->category == 'tiu' ? 'blue' : 'green');
            $categoryName = $q->category == 'twk' ? 'TWK' : ($q->category == 'tiu' ? 'TIU' : 'TKP');
            $startNumber = $index + 1;
            $endNumber = $startNumber;
        @endphp
        <div class="question-card bg-white border rounded-xl mb-6 overflow-hidden" id="question-{{ $startNumber }}" data-question="{{ $startNumber }}">
            <input type="hidden" name="questions[{{ $index }}][id]" value="{{ $q->id }}">
            <div class="bg-{{ $categoryClass }}-50 px-5 py-3 border-b flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-{{ $categoryClass }}-100 text-{{ $categoryClass }}-600 flex items-center justify-center font-bold">
                        {{ $startNumber }}
                    </div>
                    <span class="font-semibold text-gray-800">Soal {{ $startNumber }}</span>
                    <span class="text-xs px-2 py-0.5 rounded-full bg-{{ $categoryClass }}-100 text-{{ $categoryClass }}-600">
                        {{ $categoryName }}
                    </span>
                </div>
                <span class="text-xs text-gray-400">
                    @if($q->category == 'tkp') Skala 1-5
                    @else TWK/TIU: Benar=5
                    @endif
                </span>
            </div>
            <div class="p-5">
                <!-- Teks Soal -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Teks Soal *</label>
                    <textarea name="questions[{{ $index }}][question_text]" rows="3" 
                              class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                              placeholder="Tulis soal di sini...">{{ $q->question_text }}</textarea>
                </div>

                <!-- Gambar Soal -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Gambar Soal (opsional)</label>
                    <input type="file" class="question-image-input w-full px-4 py-2 border rounded-lg" accept="image/*"
                           data-target="questions[{{ $index }}][question_image]"
                           data-preview="preview-question-{{ $startNumber }}">
                    <input type="hidden" name="questions[{{ $index }}][question_image]" value="{{ $q->question_image }}" class="question-image-hidden">
                    <div id="preview-question-{{ $startNumber }}" class="mt-2">
                        @if($q->question_image)
                        <img src="{{ $q->question_image }}" class="max-w-full max-h-32 rounded-lg border">
                        <button type="button" class="text-red-500 text-sm mt-1" onclick="clearImage(this, 'preview-question-{{ $startNumber }}', 'questions[{{ $index }}][question_image]')">Hapus Gambar</button>
                        @endif
                    </div>
                </div>

                <!-- Opsi Jawaban -->
                <div class="grid md:grid-cols-2 gap-4 mb-4">
                    @foreach(['a', 'b', 'c', 'd', 'e'] as $opt)
                    <div class="border rounded-lg p-3">
                        <label class="block text-gray-700 font-semibold mb-2">Opsi {{ strtoupper($opt) }} *</label>
                        <input type="text" name="questions[{{ $index }}][option_{{ $opt }}]" 
                               value="{{ $q->{'option_' . $opt} }}"
                               class="w-full px-3 py-2 border rounded-lg" required>
                        
                        <label class="block text-gray-700 mt-2 mb-1 text-sm">Gambar Opsi (opsional)</label>
                        <input type="file" class="option-image-input w-full px-3 py-1 border rounded-lg text-sm" accept="image/*"
                               data-target="questions[{{ $index }}][option_{{ $opt }}_image]"
                               data-preview="preview-option-{{ $startNumber }}-{{ $opt }}">
                        <input type="hidden" name="questions[{{ $index }}][option_{{ $opt }}_image]" value="{{ $q->{'option_' . $opt . '_image'} }}" class="option-image-hidden">
                        <div id="preview-option-{{ $startNumber }}-{{ $opt }}" class="mt-1">
                            @if($q->{'option_' . $opt . '_image'})
                            <img src="{{ $q->{'option_' . $opt . '_image'} }}" class="max-w-full max-h-20 rounded border">
                            <button type="button" class="text-red-500 text-xs" onclick="clearImage(this, 'preview-option-{{ $startNumber }}-{{ $opt }}', 'questions[{{ $index }}][option_{{ $opt }}_image]')">Hapus</button>
                            @endif
                        </div>

                        @if($q->category == 'tkp')
                        <label class="block text-gray-700 mt-2 mb-1 text-sm">Nilai (1-5)</label>
                        <input type="number" name="questions[{{ $index }}][score_{{ $opt }}]" min="1" max="5" 
                               value="{{ $q->{'score_' . $opt} ?? 0 }}"
                               class="w-24 px-3 py-1 border rounded-lg">
                        @endif
                    </div>
                    @endforeach
                </div>

                <!-- Jawaban Benar (untuk TWK/TIU) -->
                @if($q->category != 'tkp')
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Jawaban Benar *</label>
                    <select name="questions[{{ $index }}][correct_answer]" class="w-48 px-4 py-2 border rounded-lg">
                        <option value="a" {{ $q->correct_answer == 'a' ? 'selected' : '' }}>A</option>
                        <option value="b" {{ $q->correct_answer == 'b' ? 'selected' : '' }}>B</option>
                        <option value="c" {{ $q->correct_answer == 'c' ? 'selected' : '' }}>C</option>
                        <option value="d" {{ $q->correct_answer == 'd' ? 'selected' : '' }}>D</option>
                        <option value="e" {{ $q->correct_answer == 'e' ? 'selected' : '' }}>E</option>
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Nilai: 5 poin jika benar</p>
                </div>
                @endif

                <!-- Pembahasan -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Pembahasan (opsional)</label>
                    <textarea name="questions[{{ $index }}][explanation]" rows="2" 
                              class="w-full px-4 py-2 border rounded-lg"
                              placeholder="Pembahasan untuk soal ini...">{{ $q->explanation }}</textarea>
                </div>
            </div>
        </div>
        @endforeach

        <!-- Navigasi Per Halaman -->
        <div class="sticky bottom-0 bg-white border-t p-4 flex justify-between items-center">
            <div class="flex gap-2">
                <button type="button" onclick="previousPage()" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                    ◀ Sebelumnya
                </button>
                <span id="pageInfo" class="px-4 py-2 text-gray-600">Halaman 1 dari 11</span>
                <button type="button" onclick="nextPage()" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                    Selanjutnya ▶
                </button>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.tryouts.edit', $tryout->id) }}" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition">
                    Batal
                </a>
                <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded-lg hover:bg-green-600 transition">
                    <i class="fas fa-save mr-2"></i>Simpan Semua Soal
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    let currentPage = 1;
    const questionsPerPage = 10;
    const totalQuestions = 110;
    const totalPages = Math.ceil(totalQuestions / questionsPerPage);
    
    function showPage(page) {
        currentPage = page;
        const start = (page - 1) * questionsPerPage + 1;
        const end = Math.min(page * questionsPerPage, totalQuestions);
        
        for (let i = 1; i <= totalQuestions; i++) {
            const q = document.getElementById(`question-${i}`);
            if (q) q.style.display = 'none';
        }
        
        for (let i = start; i <= end; i++) {
            const q = document.getElementById(`question-${i}`);
            if (q) q.style.display = 'block';
        }
        
        document.getElementById('pageInfo').innerText = `Halaman ${page} dari ${totalPages}`;
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
    
    function previousPage() {
        if (currentPage > 1) {
            showPage(currentPage - 1);
        }
    }
    
    function nextPage() {
        if (currentPage < totalPages) {
            showPage(currentPage + 1);
        }
    }
    
    function goToQuestion(questionNumber) {
        const page = Math.ceil(questionNumber / questionsPerPage);
        showPage(page);
        
        setTimeout(() => {
            const element = document.getElementById(`question-${questionNumber}`);
            if (element) {
                element.scrollIntoView({ behavior: 'smooth', block: 'start' });
                element.classList.add('ring-2', 'ring-purple-500');
                setTimeout(() => element.classList.remove('ring-2', 'ring-purple-500'), 2000);
            }
        }, 300);
    }
    
    function updateProgress() {
        let filled = 0;
        for (let i = 1; i <= totalQuestions; i++) {
            const textarea = document.querySelector(`#question-${i} textarea[name$="[question_text]"]`);
            if (textarea && textarea.value.trim() !== '') {
                filled++;
            }
        }
        document.getElementById('filledCount').innerText = filled;
        const percent = Math.round((filled / totalQuestions) * 100);
        document.getElementById('progressPercent').innerText = percent + '%';
        document.getElementById('progressBarFill').style.width = percent + '%';
    }
    
    function convertToBase64(file, callback) {
        let reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = function() { callback(reader.result); };
    }
    
    function setupImageUpload() {
        document.querySelectorAll('.question-image-input').forEach(input => {
            input.addEventListener('change', function(e) {
                if (e.target.files && e.target.files[0]) {
                    let targetHidden = document.querySelector(`input[name="${this.dataset.target}"]`);
                    let previewId = this.dataset.preview;
                    let previewDiv = document.getElementById(previewId);
                    
                    convertToBase64(e.target.files[0], function(base64) {
                        targetHidden.value = base64;
                        previewDiv.innerHTML = `<img src="${base64}" class="max-w-full max-h-32 rounded-lg border"><button type="button" class="text-red-500 text-sm mt-1" onclick="clearImage(this, '${previewId}', '${targetHidden.name}')">Hapus Gambar</button>`;
                    });
                }
            });
        });
        
        document.querySelectorAll('.option-image-input').forEach(input => {
            input.addEventListener('change', function(e) {
                if (e.target.files && e.target.files[0]) {
                    let targetHidden = document.querySelector(`input[name="${this.dataset.target}"]`);
                    let previewId = this.dataset.preview;
                    let previewDiv = document.getElementById(previewId);
                    
                    convertToBase64(e.target.files[0], function(base64) {
                        targetHidden.value = base64;
                        previewDiv.innerHTML = `<img src="${base64}" class="max-w-full max-h-20 rounded border"><button type="button" class="text-red-500 text-xs" onclick="clearImage(this, '${previewId}', '${targetHidden.name}')">Hapus</button>`;
                    });
                }
            });
        });
    }
    
    function clearImage(btn, previewId, hiddenName) {
        let previewDiv = document.getElementById(previewId);
        let hiddenInput = document.querySelector(`input[name="${hiddenName}"]`);
        if (hiddenInput) hiddenInput.value = '';
        previewDiv.innerHTML = '';
    }
    
    document.querySelectorAll('textarea[name$="[question_text]"]').forEach(textarea => {
        textarea.addEventListener('input', updateProgress);
        textarea.addEventListener('change', updateProgress);
    });
    
    window.onload = function() {
        setupImageUpload();
        showPage(1);
        updateProgress();
    }
</script>
@endpush
