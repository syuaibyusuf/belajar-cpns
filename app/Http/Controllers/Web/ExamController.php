<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\UserProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ExamController extends Controller
{
    private function getSessionId()
    {
        if (!session()->has('user_session')) {
            session()->put('user_session', Str::random(40));
        }
        return session()->get('user_session');
    }

    public function test(Request $request, $category)
    {
        $limit = $request->get('limit', 10);
        
        $questions = Question::where('category', $category)
            ->inRandomOrder()
            ->limit($limit)
            ->get();
        
        if ($questions->isEmpty()) {
            return redirect()->route('latihan')->with('error', 'Belum ada soal untuk kategori ini.');
        }
        
        $totalQuestions = $questions->count();
        
        return view('user.test', compact('questions', 'totalQuestions', 'category'));
    }

    public function submit(Request $request, $category)
    {
        $sessionId = $this->getSessionId();
        $answers = $request->input('answers', []);
        $questions = Question::where('category', $category)->get();
        
        if ($questions->isEmpty()) {
            return redirect()->route('latihan')->with('error', 'Soal tidak ditemukan.');
        }
        
        $score = 0;
        $maxScore = 0;
        $results = [];
        
        foreach ($questions as $index => $question) {
            $userAnswer = $answers[$index] ?? null;
            
            if ($category == 'tkp') {
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
                'max_points' => ($category == 'tkp') ? 5 : ($question->points ?? 5)
            ];
        }
        
        $percentage = ($maxScore > 0) ? ($score / $maxScore) * 100 : 0;
        
        // Simpan progress
        UserProgress::updateOrCreate(
            [
                'session_id' => $sessionId,
                'category' => $category
            ],
            [
                'score' => $percentage,
                'total_questions' => count($questions),
                'answers' => $answers
            ]
        );
        
        $results = collect($results);
        
        return view('user.result', compact('score', 'maxScore', 'percentage', 'results', 'category'));
    }
}