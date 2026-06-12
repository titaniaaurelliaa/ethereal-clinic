@extends('layouts_admin.app')
@section('title', 'Manajemen Berita')

@section('content')
<div class="container">

    {{-- ─── SUCCESS TOAST ────────────────────────────────────────────────────── --}}
    @if(session('success'))
        <div id="successToast" class="mb-5 bg-green-50 border border-green-200 rounded-2xl px-5 py-4 flex items-center gap-3">
            <div class="w-7 h-7 bg-green-100 rounded-full flex items-center justify-center shrink-0">
                <svg class="w-4 h-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <span class="text-sm font-medium text-green-700">{{ session('success') }}</span>
        </div>
        <script>setTimeout(() => { const t = document.getElementById('successToast'); if(t) t.remove(); }, 4000);</script>
    @endif

    {{-- ─── HEADER ───────────────────────────────────────────────────────────── --}}
    <div class="flex flex-wrap justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-[#5D605C]">Manajemen Berita</h1>
            <p class="text-sm text-gray-400 mt-0.5">Kelola artikel dan berita kesehatan kulit untuk pasien</p>
        </div>
        <button onclick="openCreateModal()"
                class="bg-pink-500 text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow hover:bg-pink-600 transition-colors inline-flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            Tulis Berita Baru
        </button>
    </div>

    {{-- ─── FILTER BAR ────────────────────────────────────────────────────────── --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-4 mb-5 shadow-sm">
        <form method="GET" action="{{ route('admin.news.index') }}" class="flex flex-wrap gap-3">
            <input type="text" name="search" placeholder="Cari judul berita..."
                value="{{ request('search') }}"
                class="flex-1 min-w-[180px] px-3 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-pink-400">
            <button type="submit"
                class="px-4 py-2 bg-pink-500 text-white rounded-lg hover:bg-pink-600 transition">
                <i class="fas fa-search"></i> Cari
            </button>
            @if(request('search'))
                <a href="{{ route('admin.news.index') }}"
                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                    <i class="fas fa-times"></i> Reset
                </a>
            @endif
        </form>
    </div>

    {{-- ─── TABLE ─────────────────────────────────────────────────────────────── --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50">
            <h3 class="font-semibold text-gray-700">Daftar Artikel Berita</h3>
            <span class="text-xs text-gray-400">Total: {{ $newsList->total() }}</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-pink-50 text-gray-600 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="p-4 text-left">No</th>
                        <th class="p-4 text-left">Gambar</th>
                        <th class="p-4 text-left">Judul Berita</th>
                        <th class="p-4 text-left">Penulis</th>
                        <th class="p-4 text-left">Tanggal</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($newsList as $index => $item)
                        <tr class="hover:bg-pink-50 transition-colors">
                            <td class="p-4">
                                <span class="bg-pink-100 text-pink-600 px-2 py-1 rounded-md text-xs font-semibold">
                                    N{{ str_pad($item->id, 3, '0', STR_PAD_LEFT) }}
                                </span>
                            </td>
                            <td class="p-4">
                                @if($item->image_path && file_exists(public_path($item->image_path)))
                                    <img src="{{ asset($item->image_path) }}"
                                         alt="{{ $item->title }}"
                                         class="w-12 h-12 object-cover rounded-lg">
                                @else
                                    <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif
                            </td>
                            <td class="p-4 font-semibold text-gray-800 max-w-xs">
                                <p class="line-clamp-2 leading-snug">{{ $item->title }}</p>
                                <p class="text-[10px] text-gray-400 font-normal mt-0.5">{{ $item->slug }}</p>
                            </td>
                            <td class="p-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-full bg-pink-100 flex items-center justify-center shrink-0">
                                        <span class="text-[10px] font-bold text-pink-600 uppercase">
                                            {{ substr($item->user->name ?? 'A', 0, 1) }}
                                        </span>
                                    </div>
                                    <span class="text-xs text-gray-600">{{ $item->user->name ?? '—' }}</span>
                                </div>
                            </td>
                            <td class="p-4 text-xs text-gray-400">
                                {{ $item->created_at->format('d M Y') }}<br>
                                <span class="text-gray-300">{{ $item->created_at->format('H:i') }} WIB</span>
                            </td>
                            <td class="p-4 text-center">
                                <div class="flex justify-center gap-2">
                                    <button type="button"
                                        onclick="openEditModal({{ $item->id }}, @js($item->title), @js($item->content), @js($item->image_path))"
                                        class="px-3 py-1.5 text-xs bg-pink-100 text-pink-600 rounded-lg hover:bg-pink-500 hover:text-white transition-colors font-medium">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <button type="button"
                                        onclick="openDeleteModal({{ $item->id }}, @js($item->title))"
                                        class="px-3 py-1.5 text-xs bg-red-100 text-red-600 rounded-lg hover:bg-red-500 hover:text-white transition-colors font-medium">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-10 text-center text-gray-400">
                                <i class="fas fa-inbox text-2xl mb-2 block"></i>
                                Belum ada artikel berita. Mulai menulis sekarang.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $newsList->appends(request()->query())->links() }}
    </div>

</div>

{{-- ════════════════════════════════════════════════════════════════ --}}
{{-- MODAL CREATE BERITA --}}
{{-- ════════════════════════════════════════════════════════════════ --}}
<div id="createModal" class="fixed inset-0 hidden justify-center items-center z-50" style="background-color: rgba(0, 0, 0, 0.35);">
    <div class="bg-white rounded-2xl w-[700px] shadow-xl border border-gray-100 max-h-[90vh] overflow-y-auto">
        <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between sticky top-0 bg-white">
            <h2 class="text-base font-bold text-gray-800">Tulis Berita Baru</h2>
            <button onclick="closeModal('createModal')" class="text-gray-400 hover:text-gray-600 text-xl leading-none">&times;</button>
        </div>

        <form id="createForm" action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
            @csrf
            <input type="hidden" name="page" id="createPage" value="{{ request()->get('page', 1) }}">

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">
                    Judul Berita <span class="text-red-500">*</span>
                </label>
                <input type="text" name="title" id="createTitle"
                       placeholder="cth: Cara Mengatasi Jerawat Meradang Secara Klinis"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-pink-400">
                <p class="text-[10px] text-gray-400 mt-1">Slug akan dibuat otomatis dari judul ini.</p>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">
                    Foto Cover <span class="text-gray-400 font-normal">(Opsional — JPG/PNG/WebP, maks 2MB)</span>
                </label>
                <div class="border-2 border-dashed border-gray-200 rounded-xl p-4 text-center hover:border-pink-400 transition-colors cursor-pointer">
                    <input type="file" name="image_path" id="createImage" accept="image/jpeg,image/png,image/webp"
                           class="hidden" onchange="previewCreateImage(this)">
                    <div id="createDropPlaceholder" onclick="document.getElementById('createImage').click()">
                        <svg class="w-8 h-8 text-gray-300 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-sm text-gray-400">Klik untuk upload gambar</p>
                        <p class="text-xs text-gray-300 mt-0.5">JPG, PNG, WebP — maks 2MB</p>
                    </div>
                    <img id="createPreview" src="#" alt="Preview" class="hidden mx-auto max-h-32 rounded-lg object-cover mt-2">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">
                    Konten Berita <span class="text-red-500">*</span>
                </label>
                <textarea name="content" id="createContent" rows="8"
                          placeholder="Tulis isi artikel di sini..."
                          class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-700 leading-relaxed focus:outline-none focus:ring-2 focus:ring-pink-400 resize-y"></textarea>
            </div>

            <div class="flex justify-end gap-3 pt-2 border-t border-gray-100">
                <button type="button" onclick="closeModal('createModal')" class="px-4 py-2 rounded-xl bg-gray-200 text-gray-600 text-sm font-semibold hover:bg-gray-300 transition-colors">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-pink-500 text-white text-sm font-semibold hover:bg-pink-600 transition-colors">
                    <i class="fas fa-save"></i> Publikasikan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ════════════════════════════════════════════════════════════════ --}}
{{-- MODAL EDIT BERITA --}}
{{-- ════════════════════════════════════════════════════════════════ --}}
<div id="editModal" class="fixed inset-0 hidden justify-center items-center z-50" style="background-color: rgba(0, 0, 0, 0.35);">
    <div class="bg-white rounded-2xl w-[700px] shadow-xl border border-pink-100 max-h-[90vh] overflow-y-auto">
        <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between sticky top-0 bg-white">
            <h2 class="text-base font-bold text-gray-800">Edit Berita</h2>
            <button onclick="closeModal('editModal')" class="text-gray-400 hover:text-gray-600 text-xl leading-none">&times;</button>
        </div>

        <form id="editForm" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
            @csrf
            @method('PUT')
            <input type="hidden" name="page" id="editPage" value="{{ request()->get('page', 1) }}">
            <input type="hidden" name="id" id="editId">

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">
                    Judul Berita <span class="text-red-500">*</span>
                </label>
                <input type="text" name="title" id="editTitle"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-pink-400">
                <p class="text-[10px] text-gray-400 mt-1">Slug akan diperbarui otomatis saat disimpan.</p>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">
                    Foto Cover <span class="text-gray-400 font-normal">(Kosongkan untuk mempertahankan foto saat ini)</span>
                </label>
                
                {{-- Current image preview --}}
                <div id="currentImageContainer" class="mb-3 hidden">
                    <div class="p-3 bg-gray-50 border border-gray-200 rounded-xl flex items-center gap-3">
                        <img id="currentImage" src="#" alt="Cover saat ini" class="w-20 h-14 object-cover rounded-lg border border-gray-200">
                        <div>
                            <p class="text-xs font-semibold text-gray-700">Foto Cover Saat Ini</p>
                            <p class="text-[10px] text-gray-400 mt-0.5">Upload foto baru di bawah untuk menggantinya</p>
                        </div>
                    </div>
                </div>

                <div class="border-2 border-dashed border-gray-200 rounded-xl p-4 text-center hover:border-pink-400 transition-colors cursor-pointer">
                    <input type="file" name="image_path" id="editImage" accept="image/jpeg,image/png,image/webp"
                           class="hidden" onchange="previewEditImage(this)">
                    <div id="editDropPlaceholder" onclick="document.getElementById('editImage').click()">
                        <svg class="w-8 h-8 text-gray-300 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-sm text-gray-400">Klik untuk upload gambar baru</p>
                        <p class="text-xs text-gray-300 mt-0.5">JPG, PNG, WebP — maks 2MB</p>
                    </div>
                    <img id="editPreview" src="#" alt="Preview Baru" class="hidden mx-auto max-h-32 rounded-lg object-cover mt-2">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">
                    Konten Berita <span class="text-red-500">*</span>
                </label>
                <textarea name="content" id="editContent" rows="8"
                          class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-700 leading-relaxed focus:outline-none focus:ring-2 focus:ring-pink-400 resize-y"></textarea>
            </div>

            <div class="flex justify-end gap-3 pt-2 border-t border-gray-100">
                <button type="button" onclick="closeModal('editModal')" class="px-4 py-2 rounded-xl bg-gray-200 text-gray-600 text-sm font-semibold hover:bg-gray-300 transition-colors">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-pink-500 text-white text-sm font-semibold hover:bg-pink-600 transition-colors">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ════════════════════════════════════════════════════════════════ --}}
{{-- MODAL DELETE CONFIRM --}}
{{-- ════════════════════════════════════════════════════════════════ --}}
<div id="deleteModal" class="fixed inset-0 bg-black/40 hidden justify-center items-center z-50">
    <div class="bg-white rounded-2xl w-96 p-6 shadow-xl border border-red-100">
        <div class="w-14 h-14 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-exclamation-triangle text-red-500 text-2xl"></i>
        </div>
        <h2 class="text-lg font-bold text-gray-800 text-center mb-2">Hapus Berita?</h2>
        <p class="text-sm text-gray-500 text-center mb-2">
            Apakah Anda yakin ingin menghapus berita:
        </p>
        <p id="deleteName" class="text-sm text-gray-700 text-center font-medium italic mb-6 px-2"></p>
        <p class="text-xs text-gray-400 text-center mb-6">Tindakan ini bersifat permanen dan tidak dapat dibatalkan. Foto cover berita juga akan dihapus.</p>
        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')
            <input type="hidden" name="page" id="deletePage" value="{{ request()->get('page', 1) }}">
            <div class="flex justify-center gap-2">
                <button type="button" onclick="closeModal('deleteModal')"
                    class="px-4 py-2 rounded-lg bg-gray-100 text-gray-600 hover:bg-gray-200 transition-colors font-medium">
                    <i class="fas fa-times"></i> Batal
                </button>
                <button type="submit" class="px-4 py-2 rounded-lg bg-red-500 text-white hover:bg-red-600 shadow transition-colors font-medium">
                    <i class="fas fa-trash"></i> Ya, Hapus
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    let currentImagePath = '';

    function getCurrentPage() {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get('page') || 1;
    }

    // ==================== CREATE MODAL ====================
    function openCreateModal() {
        document.getElementById('createPage').value = getCurrentPage();
        document.getElementById('createForm').reset();
        document.getElementById('createPreview').classList.add('hidden');
        document.getElementById('createDropPlaceholder').classList.remove('hidden');
        openModal('createModal');
    }

    function previewCreateImage(input) {
        const placeholder = document.getElementById('createDropPlaceholder');
        const preview = document.getElementById('createPreview');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    // ==================== EDIT MODAL ====================
    function openEditModal(id, title, content, imagePath) {
        document.getElementById('editId').value = id;
        document.getElementById('editTitle').value = title;
        document.getElementById('editContent').value = content;
        document.getElementById('editPage').value = getCurrentPage();

        // Set current image
        currentImagePath = imagePath;
        const currentContainer = document.getElementById('currentImageContainer');
        const currentImg = document.getElementById('currentImage');
        
        if (imagePath && imagePath !== 'null' && imagePath !== '') {
            const imageUrl = imagePath.startsWith('/') ? imagePath : '/' + imagePath;
            currentImg.src = imageUrl;
            currentContainer.classList.remove('hidden');
        } else {
            currentContainer.classList.add('hidden');
        }

        // Reset preview
        document.getElementById('editPreview').classList.add('hidden');
        document.getElementById('editDropPlaceholder').classList.remove('hidden');
        document.getElementById('editImage').value = '';

        document.getElementById('editForm').action = '{{ url("/admin/news") }}/' + id;
        openModal('editModal');
    }

    function previewEditImage(input) {
        const placeholder = document.getElementById('editDropPlaceholder');
        const preview = document.getElementById('editPreview');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
                // Sembunyikan gambar lama saat upload gambar baru
                document.getElementById('currentImageContainer').classList.add('hidden');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    // ==================== DELETE MODAL ====================
    function openDeleteModal(id, title) {
        document.getElementById('deleteName').textContent = '"' + title + '"';
        document.getElementById('deletePage').value = getCurrentPage();
        document.getElementById('deleteForm').action = '{{ url("/admin/news") }}/' + id;
        openModal('deleteModal');
    }

    // ==================== GENERAL FUNCTIONS ====================
    function openModal(id) {
        const modal = document.getElementById(id);
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    }

    // SweetAlert untuk notifikasi
    @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        timer: 2000,
        showConfirmButton: false,
        background: 'white',
        iconColor: '#10B981'
    });
    @endif

    @if(session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: '{{ session('error') }}',
        timer: 2000,
        showConfirmButton: false,
        background: 'white'
    });
    @endif
</script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

@endsection