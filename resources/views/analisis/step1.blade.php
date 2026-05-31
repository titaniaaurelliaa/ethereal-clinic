@extends('layouts_pasien.app')

@section('title', 'Analisis Kulit — Unggah Foto')

@section('content')

{{-- ═══════════════════════════════════════════════════════════
     STEPPER
═══════════════════════════════════════════════════════════ --}}
<div class="flex items-center justify-center gap-0 mb-10">

    {{-- Step 1: Aktif --}}
    <div class="flex items-center gap-3">
        <div class="flex items-center justify-center w-9 h-9 rounded-full bg-[#8B3A3A] text-white text-sm font-bold shadow-md shadow-[#8B3A3A]/30 ring-4 ring-[#8B3A3A]/10">
            1
        </div>
        <span class="text-sm font-semibold text-[#8B3A3A] tracking-wide uppercase">Unggah</span>
    </div>

    {{-- Connector --}}
    <div class="w-16 h-px bg-[#E1E3DE] mx-3"></div>

    {{-- Step 2: Inactive --}}
    <div class="flex items-center gap-3">
        <div class="flex items-center justify-center w-9 h-9 rounded-full bg-[#E1E3DE] text-[#A8ABA7] text-sm font-bold">
            2
        </div>
        <span class="text-sm font-medium text-[#A8ABA7] tracking-wide uppercase">Analisis</span>
    </div>

    {{-- Connector --}}
    <div class="w-16 h-px bg-[#E1E3DE] mx-3"></div>

    {{-- Step 3: Inactive --}}
    <div class="flex items-center gap-3">
        <div class="flex items-center justify-center w-9 h-9 rounded-full bg-[#E1E3DE] text-[#A8ABA7] text-sm font-bold">
            3
        </div>
        <span class="text-sm font-medium text-[#A8ABA7] tracking-wide uppercase">Hasil</span>
    </div>

</div>

{{-- ═══════════════════════════════════════════════════════════
     PAGE HEADER
═══════════════════════════════════════════════════════════ --}}
<header class="mb-8">
    <span class="inline-block bg-[#EBDBDD] text-[#8B3A3A] text-[10px] font-bold tracking-widest uppercase px-3 py-1 rounded-full mb-3">
        Langkah 1 dari 3
    </span>
    <h1 class="text-3xl md:text-4xl font-bold text-gray-800 tracking-tight leading-tight">
        Selfie Consultation
    </h1>
    <p class="text-[#797B78] mt-2 text-sm md:text-base max-w-xl leading-relaxed">
        Unggah foto wajah Anda yang jelas dan terang. AI kami akan mendeteksi kondisi kulit secara akurat dalam hitungan detik.
    </p>
</header>

{{-- ═══════════════════════════════════════════════════════════
     ERROR ALERT
═══════════════════════════════════════════════════════════ --}}
@if ($errors->any())
    <div class="mb-6 bg-red-50 border border-red-200 text-red-700 rounded-2xl px-5 py-4 flex items-start gap-3">
        <svg class="w-5 h-5 mt-0.5 shrink-0 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
        </svg>
        <ul class="text-sm space-y-1 list-none">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- ═══════════════════════════════════════════════════════════
     MAIN FORM
═══════════════════════════════════════════════════════════ --}}
<form id="scan-form"
      action="{{ route('analisis.scan') }}"
      method="POST"
      enctype="multipart/form-data">
    @csrf

    {{-- HIDDEN INPUT: menerima file dari tombol Upload atau Kamera --}}
    <input type="file"
           id="foto_wajah"
           name="foto_wajah"
           accept="image/jpeg,image/png,image/webp"
           class="hidden">

    {{-- TWO-COLUMN LAYOUT --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- ─── KIRI: Panduan & Tombol Aksi ─────────────────────── --}}
        <div class="flex flex-col gap-5">

            {{-- Tips Foto --}}
            <div class="bg-white rounded-[20px] border border-[#E1E3DE]/70 p-6 shadow-sm">
                <h3 class="text-sm font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-full bg-[#EBDBDD] flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-[#8B3A3A]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </span>
                    Tips Foto Terbaik
                </h3>
                <ul class="space-y-3">
                    @foreach ([
                        ['icon' => 'M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707', 'text' => 'Pastikan pencahayaan cukup — hindari backlight'],
                        ['icon' => 'M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'text' => 'Wajah menghadap kamera secara langsung'],
                        ['icon' => 'M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z', 'text' => 'Foto resolusi tinggi, minimal 640×640 px'],
                        ['icon' => 'M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636', 'text' => 'Lepas kacamata dan hiasan wajah'],
                    ] as $tip)
                    <li class="flex items-start gap-3">
                        <div class="w-7 h-7 rounded-xl bg-[#FAF9F6] border border-[#E1E3DE]/50 flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-3.5 h-3.5 text-[#8B3A3A]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $tip['icon'] }}"/>
                            </svg>
                        </div>
                        <span class="text-sm text-[#5D605C] leading-relaxed">{{ $tip['text'] }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>

            {{-- Tombol Kamera & Upload --}}
            <div class="grid grid-cols-2 gap-3">
                {{-- Tombol Kamera: Ambil Foto → Live → Jepret --}}
                <button type="button"
                        id="btn-kamera"
                        class="flex flex-col items-center justify-center gap-2.5 bg-white border-2 border-[#E1E3DE] hover:border-[#8B3A3A]/40 rounded-2xl py-5 px-4 text-center transition-all duration-200 hover:bg-[#FFF7F6] active:scale-95 group">
                    <div class="w-11 h-11 rounded-xl bg-[#EBDBDD]/60 flex items-center justify-center group-hover:bg-[#EBDBDD] transition-colors">
                        <svg id="icon-kamera" class="w-5 h-5 text-[#8B3A3A]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        {{-- Icon jepret (hidden awal) --}}
                        <svg id="icon-jepret" class="hidden w-5 h-5 text-[#8B3A3A]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="4" stroke-width="2.5"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                        </svg>
                    </div>
                    <div>
                        <p id="label-kamera" class="text-sm font-semibold text-gray-800">Ambil Foto</p>
                        <p id="hint-kamera" class="text-[11px] text-[#A8ABA7] mt-0.5">Gunakan kamera</p>
                    </div>
                </button>

                {{-- Upload Foto dari File --}}
                <button type="button"
                        id="btn-upload"
                        class="flex flex-col items-center justify-center gap-2.5 bg-white border-2 border-[#E1E3DE] hover:border-[#8B3A3A]/40 rounded-2xl py-5 px-4 text-center transition-all duration-200 hover:bg-[#FFF7F6] active:scale-95 group">
                    <div class="w-11 h-11 rounded-xl bg-[#E1E3DE]/60 flex items-center justify-center group-hover:bg-[#E1E3DE] transition-colors">
                        <svg class="w-5 h-5 text-[#5D605C]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-800">Upload Foto</p>
                        <p class="text-[11px] text-[#A8ABA7] mt-0.5">Dari galeri</p>
                    </div>
                </button>
            </div>

            {{-- Format yang didukung --}}
            <p class="text-xs text-[#A8ABA7] text-center -mt-1">
                Format: JPG, PNG, WebP &nbsp;·&nbsp; Maksimal 5 MB
            </p>
        </div>

        {{-- ─── KANAN: Preview Area + Tombol Submit ──────────────── --}}
        <div class="flex flex-col gap-4">

            {{-- Area Preview --}}
            <div id="preview-wrapper"
                 class="relative flex-1 min-h-[320px] bg-white rounded-3xl border-2 border-dashed border-[#D5C5C5] flex flex-col items-center justify-center overflow-hidden transition-all duration-300">

                {{-- Placeholder --}}
                <div id="preview-placeholder" class="flex flex-col items-center justify-center gap-4 p-8 text-center">
                    <div class="w-20 h-20 rounded-full bg-[#FAF9F6] border-2 border-dashed border-[#D5C5C5] flex items-center justify-center">
                        <svg class="w-9 h-9 text-[#C5B0B0]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3 7.5a.75.75 0 011.5 0v.008a.75.75 0 01-1.5 0V7.5z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-[#A8ABA7]">Foto wajah akan tampil di sini</p>
                        <p class="text-xs text-[#C5B0B0] mt-1">Gunakan tombol di sebelah kiri untuk memilih foto</p>
                    </div>
                </div>

                {{-- Video stream WebRTC (hidden awal) --}}
                <video id="camera-video"
                       autoplay playsinline muted
                       class="hidden w-full h-full object-cover rounded-3xl"></video>

                {{-- Badge Live --}}
                <div id="live-badge"
                     class="hidden absolute top-3 left-3 flex items-center gap-1.5 bg-red-600 text-white text-[10px] font-bold px-3 py-1 rounded-full shadow-md">
                    <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span> LIVE
                </div>

                {{-- Preview foto hasil jepretan --}}
                <img id="preview-img" src="#" alt="Preview foto wajah"
                     class="hidden w-full h-full object-cover rounded-3xl">

                {{-- Badge Foto Dipilih --}}
                <div id="preview-badge"
                     class="hidden absolute top-3 right-3 bg-[#8B3A3A] text-white text-[10px] font-bold px-3 py-1 rounded-full shadow-md">
                    ✓ Foto Diambil
                </div>

                {{-- Tombol hapus / ganti --}}
                <button type="button" id="btn-hapus"
                        class="hidden absolute bottom-3 right-3 bg-white/90 backdrop-blur-sm border border-[#E1E3DE] text-[#8B3A3A] text-xs font-semibold px-3 py-1.5 rounded-full hover:bg-red-50 hover:border-red-200 hover:text-red-600 transition-all shadow-sm">
                    Hapus Foto
                </button>

                <button type="button" id="btn-batal-kamera"
                        class="hidden absolute bottom-3 right-3 bg-white/90 backdrop-blur-sm border border-[#E1E3DE] text-[#5D605C] text-xs font-bold px-4 py-1.5 rounded-full hover:bg-gray-100 hover:text-gray-800 transition-all shadow-sm">
                    Batalkan
                </button>

                {{-- Canvas tersembunyi untuk capture frame --}}
                <canvas id="capture-canvas" class="hidden"></canvas>
            </div>

            {{-- Info nama file --}}
            <p id="file-name-display"
               class="text-xs text-[#A8ABA7] text-center hidden">
                <span class="font-medium text-[#5D605C]" id="file-name-text"></span>
            </p>

            {{-- Tombol Submit --}}
            <div class="flex justify-end">
                <button type="submit"
                        id="btn-submit"
                        disabled
                        class="flex items-center gap-2.5 bg-[#8B3A3A] text-white px-8 py-3 rounded-full text-sm font-semibold
                               shadow-lg shadow-[#8B3A3A]/25 transition-all duration-200
                               hover:bg-[#7a3131] hover:shadow-xl hover:shadow-[#8B3A3A]/30 hover:-translate-y-0.5
                               active:scale-95 active:translate-y-0
                               disabled:opacity-40 disabled:cursor-not-allowed disabled:shadow-none disabled:translate-y-0">
                    {{-- Spinner (muncul saat loading) --}}
                    <svg id="submit-spinner" class="hidden w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                    </svg>
                    <span id="submit-text">Mulai Scan Wajah</span>
                    {{-- Arrow icon --}}
                    <svg id="submit-arrow" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </button>
            </div>

        </div>
        {{-- /KANAN --}}
    </div>
    {{-- /TWO-COLUMN --}}

</form>

@endsection

@push('scripts')
<script>
(function () {
    'use strict';

    /* ── DOM refs ─────────────────────────────────────────────── */
    const inputFile         = document.getElementById('foto_wajah');
    const inputKamera       = document.getElementById('foto_kamera');
    const btnKamera         = document.getElementById('btn-kamera');
    const btnUpload         = document.getElementById('btn-upload');
    const btnHapus          = document.getElementById('btn-hapus');
    const btnBatalKamera    = document.getElementById('btn-batal-kamera');
    const btnSubmit         = document.getElementById('btn-submit');
    const previewImg        = document.getElementById('preview-img');
    const previewPlaceholder= document.getElementById('preview-placeholder');
    const previewBadge      = document.getElementById('preview-badge');
    const previewWrapper    = document.getElementById('preview-wrapper');
    const fileNameDisplay   = document.getElementById('file-name-display');
    const fileNameText      = document.getElementById('file-name-text');
    const submitSpinner     = document.getElementById('submit-spinner');
    const submitText        = document.getElementById('submit-text');
    const submitArrow       = document.getElementById('submit-arrow');
    const scanForm          = document.getElementById('scan-form');
    const videoEl           = document.getElementById('camera-video');
    const canvas            = document.getElementById('capture-canvas');
    const liveBadge         = document.getElementById('live-badge');
    const iconKamera        = document.getElementById('icon-kamera');
    const iconJepret        = document.getElementById('icon-jepret');
    const labelKamera       = document.getElementById('label-kamera');
    const hintKamera        = document.getElementById('hint-kamera');

    /* ── State ────────────────────────────────────────────────── */
    let stream    = null;   // MediaStream aktif
    let liveMode  = false;  // apakah sedang streaming

    /* ═══════════════════════════════════════════════════════════
       TOMBOL KAMERA — 2 peran:
         Saat idle   → buka kamera (WebRTC)
         Saat live   → jepret frame
    ═══════════════════════════════════════════════════════════ */
    btnKamera.addEventListener('click', () => {
        if (!liveMode) {
            startCamera();
        } else {
            captureFrame();
        }
    });

    /* ── Buka webcam ─────────────────────────────────────────── */
    async function startCamera() {
        if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
            alert('Browser Anda tidak mendukung akses kamera. Gunakan fitur Upload Foto.');
            return;
        }
        try {
            stream = await navigator.mediaDevices.getUserMedia({
                video: { width: { ideal: 1280 }, height: { ideal: 720 }, facingMode: 'user' },
                audio: false
            });

            videoEl.srcObject = stream;
            // Bersihkan sisa elemen UI foto sebelumnya (jika ada)
            previewPlaceholder.classList.add('hidden');
            previewImg.classList.add('hidden');
            previewBadge.classList.add('hidden');
            btnHapus.classList.add('hidden');
            fileNameDisplay.classList.add('hidden');

            // Tampilkan video stream, badge LIVE, dan tombol BATAL
            videoEl.classList.remove('hidden');
            liveBadge.classList.remove('hidden');
            btnBatalKamera.classList.remove('hidden');

            // Ganti label tombol → Jepret
            iconKamera.classList.add('hidden');
            iconJepret.classList.remove('hidden');
            labelKamera.textContent = 'Jepret!';
            hintKamera.textContent  = 'Klik untuk ambil foto';
            btnKamera.classList.add('border-red-300', 'bg-red-50');

            // Nonaktifkan tombol upload & submit selama live
            btnUpload.disabled = true;
            btnUpload.classList.add('opacity-40', 'cursor-not-allowed');
            btnSubmit.disabled = true;

            liveMode = true;
        } catch (err) {
            if (err.name === 'NotAllowedError') {
                alert('Akses kamera ditolak. Izinkan akses kamera di browser Anda lalu coba lagi.');
            } else {
                alert('Gagal membuka kamera: ' + err.message);
            }
        }
    }

    /* ── Ambil frame dari video → File → form input ──────────── */
    function captureFrame() {
        const w = videoEl.videoWidth  || 640;
        const h = videoEl.videoHeight || 480;

        canvas.width  = w;
        canvas.height = h;

        const ctx = canvas.getContext('2d');
        // Mirror horizontal (selfie mode) sesuai tampilan video
        ctx.translate(w, 0);
        ctx.scale(-1, 1);
        ctx.drawImage(videoEl, 0, 0, w, h);

        // Stop stream → lampu kamera mati
        stopCamera();

        // Konversi canvas → Blob → File → masukkan ke file input
        canvas.toBlob((blob) => {
            const fileName = 'selfie_' + Date.now() + '.jpg';
            const file     = new File([blob], fileName, { type: 'image/jpeg' });

            const dt = new DataTransfer();
            dt.items.add(file);
            inputFile.files = dt.files;

            // Tampilkan hasil jepretan
            const dataURL = canvas.toDataURL('image/jpeg', 0.92);
            previewImg.src = dataURL;
            previewImg.classList.remove('hidden');
            previewBadge.classList.remove('hidden');
            btnHapus.classList.remove('hidden');
            fileNameText.textContent  = fileName;
            fileNameDisplay.classList.remove('hidden');
            btnSubmit.disabled = false;

            previewWrapper.classList.remove('border-dashed', 'border-[#D5C5C5]');
            previewWrapper.classList.add('border-solid', 'border-[#8B3A3A]/30');
        }, 'image/jpeg', 0.92);
    }

    /* ── Stop webcam stream ──────────────────────────────────── */
    function stopCamera() {
        if (stream) {
            stream.getTracks().forEach(t => t.stop());
            stream = null;
        }
        videoEl.srcObject = null;
        videoEl.classList.add('hidden');
        liveBadge.classList.add('hidden');
        btnBatalKamera.classList.add('hidden');

        // Kembalikan tombol ke state awal
        iconJepret.classList.add('hidden');
        iconKamera.classList.remove('hidden');
        labelKamera.textContent = 'Ambil Foto';
        hintKamera.textContent  = 'Gunakan kamera';
        btnKamera.classList.remove('border-red-300', 'bg-red-50');

        btnUpload.disabled = false;
        btnUpload.classList.remove('opacity-40', 'cursor-not-allowed');

        liveMode = false;
    }
    // Event listener untuk tombol batal kamera
    btnBatalKamera.addEventListener('click', cancelCamera);

    /* ── Batalkan aksi kamera (kembali ke state sebelumnya) ──── */
    function cancelCamera() {
        stopCamera(); // Mematikan lampu webcam sepenuhnya
        
        // Cek secara cerdas: apakah sebelumnya sudah ada foto yang diunggah?
        if (inputFile.files && inputFile.files.length > 0) {
            // Jika ada, kembalikan tampilan foto sebelumnya
            previewImg.classList.remove('hidden');
            previewBadge.classList.remove('hidden');
            btnHapus.classList.remove('hidden');
            fileNameDisplay.classList.remove('hidden');
            btnSubmit.disabled = false;
        } else {
            // Jika kosong, kembalikan ke tampilan placeholder awal
            previewPlaceholder.classList.remove('hidden');
        }
    }

    /* ── Stop kamera jika user meninggalkan halaman ──────────── */
    window.addEventListener('beforeunload', () => stopCamera());
    document.addEventListener('visibilitychange', () => {
        if (document.hidden && liveMode) stopCamera();
    });

    /* ── Tombol Upload → file picker ─────────────────────────── */
    btnUpload.addEventListener('click', () => {
        if (liveMode) stopCamera();
        inputFile.click();
    });

    /* ── File input change ───────────────────────────────────── */
    inputFile.addEventListener('change', function () {
        if (this.files && this.files[0]) renderPreview(this.files[0]);
    });

    /* ── Tombol Hapus ────────────────────────────────────────── */
    btnHapus.addEventListener('click', resetPreview);

    /* ── Drag & Drop ─────────────────────────────────────────── */
    previewWrapper.addEventListener('dragover', (e) => {
        e.preventDefault();
        previewWrapper.classList.add('border-[#8B3A3A]', 'bg-[#FFF7F6]');
    });
    previewWrapper.addEventListener('dragleave', () => {
        previewWrapper.classList.remove('border-[#8B3A3A]', 'bg-[#FFF7F6]');
    });
    previewWrapper.addEventListener('drop', (e) => {
        e.preventDefault();
        previewWrapper.classList.remove('border-[#8B3A3A]', 'bg-[#FFF7F6]');
        const file = e.dataTransfer.files[0];
        if (file && file.type.startsWith('image/')) {
            if (liveMode) stopCamera();
            const dt = new DataTransfer();
            dt.items.add(file);
            inputFile.files = dt.files;
            renderPreview(file);
        }
    });

    /* ── Loading state submit ────────────────────────────────── */
    scanForm.addEventListener('submit', function () {
        btnSubmit.disabled = true;
        submitSpinner.classList.remove('hidden');
        submitArrow.classList.add('hidden');
        submitText.textContent = 'Memindai...';
    });

    /* ── Render preview dari File object ─────────────────────── */
    function renderPreview(file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            previewImg.src = e.target.result;
            previewImg.classList.remove('hidden');
            previewPlaceholder.classList.add('hidden');
            previewBadge.classList.remove('hidden');
            btnHapus.classList.remove('hidden');
            fileNameText.textContent = file.name;
            fileNameDisplay.classList.remove('hidden');
            btnSubmit.disabled = false;
            previewWrapper.classList.remove('border-dashed', 'border-[#D5C5C5]');
            previewWrapper.classList.add('border-solid', 'border-[#8B3A3A]/30');
        };
        reader.readAsDataURL(file);
    }

    /* ── Reset ke kondisi awal ───────────────────────────────── */
    function resetPreview() {
        if (liveMode) stopCamera();
        inputFile.value = '';
        previewImg.src  = '#';
        previewImg.classList.add('hidden');
        previewPlaceholder.classList.remove('hidden');
        previewBadge.classList.add('hidden');
        btnHapus.classList.add('hidden');
        fileNameDisplay.classList.add('hidden');
        btnSubmit.disabled = true;
        previewWrapper.classList.add('border-dashed', 'border-[#D5C5C5]');
        previewWrapper.classList.remove('border-solid', 'border-[#8B3A3A]/30');
    }

})();
</script>
@endpush
