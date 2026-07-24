<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $key = 'admin-login:' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->with('error', "Terlalu banyak percobaan login. Coba lagi dalam $seconds detik.");
        }

        $admin = Admin::where('email', $request->email)->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            RateLimiter::clear($key);
            session()->put('admin_id', $admin->id);
            session()->put('admin_name', $admin->name);
            session()->put('admin_role', $admin->role);
            return redirect()->route('admin.dashboard');
        }

        RateLimiter::hit($key, 60);
        return back()->with('error', 'Email atau password salah!');
    }

    public function logout()
    {
        session()->forget(['admin_id', 'admin_name', 'admin_role']);
        return redirect()->route('admin.login');
    }
}