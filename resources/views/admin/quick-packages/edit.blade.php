<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Paket Cepat - Admin</title>
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
            <h1 class="text-2xl font-bold mb-6">✏️ Edit Paket Cepat: {{ $package->name }}</h1>

            <form method="POST" action="{{ route('admin.quick-packages.update', $package->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Nama Paket *</label>
                    <input type="text" name="name" value="{{ $package->name }}" class="w-full px-4 py-2 border rounded-lg" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Kategori *</label>
                    <select name="category" class="w-full px-4 py-2 border rounded-lg" required>
                        @foreach($categories as $value => $label)
                        <option value="{{ $value }}" {{ $package->category == $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Deskripsi</label>
                    <textarea name="description" rows="3" class="w-full px-4 py-2 border rounded-lg">{{ $package->description }}</textarea>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 mb-2">Status</label>
                    <select name="status" class="w-48 px-4 py-2 border rounded-lg">
                        <option value="active" {{ $package->status == 'active' ? 'selected' : '' }}>Active (Tampil di User)</option>
                        <option value="inactive" {{ $package->status == 'inactive' ? 'selected' : '' }}>Inactive (Tidak Tampil)</option>
                    </select>
                </div>

                <div class="bg-gray-50 rounded-lg p-4 mb-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <span class="text-sm text-gray-600">Jumlah Soal Saat Ini:</span>
                            <span class="font-bold {{ $package->questions->count() == $package->total_questions ? 'text-green-600' : 'text-red-600' }}">
                                {{ $package->questions->count() }}/{{ $package->total_questions }}
                            </span>
                        </div>
                        <a href="{{ route('admin.quick-packages.select-questions', $package->id) }}" class="text-blue-600 hover:text-blue-800 text-sm">
                            <i class="fas fa-edit mr-1"></i>Ubah Pilihan Soal
                        </a>
                    </div>
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded-lg hover:bg-green-600 transition">
                        <i class="fas fa-save mr-2"></i>Update
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