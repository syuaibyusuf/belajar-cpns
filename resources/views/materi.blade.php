<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>Materi - {{ $materi['title'] }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .prose {
            font-size: 16px;
            line-height: 1.6;
        }
        @media (max-width: 640px) {
            .prose {
                font-size: 14px;
            }
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-4 md:py-8 max-w-4xl">
        <!-- Tombol Back -->
        <a href="{{ route('home') }}" class="inline-flex items-center text-purple-600 hover:text-purple-700 mb-4 md:mb-6 text-sm md:text-base">
            ← Kembali ke Home
        </a>

        <!-- Card Materi -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-5 py-4 md:px-6 md:py-4">
                <h1 class="text-xl md:text-2xl font-bold text-white">{{ $materi['title'] }}</h1>
            </div>
            <div class="p-5 md:p-8">
                <div class="prose max-w-none">
                    <p class="text-gray-700 leading-relaxed whitespace-pre-line text-sm md:text-base">
                        {{ $materi['content'] }}
                    </p>
                </div>
                
                <div class="mt-6 md:mt-8 pt-5 md:pt-6 border-t border-gray-200">
                    <a href="{{ route('test', $category) }}" 
                       class="block md:inline-block bg-green-500 text-white text-center px-6 py-3 rounded-lg hover:bg-green-600 transition active:bg-green-700">
                        🚀 Mulai Test Sekarang
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>