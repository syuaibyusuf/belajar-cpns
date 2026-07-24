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
        .menu-item {
            position: relative;
            transition: all 0.25s ease;
        }
        .menu-item:hover {
            background: rgba(255, 255, 255, 0.08);
        }
        .menu-item.active {
            background: linear-gradient(135deg, rgba(139, 92, 246, 0.3) 0%, rgba(139, 92, 246, 0.1) 100%);
            box-shadow: 0 2px 8px rgba(139, 92, 246, 0.15);
        }
        .menu-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 24px;
            background: #8b5cf6;
            border-radius: 0 4px 4px 0;
        }
        .menu-icon {
            transition: all 0.25s ease;
        }
        .menu-item:hover .menu-icon {
            transform: scale(1.1);
        }
        .menu-item.active .menu-icon {
            transform: scale(1.1);
        }
        .nav-label {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.08em;
            color: rgba(255,255,255,0.35);
            text-transform: uppercase;
            padding: 0 12px;
            margin-top: 20px;
            margin-bottom: 8px;
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
        <div class="p-6 border-b border-gray-700/50">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 bg-gradient-to-br from-purple-500 to-purple-700 rounded-2xl flex items-center justify-center text-lg shadow-lg shadow-purple-900/30">🛡️</div>
                <div>
                    <div class="font-bold text-base">Admin Panel</div>
                    <div class="text-[11px] text-gray-400">Belajar CPNS</div>
                </div>
            </div>
        </div>
        
        <nav class="p-3 space-y-0.5">
            <div class="nav-label">Menu Utama</div>

            <a href="{{ route('admin.dashboard') }}" class="menu-item flex items-center gap-3.5 px-4 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <span class="menu-icon w-8 h-8 rounded-lg flex items-center justify-center text-sm {{ request()->routeIs('admin.dashboard') ? 'bg-purple-500/30 text-purple-300' : 'text-gray-400' }}">
                    <i class="fas fa-tachometer-alt"></i>
                </span>
                <span class="text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-gray-300' }}">Dashboard</span>
            </a>
            
            <div class="nav-label">Konten</div>

            <a href="{{ route('admin.materi.index') }}" class="menu-item flex items-center gap-3.5 px-4 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.materi.*') ? 'active' : '' }}">
                <span class="menu-icon w-8 h-8 rounded-lg flex items-center justify-center text-sm {{ request()->routeIs('admin.materi.*') ? 'bg-purple-500/30 text-purple-300' : 'text-gray-400' }}">
                    <i class="fas fa-book"></i>
                </span>
                <span class="text-sm font-medium {{ request()->routeIs('admin.materi.*') ? 'text-white' : 'text-gray-300' }}">Materi</span>
            </a>
            
            <a href="{{ route('admin.soal.index') }}" class="menu-item flex items-center gap-3.5 px-4 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.soal.*') ? 'active' : '' }}">
                <span class="menu-icon w-8 h-8 rounded-lg flex items-center justify-center text-sm {{ request()->routeIs('admin.soal.*') ? 'bg-purple-500/30 text-purple-300' : 'text-gray-400' }}">
                    <i class="fas fa-question-circle"></i>
                </span>
                <span class="text-sm font-medium {{ request()->routeIs('admin.soal.*') ? 'text-white' : 'text-gray-300' }}">Soal</span>
            </a>
            
            <a href="{{ route('admin.packages.index') }}" class="menu-item flex items-center gap-3.5 px-4 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.packages.*') ? 'active' : '' }}">
                <span class="menu-icon w-8 h-8 rounded-lg flex items-center justify-center text-sm {{ request()->routeIs('admin.packages.*') ? 'bg-purple-500/30 text-purple-300' : 'text-gray-400' }}">
                    <i class="fas fa-box"></i>
                </span>
                <span class="text-sm font-medium {{ request()->routeIs('admin.packages.*') ? 'text-white' : 'text-gray-300' }}">Paket Soal</span>
            </a>
            
            <a href="{{ route('admin.tryouts.index') }}" class="menu-item flex items-center gap-3.5 px-4 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.tryouts.*') ? 'active' : '' }}">
                <span class="menu-icon w-8 h-8 rounded-lg flex items-center justify-center text-sm {{ request()->routeIs('admin.tryouts.*') ? 'bg-purple-500/30 text-purple-300' : 'text-gray-400' }}">
                    <i class="fas fa-trophy"></i>
                </span>
                <span class="text-sm font-medium {{ request()->routeIs('admin.tryouts.*') ? 'text-white' : 'text-gray-300' }}">Try Out 110</span>
            </a>
            
            <div class="nav-label">Lainnya</div>

            @php 
                $unreadCount = App\Models\Feedback::where('status', 'unread')->count(); 
            @endphp
            <a href="{{ route('admin.feedback.index') }}" class="menu-item flex items-center gap-3.5 px-4 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.feedback.*') ? 'active' : '' }}">
                <span class="menu-icon w-8 h-8 rounded-lg flex items-center justify-center text-sm {{ request()->routeIs('admin.feedback.*') ? 'bg-purple-500/30 text-purple-300' : 'text-gray-400' }}">
                    <i class="fas fa-comment-dots"></i>
                </span>
                <span class="text-sm font-medium {{ request()->routeIs('admin.feedback.*') ? 'text-white' : 'text-gray-300' }}">Saran & Masukan</span>
                @if($unreadCount > 0)
                <span class="bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full ml-auto min-w-[20px] text-center">{{ $unreadCount }}</span>
                @endif
            </a>

            <a href="{{ route('admin.backup.index') }}" class="menu-item flex items-center gap-3.5 px-4 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.backup.*') ? 'active' : '' }}">
                <span class="menu-icon w-8 h-8 rounded-lg flex items-center justify-center text-sm {{ request()->routeIs('admin.backup.*') ? 'bg-purple-500/30 text-purple-300' : 'text-gray-400' }}">
                    <i class="fas fa-database"></i>
                </span>
                <span class="text-sm font-medium {{ request()->routeIs('admin.backup.*') ? 'text-white' : 'text-gray-300' }}">Backup</span>
            </a>
            
            <div class="mt-6 pt-4 border-t border-gray-700/50">
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="menu-item w-full flex items-center gap-3.5 px-4 py-2.5 rounded-xl hover:bg-red-500/20 transition-all text-left">
                        <span class="w-8 h-8 rounded-lg flex items-center justify-center text-sm text-red-400">
                            <i class="fas fa-sign-out-alt"></i>
                        </span>
                        <span class="text-sm font-medium text-red-300">Logout</span>
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
