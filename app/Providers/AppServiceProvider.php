<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use App\Models\Question;
use App\Models\UserProgress;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Share data ke semua view yang menggunakan layout user
        $this->shareUserDataToLayout('layouts.user');
        $this->shareUserDataToLayout('layouts.user-app');
    }

    private function shareUserDataToLayout(string $layout): void
    {
        View::composer($layout, function ($view) {
            $data = $this->getUserSharedData();
            $view->with($data);
        });
    }

    private function getUserSharedData(): array
    {
        // Get or create session ID
        $sessionId = session()->get('user_session');
        if (!$sessionId) {
            $sessionId = Str::random(40);
            session()->put('user_session', $sessionId);
        }

        // Gunakan cache untuk data yang jarang berubah
        $totalSoal = cache()->remember('total_soal_count', 3600, function () {
            return Question::count();
        });

        $progress = UserProgress::where('session_id', $sessionId)->get();
        $totalDikerjakan = $progress->sum('total_questions');

        $statistik = [];
        $questionCounts = cache()->remember('question_counts_by_category', 3600, function () {
            return Question::selectRaw('category, count(*) as total')
                ->groupBy('category')
                ->pluck('total', 'category');
        });

        foreach (['twk', 'tiu', 'tkp'] as $cat) {
            $total = $questionCounts[$cat] ?? 0;
            $userProgress = $progress->where('category', $cat)->first();
            $statistik[$cat] = [
                'total' => $total,
                'dikerjakan' => $userProgress->total_questions ?? 0,
                'nilai' => round($userProgress->score ?? 0, 1),
                'persentase' => $total > 0 ? round((($userProgress->total_questions ?? 0) / $total) * 100) : 0
            ];
        }

        return [
            'totalSoal' => $totalSoal,
            'totalDikerjakan' => $totalDikerjakan,
            'statistik' => $statistik,
        ];
    }
}