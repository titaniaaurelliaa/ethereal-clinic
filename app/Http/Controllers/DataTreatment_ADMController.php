<?php

namespace App\Http\Controllers;

use App\Models\TreatmentModel;
use App\Models\SkinProblemModel;
use Illuminate\Http\Request;

class DataTreatment_ADMController extends Controller
{
    public function index(Request $request)
    {
        // Ambil data input pencarian jika ada
        $search = $request->input('search');

        $treatment = TreatmentModel::with('skinProblems')
            // Query akan ditambahkan hanya jika variabel $search diisi oleh user
            ->when($search, function ($query, $search) {
                return $query->where('name', 'LIKE', '%' . $search . '%');
            })
            ->orderBy('id', 'asc')
            ->paginate(10)
            ->withQueryString();

        $skinProblems = SkinProblemModel::orderBy('name')->get();

        return view('admin.treatment.index', compact('treatment', 'skinProblems'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'            => 'required|string|max:255',
            'description'     => 'required|string',
            'skin_problems'   => 'required|array|min:1',
            'skin_problems.*' => 'integer|exists:skin_problems,id',
        ]);

        $treatment = TreatmentModel::create([
            'name'        => $request->name,
            'description' => $request->description,
        ]);

        // Sync pivot (problem_treatment)
        $treatment->skinProblems()->sync($request->input('skin_problems', []));

        $page = $request->input('page', 1);
        return redirect()->route('admin.treatment.index', ['page' => $page])
            ->with('success', 'Data treatment berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'            => 'required|string|max:255',
            'description'     => 'required|string',
            'skin_problems'   => 'required|array|min:1',
            'skin_problems.*' => 'integer|exists:skin_problems,id',
        ]);

        $treatment = TreatmentModel::findOrFail($id);

        $treatment->update([
            'name'        => $request->name,
            'description' => $request->description,
        ]);

        // Sync pivot (problem_treatment)
        $treatment->skinProblems()->sync($request->input('skin_problems', []));

        $page = $request->input('page', 1);
        return redirect()->route('admin.treatment.index', ['page' => $page])
            ->with('success', 'Data treatment berhasil diperbarui');
    }

    public function destroy(Request $request, $id)
    {
        $treatment = TreatmentModel::findOrFail($id);

        // Detach pivot records first
        $treatment->skinProblems()->detach();
        $treatment->delete();

        $page = $request->input('page', 1);
        return redirect()->route('admin.treatment.index', ['page' => $page])
            ->with('success', 'Data treatment berhasil dihapus');
    }
}
