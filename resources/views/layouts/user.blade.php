<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
        
        .sidebar-transition { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .menu-hover { transition: all 0.2s ease; }
        .menu-hover:hover { transform: translateX(4px); }
        
        .progress-bar { transition: width 0.5s ease; }
        body.sidebar-open { overflow: hidden; }
        
        /* Loading Animation */
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        .animate-spin {
            animation: spin 0.8s linear infinite;
        }
        .loading-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 9999;
            display: none;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }
        .loading-overlay.active {
            display: flex;
        }
        .loading-card {
            background: white;
            border-radius: 1rem;
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }
        .loading-spinner {
            width: 48px;
            height: 48px;
            border: 4px solid #e9d5ff;
            border-top-color: #8b5cf6;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            margin-bottom: 0.75rem;
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100">

<!-- LOADING OVERLAY GLOBAL -->
<div id="globalLoading" class="loading-overlay">
    <div class="loading-card">
        <div class="loading-spinner"></div>
        <p id="loadingText" class="text-gray-600 text-sm">Memuat...</p>
    </div>
</div>

<!-- Mobile Overlay -->
<div id="mobileOverlay" class="fixed inset-0 bg-black/50 z-30 hidden transition-all duration-300"></div>

<div class="flex min-h-screen">
    <!-- SIDEBAR -->
    <aside id="sidebar" class="fixed top-0 left-0 z-40 w-80 h-full bg-gradient-to-br from-indigo-900 via-purple-900 to-purple-800 text-white shadow-2xl sidebar-transition -translate-x-full md:relative md:translate-x-0 overflow-y-auto">
        
        <div class="p-6 border-b border-white/10">
            <div class="flex items-center gap-3.5">
                <div class="w-12 h-12 bg-gradient-to-br from-purple-400 to-purple-600 rounded-2xl flex items-center justify-center text-2xl shadow-lg shadow-purple-900/30">🎯</div>
                <div>
                    <div class="text-xl font-bold tracking-tight">Belajar CPNS</div>
                    <div class="text-[11px] text-white/50 mt-0.5">Siap Jadi ASN 2024</div>
                </div>
            </div>
            <button id="closeSidebarBtn" class="absolute top-5 right-5 text-white/50 hover:text-white md:hidden text-lg"><i class="fas fa-times"></i></button>
        </div>
        
        <div class="mx-4 mt-5 p-4 bg-gradient-to-br from-white/10 to-white/5 rounded-2xl backdrop-blur border border-white/10">
            <div class="flex items-center justify-between mb-2.5">
                <span class="text-sm font-medium text-white/80 flex items-center gap-1.5">📊 Progress</span>
                <span class="text-[10px] font-bold bg-white/20 px-2 py-0.5 rounded-full text-white/70">Hari ini</span>
            </div>
            <div class="text-2xl font-bold">{{ $totalDikerjakan ?? 0 }}</div>
            <div class="text-[11px] text-white/50 mt-0.5">Soal telah dikerjakan</div>
            <div class="w-full bg-white/15 rounded-full h-2 mt-3">
                <div class="bg-gradient-to-r from-emerald-400 to-emerald-500 h-2 rounded-full transition-all duration-500" 
                     style="width: {{ isset($totalSoal) && $totalSoal > 0 ? round(($totalDikerjakan ?? 0) / $totalSoal * 100) : 0 }}%"></div>
            </div>
            <div class="flex justify-between text-[11px] text-white/40 mt-1.5">
                <span>Target {{ $totalSoal ?? 0 }} soal</span>
                <span>{{ isset($totalSoal) && $totalSoal > 0 ? round(($totalDikerjakan ?? 0) / $totalSoal * 100) : 0 }}%</span>
            </div>
        </div>
        
        <nav class="flex-1 px-4 py-6">
            <div class="text-[10px] font-bold text-white/30 uppercase tracking-[0.1em] mb-3 px-3">Menu Utama</div>
            
            <a href="{{ route('home') }}" class="flex items-center gap-3.5 px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('home') ? 'bg-white/15 shadow-sm' : 'hover:bg-white/5' }} mb-0.5 group">
                <span class="w-8 h-8 rounded-lg flex items-center justify-center text-sm {{ request()->routeIs('home') ? 'bg-purple-500/30 text-purple-300' : 'text-white/50 group-hover:text-white/70' }}">
                    <i class="fas fa-home"></i>
                </span>
                <span class="flex-1 text-sm font-medium {{ request()->routeIs('home') ? 'text-white' : 'text-white/70' }}">Dashboard</span>
                @if(request()->routeIs('home'))<span class="w-1.5 h-1.5 rounded-full bg-purple-400"></span>@endif
            </a>
            
            <a href="{{ route('materi.index') }}" class="flex items-center gap-3.5 px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('materi.*') ? 'bg-white/15 shadow-sm' : 'hover:bg-white/5' }} mb-0.5 group">
                <span class="w-8 h-8 rounded-lg flex items-center justify-center text-sm {{ request()->routeIs('materi.*') ? 'bg-blue-500/30 text-blue-300' : 'text-white/50 group-hover:text-white/70' }}">
                    <i class="fas fa-book-open"></i>
                </span>
                <span class="flex-1 text-sm font-medium {{ request()->routeIs('materi.*') ? 'text-white' : 'text-white/70' }}">Materi Belajar</span>
            </a>
            
            <a href="{{ route('packages.index') }}" class="flex items-center gap-3.5 px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('packages.*') ? 'bg-white/15 shadow-sm' : 'hover:bg-white/5' }} mb-0.5 group">
                <span class="w-8 h-8 rounded-lg flex items-center justify-center text-sm {{ request()->routeIs('packages.*') ? 'bg-emerald-500/30 text-emerald-300' : 'text-white/50 group-hover:text-white/70' }}">
                    <i class="fas fa-box"></i>
                </span>
                <span class="flex-1 text-sm font-medium {{ request()->routeIs('packages.*') ? 'text-white' : 'text-white/70' }}">Paket Soal</span>
            </a>
            
            <a href="{{ route('tryouts.index') }}" class="flex items-center gap-3.5 px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('tryouts.*') ? 'bg-white/15 shadow-sm' : 'hover:bg-white/5' }} mb-0.5 group">
                <span class="w-8 h-8 rounded-lg flex items-center justify-center text-sm {{ request()->routeIs('tryouts.*') ? 'bg-amber-500/30 text-amber-300' : 'text-white/50 group-hover:text-white/70' }}">
                    <i class="fas fa-trophy"></i>
                </span>
                <span class="flex-1 text-sm font-medium {{ request()->routeIs('tryouts.*') ? 'text-white' : 'text-white/70' }}">Try Out (110 Soal)</span>
            </a>
            
            <a href="{{ route('feedback.page') }}" class="flex items-center gap-3.5 px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('feedback.page') ? 'bg-white/15 shadow-sm' : 'hover:bg-white/5' }} mb-0.5 group">
                <span class="w-8 h-8 rounded-lg flex items-center justify-center text-sm {{ request()->routeIs('feedback.page') ? 'bg-pink-500/30 text-pink-300' : 'text-white/50 group-hover:text-white/70' }}">
                    <i class="fas fa-comment-dots"></i>
                </span>
                <span class="flex-1 text-sm font-medium {{ request()->routeIs('feedback.page') ? 'text-white' : 'text-white/70' }}">Saran & Masukan</span>
            </a>
            
            <div class="text-[10px] font-bold text-white/30 uppercase tracking-[0.1em] mb-3 mt-7 px-3">Kategori Materi</div>
            
            <a href="{{ route('materi.by-category', 'twk') }}" class="flex items-center gap-3.5 px-3 py-2.5 rounded-xl transition-all duration-200 hover:bg-white/5 group">
                <span class="w-8 h-8 rounded-lg flex items-center justify-center text-base">🇮🇩</span>
                <span class="flex-1 text-sm text-white/70 group-hover:text-white/90">TWK - Wawasan Kebangsaan</span>
                <i class="fas fa-chevron-right text-white/20 text-[10px] group-hover:translate-x-0.5 transition-transform"></i>
            </a>
            
            <a href="{{ route('materi.by-category', 'tiu') }}" class="flex items-center gap-3.5 px-3 py-2.5 rounded-xl transition-all duration-200 hover:bg-white/5 group">
                <span class="w-8 h-8 rounded-lg flex items-center justify-center text-base">🧠</span>
                <span class="flex-1 text-sm text-white/70 group-hover:text-white/90">TIU - Intelegensi Umum</span>
                <i class="fas fa-chevron-right text-white/20 text-[10px] group-hover:translate-x-0.5 transition-transform"></i>
            </a>
            
            <a href="{{ route('materi.by-category', 'tkp') }}" class="flex items-center gap-3.5 px-3 py-2.5 rounded-xl transition-all duration-200 hover:bg-white/5 group">
                <span class="w-8 h-8 rounded-lg flex items-center justify-center text-base">💼</span>
                <span class="flex-1 text-sm text-white/70 group-hover:text-white/90">TKP - Karakteristik Pribadi</span>
                <i class="fas fa-chevron-right text-white/20 text-[10px] group-hover:translate-x-0.5 transition-transform"></i>
            </a>
            
            <div class="text-[10px] font-bold text-white/30 uppercase tracking-[0.1em] mb-3 mt-7 px-3">Statistik Nilai</div>
            <div class="px-3 space-y-3">
                @foreach(['twk' => ['red', '🇮🇩'], 'tiu' => ['blue', '🧠'], 'tkp' => ['green', '💼']] as $cat => [$color, $icon])
                @php $pct = $statistik[$cat]['persentase'] ?? 0; @endphp
                <div>
                    <div class="flex justify-between text-xs mb-1">
                        <span class="text-white/60 flex items-center gap-1.5"><span>{{ $icon }}</span> {{ strtoupper($cat) }}</span>
                        <span class="font-semibold text-white/80">{{ $pct }}%</span>
                    </div>
                    <div class="w-full bg-white/10 rounded-full h-1.5">
                        <div class="bg-{{ $color }}-400 h-1.5 rounded-full transition-all duration-500" style="width: {{ $pct }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </nav>
        
        <div class="p-4 border-t border-white/10">
            <div class="bg-gradient-to-br from-purple-500/20 to-pink-500/20 rounded-xl p-3.5 text-center border border-white/5">
                <div class="text-lg mb-1">⭐</div>
                <div class="text-sm font-semibold text-white/90">Target: ASN 2024</div>
                <div class="text-[11px] text-white/40 mt-0.5">Terus Semangat Belajar!</div>
            </div>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 h-screen overflow-y-auto w-full">
        <nav class="bg-white/90 backdrop-blur-md sticky top-0 z-20 shadow-md border-b border-gray-100">
            <div class="px-4 md:px-8 py-4 flex justify-between items-center">
                <button id="mobileMenuBtn" class="md:hidden text-gray-600 hover:text-purple-600 transition text-2xl focus:outline-none bg-gray-100 w-10 h-10 rounded-full shadow-sm">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 class="text-lg font-bold text-gray-800 md:hidden flex items-center gap-2"><span>🎯</span> Belajar CPNS</h1>
                <div class="flex items-center gap-4 ml-auto md:ml-0">
                    <div class="relative">
                        <button class="text-gray-500 hover:text-purple-600 transition text-xl w-10 h-10 rounded-full hover:bg-gray-100"><i class="fas fa-bell"></i></button>
                        <span class="absolute top-0 right-0 w-2.5 h-2.5 bg-red-500 rounded-full animate-pulse"></span>
                    </div>
                    <div class="flex items-center gap-3 bg-gradient-to-r from-purple-50 to-indigo-50 rounded-full pl-4 pr-2 py-1.5 shadow-sm border border-purple-100">
                        <span class="text-sm font-medium text-purple-700 hidden sm:inline">Pejuang ASN</span>
                        <div class="w-9 h-9 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white text-base font-bold shadow-md">🎯</div>
                    </div>
                </div>
            </div>
            @hasSection('breadcrumb')
            <div class="px-4 md:px-8 pb-3 text-sm text-gray-500 border-t border-gray-100 pt-2 bg-gray-50">@yield('breadcrumb')</div>
            @endif
        </nav>

        <div class="p-4 md:p-8 animate-fade-in">
            @yield('content')
        </div>
    </main>
</div>

<script>
    // Sidebar Toggle
    const sidebar = document.getElementById('sidebar');
    const mobileBtn = document.getElementById('mobileMenuBtn');
    const closeSidebarBtn = document.getElementById('closeSidebarBtn');
    const overlay = document.getElementById('mobileOverlay');
    
    function openSidebar() { if (window.innerWidth < 768) { sidebar.classList.remove('-translate-x-full'); overlay.classList.remove('hidden'); document.body.classList.add('sidebar-open'); } }
    function closeSidebar() { if (window.innerWidth < 768) { sidebar.classList.add('-translate-x-full'); overlay.classList.add('hidden'); document.body.classList.remove('sidebar-open'); } }
    
    if (mobileBtn) mobileBtn.addEventListener('click', openSidebar);
    if (closeSidebarBtn) closeSidebarBtn.addEventListener('click', closeSidebar);
    if (overlay) overlay.addEventListener('click', closeSidebar);
    
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 768) {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.add('hidden');
            document.body.classList.remove('sidebar-open');
        } else {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
            document.body.classList.remove('sidebar-open');
        }
    });
    if (window.innerWidth < 768) { sidebar.classList.add('-translate-x-full'); overlay.classList.add('hidden'); }
    
    // ==================== LOADING STATE ====================
    window.showLoading = function(text = 'Memuat...') {
        const overlay = document.getElementById('globalLoading');
        const loadingText = document.getElementById('loadingText');
        if (overlay) {
            loadingText.textContent = text;
            overlay.classList.add('active');
        }
    };
    
    window.hideLoading = function() {
        const overlay = document.getElementById('globalLoading');
        if (overlay) overlay.classList.remove('active');
    };
    
    // Auto loading on form submit
    document.addEventListener('submit', function(e) {
        if (e.target.tagName === 'FORM' && !e.target.classList.contains('no-loading')) {
            showLoading('Menyimpan data...');
        }
    });
    
    // Auto loading on link click (internal links only)
    document.addEventListener('click', function(e) {
        const link = e.target.closest('a');
        if (link && link.href && link.href.startsWith(window.location.origin) && !link.classList.contains('no-loading')) {
            if (!link.target || link.target === '_self') {
                showLoading('Memuat halaman...');
            }
        }
    });
    
    // Hide loading when page is fully loaded
    window.addEventListener('load', function() {
        hideLoading();
    });
</script>

@stack('scripts')
</body>
</html>