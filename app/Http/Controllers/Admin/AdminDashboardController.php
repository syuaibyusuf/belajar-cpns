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
use Illuminate\Support\Facades\Cache;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Statistik dasar - cache untuk 5 menit
        $stats = Cache::remember('admin_dashboard_stats', 300, function () {
            return [
                'totalMateri' => Materi::count(),
                'totalSoal' => Question::count(),
                'totalPackages' => Package::count(),
                'totalUserSessions' => UserProgress::distinct('session_id')->count('session_id'),
                'totalTestDiikuti' => UserProgress::count(),
            ];
        });
        $totalMateri = $stats['totalMateri'];
        $totalSoal = $stats['totalSoal'];
        $totalPackages = $stats['totalPackages'];
        $totalUserSessions = $stats['totalUserSessions'];
        $totalTestDiikuti = $stats['totalTestDiikuti'];
        
        // Data untuk grafik aktivitas user (7 hari terakhir)
        $activityData = Cache::remember('admin_activity_data', 300, function () {
            $data = ['labels' => [], 'values' => []];
            for ($i = 6; $i >= 0; $i--) {
                $date = now()->subDays($i)->format('Y-m-d');
                $count = UserProgress::whereDate('created_at', $date)->count();
                $data['labels'][] = now()->subDays($i)->format('D');
                $data['values'][] = $count;
            }
            return $data;
        });
        
        // Top 5 soal paling sering salah (dari user_progress)
        // Ambil semua jawaban user dari user_progress
        $topWrongQuestions = Cache::remember('admin_wrong_questions', 300, function () {
            $allAnswers = UserProgress::whereNotNull('answers')->get();
            $wrongCounts = [];
            $questionIds = [];

            foreach ($allAnswers as $progress) {
                $answers = is_array($progress->answers) ? $progress->answers : json_decode($progress->answers, true);
                if (is_array($answers)) {
                    foreach ($answers as $questionId => $userAnswer) {
                        $questionIds[$questionId] = $questionId;
                    }
                }
            }

            if (!empty($questionIds)) {
                $questions = PackageQuestion::whereIn('id', $questionIds)->with('package:id,category')->get()->keyBy('id');

                foreach ($allAnswers as $progress) {
                    $answers = is_array($progress->answers) ? $progress->answers : json_decode($progress->answers, true);
                    if (is_array($answers)) {
                        foreach ($answers as $questionId => $userAnswer) {
                            $question = $questions->get($questionId);
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
            }

            arsort($wrongCounts);
            return array_slice($wrongCounts, 0, 5);
        });
        
        // Statistik per kategori dari soal yang ada di database
        $statsByCategory = Cache::remember('question_category_counts', 3600, function () {
            return [
                'twk' => Question::where('category', 'twk')->count(),
                'tiu' => Question::where('category', 'tiu')->count(),
                'tkp' => Question::where('category', 'tkp')->count(),
            ];
        });
        
        // Rata-rata nilai user per kategori
        $avgScores = Cache::remember('avg_scores_by_category', 300, function () {
            return [
                'twk' => round(UserProgress::where('category', 'twk')->avg('score') ?? 0, 1),
                'tiu' => round(UserProgress::where('category', 'tiu')->avg('score') ?? 0, 1),
                'tkp' => round(UserProgress::where('category', 'tkp')->avg('score') ?? 0, 1),
            ];
        });
        
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
        $stats = Cache::remember('question_category_counts', 3600, function () {
            return [
                'twk' => Question::where('category', 'twk')->count(),
                'tiu' => Question::where('category', 'tiu')->count(),
                'tkp' => Question::where('category', 'tkp')->count(),
            ];
        });
        
        $userStats = Cache::remember('avg_scores_by_category', 300, function () {
            return [
                'twk' => UserProgress::where('category', 'twk')->avg('score') ?? 0,
                'tiu' => UserProgress::where('category', 'tiu')->avg('score') ?? 0,
                'tkp' => UserProgress::where('category', 'tkp')->avg('score') ?? 0,
            ];
        });
        
        // Data untuk grafik progress user per minggu
        $weeklyProgress = Cache::remember('weekly_progress_data', 300, function () {
            $data = [];
            for ($i = 6; $i >= 0; $i--) {
                $date = now()->subDays($i)->format('Y-m-d');
                $twkCount = UserProgress::whereDate('created_at', $date)->where('category', 'twk')->count();
                $tiuCount = UserProgress::whereDate('created_at', $date)->where('category', 'tiu')->count();
                $tkpCount = UserProgress::whereDate('created_at', $date)->where('category', 'tkp')->count();
                $data['labels'][] = now()->subDays($i)->format('D');
                $data['twk'][] = $twkCount;
                $data['tiu'][] = $tiuCount;
                $data['tkp'][] = $tkpCount;
            }
            return $data;
        });
        
        return view('admin.statistik', compact('stats', 'userStats', 'weeklyProgress'));
    }
}
