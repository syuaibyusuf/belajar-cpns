<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Materi;
use App\Models\Question;
use App\Models\UserProgress;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DashboardController extends Controller
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
        $sessionId = $this->getSessionId();
        
        $materi = Materi::where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();
        
        $progress = UserProgress::where('session_id', $sessionId)->get();
        
        $recentTests = [];
        foreach (['twk', 'tiu', 'tkp'] as $cat) {
            $test = $progress->where('category', $cat)->first();
            if ($test && $test->total_questions > 0) {
                $recentTests[$cat] = [
                    'score' => round($test->score, 1),
                    'total' => $test->total_questions,
                    'date' => $test->updated_at->diffForHumans()
                ];
            }
        }
        
        return view('user.dashboard', compact('materi', 'recentTests'));
    }

    public function materiIndex(Request $request)
    {
        $filter = $request->get('filter', 'all');
        
        $allMateri = Materi::where('status', 'published')->get();
        
        $query = Materi::where('status', 'published');
        
        if ($filter == 'twk') {
            $query->where('category', 'twk');
        } elseif ($filter == 'tiu') {
            $query->where('category', 'tiu');
        } elseif ($filter == 'tkp') {
            $query->where('category', 'tkp');
        }
        
        $materi = $query->orderBy('category')->orderBy('order_number')->get();
        
        return view('user.materi-list-all', compact('materi', 'allMateri'));
    }

    public function materiByCategory($category)
    {
        $materiList = Materi::where('status', 'published')
            ->where('category', $category)
            ->orderBy('order_number', 'asc')
            ->get();
        
        $icons = ['twk' => '🇮🇩', 'tiu' => '🧠', 'tkp' => '💼'];
        $names = [
            'twk' => 'Tes Wawasan Kebangsaan',
            'tiu' => 'Tes Intelegensi Umum',
            'tkp' => 'Tes Karakteristik Pribadi'
        ];
        
        $categoryInfo = [
            'icon' => $icons[$category] ?? '📖',
            'name' => $names[$category] ?? strtoupper($category),
            'color' => $category == 'twk' ? 'red' : ($category == 'tiu' ? 'blue' : 'green')
        ];
        
        return view('user.materi-list', compact('materiList', 'category', 'categoryInfo'));
    }

    public function materiDetail($id)
    {
        $materi = Materi::where('status', 'published')->findOrFail($id);
        
        $otherMateri = Materi::where('status', 'published')
            ->where('category', $materi->category)
            ->where('id', '!=', $id)
            ->limit(3)
            ->get();
        
        return view('user.materi-detail', compact('materi', 'otherMateri'));
    }

    public function latihan()
    {
        return view('user.latihan');
    }
    
    // ==================== HALAMAN SARAN & MASUKAN ====================
    public function feedbackPage()
    {
        return view('user.feedback');
    }
    
    public function storeFeedback(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|min:5',
        ]);

        Feedback::create([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
            'status' => 'unread'
        ]);

        return redirect()->route('feedback.page')->with('success', 'Terima kasih atas saran dan masukannya!');
    }
}