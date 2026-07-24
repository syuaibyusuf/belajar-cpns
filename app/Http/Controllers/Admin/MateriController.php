<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Materi;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class MateriController extends Controller
{
    public function index()
    {
        $materi = Materi::with('creator')->latest()->paginate(10);
        return view('admin.materi.index', compact('materi'));
    }

    public function create()
    {
        $categories = Materi::getCategories();
        return view('admin.materi.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:twk,tiu,tkp',
            'content' => 'required',
            'status' => 'required|in:published,draft',
        ]);

        $data = [
            'title' => $request->title,
            'category' => $request->category,
            'order_number' => $request->order_number ?? 0,
            'status' => $request->status,
            'created_by' => session('admin_id'),
        ];
        
        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail');
            $filename = time() . '_' . Str::slug($request->title) . '.' . $thumbnail->getClientOriginalExtension();
            $thumbnail->move(public_path('uploads/materi'), $filename);
            $data['thumbnail'] = $filename;
        }
        
        $content = $request->input('content');
        $uploadedImages = [];
        
        preg_match_all('/\[IMAGE_(\d+)\]/', $content, $matches);
        
        foreach ($matches[1] as $index) {
            $imageField = 'image_' . $index;
            if ($request->hasFile($imageField)) {
                $image = $request->file($imageField);
                $imageFilename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/materi'), $imageFilename);
                $uploadedImages[] = [
                    'placeholder' => '[IMAGE_' . $index . ']',
                    'path' => $imageFilename,
                    'original_name' => $image->getClientOriginalName()
                ];
            }
        }
        
        $data['content_images'] = json_encode($uploadedImages);
        $data['content'] = $content;
        
        Materi::create($data);

        return redirect()->route('admin.materi.index')->with('success', 'Materi berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $materi = Materi::findOrFail($id);
        $categories = Materi::getCategories();
        
        $content = $materi->content;
        
        $images = $materi->content_images;
        if (is_string($images)) {
            $images = json_decode($images, true);
        }
        if (!is_array($images)) {
            $images = [];
        }
        
        $existingPlaceholders = array_column($images, 'placeholder');
        
        $materi->raw_content = $content;
        $materi->existing_images = $images;
        $materi->existing_placeholders = $existingPlaceholders;
        
        return view('admin.materi.edit', compact('materi', 'categories'));
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

        $data = [
            'title' => $request->title,
            'category' => $request->category,
            'order_number' => $request->order_number ?? 0,
            'status' => $request->status,
        ];
        
        if ($request->hasFile('thumbnail')) {
            if ($materi->thumbnail && file_exists(public_path('uploads/materi/' . $materi->thumbnail))) {
                unlink(public_path('uploads/materi/' . $materi->thumbnail));
            }
            $thumbnail = $request->file('thumbnail');
            $filename = time() . '_' . Str::slug($request->title) . '.' . $thumbnail->getClientOriginalExtension();
            $thumbnail->move(public_path('uploads/materi'), $filename);
            $data['thumbnail'] = $filename;
        }
        
        $content = $request->input('content');
        
        $existingImages = $materi->content_images;
        if (is_string($existingImages)) {
            $existingImages = json_decode($existingImages, true);
        }
        if (!is_array($existingImages)) {
            $existingImages = [];
        }
        
        $existingPlaceholdersFromForm = [];
        if ($request->has('existing_placeholders')) {
            $existingPlaceholdersFromForm = json_decode($request->existing_placeholders, true);
            if (!is_array($existingPlaceholdersFromForm)) {
                $existingPlaceholdersFromForm = [];
            }
        }
        
        $newImages = [];
        
        foreach ($existingImages as $existing) {
            $placeholder = $existing['placeholder'];
            if (strpos($content, $placeholder) !== false) {
                if (file_exists(public_path('uploads/materi/' . $existing['path']))) {
                    $newImages[] = $existing;
                }
            }
        }
        
        preg_match_all('/\[IMAGE_(\d+)\]/', $content, $matches);
        
        foreach ($matches[1] as $index) {
            $imageField = 'image_' . $index;
            if ($request->hasFile($imageField)) {
                $alreadyExists = false;
                foreach ($newImages as $img) {
                    if ($img['placeholder'] == '[IMAGE_' . $index . ']') {
                        $alreadyExists = true;
                        break;
                    }
                }
                
                if (!$alreadyExists) {
                    $image = $request->file($imageField);
                    $imageFilename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('uploads/materi'), $imageFilename);
                    $newImages[] = [
                        'placeholder' => '[IMAGE_' . $index . ']',
                        'path' => $imageFilename,
                        'original_name' => $image->getClientOriginalName()
                    ];
                }
            }
        }
        
        $usedPlaceholders = array_column($newImages, 'placeholder');
        foreach ($existingImages as $existing) {
            if (!in_array($existing['placeholder'], $usedPlaceholders)) {
                $filePath = public_path('uploads/materi/' . $existing['path']);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
        }
        
        $data['content_images'] = json_encode($newImages);
        $data['content'] = $content;
        
        $materi->update($data);

        return redirect()->route('admin.materi.index')->with('success', 'Materi berhasil diupdate!');
    }

    public function destroy($id)
    {
        $materi = Materi::findOrFail($id);
        
        if ($materi->thumbnail && file_exists(public_path('uploads/materi/' . $materi->thumbnail))) {
            unlink(public_path('uploads/materi/' . $materi->thumbnail));
        }
        
        $images = $materi->content_images;
        if (is_string($images)) {
            $images = json_decode($images, true);
        }
        if (is_array($images)) {
            foreach ($images as $img) {
                if (isset($img['path'])) {
                    $filePath = public_path('uploads/materi/' . $img['path']);
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                }
            }
        }
        
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