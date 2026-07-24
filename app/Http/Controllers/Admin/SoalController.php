<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SoalController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->get('category', 'all');
        $search = $request->get('search', '');
        
        $query = Question::query();
        
        if ($category !== 'all') {
            $query->where('category', $category);
        }
        
        if ($search) {
            $query->where('question_text', 'like', "%{$search}%");
        }
        
        $questions = $query->latest()->paginate(15);
        
        return view('admin.soal.index', compact('questions', 'category', 'search'));
    }

    public function create()
    {
        $categories = Question::getCategories();
        return view('admin.soal.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|in:twk,tiu,tkp',
            'question_text' => 'required',
            'option_a' => 'required',
            'option_b' => 'required',
            'option_c' => 'required',
            'option_d' => 'required',
            'option_e' => 'required',
        ]);
        
        $data = [
            'category' => $request->category,
            'question_text' => $request->question_text,
            'option_a' => $request->option_a,
            'option_b' => $request->option_b,
            'option_c' => $request->option_c,
            'option_d' => $request->option_d,
            'option_e' => $request->option_e,
            'explanation' => $request->explanation,
            'difficulty' => $request->difficulty ?? 'medium',
            'points' => $request->points ?? 5,
            'created_by' => session('admin_id'),
        ];
        
        // Proses gambar soal (base64)
        if ($request->has('question_image') && $request->question_image) {
            $data['question_image'] = $request->question_image;
        }
        
        // Proses gambar opsi
        foreach (['a', 'b', 'c', 'd', 'e'] as $opt) {
            $imageKey = 'image_' . $opt;
            if ($request->has($imageKey) && $request->$imageKey) {
                $data[$imageKey] = $request->$imageKey;
            }
        }
        
        // Untuk TKP: simpan nilai per opsi
        if ($request->category == 'tkp') {
            $data['score_a'] = $request->score_a ?? 0;
            $data['score_b'] = $request->score_b ?? 0;
            $data['score_c'] = $request->score_c ?? 0;
            $data['score_d'] = $request->score_d ?? 0;
            $data['score_e'] = $request->score_e ?? 0;
            $data['correct_answer'] = null; // TKP tidak punya jawaban benar
        } else {
            // Untuk TWK/TIU: wajib ada jawaban benar
            $request->validate([
                'correct_answer' => 'required|in:a,b,c,d,e',
            ]);
            $data['correct_answer'] = $request->correct_answer;
        }
        
        Question::create($data);
        
        return redirect()->route('admin.soal.index')->with('success', 'Soal berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $question = Question::findOrFail($id);
        $categories = Question::getCategories();
        return view('admin.soal.edit', compact('question', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $question = Question::findOrFail($id);
        
        $request->validate([
            'category' => 'required|in:twk,tiu,tkp',
            'question_text' => 'required',
            'option_a' => 'required',
            'option_b' => 'required',
            'option_c' => 'required',
            'option_d' => 'required',
            'option_e' => 'required',
        ]);
        
        $data = [
            'category' => $request->category,
            'question_text' => $request->question_text,
            'option_a' => $request->option_a,
            'option_b' => $request->option_b,
            'option_c' => $request->option_c,
            'option_d' => $request->option_d,
            'option_e' => $request->option_e,
            'explanation' => $request->explanation,
            'difficulty' => $request->difficulty ?? 'medium',
            'points' => $request->points ?? 5,
        ];
        
        // Proses gambar soal
        if ($request->has('question_image') && $request->question_image) {
            $data['question_image'] = $request->question_image;
        }
        
        // Proses gambar opsi
        foreach (['a', 'b', 'c', 'd', 'e'] as $opt) {
            $imageKey = 'image_' . $opt;
            if ($request->has($imageKey) && $request->$imageKey) {
                $data[$imageKey] = $request->$imageKey;
            }
        }
        
        // Untuk TKP: simpan nilai per opsi
        if ($request->category == 'tkp') {
            $data['score_a'] = $request->score_a ?? 0;
            $data['score_b'] = $request->score_b ?? 0;
            $data['score_c'] = $request->score_c ?? 0;
            $data['score_d'] = $request->score_d ?? 0;
            $data['score_e'] = $request->score_e ?? 0;
            $data['correct_answer'] = null;
        } else {
            $request->validate([
                'correct_answer' => 'required|in:a,b,c,d,e',
            ]);
            $data['correct_answer'] = $request->correct_answer;
        }
        
        $question->update($data);
        
        return redirect()->route('admin.soal.index')->with('success', 'Soal berhasil diupdate!');
    }

    public function destroy($id)
    {
        $question = Question::findOrFail($id);
        $question->delete();
        
        return redirect()->route('admin.soal.index')->with('success', 'Soal berhasil dihapus!');
    }

    public function downloadTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="template_soal.csv"',
        ];
        
        $columns = ['category', 'question_text', 'option_a', 'option_b', 'option_c', 'option_d', 'option_e', 'correct_answer', 'explanation', 'difficulty'];
        
        $callback = function() use ($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            fputcsv($file, ['twk', 'Contoh soal?', 'A', 'B', 'C', 'D', 'E', 'a', 'Pembahasan', 'medium']);
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }

    public function export()
    {
        $questions = Question::all();
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="soal_export.csv"',
        ];
        
        $callback = function() use ($questions) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Kategori', 'Soal', 'Opsi A', 'Opsi B', 'Opsi C', 'Opsi D', 'Opsi E', 'Jawaban', 'Pembahasan', 'Difficulty']);
            
            foreach ($questions as $q) {
                fputcsv($file, [
                    $q->id, $q->category, $q->question_text, $q->option_a, $q->option_b,
                    $q->option_c, $q->option_d, $q->option_e, $q->correct_answer, 
                    $q->explanation, $q->difficulty
                ]);
            }
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}