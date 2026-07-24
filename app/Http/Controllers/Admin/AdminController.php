<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Materi;
use App\Models\Question;
use App\Models\UserProgress;

class AdminController extends Controller
{
    public function index()
    {
        $totalMateri = Materi::count();
        $totalSoal = Question::count();
        $totalUserSessions = UserProgress::distinct('session_id')->count('session_id');
        $totalTestDiikuti = UserProgress::count();
        
        $latestQuestions = Question::latest()->take(5)->get();
        $latestMaterials = Materi::latest()->take(5)->get();
        
        return view('admin.dashboard', compact(
            'totalMateri', 'totalSoal', 'totalUserSessions', 
            'totalTestDiikuti', 'latestQuestions', 'latestMaterials'
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
        
        return view('admin.statistik', compact('stats', 'userStats'));
    }
}