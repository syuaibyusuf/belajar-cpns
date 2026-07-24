<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>@yield('title', 'Belajar CPNS') - Belajar CPNS</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        .animate-fade-in { animation: fadeIn 0.3s ease-out; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    </style>
    @stack('styles')
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100">

<!-- Top Navbar Sederhana -->
<nav class="bg-white/95 backdrop-blur-sm sticky top-0 z-20 shadow-sm border-b border-gray-100">
    <div class="px-4 md:px-8 py-4 flex justify-between items-center">
        <a href="{{ route('home') }}" class="text-xl font-bold text-purple-600">🎯 Belajar CPNS</a>
        <div class="flex items-center gap-4">
            <div class="relative">
                <i class="fas fa-bell text-gray-500 hover:text-purple-600 cursor-pointer text-xl"></i>
            </div>
            <div class="flex items-center gap-3 bg-purple-50 rounded-full pl-3 pr-2 py-1 shadow-sm">
                <span class="text-sm text-purple-700 hidden sm:inline">Pejuang ASN</span>
                <div class="w-8 h-8 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white text-sm font-bold">🎯</div>
            </div>
        </div>
    </div>
    @hasSection('breadcrumb')
    <div class="px-4 md:px-8 pb-3 text-sm text-gray-500 border-t border-gray-100 pt-2">
        @yield('breadcrumb')
    </div>
    @endif
</nav>

<!-- Page Content - Full Width -->
<main class="container mx-auto px-4 py-6 animate-fade-in">
    @yield('content')
</main>

<footer class="bg-gray-800 text-white mt-8 py-4">
    <div class="container mx-auto px-4 text-center text-sm">
        © 2024 Belajar CPNS - Siap Jadi ASN
    </div>
</footer>

@stack('scripts')
</body>
</html>