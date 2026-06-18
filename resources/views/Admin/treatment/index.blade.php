@extends('layouts_admin.app')

@section('title', 'Data Treatment')

@section('content')
<div class="container">

    {{-- ═══ HEADER ══════════════════════════════════════════════════════════ --}}
    <div class="flex flex-wrap justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-[#5D605C]">Data Treatment</h1>
            <p class="text-sm text-[#797B78] mt-1">Kelola tindakan perawatan klinik beserta target penyakit kulit.</p>
        </div>

        <button onclick="openModal('addModal')"
                class="inline-flex items-center gap-2 bg-pink-500 text-white px-4 py-2 rounded-lg shadow hover:bg-pink-600 transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                </svg>
                Tambah Treatment
            </button>
    </div>

    {{-- ═══ FLASH MESSAGE ═══════════════════════════════════════════════════ --}}
    @if(session('success'))
    <div class="mb-5 p-4 bg-emerald-50 border border-emerald-200 rounded-2xl flex items-center gap-3">
        <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center shrink-0">
            <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
            </svg>
        </div>
        <p class="text-sm font-medium text-emerald-700">{{ session('success') }}</p>
    </div>
    @endif

    {{-- ═══ FILTER BAR ══════════════════════════════════════════════════════ --}}
    <div class="bg-white rounded-2xl border border-[#E1E3DE]/70 p-4 mb-5 shadow-sm">
        <form method="GET" action="{{ route('admin.treatment.index') }}" class="flex gap-2">
            <div class="relative flex-1 min-w-[180px]">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-[#A8ABA7]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                    </svg>
                </div>
                <input type="text" name="search" placeholder="Cari nama treatment..." value="{{ request('search') }}"
                    class="w-full pl-10 pr-4 py-2.5 border border-[#E1E3DE] rounded-xl text-sm text-[#5D605C] focus:outline-none focus:ring-2 focus:ring-[#EBDBDD] focus:border-[#D5C5C5] transition-colors">
            </div>
                <button type="submit"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-pink-500 text-white rounded-lg text-sm font-medium hover:bg-pink-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Cari
                </button>
            @if(request('search'))
                <a href="{{ route('admin.treatment.index') }}"
                    class="px-4 py-2.5 bg-[#F0F1EE] text-[#5D605C] rounded-xl text-sm font-medium hover:bg-[#E1E3DE] transition-colors">
                    Reset
                </a>
            @endif
        </form>
    </div>

    {{-- ═══ TABLE ═══════════════════════════════════════════════════════════ --}}
    <div class="bg-white rounded-2xl shadow-sm border border-[#E1E3DE]/70 overflow-hidden">
        <div class="px-6 py-4 border-b border-[#E1E3DE]/50 flex items-center justify-between bg-[#FAF9F6]">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-[#EBDBDD] flex items-center justify-center">
                    <svg class="w-4 h-4 text-[#7B5556]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-[#5D605C]">Daftar Treatment</h3>
            </div>
            <span class="text-xs font-medium text-[#A8ABA7] bg-[#F0F1EE] px-3 py-1 rounded-full">
                Total: {{ $treatment->total() }}
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-pink-50 text-gray-600 uppercase text-xs tracking-wider">
                        <th class="p-4 text-left">Kode</th>
                        <th class="p-4 text-left">Nama Treatment</th>
                        <th class="p-4 text-left max-w-[250px]">Deskripsi</th>
                        <th class="p-4 text-left">Target Penyakit Kulit</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse ($treatment as $item)
                        <tr class="hover:bg-pink-50 transition">
                            {{-- Kode --}}
                            <td class="p-4">
                                <span class="bg-pink-100 text-pink-600 px-2 py-1 rounded-md text-xs font-semibold">
                                    T{{ str_pad($item->id, 3, '0', STR_PAD_LEFT) }}
                                </span>
                            </td>

                            {{-- Nama --}}
                            <td class="p-4">
                                <span class="font-semibold text-gray-800">{{ $item->name }}</span>
                            </td>

                            {{-- Deskripsi --}}
                            <td class="p-4 max-w-[250px]">
                                <p class="text-gray-500 text-xs leading-relaxed line-clamp-2">
                                    {{ \Illuminate\Support\Str::limit($item->description, 80) }}
                                </p>
                            </td>

                            {{-- Target Penyakit Kulit (NEW) --}}
                            <td class="p-4">
                                <div class="flex flex-wrap gap-1.5">
                                    @forelse($item->skinProblems as $problem)
                                        <span class="text-[10px] px-2 py-0.5 bg-pink-100 text-pink-600 rounded-md font-medium">
                                            {{ $problem->name }}
                                        </span>
                                    @empty
                                        <span class="text-[10px] text-gray-400 italic bg-gray-100 px-2.5 py-1 rounded-full">Belum ditautkan</span>
                                    @endforelse
                                </div>
                            </td>

                            {{-- Aksi --}}
                            <td class="p-4">
                                <div class="flex justify-center gap-2">
                                    {{-- Tombol Edit --}}
                                    <button type="button"
                                        onclick="openEditModal({{ $item->id }}, @js($item->name), @js($item->description), @js($item->skinProblems->pluck('id')))"
                                        class="px-3 py-1 text-xs bg-pink-100 text-pink-600 rounded-lg hover:bg-pink-200 transition flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/>
                                        </svg>
                                        Edit
                                    </button>

                                    {{-- Tombol Hapus --}}
                                    <button type="button"
                                        onclick="openDeleteModal({{ $item->id }}, @js($item->name))"
                                        class="px-3 py-1 text-xs bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                        </svg>
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-10 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="w-16 h-16 rounded-2xl bg-[#EBDBDD]/30 flex items-center justify-center">
                                        <svg class="w-7 h-7 text-[#A8ABA7]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0l-3-3m3 3l3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/>
                                        </svg>
                                    </div>
                                    <p class="text-sm text-[#A8ABA7] font-medium">Data treatment belum tersedia</p>
                                    <p class="text-xs text-[#A8ABA7]">Klik tombol "Tambah Treatment" untuk menambahkan data pertama.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ═══ PAGINATION ══════════════════════════════════════════════════════ --}}
    <div class="mt-5">
        {{ $treatment->links() }}
    </div>

</div>

{{-- ═══════════════════════════════════════════════════════════════════════ --}}
{{-- MODAL TAMBAH                                                          --}}
{{-- ═══════════════════════════════════════════════════════════════════════ --}}
<div id="addModal" class="fixed inset-0 hidden justify-center items-center z-50 bg-[#5D605C]/40 backdrop-blur-sm">
    <div class="bg-white rounded-2xl w-[540px] max-h-[90vh] overflow-y-auto p-6 shadow-2xl border border-[#E1E3DE]/70">
        {{-- Header --}}
        <div class="flex items-center gap-3 mb-5">
            <div class="w-10 h-10 rounded-xl bg-[#EBDBDD] flex items-center justify-center">
                <svg class="w-5 h-5 text-[#7B5556]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                </svg>
            </div>
            <div>
                <h2 class="text-lg font-bold text-[#5D605C]">Tambah Treatment</h2>
                <p class="text-xs text-[#A8ABA7]">Isi data treatment dan pilih target penyakit kulit.</p>
            </div>
        </div>

        <form action="{{ route('admin.treatment.store') }}" method="POST" onsubmit="return validateAddForm()">
            @csrf
            <input type="hidden" name="page" id="addPage" value="{{ request()->get('page', 1) }}">

            {{-- Nama Treatment --}}
            <div class="mb-4">
                <label class="block text-xs font-semibold text-[#5D605C] mb-1.5">Nama Treatment <span class="text-red-400">*</span></label>
                <input type="text" id="addName" name="name" placeholder="Contoh: Chemical Peeling"
                    class="w-full px-4 py-2.5 border border-[#E1E3DE] rounded-xl text-sm text-[#5D605C] focus:outline-none focus:ring-2 focus:ring-[#EBDBDD] focus:border-[#D5C5C5] transition-colors">
            </div>

            {{-- Deskripsi --}}
            <div class="mb-4">
                <label class="block text-xs font-semibold text-[#5D605C] mb-1.5">Deskripsi <span class="text-red-400">*</span></label>
                <textarea id="addDescription" name="description" placeholder="Deskripsikan prosedur treatment ini..."
                    class="w-full px-4 py-2.5 border border-[#E1E3DE] rounded-xl text-sm text-[#5D605C] focus:outline-none focus:ring-2 focus:ring-[#EBDBDD] focus:border-[#D5C5C5] transition-colors" rows="3"></textarea>
            </div>

            {{-- Target Penyakit Kulit --}}
            <div class="mb-4">
                <label class="block text-xs font-semibold text-[#5D605C] mb-2">Target Penyakit Kulit <span class="text-red-400">*</span></label>
                <div class="grid grid-cols-2 gap-2" id="addSkinProblems">
                    @foreach($skinProblems as $sp)
                        <label class="flex items-center gap-2.5 border border-[#E1E3DE] rounded-xl px-3 py-2.5 cursor-pointer hover:border-[#D5C5C5] transition-colors has-[:checked]:border-[#7B5556] has-[:checked]:bg-[#EBDBDD]/30">
                            <input type="checkbox" name="skin_problems[]" value="{{ $sp->id }}"
                                class="w-4 h-4 rounded accent-[#7B5556]">
                            <span class="text-xs font-medium text-[#5D605C]">{{ $sp->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <p id="addError" class="hidden text-sm text-red-500 mb-3 p-3 bg-red-50 rounded-xl border border-red-200"></p>

            <div class="flex justify-end gap-2 pt-2 border-t border-[#E1E3DE]/50 mt-2">
                <button type="button" onclick="closeModal('addModal')"
                    class="px-4 py-2.5 rounded-xl bg-[#F0F1EE] text-[#5D605C] text-sm font-medium hover:bg-[#E1E3DE] transition-colors">
                    Batal
                </button>
                <button type="submit"
                    class="px-5 py-2.5 rounded-xl bg-pink-500 text-white text-sm font-semibold hover:bg-pink-600 shadow-sm transition-colors duration-200">
                    Simpan Treatment
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════════════════ --}}
{{-- MODAL EDIT                                                            --}}
{{-- ═══════════════════════════════════════════════════════════════════════ --}}
<div id="editModal" class="fixed inset-0 hidden justify-center items-center z-50 bg-[#5D605C]/40 backdrop-blur-sm">
    <div class="bg-white rounded-2xl w-[540px] max-h-[90vh] overflow-y-auto p-6 shadow-2xl border border-[#E1E3DE]/70">
        {{-- Header --}}
        <div class="flex items-center gap-3 mb-5">
            <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center">
                <svg class="w-5 h-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/>
                </svg>
            </div>
            <div>
                <h2 class="text-lg font-bold text-[#5D605C]">Edit Treatment</h2>
                <p class="text-xs text-[#A8ABA7]">Perbarui data treatment dan relasi penyakit kulit.</p>
            </div>
        </div>

        <form id="editForm" method="POST" onsubmit="return validateEditForm()">
            @csrf
            @method('PUT')
            <input type="hidden" name="page" id="editPage" value="{{ request()->get('page', 1) }}">

            {{-- Nama Treatment --}}
            <div class="mb-4">
                <label class="block text-xs font-semibold text-[#5D605C] mb-1.5">Nama Treatment <span class="text-red-400">*</span></label>
                <input type="text" id="editName" name="name"
                    class="w-full px-4 py-2.5 border border-[#E1E3DE] rounded-xl text-sm text-[#5D605C] focus:outline-none focus:ring-2 focus:ring-[#EBDBDD] focus:border-[#D5C5C5] transition-colors">
            </div>

            {{-- Deskripsi --}}
            <div class="mb-4">
                <label class="block text-xs font-semibold text-[#5D605C] mb-1.5">Deskripsi <span class="text-red-400">*</span></label>
                <textarea id="editDescription" name="description"
                    class="w-full px-4 py-2.5 border border-[#E1E3DE] rounded-xl text-sm text-[#5D605C] focus:outline-none focus:ring-2 focus:ring-[#EBDBDD] focus:border-[#D5C5C5] transition-colors" rows="3"></textarea>
            </div>

            {{-- Target Penyakit Kulit --}}
            <div class="mb-4">
                <label class="block text-xs font-semibold text-[#5D605C] mb-2">Target Penyakit Kulit <span class="text-red-400">*</span></label>
                <div class="grid grid-cols-2 gap-2" id="editSkinProblems">
                    @foreach($skinProblems as $sp)
                        <label class="flex items-center gap-2.5 border border-[#E1E3DE] rounded-xl px-3 py-2.5 cursor-pointer hover:border-[#D5C5C5] transition-colors has-[:checked]:border-[#7B5556] has-[:checked]:bg-[#EBDBDD]/30">
                            <input type="checkbox" name="skin_problems[]" value="{{ $sp->id }}"
                                class="w-4 h-4 rounded accent-[#7B5556] edit-sp-checkbox">
                            <span class="text-xs font-medium text-[#5D605C]">{{ $sp->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <p id="editError" class="hidden text-sm text-red-500 mb-3 p-3 bg-red-50 rounded-xl border border-red-200"></p>

            <div class="flex justify-end gap-2 pt-2 border-t border-[#E1E3DE]/50 mt-2">
                <button type="button" onclick="closeModal('editModal')"
                    class="px-4 py-2.5 rounded-xl bg-[#F0F1EE] text-[#5D605C] text-sm font-medium hover:bg-[#E1E3DE] transition-colors">
                    Batal
                </button>
                <button type="submit"
                    class="px-5 py-2.5 rounded-xl bg-[#7B5556] text-white text-sm font-medium hover:bg-[#6A4849] shadow-sm transition-all duration-200">
                    Update Treatment
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════════════════ --}}
{{-- MODAL HAPUS                                                           --}}
{{-- ═══════════════════════════════════════════════════════════════════════ --}}
<div id="deleteModal" class="fixed inset-0 hidden justify-center items-center z-50 bg-[#5D605C]/40 backdrop-blur-sm">
    <div class="bg-white rounded-2xl w-[420px] p-6 shadow-2xl border border-red-100/70">
        <div class="flex flex-col items-center text-center">
            <div class="w-16 h-16 bg-red-50 rounded-2xl flex items-center justify-center mb-4">
                <svg class="w-7 h-7 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                </svg>
            </div>
            <h2 class="text-lg font-bold text-[#5D605C] mb-1">Hapus Treatment?</h2>
            <p class="text-sm text-[#797B78] mb-6">
                Anda akan menghapus treatment
                <span id="deleteName" class="font-bold text-[#5D605C]"></span>.
                Tindakan ini tidak dapat dibatalkan.
            </p>
        </div>

        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')
            <input type="hidden" name="page" id="deletePage" value="{{ request()->get('page', 1) }}">
            <div class="flex justify-center gap-3">
                <button type="button" onclick="closeModal('deleteModal')"
                    class="px-5 py-2.5 rounded-xl bg-[#F0F1EE] text-[#5D605C] text-sm font-medium hover:bg-[#E1E3DE] transition-colors">
                    Batal
                </button>
                <button type="submit"
                    class="px-5 py-2.5 rounded-xl bg-red-500 text-white text-sm font-medium hover:bg-red-600 shadow-sm transition-all duration-200">
                    Ya, Hapus Permanen
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════════════════ --}}
{{-- JAVASCRIPT                                                            --}}
{{-- ═══════════════════════════════════════════════════════════════════════ --}}
<script>
    // ── Utilitas Halaman ──────────────────────────────────────────────────
    function getCurrentPage() {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get('page') || 1;
    }

    // ── Buka / Tutup Modal ───────────────────────────────────────────────
    function openModal(id) {
        const modal = document.getElementById(id);
        if (!modal) return;

        if (id === 'addModal') {
            document.getElementById('addPage').value = getCurrentPage();
            resetAddForm();
        }
        if (id === 'editModal') {
            document.getElementById('editPage').value = getCurrentPage();
        }
        if (id === 'deleteModal') {
            document.getElementById('deletePage').value = getCurrentPage();
        }

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        if (!modal) return;

        modal.classList.add('hidden');
        modal.classList.remove('flex');

        if (id === 'addModal') resetAddForm();
        if (id === 'editModal') {
            document.getElementById('editName').value = '';
            document.getElementById('editDescription').value = '';
            // Uncheck semua checkbox edit
            document.querySelectorAll('.edit-sp-checkbox').forEach(cb => cb.checked = false);
            const error = document.getElementById('editError');
            if (error) error.classList.add('hidden');
        }
    }

    // ── Reset Form Tambah ────────────────────────────────────────────────
    function resetAddForm() {
        document.getElementById('addName').value = '';
        document.getElementById('addDescription').value = '';
        // Uncheck semua checkbox
        document.querySelectorAll('#addSkinProblems input[type="checkbox"]').forEach(cb => cb.checked = false);
        const error = document.getElementById('addError');
        if (error) error.classList.add('hidden');
    }

    // ── Validasi Form Tambah ─────────────────────────────────────────────
    function validateAddForm() {
        const name = document.getElementById('addName');
        const description = document.getElementById('addDescription');
        const error = document.getElementById('addError');
        const checkboxes = document.querySelectorAll('#addSkinProblems input[type="checkbox"]:checked');

        let messages = [];
        name.classList.remove('border-red-400');
        description.classList.remove('border-red-400');

        if (name.value.trim() === '') {
            name.classList.add('border-red-400');
            messages.push('Nama treatment wajib diisi.');
        }
        if (description.value.trim() === '') {
            description.classList.add('border-red-400');
            messages.push('Deskripsi wajib diisi.');
        }
        if (checkboxes.length === 0) {
            messages.push('Pilih minimal 1 target penyakit kulit.');
        }

        if (messages.length > 0) {
            error.innerHTML = messages.join('<br>');
            error.classList.remove('hidden');
            return false;
        }
        return true;
    }

    // ── Validasi Form Edit ───────────────────────────────────────────────
    function validateEditForm() {
        const name = document.getElementById('editName');
        const description = document.getElementById('editDescription');
        const error = document.getElementById('editError');
        const checkboxes = document.querySelectorAll('#editSkinProblems input[type="checkbox"]:checked');

        let messages = [];
        name.classList.remove('border-red-400');
        description.classList.remove('border-red-400');

        if (name.value.trim() === '') {
            name.classList.add('border-red-400');
            messages.push('Nama treatment wajib diisi.');
        }
        if (description.value.trim() === '') {
            description.classList.add('border-red-400');
            messages.push('Deskripsi wajib diisi.');
        }
        if (checkboxes.length === 0) {
            messages.push('Pilih minimal 1 target penyakit kulit.');
        }

        if (messages.length > 0) {
            error.innerHTML = messages.join('<br>');
            error.classList.remove('hidden');
            return false;
        }
        return true;
    }

    // ── Open Edit Modal (dengan pre-check skin problems) ─────────────────
    function openEditModal(id, name, description, selectedSkinProblems) {
        const editForm = document.getElementById('editForm');

        document.getElementById('editName').value = name;
        document.getElementById('editDescription').value = description;
        document.getElementById('editPage').value = getCurrentPage();

        // Pre-check skin problems yang sudah terhubung
        document.querySelectorAll('.edit-sp-checkbox').forEach(cb => {
            cb.checked = selectedSkinProblems.includes(parseInt(cb.value));
        });

        editForm.action = "{{ url('/admin/treatment') }}/" + id;
        openModal('editModal');
    }

    // ── Open Delete Modal ────────────────────────────────────────────────
    function openDeleteModal(id, name) {
        const deleteForm = document.getElementById('deleteForm');

        document.getElementById('deleteName').textContent = name;
        document.getElementById('deletePage').value = getCurrentPage();
        deleteForm.action = "{{ url('/admin/treatment') }}/" + id;

        openModal('deleteModal');
    }
</script>

@endsection
