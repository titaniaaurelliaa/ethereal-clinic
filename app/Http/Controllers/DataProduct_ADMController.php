<?php

namespace App\Http\Controllers;

use App\Models\ProductModel;
use Illuminate\Http\Request;

class DataProduct_ADMController extends Controller
{
    public function index(Request $request)
    {
        $query = ProductModel::query();
        
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('brand', 'like', '%' . $request->search . '%');
        }
        
        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }
        
        $dataproduk = $query->orderBy('id', 'asc')->paginate(10);
        $dataproduk->appends($request->query());
        
        return view('admin.dataproduk.index', compact('dataproduk'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:100',
            'category' => 'required|string|in:skincare,makeup,obat,krim,sabun,lainnya',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        $productData = [
            'name' => $request->name,
            'brand' => $request->brand,
            'category' => $request->category,
            'description' => $request->description,
        ];
        
        // PERBAIKAN: Gunakan move() ke public/images/product
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/product'), $imageName);
            $productData['image_path'] = 'images/product/' . $imageName;
        }
        
        ProductModel::create($productData);
        
        $page = $request->page ?? 1;
        return redirect()->route('admin.dataproduk.index', ['page' => $page])
                         ->with('success', 'Produk berhasil ditambahkan!');
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:100',
            'category' => 'required|string|in:skincare,makeup,obat,krim,sabun,lainnya',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        $product = ProductModel::findOrFail($id);
        
        $productData = [
            'name' => $request->name,
            'brand' => $request->brand,
            'category' => $request->category,
            'description' => $request->description,
        ];
        
        // PERBAIKAN: Gunakan move() dan unlink()
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image_path && file_exists(public_path($product->image_path))) {
                unlink(public_path($product->image_path));
            }
            
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/product'), $imageName);
            $productData['image_path'] = 'images/product/' . $imageName;
        }
        
        $product->update($productData);
        
        $page = $request->page ?? 1;
        return redirect()->route('admin.dataproduk.index', ['page' => $page])
                         ->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(Request $request, string $id)
    {
        $product = ProductModel::findOrFail($id);
        
        // PERBAIKAN: Gunakan unlink() bukan Storage
        if ($product->image_path && file_exists(public_path($product->image_path))) {
            unlink(public_path($product->image_path));
        }
        
        $product->delete();
        
        $page = $request->page ?? 1;
        return redirect()->route('admin.dataproduk.index', ['page' => $page])
                         ->with('success', 'Produk berhasil dihapus!');
    }
}