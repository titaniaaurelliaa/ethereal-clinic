<?php

namespace App\Http\Controllers;

use App\Models\ProductModel;
use App\Models\SkinProblemModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DataProduct_ADMController extends Controller
{
    public function index(Request $request)
    {
        $query = ProductModel::with('skinProblems');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('brand', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $dataproduk   = $query->orderBy('id', 'asc')->paginate(10)->appends($request->query());
        $skinProblems = SkinProblemModel::orderBy('name')->get();

        return view('admin.dataproduk.index', compact('dataproduk', 'skinProblems'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name'          => 'required|string|max:255',
                'brand'         => 'required|string|max:100',
                'category'      => 'required|string|in:cleanser,exfoliator,toner,essence_serum,moisturizer,sunscreen,masker,cream,obat',
                'description'   => 'required|string',
                'how_to_use'    => 'nullable|string',
                'image'         => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'skin_problems' => 'nullable|array',
                'skin_problems.*' => 'integer|exists:skin_problems,id',
            ]);

            $productData = $request->only(['name', 'brand', 'category', 'description', 'how_to_use']);

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                
                if (!file_exists(public_path('images/product'))) {
                    mkdir(public_path('images/product'), 0755, true);
                }
                
                $image->move(public_path('images/product'), $imageName);
                $productData['image_path'] = 'images/product/' . $imageName;
            }

            $product = ProductModel::create($productData);

            if ($request->has('skin_problems')) {
                $product->skinProblems()->sync($request->input('skin_problems', []));
            }

            $page = $request->page ?? 1;
            return redirect()->route('admin.dataproduk.index', ['page' => $page])
                             ->with('success', 'Produk berhasil ditambahkan!');

        } catch (\Exception $e) {
            Log::error('Store product error: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'name'          => 'required|string|max:255',
                'brand'         => 'required|string|max:100',
                'category'      => 'required|string|in:cleanser,exfoliator,toner,essence_serum,moisturizer,sunscreen,masker,cream,obat',
                'description'   => 'required|string',
                'how_to_use'    => 'nullable|string',
                'image'         => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'skin_problems' => 'nullable|array',
                'skin_problems.*' => 'integer|exists:skin_problems,id',
            ]);

            $product = ProductModel::findOrFail($id);
            $productData = $request->only(['name', 'brand', 'category', 'description', 'how_to_use']);

            if ($request->hasFile('image')) {
                if ($product->image_path && file_exists(public_path($product->image_path))) {
                    unlink(public_path($product->image_path));
                }
                
                $image = $request->file('image');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                
                if (!file_exists(public_path('images/product'))) {
                    mkdir(public_path('images/product'), 0755, true);
                }
                
                $image->move(public_path('images/product'), $imageName);
                $productData['image_path'] = 'images/product/' . $imageName;
            }

            $product->update($productData);
            $product->skinProblems()->sync($request->input('skin_problems', []));

            $page = $request->page ?? 1;
            return redirect()->route('admin.dataproduk.index', ['page' => $page])
                             ->with('success', 'Produk berhasil diperbarui!');

        } catch (\Exception $e) {
            Log::error('Update product error: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function destroy(Request $request, string $id)
    {
        try {
            $product = ProductModel::findOrFail($id);
            $product->skinProblems()->detach();

            if ($product->image_path && file_exists(public_path($product->image_path))) {
                unlink(public_path($product->image_path));
            }

            $product->delete();

            $page = $request->page ?? 1;
            return redirect()->route('admin.dataproduk.index', ['page' => $page])
                             ->with('success', 'Produk berhasil dihapus!');

        } catch (\Exception $e) {
            Log::error('Delete product error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }
}