@extends('layouts.admin')

@section('title', 'Manajemen Saran & Masukan')
@section('header', '💬 Manajemen Saran & Masukan')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Manajemen Saran & Masukan</h1>
    <span class="bg-yellow-100 text-yellow-600 px-3 py-1 rounded-full">
        📬 Belum dibaca: {{ $unreadCount }}
    </span>
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
                <th class="px-6 py-3 text-left">Nama</th>
                <th class="px-6 py-3 text-left">Email</th>
                <th class="px-6 py-3 text-left">Pesan</th>
                <th class="px-6 py-3 text-left">Status</th>
                <th class="px-6 py-3 text-left">Tanggal</th>
                <th class="px-6 py-3 text-left">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($feedbacks as $fb)
            <tr class="border-t hover:bg-gray-50">
                <td class="px-6 py-4">{{ $fb->id }}</td>
                <td class="px-6 py-4 font-medium">{{ $fb->name }}</td>
                <td class="px-6 py-4">{{ $fb->email }}</td>
                <td class="px-6 py-4 max-w-md">
                    <div class="truncate">{{ Str::limit($fb->message, 50) }}</div>
                </td>
                <td class="px-6 py-4">
                    @php $badge = $fb->getStatusBadge(); @endphp
                    <span class="px-2 py-1 rounded text-xs {{ $badge['class'] }}">
                        {{ $badge['label'] }}
                    </span>
                </td>
                <td class="px-6 py-4">{{ $fb->created_at->format('d/m/Y H:i') }}</td>
                <td class="px-6 py-4 space-x-2">
                    <a href="{{ route('admin.feedback.show', $fb->id) }}" class="text-blue-600 hover:text-blue-800">
                        <i class="fas fa-eye"></i>
                    </a>
                    <form action="{{ route('admin.feedback.destroy', $fb->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Yakin hapus?')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-6 py-8 text-center text-gray-400">
                    Belum ada saran atau masukan.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $feedbacks->links() }}
</div>
@endsection