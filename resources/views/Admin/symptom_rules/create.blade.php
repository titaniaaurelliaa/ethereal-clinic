@extends('layouts_admin.app')
@section('title', 'Tambah Pertanyaan Anamnesis')
@section('content')
<div class="max-w-2xl mx-auto">

    {{-- ─── BREADCRUMB ──────────────────────────────────────────────────── --}}
    <nav class="flex items-center gap-2 text-sm text-gray-400 mb-6">
        <a href="{{ route('admin.symptom-rules.index') }}"
            class="hover:text-[#7B5556] transition-colors font-medium text-[#5D605C]">
            Pertanyaan Anamnesis
        </a>
        <span class="text-gray-300">/</span>
        <span class="text-[#7B5556] font-semibold">Tambah Baru</span>
    </nav>

    {{-- ─── VALIDATION ERROR BANNER ────────────────────────────────────── --}}
    @if($errors->any())
        <div class="mb-5 bg-red-50 border border-red-200 rounded-2xl p-5">
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center shrink-0 mt-0.5">
                    <svg class="w-4 h-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-red-700 mb-1">Validasi Gagal:</h4>
                    <ul class="space-y-0.5">
                        @foreach($errors->all() as $error)
                            <li class="text-xs text-red-600">&#x25CF; {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    {{-- ─── FORM CARD ───────────────────────────────────────────────────── --}}
    <div class="bg-white rounded-2xl border border-[#E1E3DE] overflow-hidden">

        {{-- Card header --}}
        <div class="flex items-center gap-3 px-6 py-5 border-b border-[#E1E3DE] bg-[#EBDBDD]/20">
            <div class="w-10 h-10 rounded-xl bg-[#EBDBDD]/60 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-[#7B5556]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
            </div>
            <div>
                <h2 class="font-bold text-[#5D605C] text-base">Tambah Pertanyaan Anamnesis</h2>
                <p class="text-xs text-gray-400">Pertanyaan ini muncul kontekstual setelah AI mendeteksi kondisi yang dipilih.</p>
            </div>
        </div>

        {{-- Form body --}}
        <form action="{{ route('admin.symptom-rules.store') }}" method="POST" class="p-6 space-y-5">
            @csrf

            {{-- Knowledge Base dropdown --}}
            <div>
                <label for="knowledge_base_id" class="block text-xs font-semibold text-[#5D605C] mb-1">
                    Kondisi Kulit Terdeteksi <span class="text-red-500">*</span>
                </label>
                <p class="text-xs text-gray-400 mb-2">
                    Pilih kombinasi nama objek dan tingkat keparahan yang memicu pertanyaan ini.
                </p>
                <select id="knowledge_base_id" name="knowledge_base_id"
                    class="w-full px-3 py-2.5 border rounded-xl text-sm text-[#5D605C] focus:outline-none focus:ring-2 focus:ring-[#7B5556]/30 bg-white
                        {{ $errors->has('knowledge_base_id') ? 'border-red-400' : 'border-[#E1E3DE]' }}">
                    <option value="">— Pilih Kondisi Kulit —</option>
                    @php $prevObjek = ''; @endphp
                    @foreach ($knowledgeBases as $kb)
                        @if ($kb->nama_objek !== $prevObjek)
                            @if ($prevObjek !== '') </optgroup> @endif
                            <optgroup label="{{ $kb->nama_objek }}">
                            @php $prevObjek = $kb->nama_objek; @endphp
                        @endif
                        <option value="{{ $kb->id }}" {{ old('knowledge_base_id') == $kb->id ? 'selected' : '' }}>
                            {{ $kb->nama_objek }} — {{ $kb->tingkat_keparahan }}
                            ({{ $kb->min_objek }}–{{ $kb->max_objek }} objek)
                        </option>
                    @endforeach
                    @if ($prevObjek !== '') </optgroup> @endif
                </select>
                @error('knowledge_base_id')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Pertanyaan textarea --}}
            <div>
                <label for="pertanyaan" class="block text-xs font-semibold text-[#5D605C] mb-1">
                    Teks Pertanyaan <span class="text-red-500">*</span>
                </label>
                <p class="text-xs text-gray-400 mb-2">
                    Gunakan bahasa yang mudah dipahami pasien. Hindari istilah medis yang rumit.
                </p>
                <textarea id="pertanyaan" name="pertanyaan" rows="3"
                    placeholder="Contoh: Apakah benjolan terasa nyeri saat tidak disentuh?"
                    maxlength="500"
                    class="w-full px-3 py-2.5 border rounded-xl text-sm text-[#5D605C] resize-none focus:outline-none focus:ring-2 focus:ring-[#7B5556]/30
                        {{ $errors->has('pertanyaan') ? 'border-red-400' : 'border-[#E1E3DE]' }}">{{ old('pertanyaan') }}</textarea>
                <div class="flex justify-between items-center mt-1">
                    @error('pertanyaan')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @else
                        <span></span>
                    @enderror
                    <span id="charCount" class="text-xs text-gray-400 ml-auto">0 / 500</span>
                </div>
            </div>

            {{-- CF Gejala --}}
            <div>
                <label for="cf_gejala" class="block text-xs font-semibold text-[#5D605C] mb-1">
                    Nilai CF Gejala <span class="text-red-500">*</span>
                </label>
                <p class="text-xs text-gray-400 mb-2">
                    Bobot keyakinan pakar terhadap gejala ini. Rentang: <strong>0.1</strong> (sangat lemah)
                    sampai <strong>1.0</strong> (sangat kuat).
                </p>

                <div class="flex gap-2 mb-3 text-xs flex-wrap">
                    <span class="px-2 py-1 bg-green-50 text-green-700 rounded-lg border border-green-200">0.1 – 0.4 Rendah</span>
                    <span class="px-2 py-1 bg-amber-50 text-amber-700 rounded-lg border border-amber-200">0.5 – 0.7 Sedang</span>
                    <span class="px-2 py-1 bg-red-50 text-red-700 rounded-lg border border-red-200">0.8 – 1.0 Tinggi</span>
                </div>

                <div class="flex items-center gap-4">
                    <input type="number" id="cf_gejala" name="cf_gejala"
                        value="{{ old('cf_gejala', '0.5') }}"
                        min="0.1" max="1.0" step="0.1"
                        class="w-28 px-3 py-2.5 border rounded-xl text-sm text-[#5D605C] text-center font-bold focus:outline-none focus:ring-2 focus:ring-[#7B5556]/30
                            {{ $errors->has('cf_gejala') ? 'border-red-400' : 'border-[#E1E3DE]' }}">

                    <div class="flex-1">
                        <input type="range" id="cfSlider" min="0.1" max="1.0" step="0.1"
                            value="{{ old('cf_gejala', '0.5') }}"
                            class="w-full h-2 appearance-none rounded-full outline-none cursor-pointer"
                            style="accent-color:#7B5556;">
                        <div class="flex justify-between text-xs text-gray-400 mt-1">
                            <span>0.1</span><span>0.5</span><span>1.0</span>
                        </div>
                    </div>
                </div>
                @error('cf_gejala')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Actions --}}
            <div class="flex justify-end gap-3 pt-2 border-t border-[#E1E3DE]">
                <a href="{{ route('admin.symptom-rules.index') }}"
                    class="px-5 py-2.5 rounded-xl bg-[#E1E3DE] text-[#5D605C] text-sm font-semibold hover:bg-gray-200 transition-colors">
                    Batal
                </a>
                <button type="submit"
                    class="px-6 py-2.5 rounded-xl bg-[#7B5556] text-white text-sm font-semibold hover:bg-[#6a494a] transition-colors shadow-sm">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
const cfInput  = document.getElementById('cf_gejala');
const cfSlider = document.getElementById('cfSlider');

cfSlider.addEventListener('input', () => {
    cfInput.value = parseFloat(cfSlider.value).toFixed(1);
});
cfInput.addEventListener('input', () => {
    const val = Math.min(1.0, Math.max(0.1, parseFloat(cfInput.value) || 0.1));
    cfSlider.value = val.toFixed(1);
});

const textarea  = document.getElementById('pertanyaan');
const charCount = document.getElementById('charCount');
function updateCount() {
    const len = textarea.value.length;
    charCount.textContent = len + ' / 500';
    charCount.classList.toggle('text-red-500', len > 480);
    charCount.classList.toggle('text-gray-400', len <= 480);
}
textarea.addEventListener('input', updateCount);
updateCount();
</script>
@endsection
