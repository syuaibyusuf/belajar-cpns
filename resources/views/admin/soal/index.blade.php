@extends('layouts.admin')

@section('title', 'Manajemen Soal')
@section('header', '❓ Manajemen Soal')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Manajemen Soal</h1>
    <div class="flex gap-3">
        <a href="{{ route('admin.soal.template') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
            <i class="fas fa-download mr-2"></i>Template
        </a>
        <a href="{{ route('admin.soal.export') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
            <i class="fas fa-file-export mr-2"></i>Export
        </a>
        <a href="{{ route('admin.soal.create') }}" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
            <i class="fas fa-plus mr-2"></i>Tambah Soal
        </a>
    </div>
</div>

<!-- Filter -->
<div class="bg-white rounded-xl shadow-sm p-4 mb-6">
    <form method="GET" class="flex flex-wrap gap-4">
        <select name="category" class="px-4 py-2 border rounded-lg">
            <option value="all">Semua Kategori</option>
            <option value="twk" {{ request('category') == 'twk' ? 'selected' : '' }}>TWK</option>
            <option value="tiu" {{ request('category') == 'tiu' ? 'selected' : '' }}>TIU</option>
            <option value="tkp" {{ request('category') == 'tkp' ? 'selected' : '' }}>TKP</option>
        </select>
        <input type="text" name="search" placeholder="Cari soal..." value="{{ request('search') }}" class="flex-1 px-4 py-2 border rounded-lg">
        <button type="submit" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700">
            <i class="fas fa-search mr-2"></i>Cari
        </button>
        @if(request('search') || request('category') != 'all')
        <a href="{{ route('admin.soal.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg">Reset</a>
        @endif
    </form>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left">ID</th>
                <th class="px-4 py-3 text-left">Soal</th>
                <th class="px-4 py-3 text-left">Kategori</th>
                <th class="px-4 py-3 text-left">Jawaban</th>
                <th class="px-4 py-3 text-left">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($questions as $q)
            <tr class="border-t">
                <td class="px-4 py-3">{{ $q->id }}</td>
                <td class="px-4 py-3">{{ Str::limit($q->question_text, 50) }}</td>
                <td class="px-4 py-3">
                    <span class="px-2 py-1 rounded text-sm 
                        @if($q->category == 'twk') bg-red-100 text-red-600
                        @elseif($q->category == 'tiu') bg-blue-100 text-blue-600
                        @else bg-green-100 text-green-600 @endif">
                        {{ strtoupper($q->category) }}
                    </span>
                </td>
                <td class="px-4 py-3 font-bold uppercase">{{ $q->correct_answer }}</td>
                <td class="px-4 py-3 space-x-2">
                    <a href="{{ route('admin.soal.edit', $q->id) }}" class="text-blue-600 hover:text-blue-800">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('admin.soal.destroy', $q->id) }}" method="POST" class="inline">
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
    {{ $questions->links() }}
</div>
@endsection