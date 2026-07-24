<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Question;
use App\Models\UserProgress;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Share data user ke semua view (dijalankan saat view dirender)
        View::composer('*', function ($view) {
            $sessionId = session()->get('user_session');
            if (!$sessionId) {
                return;
            }

            $totalSoal = Question::count();

            $progress = UserProgress::where('session_id', $sessionId)->get();
            $totalDikerjakan = $progress->sum('total_questions');

            $statistik = [];
            $questionCounts = Question::selectRaw('category, count(*) as total')
                ->groupBy('category')
                ->pluck('total', 'category');

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

            $view->with([
                'totalSoal' => $totalSoal,
                'totalDikerjakan' => $totalDikerjakan,
                'statistik' => $statistik,
            ]);
        });
    }
}