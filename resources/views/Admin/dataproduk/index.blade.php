@extends('layouts_admin.app')
@section('title', 'Data Produk')
@section('content')
<div class="container">

    {{-- HEADER --}}
    <div class="flex flex-wrap justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Data Produk</h1>
        
        <button onclick="openModal('addModal')" class="bg-pink-500 text-white px-4 py-2 rounded-lg shadow hover:bg-pink-600 transition">
            + Tambah Produk
        </button>
    </div>

    {{-- FILTER BAR --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-4 mb-5 shadow-sm">
        <form method="GET" action="{{ route('admin.dataproduk.index') }}" class="flex flex-wrap gap-3">
            <select name="category" class="px-3 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-pink-400">
                <option value="">Semua Kategori</option>
                <option value="cleanser" {{ request('category') == 'cleanser' ? 'selected' : '' }}>Cleanser (Pembersih)</option>
                <option value="exfoliator" {{ request('category') == 'exfoliator' ? 'selected' : '' }}>Exfoliator (Eksfoliator)</option>
                <option value="toner" {{ request('category') == 'toner' ? 'selected' : '' }}>Toner</option>
                <option value="essence_serum" {{ request('category') == 'essence_serum' ? 'selected' : '' }}>Essence/Serum</option>
                <option value="moisturizer" {{ request('category') == 'moisturizer' ? 'selected' : '' }}>Moisturizer (Pelembab)</option>
                <option value="sunscreen" {{ request('category') == 'sunscreen' ? 'selected' : '' }}>Sunscreen (Tabir Surya)</option>
                <option value="masker" {{ request('category') == 'masker' ? 'selected' : '' }}>Masker (Wajah)</option>
                <option value="cream" {{ request('category') == 'cream' ? 'selected' : '' }}>Cream (Krim)</option>
                <option value="obat" {{ request('category') == 'obat' ? 'selected' : '' }}>Obat (Resep Dokter)</option>
            </select>
            <input type="text" name="search" placeholder="Cari nama / brand..." value="{{ request('search') }}"
                class="flex-1 min-w-[180px] px-3 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-pink-400">
            <button type="submit" class="px-4 py-2 bg-pink-500 text-white rounded-lg hover:bg-pink-600 transition">
                <i class="fas fa-search"></i> Cari
            </button>
            @if(request('search') || request('category'))
                <a href="{{ route('admin.dataproduk.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                    <i class="fas fa-times"></i> Reset
                </a>
            @endif
        </form>
    </div>

    {{-- TABLE --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50">
            <h3 class="font-semibold text-gray-700">Daftar Produk</h3>
            <span class="text-xs text-gray-400">Total: {{ $dataproduk->total() }}</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-pink-50 text-gray-600 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="p-4 text-left">ID</th>
                        <th class="p-4 text-left">Gambar</th>
                        <th class="p-4 text-left">Nama Produk</th>
                        <th class="p-4 text-left">Brand</th>
                        <th class="p-4 text-left">Kategori</th>
                        <th class="p-4 text-left">Deskripsi</th>
                        <th class="p-4 text-left">Cara Penggunaan</th>
                        <th class="p-4 text-left">Indikasi Masalah</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($dataproduk as $item)
                        @php
                            $categoryLabels = [
                                'cleanser' => 'Cleanser (Pembersih)',
                                'exfoliator' => 'Exfoliator (Eksfoliator)',
                                'toner' => 'Toner',
                                'essence_serum' => 'Essence/Serum',
                                'moisturizer' => 'Moisturizer (Pelembab)',
                                'sunscreen' => 'Sunscreen (Tabir Surya)',
                                'masker' => 'Masker (Wajah)',
                                'cream' => 'Cream (Krim)',
                                'obat' => 'Obat (Resep Dokter)'
                            ];
                            $categoryColor = [
                                'cleanser' => 'bg-blue-100 text-blue-600',
                                'exfoliator' => 'bg-purple-100 text-purple-600',
                                'toner' => 'bg-green-100 text-green-600',
                                'essence_serum' => 'bg-pink-100 text-pink-600',
                                'moisturizer' => 'bg-yellow-100 text-yellow-600',
                                'sunscreen' => 'bg-orange-100 text-orange-600',
                                'masker' => 'bg-indigo-100 text-indigo-600',
                                'cream' => 'bg-rose-100 text-rose-600',
                                'obat' => 'bg-red-100 text-red-600'
                            ];
                        @endphp
                        <tr class="hover:bg-pink-50 transition">
                            <td class="p-4">
                                <span class="bg-pink-100 text-pink-600 px-2 py-1 rounded-md text-xs font-semibold">
                                    P{{ str_pad($item->id, 3, '0', STR_PAD_LEFT) }}
                                </span>
                            </td>
                            <td class="p-4">
                                @if($item->image_path && file_exists(public_path($item->image_path)))
                                    <img src="{{ asset($item->image_path) }}" alt="{{ $item->name }}"
                                         class="w-12 h-12 object-cover rounded-lg">
                                @else
                                    <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </td>
                            <td class="p-4 font-semibold text-gray-800">{{ $item->name }}</td>
                            <td class="p-4 text-gray-500 text-xs">{{ $item->brand }}</td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 {{ $categoryColor[$item->category] ?? 'bg-gray-100 text-gray-600' }} rounded-lg text-xs font-medium">
                                    {{ $categoryLabels[$item->category] ?? $item->category }}
                                </span>
                            </td>
                            <td class="p-4 text-gray-500 max-w-xs">
                                {{ \Illuminate\Support\Str::limit($item->description, 50) }}
                            </td>
                            <td class="p-4 text-gray-500 max-w-xs">
                                {{ \Illuminate\Support\Str::limit($item->how_to_use ?? '-', 50) }}
                            </td>
                            <td class="p-4">
                                <div class="flex flex-wrap gap-1">
                                    @forelse($item->skinProblems as $sp)
                                        <span class="text-[10px] px-2 py-0.5 bg-pink-100 text-pink-600 rounded-md font-medium">
                                            {{ $sp->name }}
                                        </span>
                                    @empty
                                        <span class="text-[10px] text-gray-300 italic">—</span>
                                    @endforelse
                                </div>
                            </td>
                            <td class="p-4 text-center">
                                <div class="flex justify-center gap-2">
                                    <button type="button"
                                        onclick="openEditModal({{ $item->id }}, @js($item->name), @js($item->brand), @js($item->description), @js($item->category), @js($item->image_path), @js($item->how_to_use), @js($item->skinProblems->pluck('id')))"
                                        class="px-3 py-1 text-xs bg-pink-100 text-pink-600 rounded-lg hover:bg-pink-200 transition">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <button type="button"
                                        onclick="openDeleteModal({{ $item->id }}, @js($item->name))"
                                        class="px-3 py-1 text-xs bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="p-10 text-center text-gray-400">
                                <i class="fas fa-inbox text-2xl mb-2 block"></i>
                                Data produk belum tersedia
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $dataproduk->appends(request()->query())->links() }}
    </div>

</div>

{{-- MODAL TAMBAH --}}
<div id="addModal" class="fixed inset-0 hidden justify-center items-center z-50" style="background-color: rgba(0, 0, 0, 0.35);">
    <div class="bg-white rounded-2xl w-[560px] shadow-xl border border-gray-100 max-h-[90vh] overflow-y-auto">
        <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
            <h2 class="text-base font-bold text-gray-800">Tambah Produk</h2>
            <button onclick="closeModal('addModal')" class="text-gray-400 hover:text-gray-600 text-xl leading-none">&times;</button>
        </div>

        <form action="{{ route('admin.dataproduk.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
            @csrf
            <input type="hidden" name="page" id="addPage" value="{{ request()->get('page', 1) }}">

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Nama Produk <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="addName" placeholder="Nama produk"
                        class="w-full border border-gray-200 rounded-xl p-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-pink-400">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Brand <span class="text-red-500">*</span></label>
                    <input type="text" name="brand" id="addBrand" placeholder="Nama brand"
                        class="w-full border border-gray-200 rounded-xl p-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-pink-400">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">Kategori <span class="text-red-500">*</span></label>
                <select name="category" id="addCategory"
                    class="w-full border border-gray-200 rounded-xl p-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-pink-400">
                    <option value="">Pilih Kategori</option>
                    <option value="cleanser">Cleanser (Pembersih)</option>
                    <option value="exfoliator">Exfoliator (Eksfoliator)</option>
                    <option value="toner">Toner</option>
                    <option value="essence_serum">Essence/Serum</option>
                    <option value="moisturizer">Moisturizer (Pelembab)</option>
                    <option value="sunscreen">Sunscreen (Tabir Surya)</option>
                    <option value="masker">Masker (Wajah)</option>
                    <option value="cream">Cream (Krim)</option>
                    <option value="obat">Obat (Resep Dokter)</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">Deskripsi <span class="text-red-500">*</span></label>
                <textarea name="description" id="addDescription" rows="3" placeholder="Deskripsi produk"
                    class="w-full border border-gray-200 rounded-xl p-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-pink-400"></textarea>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">Cara Penggunaan</label>
                <textarea name="how_to_use" id="addHowToUse" rows="2" placeholder="Cara penggunaan produk (contoh: Gunakan 2 kali sehari, pagi dan malam)"
                    class="w-full border border-gray-200 rounded-xl p-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-pink-400"></textarea>
                <p class="text-xs text-gray-400 mt-1">Opsional, kosongkan jika tidak ada</p>
            </div>

            {{-- Upload Gambar --}}
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-2">Gambar Produk</label>
                <div class="border-2 border-dashed border-gray-200 rounded-xl px-4 py-6 text-center hover:border-pink-400 transition-colors cursor-pointer">
                    <svg class="mx-auto h-8 w-8 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                    <label for="addImage" class="cursor-pointer text-sm text-pink-500 font-medium hover:underline">
                        Klik untuk upload
                        <input id="addImage" name="image" type="file" class="sr-only" accept="image/*" onchange="previewImg(event,'addPreviewImg','addPreviewBox')">
                    </label>
                    <p class="text-xs text-gray-400 mt-1">PNG, JPG, GIF — Max 2MB</p>
                </div>
                <div id="addPreviewBox" class="hidden mt-2 flex items-center gap-2">
                    <img id="addPreviewImg" src="#" class="w-16 h-16 object-cover rounded-xl border border-gray-200">
                    <button type="button" onclick="clearImg('addImage','addPreviewBox')" class="text-xs text-red-500 hover:underline">Hapus</button>
                </div>
            </div>

            {{-- Indikasi Masalah Kulit --}}
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-2">Indikasi Masalah Kulit</label>
                <div class="grid grid-cols-2 gap-2">
                    @foreach($skinProblems as $sp)
                        <label class="flex items-center gap-2 border border-gray-200 rounded-xl px-3 py-2 cursor-pointer hover:border-pink-400 transition-colors has-[:checked]:border-pink-500 has-[:checked]:bg-pink-50">
                            <input type="checkbox" name="skin_problems[]" value="{{ $sp->id }}"
                                class="w-4 h-4 accent-pink-500">
                            <span class="text-xs font-medium text-gray-700">{{ $sp->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <p id="addError" class="hidden text-sm text-red-500"></p>

            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="closeModal('addModal')" class="px-4 py-2 rounded-xl bg-gray-200 text-gray-600 text-sm font-semibold hover:bg-gray-300 transition-colors">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-pink-500 text-white text-sm font-semibold hover:bg-pink-600 transition-colors">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL EDIT --}}
<div id="editModal" class="fixed inset-0 bg-black/40 hidden justify-center items-center z-50">
    <div class="bg-white rounded-2xl w-[560px] shadow-xl border border-pink-100 max-h-[90vh] overflow-y-auto">
        <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
            <h2 class="text-base font-bold text-gray-800">Edit Produk</h2>
            <button onclick="closeModal('editModal')" class="text-gray-400 hover:text-gray-600 text-xl leading-none">&times;</button>
        </div>

        <form id="editForm" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
            @csrf
            @method('PUT')
            <input type="hidden" name="page" id="editPage" value="{{ request()->get('page', 1) }}">

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Nama Produk <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="editName"
                        class="w-full border border-gray-200 rounded-xl p-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-pink-400">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Brand <span class="text-red-500">*</span></label>
                    <input type="text" name="brand" id="editBrand"
                        class="w-full border border-gray-200 rounded-xl p-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-pink-400">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">Kategori <span class="text-red-500">*</span></label>
                <select name="category" id="editCategory"
                    class="w-full border border-gray-200 rounded-xl p-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-pink-400">
                    <option value="cleanser">Cleanser (Pembersih)</option>
                    <option value="exfoliator">Exfoliator (Eksfoliator)</option>
                    <option value="toner">Toner</option>
                    <option value="essence_serum">Essence/Serum</option>
                    <option value="moisturizer">Moisturizer (Pelembab)</option>
                    <option value="sunscreen">Sunscreen (Tabir Surya)</option>
                    <option value="masker">Masker (Wajah)</option>
                    <option value="cream">Cream (Krim)</option>
                    <option value="obat">Obat (Resep Dokter)</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">Deskripsi <span class="text-red-500">*</span></label>
                <textarea name="description" id="editDescription" rows="3"
                    class="w-full border border-gray-200 rounded-xl p-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-pink-400"></textarea>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">Cara Penggunaan</label>
                <textarea name="how_to_use" id="editHowToUse" rows="2"
                    class="w-full border border-gray-200 rounded-xl p-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-pink-400"></textarea>
                <p class="text-xs text-gray-400 mt-1">Cara penggunaan produk (opsional)</p>
            </div>

            {{-- Gambar existing + upload baru --}}
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-2">Gambar Produk</label>
                <div id="editCurrentImgBox" class="hidden mb-2 flex items-center gap-2">
                    <img id="editCurrentImg" src="#" class="w-16 h-16 object-cover rounded-xl border border-gray-200">
                    <span class="text-xs text-gray-400">Gambar saat ini</span>
                </div>
                <div class="border-2 border-dashed border-gray-200 rounded-xl px-4 py-5 text-center hover:border-pink-400 transition-colors cursor-pointer">
                    <label for="editImage" class="cursor-pointer text-sm text-pink-500 font-medium hover:underline">
                        Upload gambar baru (opsional)
                        <input id="editImage" name="image" type="file" class="sr-only" accept="image/*" onchange="previewImg(event,'editPreviewImg','editPreviewBox')">
                    </label>
                    <p class="text-xs text-gray-400 mt-1">PNG, JPG, GIF — Max 2MB. Kosongkan jika tidak diubah.</p>
                </div>
                <div id="editPreviewBox" class="hidden mt-2 flex items-center gap-2">
                    <img id="editPreviewImg" src="#" class="w-16 h-16 object-cover rounded-xl border border-gray-200">
                    <button type="button" onclick="clearImg('editImage','editPreviewBox')" class="text-xs text-red-500 hover:underline">Batal</button>
                </div>
            </div>

            {{-- Indikasi Masalah Kulit --}}
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-2">Indikasi Masalah Kulit</label>
                <div id="editSkinProblemCheckboxes" class="grid grid-cols-2 gap-2">
                    @foreach($skinProblems as $sp)
                        <label class="flex items-center gap-2 border border-gray-200 rounded-xl px-3 py-2 cursor-pointer hover:border-pink-400 transition-colors has-[:checked]:border-pink-500 has-[:checked]:bg-pink-50 sp-edit-label">
                            <input type="checkbox" name="skin_problems[]" value="{{ $sp->id }}"
                                class="w-4 h-4 accent-pink-500 sp-edit-cb" data-sp-id="{{ $sp->id }}">
                            <span class="text-xs font-medium text-gray-700">{{ $sp->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <p id="editError" class="hidden text-sm text-red-500"></p>

            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="closeModal('editModal')" class="px-4 py-2 rounded-xl bg-gray-200 text-gray-600 text-sm font-semibold hover:bg-gray-300 transition-colors">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-pink-500 text-white text-sm font-semibold hover:bg-pink-600 transition-colors">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL HAPUS --}}
<div id="deleteModal" class="fixed inset-0 bg-black/40 hidden justify-center items-center z-50">
    <div class="bg-white rounded-2xl w-96 p-6 shadow-xl border border-red-100">
        <div class="w-14 h-14 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <span class="text-red-600 text-2xl font-bold">!</span>
        </div>
        <h2 class="text-lg font-bold text-gray-800 text-center mb-2">Hapus Produk?</h2>
        <p class="text-sm text-gray-500 text-center mb-6">
            Apakah Anda yakin ingin menghapus produk
            <span id="deleteName" class="font-semibold text-gray-700"></span>?
            Data yang sudah dihapus tidak dapat dikembalikan.
        </p>
        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')
            <input type="hidden" name="page" id="deletePage" value="{{ request()->get('page', 1) }}">
            <div class="flex justify-center gap-2">
                <button type="button" onclick="closeModal('deleteModal')"
                    class="px-4 py-2 rounded-lg bg-gray-100 text-gray-600 hover:bg-gray-200">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 rounded-lg bg-red-500 text-white hover:bg-red-600 shadow">
                    Ya, Hapus
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function getCurrentPage() {
    return new URLSearchParams(window.location.search).get('page') || 1;
}

function openModal(id) {
    const modal = document.getElementById(id);
    if (!modal) return;
    if (id === 'addModal') { document.getElementById('addPage').value = getCurrentPage(); resetAddForm(); }
    if (id === 'deleteModal') { document.getElementById('deletePage').value = getCurrentPage(); }
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeModal(id) {
    const modal = document.getElementById(id);
    if (!modal) return;
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

function resetAddForm() {
    document.getElementById('addName').value = '';
    document.getElementById('addBrand').value = '';
    document.getElementById('addDescription').value = '';
    document.getElementById('addHowToUse').value = '';
    document.getElementById('addCategory').value = '';
    document.getElementById('addImage').value = '';
    document.getElementById('addPreviewBox').classList.add('hidden');
    document.querySelectorAll('#addModal input[type="checkbox"]').forEach(cb => cb.checked = false);
    const err = document.getElementById('addError'); if(err) err.classList.add('hidden');
}

function previewImg(event, imgId, boxId) {
    const file = event.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById(imgId).src = e.target.result;
        document.getElementById(boxId).classList.remove('hidden');
    };
    reader.readAsDataURL(file);
}

function clearImg(inputId, boxId) {
    document.getElementById(inputId).value = '';
    document.getElementById(boxId).classList.add('hidden');
}

function openEditModal(id, name, brand, description, category, imagePath, howToUse, skinProblemIds) {
    document.getElementById('editName').value        = name;
    document.getElementById('editBrand').value       = brand;
    document.getElementById('editDescription').value = description;
    document.getElementById('editCategory').value    = category;
    document.getElementById('editPage').value        = getCurrentPage();
    
    const howToUseInput = document.getElementById('editHowToUse');
    if (howToUseInput) howToUseInput.value = howToUse || '';

    // Show current image
    const imgBox = document.getElementById('editCurrentImgBox');
    if (imagePath && imagePath !== 'null') {
        document.getElementById('editCurrentImg').src = '/' + imagePath;
        imgBox.classList.remove('hidden');
    } else {
        imgBox.classList.add('hidden');
    }

    // Reset new image preview
    document.getElementById('editImage').value = '';
    document.getElementById('editPreviewBox').classList.add('hidden');

    // Pre-check skin problem checkboxes
    document.querySelectorAll('.sp-edit-cb').forEach(cb => {
        cb.checked = skinProblemIds.includes(parseInt(cb.dataset.spId));
    });

    document.getElementById('editForm').action = '{{ url("/admin/dataproduk") }}/' + id;
    openModal('editModal');
}

function openDeleteModal(id, name) {
    document.getElementById('deleteName').textContent = name;
    document.getElementById('deletePage').value       = getCurrentPage();
    document.getElementById('deleteForm').action      = '{{ url("/admin/dataproduk") }}/' + id;
    openModal('deleteModal');
}
</script>
@endsection