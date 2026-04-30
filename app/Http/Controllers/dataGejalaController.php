<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Symptom;

class dataGejalaController extends Controller
{
    public function index()
    {
        $symptoms = Symptom::paginate(10);
        return view('Admin.symptoms.index', compact('symptoms'));
    }

    public function create()
    {
        return view('Admin.symptoms.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required'
        ]);

        Symptom::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        // Ambil page dari request, default 1
        $page = $request->input('page', 1);

        return redirect()->route('admin.symptoms.index', ['page' => $page])
            ->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $symptom = Symptom::findOrFail($id);
        return view('Admin.symptoms.edit', compact('symptom'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required'
        ]);

        $symptom = Symptom::findOrFail($id);

        $symptom->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        // Ambil page dari request, default 1
        $page = $request->input('page', 1);

        return redirect()->route('admin.symptoms.index', ['page' => $page])
            ->with('success', 'Data berhasil diupdate');
    }

    public function destroy(Request $request, $id)
    {
        $symptom = Symptom::findOrFail($id);
        $symptom->delete();

        // Ambil page dari request, default 1
        $page = $request->input('page', 1);

        return redirect()->route('admin.symptoms.index', ['page' => $page])
            ->with('success', 'Data berhasil dihapus');
    }
}