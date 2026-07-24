<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Materi - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
            <a href="{{ route('admin.materi.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-purple-700">
                <i class="fas fa-book"></i> Manajemen Materi
            </a>
            <a href="{{ route('admin.soal.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-700 transition">
                <i class="fas fa-question-circle"></i> Manajemen Soal
            </a>
            <a href="{{ route('admin.packages.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-700 transition">
                <i class="fas fa-box"></i> Manajemen Paket
            </a>
            <a href="{{ route('admin.tryouts.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-700 transition">
                <i class="fas fa-trophy"></i> Try Out
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
            <a href="{{ route('admin.materi.index') }}" class="text-purple-600 hover:underline">← Kembali</a>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <h1 class="text-2xl font-bold mb-6">✏️ Edit Materi: {{ $materi->title }}</h1>

            <form method="POST" action="{{ route('admin.materi.update', $materi->id) }}" enctype="multipart/form-data" id="materiForm">
                @csrf
                @method('PUT')
                
                <input type="hidden" name="existing_placeholders" value="{{ json_encode($materi->existing_placeholders ?? []) }}">

                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2">Judul Materi *</label>
                            <input type="text" name="title" value="{{ $materi->title }}" class="w-full px-4 py-2 border rounded-lg" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2">Kategori *</label>
                            <select name="category" class="w-full px-4 py-2 border rounded-lg" required>
                                @foreach($categories as $key => $label)
                                <option value="{{ $key }}" {{ $materi->category == $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2">Thumbnail (opsional)</label>
                            @if($materi->thumbnail)
                            <div class="mb-2">
                                <img src="{{ asset('uploads/materi/' . $materi->thumbnail) }}" class="w-32 h-32 object-cover rounded-lg border">
                                <p class="text-xs text-gray-500 mt-1">Thumbnail saat ini</p>
                            </div>
                            @endif
                            <input type="file" name="thumbnail" accept="image/jpeg,image/png,image/gif" class="w-full px-4 py-2 border rounded-lg">
                            <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ingin mengubah thumbnail</p>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2">Urutan</label>
                            <input type="number" name="order_number" value="{{ $materi->order_number }}" class="w-32 px-4 py-2 border rounded-lg">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2">Status</label>
                            <select name="status" class="w-48 px-4 py-2 border rounded-lg">
                                <option value="published" {{ $materi->status == 'published' ? 'selected' : '' }}>Published</option>
                                <option value="draft" {{ $materi->status == 'draft' ? 'selected' : '' }}>Draft</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 rounded-xl p-4">
                        <h3 class="font-semibold text-gray-800 mb-3">📷 Cara Menambahkan/Mengganti Gambar</h3>
                        <ol class="text-sm text-gray-600 space-y-2 list-decimal list-inside">
                            <li>Klik tombol <strong>"Tambah Gambar"</strong> di bawah editor</li>
                            <li>Pilih file gambar (JPG, PNG, GIF)</li>
                            <li>Kode <strong>[IMAGE_X]</strong> akan muncul di posisi kursor</li>
                            <li>Anda bisa memindahkan kode tersebut ke mana saja</li>
                            <li>Jangan hapus kode <strong>[IMAGE_X]</strong> jika ingin gambar tetap ada</li>
                        </ol>
                        <div class="mt-4 p-3 bg-yellow-50 rounded-lg">
                            <p class="text-xs text-yellow-700">⚠️ Jangan hapus kode [IMAGE_X] dari editor, karena itu adalah penanda gambar.</p>
                        </div>
                    </div>
                </div>

                <div class="mb-4 mt-4">
                    <label class="block text-gray-700 mb-2">Isi Materi *</label>
                    <textarea name="content" id="contentTextarea" rows="15" class="w-full px-4 py-2 border rounded-lg font-mono text-sm">{{ $materi->raw_content ?? $materi->content }}</textarea>
                </div>

                <div class="mb-4">
                    <button type="button" id="addImageBtn" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition">
                        <i class="fas fa-image mr-2"></i> Tambah Gambar Baru
                    </button>
                </div>

                <div id="imagePreviewContainer" class="mb-4 grid grid-cols-2 md:grid-cols-4 gap-3"></div>
                <div id="imageDataContainer"></div>

                <div class="flex gap-3 mt-6">
                    <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded-lg hover:bg-green-600 transition">
                        <i class="fas fa-save mr-2"></i> Update
                    </button>
                    <a href="{{ route('admin.materi.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </main>
</div>

<script>
    @php
        $existingImages = [];
        if ($materi->existing_images) {
            $existingImages = $materi->existing_images;
        }
        $imageCounter = count($existingImages);
    @endphp
    
    let imageCounter = {{ $imageCounter }};
    const textarea = document.getElementById('contentTextarea');
    const imagePreviewContainer = document.getElementById('imagePreviewContainer');
    const imageDataContainer = document.getElementById('imageDataContainer');
    
    function insertAtCursor(text) {
        const start = textarea.selectionStart;
        const end = textarea.selectionEnd;
        const content = textarea.value;
        textarea.value = content.substring(0, start) + text + content.substring(end);
        textarea.focus();
        textarea.selectionStart = start + text.length;
        textarea.selectionEnd = start + text.length;
    }
    
    document.getElementById('addImageBtn').addEventListener('click', function() {
        const input = document.createElement('input');
        input.type = 'file';
        input.accept = 'image/jpeg,image/png,image/gif';
        input.onchange = function(e) {
            const file = e.target.files[0];
            if (file) {
                const placeholder = `[IMAGE_${imageCounter}]`;
                
                const reader = new FileReader();
                reader.onload = function(evt) {
                    const previewDiv = document.createElement('div');
                    previewDiv.className = 'border rounded-lg p-2 bg-gray-50';
                    previewDiv.innerHTML = `
                        <img src="${evt.target.result}" class="w-full h-24 object-cover rounded-lg mb-1">
                        <p class="text-xs text-gray-500 truncate">${file.name}</p>
                        <p class="text-xs text-purple-600 font-mono">${placeholder}</p>
                        <button type="button" class="text-red-500 text-xs mt-1" onclick="this.parentElement.remove()">Hapus</button>
                    `;
                    imagePreviewContainer.appendChild(previewDiv);
                };
                reader.readAsDataURL(file);
                
                const fileInput = document.createElement('input');
                fileInput.type = 'file';
                fileInput.name = `image_${imageCounter}`;
                fileInput.style.display = 'none';
                
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                fileInput.files = dataTransfer.files;
                imageDataContainer.appendChild(fileInput);
                
                insertAtCursor(placeholder);
                imageCounter++;
            }
        };
        input.click();
    });
    
    document.getElementById('materiForm').addEventListener('submit', function(e) {
        const container = document.getElementById('imageDataContainer');
        const fileInputs = container.querySelectorAll('input[type="file"]');
        fileInputs.forEach(input => {
            this.appendChild(input.cloneNode(true));
        });
    });
</script>

</body>
</html>