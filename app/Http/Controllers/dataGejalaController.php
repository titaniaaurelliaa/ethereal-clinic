<?php

namespace App\Http\Controllers;

use App\Models\KnowledgeBase;
use App\Models\SkinProblemModel;
use Illuminate\Http\Request;

/**
 * KnowledgeBaseController  (file: dataGejalaController.php)
 *
 * Manages the "Basis Pengetahuan Pakar" module (knowledge_bases table).
 * Routes are registered as admin.knowledge-base.* in web.php.
 * Views live in: resources/views/Admin/knowledge_base/
 */
class dataGejalaController extends Controller
{
    // ─────────────────────────────────────────────────────────────────────
    // READ
    // ─────────────────────────────────────────────────────────────────────

    public function index(Request $request)
    {
        $query = KnowledgeBase::with('skinProblem')
            ->orderBy('skin_problem_id')
            ->orderBy('id');

        if ($request->filled('search')) {
            $query->where('nama_objek', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('keparahan')) {
            $query->where('tingkat_keparahan', $request->keparahan);
        }

        $knowledgeBases = $query->paginate(15)->appends($request->query());
        $skinProblems   = SkinProblemModel::orderBy('name')->get();

        return view('Admin.knowledge_base.index', compact('knowledgeBases', 'skinProblems'));
    }

    // ─────────────────────────────────────────────────────────────────────
    // STORE (GAP 2 — hardened validation)
    // ─────────────────────────────────────────────────────────────────────

    public function store(Request $request)
    {
        $request->validate(
            [
                'skin_problem_id'   => 'required|integer|exists:skin_problems,id',
                'nama_objek'        => 'required|string|max:100',
                'tingkat_keparahan' => 'required|in:Ringan,Sedang,Parah',
                'min_objek'         => 'required|integer|min:0',
                'max_objek'         => 'required|integer|min:0|gte:min_objek',
                'cf_pakar'          => 'required|numeric|between:0,1',
            ],
            [
                'skin_problem_id.required'   => 'Masalah kulit wajib dipilih.',
                'skin_problem_id.exists'     => 'Masalah kulit yang dipilih tidak valid.',
                'nama_objek.required'        => 'Nama objek AI wajib diisi.',
                'tingkat_keparahan.required' => 'Tingkat keparahan wajib dipilih.',
                'tingkat_keparahan.in'       => 'Tingkat keparahan harus salah satu dari: Ringan, Sedang, Parah.',
                'min_objek.required'         => 'Batas minimum objek wajib diisi.',
                'min_objek.integer'          => 'Batas minimum objek harus berupa bilangan bulat.',
                'min_objek.min'              => 'Batas minimum objek tidak boleh kurang dari 0.',
                'max_objek.required'         => 'Batas maksimum objek wajib diisi.',
                'max_objek.integer'          => 'Batas maksimum objek harus berupa bilangan bulat.',
                'max_objek.gte'              => 'Batas maksimum objek harus lebih besar atau sama dengan batas minimum (:value). Periksa kembali logika rentang objek.',
                'cf_pakar.required'          => 'Bobot pakar (CF) wajib diisi.',
                'cf_pakar.numeric'           => 'Bobot pakar harus berupa angka desimal.',
                'cf_pakar.between'           => 'Bobot pakar harus berada dalam rentang 0.00 hingga 1.00.',
            ]
        );

        KnowledgeBase::create([
            'skin_problem_id'   => $request->skin_problem_id,
            'nama_objek'        => $request->nama_objek,
            'tingkat_keparahan' => $request->tingkat_keparahan,
            'min_objek'         => $request->min_objek,
            'max_objek'         => $request->max_objek,
            'cf_pakar'          => $request->cf_pakar,
        ]);

        $page = $request->input('page', 1);
        return redirect()
            ->route('admin.knowledge-base.index', ['page' => $page])
            ->with('success', 'Basis pengetahuan berhasil ditambahkan.');
    }

    // ─────────────────────────────────────────────────────────────────────
    // UPDATE (GAP 2 — hardened validation)
    // ─────────────────────────────────────────────────────────────────────

    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'skin_problem_id'   => 'required|integer|exists:skin_problems,id',
                'nama_objek'        => 'required|string|max:100',
                'tingkat_keparahan' => 'required|in:Ringan,Sedang,Parah',
                'min_objek'         => 'required|integer|min:0',
                'max_objek'         => 'required|integer|min:0|gte:min_objek',
                'cf_pakar'          => 'required|numeric|between:0,1',
            ],
            [
                'skin_problem_id.required'   => 'Masalah kulit wajib dipilih.',
                'skin_problem_id.exists'     => 'Masalah kulit yang dipilih tidak valid.',
                'nama_objek.required'        => 'Nama objek AI wajib diisi.',
                'tingkat_keparahan.required' => 'Tingkat keparahan wajib dipilih.',
                'tingkat_keparahan.in'       => 'Tingkat keparahan harus salah satu dari: Ringan, Sedang, Parah.',
                'min_objek.required'         => 'Batas minimum objek wajib diisi.',
                'min_objek.integer'          => 'Batas minimum objek harus berupa bilangan bulat.',
                'min_objek.min'              => 'Batas minimum objek tidak boleh kurang dari 0.',
                'max_objek.required'         => 'Batas maksimum objek wajib diisi.',
                'max_objek.integer'          => 'Batas maksimum objek harus berupa bilangan bulat.',
                'max_objek.gte'              => 'Batas maksimum objek harus lebih besar atau sama dengan batas minimum (:value). Periksa kembali logika rentang objek.',
                'cf_pakar.required'          => 'Bobot pakar (CF) wajib diisi.',
                'cf_pakar.numeric'           => 'Bobot pakar harus berupa angka desimal.',
                'cf_pakar.between'           => 'Bobot pakar harus berada dalam rentang 0.00 hingga 1.00.',
            ]
        );

        $kb = KnowledgeBase::findOrFail($id);

        $kb->update([
            'skin_problem_id'   => $request->skin_problem_id,
            'nama_objek'        => $request->nama_objek,
            'tingkat_keparahan' => $request->tingkat_keparahan,
            'min_objek'         => $request->min_objek,
            'max_objek'         => $request->max_objek,
            'cf_pakar'          => $request->cf_pakar,
        ]);

        $page = $request->input('page', 1);
        return redirect()
            ->route('admin.knowledge-base.index', ['page' => $page])
            ->with('success', 'Basis pengetahuan berhasil diperbarui.');
    }

    // ─────────────────────────────────────────────────────────────────────
    // DESTROY (cascade-safe: deletes child SymptomRules first)
    // ─────────────────────────────────────────────────────────────────────

    public function destroy(Request $request, $id)
    {
        $kb = KnowledgeBase::findOrFail($id);

        // Cascade-delete all linked anamnesis questions before removing the rule
        $kb->symptomRules()->delete();
        $kb->delete();

        $page = $request->input('page', 1);
        return redirect()
            ->route('admin.knowledge-base.index', ['page' => $page])
            ->with('success', 'Basis pengetahuan berhasil dihapus.');
    }
}