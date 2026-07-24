<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\PackageQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::with('creator')->latest()->paginate(10);
        return view('admin.packages.index', compact('packages'));
    }

    public function create()
    {
        $categories = [
            'twk' => 'TWK - Tes Wawasan Kebangsaan',
            'tiu' => 'TIU - Tes Intelegensi Umum',
            'tkp' => 'TKP - Tes Karakteristik Pribadi'
        ];
        return view('admin.packages.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:twk,tiu,tkp',
            'description' => 'nullable|string',
            'total_questions' => 'required|integer|min:1|max:100',
        ]);

        $package = Package::create([
            'name' => $request->name,
            'category' => $request->category,
            'description' => $request->description,
            'total_questions' => $request->total_questions,
            'status' => 'draft',
            'created_by' => session('admin_id'),
        ]);

        return redirect()->route('admin.packages.edit-questions', $package->id)
            ->with('success', 'Paket berhasil dibuat! Silakan buat ' . $request->total_questions . ' soal.');
    }

    public function editQuestions($id)
    {
        $package = Package::findOrFail($id);
        $questions = $package->questions()->orderBy('order_number')->get();
        
        // Jika belum ada soal, buat placeholder kosong
        if ($questions->count() == 0) {
            for ($i = 1; $i <= $package->total_questions; $i++) {
                $questions->push(new PackageQuestion(['order_number' => $i]));
            }
        }
        
        return view('admin.packages.edit-questions', compact('package', 'questions'));
    }

    public function saveQuestions(Request $request, $id)
    {
        $package = Package::findOrFail($id);
        $questionsData = $request->input('questions', []);
        
        foreach ($questionsData as $order => $data) {
            $questionId = $data['id'] ?? null;
            
            $questionData = [
                'package_id' => $package->id,
                'order_number' => $order + 1,
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
            
            if ($package->category == 'tkp') {
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
                $question = PackageQuestion::find($questionId);
                if ($question) {
                    $question->update($questionData);
                }
            } else {
                if (!empty($questionData['question_text'])) {
                    PackageQuestion::create($questionData);
                }
            }
        }
        
        // Hitung jumlah soal yang sudah terisi
        $filledCount = $package->questions()->where('question_text', '!=', '')->count();
        
        if ($filledCount == $package->total_questions) {
            $package->update(['status' => 'active']);
            $message = 'Semua soal berhasil disimpan! Paket sudah aktif dan siap digunakan.';
        } else {
            $message = 'Soal berhasil disimpan. (' . $filledCount . '/' . $package->total_questions . ' soal terisi)';
        }
        
        return redirect()->route('admin.packages.index')->with('success', $message);
    }

    public function edit($id)
    {
        $package = Package::findOrFail($id);
        $categories = [
            'twk' => 'TWK - Tes Wawasan Kebangsaan',
            'tiu' => 'TIU - Tes Intelegensi Umum',
            'tkp' => 'TKP - Tes Karakteristik Pribadi'
        ];
        return view('admin.packages.edit', compact('package', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $package = Package::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:twk,tiu,tkp',
            'description' => 'nullable|string',
            'status' => 'required|in:draft,active',
        ]);

        $package->update([
            'name' => $request->name,
            'category' => $request->category,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.packages.index')->with('success', 'Paket berhasil diupdate!');
    }

    public function destroy($id)
    {
        $package = Package::findOrFail($id);
        $package->delete();
        
        return redirect()->route('admin.packages.index')->with('success', 'Paket berhasil dihapus!');
    }
    
    public function duplicate($id)
    {
        $package = Package::findOrFail($id);
        
        $newPackage = Package::create([
            'name' => $package->name . ' (Copy)',
            'category' => $package->category,
            'description' => $package->description,
            'total_questions' => $package->total_questions,
            'status' => 'draft',
            'created_by' => session('admin_id'),
        ]);
        
        foreach ($package->questions as $question) {
            $newQuestion = $question->replicate();
            $newQuestion->package_id = $newPackage->id;
            $newQuestion->save();
        }
        
        return redirect()->route('admin.packages.edit-questions', $newPackage->id)
            ->with('success', 'Paket berhasil diduplikasi! Silakan lanjutkan edit soal.');
    }
}