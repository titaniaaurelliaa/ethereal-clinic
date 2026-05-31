<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Profile_ADMController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Debug: Cek apakah user ditemukan
        if (!$user) {
            abort(404, 'User tidak ditemukan');
        }
        
        return view('Admin.profile.index', compact('user'));
    }
    
    public function update(Request $request)
    {
        // Ambil user dengan query builder untuk memastikan
        $userId = Auth::id();
        $user = User::find($userId);
        
        if (!$user) {
            return redirect()->route('admin.profile')->with('error', 'User tidak ditemukan!');
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $userId,
        ]);
        
        // Update menggunakan query builder
        User::where('id', $userId)->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        
        return redirect()->route('admin.profile')->with('success', 'Profile berhasil diperbarui!');
    }
    
    public function updatePassword(Request $request)
    {
        // Ambil user dengan query builder
        $userId = Auth::id();
        $user = User::find($userId);
        
        if (!$user) {
            return redirect()->route('admin.profile')->with('error', 'User tidak ditemukan!');
        }
        
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        ]);
        
        // Cek password lama
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->route('admin.profile')->with('error', 'Password saat ini salah!');
        }
        
        // Update password menggunakan query builder
        User::where('id', $userId)->update([
            'password' => Hash::make($request->new_password),
        ]);
        
        return redirect()->route('admin.profile')->with('success', 'Password berhasil diubah!');
    }
    
    public function updateAvatar(Request $request)
    {
        // Ambil user dengan query builder
        $userId = Auth::id();
        $user = User::find($userId);
        
        if (!$user) {
            return redirect()->route('admin.profile')->with('error', 'User tidak ditemukan!');
        }
        
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        // Hapus avatar lama jika ada
        if ($user->avatar && file_exists(public_path('storage/avatars/' . $user->avatar))) {
            unlink(public_path('storage/avatars/' . $user->avatar));
        }
        
        // Upload avatar baru
        $file = $request->file('avatar');
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('storage/avatars'), $filename);
        
        // Update avatar menggunakan query builder
        User::where('id', $userId)->update([
            'avatar' => $filename,
        ]);
        
        return redirect()->route('admin.profile')->with('success', 'Foto profile berhasil diubah!');
    }
}