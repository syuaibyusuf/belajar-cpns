<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Materi;
use App\Models\Question;
use App\Models\UserProgress;
use App\Models\Package;
use App\Models\PackageQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Statistik dasar
        $totalMateri = Materi::count();
        $totalSoal = Question::count();
        $totalPackages = Package::count();
        $totalUserSessions = UserProgress::distinct('session_id')->count('session_id');
        $totalTestDiikuti = UserProgress::count();
        
        // Data untuk grafik aktivitas user (7 hari terakhir)
        $activityData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $count = UserProgress::whereDate('created_at', $date)->count();
            $activityData['labels'][] = now()->subDays($i)->format('D');
            $activityData['values'][] = $count;
        }
        
        // Top 5 soal paling sering salah (dari user_progress)
        // Ambil semua jawaban user dari user_progress
        $allAnswers = UserProgress::whereNotNull('answers')->get();
        $wrongCounts = [];
        
        foreach ($allAnswers as $progress) {
            $answers = is_array($progress->answers) ? $progress->answers : json_decode($progress->answers, true);
            if (is_array($answers)) {
                foreach ($answers as $questionId => $userAnswer) {
                    // Cari soal berdasarkan ID (untuk paket soal)
                    $question = PackageQuestion::find($questionId);
                    if ($question && $userAnswer != $question->correct_answer && $question->correct_answer) {
                        $key = $questionId;
                        if (!isset($wrongCounts[$key])) {
                            $wrongCounts[$key] = [
                                'text' => $question->question_text,
                                'category' => $question->package->category ?? 'unknown',
                                'count' => 0
                            ];
                        }
                        $wrongCounts[$key]['count']++;
                    }
                }
            }
        }
        
        // Urutkan berdasarkan jumlah kesalahan terbanyak
        arsort($wrongCounts);
        $topWrongQuestions = array_slice($wrongCounts, 0, 5);
        
        // Statistik per kategori dari soal yang ada di database
        $statsByCategory = [
            'twk' => Question::where('category', 'twk')->count(),
            'tiu' => Question::where('category', 'tiu')->count(),
            'tkp' => Question::where('category', 'tkp')->count(),
        ];
        
        // Rata-rata nilai user per kategori
        $avgScores = [
            'twk' => round(UserProgress::where('category', 'twk')->avg('score') ?? 0, 1),
            'tiu' => round(UserProgress::where('category', 'tiu')->avg('score') ?? 0, 1),
            'tkp' => round(UserProgress::where('category', 'tkp')->avg('score') ?? 0, 1),
        ];
        
        // Materi, soal, dan paket terbaru
        $latestMaterials = Materi::latest()->take(5)->get();
        $latestQuestions = Question::latest()->take(5)->get();
        $latestPackages = Package::with('creator')->latest()->take(5)->get();
        
        return view('admin.dashboard', compact(
            'totalMateri', 'totalSoal', 'totalPackages', 'totalUserSessions', 'totalTestDiikuti',
            'activityData', 'topWrongQuestions', 'statsByCategory', 'avgScores',
            'latestMaterials', 'latestQuestions', 'latestPackages'
        ));
    }
    
    public function statistik()
    {
        $stats = [
            'twk' => Question::where('category', 'twk')->count(),
            'tiu' => Question::where('category', 'tiu')->count(),
            'tkp' => Question::where('category', 'tkp')->count(),
        ];
        
        $userStats = [
            'twk' => UserProgress::where('category', 'twk')->avg('score') ?? 0,
            'tiu' => UserProgress::where('category', 'tiu')->avg('score') ?? 0,
            'tkp' => UserProgress::where('category', 'tkp')->avg('score') ?? 0,
        ];
        
        // Data untuk grafik progress user per minggu
        $weeklyProgress = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $twkCount = UserProgress::whereDate('created_at', $date)->where('category', 'twk')->count();
            $tiuCount = UserProgress::whereDate('created_at', $date)->where('category', 'tiu')->count();
            $tkpCount = UserProgress::whereDate('created_at', $date)->where('category', 'tkp')->count();
            $weeklyProgress['labels'][] = now()->subDays($i)->format('D');
            $weeklyProgress['twk'][] = $twkCount;
            $weeklyProgress['tiu'][] = $tiuCount;
            $weeklyProgress['tkp'][] = $tkpCount;
        }
        
        return view('admin.statistik', compact('stats', 'userStats', 'weeklyProgress'));
    }
}
