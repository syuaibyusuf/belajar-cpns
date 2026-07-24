@extends('layouts.admin')

@section('title', 'Manajemen Materi')
@section('header', '📚 Manajemen Materi')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Manajemen Materi</h1>
    <a href="{{ route('admin.materi.create') }}" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
        <i class="fas fa-plus mr-2"></i>Tambah Materi
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left">ID</th>
                <th class="px-6 py-3 text-left">Judul</th>
                <th class="px-6 py-3 text-left">Kategori</th>
                <th class="px-6 py-3 text-left">Status</th>
                <th class="px-6 py-3 text-left">Dibuat</th>
                <th class="px-6 py-3 text-left">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($materi as $item)
            <tr class="border-t">
                <td class="px-6 py-4">{{ $item->id }}</td>
                <td class="px-6 py-4">{{ $item->title }}</td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 rounded text-sm 
                        @if($item->category == 'twk') bg-red-100 text-red-600
                        @elseif($item->category == 'tiu') bg-blue-100 text-blue-600
                        @else bg-green-100 text-green-600 @endif">
                        {{ strtoupper($item->category) }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 rounded text-sm {{ $item->status == 'published' ? 'bg-green-100 text-green-600' : 'bg-gray-100 text-gray-500' }}">
                        {{ $item->status }}
                    </span>
                </td>
                <td class="px-6 py-4">{{ $item->created_at->format('d/m/Y') }}</td>
                <td class="px-6 py-4 space-x-2">
                    <a href="{{ route('admin.materi.edit', $item->id) }}" class="text-blue-600 hover:text-blue-800">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('admin.materi.destroy', $item->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Yakin hapus?')">
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
    {{ $materi->links() }}
</div>
@endsection