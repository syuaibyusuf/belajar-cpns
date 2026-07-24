<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Soal - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
</head>
<body class="bg-gray-100">

<div class="flex min-h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-gradient-to-br from-gray-900 to-gray-800 text-white fixed h-full overflow-y-auto">
        <div class="p-6 border-b border-gray-700">
            <div class="text-xl font-bold">🛡️ Admin Panel</div>
            <div class="text-sm text-gray-400">Belajar CPNS</div>
        </div>
        <nav class="p-4 space-y-2">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-700 transition">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
            <a href="{{ route('admin.materi.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-700 transition">
                <i class="fas fa-book"></i> Manajemen Materi
            </a>
            <a href="{{ route('admin.soal.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-purple-700">
                <i class="fas fa-question-circle"></i> Manajemen Soal
            </a>
            <a href="{{ route('admin.packages.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-700 transition">
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
            <a href="{{ route('admin.soal.index') }}" class="text-purple-600 hover:underline">← Kembali</a>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 max-w-4xl">
            <h1 class="text-2xl font-bold mb-6">➕ Tambah Soal Baru</h1>

            <form method="POST" action="{{ route('admin.soal.store') }}" id="soalForm">
                @csrf

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Kategori *</label>
                    <select name="category" id="category" class="w-full px-4 py-2 border rounded-lg" required onchange="toggleTKPMode()">
                        @foreach($categories as $key => $cat)
                        <option value="{{ $key }}">{{ $cat['name'] }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Soal *</label>
                    <textarea name="question_text" id="question_text" rows="4" class="w-full px-4 py-2 border rounded-lg" required></textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Gambar Soal (Base64 - opsional)</label>
                    <input type="file" id="question_image_input" accept="image/*" class="w-full px-4 py-2 border rounded-lg">
                    <input type="hidden" name="question_image" id="question_image_base64">
                    <div id="question_image_preview" class="mt-2 hidden">
                        <img id="question_preview_img" class="max-w-full h-32 object-cover rounded-lg border">
                        <button type="button" onclick="clearImage('question')" class="text-red-500 text-sm mt-1">Hapus Gambar</button>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-4 mb-4">
                    @foreach(['a', 'b', 'c', 'd', 'e'] as $opt)
                    <div class="border rounded-lg p-3">
                        <label class="block text-gray-700 mb-2 font-semibold">Opsi {{ strtoupper($opt) }} *</label>
                        <input type="text" name="option_{{ $opt }}" class="w-full px-3 py-2 border rounded-lg" required>
                        
                        <label class="block text-gray-700 mt-2 mb-1 text-sm">Gambar Opsi (opsional)</label>
                        <input type="file" id="image_{{ $opt }}_input" accept="image/*" class="w-full px-3 py-1 border rounded-lg text-sm">
                        <input type="hidden" name="image_{{ $opt }}" id="image_{{ $opt }}_base64">
                        <div id="image_{{ $opt }}_preview" class="mt-1 hidden">
                            <img id="image_{{ $opt }}_preview_img" class="max-w-full h-20 object-cover rounded-lg border">
                        </div>
                        
                        <!-- Nilai untuk TKP (hidden by default) -->
                        <div class="tkp-score mt-2 hidden">
                            <label class="block text-gray-700 mb-1 text-sm">Nilai (1-5)</label>
                            <input type="number" name="score_{{ $opt }}" min="1" max="5" value="0" class="w-24 px-3 py-1 border rounded-lg">
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Untuk TWK/TIU (jawaban benar) -->
                <div id="twk_tiu_section" class="mb-4">
                    <label class="block text-gray-700 mb-2">Jawaban Benar *</label>
                    <select name="correct_answer" class="w-48 px-4 py-2 border rounded-lg">
                        <option value="a">A</option>
                        <option value="b">B</option>
                        <option value="c">C</option>
                        <option value="d">D</option>
                        <option value="e">E</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Pembahasan (opsional)</label>
                    <textarea name="explanation" rows="3" class="w-full px-4 py-2 border rounded-lg"></textarea>
                </div>

                <div class="grid md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="block text-gray-700 mb-2">Tingkat Kesulitan</label>
                        <select name="difficulty" class="w-full px-4 py-2 border rounded-lg">
                            <option value="easy">Easy</option>
                            <option value="medium" selected>Medium</option>
                            <option value="hard">Hard</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-2">Poin (untuk TWK/TIU)</label>
                        <input type="number" name="points" value="5" class="w-32 px-4 py-2 border rounded-lg">
                        <p class="text-xs text-gray-500 mt-1">Default 5 poin per jawaban benar</p>
                    </div>
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded-lg hover:bg-green-600 transition">
                        <i class="fas fa-save mr-2"></i>Simpan
                    </button>
                    <a href="{{ route('admin.soal.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </main>
</div>

<script>
    function toggleTKPMode() {
        let category = document.getElementById('category').value;
        let twkTiuSection = document.getElementById('twk_tiu_section');
        let tkpScores = document.querySelectorAll('.tkp-score');
        
        if (category === 'tkp') {
            twkTiuSection.style.display = 'none';
            tkpScores.forEach(el => el.classList.remove('hidden'));
        } else {
            twkTiuSection.style.display = 'block';
            tkpScores.forEach(el => el.classList.add('hidden'));
        }
    }
    
    function convertToBase64(file, callback) {
        let reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = function() {
            callback(reader.result);
        };
        reader.onerror = function(error) {
            console.log('Error: ', error);
        };
    }
    
    function setupImageUpload(inputId, hiddenId, previewId, previewImgId, type) {
        let input = document.getElementById(inputId);
        if (input) {
            input.addEventListener('change', function(e) {
                if (e.target.files && e.target.files[0]) {
                    convertToBase64(e.target.files[0], function(base64) {
                        document.getElementById(hiddenId).value = base64;
                        let preview = document.getElementById(previewId);
                        let previewImg = document.getElementById(previewImgId);
                        previewImg.src = base64;
                        preview.classList.remove('hidden');
                    });
                }
            });
        }
    }
    
    function clearImage(type) {
        document.getElementById(`${type}_image_base64`).value = '';
        document.getElementById(`${type}_image_preview`).classList.add('hidden');
        document.getElementById(`${type}_image_input`).value = '';
    }
    
    // Setup semua upload gambar
    setupImageUpload('question_image_input', 'question_image_base64', 'question_image_preview', 'question_preview_img', 'question');
    setupImageUpload('image_a_input', 'image_a_base64', 'image_a_preview', 'image_a_preview_img', 'image_a');
    setupImageUpload('image_b_input', 'image_b_base64', 'image_b_preview', 'image_b_preview_img', 'image_b');
    setupImageUpload('image_c_input', 'image_c_base64', 'image_c_preview', 'image_c_preview_img', 'image_c');
    setupImageUpload('image_d_input', 'image_d_base64', 'image_d_preview', 'image_d_preview_img', 'image_d');
    setupImageUpload('image_e_input', 'image_e_base64', 'image_e_preview', 'image_e_preview_img', 'image_e');
    
    // Initial toggle
    toggleTKPMode();
</script>

</body>
</html>