<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Paket Cepat - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">

<div class="flex min-h-screen">
    <aside class="w-64 bg-gradient-to-br from-gray-900 to-gray-800 text-white fixed h-full">
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
            <a href="{{ route('admin.soal.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-700 transition">
                <i class="fas fa-question-circle"></i> Manajemen Soal
            </a>
            <a href="{{ route('admin.packages.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-700 transition">
                <i class="fas fa-box"></i> Paket Lengkap (50)
            </a>
            <a href="{{ route('admin.quick-packages.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-purple-700">
                <i class="fas fa-bolt"></i> Paket Cepat (10-20)
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
            <a href="{{ route('admin.quick-packages.index') }}" class="text-purple-600 hover:underline">← Kembali</a>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 max-w-2xl">
            <h1 class="text-2xl font-bold mb-6">⚡ Buat Paket Cepat Baru</h1>

            <form method="POST" action="{{ route('admin.quick-packages.store') }}">
                @csrf

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Nama Paket *</label>
                    <input type="text" name="name" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500" 
                           placeholder="Contoh: Latihan Cepat TWK 01, Try Out TIU 10 Soal" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Kategori *</label>
                    <select name="category" class="w-full px-4 py-2 border rounded-lg" required>
                        @foreach($categories as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Jumlah Soal *</label>
                    <select name="total_questions" class="w-48 px-4 py-2 border rounded-lg" required>
                        <option value="10">10 Soal</option>
                        <option value="15">15 Soal</option>
                        <option value="20">20 Soal</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Deskripsi (opsional)</label>
                    <textarea name="description" rows="3" class="w-full px-4 py-2 border rounded-lg" 
                              placeholder="Deskripsi singkat tentang paket ini..."></textarea>
                </div>

                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                    <div class="flex items-start gap-3">
                        <i class="fas fa-info-circle text-yellow-600"></i>
                        <div class="text-sm text-yellow-800">
                            <p class="font-semibold">Langkah Selanjutnya:</p>
                            <p>Setelah membuat paket, Anda akan diarahkan ke halaman <strong>Pilih Soal</strong> untuk memilih tepat {{ old('total_questions', 10) }} soal dari database.</p>
                        </div>
                    </div>
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded-lg hover:bg-green-600 transition">
                        <i class="fas fa-save mr-2"></i>Buat Paket & Lanjut Pilih Soal
                    </button>
                    <a href="{{ route('admin.quick-packages.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </main>
</div>

</body>
</html>