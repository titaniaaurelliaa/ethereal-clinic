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

        // 1. Validasi Input
        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'nullable|min:8',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Maksimal 2MB
        ]);

        // 2. Update Nama
        $user->name = $request->name;
        
        // 3. Update Password (Hanya jika input form tidak kosong)
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // 4. Handle Upload File Fisik Avatar
        if ($request->hasFile('avatar')) {
            
            // Hapus file avatar lama dari server jika sebelumnya sudah ada
            if ($user->avatar && Storage::exists('public/avatars/' . $user->avatar)) {
                Storage::delete('public/avatars/' . $user->avatar);
            }

            // Ambil file yang diupload
            $file = $request->file('avatar');
            // Buat nama unik agar tidak bentrok (contoh: 1712345678_foto.jpg)
            $filename = time() . '_' . $file->getClientOriginalName();
            
            // Simpan foto baru ke dalam folder storage/app/public/avatars
            $file->storeAs('public/avatars', $filename);
            
            // Simpan HANYA nama filenya ke database MySQL
            $user->avatar = $filename;
        }

        // Simpan semua perubahan ke database
        $user->save();

        // Kembali ke halaman profil dengan pesan sukses
        return back()->with('success', 'Profil berhasil diperbarui!');
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