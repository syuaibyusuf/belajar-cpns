<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Soal untuk {{ $package->name }} - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">

<div class="flex min-h-screen">
    <!-- Sidebar -->
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
            <a href="{{ route('admin.soal.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-700 transition">
                <i class="fas fa-question-circle"></i> Manajemen Soal
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
                    <h1 class="text-2xl font-bold">📋 Pilih Soal untuk <span class="text-purple-600">{{ $package->name }}</span></h1>
                    <p class="text-gray-500 mt-1">Kategori: <strong>{{ strtoupper($package->category) }}</strong> | Total soal tersedia: {{ $totalQuestions }}</p>
                </div>
                <div class="text-right">
                    <div class="text-sm text-gray-600">Soal dipilih:</div>
                    <div class="text-3xl font-bold" id="selectedCount">{{ count($selectedQuestionIds) }}</div>
                    <div class="text-xs text-gray-400">Target: 50 soal</div>
                </div>
            </div>

            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                <div class="flex items-start gap-3">
                    <i class="fas fa-info-circle text-yellow-600 text-xl"></i>
                    <div class="text-sm text-yellow-800">
                        <p class="font-semibold">Perhatian!</p>
                        <p>Anda harus memilih <strong>tepat 50 soal</strong> untuk paket ini. Centang checkbox pada soal yang ingin dimasukkan ke dalam paket.</p>
                        <p class="mt-1">Soal yang sudah dipilih sebelumnya akan ditandai dengan centang.</p>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.packages.save-questions', $package->id) }}" id="selectForm">
                @csrf
                
                <div class="flex justify-between items-center mb-4">
                    <div class="flex gap-3">
                        <button type="button" onclick="selectAll()" class="bg-blue-500 text-white px-3 py-1 rounded text-sm hover:bg-blue-600">
                            <i class="fas fa-check-double mr-1"></i>Pilih Semua
                        </button>
                        <button type="button" onclick="unselectAll()" class="bg-gray-500 text-white px-3 py-1 rounded text-sm hover:bg-gray-600">
                            <i class="fas fa-times mr-1"></i>Hapus Semua
                        </button>
                    </div>
                    <div class="text-sm text-gray-500">
                        Menampilkan {{ $questions->firstItem() }}-{{ $questions->lastItem() }} dari {{ $questions->total() }} soal
                    </div>
                </div>

                <div class="space-y-3 mb-6">
                    @foreach($questions as $q)
                    <label class="flex items-start gap-3 p-4 border rounded-xl cursor-pointer hover:bg-purple-50 transition">
                        <input type="checkbox" 
                               name="questions[]" 
                               value="{{ $q->id }}"
                               class="question-checkbox w-5 h-5 mt-0.5 text-purple-600 rounded"
                               onchange="updateSelectedCount()"
                               {{ in_array($q->id, $selectedQuestionIds) ? 'checked' : '' }}>
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1 flex-wrap">
                                <span class="text-xs px-2 py-0.5 rounded-full 
                                    @if($q->category == 'twk') bg-red-100 text-red-600
                                    @elseif($q->category == 'tiu') bg-blue-100 text-blue-600
                                    @else bg-green-100 text-green-600 @endif">
                                    {{ strtoupper($q->category) }}
                                </span>
                                <span class="text-xs text-gray-400">ID: {{ $q->id }}</span>
                                <span class="text-xs px-2 py-0.5 rounded-full 
                                    @if($q->difficulty == 'easy') bg-green-100 text-green-600
                                    @elseif($q->difficulty == 'medium') bg-yellow-100 text-yellow-600
                                    @else bg-red-100 text-red-600 @endif">
                                    {{ ucfirst($q->difficulty) }}
                                </span>
                            </div>
                            <p class="text-gray-800">{{ $q->question_text }}</p>
                            <div class="grid grid-cols-5 gap-2 mt-2 text-xs text-gray-500">
                                <span>A. {{ Str::limit($q->option_a, 30) }}</span>
                                <span>B. {{ Str::limit($q->option_b, 30) }}</span>
                                <span>C. {{ Str::limit($q->option_c, 30) }}</span>
                                <span>D. {{ Str::limit($q->option_d, 30) }}</span>
                                <span>E. {{ Str::limit($q->option_e, 30) }}</span>
                            </div>
                            <div class="mt-2 text-xs text-green-600">
                                Jawaban: <strong>{{ strtoupper($q->correct_answer) }}</strong>
                            </div>
                        </div>
                    </label>
                    @endforeach
                </div>

                <div class="flex justify-between items-center">
                    <div>
                        {{ $questions->appends(['package_id' => $package->id])->links() }}
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('admin.packages.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition">
                            Batal
                        </a>
                        <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded-lg hover:bg-green-600 transition" id="submitBtn">
                            <i class="fas fa-save mr-2"></i>Simpan 50 Soal
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </main>
</div>

<script>
    function updateSelectedCount() {
        let checked = document.querySelectorAll('.question-checkbox:checked').length;
        document.getElementById('selectedCount').innerText = checked;
        
        let submitBtn = document.getElementById('submitBtn');
        if(checked === 50) {
            submitBtn.classList.remove('bg-green-500');
            submitBtn.classList.add('bg-green-600');
            submitBtn.innerHTML = '<i class="fas fa-check-circle mr-2"></i>Simpan 50 Soal (Lengkap)';
        } else {
            submitBtn.classList.remove('bg-green-600');
            submitBtn.classList.add('bg-green-500');
            submitBtn.innerHTML = '<i class="fas fa-save mr-2"></i>Simpan ' + checked + '/50 Soal (Butuh 50)';
        }
    }
    
    function selectAll() {
        document.querySelectorAll('.question-checkbox').forEach(cb => {
            cb.checked = true;
        });
        updateSelectedCount();
    }
    
    function unselectAll() {
        document.querySelectorAll('.question-checkbox').forEach(cb => {
            cb.checked = false;
        });
        updateSelectedCount();
    }
    
    document.getElementById('selectForm').addEventListener('submit', function(e) {
        let checked = document.querySelectorAll('.question-checkbox:checked').length;
        if(checked !== 50) {
            e.preventDefault();
            alert('Harus memilih tepat 50 soal! Saat ini: ' + checked + ' soal');
        }
    });
    
    // Initial count
    updateSelectedCount();
</script>

</body>
</html>