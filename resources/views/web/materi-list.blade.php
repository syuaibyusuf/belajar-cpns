<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Materi {{ $categoryInfo['name'] }} - Belajar CPNS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100 font-[Inter]">

<div class="container mx-auto px-4 py-8 max-w-4xl">
    <a href="{{ route('home') }}" class="inline-flex items-center text-purple-600 hover:text-purple-700 mb-6">
        <i class="fas fa-arrow-left mr-2"></i> Kembali
    </a>

    <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-8">
        <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-6 py-8 text-white">
            <div class="text-5xl mb-3">{{ $categoryInfo['icon'] }}</div>
            <h1 class="text-2xl font-bold">{{ $categoryInfo['name'] }}</h1>
            <p class="opacity-90 mt-1">Pelajari materi berikut untuk mempersiapkan ujian</p>
        </div>
    </div>

    <div class="space-y-4">
        @forelse($materiList as $item)
        <a href="{{ route('materi.detail', $item->id) }}" class="block bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <h3 class="font-bold text-lg mb-2">{{ $item->title }}</h3>
                    <p class="text-gray-500 text-sm line-clamp-2">{{ Str::limit(strip_tags($item->content), 150) }}</p>
                </div>
                <i class="fas fa-chevron-right text-gray-400 mt-2"></i>
            </div>
        </a>
        @empty
        <div class="bg-white rounded-xl p-8 text-center">
            <i class="fas fa-book-open text-5xl text-gray-300 mb-3"></i>
            <p class="text-gray-500">Belum ada materi untuk kategori ini</p>
        </div>
        @endforelse
    </div>
</div>

</body>
</html>