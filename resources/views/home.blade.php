<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>Belajar CPNS - Home</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card-hover:active {
            transform: scale(0.98);
        }
        /* Untuk touch-friendly */
        button, a, [role="button"] {
            touch-action: manipulation;
            cursor: pointer;
        }
        /* Smooth scroll */
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="gradient-bg text-white shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-4 py-3">
            <div class="flex items-center justify-between">
                <div class="text-xl md:text-2xl font-bold">✨ Belajar CPNS</div>
                <div class="text-xs md:text-sm bg-white/20 px-3 py-1 rounded-full">Tanpa Login</div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="gradient-bg text-white py-12 md:py-20">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-3xl md:text-5xl font-bold mb-3">Siap Jadi ASN? 🎯</h1>
            <p class="text-base md:text-xl opacity-90 px-4">Belajar TWK, TIU, dan TKP dengan soal-soal terbaru</p>
        </div>
    </div>

    <!-- Cards Section -->
    <div class="container mx-auto px-4 py-8 md:py-16">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-8">
            
            <!-- Card TWK -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden card-hover">
                <div class="bg-red-500 h-2"></div>
                <div class="p-5 md:p-6">
                    <div class="text-4xl md:text-5xl mb-3">🇮🇩</div>
                    <h3 class="text-xl md:text-2xl font-bold mb-2">TWK</h3>
                    <p class="text-gray-600 text-sm mb-4">Tes Wawasan Kebangsaan<br>Nasionalisme & Kebangsaan</p>
                    <div class="space-y-2">
                        <a href="{{ route('materi', 'twk') }}" 
                           class="block text-center bg-red-500 text-white py-3 rounded-lg hover:bg-red-600 transition active:bg-red-700">
                            📖 Lihat Materi
                        </a>
                        <a href="{{ route('test', 'twk') }}" 
                           class="block text-center border-2 border-red-500 text-red-500 py-3 rounded-lg hover:bg-red-50 transition active:bg-red-100">
                            📝 Mulai Test
                        </a>
                    </div>
                </div>
            </div>

            <!-- Card TIU -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden card-hover">
                <div class="bg-blue-500 h-2"></div>
                <div class="p-5 md:p-6">
                    <div class="text-4xl md:text-5xl mb-3">🧠</div>
                    <h3 class="text-xl md:text-2xl font-bold mb-2">TIU</h3>
                    <p class="text-gray-600 text-sm mb-4">Tes Intelegensi Umum<br>Logika & Numerik</p>
                    <div class="space-y-2">
                        <a href="{{ route('materi', 'tiu') }}" 
                           class="block text-center bg-blue-500 text-white py-3 rounded-lg hover:bg-blue-600 transition active:bg-blue-700">
                            📖 Lihat Materi
                        </a>
                        <a href="{{ route('test', 'tiu') }}" 
                           class="block text-center border-2 border-blue-500 text-blue-500 py-3 rounded-lg hover:bg-blue-50 transition active:bg-blue-100">
                            📝 Mulai Test
                        </a>
                    </div>
                </div>
            </div>

            <!-- Card TKP -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden card-hover">
                <div class="bg-green-500 h-2"></div>
                <div class="p-5 md:p-6">
                    <div class="text-4xl md:text-5xl mb-3">💼</div>
                    <h3 class="text-xl md:text-2xl font-bold mb-2">TKP</h3>
                    <p class="text-gray-600 text-sm mb-4">Tes Karakteristik Pribadi<br>Sikap & Kepribadian</p>
                    <div class="space-y-2">
                        <a href="{{ route('materi', 'tkp') }}" 
                           class="block text-center bg-green-500 text-white py-3 rounded-lg hover:bg-green-600 transition active:bg-green-700">
                            📖 Lihat Materi
                        </a>
                        <a href="{{ route('test', 'tkp') }}" 
                           class="block text-center border-2 border-green-500 text-green-500 py-3 rounded-lg hover:bg-green-50 transition active:bg-green-100">
                            📝 Mulai Test
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Floating Tombol Kembali ke Atas (Untuk HP) -->
    <button onclick="window.scrollTo({top:0,behavior:'smooth'})" 
            class="fixed bottom-5 right-5 bg-purple-600 text-white w-12 h-12 rounded-full shadow-lg hover:bg-purple-700 active:bg-purple-800 transition z-50 hidden md:block"
            id="scrollTop">
        ↑
    </button>

    <footer class="bg-gray-800 text-white py-6 mt-8">
        <div class="container mx-auto px-4 text-center text-sm">
            <p>© 2024 Aplikasi Belajar CPNS - Gratis Tanpa Login</p>
        </div>
    </footer>

    <script>
        // Tampilkan tombol scroll ke atas saat scroll
        let scrollBtn = document.getElementById('scrollTop');
        if(scrollBtn) {
            window.addEventListener('scroll', function() {
                if(window.scrollY > 300) {
                    scrollBtn.classList.remove('hidden');
                } else {
                    scrollBtn.classList.add('hidden');
                }
            });
        }
    </script>
</body>
</html>