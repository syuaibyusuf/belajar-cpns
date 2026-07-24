<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PackageController extends Controller
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
        // Ambil semua paket yang aktif, urutkan dari terbaru
        $allPackages = Package::where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->get();
        
        $packagesByCategory = [
            'twk' => Package::where('status', 'active')->where('category', 'twk')->get(),
            'tiu' => Package::where('status', 'active')->where('category', 'tiu')->get(),
            'tkp' => Package::where('status', 'active')->where('category', 'tkp')->get(),
        ];
        
        return view('user.package-list', compact('allPackages', 'packagesByCategory'));
    }

    public function start($id)
    {
        $package = Package::with('questions')->where('status', 'active')->findOrFail($id);
        $questions = $package->questions;
        
        if ($questions->count() != $package->total_questions) {
            return redirect()->route('packages.index')
                ->with('error', 'Paket soal belum lengkap. Silakan hubungi admin.');
        }
        
        return view('user.package-test', compact('package', 'questions'));
    }

    public function submit(Request $request, $id)
    {
        $package = Package::with('questions')->findOrFail($id);
        $answers = $request->input('answers', []);
        $questions = $package->questions;
        
        $score = 0;
        $results = [];
        $maxScore = 0;
        
        foreach ($questions as $index => $question) {
            $userAnswer = $answers[$index] ?? null;
            
            if ($package->category == 'tkp') {
                $scoreColumn = 'score_' . $userAnswer;
                $points = $question->$scoreColumn ?? 0;
                $maxScore += 5;
                $score += $points;
                $isCorrect = true;
            } else {
                $isCorrect = ($userAnswer == $question->correct_answer);
                $points = $isCorrect ? 5 : 0;
                $maxScore += 5;
                $score += $points;
            }
            
            $results[] = [
                'question' => $question,
                'user_answer' => $userAnswer,
                'is_correct' => $isCorrect,
                'correct_answer' => $question->correct_answer,
                'explanation' => $question->explanation,
                'points' => $points,
                'max_points' => 5
            ];
        }
        
        $percentage = ($maxScore > 0) ? ($score / $maxScore) * 100 : 0;
        
        return view('user.package-result', compact('package', 'score', 'maxScore', 'percentage', 'results', 'questions'));
    }
}