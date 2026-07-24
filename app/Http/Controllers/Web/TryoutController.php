<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Tryout;
use App\Models\TryoutQuestion;
use App\Models\UserProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TryoutController extends Controller
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
        $tryouts = Tryout::where('status', 'active')->latest()->get();
        return view('user.tryout-list', compact('tryouts'));
    }

    public function start($id)
    {
        $tryout = Tryout::with('questions')->where('status', 'active')->findOrFail($id);
        $questions = $tryout->questions;
        
        if ($questions->count() != $tryout->total_questions) {
            return redirect()->route('tryouts.index')
                ->with('error', 'Try Out belum lengkap (harus ' . $tryout->total_questions . ' soal). Silakan hubungi admin.');
        }
        
        return view('user.tryout-test', compact('tryout', 'questions'));
    }

    public function submit(Request $request, $id)
    {
        $tryout = Tryout::with('questions')->findOrFail($id);
        $answers = $request->input('answers', []);
        $questions = $tryout->questions;
        
        $score = 0;
        $results = [];
        $maxScore = 0;
        
        // Hitung skor per kategori
        $twkScore = 0;
        $tiuScore = 0;
        $tkpScore = 0;
        $twkMax = 0;
        $tiuMax = 0;
        $tkpMax = 0;
        $twkCorrect = 0;
        $tiuCorrect = 0;
        $twkTotal = 0;
        $tiuTotal = 0;
        $tkpTotal = 0;
        
        foreach ($questions as $index => $question) {
            $userAnswer = $answers[$index] ?? null;
            $isCorrect = false;
            $points = 0;
            
            if ($question->category == 'tkp') {
                // TKP: ambil nilai dari score_* kolom
                $scoreColumn = 'score_' . $userAnswer;
                $points = $question->$scoreColumn ?? 0;
                $maxScore += 5;
                $score += $points;
                $tkpScore += $points;
                $tkpMax += 5;
                $tkpTotal++;
                $isCorrect = true;
            } else {
                // TWK/TIU: 5 poin jika benar
                $isCorrect = ($userAnswer == $question->correct_answer);
                $points = $isCorrect ? 5 : 0;
                $maxScore += 5;
                $score += $points;
                
                if ($question->category == 'twk') {
                    $twkScore += $points;
                    $twkMax += 5;
                    $twkTotal++;
                    if ($isCorrect) $twkCorrect++;
                } else {
                    $tiuScore += $points;
                    $tiuMax += 5;
                    $tiuTotal++;
                    if ($isCorrect) $tiuCorrect++;
                }
            }
            
            $results[] = [
                'question' => $question,
                'user_answer' => $userAnswer,
                'is_correct' => $isCorrect,
                'correct_answer' => $question->correct_answer,
                'explanation' => $question->explanation,
                'points' => $points,
                'max_points' => 5,
                'category' => $question->category
            ];
        }
        
        $percentage = ($maxScore > 0) ? ($score / $maxScore) * 100 : 0;
        
        // Hitung persentase per kategori
        $twkPercent = $twkMax > 0 ? ($twkScore / $twkMax) * 100 : 0;
        $tiuPercent = $tiuMax > 0 ? ($tiuScore / $tiuMax) * 100 : 0;
        $tkpPercent = $tkpMax > 0 ? ($tkpScore / $tkpMax) * 100 : 0;
        
        // Tentukan status per kategori
        $twkStatus = $twkPercent >= 80 ? 'Sangat Baik' : ($twkPercent >= 60 ? 'Cukup' : 'Perlu Belajar');
        $tiuStatus = $tiuPercent >= 80 ? 'Sangat Baik' : ($tiuPercent >= 60 ? 'Cukup' : 'Perlu Belajar');
        $tkpStatus = $tkpPercent >= 80 ? 'Sangat Baik' : ($tkpPercent >= 60 ? 'Cukup' : 'Perlu Belajar');
        
        $twkColor = $twkPercent >= 80 ? 'text-green-600' : ($twkPercent >= 60 ? 'text-yellow-600' : 'text-red-600');
        $tiuColor = $tiuPercent >= 80 ? 'text-green-600' : ($tiuPercent >= 60 ? 'text-yellow-600' : 'text-red-600');
        $tkpColor = $tkpPercent >= 80 ? 'text-green-600' : ($tkpPercent >= 60 ? 'text-yellow-600' : 'text-red-600');
        
        // Simpan progress
        $sessionId = $this->getSessionId();
        UserProgress::updateOrCreate(
            [
                'session_id' => $sessionId,
                'category' => 'tryout_' . $tryout->id
            ],
            [
                'score' => $percentage,
                'total_questions' => $tryout->total_questions,
                'answers' => $answers
            ]
        );
        
        $results = collect($results);
        
        return view('user.tryout-result', compact(
            'tryout', 'score', 'maxScore', 'percentage', 'results', 'questions',
            'twkScore', 'twkMax', 'twkPercent', 'twkStatus', 'twkColor', 'twkCorrect', 'twkTotal',
            'tiuScore', 'tiuMax', 'tiuPercent', 'tiuStatus', 'tiuColor', 'tiuCorrect', 'tiuTotal',
            'tkpScore', 'tkpMax', 'tkpPercent', 'tkpStatus', 'tkpColor', 'tkpTotal'
        ));
    }
}