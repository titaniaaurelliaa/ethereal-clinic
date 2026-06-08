<?php

namespace App\Http\Controllers;

use App\Models\KnowledgeBase;
use App\Models\SymptomRule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SymptomRuleController extends Controller
{
    // ─────────────────────────────────────────────────────────────────────────
    // READ — Daftar semua pertanyaan anamnesis
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Menampilkan daftar SymptomRule beserta relasi KnowledgeBase-nya.
     * Mendukung filter berdasarkan nama_objek dan pencarian teks pertanyaan.
     */
    public function index(Request $request): View
    {
        $query = SymptomRule::with('knowledgeBase')
                            ->orderBy('knowledge_base_id')
                            ->orderBy('id');

        // Filter berdasarkan nama objek (KnowledgeBase)
        if ($request->filled('objek')) {
            $query->whereHas('knowledgeBase', fn ($q) =>
                $q->where('nama_objek', $request->objek)
            );
        }

        // Filter pencarian teks pertanyaan
        if ($request->filled('search')) {
            $query->where('pertanyaan', 'like', '%' . $request->search . '%');
        }

        $rules    = $query->paginate(15)->appends($request->query());
        $total    = SymptomRule::count();

        // Daftar unik nama_objek untuk dropdown filter
        $objekList = KnowledgeBase::distinct()->orderBy('nama_objek')->pluck('nama_objek');

        // Ambil semua KnowledgeBase untuk modal create & edit
        $knowledgeBases = KnowledgeBase::orderBy('nama_objek')
                                       ->orderByRaw("FIELD(tingkat_keparahan, 'Ringan', 'Sedang', 'Parah')")
                                       ->get();

        return view('Admin.symptom_rules.index', compact('rules', 'total', 'objekList', 'knowledgeBases'));
    }

    // ─────────────────────────────────────────────────────────────────────────
    // CREATE
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Menampilkan form tambah SymptomRule.
     */
    public function create(): View
    {
        $knowledgeBases = KnowledgeBase::orderBy('nama_objek')
                                       ->orderByRaw("FIELD(tingkat_keparahan, 'Ringan', 'Sedang', 'Parah')")
                                       ->get();

        return view('Admin.symptom_rules.create', compact('knowledgeBases'));
    }

    /**
     * Menyimpan SymptomRule baru ke database.
     * Menambahkan parameter page untuk redirect ke halaman yang sama.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'knowledge_base_id' => ['required', 'integer', 'exists:knowledge_bases,id'],
            'pertanyaan'        => ['required', 'string', 'max:500'],
            'cf_pakar'          => ['required', 'numeric', 'min:0.1', 'max:1.0'], // <-- GANTI cf_gejala MENJADI cf_pakar
        ], [
            'knowledge_base_id.required' => 'Pilih kondisi kulit / KnowledgeBase terlebih dahulu.',
            'knowledge_base_id.exists'   => 'Kondisi kulit yang dipilih tidak valid.',
            'pertanyaan.required'        => 'Teks pertanyaan anamnesis wajib diisi.',
            'pertanyaan.max'             => 'Pertanyaan maksimal 500 karakter.',
            'cf_pakar.required'          => 'Nilai CF Pakar wajib diisi.',
            'cf_pakar.min'               => 'Nilai CF Pakar minimal 0.1.',
            'cf_pakar.max'               => 'Nilai CF Pakar tidak boleh melebihi 1.0.',
        ]);

        SymptomRule::create($validated);

        $page = $request->input('page', 1);
        return redirect()
            ->route('admin.symptom-rules.index', ['page' => $page])
            ->with('success', 'Pertanyaan anamnesis berhasil ditambahkan!');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // UPDATE
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Menampilkan form edit SymptomRule yang sudah ada.
     */
    public function edit(SymptomRule $symptomRule): View
    {
        $knowledgeBases = KnowledgeBase::orderBy('nama_objek')
                                       ->orderByRaw("FIELD(tingkat_keparahan, 'Ringan', 'Sedang', 'Parah')")
                                       ->get();

        return view('Admin.symptom_rules.edit', compact('symptomRule', 'knowledgeBases'));
    }

    /**
     * Menyimpan perubahan SymptomRule ke database.
     * Menambahkan parameter page untuk redirect ke halaman yang sama.
     */
    public function update(Request $request, SymptomRule $symptomRule): RedirectResponse
    {
        $validated = $request->validate([
            'knowledge_base_id' => ['required', 'integer', 'exists:knowledge_bases,id'],
            'pertanyaan'        => ['required', 'string', 'max:500'],
            'cf_pakar'          => ['required', 'numeric', 'min:0.1', 'max:1.0'], // <-- GANTI cf_gejala MENJADI cf_pakar
        ], [
            'knowledge_base_id.required' => 'Pilih kondisi kulit / KnowledgeBase terlebih dahulu.',
            'knowledge_base_id.exists'   => 'Kondisi kulit yang dipilih tidak valid.',
            'pertanyaan.required'        => 'Teks pertanyaan anamnesis wajib diisi.',
            'pertanyaan.max'             => 'Pertanyaan maksimal 500 karakter.',
            'cf_pakar.required'          => 'Nilai CF Pakar wajib diisi.',
            'cf_pakar.min'               => 'Nilai CF Pakar minimal 0.1.',
            'cf_pakar.max'               => 'Nilai CF Pakar tidak boleh melebihi 1.0.',
        ]);

        $symptomRule->update($validated);

        $page = $request->input('page', 1);
        return redirect()
            ->route('admin.symptom-rules.index', ['page' => $page])
            ->with('success', 'Pertanyaan anamnesis berhasil diperbarui!');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // DELETE
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Menghapus SymptomRule dari database.
     * Menambahkan parameter page untuk redirect ke halaman yang sama.
     */
    public function destroy(Request $request, SymptomRule $symptomRule): RedirectResponse
    {
        $symptomRule->delete();

        $page = $request->input('page', 1);
        return redirect()
            ->route('admin.symptom-rules.index', ['page' => $page])
            ->with('success', 'Pertanyaan anamnesis berhasil dihapus!');
    }
}