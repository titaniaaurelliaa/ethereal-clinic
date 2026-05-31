<?php

namespace App\Http\Controllers;

use App\Models\TreatmentModel;
use App\Models\SkinProblemModel;
use Illuminate\Http\Request;

class DataTreatment_ADMController extends Controller
{
    public function index(Request $request)
    {
        $treatment    = TreatmentModel::with('skinProblems')->orderBy('id', 'asc')->paginate(10);
        $skinProblems = SkinProblemModel::orderBy('name')->get();

        return view('admin.treatment.index', compact('treatment', 'skinProblems'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'            => 'required|string|max:255',
            'description'     => 'required|string',
            'category'        => 'required|string|in:daily_habit,avoidance,protection,lifestyle',
            'priority'        => 'nullable|integer|min:0|max:10',
            'skin_problems'   => 'nullable|array',
            'skin_problems.*' => 'integer|exists:skin_problems,id',
        ]);

        $treatment = TreatmentModel::create([
            'name'        => $request->name,
            'description' => $request->description,
            'category'    => $request->category,
            'priority'    => $request->input('priority', 0),
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
            'category'        => 'required|string|in:daily_habit,avoidance,protection,lifestyle',
            'priority'        => 'nullable|integer|min:0|max:10',
            'skin_problems'   => 'nullable|array',
            'skin_problems.*' => 'integer|exists:skin_problems,id',
        ]);

        $treatment = TreatmentModel::findOrFail($id);

        $treatment->update([
            'name'        => $request->name,
            'description' => $request->description,
            'category'    => $request->category,
            'priority'    => $request->input('priority', 0),
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