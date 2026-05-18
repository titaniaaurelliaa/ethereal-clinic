<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        // 1. Cek apakah user sudah login? Kalau belum, tendang ke halaman login
        if (!Auth::check()) {
            return redirect('/login');
        }

        // 2. Cek apakah role user SESUAI dengan pintu yang mau dia masuki?
        if (Auth::user()->role !== $role) {
            
            // Kalau tidak sesuai, kembalikan mereka ke habitatnya masing-masing
            if (Auth::user()->role === 'admin') {
                return redirect('/admin/dashboard');
            } else {
                return redirect('/pasien/dashboard');
            }
        }

        // 3. Kalau semua aman, silakan masuk!
        return $next($request);
    }
}
