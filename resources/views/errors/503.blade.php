<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>503 - Pemeliharaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>* { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="text-center max-w-md">
        <div class="text-8xl font-bold text-gray-300 mb-4">503</div>
        <div class="w-20 h-20 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-tools text-gray-500 text-3xl"></i>
        </div>
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Sedang Pemeliharaan</h1>
        <p class="text-gray-500 mb-8">Kami sedang melakukan pemeliharaan. Silakan kembali lagi nanti.</p>
        <a href="{{ url('/') }}" class="inline-flex items-center gap-2 bg-purple-600 text-white px-6 py-3 rounded-xl hover:bg-purple-700 transition">
            <i class="fas fa-sync-alt"></i> Coba Lagi
        </a>
    </div>
</body>
</html>
