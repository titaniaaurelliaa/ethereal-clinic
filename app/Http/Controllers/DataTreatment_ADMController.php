<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\TreatmentModel;

class DataTreatment_ADMController extends Controller
{
    public function index()
    {
        $treatment = TreatmentModel::paginate(10);
        return view('admin.treatment.index', compact('treatment'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'category' => 'required'
        ]);

        TreatmentModel::create([
            'name' => $request->name,
            'description' => $request->description,
            'category' => $request->category,
            'priority' => $request->priority ?? 0,
        ]);

        $page = $request->input('page', 1);

        return redirect()->route('admin.treatment.index', ['page' => $page])
            ->with('success', 'Data treatment berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'category' => 'required'
        ]);

        $treatment = TreatmentModel::findOrFail($id);

        $treatment->update([
            'name' => $request->name,
            'description' => $request->description,
            'category' => $request->category,
            'priority' => $request->priority ?? 0,
        ]);

        $page = $request->input('page', 1);

        return redirect()->route('admin.treatment.index', ['page' => $page])
            ->with('success', 'Data treatment berhasil diupdate');
    }

    public function destroy(Request $request, $id)
    {
        $treatment = TreatmentModel::findOrFail($id);
        $treatment->delete();

        $page = $request->input('page', 1);

        return redirect()->route('admin.treatment.index', ['page' => $page])
            ->with('success', 'Data treatment berhasil dihapus');
    }
}