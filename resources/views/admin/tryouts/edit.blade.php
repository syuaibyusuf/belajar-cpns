@extends('layouts.admin')

@section('title', 'Edit Try Out - Admin')
@section('header', '✏️ Edit Try Out')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.tryouts.index') }}" class="text-purple-600 hover:underline">← Kembali</a>
</div>

<div class="bg-white rounded-xl shadow-sm p-6 max-w-2xl">
    <h1 class="text-2xl font-bold mb-6">✏️ Edit Try Out: {{ $tryout->name }}</h1>

    <form method="POST" action="{{ route('admin.tryouts.update', $tryout->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Nama Try Out *</label>
            <input type="text" name="name" value="{{ $tryout->name }}" class="w-full px-4 py-2 border rounded-lg" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Deskripsi</label>
            <textarea name="description" rows="3" class="w-full px-4 py-2 border rounded-lg">{{ $tryout->description }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Durasi (menit)</label>
            <input type="number" name="duration" value="{{ $tryout->duration }}" min="30" max="180" class="w-32 px-4 py-2 border rounded-lg" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Status</label>
            <select name="status" class="w-48 px-4 py-2 border rounded-lg">
                <option value="draft" {{ $tryout->status == 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="active" {{ $tryout->status == 'active' ? 'selected' : '' }}>Active</option>
            </select>
        </div>

        <div class="bg-gray-50 rounded-lg p-4 mb-6">
            <div class="flex justify-between items-center">
                <div>
                    <span class="text-sm text-gray-600">Progress Soal:</span>
                    <span class="font-bold {{ $tryout->questions()->where('question_text', '!=', '')->count() == 110 ? 'text-green-600' : 'text-orange-600' }}">
                        {{ $tryout->questions()->where('question_text', '!=', '')->count() }}/110 soal terisi
                    </span>
                </div>
                <a href="{{ route('admin.tryouts.edit-questions', $tryout->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 text-sm">
                    <i class="fas fa-edit mr-1"></i>Edit Soal
                </a>
            </div>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded-lg hover:bg-green-600 transition">
                <i class="fas fa-save mr-2"></i>Update Try Out
            </button>
            <a href="{{ route('admin.tryouts.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
