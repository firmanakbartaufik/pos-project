<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Menampilkan halaman login
    public function showLoginForm()
    {
        return view('login'); // tetap menampilkan Blade
    }

    // Login via form (JSON response untuk AJAX)
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Jika form biasa (non-AJAX), redirect ke dashboard
            if (!$request->expectsJson()) {
                return redirect()->intended('/');
            }

            // Jika AJAX / API request, kembalikan JSON
            return response()->json([
                'success' => true,
                'message' => 'Login berhasil',
                'user' => Auth::user()
            ]);
        }

        $errorMessage = 'Email atau password salah';

        // Jika form biasa
        if (!$request->expectsJson()) {
            return back()->withErrors(['email' => $errorMessage])->onlyInput('email');
        }

        // Jika AJAX / API request
        return response()->json([
            'success' => false,
            'message' => $errorMessage
        ], 401);
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Jika form biasa
        if (!$request->expectsJson()) {
            return redirect('/login')->with('success', 'Berhasil logout');
        }

        // Jika AJAX / API
        return response()->json([
            'success' => true,
            'message' => 'Berhasil logout'
        ]);
    }
}
