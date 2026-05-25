@extends('layouts_admin.app')
@section('title', 'Basis Pengetahuan Pakar')
@section('content')
<div class="container">

    {{-- ─── VALIDATION ERROR BANNER (GAP 2) ──────────────────────────────── --}}
    @if($errors->any())
        <div class="mb-5 bg-red-50 border border-red-200 rounded-2xl p-5">
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center shrink-0 mt-0.5">
                    <svg class="w-4 h-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-red-700 mb-2">Validasi Gagal — Periksa Input Berikut:</h4>
                    <ul class="space-y-1">
                        @foreach($errors->all() as $error)
                            <li class="text-xs text-red-600 flex items-start gap-1.5">
                                <span class="mt-0.5 shrink-0">&#x25CF;</span>
                                <span>{{ $error }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    {{-- ─── SUCCESS TOAST ───────────────────────────────────────────────── --}}
    @if(session('success'))
        <div id="successToast"
            class="mb-5 bg-green-50 border border-green-200 rounded-2xl px-5 py-4 flex items-center gap-3">
            <div class="w-7 h-7 bg-green-100 rounded-full flex items-center justify-center shrink-0">
                <svg class="w-4 h-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <span class="text-sm font-medium text-green-700">{{ session('success') }}</span>
        </div>
        <script>setTimeout(() => { const t = document.getElementById('successToast'); if(t) t.remove(); }, 4000);</script>
    @endif

    {{-- ─── HEADER ──────────────────────────────────────────────────────── --}}
    <div class="flex flex-wrap justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-[#5D605C]">Basis Pengetahuan Pakar</h1>
            <p class="text-sm text-gray-400 mt-0.5">Aturan deteksi AI — objek visual, keparahan, dan bobot kepakaran</p>
        </div>
        <button onclick="openModal('addModal')"
            class="bg-[#7B5556] text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow-sm hover:bg-[#6a494a] transition-colors">
            + Tambah Aturan
        </button>
    </div>

    {{-- ─── FILTER BAR ──────────────────────────────────────────────────── --}}
    <div class="bg-white rounded-2xl border border-[#E1E3DE] p-4 mb-5">
        <form method="GET" action="{{ route('admin.knowledge-base.index') }}" class="flex flex-wrap gap-3">
            <select name="keparahan"
                class="px-3 py-2 border border-[#E1E3DE] rounded-xl text-sm text-[#5D605C] focus:outline-none focus:ring-2 focus:ring-[#7B5556]/30">
                <option value="">Semua Tingkat</option>
                @foreach(['Ringan', 'Sedang', 'Parah'] as $k)
                    <option value="{{ $k }}" {{ request('keparahan') == $k ? 'selected' : '' }}>{{ $k }}</option>
                @endforeach
            </select>
            <input type="text" name="search" placeholder="Cari nama objek AI..."
                value="{{ request('search') }}"
                class="flex-1 min-w-[180px] px-3 py-2 border border-[#E1E3DE] rounded-xl text-sm text-[#5D605C] focus:outline-none focus:ring-2 focus:ring-[#7B5556]/30">
            <button type="submit"
                class="px-4 py-2 bg-[#7B5556] text-white rounded-xl text-sm font-semibold hover:bg-[#6a494a] transition-colors">
                Cari
            </button>
            @if(request('search') || request('keparahan'))
                <a href="{{ route('admin.knowledge-base.index') }}"
                    class="px-4 py-2 bg-[#E1E3DE] text-[#5D605C] rounded-xl text-sm font-semibold hover:bg-gray-200 transition-colors">
                    Reset
                </a>
            @endif
        </form>
    </div>

    {{-- ─── TABLE ───────────────────────────────────────────────────────── --}}
    <div class="bg-white rounded-2xl border border-[#E1E3DE] overflow-hidden">
        <div class="px-6 py-4 border-b border-[#E1E3DE] flex items-center justify-between">
            <h3 class="font-semibold text-[#5D605C]">Daftar Aturan Knowledge Base</h3>
            <span class="text-xs text-gray-400">Total: {{ $knowledgeBases->total() }}</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-[#EBDBDD]/30 text-[#5D605C] uppercase text-xs tracking-wider">
                    <tr>
                        <th class="p-4 text-left">No</th>
                        <th class="p-4 text-left">Nama Objek AI</th>
                        <th class="p-4 text-left">Masalah Kulit</th>
                        <th class="p-4 text-left">Keparahan</th>
                        <th class="p-4 text-center">Batas Objek</th>
                        <th class="p-4 text-center">Bobot Pakar</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E1E3DE]/60">
                    @forelse ($knowledgeBases as $index => $item)
                        @php
                            $kepColor = [
                                'Ringan' => 'bg-green-50 text-green-700 border-green-200',
                                'Sedang' => 'bg-amber-50 text-amber-700 border-amber-200',
                                'Parah'  => 'bg-red-50 text-red-700 border-red-200',
                            ][$item->tingkat_keparahan] ?? 'bg-gray-50 text-gray-600 border-gray-200';
                            $cfPct = round($item->cf_pakar * 100);
                        @endphp
                        <tr class="hover:bg-[#EBDBDD]/10 transition-colors">
                            <td class="p-4 text-gray-400 text-xs">
                                {{ $knowledgeBases->firstItem() + $index }}
                            </td>
                            <td class="p-4 font-semibold text-[#5D605C]">{{ $item->nama_objek }}</td>
                            <td class="p-4">
                                @if($item->skinProblem)
                                    <span class="text-xs px-2.5 py-1 bg-[#EBDBDD]/60 text-[#7B5556] rounded-lg font-medium">
                                        {{ $item->skinProblem->name }}
                                    </span>
                                @else
                                    <span class="text-xs text-gray-300 italic">—</span>
                                @endif
                            </td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 border {{ $kepColor }} rounded-lg text-xs font-semibold">
                                    {{ $item->tingkat_keparahan }}
                                </span>
                            </td>
                            <td class="p-4 text-center text-[#5D605C] font-medium text-xs">
                                {{ $item->min_objek }} &ndash; {{ $item->max_objek }}
                            </td>
                            <td class="p-4 text-center">
                                <div class="flex flex-col items-center gap-1">
                                    <span class="font-bold text-[#7B5556] text-sm">{{ $cfPct }}%</span>
                                    <div class="w-16 h-1.5 bg-[#E1E3DE] rounded-full overflow-hidden">
                                        <div class="h-full bg-[#7B5556] rounded-full" style="width:{{ $cfPct }}%"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4 text-center">
                                <div class="flex justify-center gap-2">
                                    <button type="button"
                                        onclick="openEditModal(
                                            {{ $item->id }},
                                            {{ $item->skin_problem_id ?? 'null' }},
                                            @js($item->nama_objek),
                                            @js($item->tingkat_keparahan),
                                            {{ $item->min_objek }},
                                            {{ $item->max_objek }},
                                            {{ $item->cf_pakar }}
                                        )"
                                        class="px-3 py-1.5 text-xs bg-[#EBDBDD] text-[#7B5556] rounded-lg hover:bg-[#7B5556] hover:text-white transition-colors font-medium">
                                        Edit
                                    </button>

                                    {{-- GAP 4 — Deletion safety barrier: form intercepted by JS confirm --}}
                                    <form id="deleteForm-{{ $item->id }}"
                                        action="{{ route('admin.knowledge-base.destroy', $item->id) }}"
                                        method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="page" value="{{ request()->get('page', 1) }}">
                                    </form>
                                    <button type="button"
                                        onclick="confirmDelete({{ $item->id }}, @js($item->nama_objek))"
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
                                    <svg class="w-10 h-10 text-[#E1E3DE]" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    Belum ada aturan knowledge base
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $knowledgeBases->appends(request()->query())->links() }}
    </div>

</div>

{{-- ════════════════════════════════════════════════════════════════════════ --}}
{{-- MODAL TAMBAH                                                            --}}
{{-- ════════════════════════════════════════════════════════════════════════ --}}
<div id="addModal" class="fixed inset-0 hidden justify-center items-center z-50"
    style="background-color:rgba(0,0,0,0.35);">
    <div class="bg-white rounded-2xl w-[520px] shadow-xl border border-[#E1E3DE] max-h-[90vh] overflow-y-auto">
        <div class="px-6 py-5 border-b border-[#E1E3DE] flex items-center justify-between">
            <h2 class="text-base font-bold text-[#5D605C]">Tambah Aturan Knowledge Base</h2>
            <button onclick="closeModal('addModal')" class="text-gray-400 hover:text-gray-600 text-xl leading-none">&times;</button>
        </div>

        <form action="{{ route('admin.knowledge-base.store') }}" method="POST" class="p-6 space-y-4">
            @csrf
            <input type="hidden" name="page" id="addPage" value="{{ request()->get('page', 1) }}">

            <div>
                <label class="block text-xs font-semibold text-[#5D605C] mb-1">
                    Masalah Kulit <span class="text-red-500">*</span>
                </label>
                <select name="skin_problem_id" id="addSkinProblem" required
                    class="w-full border border-[#E1E3DE] rounded-xl p-2.5 text-sm text-[#5D605C] focus:outline-none focus:ring-2 focus:ring-[#7B5556]/30">
                    <option value="">-- Pilih Masalah Kulit --</option>
                    @foreach($skinProblems as $sp)
                        <option value="{{ $sp->id }}" {{ old('skin_problem_id') == $sp->id ? 'selected' : '' }}>
                            {{ $sp->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-[#5D605C] mb-1">
                        Nama Objek AI <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama_objek" id="addNamaObjek"
                        placeholder="cth: pustule" value="{{ old('nama_objek') }}"
                        class="w-full border border-[#E1E3DE] rounded-xl p-2.5 text-sm text-[#5D605C] focus:outline-none focus:ring-2 focus:ring-[#7B5556]/30">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-[#5D605C] mb-1">
                        Tingkat Keparahan <span class="text-red-500">*</span>
                    </label>
                    <select name="tingkat_keparahan" id="addKeparahan" required
                        class="w-full border border-[#E1E3DE] rounded-xl p-2.5 text-sm text-[#5D605C] focus:outline-none focus:ring-2 focus:ring-[#7B5556]/30">
                        <option value="">-- Pilih --</option>
                        @foreach(['Ringan', 'Sedang', 'Parah'] as $k)
                            <option value="{{ $k }}" {{ old('tingkat_keparahan') == $k ? 'selected' : '' }}>{{ $k }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- GAP 2: Strict numeric bounds --}}
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-[#5D605C] mb-1">
                        Min Objek <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="min_objek" id="addMinObjek"
                        min="0" placeholder="0" value="{{ old('min_objek') }}"
                        class="w-full border border-[#E1E3DE] rounded-xl p-2.5 text-sm text-[#5D605C] focus:outline-none focus:ring-2 focus:ring-[#7B5556]/30"
                        oninput="enforceMaxMin('addMinObjek','addMaxObjek')">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-[#5D605C] mb-1">
                        Max Objek <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="max_objek" id="addMaxObjek"
                        min="0" placeholder="10" value="{{ old('max_objek') }}"
                        class="w-full border border-[#E1E3DE] rounded-xl p-2.5 text-sm text-[#5D605C] focus:outline-none focus:ring-2 focus:ring-[#7B5556]/30"
                        oninput="enforceMaxMin('addMinObjek','addMaxObjek')">
                    <p id="addMaxError" class="text-[10px] text-red-500 mt-1 hidden">Max harus &ge; Min</p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-[#5D605C] mb-1">
                        Bobot Pakar <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="cf_pakar" id="addCfPakar"
                        min="0" max="1" step="0.01" placeholder="0.80" value="{{ old('cf_pakar') }}"
                        class="w-full border border-[#E1E3DE] rounded-xl p-2.5 text-sm text-[#5D605C] focus:outline-none focus:ring-2 focus:ring-[#7B5556]/30">
                    <p class="text-[10px] text-gray-400 mt-1">0.00 – 1.00</p>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="closeModal('addModal')"
                    class="px-4 py-2 rounded-xl bg-[#E1E3DE] text-[#5D605C] text-sm font-semibold hover:bg-gray-200 transition-colors">
                    Batal
                </button>
                <button type="submit"
                    class="px-5 py-2 rounded-xl bg-[#7B5556] text-white text-sm font-semibold hover:bg-[#6a494a] transition-colors">
                    Simpan
                </button>
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
            <h2 class="text-base font-bold text-[#5D605C]">Edit Aturan Knowledge Base</h2>
            <button onclick="closeModal('editModal')" class="text-gray-400 hover:text-gray-600 text-xl leading-none">&times;</button>
        </div>

        <form id="editForm" method="POST" class="p-6 space-y-4">
            @csrf
            @method('PUT')
            <input type="hidden" name="page" id="editPage" value="{{ request()->get('page', 1) }}">

            <div>
                <label class="block text-xs font-semibold text-[#5D605C] mb-1">
                    Masalah Kulit <span class="text-red-500">*</span>
                </label>
                <select name="skin_problem_id" id="editSkinProblem" required
                    class="w-full border border-[#E1E3DE] rounded-xl p-2.5 text-sm text-[#5D605C] focus:outline-none focus:ring-2 focus:ring-[#7B5556]/30">
                    <option value="">-- Pilih Masalah Kulit --</option>
                    @foreach($skinProblems as $sp)
                        <option value="{{ $sp->id }}">{{ $sp->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-[#5D605C] mb-1">
                        Nama Objek AI <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama_objek" id="editNamaObjek"
                        class="w-full border border-[#E1E3DE] rounded-xl p-2.5 text-sm text-[#5D605C] focus:outline-none focus:ring-2 focus:ring-[#7B5556]/30">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-[#5D605C] mb-1">
                        Tingkat Keparahan <span class="text-red-500">*</span>
                    </label>
                    <select name="tingkat_keparahan" id="editKeparahan" required
                        class="w-full border border-[#E1E3DE] rounded-xl p-2.5 text-sm text-[#5D605C] focus:outline-none focus:ring-2 focus:ring-[#7B5556]/30">
                        @foreach(['Ringan', 'Sedang', 'Parah'] as $k)
                            <option value="{{ $k }}">{{ $k }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- GAP 2: Strict numeric bounds --}}
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-[#5D605C] mb-1">
                        Min Objek <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="min_objek" id="editMinObjek" min="0"
                        class="w-full border border-[#E1E3DE] rounded-xl p-2.5 text-sm text-[#5D605C] focus:outline-none focus:ring-2 focus:ring-[#7B5556]/30"
                        oninput="enforceMaxMin('editMinObjek','editMaxObjek')">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-[#5D605C] mb-1">
                        Max Objek <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="max_objek" id="editMaxObjek" min="0"
                        class="w-full border border-[#E1E3DE] rounded-xl p-2.5 text-sm text-[#5D605C] focus:outline-none focus:ring-2 focus:ring-[#7B5556]/30"
                        oninput="enforceMaxMin('editMinObjek','editMaxObjek')">
                    <p id="editMaxError" class="text-[10px] text-red-500 mt-1 hidden">Max harus &ge; Min</p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-[#5D605C] mb-1">
                        Bobot Pakar <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="cf_pakar" id="editCfPakar"
                        min="0" max="1" step="0.01"
                        class="w-full border border-[#E1E3DE] rounded-xl p-2.5 text-sm text-[#5D605C] focus:outline-none focus:ring-2 focus:ring-[#7B5556]/30">
                    <p class="text-[10px] text-gray-400 mt-1">0.00 – 1.00</p>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="closeModal('editModal')"
                    class="px-4 py-2 rounded-xl bg-[#E1E3DE] text-[#5D605C] text-sm font-semibold hover:bg-gray-200 transition-colors">
                    Batal
                </button>
                <button type="submit"
                    class="px-5 py-2 rounded-xl bg-[#7B5556] text-white text-sm font-semibold hover:bg-[#6a494a] transition-colors">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ════════════════════════════════════════════════════════════════════════ --}}
{{-- GAP 4 — DELETION SAFETY BARRIER MODAL                                  --}}
{{-- ════════════════════════════════════════════════════════════════════════ --}}
<div id="deleteConfirmModal" class="fixed inset-0 bg-black/50 hidden justify-center items-center z-50">
    <div class="bg-white rounded-2xl w-[480px] shadow-2xl border border-red-100 overflow-hidden">

        {{-- Red danger header bar --}}
        <div class="bg-red-600 px-6 py-4 flex items-center gap-3">
            <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                </svg>
            </div>
            <h2 class="text-base font-bold text-white tracking-wide">PERINGATAN — Penghapusan Permanen</h2>
        </div>

        <div class="p-6 space-y-4">
            {{-- Primary warning --}}
            <div class="bg-amber-50 border border-amber-200 rounded-xl p-4">
                <p class="text-xs font-bold text-amber-800 uppercase tracking-wide mb-1">Dampak Kritis:</p>
                <p class="text-sm text-amber-700 leading-relaxed">
                    <strong>PENTING:</strong> Menghapus Basis Pengetahuan Pakar ini juga akan menghapus
                    <strong>SELURUH daftar pertanyaan kuesioner anamnesis yang terhubung</strong> secara permanen!
                    Tindakan ini tidak dapat dibatalkan.
                </p>
            </div>

            {{-- Target record --}}
            <div class="bg-[#F9F9F8] border border-[#E1E3DE] rounded-xl px-4 py-3">
                <p class="text-[10px] text-gray-400 uppercase tracking-widest mb-1">Objek yang akan dihapus</p>
                <p id="deleteTargetName" class="text-sm font-bold text-[#5D605C]">—</p>
            </div>

            {{-- GAP 4: typed confirmation input --}}
            <div>
                <label class="block text-xs font-semibold text-[#5D605C] mb-1.5">
                    Ketik <span class="font-mono bg-gray-100 px-1.5 py-0.5 rounded text-red-600">HAPUS</span>
                    untuk mengkonfirmasi penghapusan:
                </label>
                <input type="text" id="deleteConfirmInput" placeholder='Ketik "HAPUS" di sini'
                    oninput="validateDeleteInput()"
                    class="w-full border border-[#E1E3DE] rounded-xl p-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-300 text-[#5D605C]">
                <p id="deleteInputError" class="text-[10px] text-red-500 mt-1 hidden">
                    Ketik HAPUS (huruf kapital) untuk mengaktifkan tombol hapus.
                </p>
            </div>

            <div class="flex gap-3 pt-1">
                <button type="button" onclick="closeDeleteModal()"
                    class="flex-1 px-4 py-2.5 rounded-xl bg-[#E1E3DE] text-[#5D605C] text-sm font-semibold hover:bg-gray-200 transition-colors">
                    Batal
                </button>
                <button type="button" id="confirmDeleteBtn" disabled
                    onclick="executeDelete()"
                    class="flex-1 px-4 py-2.5 rounded-xl bg-red-200 text-red-300 text-sm font-semibold cursor-not-allowed transition-colors"
                    data-form-id="">
                    Ya, Hapus Permanen
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// ─── Modal helpers ──────────────────────────────────────────────────────────
function openModal(id) {
    const modal = document.getElementById(id);
    if (!modal) return;
    if (id === 'addModal') {
        document.getElementById('addPage').value = new URLSearchParams(window.location.search).get('page') || 1;
    }
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeModal(id) {
    const modal = document.getElementById(id);
    if (!modal) return;
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

// ─── Edit modal ─────────────────────────────────────────────────────────────
function openEditModal(id, skinProblemId, namaObjek, keparahan, minObjek, maxObjek, cfPakar) {
    document.getElementById('editSkinProblem').value = skinProblemId || '';
    document.getElementById('editNamaObjek').value   = namaObjek;
    document.getElementById('editKeparahan').value   = keparahan;
    document.getElementById('editMinObjek').value    = minObjek;
    document.getElementById('editMaxObjek').value    = maxObjek;
    document.getElementById('editCfPakar').value     = cfPakar;
    document.getElementById('editPage').value        = new URLSearchParams(window.location.search).get('page') || 1;

    const editMaxError = document.getElementById('editMaxError');
    if (editMaxError) editMaxError.classList.add('hidden');

    document.getElementById('editForm').action = '{{ url("/admin/knowledge-base") }}/' + id;
    openModal('editModal');
}

// ─── Client-side min/max validation (GAP 2 — real-time feedback) ────────────
function enforceMaxMin(minId, maxId) {
    const minEl    = document.getElementById(minId);
    const maxEl    = document.getElementById(maxId);
    const errorId  = maxId === 'addMaxObjek' ? 'addMaxError' : 'editMaxError';
    const errorEl  = document.getElementById(errorId);

    const minVal = parseInt(minEl.value, 10);
    const maxVal = parseInt(maxEl.value, 10);

    if (!isNaN(minVal) && !isNaN(maxVal) && maxVal < minVal) {
        maxEl.classList.add('border-red-400');
        if (errorEl) errorEl.classList.remove('hidden');
    } else {
        maxEl.classList.remove('border-red-400');
        if (errorEl) errorEl.classList.add('hidden');
    }
}

// ─── GAP 4 — Deletion safety barrier ────────────────────────────────────────
let _pendingDeleteFormId = null;

function confirmDelete(id, namaObjek) {
    _pendingDeleteFormId = 'deleteForm-' + id;

    document.getElementById('deleteTargetName').textContent = namaObjek;
    document.getElementById('deleteConfirmInput').value     = '';

    const btn = document.getElementById('confirmDeleteBtn');
    btn.disabled = true;
    btn.className = 'flex-1 px-4 py-2.5 rounded-xl bg-red-200 text-red-300 text-sm font-semibold cursor-not-allowed transition-colors';

    const errEl = document.getElementById('deleteInputError');
    if (errEl) errEl.classList.add('hidden');

    const modal = document.getElementById('deleteConfirmModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');

    // Focus the input for faster UX
    setTimeout(() => document.getElementById('deleteConfirmInput').focus(), 100);
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteConfirmModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    _pendingDeleteFormId = null;
}

function validateDeleteInput() {
    const input = document.getElementById('deleteConfirmInput').value.trim();
    const btn   = document.getElementById('confirmDeleteBtn');
    const errEl = document.getElementById('deleteInputError');

    if (input === 'HAPUS') {
        btn.disabled  = false;
        btn.className = 'flex-1 px-4 py-2.5 rounded-xl bg-red-600 text-white text-sm font-semibold hover:bg-red-700 cursor-pointer transition-colors';
        if (errEl) errEl.classList.add('hidden');
    } else {
        btn.disabled  = true;
        btn.className = 'flex-1 px-4 py-2.5 rounded-xl bg-red-200 text-red-300 text-sm font-semibold cursor-not-allowed transition-colors';
        if (input.length > 0 && errEl) errEl.classList.remove('hidden');
    }
}

function executeDelete() {
    if (!_pendingDeleteFormId) return;
    const form = document.getElementById(_pendingDeleteFormId);
    if (form) form.submit();
}

// Close delete modal on backdrop click
document.getElementById('deleteConfirmModal').addEventListener('click', function(e) {
    if (e.target === this) closeDeleteModal();
});
</script>
@endsection
