<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuickPackage;
use App\Models\Question;
use Illuminate\Http\Request;

class QuickPackageController extends Controller
{
    public function index()
    {
        $packages = QuickPackage::with('creator')->latest()->paginate(10);
        return view('admin.quick-packages.index', compact('packages'));
    }

    public function create()
    {
        $categories = [
            'twk' => 'TWK - Tes Wawasan Kebangsaan',
            'tiu' => 'TIU - Tes Intelegensi Umum',
            'tkp' => 'TKP - Tes Karakteristik Pribadi'
        ];
        return view('admin.quick-packages.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:twk,tiu,tkp',
            'description' => 'nullable|string',
            'total_questions' => 'required|integer|in:10,15,20',
        ]);

        $package = QuickPackage::create([
            'name' => $request->name,
            'category' => $request->category,
            'description' => $request->description,
            'total_questions' => $request->total_questions,
            'status' => 'active',
            'created_by' => session('admin_id'),
        ]);

        return redirect()->route('admin.quick-packages.select-questions', $package->id)
            ->with('success', 'Paket cepat berhasil dibuat! Silakan pilih ' . $request->total_questions . ' soal.');
    }

    public function selectQuestions($id)
    {
        $package = QuickPackage::findOrFail($id);
        
        $selectedQuestionIds = $package->questions->pluck('id')->toArray();
        
        $questions = Question::where('category', $package->category)
            ->orderBy('id')
            ->paginate(20);
        
        $totalQuestions = Question::where('category', $package->category)->count();
        
        return view('admin.quick-packages.select-questions', compact('package', 'questions', 'selectedQuestionIds', 'totalQuestions'));
    }

    public function saveQuestions(Request $request, $id)
    {
        $package = QuickPackage::findOrFail($id);
        $questionIds = $request->input('questions', []);
        
        if (count($questionIds) != $package->total_questions) {
            return back()->with('error', 'Harus memilih tepat ' . $package->total_questions . ' soal! Saat ini: ' . count($questionIds) . ' soal');
        }
        
        // Hapus soal lama
        $package->questions()->detach();
        
        // Tambah soal baru dengan urutan
        foreach ($questionIds as $order => $questionId) {
            $package->questions()->attach($questionId, ['order_number' => $order + 1]);
        }
        
        return redirect()->route('admin.quick-packages.index')->with('success', $package->total_questions . ' soal berhasil dipilih untuk paket ' . $package->name);
    }

    public function edit($id)
    {
        $package = QuickPackage::findOrFail($id);
        $categories = [
            'twk' => 'TWK - Tes Wawasan Kebangsaan',
            'tiu' => 'TIU - Tes Intelegensi Umum',
            'tkp' => 'TKP - Tes Karakteristik Pribadi'
        ];
        return view('admin.quick-packages.edit', compact('package', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $package = QuickPackage::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:twk,tiu,tkp',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $package->update([
            'name' => $request->name,
            'category' => $request->category,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.quick-packages.index')->with('success', 'Paket cepat berhasil diupdate!');
    }

    public function destroy($id)
    {
        $package = QuickPackage::findOrFail($id);
        $package->delete();
        
        return redirect()->route('admin.quick-packages.index')->with('success', 'Paket cepat berhasil dihapus!');
    }
    
    public function duplicate($id)
    {
        $package = QuickPackage::findOrFail($id);
        
        $newPackage = QuickPackage::create([
            'name' => $package->name . ' (Copy)',
            'category' => $package->category,
            'description' => $package->description,
            'total_questions' => $package->total_questions,
            'status' => 'inactive',
            'created_by' => session('admin_id'),
        ]);
        
        foreach ($package->questions as $question) {
            $newPackage->questions()->attach($question->id, ['order_number' => $question->pivot->order_number]);
        }
        
        return redirect()->route('admin.quick-packages.edit', $newPackage->id)
            ->with('success', 'Paket cepat berhasil diduplikasi!');
    }
}