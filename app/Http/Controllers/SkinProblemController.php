<?php

namespace App\Http\Controllers;

use App\Models\SkinProblemModel;
use Illuminate\Http\Request;

class SkinProblemController extends Controller
{
    public function index(Request $request)
    {
        $query = SkinProblemModel::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Sesuaikan dengan name="severity" di form filter blade
        if ($request->has('severity') && $request->severity != '') {
            $query->where('severity_level', $request->severity);
        }

        // PERBAIKAN: Urutan dari ID terkecil (asc) agar P001 muncul duluan
        $problems = $query->orderBy('id', 'asc')->paginate(10);
        $problems->appends($request->query());

        $totalPenyakit = SkinProblemModel::count();
        $risikoTinggi = SkinProblemModel::where('severity_level', 'berat')->count();
        $updateTerakhir = SkinProblemModel::latest('updated_at')->first()?->updated_at->format('d M Y') ?? '-';

        return view('admin.skin_problems.index', compact(
            'problems', 'totalPenyakit', 'risikoTinggi', 'updateTerakhir'
        ));
    }

    public function store(Request $request)
    {
        // Validasi ketat seperti Data Produk
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'severity_level' => 'required|string|in:ringan,sedang,berat'
        ]);

        SkinProblemModel::create([
            'name' => $request->name,
            'description' => $request->description,
            'severity_level' => $request->severity_level,
        ]);

        // Redirect kembali ke halaman aktif saat ini
        $page = $request->page ?? 1;
        return redirect()->route('admin.skin-problems.index', ['page' => $page])
                         ->with('success', 'Masalah kulit berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'severity_level' => 'required|string|in:ringan,sedang,berat'
        ]);

        $problem = SkinProblemModel::findOrFail($id);

        $problem->update([
            'name' => $request->name,
            'description' => $request->description,
            'severity_level' => $request->severity_level,
        ]);

        $page = $request->page ?? 1;
        return redirect()->route('admin.skin-problems.index', ['page' => $page])
                         ->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy(Request $request, $id)
    {
        $problem = SkinProblemModel::findOrFail($id);
        $problem->delete();

        $page = $request->page ?? 1;
        return redirect()->route('admin.skin-problems.index', ['page' => $page])
                         ->with('success', 'Data masalah kulit berhasil dihapus!');
    }
}
