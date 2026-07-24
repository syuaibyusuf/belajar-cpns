<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;

class AdminSoalController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->get('category', 'all');
        $search = $request->get('search', '');
        
        $query = Question::with('creator');
        
        if ($category !== 'all') {
            $query->where('category', $category);
        }
        
        if ($search) {
            $query->where('question_text', 'like', "%{$search}%");
        }
        
        $questions = $query->latest()->paginate(15);
        $categories = Question::getCategories();
        
        return view('admin.soal.index', compact('questions', 'categories', 'category', 'search'));
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
            'correct_answer' => 'required|in:a,b,c,d,e',
            'difficulty' => 'required|in:easy,medium,hard',
        ]);

        Question::create([
            'category' => $request->category,
            'question_text' => $request->question_text,
            'option_a' => $request->option_a,
            'option_b' => $request->option_b,
            'option_c' => $request->option_c,
            'option_d' => $request->option_d,
            'option_e' => $request->option_e,
            'correct_answer' => $request->correct_answer,
            'explanation' => $request->explanation,
            'difficulty' => $request->difficulty,
            'points' => $request->points ?? 1,
            'created_by' => session('admin_id'),
        ]);

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
            'correct_answer' => 'required|in:a,b,c,d,e',
            'difficulty' => 'required|in:easy,medium,hard',
        ]);

        $question->update([
            'category' => $request->category,
            'question_text' => $request->question_text,
            'option_a' => $request->option_a,
            'option_b' => $request->option_b,
            'option_c' => $request->option_c,
            'option_d' => $request->option_d,
            'option_e' => $request->option_e,
            'correct_answer' => $request->correct_answer,
            'explanation' => $request->explanation,
            'difficulty' => $request->difficulty,
            'points' => $request->points ?? 1,
        ]);

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
            
            // Contoh data
            fputcsv($file, ['twk', 'Contoh soal TWK?', 'Opsi A', 'Opsi B', 'Opsi C', 'Opsi D', 'Opsi E', 'a', 'Pembahasan', 'medium']);
            
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