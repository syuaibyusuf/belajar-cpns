<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tryout;
use App\Models\TryoutQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TryoutController extends Controller
{
    public function index()
    {
        $tryouts = Tryout::with('creator')->latest()->paginate(10);
        return view('admin.tryouts.index', compact('tryouts'));
    }

    public function create()
    {
        return view('admin.tryouts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'required|integer|min:30|max:180',
            'status' => 'required|in:draft,active',
        ]);

        $tryout = Tryout::create([
            'name' => $request->name,
            'description' => $request->description,
            'duration' => $request->duration,
            'total_questions_twk' => 30,
            'total_questions_tiu' => 35,
            'total_questions_tkp' => 45,
            'total_questions' => 110,
            'status' => $request->status,
            'created_by' => session('admin_id'),
        ]);

        return redirect()->route('admin.tryouts.edit-questions', $tryout->id)
            ->with('success', 'Try Out berhasil dibuat! Silakan buat ' . $tryout->total_questions . ' soal (30 TWK + 35 TIU + 45 TKP).');
    }

    public function editQuestions($id)
    {
        $tryout = Tryout::findOrFail($id);
        $questions = $tryout->questions()->orderBy('order_number')->get();
        
        // Jika belum ada soal, buat placeholder kosong
        if ($questions->count() == 0) {
            for ($i = 1; $i <= $tryout->total_questions; $i++) {
                $category = $this->getCategoryByOrder($i, $tryout);
                $questions->push(new TryoutQuestion([
                    'order_number' => $i,
                    'category' => $category
                ]));
            }
        }
        
        return view('admin.tryouts.edit-questions', compact('tryout', 'questions'));
    }
    
    private function getCategoryByOrder($order, $tryout = null)
    {
        $twk = $tryout ? $tryout->total_questions_twk : 30;
        $tiu = $tryout ? $tryout->total_questions_tiu : 35;
        $twkTiu = $twk + $tiu;
        
        if ($order <= $twk) {
            return 'twk';
        } elseif ($order <= $twkTiu) {
            return 'tiu';
        } else {
            return 'tkp';
        }
    }

    public function saveQuestions(Request $request, $id)
    {
        $tryout = Tryout::findOrFail($id);
        $questionsData = $request->input('questions', []);
        
        foreach ($questionsData as $order => $data) {
            $questionId = $data['id'] ?? null;
            $category = $this->getCategoryByOrder($order + 1, $tryout);
            
            $questionData = [
                'tryout_id' => $tryout->id,
                'order_number' => $order + 1,
                'category' => $category,
                'question_text' => $data['question_text'] ?? '',
                'question_image' => $data['question_image'] ?? null,
                'option_a' => $data['option_a'] ?? '',
                'option_a_image' => $data['option_a_image'] ?? null,
                'option_b' => $data['option_b'] ?? '',
                'option_b_image' => $data['option_b_image'] ?? null,
                'option_c' => $data['option_c'] ?? '',
                'option_c_image' => $data['option_c_image'] ?? null,
                'option_d' => $data['option_d'] ?? '',
                'option_d_image' => $data['option_d_image'] ?? null,
                'option_e' => $data['option_e'] ?? '',
                'option_e_image' => $data['option_e_image'] ?? null,
                'explanation' => $data['explanation'] ?? null,
            ];
            
            if ($category == 'tkp') {
                $questionData['score_a'] = $data['score_a'] ?? 0;
                $questionData['score_b'] = $data['score_b'] ?? 0;
                $questionData['score_c'] = $data['score_c'] ?? 0;
                $questionData['score_d'] = $data['score_d'] ?? 0;
                $questionData['score_e'] = $data['score_e'] ?? 0;
                $questionData['correct_answer'] = null;
            } else {
                $questionData['correct_answer'] = $data['correct_answer'] ?? 'a';
            }
            
            if ($questionId) {
                $question = TryoutQuestion::find($questionId);
                if ($question) {
                    $question->update($questionData);
                }
            } else {
                if (!empty($questionData['question_text'])) {
                    TryoutQuestion::create($questionData);
                }
            }
        }
        
        $filledCount = $tryout->questions()->where('question_text', '!=', '')->count();
        
        if ($filledCount == $tryout->total_questions) {
            $tryout->update(['status' => 'active']);
            $message = 'Semua soal berhasil disimpan! Try Out sudah aktif dan siap digunakan.';
        } else {
            $message = 'Soal berhasil disimpan. (' . $filledCount . '/' . $tryout->total_questions . ' soal terisi)';
        }
        
        return redirect()->route('admin.tryouts.index')->with('success', $message);
    }

    public function edit($id)
    {
        $tryout = Tryout::findOrFail($id);
        return view('admin.tryouts.edit', compact('tryout'));
    }

    public function update(Request $request, $id)
    {
        $tryout = Tryout::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'required|integer|min:30|max:180',
            'status' => 'required|in:draft,active',
        ]);

        $tryout->update([
            'name' => $request->name,
            'description' => $request->description,
            'duration' => $request->duration,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.tryouts.index')->with('success', 'Try Out berhasil diupdate!');
    }

    public function destroy($id)
    {
        $tryout = Tryout::findOrFail($id);
        
        // Hapus semua gambar terkait
        foreach ($tryout->questions as $question) {
            if ($question->question_image && file_exists(public_path('uploads/tryouts/' . $question->question_image))) {
                unlink(public_path('uploads/tryouts/' . $question->question_image));
            }
            foreach (['a', 'b', 'c', 'd', 'e'] as $opt) {
                $imageField = 'option_' . $opt . '_image';
                if ($question->$imageField && file_exists(public_path('uploads/tryouts/' . $question->$imageField))) {
                    unlink(public_path('uploads/tryouts/' . $question->$imageField));
                }
            }
        }
        
        $tryout->delete();
        
        return redirect()->route('admin.tryouts.index')->with('success', 'Try Out berhasil dihapus!');
    }
    
    public function duplicate($id)
    {
        $tryout = Tryout::findOrFail($id);
        
        $newTryout = Tryout::create([
            'name' => $tryout->name . ' (Copy)',
            'description' => $tryout->description,
            'duration' => $tryout->duration,
            'total_questions_twk' => $tryout->total_questions_twk,
            'total_questions_tiu' => $tryout->total_questions_tiu,
            'total_questions_tkp' => $tryout->total_questions_tkp,
            'total_questions' => $tryout->total_questions,
            'status' => 'draft',
            'created_by' => session('admin_id'),
        ]);
        
        foreach ($tryout->questions as $question) {
            $newQuestion = $question->replicate();
            $newQuestion->tryout_id = $newTryout->id;
            $newQuestion->save();
        }
        
        return redirect()->route('admin.tryouts.edit-questions', $newTryout->id)
            ->with('success', 'Try Out berhasil diduplikasi! Silakan lanjutkan edit soal.');
    }
}