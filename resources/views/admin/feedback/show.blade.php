@extends('layouts.admin')

@section('title', 'Detail Saran')
@section('header', '💬 Detail Saran & Masukan')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.feedback.index') }}" class="text-purple-600 hover:underline">← Kembali</a>
    </div>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="bg-gradient-to-r from-purple-600 to-indigo-600 px-6 py-5 text-white">
            <div class="flex justify-between items-start">
                <div>
                    <h2 class="text-xl font-bold">Saran dari {{ $feedback->name }}</h2>
                    <p class="text-sm opacity-90 mt-1">
                        <i class="far fa-calendar-alt mr-1"></i> {{ $feedback->created_at->translatedFormat('l, d F Y H:i') }}
                    </p>
                </div>
                @php $badge = $feedback->getStatusBadge(); @endphp
                <span class="px-3 py-1 rounded-full text-sm bg-white/20">
                    {{ $badge['label'] }}
                </span>
            </div>
        </div>
        
        <div class="p-6">
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-medium mb-2">Pengirim</label>
                <div class="bg-gray-50 rounded-lg p-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center text-purple-600">
                            <i class="fas fa-user"></i>
                        </div>
                        <div>
                            <div class="font-medium">{{ $feedback->name }}</div>
                            <a href="mailto:{{ $feedback->email }}" class="text-sm text-purple-600">{{ $feedback->email }}</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-medium mb-2">Pesan / Saran</label>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-gray-700 whitespace-pre-wrap leading-relaxed">{{ $feedback->message }}</p>
                </div>
            </div>
            
            @if($feedback->admin_response)
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-medium mb-2">Respon Admin</label>
                <div class="bg-green-50 rounded-lg p-4 border-l-4 border-green-500">
                    <p class="text-gray-700 whitespace-pre-wrap">{{ $feedback->admin_response }}</p>
                    <p class="text-xs text-gray-400 mt-2">
                        <i class="far fa-clock mr-1"></i> Direspon pada {{ $feedback->updated_at->translatedFormat('d F Y H:i') }}
                    </p>
                </div>
            </div>
            @endif
            
            <div class="border-t pt-6 mt-4">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Beri Respon</h3>
                
                <form method="POST" action="{{ route('admin.feedback.respond', $feedback->id) }}">
                    @csrf
                    <div class="mb-4">
                        <textarea name="response" rows="5" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500" placeholder="Tulis respon Anda di sini..."></textarea>
                    </div>
                    <div class="flex gap-3">
                        <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded-lg hover:bg-green-600 transition">
                            <i class="fas fa-paper-plane mr-2"></i> Kirim Respon
                        </button>
                        <a href="{{ route('admin.feedback.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition">
                            Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection