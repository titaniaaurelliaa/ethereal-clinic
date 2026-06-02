<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminNewsController extends Controller
{
    /**
     * Display a paginated list of all news articles.
     */
public function index(Request $request)
    {
        $query = News::with('user')->latest();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        /** @var \Illuminate\Pagination\LengthAwarePaginator $newsList */
        $newsList = $query->paginate(10)->withQueryString();

        return view('Admin.news.index', compact('newsList'));
    }

    /**
     * Show the form for creating a new news article.
     */
    public function create()
    {
        return view('Admin.news.create');
    }

    /**
     * Store a newly created news article in the database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'      => 'required|string|max:255',
            'content'    => 'required|string',
            'image_path' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'title.required'   => 'Judul berita wajib diisi.',
            'content.required' => 'Konten berita wajib diisi.',
            'image_path.image' => 'File harus berupa gambar.',
            'image_path.max'   => 'Ukuran gambar maksimal 2MB.',
        ]);

        $imagePath = null;
        if ($request->hasFile('image_path')) {
            $file      = $request->file('image_path');
            $filename  = Str::slug($request->title) . '-' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/news'), $filename);
            $imagePath = 'images/news/' . $filename;
        }

        News::create([
            'title'      => $request->title,
            'slug'       => Str::slug($request->title),
            'content'    => $request->input('content'),
            'image_path' => $imagePath,
            'user_id'    => auth()->id(),
        ]);

        return redirect()->route('admin.news.index')
            ->with('success', 'Berita berhasil dipublikasikan.');
    }

    /**
     * Show the form for editing the specified news article.
     */
    public function edit(News $news)
    {
        return view('Admin.news.edit', compact('news'));
    }

    /**
     * Update the specified news article in the database.
     */
    public function update(Request $request, News $news)
    {
        $request->validate([
            'title'      => 'required|string|max:255',
            'content'    => 'required|string',
            'image_path' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'title.required'   => 'Judul berita wajib diisi.',
            'content.required' => 'Konten berita wajib diisi.',
            'image_path.image' => 'File harus berupa gambar.',
            'image_path.max'   => 'Ukuran gambar maksimal 2MB.',
        ]);

        $imagePath = $news->image_path; // Keep existing image by default

        if ($request->hasFile('image_path')) {
            // Delete old image from public disk if it exists
            if ($news->image_path && file_exists(public_path($news->image_path))) {
                unlink(public_path($news->image_path));
            }

            $file      = $request->file('image_path');
            $filename  = Str::slug($request->title) . '-' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/news'), $filename);
            $imagePath = 'images/news/' . $filename;
        }

        $news->update([
            'title'      => $request->title,
            'slug'       => Str::slug($request->title),
            'content'    => $request->input('content'),
            'image_path' => $imagePath,
        ]);

        return redirect()->route('admin.news.index')
            ->with('success', 'Berita berhasil diperbarui.');
    }

    /**
     * Remove the specified news article from the database.
     */
    public function destroy(News $news)
    {
        // Delete associated image file from disk
        if ($news->image_path && file_exists(public_path($news->image_path))) {
            unlink(public_path($news->image_path));
        }

        $news->delete();

        return redirect()->route('admin.news.index')
            ->with('success', 'Berita berhasil dihapus.');
    }
}
