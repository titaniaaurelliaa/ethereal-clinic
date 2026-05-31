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

        return view('Admin.symptom_rules.index', compact('rules', 'total', 'objekList'));
    }

    // ─────────────────────────────────────────────────────────────────────────
    // CREATE
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Menampilkan form tambah SymptomRule.
     * Mengirimkan semua KnowledgeBase agar admin bisa memilih lewat dropdown.
     */
    public function create(): View
    {
        // Ambil semua KnowledgeBase diurutkan per nama dan keparahan
        $knowledgeBases = KnowledgeBase::orderBy('nama_objek')
                                       ->orderByRaw("FIELD(tingkat_keparahan, 'Ringan', 'Sedang', 'Parah')")
                                       ->get();

        return view('Admin.symptom_rules.create', compact('knowledgeBases'));
    }

    /**
     * Menyimpan SymptomRule baru ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'knowledge_base_id' => ['required', 'integer', 'exists:knowledge_bases,id'],
            'pertanyaan'        => ['required', 'string', 'max:500'],
            'cf_gejala'         => ['required', 'numeric', 'min:0.1', 'max:1.0'],
        ], [
            'knowledge_base_id.required' => 'Pilih kondisi kulit / KnowledgeBase terlebih dahulu.',
            'knowledge_base_id.exists'   => 'Kondisi kulit yang dipilih tidak valid.',
            'pertanyaan.required'        => 'Teks pertanyaan anamnesis wajib diisi.',
            'pertanyaan.max'             => 'Pertanyaan maksimal 500 karakter.',
            'cf_gejala.required'         => 'Nilai CF Gejala wajib diisi.',
            'cf_gejala.min'              => 'Nilai CF Gejala minimal 0.1.',
            'cf_gejala.max'              => 'Nilai CF Gejala tidak boleh melebihi 1.0.',
        ]);

        SymptomRule::create($validated);

        return redirect()
            ->route('admin.symptom-rules.index')
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
     */
    public function update(Request $request, SymptomRule $symptomRule): RedirectResponse
    {
        $validated = $request->validate([
            'knowledge_base_id' => ['required', 'integer', 'exists:knowledge_bases,id'],
            'pertanyaan'        => ['required', 'string', 'max:500'],
            'cf_gejala'         => ['required', 'numeric', 'min:0.1', 'max:1.0'],
        ], [
            'knowledge_base_id.required' => 'Pilih kondisi kulit / KnowledgeBase terlebih dahulu.',
            'knowledge_base_id.exists'   => 'Kondisi kulit yang dipilih tidak valid.',
            'pertanyaan.required'        => 'Teks pertanyaan anamnesis wajib diisi.',
            'pertanyaan.max'             => 'Pertanyaan maksimal 500 karakter.',
            'cf_gejala.required'         => 'Nilai CF Gejala wajib diisi.',
            'cf_gejala.min'              => 'Nilai CF Gejala minimal 0.1.',
            'cf_gejala.max'              => 'Nilai CF Gejala tidak boleh melebihi 1.0.',
        ]);

        $symptomRule->update($validated);

        return redirect()
            ->route('admin.symptom-rules.index')
            ->with('success', 'Pertanyaan anamnesis berhasil diperbarui!');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // DELETE
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Menghapus SymptomRule dari database.
     */
    public function destroy(SymptomRule $symptomRule): RedirectResponse
    {
        $symptomRule->delete();

        return redirect()
            ->route('admin.symptom-rules.index')
            ->with('success', 'Pertanyaan anamnesis berhasil dihapus!');
    }
}
