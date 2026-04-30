<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password; 

class AuthController extends Controller
{
    // --- PROSES REGISTRASI PASIEN ---
    public function registerPost(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            
            // email:rfc,dns memastikan format sesuai standar global dan domainnya benar-benar ada
            'email' => 'required|string|email:rfc,dns|max:255|unique:users',
            
            'password' => [
                'required',
                'confirmed',
                Password::min(8) // Minimal 8 karakter

            ],
        ]);

        // Simpan ke database
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    


    // --- PROSES LOGIN ---
    public function loginPost(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Cek kecocokan email dan password
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Cek Role untuk Redirection
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('pasien.dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // --- PROSES LOGOUT ---
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
