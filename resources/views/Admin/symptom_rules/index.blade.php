@extends('layouts_admin.app')
@section('title', 'Pertanyaan Anamnesis')
@section('content')
<div class="container">

    {{-- ─── SUCCESS / ERROR BANNERS ───────────────────────────────────────── --}}
    @if(session('success'))
        <div id="successToast" class="mb-5 bg-green-50 border border-green-200 rounded-2xl px-5 py-4 flex items-center gap-3">
            <div class="w-7 h-7 bg-green-100 rounded-full flex items-center justify-center shrink-0">
                <svg class="w-4 h-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <span class="text-sm font-medium text-green-700">{{ session('success') }}</span>
        </div>
        <script>setTimeout(() => { const t=document.getElementById('successToast'); if(t) t.remove(); }, 4000);</script>
    @endif

    {{-- ─── HEADER ──────────────────────────────────────────────────────── --}}
    <div class="flex flex-wrap justify-between items-center mb-6 gap-3">
        <div>
            <h1 class="text-2xl font-bold text-[#5D605C]">Pertanyaan Anamnesis</h1>
            <p class="text-sm text-gray-400 mt-0.5">Kelola pertanyaan kontekstual yang muncul setelah AI mendeteksi kondisi tertentu</p>
        </div>
        <a href="{{ route('admin.symptom-rules.create') }}"
            class="bg-[#7B5556] text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow-sm hover:bg-[#6a494a] transition-colors">
            + Tambah Pertanyaan
        </a>
    </div>

    {{-- ─── STAT CARDS ──────────────────────────────────────────────────── --}}
    <div class="grid grid-cols-2 gap-4 mb-5">
        <div class="bg-white border border-[#E1E3DE] rounded-2xl p-4 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-[#EBDBDD]/60 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-[#7B5556]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-400 font-medium">Total Pertanyaan</p>
                <p class="text-2xl font-bold text-[#5D605C]">{{ $total }}</p>
            </div>
        </div>
        <div class="bg-white border border-[#E1E3DE] rounded-2xl p-4 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-[#EBDBDD]/60 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-[#7B5556]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-400 font-medium">Jenis Kondisi</p>
                <p class="text-2xl font-bold text-[#5D605C]">{{ $objekList->count() }}</p>
            </div>
        </div>
    </div>

    {{-- ─── TABLE ───────────────────────────────────────────────────────── --}}
    <div class="bg-white rounded-2xl border border-[#E1E3DE] overflow-hidden">

        {{-- Filter bar --}}
        <div class="px-5 py-4 border-b border-[#E1E3DE] bg-[#EBDBDD]/10">
            <form method="GET" action="{{ route('admin.symptom-rules.index') }}" class="flex flex-wrap gap-3">
                <select name="objek"
                    class="px-3 py-2 border border-[#E1E3DE] rounded-xl text-sm text-[#5D605C] focus:outline-none focus:ring-2 focus:ring-[#7B5556]/30 bg-white">
                    <option value="">Semua Kondisi</option>
                    @foreach ($objekList as $nama)
                        <option value="{{ $nama }}" {{ request('objek') === $nama ? 'selected' : '' }}>
                            {{ $nama }}
                        </option>
                    @endforeach
                </select>
                <input type="text" name="search" placeholder="Cari pertanyaan..."
                    value="{{ request('search') }}"
                    class="flex-1 min-w-[180px] px-3 py-2 border border-[#E1E3DE] rounded-xl text-sm text-[#5D605C] focus:outline-none focus:ring-2 focus:ring-[#7B5556]/30">
                <button type="submit"
                    class="px-4 py-2 bg-[#7B5556] text-white rounded-xl text-sm font-semibold hover:bg-[#6a494a] transition-colors">
                    Cari
                </button>
                @if(request('search') || request('objek'))
                    <a href="{{ route('admin.symptom-rules.index') }}"
                        class="px-4 py-2 bg-[#E1E3DE] text-[#5D605C] rounded-xl text-sm font-semibold hover:bg-gray-200 transition-colors">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        {{-- Table body --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-[#EBDBDD]/30 text-[#5D605C] uppercase text-xs tracking-wider">
                    <tr>
                        <th class="p-4 text-left w-10">No</th>
                        <th class="p-4 text-left">Kondisi Kulit (KB)</th>
                        <th class="p-4 text-left">Keparahan</th>
                        <th class="p-4 text-left">Pertanyaan Anamnesis</th>
                        <th class="p-4 text-center w-28">CF Gejala</th>
                        <th class="p-4 text-center w-32">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-[#E1E3DE]/60">
                    @forelse ($rules as $rule)
                        @php
                            $keparahan = $rule->knowledgeBase?->tingkat_keparahan;
                            $kepColor  = [
                                'Ringan' => 'bg-green-50 text-green-700 border-green-200',
                                'Sedang' => 'bg-amber-50 text-amber-700 border-amber-200',
                                'Parah'  => 'bg-red-50 text-red-700 border-red-200',
                            ][$keparahan] ?? 'bg-gray-50 text-gray-600 border-gray-200';
                            $cf    = $rule->cf_gejala;
                            $cfPct = intval($cf * 100);
                            $cfBar = $cf >= 0.8 ? 'bg-red-500' : ($cf >= 0.6 ? 'bg-amber-400' : 'bg-green-500');
                            $cfTxt = $cf >= 0.8 ? 'text-red-600' : ($cf >= 0.6 ? 'text-amber-600' : 'text-green-600');
                        @endphp
                        <tr class="hover:bg-[#EBDBDD]/10 transition-colors">
                            <td class="p-4 text-gray-400 text-xs">
                                {{ $loop->iteration + ($rules->currentPage() - 1) * $rules->perPage() }}
                            </td>
                            <td class="p-4">
                                <span class="font-medium text-[#5D605C]">
                                    {{ $rule->knowledgeBase?->nama_objek ?? '—' }}
                                </span>
                            </td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 border {{ $kepColor }} rounded-lg text-xs font-semibold">
                                    {{ $keparahan ?? '—' }}
                                </span>
                            </td>
                            <td class="p-4 text-[#5D605C] leading-relaxed max-w-xs">
                                {{ $rule->pertanyaan }}
                            </td>
                            <td class="p-4 text-center">
                                <div class="flex flex-col items-center gap-1">
                                    <span class="font-bold text-sm {{ $cfTxt }}">{{ number_format($cf, 1) }}</span>
                                    <div class="w-16 h-1.5 bg-[#E1E3DE] rounded-full overflow-hidden">
                                        <div class="h-full rounded-full {{ $cfBar }}" style="width:{{ $cfPct }}%"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4 text-center">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('admin.symptom-rules.edit', $rule->id) }}"
                                        class="px-3 py-1.5 text-xs bg-[#EBDBDD] text-[#7B5556] rounded-lg hover:bg-[#7B5556] hover:text-white transition-colors font-medium">
                                        Edit
                                    </a>
                                    <form id="srDeleteForm-{{ $rule->id }}"
                                        action="{{ route('admin.symptom-rules.destroy', $rule->id) }}"
                                        method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <button type="button"
                                        onclick="confirmSrDelete({{ $rule->id }}, @js(\Illuminate\Support\Str::limit($rule->pertanyaan, 55)))"
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
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Belum ada pertanyaan anamnesis. Klik <strong>Tambah Pertanyaan</strong> untuk memulai.
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">{{ $rules->appends(request()->query())->links() }}</div>

</div>

{{-- ════════════════════════════════════════════════════════════════════════ --}}
{{-- MODAL HAPUS PERTANYAAN ANAMNESIS                                        --}}
{{-- ════════════════════════════════════════════════════════════════════════ --}}
<div id="srDeleteModal" class="fixed inset-0 bg-black/40 hidden justify-center items-center z-50">
    <div class="bg-white rounded-2xl w-96 p-6 shadow-xl border border-[#E1E3DE]">
        <div class="w-14 h-14 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-red-200">
            <svg class="w-6 h-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
        </div>
        <h2 class="text-base font-bold text-[#5D605C] text-center mb-2">Hapus Pertanyaan?</h2>
        <p class="text-xs text-gray-400 text-center mb-2">Pertanyaan yang akan dihapus:</p>
        <p id="srDeleteName" class="text-sm text-[#5D605C] text-center font-medium italic mb-5 px-2"></p>
        <p class="text-xs text-gray-400 text-center mb-6">Data yang sudah dihapus tidak dapat dikembalikan.</p>
        <div class="flex gap-3">
            <button type="button" onclick="closeSrDeleteModal()"
                class="flex-1 px-4 py-2.5 rounded-xl bg-[#E1E3DE] text-[#5D605C] text-sm font-semibold hover:bg-gray-200 transition-colors">
                Batal
            </button>
            <button type="button" id="srDeleteConfirmBtn" onclick="executeSrDelete()"
                class="flex-1 px-4 py-2.5 rounded-xl bg-red-500 text-white text-sm font-semibold hover:bg-red-600 transition-colors">
                Ya, Hapus
            </button>
        </div>
    </div>
</div>

<script>
let _srPendingFormId = null;

function confirmSrDelete(id, text) {
    _srPendingFormId = 'srDeleteForm-' + id;
    document.getElementById('srDeleteName').textContent = '"' + text + '"';
    const modal = document.getElementById('srDeleteModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeSrDeleteModal() {
    const modal = document.getElementById('srDeleteModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    _srPendingFormId = null;
}

function executeSrDelete() {
    if (!_srPendingFormId) return;
    const form = document.getElementById(_srPendingFormId);
    if (form) form.submit();
}

document.getElementById('srDeleteModal').addEventListener('click', function(e) {
    if (e.target === this) closeSrDeleteModal();
});
</script>
@endsection
