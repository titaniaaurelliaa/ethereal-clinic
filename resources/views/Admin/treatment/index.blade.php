@extends('layouts_admin.app')
@section('title', 'Data Treatment')
@section('content')
<div class="container">

    {{-- ─── HEADER ──────────────────────────────────────────────────────── --}}
    <div class="flex flex-wrap justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-[#5D605C]">Data Treatment</h1>
            <p class="text-sm text-gray-400 mt-0.5">Manajemen tindakan klinis & rekomendasi gaya hidup</p>
        </div>
        <button onclick="openModal('addModal')"
            class="bg-[#7B5556] text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow-sm hover:bg-[#6a494a] transition-colors">
            + Tambah Treatment
        </button>
    </div>

    {{-- ─── TABLE ───────────────────────────────────────────────────────── --}}
    <div class="bg-white rounded-2xl border border-[#E1E3DE] overflow-hidden">
        <div class="px-6 py-4 border-b border-[#E1E3DE] flex items-center justify-between">
            <h3 class="font-semibold text-[#5D605C]">Daftar Treatment</h3>
            <span class="text-xs text-gray-400">Total: {{ $treatment->total() }}</span>
        </div>

        <table class="w-full text-sm">
            <thead class="bg-[#EBDBDD]/30 text-[#5D605C] uppercase text-xs tracking-wider">
                <tr>
                    <th class="p-4 text-left">ID</th>
                    <th class="p-4 text-left">Nama Treatment</th>
                    <th class="p-4 text-left">Kategori</th>
                    <th class="p-4 text-left">Indikasi Masalah</th>
                    <th class="p-4 text-center">Prioritas</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#E1E3DE]/60">
                @forelse ($treatment as $item)
                    @php
                        $catLabels = ['daily_habit'=>'Daily Habit','avoidance'=>'Avoidance','protection'=>'Protection','lifestyle'=>'Lifestyle'];
                        $catColor  = ['daily_habit'=>'bg-green-50 text-green-700','avoidance'=>'bg-yellow-50 text-yellow-700','protection'=>'bg-blue-50 text-blue-700','lifestyle'=>'bg-purple-50 text-purple-700'];
                    @endphp
                    <tr class="hover:bg-[#EBDBDD]/10 transition-colors">
                        <td class="p-4">
                            <span class="bg-[#EBDBDD] text-[#7B5556] px-2 py-1 rounded-md text-xs font-bold">
                                T{{ str_pad($item->id, 3, '0', STR_PAD_LEFT) }}
                            </span>
                        </td>
                        <td class="p-4">
                            <p class="font-semibold text-[#5D605C]">{{ $item->name }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">{{ \Illuminate\Support\Str::limit($item->description, 50) }}</p>
                        </td>
                        <td class="p-4">
                            <span class="px-2.5 py-1 {{ $catColor[$item->category] ?? 'bg-gray-50 text-gray-600' }} rounded-lg text-xs font-medium">
                                {{ $catLabels[$item->category] ?? $item->category }}
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
                            <span class="px-2.5 py-1 {{ $item->priority >= 5 ? 'bg-red-50 text-red-600' : 'bg-gray-50 text-gray-500' }} rounded-lg text-xs font-bold">
                                {{ $item->priority }}
                            </span>
                        </td>
                        <td class="p-4 text-center">
                            <div class="flex justify-center gap-2">
                                <button type="button"
                                    onclick="openEditModal({{ $item->id }}, @js($item->name), @js($item->description), @js($item->category), {{ $item->priority }}, @js($item->skinProblems->pluck('id')))"
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
                        <td colspan="6" class="p-10 text-center text-gray-400">
                            <div class="flex flex-col items-center gap-2">
                                <svg class="w-10 h-10 text-[#E1E3DE]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                </svg>
                                Data treatment belum tersedia
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $treatment->links() }}</div>

</div>

{{-- ════════════════════════════════════════════════════════════════════════ --}}
{{-- MODAL TAMBAH                                                            --}}
{{-- ════════════════════════════════════════════════════════════════════════ --}}
<div id="addModal" class="fixed inset-0 hidden justify-center items-center z-50" style="background-color:rgba(0,0,0,0.35);">
    <div class="bg-white rounded-2xl w-[520px] shadow-xl border border-[#E1E3DE] max-h-[90vh] overflow-y-auto">
        <div class="px-6 py-5 border-b border-[#E1E3DE] flex items-center justify-between">
            <h2 class="text-base font-bold text-[#5D605C]">Tambah Treatment</h2>
            <button onclick="closeModal('addModal')" class="text-gray-400 hover:text-gray-600 text-xl leading-none">&times;</button>
        </div>

        <form action="{{ route('admin.treatment.store') }}" method="POST" class="p-6 space-y-4">
            @csrf
            <input type="hidden" name="page" id="addPage" value="{{ request()->get('page', 1) }}">

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-[#5D605C] mb-1">Nama Treatment <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="addName" placeholder="Nama treatment"
                        class="w-full border border-[#E1E3DE] rounded-xl p-2.5 text-sm text-[#5D605C] focus:outline-none focus:ring-2 focus:ring-[#7B5556]/30">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-[#5D605C] mb-1">Kategori <span class="text-red-500">*</span></label>
                    <select name="category" id="addCategory"
                        class="w-full border border-[#E1E3DE] rounded-xl p-2.5 text-sm text-[#5D605C] focus:outline-none focus:ring-2 focus:ring-[#7B5556]/30">
                        <option value="">Pilih Kategori</option>
                        <option value="daily_habit">Daily Habit</option>
                        <option value="avoidance">Avoidance</option>
                        <option value="protection">Protection</option>
                        <option value="lifestyle">Lifestyle</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-[#5D605C] mb-1">Deskripsi <span class="text-red-500">*</span></label>
                <textarea name="description" id="addDescription" rows="3" placeholder="Deskripsi tindakan / rekomendasi"
                    class="w-full border border-[#E1E3DE] rounded-xl p-2.5 text-sm text-[#5D605C] focus:outline-none focus:ring-2 focus:ring-[#7B5556]/30"></textarea>
            </div>

            <div>
                <label class="block text-xs font-semibold text-[#5D605C] mb-1">Prioritas (0–10)</label>
                <input type="number" name="priority" id="addPriority" min="0" max="10" value="0"
                    class="w-full border border-[#E1E3DE] rounded-xl p-2.5 text-sm text-[#5D605C] focus:outline-none focus:ring-2 focus:ring-[#7B5556]/30">
                <p class="text-xs text-gray-400 mt-1">Semakin tinggi angka, semakin diprioritaskan</p>
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
    <div class="bg-white rounded-2xl w-[520px] shadow-xl border border-[#E1E3DE] max-h-[90vh] overflow-y-auto">
        <div class="px-6 py-5 border-b border-[#E1E3DE] flex items-center justify-between">
            <h2 class="text-base font-bold text-[#5D605C]">Edit Treatment</h2>
            <button onclick="closeModal('editModal')" class="text-gray-400 hover:text-gray-600 text-xl leading-none">&times;</button>
        </div>

        <form id="editForm" method="POST" class="p-6 space-y-4">
            @csrf
            @method('PUT')
            <input type="hidden" name="page" id="editPage" value="{{ request()->get('page', 1) }}">

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-[#5D605C] mb-1">Nama Treatment <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="editName"
                        class="w-full border border-[#E1E3DE] rounded-xl p-2.5 text-sm text-[#5D605C] focus:outline-none focus:ring-2 focus:ring-[#7B5556]/30">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-[#5D605C] mb-1">Kategori <span class="text-red-500">*</span></label>
                    <select name="category" id="editCategory"
                        class="w-full border border-[#E1E3DE] rounded-xl p-2.5 text-sm text-[#5D605C] focus:outline-none focus:ring-2 focus:ring-[#7B5556]/30">
                        <option value="daily_habit">Daily Habit</option>
                        <option value="avoidance">Avoidance</option>
                        <option value="protection">Protection</option>
                        <option value="lifestyle">Lifestyle</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-[#5D605C] mb-1">Deskripsi <span class="text-red-500">*</span></label>
                <textarea name="description" id="editDescription" rows="3"
                    class="w-full border border-[#E1E3DE] rounded-xl p-2.5 text-sm text-[#5D605C] focus:outline-none focus:ring-2 focus:ring-[#7B5556]/30"></textarea>
            </div>

            <div>
                <label class="block text-xs font-semibold text-[#5D605C] mb-1">Prioritas (0–10)</label>
                <input type="number" name="priority" id="editPriority" min="0" max="10"
                    class="w-full border border-[#E1E3DE] rounded-xl p-2.5 text-sm text-[#5D605C] focus:outline-none focus:ring-2 focus:ring-[#7B5556]/30">
            </div>

            {{-- Indikasi Masalah Kulit --}}
            <div>
                <label class="block text-xs font-semibold text-[#5D605C] mb-2">Indikasi Masalah Kulit</label>
                <div class="grid grid-cols-2 gap-2">
                    @foreach($skinProblems as $sp)
                        <label class="flex items-center gap-2 border border-[#E1E3DE] rounded-xl px-3 py-2 cursor-pointer hover:border-[#7B5556]/40 transition-colors has-[:checked]:border-[#7B5556] has-[:checked]:bg-[#EBDBDD]/30">
                            <input type="checkbox" name="skin_problems[]" value="{{ $sp->id }}"
                                class="w-4 h-4 accent-[#7B5556] sp-edit-cb-t" data-sp-id="{{ $sp->id }}">
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
        <h2 class="text-base font-bold text-[#5D605C] text-center mb-2">Hapus Treatment?</h2>
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
    ['addName','addDescription'].forEach(id => { const el=document.getElementById(id); if(el) el.value=''; });
    document.getElementById('addCategory').value = '';
    document.getElementById('addPriority').value = '0';
    document.querySelectorAll('#addModal input[type="checkbox"]').forEach(cb => cb.checked = false);
    const err = document.getElementById('addError'); if(err) err.classList.add('hidden');
}

function openEditModal(id, name, description, category, priority, skinProblemIds) {
    document.getElementById('editName').value        = name;
    document.getElementById('editDescription').value = description;
    document.getElementById('editCategory').value    = category;
    document.getElementById('editPriority').value    = priority || 0;
    document.getElementById('editPage').value        = getCurrentPage();

    // Pre-check skin problem checkboxes
    document.querySelectorAll('.sp-edit-cb-t').forEach(cb => {
        cb.checked = skinProblemIds.includes(parseInt(cb.dataset.spId));
    });

    document.getElementById('editForm').action = '{{ url("/admin/treatment") }}/' + id;
    openModal('editModal');
}

function openDeleteModal(id, name) {
    document.getElementById('deleteName').textContent = name;
    document.getElementById('deletePage').value       = getCurrentPage();
    document.getElementById('deleteForm').action      = '{{ url("/admin/treatment") }}/' + id;
    openModal('deleteModal');
}
</script>
@endsection