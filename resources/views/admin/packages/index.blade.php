@extends('layouts.admin')

@section('title', 'Manajemen Paket Soal')
@section('header', '📦 Manajemen Paket Soal')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Manajemen Paket Soal</h1>
    <a href="{{ route('admin.packages.create') }}" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
        <i class="fas fa-plus mr-2"></i>Buat Paket Baru
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left">ID</th>
                <th class="px-6 py-3 text-left">Nama Paket</th>
                <th class="px-6 py-3 text-left">Kategori</th>
                <th class="px-6 py-3 text-left">Jumlah Soal</th>
                <th class="px-6 py-3 text-left">Terisi</th>
                <th class="px-6 py-3 text-left">Status</th>
                <th class="px-6 py-3 text-left">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($packages as $pkg)
            @php $filledCount = $pkg->questions()->where('question_text', '!=', '')->count(); @endphp
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
                <td class="px-6 py-4">{{ $pkg->total_questions }} soal</td>
                <td class="px-6 py-4">
                    <span class="font-bold {{ $filledCount == $pkg->total_questions ? 'text-green-600' : 'text-red-600' }}">
                        {{ $filledCount }}/{{ $pkg->total_questions }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 rounded text-sm {{ $pkg->status == 'active' ? 'bg-green-100 text-green-600' : 'bg-yellow-100 text-yellow-600' }}">
                        {{ $pkg->status == 'active' ? 'Active' : 'Draft' }}
                    </span>
                </td>
                <td class="px-6 py-4 space-x-2">
                    <a href="{{ route('admin.packages.edit-questions', $pkg->id) }}" class="text-blue-600 hover:text-blue-800" title="Edit Soal">
                        <i class="fas fa-list-check"></i>
                    </a>
                    <a href="{{ route('admin.packages.edit', $pkg->id) }}" class="text-yellow-600 hover:text-yellow-800" title="Edit Info">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('admin.packages.destroy', $pkg->id) }}" method="POST" class="inline">
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
@endsection