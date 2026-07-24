<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - Belajar CPNS</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        * { font-family: 'Inter', sans-serif; }
        .sidebar-active {
            background: linear-gradient(135deg, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0.05) 100%);
            border-left: 3px solid white;
        }
        .menu-item {
            transition: all 0.2s ease;
        }
        .menu-item:hover {
            transform: translateX(4px);
            background: rgba(255, 255, 255, 0.1);
        }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #8b5cf6; border-radius: 3px; }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gray-100">

<div class="flex min-h-screen">
    <!-- SIDEBAR ADMIN -->
    <aside class="w-64 bg-gradient-to-br from-gray-900 to-gray-800 text-white fixed h-full shadow-xl z-30 overflow-y-auto">
        <div class="p-6 border-b border-gray-700">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-purple-600 rounded-xl flex items-center justify-center text-xl">🛡️</div>
                <div>
                    <div class="font-bold text-lg">Admin Panel</div>
                    <div class="text-xs text-gray-400">Belajar CPNS</div>
                </div>
            </div>
        </div>
        
        <nav class="p-4 space-y-1">
            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}" class="menu-item flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'sidebar-active bg-purple-700' : 'hover:bg-gray-700' }}">
                <i class="fas fa-tachometer-alt w-5"></i>
                <span>Dashboard</span>
            </a>
            
            <!-- Manajemen Materi -->
            <a href="{{ route('admin.materi.index') }}" class="menu-item flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.materi.*') ? 'sidebar-active bg-purple-700' : 'hover:bg-gray-700' }}">
                <i class="fas fa-book w-5"></i>
                <span>Manajemen Materi</span>
            </a>
            
            <!-- Manajemen Soal -->
            <a href="{{ route('admin.soal.index') }}" class="menu-item flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.soal.*') ? 'sidebar-active bg-purple-700' : 'hover:bg-gray-700' }}">
                <i class="fas fa-question-circle w-5"></i>
                <span>Manajemen Soal</span>
            </a>
            
            <!-- Manajemen Paket -->
            <a href="{{ route('admin.packages.index') }}" class="menu-item flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.packages.*') ? 'sidebar-active bg-purple-700' : 'hover:bg-gray-700' }}">
                <i class="fas fa-box w-5"></i>
                <span>Manajemen Paket</span>
            </a>
            
            <!-- Try Out -->
            <a href="{{ route('admin.tryouts.index') }}" class="menu-item flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.tryouts.*') ? 'sidebar-active bg-purple-700' : 'hover:bg-gray-700' }}">
                <i class="fas fa-trophy w-5"></i>
                <span>Try Out (110 Soal)</span>
            </a>
            
            <!-- ==================== MENU BACKUP DATABASE (STEP 4) ==================== -->
            <a href="{{ route('admin.backup.index') }}" class="menu-item flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.backup.*') ? 'sidebar-active bg-purple-700' : 'hover:bg-gray-700' }}">
                <i class="fas fa-database w-5"></i>
                <span>Backup Database</span>
            </a>
            
            <!-- Saran & Masukan -->
            @php 
                $unreadCount = App\Models\Feedback::where('status', 'unread')->count(); 
            @endphp
            <a href="{{ route('admin.feedback.index') }}" class="menu-item flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.feedback.*') ? 'sidebar-active bg-purple-700' : 'hover:bg-gray-700' }}">
                <i class="fas fa-comment-dots w-5"></i>
                <span>Saran & Masukan</span>
                @if($unreadCount > 0)
                <span class="bg-red-500 text-white text-xs px-2 py-0.5 rounded-full ml-auto">{{ $unreadCount }}</span>
                @endif
            </a>
            
            <!-- Logout -->
            <div class="pt-8 mt-4 border-t border-gray-700">
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="menu-item w-full flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-red-600 transition-all text-left">
                        <i class="fas fa-sign-out-alt w-5"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </nav>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 ml-64">
        <!-- Top Navbar -->
        <div class="bg-white shadow-sm sticky top-0 z-20">
            <div class="px-8 py-4 flex justify-between items-center">
                <h1 class="text-xl font-bold text-gray-800">@yield('header', 'Dashboard')</h1>
                <div class="flex items-center gap-4">
                    <span class="text-sm text-gray-600">
                        <i class="fas fa-user-circle mr-2"></i>
                        {{ session('admin_name') }}
                    </span>
                    <span class="text-xs bg-purple-100 text-purple-600 px-3 py-1 rounded-full">
                        {{ session('admin_role') }}
                    </span>
                </div>
            </div>
        </div>
        
        <!-- Page Content -->
        <div class="p-8">
            @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded mb-6 shadow-sm">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
            </div>
            @endif
            
            @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded mb-6">
                <i class="fas fa-exclamation-circle mr-2"></i>
                {{ session('error') }}
            </div>
            @endif
            
            @yield('content')
        </div>
    </main>
</div>

@stack('scripts')
</body>
</html>