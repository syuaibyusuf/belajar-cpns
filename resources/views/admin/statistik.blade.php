<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistik - Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                <i class="fas fa-box"></i> Manajemen Paket
            </a>
            <a href="{{ route('admin.statistik') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-purple-700">
                <i class="fas fa-chart-line"></i> Statistik
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
        <h1 class="text-2xl font-bold mb-8">📊 Statistik Belajar</h1>

        <div class="grid md:grid-cols-2 gap-8">
            <!-- Jumlah Soal per Kategori -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h2 class="font-bold mb-4">Jumlah Soal per Kategori</h2>
                <canvas id="soalChart" height="200"></canvas>
                <div class="mt-4 space-y-2">
                    <div class="flex justify-between">
                        <span>🇮🇩 TWK:</span>
                        <span class="font-bold">{{ $stats['twk'] }} soal</span>
                    </div>
                    <div class="flex justify-between">
                        <span>🧠 TIU:</span>
                        <span class="font-bold">{{ $stats['tiu'] }} soal</span>
                    </div>
                    <div class="flex justify-between">
                        <span>💼 TKP:</span>
                        <span class="font-bold">{{ $stats['tkp'] }} soal</span>
                    </div>
                </div>
            </div>

            <!-- Rata-rata Nilai User -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h2 class="font-bold mb-4">Rata-rata Nilai User</h2>
                <canvas id="nilaiChart" height="200"></canvas>
                <div class="mt-4 space-y-2">
                    <div class="flex justify-between">
                        <span>🇮🇩 TWK:</span>
                        <span class="font-bold">{{ round($userStats['twk']) }}%</span>
                    </div>
                    <div class="flex justify-between">
                        <span>🧠 TIU:</span>
                        <span class="font-bold">{{ round($userStats['tiu']) }}%</span>
                    </div>
                    <div class="flex justify-between">
                        <span>💼 TKP:</span>
                        <span class="font-bold">{{ round($userStats['tkp']) }}%</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grafik Progress per Kategori -->
        <div class="bg-white rounded-xl shadow-sm p-6 mt-8">
            <h2 class="font-bold mb-4">Progress Test per Kategori (7 Hari Terakhir)</h2>
            <canvas id="progressChart" height="100"></canvas>
        </div>
    </main>
</div>

<script>
    // Chart Jumlah Soal
    new Chart(document.getElementById('soalChart'), {
        type: 'bar',
        data: {
            labels: ['TWK', 'TIU', 'TKP'],
            datasets: [{
                label: 'Jumlah Soal',
                data: [{{ $stats['twk'] }}, {{ $stats['tiu'] }}, {{ $stats['tkp'] }}],
                backgroundColor: ['#ef4444', '#3b82f6', '#10b981']
            }]
        }
    });

    // Chart Rata-rata Nilai
    new Chart(document.getElementById('nilaiChart'), {
        type: 'line',
        data: {
            labels: ['TWK', 'TIU', 'TKP'],
            datasets: [{
                label: 'Rata-rata Nilai (%)',
                data: [{{ round($userStats['twk']) }}, {{ round($userStats['tiu']) }}, {{ round($userStats['tkp']) }}],
                borderColor: '#8b5cf6',
                backgroundColor: 'rgba(139, 92, 246, 0.1)',
                tension: 0.4,
                fill: true
            }]
        }
    });

    // Chart Progress per Kategori
    new Chart(document.getElementById('progressChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode($weeklyProgress['labels']) !!},
            datasets: [
                {
                    label: 'TWK',
                    data: {!! json_encode($weeklyProgress['twk']) !!},
                    borderColor: '#ef4444',
                    tension: 0.4
                },
                {
                    label: 'TIU',
                    data: {!! json_encode($weeklyProgress['tiu']) !!},
                    borderColor: '#3b82f6',
                    tension: 0.4
                },
                {
                    label: 'TKP',
                    data: {!! json_encode($weeklyProgress['tkp']) !!},
                    borderColor: '#10b981',
                    tension: 0.4
                }
            ]
        }
    });
</script>

</body>
</html>