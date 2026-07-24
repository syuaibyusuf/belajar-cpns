<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\UserProgress;
use Illuminate\Support\Str;

class ShareUserData
{
    public function handle(Request $request, Closure $next)
    {
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
        
        // Share ke semua view
        view()->share([
            'totalSoal' => $totalSoal,
            'totalDikerjakan' => $totalDikerjakan,
            'statistik' => $statistik,
        ]);
        
        return $next($request);
    }
}