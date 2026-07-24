@extends('layouts.admin')

@section('title', 'Backup Database')
@section('header', '💾 Backup Database')

@section('content')
<style>
    .backup-card {
        transition: all 0.3s ease;
    }
    .backup-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px -12px rgba(0, 0, 0, 0.15);
    }
    .modal {
        transition: all 0.3s ease;
    }
</style>

<div class="max-w-5xl mx-auto">
    <!-- Info Card -->
    <div class="bg-blue-50 border-l-4 border-blue-500 rounded-lg p-4 mb-6">
        <div class="flex items-start gap-3">
            <i class="fas fa-info-circle text-blue-500 text-xl"></i>
            <div>
                <h3 class="font-semibold text-blue-800">Informasi Backup</h3>
                <p class="text-sm text-blue-700">Backup akan menyimpan database dan semua file gambar (materi, tryout) ke dalam file ZIP.</p>
            </div>
        </div>
    </div>

    <!-- Create Backup Card -->
    <div class="backup-card bg-white rounded-xl shadow-sm p-6 mb-8">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <div class="text-3xl mb-2">💾</div>
                <h2 class="text-xl font-bold text-gray-800">Buat Backup Baru</h2>
                <p class="text-gray-500 text-sm mt-1">Simpan database dan semua file gambar ke file ZIP</p>
            </div>
            <button onclick="createBackup()" id="backupBtn" class="bg-green-500 text-white px-6 py-3 rounded-xl font-semibold hover:bg-green-600 transition shadow-md">
                <i class="fas fa-database mr-2"></i> Backup Sekarang
            </button>
        </div>
    </div>

    <!-- Restore Card -->
    <div class="backup-card bg-white rounded-xl shadow-sm p-6 mb-8">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <div class="text-3xl mb-2">🔄</div>
                <h2 class="text-xl font-bold text-gray-800">Restore Database</h2>
                <p class="text-gray-500 text-sm mt-1">Pulihkan database dan gambar dari file backup ZIP</p>
            </div>
            <button onclick="openRestoreModal()" class="bg-blue-500 text-white px-6 py-3 rounded-xl font-semibold hover:bg-blue-600 transition shadow-md">
                <i class="fas fa-upload mr-2"></i> Restore
            </button>
        </div>
    </div>

    <!-- Daftar Backup -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="bg-gray-50 px-6 py-4 border-b">
            <h2 class="text-lg font-bold text-gray-800">📁 Daftar Backup</h2>
        </div>
        
        @if(count($backupFiles) > 0)
        <div class="divide-y">
            @foreach($backupFiles as $file)
            <div class="px-6 py-4 flex flex-col md:flex-row justify-between items-start md:items-center gap-3">
                <div class="flex items-center gap-3">
                    <i class="fas fa-file-archive text-2xl text-gray-400"></i>
                    <div>
                        <div class="font-medium text-gray-800">{{ $file['name'] }}</div>
                        <div class="text-xs text-gray-400">{{ $file['size'] }} • {{ $file['date'] }}</div>
                    </div>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('admin.backup.download', $file['name']) }}" class="text-blue-600 hover:text-blue-800 px-3 py-1 rounded-lg hover:bg-blue-50 transition">
                        <i class="fas fa-download mr-1"></i> Download
                    </a>
                    <button onclick="deleteBackup('{{ $file['name'] }}')" class="text-red-600 hover:text-red-800 px-3 py-1 rounded-lg hover:bg-red-50 transition">
                        <i class="fas fa-trash mr-1"></i> Hapus
                    </button>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="px-6 py-12 text-center text-gray-400">
            <i class="fas fa-database text-4xl mb-3 block"></i>
            <p>Belum ada backup. Klik "Backup Sekarang" untuk membuat backup pertama.</p>
        </div>
        @endif
    </div>
</div>

<!-- Modal Restore -->
<div id="restoreModal" class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl modal">
        <div class="flex justify-between items-center mb-5">
            <h3 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                <i class="fas fa-upload text-blue-600"></i>
                Restore Database
            </h3>
            <button onclick="closeRestoreModal()" class="text-gray-400 hover:text-gray-600 w-8 h-8 rounded-full hover:bg-gray-100">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        
        <form id="restoreForm" method="POST" action="{{ route('admin.backup.restore') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-medium mb-2">Pilih File Backup (.zip)</label>
                <input type="file" name="backup_file" accept=".zip" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl" required>
                <p class="text-xs text-gray-400 mt-1">Maksimal 50MB, file harus berekstensi .zip (hasil backup dari sistem)</p>
            </div>
            <div class="bg-yellow-50 rounded-lg p-3 mb-4">
                <div class="flex items-start gap-2">
                    <i class="fas fa-exclamation-triangle text-yellow-600 mt-0.5"></i>
                    <p class="text-xs text-yellow-700">
                        <strong>Peringatan!</strong> Restore akan mengganti semua data saat ini dengan data dari file backup.
                        Pastikan Anda sudah melakukan backup terbaru sebelum melanjutkan!
                    </p>
                </div>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="flex-1 bg-blue-600 text-white py-2.5 rounded-xl font-semibold hover:bg-blue-700 transition">
                    <i class="fas fa-check-circle mr-2"></i> Ya, Restore
                </button>
                <button type="button" onclick="closeRestoreModal()" class="flex-1 bg-gray-100 text-gray-700 py-2.5 rounded-xl font-semibold hover:bg-gray-200 transition">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Create Backup
    function createBackup() {
        const btn = document.getElementById('backupBtn');
        const originalText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Memproses...';
        
        fetch('{{ route("admin.backup.create") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('✅ ' + data.message);
                location.reload();
            } else {
                alert('❌ ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('❌ Terjadi kesalahan: ' + error.message);
        })
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = originalText;
        });
    }
    
    // Delete Backup
    function deleteBackup(filename) {
        if (confirm('Yakin ingin menghapus file backup ' + filename + '?')) {
            fetch('{{ url("admin/backup/delete") }}/' + filename, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('✅ ' + data.message);
                    location.reload();
                } else {
                    alert('❌ ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('❌ Terjadi kesalahan: ' + error.message);
            });
        }
    }
    
    // Open Restore Modal
    function openRestoreModal() {
        document.getElementById('restoreModal').classList.remove('hidden');
        document.getElementById('restoreModal').classList.add('flex');
        document.body.style.overflow = 'hidden';
    }
    
    // Close Restore Modal
    function closeRestoreModal() {
        document.getElementById('restoreModal').classList.add('hidden');
        document.getElementById('restoreModal').classList.remove('flex');
        document.body.style.overflow = '';
    }
    
    // Loading saat restore form submit
    document.getElementById('restoreForm').addEventListener('submit', function() {
        const btn = this.querySelector('button[type="submit"]');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Merestore...';
        if (typeof showLoading === 'function') showLoading('Merestore database dan gambar...');
    });
    
    // Tutup modal jika klik di luar area
    window.onclick = function(event) {
        const modal = document.getElementById('restoreModal');
        if (event.target === modal) {
            closeRestoreModal();
        }
    }
</script>
@endsection