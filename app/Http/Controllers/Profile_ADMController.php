<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Profile_ADMController extends Controller
{
    public function index()
    {
        // Ambil data admin yang sedang login
        $user = Auth::user();

        // Cek apakah user login
        if (!$user) {
            return redirect()->route('login');
        }

        return view('admin.profile.index', compact('user'));
    }
}