@extends('layouts.admin')

@section('title', 'Manajemen Try Out')
@section('header', '🎯 Manajemen Try Out (110 Soal)')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Manajemen Try Out</h1>
    <a href="{{ route('admin.tryouts.create') }}" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
        <i class="fas fa-plus mr-2"></i>Buat Try Out Baru
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left">ID</th>
                <th class="px-6 py-3 text-left">Nama Try Out</th>
                <th class="px-6 py-3 text-left">Komposisi</th>
                <th class="px-6 py-3 text-left">Durasi</th>
                <th class="px-6 py-3 text-left">Status</th>
                <th class="px-6 py-3 text-left">Soal Terisi</th>
                <th class="px-6 py-3 text-left">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tryouts as $tryout)
            @php $filledCount = $tryout->questions()->where('question_text', '!=', '')->count(); @endphp
            <tr class="border-t">
                <td class="px-6 py-4">{{ $tryout->id }}</td>
                <td class="px-6 py-4 font-medium">{{ $tryout->name }}</td>
                <td class="px-6 py-4 text-sm">🇮🇩 30 🧠 35 💼 45</td>
                <td class="px-6 py-4">{{ $tryout->duration }} menit</td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 rounded text-sm {{ $tryout->status == 'active' ? 'bg-green-100 text-green-600' : 'bg-yellow-100 text-yellow-600' }}">
                        {{ $tryout->status == 'active' ? 'Active' : 'Draft' }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <span class="font-bold {{ $filledCount == 110 ? 'text-green-600' : 'text-red-600' }}">
                        {{ $filledCount }}/110
                    </span>
                </td>
                <td class="px-6 py-4 space-x-2">
                    <a href="{{ route('admin.tryouts.edit-questions', $tryout->id) }}" class="text-blue-600 hover:text-blue-800" title="Edit Soal">
                        <i class="fas fa-list-check"></i>
                    </a>
                    <a href="{{ route('admin.tryouts.edit', $tryout->id) }}" class="text-yellow-600 hover:text-yellow-800" title="Edit Info">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('admin.tryouts.destroy', $tryout->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Yakin hapus? Semua soal akan terhapus.')" title="Hapus">
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
    {{ $tryouts->links() }}
</div>
@endsection