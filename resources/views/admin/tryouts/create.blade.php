@extends('layouts.admin')

@section('title', 'Buat Try Out - Admin')
@section('header', '🎯 Buat Try Out Baru')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.tryouts.index') }}" class="text-purple-600 hover:underline">← Kembali</a>
</div>

<div class="bg-white rounded-xl shadow-sm p-6 max-w-2xl">
    <h1 class="text-2xl font-bold mb-6">🎯 Buat Try Out Baru</h1>

    <form method="POST" action="{{ route('admin.tryouts.store') }}">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Nama Try Out *</label>
            <input type="text" name="name" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500" 
                   placeholder="Contoh: Try Out CPNS 2024 - 1" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Deskripsi (opsional)</label>
            <textarea name="description" rows="3" class="w-full px-4 py-2 border rounded-lg" 
                      placeholder="Deskripsi singkat tentang try out ini..."></textarea>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Durasi (menit) *</label>
            <input type="number" name="duration" value="100" min="30" max="180" class="w-32 px-4 py-2 border rounded-lg" required>
            <p class="text-xs text-gray-500 mt-1">Waktu pengerjaan try out dalam menit</p>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Status</label>
            <select name="status" class="w-48 px-4 py-2 border rounded-lg">
                <option value="draft">Draft (Belum selesai)</option>
                <option value="active">Active (Langsung tampil)</option>
            </select>
        </div>

        <div class="bg-gray-50 rounded-lg p-4 mb-6">
            <h3 class="font-semibold text-gray-800 mb-3">📋 Komposisi Soal (Tetap)</h3>
            <div class="grid grid-cols-3 gap-3 text-center">
                <div class="p-3 bg-red-50 rounded-lg">
                    <div class="text-2xl">🇮🇩</div>
                    <div class="font-bold">TWK</div>
                    <div class="text-lg font-bold text-red-600">30 Soal</div>
                    <div class="text-xs text-gray-500">Poin: 150</div>
                </div>
                <div class="p-3 bg-blue-50 rounded-lg">
                    <div class="text-2xl">🧠</div>
                    <div class="font-bold">TIU</div>
                    <div class="text-lg font-bold text-blue-600">35 Soal</div>
                    <div class="text-xs text-gray-500">Poin: 175</div>
                </div>
                <div class="p-3 bg-green-50 rounded-lg">
                    <div class="text-2xl">💼</div>
                    <div class="font-bold">TKP</div>
                    <div class="text-lg font-bold text-green-600">45 Soal</div>
                    <div class="text-xs text-gray-500">Poin: 225</div>
                </div>
            </div>
            <p class="text-sm text-gray-500 mt-3 text-center">Total: 110 Soal | Maksimal Poin: 550</p>
        </div>

        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
            <div class="flex items-start gap-3">
                <i class="fas fa-info-circle text-yellow-600"></i>
                <div class="text-sm text-yellow-800">
                    <p class="font-semibold">Langkah Selanjutnya:</p>
                    <p>Setelah membuat try out, Anda akan diarahkan ke halaman <strong>Buat Soal</strong> untuk membuat 110 soal (30 TWK + 35 TIU + 45 TKP).</p>
                    <p class="mt-1">Soal akan berurutan: Soal 1-30 = TWK, 31-65 = TIU, 66-110 = TKP.</p>
                </div>
            </div>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded-lg hover:bg-green-600 transition">
                <i class="fas fa-save mr-2"></i>Buat Try Out & Lanjut Buat Soal
            </button>
            <a href="{{ route('admin.tryouts.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
