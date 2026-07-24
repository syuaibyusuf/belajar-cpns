@extends('layouts.user')

@section('title', 'Saran & Masukan')
@section('page-title', 'Saran & Masukan')
@section('breadcrumb')
    <a href="{{ route('home') }}" class="text-purple-600">Home</a> / Saran & Masukan
@endsection

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm p-8">
        <div class="text-center mb-8">
            <div class="text-5xl mb-3">💬</div>
            <h1 class="text-2xl font-bold text-gray-800">Saran & Masukan</h1>
            <p class="text-gray-500 mt-2">Kritik dan saran Anda sangat berharga untuk kemajuan aplikasi</p>
        </div>

        @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
        @endif

        @if($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded mb-6">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
        @endif

        <form method="POST" action="{{ route('feedback.store') }}">
            @csrf
            <div class="mb-5">
                <label class="block text-gray-700 font-medium mb-2">Nama Lengkap</label>
                <input type="text" name="name" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500" placeholder="Masukkan nama Anda" required>
            </div>
            <div class="mb-5">
                <label class="block text-gray-700 font-medium mb-2">Email</label>
                <input type="email" name="email" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500" placeholder="email@example.com" required>
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-2">Pesan / Saran</label>
                <textarea name="message" rows="6" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500" placeholder="Tulis saran atau masukan Anda..." required></textarea>
            </div>
            <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 text-white py-3 rounded-xl font-semibold hover:shadow-lg transition-all">
                <i class="fas fa-paper-plane mr-2"></i> Kirim Saran
            </button>
        </form>
    </div>
</div>
@endsection