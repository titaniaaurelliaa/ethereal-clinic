@extends('layouts_admin.app')
@section('title', 'Tulis Berita Baru')

@section('content')
<div class="container max-w-3xl">

    {{-- ─── HEADER ───────────────────────────────────────────────────────────── --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.news.index') }}"
           class="w-9 h-9 rounded-xl border border-[#E1E3DE] flex items-center justify-center text-[#797B78] hover:text-[#7B5556] hover:border-[#7B5556]/40 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11 17l-5-5m0 0l5-5m-5 5h12"/>
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-[#5D605C]">Tulis Berita Baru</h1>
            <p class="text-sm text-gray-400 mt-0.5">Artikel ini akan tampil di dashboard pasien</p>
        </div>
    </div>

    {{-- ─── VALIDATION ERROR BANNER ─────────────────────────────────────────── --}}
    @if($errors->any())
        <div class="mb-5 bg-red-50 border border-red-200 rounded-2xl p-5">
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center shrink-0 mt-0.5">
                    <svg class="w-4 h-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-red-700 mb-2">Validasi Gagal:</h4>
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

    {{-- ─── FORM ─────────────────────────────────────────────────────────────── --}}
    <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="bg-white rounded-2xl border border-[#E1E3DE] overflow-hidden">

            {{-- Form Header --}}
            <div class="px-6 py-4 border-b border-[#E1E3DE] bg-gray-50/60">
                <h3 class="text-sm font-semibold text-[#5D605C]">Detail Artikel</h3>
            </div>

            <div class="p-6 space-y-5">

                {{-- Title --}}
                <div>
                    <label for="title" class="block text-xs font-semibold text-[#5D605C] mb-1.5">
                        Judul Berita <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title" id="title"
                           value="{{ old('title') }}"
                           placeholder="cth: Cara Mengatasi Jerawat Meradang Secara Klinis"
                           class="w-full border border-[#E1E3DE] rounded-xl px-4 py-2.5 text-sm text-[#5D605C] focus:outline-none focus:ring-2 focus:ring-[#7B5556]/30 @error('title') border-red-400 @enderror">
                    @error('title')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-[10px] text-gray-400 mt-1">Slug akan dibuat otomatis dari judul ini.</p>
                </div>

                {{-- Cover Image --}}
                <div>
                    <label for="image_path" class="block text-xs font-semibold text-[#5D605C] mb-1.5">
                        Foto Cover <span class="text-gray-400 font-normal">(Opsional — JPG/PNG/WebP, maks 2MB)</span>
                    </label>
                    <div id="dropZone"
                         class="relative border-2 border-dashed border-[#E1E3DE] rounded-xl p-6 text-center cursor-pointer hover:border-[#7B5556]/50 transition-colors group">
                        <input type="file" name="image_path" id="image_path"
                               accept="image/jpeg,image/png,image/webp"
                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                               onchange="previewImage(this)">
                        <div id="dropPlaceholder">
                            <svg class="w-8 h-8 text-[#E1E3DE] mx-auto mb-2 group-hover:text-[#7B5556]/40 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <p class="text-sm text-gray-400">Klik atau seret gambar ke sini</p>
                            <p class="text-xs text-gray-300 mt-0.5">JPG, PNG, WebP — maks 2MB</p>
                        </div>
                        <img id="imagePreview" src="#" alt="Preview"
                             class="hidden mx-auto max-h-40 rounded-lg object-cover">
                    </div>
                    @error('image_path')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Content --}}
                <div>
                    <label for="content" class="block text-xs font-semibold text-[#5D605C] mb-1.5">
                        Konten Berita <span class="text-red-500">*</span>
                    </label>
                    <textarea name="content" id="content" rows="12"
                              placeholder="Tulis isi artikel di sini..."
                              class="w-full border border-[#E1E3DE] rounded-xl px-4 py-3 text-sm text-[#5D605C] leading-relaxed focus:outline-none focus:ring-2 focus:ring-[#7B5556]/30 resize-y @error('content') border-red-400 @enderror">{{ old('content') }}</textarea>
                    @error('content')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            {{-- Form Footer --}}
        <div class="px-6 py-4 border-t border-[#E1E3DE] bg-gray-50/60 flex justify-end gap-3">
            <a href="{{ route('admin.news.index') }}"
            class="px-5 py-2.5 rounded-xl bg-[#E1E3DE] text-[#5D605C] text-sm font-semibold hover:bg-gray-200 transition-colors">
                Batal
            </a>
            <button type="submit"
                    class="px-6 py-2.5 rounded-xl bg-pink-500 text-white text-sm font-semibold hover:bg-pink-600 shadow-sm transition-colors inline-flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
                Publikasikan Berita
            </button>
        </div>
    </div>

    </form>
</div>

<script>
function previewImage(input) {
    const placeholder = document.getElementById('dropPlaceholder');
    const preview     = document.getElementById('imagePreview');

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
</script>

@endsection
