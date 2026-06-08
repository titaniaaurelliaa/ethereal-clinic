@extends('layouts_admin.app')

@section('title', 'Pertanyaan Anamnesis')

@section('content')
<div class="container">

    {{-- HEADER --}}
    <div class="flex flex-wrap justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Pertanyaan Gejala</h1>
            <p class="text-sm text-gray-400 mt-0.5">Kelola pertanyaan anamnesis yang muncul berdasarkan kondisi kulit terdeteksi</p>
        </div>
        <button onclick="openCreateModal()" class="bg-pink-500 text-white px-4 py-2 rounded-lg shadow hover:bg-pink-600 transition">
            + Tambah Pertanyaan
        </button>
    </div>

    {{-- FILTER BAR --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-4 mb-5 shadow-sm">
        <form method="GET" action="{{ route('admin.symptom-rules.index') }}" class="flex flex-wrap gap-3">
            <select name="objek" class="px-3 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-pink-400">
                <option value="">Semua Kondisi</option>
                @foreach ($objekList as $nama)
                    <option value="{{ $nama }}" {{ request('objek') === $nama ? 'selected' : '' }}>
                        {{ $nama }}
                    </option>
                @endforeach
            </select>
            <input type="text" name="search" placeholder="Cari pertanyaan..." value="{{ request('search') }}"
                class="flex-1 min-w-[180px] px-3 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-pink-400">
            <button type="submit" class="px-4 py-2 bg-pink-500 text-white rounded-lg hover:bg-pink-600 transition">
                <i class="fas fa-search"></i> Cari
            </button>
            @if(request('search') || request('objek'))
                <a href="{{ route('admin.symptom-rules.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                    <i class="fas fa-times"></i> Reset
                </a>
            @endif
        </form>
    </div>

    {{-- TABLE --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50">
            <h3 class="font-semibold text-gray-700">Daftar Pertanyaan Gejala</h3>
            <span class="text-xs text-gray-400">Total: {{ $rules->total() }}</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-pink-50 text-gray-600 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="p-4 text-left">No</th>
                        <th class="p-4 text-left">Kondisi Kulit (KB)</th>
                        <th class="p-4 text-left">Keparahan</th>
                        <th class="p-4 text-left">Pertanyaan Anamnesis</th>
                        <th class="p-4 text-center w-28">CF Pakar</th>
                        <th class="p-4 text-center w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($rules as $rule)
                        @php
                            $keparahan = $rule->knowledgeBase?->tingkat_keparahan;
                            $kepColor = [
                                'Ringan' => 'bg-green-100 text-green-600',
                                'Sedang' => 'bg-yellow-100 text-yellow-600',
                                'Parah'  => 'bg-red-100 text-red-600',
                            ][$keparahan] ?? 'bg-gray-100 text-gray-600';
                            $cf = $rule->cf_pakar;
                            $cfPct = intval($cf * 100);
                            $cfBar = $cf >= 0.8 ? 'bg-red-500' : ($cf >= 0.6 ? 'bg-yellow-500' : 'bg-green-500');
                        @endphp
                        <tr class="hover:bg-pink-50 transition">
                            <td class="p-4 text-gray-400 text-xs">
                                {{ $loop->iteration + ($rules->currentPage() - 1) * $rules->perPage() }}
                            </td>
                            <td class="p-4 font-medium text-gray-800">
                                {{ $rule->knowledgeBase?->nama_objek ?? '—' }}
                            </td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 {{ $kepColor }} rounded-lg text-xs font-semibold">
                                    {{ $keparahan ?? '—' }}
                                </span>
                            </td>
                            <td class="p-4 text-gray-600 leading-relaxed max-w-xs">
                                {{ $rule->pertanyaan }}
                            </td>
                            <td class="p-4 text-center">
                                <div class="flex flex-col items-center gap-1">
                                    <span class="font-bold text-sm text-pink-600">{{ number_format($cf, 1) }}</span>
                                    <div class="w-16 h-1.5 bg-gray-200 rounded-full overflow-hidden">
                                        <div class="h-full rounded-full {{ $cfBar }}" style="width:{{ $cfPct }}%"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4 text-center">
                                <div class="flex justify-center gap-2">
                                    <button type="button"
                                        onclick="openEditModal({{ $rule->id }}, {{ $rule->knowledge_base_id }}, @js($rule->pertanyaan), {{ $rule->cf_pakar }})"
                                        class="px-3 py-1 text-xs bg-pink-100 text-pink-600 rounded-lg hover:bg-pink-200 transition">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <button type="button"
                                        onclick="openDeleteModal({{ $rule->id }}, @js(\Illuminate\Support\Str::limit($rule->pertanyaan, 55)))"
                                        class="px-3 py-1 text-xs bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-10 text-center text-gray-400">
                                <i class="fas fa-inbox text-2xl mb-2 block"></i>
                                Belum ada pertanyaan anamnesis
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $rules->appends(request()->query())->links() }}
    </div>

</div>

{{-- MODAL CREATE --}}
<div id="createModal" class="fixed inset-0 hidden justify-center items-center z-50" style="background-color: rgba(0, 0, 0, 0.35);">
    <div class="bg-white rounded-2xl w-[600px] shadow-xl border border-gray-100 max-h-[90vh] overflow-y-auto">
        <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between sticky top-0 bg-white">
            <h2 class="text-base font-bold text-gray-800">Tambah Pertanyaan Anamnesis</h2>
            <button onclick="closeModal('createModal')" class="text-gray-400 hover:text-gray-600 text-xl leading-none">&times;</button>
        </div>

        <form id="createForm" action="{{ route('admin.symptom-rules.store') }}" method="POST" class="p-6 space-y-4">
            @csrf
            <input type="hidden" name="page" id="createPage" value="{{ request()->get('page', 1) }}">

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">
                    Kondisi Kulit Terdeteksi <span class="text-red-500">*</span>
                </label>
                <select name="knowledge_base_id" id="createKnowledgeBaseId" required
                    class="w-full border border-gray-200 rounded-xl p-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-pink-400">
                    <option value="">-- Pilih Kondisi Kulit --</option>
                    @php $prevObjek = ''; @endphp
                    @foreach ($knowledgeBases as $kb)
                        @if ($kb->nama_objek !== $prevObjek)
                            @if ($prevObjek !== '') </optgroup> @endif
                            <optgroup label="{{ $kb->nama_objek }}">
                            @php $prevObjek = $kb->nama_objek; @endphp
                        @endif
                        <option value="{{ $kb->id }}">
                            {{ $kb->nama_objek }} — {{ $kb->tingkat_keparahan }}
                            ({{ $kb->min_objek }}–{{ $kb->max_objek }} objek)
                        </option>
                    @endforeach
                    @if ($prevObjek !== '') </optgroup> @endif
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">
                    Teks Pertanyaan <span class="text-red-500">*</span>
                </label>
                <textarea name="pertanyaan" id="createPertanyaan" rows="3" placeholder="Contoh: Apakah benjolan terasa nyeri saat tidak disentuh?"
                    class="w-full border border-gray-200 rounded-xl p-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-pink-400"></textarea>
                <div class="flex justify-end mt-1">
                    <span id="createCharCount" class="text-xs text-gray-400">0 / 500</span>
                </div>
            </div>

            {{-- CF PAKAR PILIHAN LANGSUNG 0.1 - 1.0 --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-3">
                    Nilai CF Pakar <span class="text-red-500">*</span>
                </label>

                {{-- Info Level Keyakinan --}}
                <div class="flex gap-2 mb-4 text-xs flex-wrap">
                    <span class="px-3 py-1.5 bg-green-100 text-green-700 rounded-full border border-green-200 font-semibold">
                        🟢 Rendah
                    </span>
                    <span class="px-3 py-1.5 bg-yellow-100 text-yellow-700 rounded-full border border-yellow-200 font-semibold">
                        🟡 Sedang
                    </span>
                    <span class="px-3 py-1.5 bg-red-100 text-red-700 rounded-full border border-red-200 font-semibold">
                        🔴 Tinggi
                    </span>
                </div>

                {{-- Tombol Pilihan CF --}}
                <div class="grid grid-cols-5 gap-2 mb-4">
                    <button type="button" data-cf="0.1" class="cf-option-create px-3 py-2 rounded-lg border border-gray-200 text-gray-700 text-sm font-medium hover:bg-pink-50 hover:border-pink-300 transition-all">0.1</button>
                    <button type="button" data-cf="0.2" class="cf-option-create px-3 py-2 rounded-lg border border-gray-200 text-gray-700 text-sm font-medium hover:bg-pink-50 hover:border-pink-300 transition-all">0.2</button>
                    <button type="button" data-cf="0.3" class="cf-option-create px-3 py-2 rounded-lg border border-gray-200 text-gray-700 text-sm font-medium hover:bg-pink-50 hover:border-pink-300 transition-all">0.3</button>
                    <button type="button" data-cf="0.4" class="cf-option-create px-3 py-2 rounded-lg border border-gray-200 text-gray-700 text-sm font-medium hover:bg-pink-50 hover:border-pink-300 transition-all">0.4</button>
                    <button type="button" data-cf="0.5" class="cf-option-create px-3 py-2 rounded-lg border border-gray-200 text-gray-700 text-sm font-medium hover:bg-pink-50 hover:border-pink-300 transition-all">0.5</button>
                    <button type="button" data-cf="0.6" class="cf-option-create px-3 py-2 rounded-lg border border-gray-200 text-gray-700 text-sm font-medium hover:bg-pink-50 hover:border-pink-300 transition-all">0.6</button>
                    <button type="button" data-cf="0.7" class="cf-option-create px-3 py-2 rounded-lg border border-gray-200 text-gray-700 text-sm font-medium hover:bg-pink-50 hover:border-pink-300 transition-all">0.7</button>
                    <button type="button" data-cf="0.8" class="cf-option-create px-3 py-2 rounded-lg border border-gray-200 text-gray-700 text-sm font-medium hover:bg-pink-50 hover:border-pink-300 transition-all">0.8</button>
                    <button type="button" data-cf="0.9" class="cf-option-create px-3 py-2 rounded-lg border border-gray-200 text-gray-700 text-sm font-medium hover:bg-pink-50 hover:border-pink-300 transition-all">0.9</button>
                    <button type="button" data-cf="1.0" class="cf-option-create px-3 py-2 rounded-lg border border-gray-200 text-pink-600 text-sm font-bold hover:bg-pink-100 hover:border-pink-400 transition-all">1.0</button>
                </div>

                {{-- Input hidden untuk nilai CF --}}
                <input type="hidden" id="createCfPakar" name="cf_pakar" value="0.5">

                {{-- Tampilan nilai yang dipilih --}}
                <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-600">Nilai yang dipilih:</span>
                        <div class="flex items-center gap-3">
                            <span id="createCfDisplay" class="text-2xl font-bold text-pink-600">0.5</span>
                            <span id="createCfLevelDisplay" class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700">Sedang</span>
                        </div>
                    </div>
                    <div class="mt-2 h-2 bg-gray-200 rounded-full overflow-hidden">
                        <div id="createCfProgress" class="h-full rounded-full transition-all duration-300" style="width: 50%; background: linear-gradient(to right, #22c55e, #eab308, #ef4444);"></div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-2 border-t border-gray-100">
                <button type="button" onclick="closeModal('createModal')" class="px-4 py-2 rounded-xl bg-gray-200 text-gray-600 text-sm font-semibold hover:bg-gray-300 transition-colors">
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
<div id="editModal" class="fixed inset-0 hidden justify-center items-center z-50" style="background-color: rgba(0, 0, 0, 0.35);">
    <div class="bg-white rounded-2xl w-[600px] shadow-xl border border-gray-100 max-h-[90vh] overflow-y-auto">
        <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between sticky top-0 bg-white">
            <h2 class="text-base font-bold text-gray-800">Edit Pertanyaan Anamnesis</h2>
            <button onclick="closeModal('editModal')" class="text-gray-400 hover:text-gray-600 text-xl leading-none">&times;</button>
        </div>

        <form id="editForm" method="POST" class="p-6 space-y-4">
            @csrf
            @method('PUT')
            <input type="hidden" name="page" id="editPage" value="{{ request()->get('page', 1) }}">
            <input type="hidden" name="id" id="editId">

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">
                    Kondisi Kulit Terdeteksi <span class="text-red-500">*</span>
                </label>
                <select name="knowledge_base_id" id="editKnowledgeBaseId" required
                    class="w-full border border-gray-200 rounded-xl p-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-pink-400">
                    <option value="">-- Pilih Kondisi Kulit --</option>
                    @php $prevObjek = ''; @endphp
                    @foreach ($knowledgeBases as $kb)
                        @if ($kb->nama_objek !== $prevObjek)
                            @if ($prevObjek !== '') </optgroup> @endif
                            <optgroup label="{{ $kb->nama_objek }}">
                            @php $prevObjek = $kb->nama_objek; @endphp
                        @endif
                        <option value="{{ $kb->id }}">
                            {{ $kb->nama_objek }} — {{ $kb->tingkat_keparahan }}
                            ({{ $kb->min_objek }}–{{ $kb->max_objek }} objek)
                        </option>
                    @endforeach
                    @if ($prevObjek !== '') </optgroup> @endif
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">
                    Teks Pertanyaan <span class="text-red-500">*</span>
                </label>
                <textarea name="pertanyaan" id="editPertanyaan" rows="3"
                    class="w-full border border-gray-200 rounded-xl p-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-pink-400"></textarea>
                <div class="flex justify-end mt-1">
                    <span id="editCharCount" class="text-xs text-gray-400">0 / 500</span>
                </div>
            </div>

            {{-- CF PAKAR PILIHAN LANGSUNG 0.1 - 1.0 --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-3">
                    Nilai CF Pakar <span class="text-red-500">*</span>
                </label>

                {{-- Info Level Keyakinan --}}
                <div class="flex gap-2 mb-4 text-xs flex-wrap">
                    <span class="px-3 py-1.5 bg-green-100 text-green-700 rounded-full border border-green-200 font-semibold">
                        🟢 Rendah
                    </span>
                    <span class="px-3 py-1.5 bg-yellow-100 text-yellow-700 rounded-full border border-yellow-200 font-semibold">
                        🟡 Sedang
                    </span>
                    <span class="px-3 py-1.5 bg-red-100 text-red-700 rounded-full border border-red-200 font-semibold">
                        🔴 Tinggi
                    </span>
                </div>

                {{-- Tombol Pilihan CF --}}
                <div class="grid grid-cols-5 gap-2 mb-4">
                    <button type="button" data-cf="0.1" class="cf-option-edit px-3 py-2 rounded-lg border border-gray-200 text-gray-700 text-sm font-medium hover:bg-pink-50 hover:border-pink-300 transition-all">0.1</button>
                    <button type="button" data-cf="0.2" class="cf-option-edit px-3 py-2 rounded-lg border border-gray-200 text-gray-700 text-sm font-medium hover:bg-pink-50 hover:border-pink-300 transition-all">0.2</button>
                    <button type="button" data-cf="0.3" class="cf-option-edit px-3 py-2 rounded-lg border border-gray-200 text-gray-700 text-sm font-medium hover:bg-pink-50 hover:border-pink-300 transition-all">0.3</button>
                    <button type="button" data-cf="0.4" class="cf-option-edit px-3 py-2 rounded-lg border border-gray-200 text-gray-700 text-sm font-medium hover:bg-pink-50 hover:border-pink-300 transition-all">0.4</button>
                    <button type="button" data-cf="0.5" class="cf-option-edit px-3 py-2 rounded-lg border border-gray-200 text-gray-700 text-sm font-medium hover:bg-pink-50 hover:border-pink-300 transition-all">0.5</button>
                    <button type="button" data-cf="0.6" class="cf-option-edit px-3 py-2 rounded-lg border border-gray-200 text-gray-700 text-sm font-medium hover:bg-pink-50 hover:border-pink-300 transition-all">0.6</button>
                    <button type="button" data-cf="0.7" class="cf-option-edit px-3 py-2 rounded-lg border border-gray-200 text-gray-700 text-sm font-medium hover:bg-pink-50 hover:border-pink-300 transition-all">0.7</button>
                    <button type="button" data-cf="0.8" class="cf-option-edit px-3 py-2 rounded-lg border border-gray-200 text-gray-700 text-sm font-medium hover:bg-pink-50 hover:border-pink-300 transition-all">0.8</button>
                    <button type="button" data-cf="0.9" class="cf-option-edit px-3 py-2 rounded-lg border border-gray-200 text-gray-700 text-sm font-medium hover:bg-pink-50 hover:border-pink-300 transition-all">0.9</button>
                    <button type="button" data-cf="1.0" class="cf-option-edit px-3 py-2 rounded-lg border border-gray-200 text-pink-600 text-sm font-bold hover:bg-pink-100 hover:border-pink-400 transition-all">1.0</button>
                </div>

                {{-- Input hidden untuk nilai CF --}}
                <input type="hidden" id="editCfPakar" name="cf_pakar" value="0.5">

                {{-- Tampilan nilai yang dipilih --}}
                <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-600">Nilai yang dipilih:</span>
                        <div class="flex items-center gap-3">
                            <span id="editCfDisplay" class="text-2xl font-bold text-pink-600">0.5</span>
                            <span id="editCfLevelDisplay" class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700">Sedang</span>
                        </div>
                    </div>
                    <div class="mt-2 h-2 bg-gray-200 rounded-full overflow-hidden">
                        <div id="editCfProgress" class="h-full rounded-full transition-all duration-300" style="width: 50%; background: linear-gradient(to right, #22c55e, #eab308, #ef4444);"></div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-2 border-t border-gray-100">
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
        <h2 class="text-lg font-bold text-gray-800 text-center mb-2">Hapus Pertanyaan?</h2>
        <p class="text-sm text-gray-500 text-center mb-4">
            Apakah Anda yakin ingin menghapus pertanyaan:
        </p>
        <p id="deleteName" class="text-sm text-gray-700 text-center font-medium italic mb-6 px-2"></p>
        <p class="text-xs text-gray-400 text-center mb-6">Data yang sudah dihapus tidak dapat dikembalikan.</p>
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
    // Fungsi update display CF untuk Create Modal
    function updateCreateCfDisplay(value) {
        const cfValue = parseFloat(value);
        const percent = Math.round(cfValue * 100);
        document.getElementById('createCfDisplay').textContent = cfValue.toFixed(1);
        document.getElementById('createCfPakar').value = cfValue.toFixed(1);
        document.getElementById('createCfProgress').style.width = percent + '%';
        
        // Update level
        const levelSpan = document.getElementById('createCfLevelDisplay');
        if (cfValue >= 0.8) {
            levelSpan.textContent = 'Tinggi';
            levelSpan.className = 'px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700';
        } else if (cfValue >= 0.5) {
            levelSpan.textContent = 'Sedang';
            levelSpan.className = 'px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700';
        } else {
            levelSpan.textContent = 'Rendah';
            levelSpan.className = 'px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700';
        }
    }

    // Event listener untuk tombol CF di Create Modal
    document.querySelectorAll('.cf-option-create').forEach(btn => {
        btn.addEventListener('click', function() {
            const cfValue = this.getAttribute('data-cf');
            updateCreateCfDisplay(cfValue);
            
            // Update style tombol
            document.querySelectorAll('.cf-option-create').forEach(b => {
                b.classList.remove('bg-pink-500', 'text-white', 'border-pink-500');
                b.classList.add('border-gray-200', 'text-gray-700');
            });
            this.classList.remove('border-gray-200', 'text-gray-700');
            this.classList.add('bg-pink-500', 'text-white', 'border-pink-500');
        });
    });

    // Fungsi update display CF untuk Edit Modal
    function updateEditCfDisplay(value) {
        const cfValue = parseFloat(value);
        const percent = Math.round(cfValue * 100);
        document.getElementById('editCfDisplay').textContent = cfValue.toFixed(1);
        document.getElementById('editCfPakar').value = cfValue.toFixed(1);
        document.getElementById('editCfProgress').style.width = percent + '%';
        
        // Update level
        const levelSpan = document.getElementById('editCfLevelDisplay');
        if (cfValue >= 0.8) {
            levelSpan.textContent = 'Tinggi';
            levelSpan.className = 'px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700';
        } else if (cfValue >= 0.5) {
            levelSpan.textContent = 'Sedang';
            levelSpan.className = 'px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700';
        } else {
            levelSpan.textContent = 'Rendah';
            levelSpan.className = 'px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700';
        }
    }

    // Event listener untuk tombol CF di Edit Modal
    document.querySelectorAll('.cf-option-edit').forEach(btn => {
        btn.addEventListener('click', function() {
            const cfValue = this.getAttribute('data-cf');
            updateEditCfDisplay(cfValue);
            
            // Update style tombol
            document.querySelectorAll('.cf-option-edit').forEach(b => {
                b.classList.remove('bg-pink-500', 'text-white', 'border-pink-500');
                b.classList.add('border-gray-200', 'text-gray-700');
            });
            this.classList.remove('border-gray-200', 'text-gray-700');
            this.classList.add('bg-pink-500', 'text-white', 'border-pink-500');
        });
    });

    // Character Counter untuk Create Modal
    const createTextarea = document.getElementById('createPertanyaan');
    const createCharCount = document.getElementById('createCharCount');
    if (createTextarea) {
        function updateCreateCount() {
            const len = createTextarea.value.length;
            createCharCount.textContent = len + ' / 500';
            createCharCount.classList.toggle('text-red-500', len > 480);
            createCharCount.classList.toggle('text-gray-400', len <= 480);
        }
        createTextarea.addEventListener('input', updateCreateCount);
        updateCreateCount();
    }

    // Character Counter untuk Edit Modal
    const editTextarea = document.getElementById('editPertanyaan');
    const editCharCount = document.getElementById('editCharCount');
    if (editTextarea) {
        function updateEditCount() {
            const len = editTextarea.value.length;
            editCharCount.textContent = len + ' / 500';
            editCharCount.classList.toggle('text-red-500', len > 480);
            editCharCount.classList.toggle('text-gray-400', len <= 480);
        }
        editTextarea.addEventListener('input', updateEditCount);
        if (editTextarea.value) updateEditCount();
    }

    function getCurrentPage() {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get('page') || 1;
    }

    function openCreateModal() {
        document.getElementById('createPage').value = getCurrentPage();
        document.getElementById('createForm').reset();
        document.getElementById('createCfPakar').value = '0.5';
        updateCreateCfDisplay(0.5);
        
        // Reset style tombol
        document.querySelectorAll('.cf-option-create').forEach(btn => {
            btn.classList.remove('bg-pink-500', 'text-white', 'border-pink-500');
            btn.classList.add('border-gray-200', 'text-gray-700');
        });
        // Highlight tombol 0.5
        document.querySelector('.cf-option-create[data-cf="0.5"]')?.classList.add('bg-pink-500', 'text-white', 'border-pink-500');
        
        if (createTextarea) updateCreateCount();
        openModal('createModal');
    }

    function openEditModal(id, knowledgeBaseId, pertanyaan, cfPakar) {
        document.getElementById('editId').value = id;
        document.getElementById('editKnowledgeBaseId').value = knowledgeBaseId;
        document.getElementById('editPertanyaan').value = pertanyaan;
        updateEditCfDisplay(cfPakar);
        document.getElementById('editPage').value = getCurrentPage();
        
        // Reset style tombol
        document.querySelectorAll('.cf-option-edit').forEach(btn => {
            btn.classList.remove('bg-pink-500', 'text-white', 'border-pink-500');
            btn.classList.add('border-gray-200', 'text-gray-700');
        });
        // Highlight tombol sesuai nilai CF
        const targetBtn = document.querySelector(`.cf-option-edit[data-cf="${cfPakar}"]`);
        if (targetBtn) {
            targetBtn.classList.remove('border-gray-200', 'text-gray-700');
            targetBtn.classList.add('bg-pink-500', 'text-white', 'border-pink-500');
        } else if (cfPakar >= 1.0) {
            document.querySelector('.cf-option-edit[data-cf="1.0"]')?.classList.add('bg-pink-500', 'text-white', 'border-pink-500');
        }
        
        if (editTextarea) updateEditCount();
        
        document.getElementById('editForm').action = '{{ url("/admin/symptom-rules") }}/' + id;
        openModal('editModal');
    }

    function openDeleteModal(id, text) {
        document.getElementById('deleteName').textContent = '"' + text + '"';
        document.getElementById('deletePage').value = getCurrentPage();
        document.getElementById('deleteForm').action = '{{ url("/admin/symptom-rules") }}/' + id;
        openModal('deleteModal');
    }

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

@endsection