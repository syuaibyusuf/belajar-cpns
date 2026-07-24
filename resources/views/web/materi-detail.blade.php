<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $materi->title }} - Belajar CPNS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100 font-[Inter]">

<div class="container mx-auto px-4 py-8 max-w-4xl">
    <a href="{{ route('materi.by-category', $materi->category) }}" class="inline-flex items-center text-purple-600 hover:text-purple-700 mb-6">
        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Materi
    </a>

    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        @if($materi->image)
        <img src="{{ asset('uploads/materi/'.$materi->image) }}" class="w-full h-64 object-cover">
        @endif
        
        <div class="p-6 md:p-8">
            <h1 class="text-2xl md:text-3xl font-bold mb-4">{{ $materi->title }}</h1>
            
            <div class="prose max-w-none text-gray-700 leading-relaxed">
                {!! nl2br(e($materi->content)) !!}
            </div>
            
            <div class="mt-8 pt-6 border-t">
                <a href="{{ route('test', $materi->category) }}" 
                   class="inline-block bg-green-500 text-white px-6 py-3 rounded-lg hover:bg-green-600 transition">
                    🚀 Latihan Soal {{ strtoupper($materi->category) }}
                </a>
            </div>
        </div>
    </div>
</div>

</body>
</html>