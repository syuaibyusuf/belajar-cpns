<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>@yield('title', 'Belajar CPNS') - Belajar CPNS</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        * { font-family: 'Inter', sans-serif; }
        
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #8b5cf6; border-radius: 3px; }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in { animation: fadeIn 0.3s ease-out; }
        
        @keyframes slideIn {
            from { transform: translateX(-100%); }
            to { transform: translateX(0); }
        }
        .animate-slide-in { animation: slideIn 0.3s ease-out; }
        
        .sidebar-transition { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .menu-hover { transition: all 0.2s ease; }
        .menu-hover:hover { transform: translateX(4px); }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100">

<!-- Mobile Overlay -->
<div id="mobileOverlay" class="fixed inset-0 bg-black/50 z-30 hidden transition-all duration-300 md:hidden"></div>

<div class="flex min-h-screen">
    <!-- SIDEBAR TETAP -->
    <aside id="sidebar" class="fixed md:relative w-72 h-full bg-gradient-to-br from-indigo-900 via-purple-900 to-purple-800 text-white shadow-2xl z-40 sidebar-transition -translate-x-full md:translate-x-0 overflow-y-auto">
        
        <!-- Sidebar Header -->
        <div class="p-6 border-b border-white/20">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center text-2xl backdrop-blur">🎯</div>
                <div>
                    <div class="text-xl font-bold tracking-tight">Belajar CPNS</div>
                    <div class="text-xs text-white/60 mt-0.5">Siap Jadi ASN</div>
                </div>
            </div>
        </div>
        
        <!-- Progress Card -->
        <div class="mx-4 mt-6 p-4 bg-white/10 rounded-2xl backdrop-blur-sm">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm text-white/70">Progress Belajar</span>
                <span class="text-xs font-medium bg-white/20 px-2 py-0.5 rounded-full">Hari ini</span>
            </div>
            <div class="text-2xl font-bold">{{ $totalDikerjakan ?? 0 }}</div>
            <div class="text-xs text-white/50 mt-1">Soal dikerjakan</div>
            <div class="w-full bg-white/20 rounded-full h-2 mt-3">
                <div class="bg-gradient-to-r from-green-400 to-emerald-500 h-2 rounded-full transition-all duration-500" 
                     style="width: {{ isset($totalSoal) && $totalSoal > 0 ? round(($totalDikerjakan ?? 0) / $totalSoal * 100) : 0 }}%">
                </div>
            </div>
            <div class="text-right text-xs text-white/40 mt-1">{{ $totalSoal ?? 0 }} total soal</div>
        </div>
        
        <!-- MENU UTAMA -->
        <nav class="flex-1 px-4 py-6">
            <div class="text-xs font-semibold text-white/40 uppercase tracking-wider mb-3 px-3">Menu Utama</div>
            
            <a href="{{ route('home') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 menu-hover {{ request()->routeIs('home') ? 'bg-white/20 shadow-lg' : 'hover:bg-white/10' }}">
                <i class="fas fa-home w-5 text-lg"></i>
                <span class="flex-1">Dashboard</span>
                @if(request()->routeIs('home'))
                <i class="fas fa-circle text-[6px] text-green-400"></i>
                @endif
            </a>
            
            <a href="{{ route('materi.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 menu-hover {{ request()->routeIs('materi.*') ? 'bg-white/20 shadow-lg' : 'hover:bg-white/10' }}">
                <i class="fas fa-book w-5"></i>
                <span class="flex-1">Semua Materi</span>
            </a>
            
            <a href="{{ route('latihan') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 menu-hover {{ request()->routeIs('latihan') ? 'bg-white/20 shadow-lg' : 'hover:bg-white/10' }}">
                <i class="fas fa-pencil-alt w-5"></i>
                <span class="flex-1">Latihan Soal</span>
            </a>
            
            <a href="{{ route('packages.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 menu-hover {{ request()->routeIs('packages.*') ? 'bg-white/20 shadow-lg' : 'hover:bg-white/10' }}">
                <i class="fas fa-box w-5"></i>
                <span class="flex-1">Paket Soal (50)</span>
            </a>
            
            <div class="text-xs font-semibold text-white/40 uppercase tracking-wider mb-3 mt-6 px-3">Kategori Materi</div>
            
            <a href="{{ route('materi.by-category', 'twk') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 hover:bg-white/10 group">
                <span class="text-xl">🇮🇩</span>
                <span class="flex-1">Tes Wawasan Kebangsaan</span>
                <i class="fas fa-chevron-right text-white/30 text-xs group-hover:translate-x-1 transition-transform"></i>
            </a>
            
            <a href="{{ route('materi.by-category', 'tiu') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 hover:bg-white/10 group">
                <span class="text-xl">🧠</span>
                <span class="flex-1">Tes Intelegensi Umum</span>
                <i class="fas fa-chevron-right text-white/30 text-xs group-hover:translate-x-1 transition-transform"></i>
            </a>
            
            <a href="{{ route('materi.by-category', 'tkp') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 hover:bg-white/10 group">
                <span class="text-xl">💼</span>
                <span class="flex-1">Tes Karakteristik Pribadi</span>
                <i class="fas fa-chevron-right text-white/30 text-xs group-hover:translate-x-1 transition-transform"></i>
            </a>
            
            <!-- Statistik Ringkas -->
            <div class="text-xs font-semibold text-white/40 uppercase tracking-wider mb-3 mt-6 px-3">Statistik</div>
            <div class="px-4 py-2">
                <div class="flex justify-between text-sm mb-1">
                    <span>TWK</span>
                    <span>{{ $statistik['twk']['persentase'] ?? 0 }}%</span>
                </div>
                <div class="w-full bg-white/20 rounded-full h-1.5 mb-3">
                    <div class="bg-red-400 h-1.5 rounded-full" style="width: {{ $statistik['twk']['persentase'] ?? 0 }}%"></div>
                </div>
                
                <div class="flex justify-between text-sm mb-1">
                    <span>TIU</span>
                    <span>{{ $statistik['tiu']['persentase'] ?? 0 }}%</span>
                </div>
                <div class="w-full bg-white/20 rounded-full h-1.5 mb-3">
                    <div class="bg-blue-400 h-1.5 rounded-full" style="width: {{ $statistik['tiu']['persentase'] ?? 0 }}%"></div>
                </div>
                
                <div class="flex justify-between text-sm mb-1">
                    <span>TKP</span>
                    <span>{{ $statistik['tkp']['persentase'] ?? 0 }}%</span>
                </div>
                <div class="w-full bg-white/20 rounded-full h-1.5">
                    <div class="bg-green-400 h-1.5 rounded-full" style="width: {{ $statistik['tkp']['persentase'] ?? 0 }}%"></div>
                </div>
            </div>
        </nav>
        
        <!-- Sidebar Footer -->
        <div class="p-4 border-t border-white/10 mt-auto">
            <div class="bg-gradient-to-r from-purple-600/50 to-pink-600/50 rounded-xl p-3 text-center">
                <div class="text-2xl mb-1">⭐</div>
                <div class="text-xs font-medium">Target: ASN 2024</div>
                <div class="text-2xs text-white/50 mt-1">Terus Belajar!</div>
            </div>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 min-h-screen overflow-x-hidden">
        
        <!-- Top Navbar -->
        <nav class="bg-white/95 backdrop-blur-sm sticky top-0 z-20 shadow-sm border-b border-gray-100">
            <div class="px-4 md:px-8 py-4 flex justify-between items-center">
                <button id="mobileMenuBtn" class="md:hidden text-gray-600 hover:text-purple-600 transition text-2xl">
                    <i class="fas fa-bars"></i>
                </button>
                
                <h1 class="text-lg font-semibold text-gray-800 md:hidden">
                    @yield('page-title', 'Belajar CPNS')
                </h1>
                
                <div class="flex items-center gap-4 ml-auto">
                    <div class="relative">
                        <i class="fas fa-bell text-gray-500 hover:text-purple-600 cursor-pointer transition text-xl"></i>
                        <span class="absolute -top-1 -right-1 w-2 h-2 bg-red-500 rounded-full animate-pulse"></span>
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

        <!-- Page Content -->
        <div class="p-4 md:p-8 animate-fade-in">
            @yield('content')
        </div>
        
    </main>
</div>

<!-- Mobile Menu Script -->
<script>
    const sidebar = document.getElementById('sidebar');
    const mobileBtn = document.getElementById('mobileMenuBtn');
    const overlay = document.getElementById('mobileOverlay');
    
    if(mobileBtn) {
        mobileBtn.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
            document.body.style.overflow = sidebar.classList.contains('-translate-x-full') ? '' : 'hidden';
        });
    }
    
    if(overlay) {
        overlay.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
            document.body.style.overflow = '';
        });
    }
    
    window.addEventListener('resize', function() {
        if(window.innerWidth >= 768) {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.add('hidden');
            document.body.style.overflow = '';
        }
    });
</script>

@stack('scripts')
</body>
</html>