<?php

// app/Http/Controllers/SkinProblemController.php
namespace App\Http\Controllers;

use App\Models\SkinProblemModel; // Gunakan model kamu
use Illuminate\Http\Request;

class SkinProblemController extends Controller
{
    public function index()
    {
        $problems = SkinProblemModel::all();
        
        // Menghitung statistik untuk card di UI
        $totalPenyakit = $problems->count();
        $risikoTinggi = $problems->where('severity_level', 'sedang')->count(); 
        // Note: sesuaikan 'sedang' atau 'tinggi' sesuai kebutuhan tim
        
        $updateTerakhir = SkinProblemModel::latest('updated_at')->first()?->updated_at->format('d M Y');

        return view('admin.skin_problems.index', compact('problems', 'totalPenyakit', 'risikoTinggi', 'updateTerakhir'));
    }

    public function create()
{
    return view('admin.skin_problems.create');
}

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'severity_level' => 'required'
        ]);

        \App\Models\SkinProblemModel::create($request->all());
        return redirect()->route('skin-problems.index')->with('success', 'Masalah kulit berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $problem = \App\Models\SkinProblemModel::findOrFail($id);
        return view('admin.skin_problems.edit', compact('problem'));
    }

    public function update(Request $request, $id)
    {
        $problem = \App\Models\SkinProblemModel::findOrFail($id);
        $problem->update($request->all());
        return redirect()->route('skin-problems.index')->with('info', 'Data berhasil diperbarui!');
    }
    
    public function destroy($id)
    {
        // 1. Cari data berdasarkan ID
        $problem = \App\Models\SkinProblemModel::findOrFail($id);

        // 2. Hapus data tersebut
        $problem->delete();

        // 3. Kembalikan ke halaman index dengan pesan sukses
        return redirect()->route('skin-problems.index')->with('success', 'Data masalah kulit berhasil dihapus!');
    }
    
    // Method update dan destroy tetap sama seperti sebelumnya, 
    // hanya ganti SkinProblem menjadi SkinProblemModel.
}
