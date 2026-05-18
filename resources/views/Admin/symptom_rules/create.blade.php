@extends('layouts_admin.app')

@section('title', 'Tambah Pertanyaan Anamnesis — Admin')

@section('content')
<div class="max-w-2xl mx-auto">

    {{-- ── BREADCRUMB ── --}}
    <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
        <a href="{{ route('admin.symptom-rules.index') }}" class="hover:text-pink-500 transition">
            Pertanyaan Anamnesis
        </a>
        <i class="fas fa-chevron-right text-xs text-gray-300"></i>
        <span class="text-gray-700 font-medium">Tambah Baru</span>
    </nav>

    {{-- ── CARD FORM ── --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        {{-- Header Card --}}
        <div class="flex items-center gap-3 px-6 py-5 border-b border-gray-100 bg-pink-50/60">
            <div class="w-10 h-10 rounded-xl bg-pink-100 flex items-center justify-center text-pink-500">
                <i class="fas fa-plus-circle"></i>
            </div>
            <div>
                <h2 class="font-bold text-gray-800 text-lg">Tambah Pertanyaan Anamnesis</h2>
                <p class="text-xs text-gray-500">Pertanyaan ini akan ditampilkan kontekstual setelah AI mendeteksi kondisi yang dipilih.</p>
            </div>
        </div>

        {{-- Body Form --}}
        <form action="{{ route('admin.symptom-rules.store') }}" method="POST" class="p-6 space-y-5">
            @csrf

            {{-- Dropdown: KnowledgeBase --}}
            <div>
                <label for="knowledge_base_id" class="block text-sm font-semibold text-gray-700 mb-1.5">
                    Kondisi Kulit Terdeteksi <span class="text-red-500">*</span>
                </label>
                <p class="text-xs text-gray-400 mb-2">
                    Pilih kombinasi nama objek + tingkat keparahan yang memicu pertanyaan ini.
                </p>
                <select id="knowledge_base_id" name="knowledge_base_id"
                    class="w-full px-4 py-2.5 border rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-400 bg-white text-sm
                        {{ $errors->has('knowledge_base_id') ? 'border-red-400' : 'border-gray-200' }}">
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
                            ({{ $kb->min_objek }}–{{ $kb->max_objek ?? '∞' }} objek)
                        </option>
                    @endforeach
                    @if ($prevObjek !== '') </optgroup> @endif
                </select>
                @error('knowledge_base_id')
                    <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Textarea: Pertanyaan --}}
            <div>
                <label for="pertanyaan" class="block text-sm font-semibold text-gray-700 mb-1.5">
                    Teks Pertanyaan <span class="text-red-500">*</span>
                </label>
                <p class="text-xs text-gray-400 mb-2">
                    Gunakan bahasa yang mudah dipahami pasien. Hindari istilah medis yang rumit.
                </p>
                <textarea id="pertanyaan" name="pertanyaan" rows="3"
                    placeholder="Contoh: Apakah benjolan terasa nyeri saat tidak disentuh?"
                    maxlength="500"
                    class="w-full px-4 py-2.5 border rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-400 text-sm resize-none
                        {{ $errors->has('pertanyaan') ? 'border-red-400' : 'border-gray-200' }}">{{ old('pertanyaan') }}</textarea>
                <div class="flex justify-between items-center mt-1">
                    @error('pertanyaan')
                        <p class="text-xs text-red-500 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </p>
                    @else
                        <span></span>
                    @enderror
                    <span id="charCount" class="text-xs text-gray-400">0 / 500</span>
                </div>
            </div>

            {{-- Number Input: CF Gejala --}}
            <div>
                <label for="cf_gejala" class="block text-sm font-semibold text-gray-700 mb-1.5">
                    Nilai CF Gejala <span class="text-red-500">*</span>
                </label>
                <p class="text-xs text-gray-400 mb-2">
                    Bobot keyakinan pakar terhadap gejala ini. Rentang: <strong>0.1</strong> (sangat lemah)
                    sampai <strong>1.0</strong> (sangat kuat).
                </p>

                {{-- Referensi Skala CF --}}
                <div class="flex gap-2 mb-3 text-xs flex-wrap">
                    <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full">0.1–0.4 Rendah</span>
                    <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded-full">0.5–0.7 Sedang</span>
                    <span class="px-2 py-1 bg-red-100 text-red-700 rounded-full">0.8–1.0 Tinggi</span>
                </div>

                <div class="flex items-center gap-4">
                    <input type="number" id="cf_gejala" name="cf_gejala"
                        value="{{ old('cf_gejala', '0.5') }}"
                        min="0.1" max="1.0" step="0.1"
                        class="w-32 px-4 py-2.5 border rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-400 text-sm text-center font-bold
                            {{ $errors->has('cf_gejala') ? 'border-red-400' : 'border-gray-200' }}">

                    {{-- Visual slider --}}
                    <div class="flex-1">
                        <input type="range" id="cfSlider" min="0.1" max="1.0" step="0.1"
                            value="{{ old('cf_gejala', '0.5') }}"
                            class="w-full h-2 appearance-none rounded-full outline-none cursor-pointer"
                            style="accent-color: #EC4899;">
                        <div class="flex justify-between text-xs text-gray-400 mt-1">
                            <span>0.1</span><span>0.5</span><span>1.0</span>
                        </div>
                    </div>
                </div>
                @error('cf_gejala')
                    <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex justify-end gap-3 pt-2 border-t border-gray-100">
                <a href="{{ route('admin.symptom-rules.index') }}"
                   class="px-5 py-2.5 rounded-xl bg-gray-100 text-gray-600 hover:bg-gray-200 text-sm font-semibold transition">
                    Batal
                </a>
                <button type="submit"
                    class="px-6 py-2.5 rounded-xl bg-pink-500 text-white hover:bg-pink-600 text-sm font-semibold shadow transition">
                    <i class="fas fa-save mr-1"></i> Simpan
                </button>
            </div>

        </form>
    </div>

</div>

<script>
    // ── Sinkronisasi angka & slider ──────────────────────────────────────────
    const cfInput  = document.getElementById('cf_gejala');
    const cfSlider = document.getElementById('cfSlider');

    cfSlider.addEventListener('input', () => {
        cfInput.value = parseFloat(cfSlider.value).toFixed(1);
    });
    cfInput.addEventListener('input', () => {
        const val = Math.min(1.0, Math.max(0.1, parseFloat(cfInput.value) || 0.1));
        cfSlider.value = val.toFixed(1);
    });

    // ── Counter karakter ─────────────────────────────────────────────────────
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
