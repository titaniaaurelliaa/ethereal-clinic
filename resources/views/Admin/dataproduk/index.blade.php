@extends('layouts_admin.app')
@section('title', 'Data Produk')
@section('content')
<div class="container">

    {{-- ─── HEADER ──────────────────────────────────────────────────────── --}}
    <div class="flex flex-wrap justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-[#5D605C]">Data Produk</h1>
            <p class="text-sm text-gray-400 mt-0.5">Manajemen produk skincare & obat yang direkomendasikan sistem</p>
        </div>
        <button onclick="openModal('addModal')"
            class="bg-[#7B5556] text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow-sm hover:bg-[#6a494a] transition-colors">
            + Tambah Produk
        </button>
    </div>

    {{-- ─── FILTER BAR ──────────────────────────────────────────────────── --}}
    <div class="bg-white rounded-2xl border border-[#E1E3DE] p-4 mb-5 flex flex-wrap gap-3">
        <form method="GET" action="{{ route('admin.dataproduk.index') }}" class="flex flex-wrap gap-3 w-full">
            <select name="category" class="px-3 py-2 border border-[#E1E3DE] rounded-xl text-sm text-[#5D605C] focus:outline-none focus:ring-2 focus:ring-[#7B5556]/30">
                <option value="">Semua Kategori</option>
                @foreach(['skincare'=>'Skincare','makeup'=>'Makeup','obat'=>'Obat','krim'=>'Krim','sabun'=>'Sabun','lainnya'=>'Lainnya'] as $val=>$lbl)
                    <option value="{{ $val }}" {{ request('category') == $val ? 'selected' : '' }}>{{ $lbl }}</option>
                @endforeach
            </select>
            <input type="text" name="search" placeholder="Cari nama / brand..." value="{{ request('search') }}"
                class="flex-1 px-3 py-2 border border-[#E1E3DE] rounded-xl text-sm text-[#5D605C] focus:outline-none focus:ring-2 focus:ring-[#7B5556]/30">
            <button type="submit" class="px-4 py-2 bg-[#7B5556] text-white rounded-xl text-sm font-semibold hover:bg-[#6a494a] transition-colors">
                Cari
            </button>
            @if(request('search') || request('category'))
                <a href="{{ route('admin.dataproduk.index') }}" class="px-4 py-2 bg-[#E1E3DE] text-[#5D605C] rounded-xl text-sm font-semibold hover:bg-gray-200 transition-colors">
                    Reset
                </a>
            @endif
        </form>
    </div>

    {{-- ─── TABLE ───────────────────────────────────────────────────────── --}}
    <div class="bg-white rounded-2xl border border-[#E1E3DE] overflow-hidden">
        <div class="px-6 py-4 border-b border-[#E1E3DE] flex items-center justify-between">
            <h3 class="font-semibold text-[#5D605C]">Daftar Produk</h3>
            <span class="text-xs text-gray-400">Total: {{ $dataproduk->total() }}</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-[#EBDBDD]/30 text-[#5D605C] uppercase text-xs tracking-wider">
                    <tr>
                        <th class="p-4 text-left">ID</th>
                        <th class="p-4 text-left">Gambar</th>
                        <th class="p-4 text-left">Nama Produk</th>
                        <th class="p-4 text-left">Brand</th>
                        <th class="p-4 text-left">Kategori</th>
                        <th class="p-4 text-left">Indikasi Masalah</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E1E3DE]/60">
                    @forelse ($dataproduk as $item)
                        @php
                            $categoryLabels = ['skincare'=>'Skincare','makeup'=>'Makeup','obat'=>'Obat','krim'=>'Krim','sabun'=>'Sabun','lainnya'=>'Lainnya'];
                            $categoryColor  = ['skincare'=>'bg-green-50 text-green-700','makeup'=>'bg-purple-50 text-purple-700','obat'=>'bg-red-50 text-red-700','krim'=>'bg-blue-50 text-blue-700','sabun'=>'bg-yellow-50 text-yellow-700','lainnya'=>'bg-gray-50 text-gray-600'];
                        @endphp
                        <tr class="hover:bg-[#EBDBDD]/10 transition-colors">
                            <td class="p-4">
                                <span class="bg-[#EBDBDD] text-[#7B5556] px-2 py-1 rounded-md text-xs font-bold">
                                    P{{ str_pad($item->id, 3, '0', STR_PAD_LEFT) }}
                                </span>
                            </td>
                            <td class="p-4">
                                @if($item->image_path && file_exists(public_path($item->image_path)))
                                    <img src="{{ asset($item->image_path) }}" alt="{{ $item->name }}"
                                         class="w-12 h-12 object-cover rounded-xl border border-[#E1E3DE]">
                                @else
                                    <div class="w-12 h-12 bg-[#E1E3DE]/50 rounded-xl flex items-center justify-center">
                                        <span class="text-[#A8ABA7] text-[10px] font-medium">No img</span>
                                    </div>
                                @endif
                            </td>
                            <td class="p-4 font-semibold text-[#5D605C]">{{ $item->name }}</td>
                            <td class="p-4 text-gray-500 text-xs">{{ $item->brand }}</td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 {{ $categoryColor[$item->category] ?? 'bg-gray-50 text-gray-600' }} rounded-lg text-xs font-medium">
                                    {{ $categoryLabels[$item->category] ?? $item->category }}
                                </span>
                            </td>
                            <td class="p-4">
                                <div class="flex flex-wrap gap-1">
                                    @forelse($item->skinProblems as $sp)
                                        <span class="text-[10px] px-2 py-0.5 bg-[#EBDBDD]/60 text-[#7B5556] rounded-md font-medium">
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
                                        onclick="openEditModal({{ $item->id }}, @js($item->name), @js($item->brand), @js($item->description), @js($item->category), @js($item->image_path), @js($item->skinProblems->pluck('id')))"
                                        class="px-3 py-1.5 text-xs bg-[#EBDBDD] text-[#7B5556] rounded-lg hover:bg-[#7B5556] hover:text-white transition-colors font-medium">
                                        Edit
                                    </button>
                                    <button type="button"
                                        onclick="openDeleteModal({{ $item->id }}, @js($item->name))"
                                        class="px-3 py-1.5 text-xs bg-red-50 text-red-600 rounded-lg hover:bg-red-500 hover:text-white transition-colors font-medium">
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-10 text-center text-gray-400">
                                <div class="flex flex-col items-center gap-2">
                                    <svg class="w-10 h-10 text-[#E1E3DE]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                                    </svg>
                                    Data produk belum tersedia
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ─── PAGINATION ──────────────────────────────────────────────────── --}}
    <div class="mt-4">
        {{ $dataproduk->appends(request()->query())->links() }}
    </div>

</div>

{{-- ════════════════════════════════════════════════════════════════════════ --}}
{{-- MODAL TAMBAH                                                            --}}
{{-- ════════════════════════════════════════════════════════════════════════ --}}
<div id="addModal" class="fixed inset-0 hidden justify-center items-center z-50" style="background-color:rgba(0,0,0,0.35);">
    <div class="bg-white rounded-2xl w-[560px] shadow-xl border border-[#E1E3DE] max-h-[90vh] overflow-y-auto">
        <div class="px-6 py-5 border-b border-[#E1E3DE] flex items-center justify-between">
            <h2 class="text-base font-bold text-[#5D605C]">Tambah Produk</h2>
            <button onclick="closeModal('addModal')" class="text-gray-400 hover:text-gray-600 text-xl leading-none">&times;</button>
        </div>

        <form action="{{ route('admin.dataproduk.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
            @csrf
            <input type="hidden" name="page" id="addPage" value="{{ request()->get('page', 1) }}">

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-[#5D605C] mb-1">Nama Produk <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="addName" placeholder="Nama produk"
                        class="w-full border border-[#E1E3DE] rounded-xl p-2.5 text-sm text-[#5D605C] focus:outline-none focus:ring-2 focus:ring-[#7B5556]/30">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-[#5D605C] mb-1">Brand <span class="text-red-500">*</span></label>
                    <input type="text" name="brand" id="addBrand" placeholder="Nama brand"
                        class="w-full border border-[#E1E3DE] rounded-xl p-2.5 text-sm text-[#5D605C] focus:outline-none focus:ring-2 focus:ring-[#7B5556]/30">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-[#5D605C] mb-1">Kategori <span class="text-red-500">*</span></label>
                <select name="category" id="addCategory"
                    class="w-full border border-[#E1E3DE] rounded-xl p-2.5 text-sm text-[#5D605C] focus:outline-none focus:ring-2 focus:ring-[#7B5556]/30">
                    <option value="">Pilih Kategori</option>
                    @foreach(['skincare'=>'Skincare','makeup'=>'Makeup','obat'=>'Obat','krim'=>'Krim','sabun'=>'Sabun','lainnya'=>'Lainnya'] as $val=>$lbl)
                        <option value="{{ $val }}">{{ $lbl }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-[#5D605C] mb-1">Deskripsi <span class="text-red-500">*</span></label>
                <textarea name="description" id="addDescription" rows="3" placeholder="Deskripsi produk"
                    class="w-full border border-[#E1E3DE] rounded-xl p-2.5 text-sm text-[#5D605C] focus:outline-none focus:ring-2 focus:ring-[#7B5556]/30"></textarea>
            </div>

            {{-- Upload Gambar --}}
            <div>
                <label class="block text-xs font-semibold text-[#5D605C] mb-2">Gambar Produk</label>
                <div class="border-2 border-dashed border-[#E1E3DE] rounded-xl px-4 py-6 text-center hover:border-[#7B5556]/40 transition-colors cursor-pointer" id="uploadAreaAdd">
                    <svg class="mx-auto h-8 w-8 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                    <label for="addImage" class="cursor-pointer text-sm text-[#7B5556] font-medium hover:underline">
                        Klik untuk upload
                        <input id="addImage" name="image" type="file" class="sr-only" accept="image/*" onchange="previewImg(event,'addPreviewImg','addPreviewBox')">
                    </label>
                    <p class="text-xs text-gray-400 mt-1">PNG, JPG, GIF — Max 2MB</p>
                </div>
                <div id="addPreviewBox" class="hidden mt-2 flex items-center gap-2">
                    <img id="addPreviewImg" src="#" class="w-16 h-16 object-cover rounded-xl border border-[#E1E3DE]">
                    <button type="button" onclick="clearImg('addImage','addPreviewBox')" class="text-xs text-red-500 hover:underline">Hapus</button>
                </div>
            </div>

            {{-- Indikasi Masalah Kulit --}}
            <div>
                <label class="block text-xs font-semibold text-[#5D605C] mb-2">Indikasi Masalah Kulit</label>
                <div class="grid grid-cols-2 gap-2">
                    @foreach($skinProblems as $sp)
                        <label class="flex items-center gap-2 border border-[#E1E3DE] rounded-xl px-3 py-2 cursor-pointer hover:border-[#7B5556]/40 transition-colors has-[:checked]:border-[#7B5556] has-[:checked]:bg-[#EBDBDD]/30">
                            <input type="checkbox" name="skin_problems[]" value="{{ $sp->id }}"
                                class="w-4 h-4 accent-[#7B5556]">
                            <span class="text-xs font-medium text-[#5D605C]">{{ $sp->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <p id="addError" class="hidden text-sm text-red-500"></p>

            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="closeModal('addModal')" class="px-4 py-2 rounded-xl bg-[#E1E3DE] text-[#5D605C] text-sm font-semibold hover:bg-gray-200 transition-colors">Batal</button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-[#7B5556] text-white text-sm font-semibold hover:bg-[#6a494a] transition-colors">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- ════════════════════════════════════════════════════════════════════════ --}}
{{-- MODAL EDIT                                                              --}}
{{-- ════════════════════════════════════════════════════════════════════════ --}}
<div id="editModal" class="fixed inset-0 bg-black/40 hidden justify-center items-center z-50">
    <div class="bg-white rounded-2xl w-[560px] shadow-xl border border-[#E1E3DE] max-h-[90vh] overflow-y-auto">
        <div class="px-6 py-5 border-b border-[#E1E3DE] flex items-center justify-between">
            <h2 class="text-base font-bold text-[#5D605C]">Edit Produk</h2>
            <button onclick="closeModal('editModal')" class="text-gray-400 hover:text-gray-600 text-xl leading-none">&times;</button>
        </div>

        <form id="editForm" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
            @csrf
            @method('PUT')
            <input type="hidden" name="page" id="editPage" value="{{ request()->get('page', 1) }}">

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-[#5D605C] mb-1">Nama Produk <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="editName"
                        class="w-full border border-[#E1E3DE] rounded-xl p-2.5 text-sm text-[#5D605C] focus:outline-none focus:ring-2 focus:ring-[#7B5556]/30">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-[#5D605C] mb-1">Brand <span class="text-red-500">*</span></label>
                    <input type="text" name="brand" id="editBrand"
                        class="w-full border border-[#E1E3DE] rounded-xl p-2.5 text-sm text-[#5D605C] focus:outline-none focus:ring-2 focus:ring-[#7B5556]/30">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-[#5D605C] mb-1">Kategori <span class="text-red-500">*</span></label>
                <select name="category" id="editCategory"
                    class="w-full border border-[#E1E3DE] rounded-xl p-2.5 text-sm text-[#5D605C] focus:outline-none focus:ring-2 focus:ring-[#7B5556]/30">
                    @foreach(['skincare'=>'Skincare','makeup'=>'Makeup','obat'=>'Obat','krim'=>'Krim','sabun'=>'Sabun','lainnya'=>'Lainnya'] as $val=>$lbl)
                        <option value="{{ $val }}">{{ $lbl }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-[#5D605C] mb-1">Deskripsi <span class="text-red-500">*</span></label>
                <textarea name="description" id="editDescription" rows="3"
                    class="w-full border border-[#E1E3DE] rounded-xl p-2.5 text-sm text-[#5D605C] focus:outline-none focus:ring-2 focus:ring-[#7B5556]/30"></textarea>
            </div>

            {{-- Gambar existing + upload baru --}}
            <div>
                <label class="block text-xs font-semibold text-[#5D605C] mb-2">Gambar Produk</label>
                <div id="editCurrentImgBox" class="hidden mb-2 flex items-center gap-2">
                    <img id="editCurrentImg" src="#" class="w-16 h-16 object-cover rounded-xl border border-[#E1E3DE]">
                    <span class="text-xs text-gray-400">Gambar saat ini</span>
                </div>
                <div class="border-2 border-dashed border-[#E1E3DE] rounded-xl px-4 py-5 text-center hover:border-[#7B5556]/40 transition-colors cursor-pointer">
                    <label for="editImage" class="cursor-pointer text-sm text-[#7B5556] font-medium hover:underline">
                        Upload gambar baru (opsional)
                        <input id="editImage" name="image" type="file" class="sr-only" accept="image/*" onchange="previewImg(event,'editPreviewImg','editPreviewBox')">
                    </label>
                    <p class="text-xs text-gray-400 mt-1">PNG, JPG, GIF — Max 2MB. Kosongkan jika tidak diubah.</p>
                </div>
                <div id="editPreviewBox" class="hidden mt-2 flex items-center gap-2">
                    <img id="editPreviewImg" src="#" class="w-16 h-16 object-cover rounded-xl border border-[#E1E3DE]">
                    <button type="button" onclick="clearImg('editImage','editPreviewBox')" class="text-xs text-red-500 hover:underline">Batal</button>
                </div>
            </div>

            {{-- Indikasi Masalah Kulit --}}
            <div>
                <label class="block text-xs font-semibold text-[#5D605C] mb-2">Indikasi Masalah Kulit</label>
                <div id="editSkinProblemCheckboxes" class="grid grid-cols-2 gap-2">
                    @foreach($skinProblems as $sp)
                        <label class="flex items-center gap-2 border border-[#E1E3DE] rounded-xl px-3 py-2 cursor-pointer hover:border-[#7B5556]/40 transition-colors has-[:checked]:border-[#7B5556] has-[:checked]:bg-[#EBDBDD]/30 sp-edit-label">
                            <input type="checkbox" name="skin_problems[]" value="{{ $sp->id }}"
                                class="w-4 h-4 accent-[#7B5556] sp-edit-cb" data-sp-id="{{ $sp->id }}">
                            <span class="text-xs font-medium text-[#5D605C]">{{ $sp->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <p id="editError" class="hidden text-sm text-red-500"></p>

            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="closeModal('editModal')" class="px-4 py-2 rounded-xl bg-[#E1E3DE] text-[#5D605C] text-sm font-semibold hover:bg-gray-200 transition-colors">Batal</button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-[#7B5556] text-white text-sm font-semibold hover:bg-[#6a494a] transition-colors">Update</button>
            </div>
        </form>
    </div>
</div>

{{-- ════════════════════════════════════════════════════════════════════════ --}}
{{-- MODAL HAPUS                                                             --}}
{{-- ════════════════════════════════════════════════════════════════════════ --}}
<div id="deleteModal" class="fixed inset-0 bg-black/40 hidden justify-center items-center z-50">
    <div class="bg-white rounded-2xl w-96 p-6 shadow-xl border border-[#E1E3DE]">
        <div class="w-14 h-14 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-red-200">
            <span class="text-red-500 text-2xl font-bold">!</span>
        </div>
        <h2 class="text-base font-bold text-[#5D605C] text-center mb-2">Hapus Produk?</h2>
        <p class="text-sm text-gray-400 text-center mb-6">
            Yakin ingin menghapus <span id="deleteName" class="font-semibold text-[#5D605C]"></span>?
            Data yang sudah dihapus tidak dapat dikembalikan.
        </p>
        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')
            <input type="hidden" name="page" id="deletePage" value="{{ request()->get('page', 1) }}">
            <div class="flex justify-center gap-3">
                <button type="button" onclick="closeModal('deleteModal')" class="px-5 py-2 rounded-xl bg-[#E1E3DE] text-[#5D605C] text-sm font-semibold hover:bg-gray-200">Batal</button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-red-500 text-white text-sm font-semibold hover:bg-red-600">Ya, Hapus</button>
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
    ['addName','addBrand','addDescription'].forEach(id => { const el=document.getElementById(id); if(el) el.value=''; });
    document.getElementById('addCategory').value='';
    document.getElementById('addImage').value='';
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

function openEditModal(id, name, brand, description, category, imagePath, skinProblemIds) {
    document.getElementById('editName').value        = name;
    document.getElementById('editBrand').value       = brand;
    document.getElementById('editDescription').value = description;
    document.getElementById('editCategory').value    = category;
    document.getElementById('editPage').value        = getCurrentPage();

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