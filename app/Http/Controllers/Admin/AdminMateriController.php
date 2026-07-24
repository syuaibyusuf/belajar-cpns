<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Materi;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MateriController extends Controller
{
    public function index()
    {
        $materi = Materi::latest()->paginate(10);
        return view('admin.materi.index', compact('materi'));
    }

    public function create()
    {
        return view('admin.materi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:twk,tiu,tkp',
            'content' => 'required',
            'status' => 'required|in:published,draft',
        ]);

        Materi::create([
            'title' => $request->title,
            'category' => $request->category,
            'content' => $request->content,
            'order_number' => $request->order_number ?? 0,
            'status' => $request->status,
            'created_by' => session('admin_id'),
        ]);

        return redirect()->route('admin.materi.index')->with('success', 'Materi berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $materi = Materi::findOrFail($id);
        return view('admin.materi.edit', compact('materi'));
    }

    public function update(Request $request, $id)
    {
        $materi = Materi::findOrFail($id);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:twk,tiu,tkp',
            'content' => 'required',
            'status' => 'required|in:published,draft',
        ]);

        $materi->update([
            'title' => $request->title,
            'category' => $request->category,
            'content' => $request->content,
            'order_number' => $request->order_number ?? 0,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.materi.index')->with('success', 'Materi berhasil diupdate!');
    }

    public function destroy($id)
    {
        $materi = Materi::findOrFail($id);
        $materi->delete();
        
        return redirect()->route('admin.materi.index')->with('success', 'Materi berhasil dihapus!');
    }
    
    public function toggleStatus($id)
    {
        $materi = Materi::findOrFail($id);
        $materi->status = $materi->status == 'published' ? 'draft' : 'published';
        $materi->save();
        
        return response()->json(['success' => true, 'status' => $materi->status]);
    }
}
