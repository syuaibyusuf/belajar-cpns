<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Paket Cepat - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">

<div class="flex min-h-screen">
    <aside class="w-64 bg-gradient-to-br from-gray-900 to-gray-800 text-white fixed h-full">
        <div class="p-6 border-b border-gray-700">
            <div class="text-xl font-bold">🛡️ Admin Panel</div>
        </div>
        <nav class="p-4 space-y-2">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-700 transition">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
            <a href="{{ route('admin.materi.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-700 transition">
                <i class="fas fa-book"></i> Manajemen Materi
            </a>
            <a href="{{ route('admin.soal.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-700 transition">
                <i class="fas fa-question-circle"></i> Manajemen Soal
            </a>
            <a href="{{ route('admin.packages.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-700 transition">
                <i class="fas fa-box"></i> Paket Lengkap (50)
            </a>
            <a href="{{ route('admin.quick-packages.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-purple-700">
                <i class="fas fa-bolt"></i> Paket Cepat (10-20)
            </a>
            <form method="POST" action="{{ route('admin.logout') }}" class="mt-8">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-red-600 transition">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </nav>
    </aside>

    <main class="flex-1 ml-64 p-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl font-bold">⚡ Manajemen Paket Cepat (10-20 Soal)</h1>
            <a href="{{ route('admin.quick-packages.create') }}" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
                <i class="fas fa-plus mr-2"></i>Buat Paket Cepat
            </a>
        </div>

        @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left">ID</th>
                        <th class="px-6 py-3 text-left">Nama Paket</th>
                        <th class="px-6 py-3 text-left">Kategori</th>
                        <th class="px-6 py-3 text-left">Jumlah Soal</th>
                        <th class="px-6 py-3 text-left">Status</th>
                        <th class="px-6 py-3 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($packages as $pkg)
                    <tr class="border-t">
                        <td class="px-6 py-4">{{ $pkg->id }}</td>
                        <td class="px-6 py-4 font-medium">{{ $pkg->name }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded text-sm 
                                @if($pkg->category == 'twk') bg-red-100 text-red-600
                                @elseif($pkg->category == 'tiu') bg-blue-100 text-blue-600
                                @else bg-green-100 text-green-600 @endif">
                                {{ strtoupper($pkg->category) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-bold {{ $pkg->questions->count() == $pkg->total_questions ? 'text-green-600' : 'text-red-600' }}">
                                {{ $pkg->questions->count() }}/{{ $pkg->total_questions }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded text-sm {{ $pkg->status == 'active' ? 'bg-green-100 text-green-600' : 'bg-gray-100 text-gray-500' }}">
                                {{ $pkg->status == 'active' ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 space-x-2">
                            <a href="{{ route('admin.quick-packages.select-questions', $pkg->id) }}" class="text-blue-600 hover:text-blue-800" title="Pilih Soal">
                                <i class="fas fa-list-check"></i>
                            </a>
                            <a href="{{ route('admin.quick-packages.edit', $pkg->id) }}" class="text-yellow-600 hover:text-yellow-800" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.quick-packages.destroy', $pkg->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Yakin hapus?')" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="mt-6">
            {{ $packages->links() }}
        </div>
    </main>
</div>

</body>
</html>