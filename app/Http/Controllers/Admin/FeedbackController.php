<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::latest()->paginate(15);
        $unreadCount = Feedback::where('status', 'unread')->count();
        return view('admin.feedback.index', compact('feedbacks', 'unreadCount'));
    }
    
    public function show($id)
    {
        $feedback = Feedback::findOrFail($id);
        
        if ($feedback->status == 'unread') {
            $feedback->update(['status' => 'read']);
        }
        
        return view('admin.feedback.show', compact('feedback'));
    }
    
    public function respond(Request $request, $id)
    {
        $feedback = Feedback::findOrFail($id);
        
        $request->validate([
            'response' => 'required|string|min:5'
        ]);
        
        $feedback->update([
            'admin_response' => $request->response,
            'status' => 'responded'
        ]);
        
        return redirect()->route('admin.feedback.index')->with('success', 'Respon berhasil dikirim!');
    }
    
    public function destroy($id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->delete();
        
        return redirect()->route('admin.feedback.index')->with('success', 'Saran berhasil dihapus!');
    }
}