@extends('layouts_admin.app')

@section('title', 'Basis Pengetahuan Pakar')

@section('content')
<div class="container">

    {{-- HEADER --}}
    <div class="flex flex-wrap justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Basis Pengetahuan Pakar</h1>
        
        <button onclick="openModal('addModal')" class="bg-pink-500 text-white px-4 py-2 rounded-lg shadow hover:bg-pink-600 transition">
            + Tambah Aturan
        </button>
    </div>

    {{-- FILTER BAR --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-4 mb-5 shadow-sm">
        <form method="GET" action="{{ route('admin.knowledge-base.index') }}" class="flex flex-wrap gap-3">
            <select name="keparahan" class="px-3 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-pink-400">
                <option value="">Semua Tingkat</option>
                @foreach(['Ringan', 'Sedang', 'Parah'] as $k)
                    <option value="{{ $k }}" {{ request('keparahan') == $k ? 'selected' : '' }}>{{ $k }}</option>
                @endforeach
            </select>
            <input type="text" name="search" placeholder="Cari nama objek AI..." value="{{ request('search') }}"
                class="flex-1 min-w-[180px] px-3 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-pink-400">
            <button type="submit" class="px-4 py-2 bg-pink-500 text-white rounded-lg hover:bg-pink-600 transition">
                <i class="fas fa-search"></i> Cari
            </button>
            @if(request('search') || request('keparahan'))
                <a href="{{ route('admin.knowledge-base.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                    <i class="fas fa-times"></i> Reset
                </a>
            @endif
        </form>
    </div>

    {{-- TABLE --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50">
            <h3 class="font-semibold text-gray-700">Daftar Aturan Knowledge Base</h3>
            <span class="text-xs text-gray-400">Total: {{ $knowledgeBases->total() }}</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-pink-50 text-gray-600 uppercase text-xs tracking-wider">
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
                <tbody class="divide-y divide-gray-100">
                    @forelse ($knowledgeBases as $index => $item)
                        @php
                            $kepColor = [
                                'Ringan' => 'bg-green-100 text-green-600',
                                'Sedang' => 'bg-yellow-100 text-yellow-600',
                                'Parah'  => 'bg-red-100 text-red-600',
                            ][$item->tingkat_keparahan] ?? 'bg-gray-100 text-gray-600';
                            $cfPct = round($item->cf_pakar * 100);
                        @endphp
                        <tr class="hover:bg-pink-50 transition">
                            <td class="p-4 text-gray-400 text-xs">
                                {{ $knowledgeBases->firstItem() + $index }}
                            </td>
                            <td class="p-4 font-semibold text-gray-800">{{ $item->nama_objek }}</td>
                            <td class="p-4">
                                @if($item->skinProblem)
                                    <span class="text-xs px-2.5 py-1 bg-pink-100 text-pink-600 rounded-lg font-medium">
                                        {{ $item->skinProblem->name }}
                                    </span>
                                @else
                                    <span class="text-xs text-gray-300 italic">—</span>
                                @endif
                            </td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 {{ $kepColor }} rounded-lg text-xs font-semibold">
                                    {{ $item->tingkat_keparahan }}
                                </span>
                            </td>
                            <td class="p-4 text-center text-gray-700 font-medium text-xs">
                                {{ $item->min_objek }} – {{ $item->max_objek }}
                            </td>
                            <td class="p-4 text-center">
                                <div class="flex flex-col items-center gap-1">
                                    @php
                                        // Mengubah persen (misal 60) menjadi desimal (0.60)
                                        $cfDecimal = $cfPct / 100;
                                    @endphp
                                    
                                    <!-- Tampilan teks desimal dengan format 2 angka di belakang koma (contoh: 0.60) -->
                                    <span class="font-bold text-pink-600 text-sm">
                                        {{ number_format($cfDecimal, 2) }}
                                    </span>
                                    
                                   
                                    <div class="w-16 h-1.5 bg-gray-200 rounded-full overflow-hidden">
                                        <div class="h-full rounded-full {{ $cfPct >= 80 ? 'bg-red-500' : ($cfPct >= 60 ? 'bg-yellow-500' : 'bg-green-500') }}" 
                                            style="width:{{ $cfPct }}%"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4 text-center">
                                <div class="flex justify-center gap-2">
                                    <button type="button"
                                        onclick="openEditModal({{ $item->id }}, {{ $item->skin_problem_id ?? 'null' }}, @js($item->nama_objek), @js($item->tingkat_keparahan), {{ $item->min_objek }}, {{ $item->max_objek }}, {{ $item->cf_pakar }})"
                                        class="px-3 py-1 text-xs bg-pink-100 text-pink-600 rounded-lg hover:bg-pink-200 transition">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <button type="button"
                                        onclick="openDeleteModal({{ $item->id }}, @js($item->nama_objek))"
                                        class="px-3 py-1 text-xs bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-10 text-center text-gray-400">
                                <i class="fas fa-inbox text-2xl mb-2 block"></i>
                                Belum ada aturan knowledge base
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

{{-- MODAL TAMBAH --}}
<div id="addModal" class="fixed inset-0 hidden justify-center items-center z-50" style="background-color: rgba(0, 0, 0, 0.35);">
    <div class="bg-white rounded-2xl w-[520px] shadow-xl border border-gray-100 max-h-[90vh] overflow-y-auto">
        <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
            <h2 class="text-base font-bold text-gray-800">Tambah Aturan Knowledge Base</h2>
            <button onclick="closeModal('addModal')" class="text-gray-400 hover:text-gray-600 text-xl leading-none">&times;</button>
        </div>

        <form action="{{ route('admin.knowledge-base.store') }}" method="POST" class="p-6 space-y-4">
            @csrf
            <input type="hidden" name="page" id="addPage" value="{{ request()->get('page', 1) }}">

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">
                    Masalah Kulit <span class="text-red-500">*</span>
                </label>
                <select name="skin_problem_id" id="addSkinProblem" required
                    class="w-full border border-gray-200 rounded-xl p-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-pink-400">
                    <option value="">-- Pilih Masalah Kulit --</option>
                    @foreach($skinProblems as $sp)
                        <option value="{{ $sp->id }}">{{ $sp->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">
                        Nama Objek AI <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama_objek" id="addNamaObjek" placeholder="cth: pustule"
                        class="w-full border border-gray-200 rounded-xl p-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-pink-400">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">
                        Tingkat Keparahan <span class="text-red-500">*</span>
                    </label>
                    <select name="tingkat_keparahan" id="addKeparahan" required
                        class="w-full border border-gray-200 rounded-xl p-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-pink-400">
                        <option value="">-- Pilih --</option>
                        @foreach(['Ringan', 'Sedang', 'Parah'] as $k)
                            <option value="{{ $k }}">{{ $k }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">
                        Min Objek <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="min_objek" id="addMinObjek" min="0" placeholder="0"
                        class="w-full border border-gray-200 rounded-xl p-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-pink-400">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">
                        Max Objek <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="max_objek" id="addMaxObjek" min="0" placeholder="10"
                        class="w-full border border-gray-200 rounded-xl p-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-pink-400">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">
                        Bobot Pakar <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="cf_pakar" id="addCfPakar" min="0" max="1" step="0.01" placeholder="0.80"
                        class="w-full border border-gray-200 rounded-xl p-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-pink-400">
                    <p class="text-[10px] text-gray-400 mt-1">0.00 – 1.00</p>
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
    <div class="bg-white rounded-2xl w-[520px] shadow-xl border border-pink-100 max-h-[90vh] overflow-y-auto">
        <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
            <h2 class="text-base font-bold text-gray-800">Edit Aturan Knowledge Base</h2>
            <button onclick="closeModal('editModal')" class="text-gray-400 hover:text-gray-600 text-xl leading-none">&times;</button>
        </div>

        <form id="editForm" method="POST" class="p-6 space-y-4">
            @csrf
            @method('PUT')
            <input type="hidden" name="page" id="editPage" value="{{ request()->get('page', 1) }}">

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">
                    Masalah Kulit <span class="text-red-500">*</span>
                </label>
                <select name="skin_problem_id" id="editSkinProblem" required
                    class="w-full border border-gray-200 rounded-xl p-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-pink-400">
                    <option value="">-- Pilih Masalah Kulit --</option>
                    @foreach($skinProblems as $sp)
                        <option value="{{ $sp->id }}">{{ $sp->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">
                        Nama Objek AI <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama_objek" id="editNamaObjek"
                        class="w-full border border-gray-200 rounded-xl p-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-pink-400">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">
                        Tingkat Keparahan <span class="text-red-500">*</span>
                    </label>
                    <select name="tingkat_keparahan" id="editKeparahan" required
                        class="w-full border border-gray-200 rounded-xl p-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-pink-400">
                        @foreach(['Ringan', 'Sedang', 'Parah'] as $k)
                            <option value="{{ $k }}">{{ $k }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">
                        Min Objek <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="min_objek" id="editMinObjek" min="0"
                        class="w-full border border-gray-200 rounded-xl p-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-pink-400">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">
                        Max Objek <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="max_objek" id="editMaxObjek" min="0"
                        class="w-full border border-gray-200 rounded-xl p-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-pink-400">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">
                        Bobot Pakar <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="cf_pakar" id="editCfPakar" min="0" max="1" step="0.01"
                        class="w-full border border-gray-200 rounded-xl p-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-pink-400">
                    <p class="text-[10px] text-gray-400 mt-1">0.00 – 1.00</p>
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
        <h2 class="text-lg font-bold text-gray-800 text-center mb-2">Hapus Aturan?</h2>
        <p class="text-sm text-gray-500 text-center mb-6">
            Apakah Anda yakin ingin menghapus aturan untuk
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
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get('page') || 1;
    }

    function openModal(id) {
        const modal = document.getElementById(id);
        if (!modal) return;

        if (id === 'addModal') {
            document.getElementById('addPage').value = getCurrentPage();
            resetAddForm();
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
            document.getElementById('editError').classList.add('hidden');
        }
    }

    function resetAddForm() {
        document.getElementById('addSkinProblem').value = '';
        document.getElementById('addNamaObjek').value = '';
        document.getElementById('addKeparahan').value = '';
        document.getElementById('addMinObjek').value = '';
        document.getElementById('addMaxObjek').value = '';
        document.getElementById('addCfPakar').value = '';
        const error = document.getElementById('addError');
        if (error) error.classList.add('hidden');
    }

    function openEditModal(id, skinProblemId, namaObjek, keparahan, minObjek, maxObjek, cfPakar) {
        document.getElementById('editSkinProblem').value = skinProblemId || '';
        document.getElementById('editNamaObjek').value = namaObjek;
        document.getElementById('editKeparahan').value = keparahan;
        document.getElementById('editMinObjek').value = minObjek;
        document.getElementById('editMaxObjek').value = maxObjek;
        document.getElementById('editCfPakar').value = cfPakar;
        document.getElementById('editPage').value = getCurrentPage();

        document.getElementById('editForm').action = '{{ url("/admin/knowledge-base") }}/' + id;
        openModal('editModal');
    }

    function openDeleteModal(id, name) {
        document.getElementById('deleteName').textContent = name;
        document.getElementById('deletePage').value = getCurrentPage();
        document.getElementById('deleteForm').action = '{{ url("/admin/knowledge-base") }}/' + id;
        openModal('deleteModal');
    }
</script>

@endsection