<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\QuickPackage;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class QuickExamController extends Controller
{
    private function getSessionId()
    {
        if (!session()->has('user_session')) {
            session()->put('user_session', Str::random(40));
        }
        return session()->get('user_session');
    }

    public function index()
    {
        $packages = QuickPackage::where('status', 'active')->get();
        
        $packagesByCategory = [
            'twk' => $packages->where('category', 'twk'),
            'tiu' => $packages->where('category', 'tiu'),
            'tkp' => $packages->where('category', 'tkp'),
        ];
        
        return view('user.quick-package-list', compact('packagesByCategory'));
    }

    public function start($id)
    {
        $package = QuickPackage::with('questions')->where('status', 'active')->findOrFail($id);
        $questions = $package->questions;
        
        if ($questions->count() != $package->total_questions) {
            return redirect()->route('quick-packages.index')
                ->with('error', 'Paket soal belum lengkap (harus ' . $package->total_questions . ' soal). Silakan hubungi admin.');
        }
        
        return view('user.quick-test', compact('package', 'questions'));
    }

    public function submit(Request $request, $id)
    {
        $package = QuickPackage::with('questions')->findOrFail($id);
        $answers = $request->input('answers', []);
        $questions = $package->questions;
        
        $score = 0;
        $results = [];
        $maxScore = 0;
        
        foreach ($questions as $index => $question) {
            $userAnswer = $answers[$index] ?? null;
            
            if ($package->category == 'tkp') {
                // TKP: ambil nilai dari score_* kolom
                $scoreColumn = 'score_' . $userAnswer;
                $points = $question->$scoreColumn ?? 0;
                $maxScore += 5; // Maksimal per soal TKP adalah 5
                $score += $points;
                $isCorrect = true;
            } else {
                // TWK/TIU: 5 poin jika benar
                $isCorrect = ($userAnswer == $question->correct_answer);
                $points = $isCorrect ? ($question->points ?? 5) : 0;
                $maxScore += ($question->points ?? 5);
                $score += $points;
            }
            
            $results[] = [
                'question' => $question,
                'user_answer' => $userAnswer,
                'is_correct' => $isCorrect,
                'correct_answer' => $question->correct_answer,
                'explanation' => $question->explanation,
                'points' => $points,
                'max_points' => ($package->category == 'tkp') ? 5 : ($question->points ?? 5)
            ];
        }
        
        $percentage = ($maxScore > 0) ? ($score / $maxScore) * 100 : 0;
        
        return view('user.quick-result', compact('package', 'score', 'maxScore', 'percentage', 'results', 'questions'));
    }
}