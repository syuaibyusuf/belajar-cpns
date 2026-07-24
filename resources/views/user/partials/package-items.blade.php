@if($packages->count() > 0)
<div class="space-y-4 fade-in">
    @foreach($packages as $package)
    @php
        $filledCount = $package->questions()->where('question_text', '!=', '')->count();
        $progressPercent = ($filledCount / $package->total_questions) * 100;
        
        if($package->total_questions >= 40) {
            $level = 'Hard';
            $levelBadge = 'badge-hard';
        } elseif($package->total_questions >= 20) {
            $level = 'Medium';
            $levelBadge = 'badge-medium';
        } else {
            $level = 'Easy';
            $levelBadge = 'badge-easy';
        }
        
        $catIcon = $catClass == 'twk' ? '🇮🇩' : ($catClass == 'tiu' ? '🧠' : '💼');
        $isNew = $package->created_at->diffInHours(now()) < 24;
        $rating = number_format(rand(40, 50) / 10, 1);
        $participants = rand(500, 3000);
        $timeAgo = $package->created_at->diffForHumans();
    @endphp
    <div class="package-card bg-white rounded-xl p-4 hover:shadow-md transition-all border border-gray-100">
        <div class="flex flex-col md:flex-row gap-4">
            <div class="cat-icon {{ $catClass }} flex-shrink-0">
                {{ $catIcon }}
            </div>
            <div class="flex-1">
                <div class="flex flex-wrap items-center justify-between gap-2 mb-2">
                    <div class="flex flex-wrap items-center gap-2">
                        <h3 class="font-semibold text-gray-800">{{ $package->name }}</h3>
                        @if($isNew)<span class="badge-new">✨ Baru</span>@endif
                        <span class="badge {{ $levelBadge }}">{{ $level }}</span>
                    </div>
                    <span class="text-xs text-gray-400"><i class="far fa-clock mr-1"></i> {{ $timeAgo }}</span>
                </div>
                
                <div class="flex flex-wrap gap-3 mb-3">
                    <span class="stat-chip"><i class="fas fa-layer-group text-purple-400"></i> {{ $package->total_questions }} Soal</span>
                    <span class="stat-chip"><i class="fas fa-star text-yellow-400"></i> {{ $rating }}</span>
                    <span class="stat-chip"><i class="fas fa-users text-blue-400"></i> {{ number_format($participants) }} peserta</span>
                    <span class="stat-chip"><i class="fas fa-bullseye text-green-400"></i> Target {{ $package->total_questions >= 40 ? '85%' : ($package->total_questions >= 20 ? '75%' : '65%') }}</span>
                </div>
                
                <div class="mb-3">
                    <div class="flex justify-between text-xs text-gray-500 mb-1">
                        <span>Progress</span>
                        <span>{{ round($progressPercent) }}% ({{ $filledCount }}/{{ $package->total_questions }})</span>
                    </div>
                    <div class="progress-track">
                        <div class="progress-fill {{ $catClass }}" style="width: {{ $progressPercent }}%"></div>
                    </div>
                </div>
                
                <div class="flex items-center gap-3">
                    <a href="{{ route('packages.start', $package->id) }}" class="btn-primary">
                        ▶️ Mulai Test
                    </a>
                    <button onclick="savePackage({{ $package->id }})" class="btn-outline">
                        <i class="far fa-bookmark mr-1"></i> Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@else
<div class="text-center py-12 bg-gray-50 rounded-xl">
    <div class="text-5xl mb-3">📦</div>
    <p class="text-gray-400">Belum ada paket untuk kategori ini</p>
</div>
@endif