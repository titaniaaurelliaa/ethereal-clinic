<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    /**
     * Menampilkan halaman profil pasien
     */
    public function index()
    {
        // Pastikan nama view ini sesuai dengan lokasi file blade-mu (resources/views/pasien/profil.blade.php)
        return view('pasien.profil'); 
    }

    /**
     * Memproses pembaruan profil dan upload foto
     */
    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // 1. Validasi Input dengan Proteksi Sandi Lama
        $request->validate([
            'name' => 'required|string|max:255',
            // required_with:password berarti sandi lama WAJIB diisi JIKA sandi baru diisi
            'current_password' => 'nullable|required_with:password|current_password', 
            'password' => 'nullable|min:8',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', 
        ], [
            // Kustomisasi pesan eror agar ramah pengguna
            'current_password.required_with' => 'Sandi saat ini wajib diisi untuk keamanan sebelum mengubah sandi baru.',
            'current_password.current_password' => 'Sandi saat ini yang Anda masukkan salah.',
            'password.min' => 'Sandi baru minimal harus 8 karakter.'
        ]);

        // 2. Update Nama
        $user->name = $request->name;
        
        // 3. Update Password
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // 4. Handle Upload File Fisik Avatar
        if ($request->hasFile('avatar')) {
            if ($user->avatar && Storage::exists('public/avatars/' . $user->avatar)) {
                Storage::delete('public/avatars/' . $user->avatar);
            }
            $file = $request->file('avatar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/avatars', $filename);
            $user->avatar = $filename;
        }

        $user->save();

        return back()->with('success', 'Profil dan keamanan akun berhasil diperbarui!');
    }
    /**
     * Menghapus akun pasien secara permanen
     */
    public function destroy(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // 1. Bersihkan file foto dari storage agar tidak menjadi sampah
        if ($user->avatar && Storage::exists('public/avatars/' . $user->avatar)) {
            Storage::delete('public/avatars/' . $user->avatar);
        }

        // 2. Logout sesi saat ini
        Auth::logout();

        // 3. Hapus data user dari database
        $user->delete();

        // 4. Hancurkan sesi untuk keamanan
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // 5. Kembalikan ke halaman depan 
        return redirect('/')->with('success', 'Akun Anda telah berhasil dihapus secara permanen.');
    }
}