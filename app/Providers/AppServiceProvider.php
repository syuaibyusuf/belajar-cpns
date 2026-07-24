<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
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
        View::composer('layouts.user', function ($view) {
            // Get or create session ID
            $sessionId = session()->get('user_session');
            if (!$sessionId) {
                $sessionId = Str::random(40);
                session()->put('user_session', $sessionId);
            }
            
            // Total soal
            $totalSoal = Question::count();
            
            // User progress
            $progress = UserProgress::where('session_id', $sessionId)->get();
            $totalDikerjakan = $progress->sum('total_questions');
            
            // Statistik per kategori
            $statistik = [];
            foreach (['twk', 'tiu', 'tkp'] as $cat) {
                $total = Question::where('category', $cat)->count();
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