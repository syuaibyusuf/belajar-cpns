<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Soal untuk {{ $package->name }} - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .question-card {
            transition: all 0.3s ease;
            scroll-margin-top: 100px;
        }
        .question-card:hover {
            box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1);
        }
        .image-preview {
            max-width: 150px;
            max-height: 100px;
            object-fit: cover;
            border-radius: 8px;
        }
    </style>
</head>
<body class="bg-gray-100">

<div class="flex min-h-screen">
    <aside class="w-64 bg-gradient-to-br from-gray-900 to-gray-800 text-white fixed h-full overflow-y-auto">
        <div class="p-6 border-b border-gray-700">
            <div class="text-xl font-bold">🛡️ Admin Panel</div>
        </div>
        <nav class="p-4 space-y-2">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-700 transition">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
            <a href="{{ route('admin.materi.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-700 transition">
                <i class="fas fa-book"></i> Manajemen Materi
            </a>
            <a href="{{ route('admin.packages.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-purple-700">
                <i class="fas fa-box"></i> Manajemen Paket
            </a>
            <form method="POST" action="{{ route('admin.logout') }}" class="mt-8">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-red-600 transition">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </nav>
    </aside>

    <main class="flex-1 ml-64 p-8">
        <div class="mb-6">
            <a href="{{ route('admin.packages.index') }}" class="text-purple-600 hover:underline">← Kembali ke Daftar Paket</a>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-bold">📝 Buat Soal untuk <span class="text-purple-600">{{ $package->name }}</span></h1>
                    <p class="text-gray-500 mt-1">Kategori: <strong>{{ strtoupper($package->category) }}</strong> | Target: {{ $package->total_questions }} soal</p>
                </div>
                <div class="text-right">
                    <div class="text-sm text-gray-600">Progress Soal:</div>
                    <div class="text-3xl font-bold" id="filledCount">{{ $questions->where('question_text', '!=', '')->count() }}</div>
                    <div class="text-xs text-gray-400">Target: {{ $package->total_questions }} soal</div>
                </div>
            </div>

            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                <div class="flex items-start gap-3">
                    <i class="fas fa-info-circle text-yellow-600 text-xl"></i>
                    <div class="text-sm text-yellow-800">
                        <p class="font-semibold">Petunjuk:</p>
                        <p>Isi semua soal di bawah ini. Scroll ke bawah untuk melihat semua soal.</p>
                        <p>Untuk soal TKP, Anda bisa menentukan nilai (1-5) untuk setiap opsi jawaban.</p>
                        <p>Untuk soal TWK/TIU, pilih jawaban yang benar.</p>
                        <p>Anda bisa menyimpan kapan saja sebagai DRAFT dan melanjutkan nanti.</p>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.packages.save-questions', $package->id) }}" id="questionsForm">
                @csrf
                
                @foreach($questions as $index => $q)
                <div class="question-card bg-white border rounded-xl mb-6 overflow-hidden" id="question-{{ $index }}">
                    <input type="hidden" name="questions[{{ $index }}][id]" value="{{ $q->id }}">
                    <div class="bg-gradient-to-r from-gray-800 to-gray-700 text-white px-5 py-3">
                        <div class="flex justify-between items-center">
                            <span class="font-bold">Soal {{ $index + 1 }} dari {{ $package->total_questions }}</span>
                            <span class="text-sm {{ $q->question_text ? 'text-green-300' : 'text-yellow-300' }}">
                                <i class="fas {{ $q->question_text ? 'fa-check-circle' : 'fa-circle' }} mr-1"></i>
                                {{ $q->question_text ? 'Terisi' : 'Belum diisi' }}
                            </span>
                        </div>
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
                                   data-preview="preview-question-{{ $index }}">
                            <input type="hidden" name="questions[{{ $index }}][question_image]" value="{{ $q->question_image }}" class="question-image-hidden">
                            <div id="preview-question-{{ $index }}" class="mt-2">
                                @if($q->question_image)
                                <img src="{{ $q->question_image }}" class="image-preview">
                                <button type="button" class="text-red-500 text-sm mt-1" onclick="clearImage(this, 'preview-question-{{ $index }}', 'questions[{{ $index }}][question_image]')">Hapus Gambar</button>
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
                                       data-preview="preview-option-{{ $index }}-{{ $opt }}">
                                <input type="hidden" name="questions[{{ $index }}][option_{{ $opt }}_image]" value="{{ $q->{'option_' . $opt . '_image'} }}" class="option-image-hidden">
                                <div id="preview-option-{{ $index }}-{{ $opt }}" class="mt-1">
                                    @if($q->{'option_' . $opt . '_image'})
                                    <img src="{{ $q->{'option_' . $opt . '_image'} }}" class="image-preview">
                                    <button type="button" class="text-red-500 text-xs" onclick="clearImage(this, 'preview-option-{{ $index }}-{{ $opt }}', 'questions[{{ $index }}][option_{{ $opt }}_image]')">Hapus</button>
                                    @endif
                                </div>

                                <!-- Nilai untuk TKP -->
                                @if($package->category == 'tkp')
                                <label class="block text-gray-700 mt-2 mb-1 text-sm">Nilai (1-5)</label>
                                <input type="number" name="questions[{{ $index }}][score_{{ $opt }}]" min="1" max="5" 
                                       value="{{ $q->{'score_' . $opt} ?? 0 }}"
                                       class="w-24 px-3 py-1 border rounded-lg">
                                @endif
                            </div>
                            @endforeach
                        </div>

                        <!-- Jawaban Benar (untuk TWK/TIU) -->
                        @if($package->category != 'tkp')
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

                <!-- Navigasi -->
                <div class="sticky bottom-4 bg-white rounded-xl shadow-lg p-4 border-t-4 border-purple-500 flex justify-between items-center">
                    <div>
                        <span id="filledCountBottom" class="font-bold text-purple-600">{{ $questions->where('question_text', '!=', '')->count() }}</span>
                        <span class="text-gray-600"> dari {{ $package->total_questions }} soal terisi</span>
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('admin.packages.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition">
                            Batal
                        </a>
                        <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded-lg hover:bg-green-600 transition" id="submitBtn">
                            <i class="fas fa-save mr-2"></i>Simpan Soal
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </main>
</div>

<script>
    // Update counter function
    function updateFilledCount() {
        let filled = 0;
        document.querySelectorAll('.question-card').forEach(card => {
            let questionText = card.querySelector('textarea[name$="[question_text]"]');
            if (questionText && questionText.value.trim() !== '') {
                filled++;
            }
        });
        document.getElementById('filledCount').innerText = filled;
        document.getElementById('filledCountBottom').innerText = filled;
        
        let submitBtn = document.getElementById('submitBtn');
        let total = {{ $package->total_questions }};
        if (filled === total) {
            submitBtn.innerHTML = '<i class="fas fa-check-circle mr-2"></i>Simpan & Aktifkan Paket';
            submitBtn.classList.remove('bg-green-500');
            submitBtn.classList.add('bg-green-600');
        } else {
            submitBtn.innerHTML = '<i class="fas fa-save mr-2"></i>Simpan Draft (' + filled + '/' + total + ')';
            submitBtn.classList.remove('bg-green-600');
            submitBtn.classList.add('bg-green-500');
        }
    }
    
    // Convert image to base64
    function convertToBase64(file, callback) {
        let reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = function() { callback(reader.result); };
        reader.onerror = function(error) { console.log('Error:', error); };
    }
    
    // Setup image upload for question images
    document.querySelectorAll('.question-image-input').forEach(input => {
        input.addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                let targetHidden = document.querySelector(`input[name="${this.dataset.target}"]`);
                let previewId = this.dataset.preview;
                let previewDiv = document.getElementById(previewId);
                
                convertToBase64(e.target.files[0], function(base64) {
                    targetHidden.value = base64;
                    previewDiv.innerHTML = `<img src="${base64}" class="image-preview"><button type="button" class="text-red-500 text-sm mt-1" onclick="clearImage(this, '${previewId}', '${targetHidden.name}')">Hapus Gambar</button>`;
                });
            }
        });
    });
    
    // Setup image upload for option images
    document.querySelectorAll('.option-image-input').forEach(input => {
        input.addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                let targetHidden = document.querySelector(`input[name="${this.dataset.target}"]`);
                let previewId = this.dataset.preview;
                let previewDiv = document.getElementById(previewId);
                
                convertToBase64(e.target.files[0], function(base64) {
                    targetHidden.value = base64;
                    previewDiv.innerHTML = `<img src="${base64}" class="image-preview"><button type="button" class="text-red-500 text-xs" onclick="clearImage(this, '${previewId}', '${targetHidden.name}')">Hapus</button>`;
                });
            }
        });
    });
    
    function clearImage(btn, previewId, hiddenName) {
        let previewDiv = document.getElementById(previewId);
        let hiddenInput = document.querySelector(`input[name="${hiddenName}"]`);
        if (hiddenInput) hiddenInput.value = '';
        previewDiv.innerHTML = '';
    }
    
    // Listen to question text changes to update counter
    document.querySelectorAll('textarea[name$="[question_text]"]').forEach(textarea => {
        textarea.addEventListener('input', updateFilledCount);
        textarea.addEventListener('change', updateFilledCount);
    });
    
    // Initial counter
    updateFilledCount();
</script>

</body>
</html>