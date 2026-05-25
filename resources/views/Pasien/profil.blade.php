@extends('layouts_pasien.app')

@section('content')    
<header class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-8">
    <div>
        <h1 class="text-2xl md:text-3xl font-semibold text-[#5D605C] tracking-tight">Pengaturan Akun</h1>

    </div>
</header>

    <div class="flex flex-col xl:flex-row gap-8 items-start">
        
        <div class="bg-white/90 backdrop-blur-xl rounded-[40px] p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-white flex-1 w-full grid grid-cols-1 lg:grid-cols-2 gap-8 relative overflow-hidden">
            
            <div class="absolute -top-24 -left-24 w-64 h-64 bg-gradient-to-br from-[#E1E3DE]/40 to-transparent rounded-full blur-3xl pointer-events-none"></div>

            <div class="bg-gradient-to-br from-[#F7F5F4] to-white rounded-[32px] p-8 flex flex-col border border-white shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300 relative z-10">
                <div class="flex items-center gap-3 mb-8">
                    <div class="p-2.5 bg-white rounded-2xl shadow-[0_2px_10px_rgb(0,0,0,0.02)]">
                        <svg class="w-5 h-5 text-[#134E4A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <h3 class="font-extrabold text-[#2A3435] text-lg tracking-wide">Informasi Pribadi</h3>
                </div>

                <div class="flex justify-center mb-10 relative">
                    <div class="absolute inset-0 bg-gradient-to-tr from-[#0A6879]/20 to-[#68575E]/20 rounded-full blur-xl transform scale-110"></div>
                    <div class="relative w-32 h-32 rounded-full border-4 border-white shadow-lg overflow-hidden bg-white group">
                        <img src="{{ Auth::user()->avatar ? asset('storage/avatars/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=2A3435&color=fff&size=120' }}" alt="Avatar" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="group">
                        <label class="block text-[10px] font-bold text-[#797B78] uppercase tracking-widest mb-1.5 px-2">Nama Panjang</label>
                        <input type="text" readonly value="{{ Auth::user()->name }}" class="w-full bg-white/70 border border-white text-[#2A3435] font-semibold rounded-2xl px-5 py-4 shadow-[inset_0_2px_4px_rgba(0,0,0,0.01)] outline-none group-hover:bg-white transition-colors">
                    </div>
                    <div class="group">
                        <label class="block text-[10px] font-bold text-[#797B78] uppercase tracking-widest mb-1.5 px-2">Email</label>
                        <input type="email" readonly value="{{ Auth::user()->email }}" class="w-full bg-white/70 border border-white text-[#2A3435] font-semibold rounded-2xl px-5 py-4 shadow-[inset_0_2px_4px_rgba(0,0,0,0.01)] outline-none group-hover:bg-white transition-colors">
                    </div>
                    <div class="group">
                        <label class="block text-[10px] font-bold text-[#797B78] uppercase tracking-widest mb-1.5 px-2">Kata Sandi</label>
                        <input type="password" readonly value="**********" class="w-full bg-white/70 border border-white text-[#2A3435] font-semibold rounded-2xl px-5 py-4 shadow-[inset_0_2px_4px_rgba(0,0,0,0.01)] outline-none tracking-widest group-hover:bg-white transition-colors">
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-8 relative z-10">
                
               <div class="bg-gradient-to-br from-[#F7F5F4] to-white rounded-[32px] p-8 border border-white shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between">
    <div>
        <div class="flex items-center gap-3 mb-8">
            <div class="p-2.5 bg-white rounded-2xl shadow-[0_2px_10px_rgb(0,0,0,0.02)] border border-[#E1E3DE]/50">
                <svg class="w-5 h-5 text-[#7B5556]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <h3 class="font-extrabold text-[#5D605C] text-lg tracking-wide">Ringkasan Medis</h3>
        </div>

        @php
            // Mengambil data dari relasi analysisHistories yang sudah kita buat sebelumnya
            $totalScan = Auth::user()->analysisHistories()->count();
            $latestScan = Auth::user()->analysisHistories()->latest()->first();
        @endphp

        <div class="bg-white/80 border border-[#E1E3DE]/40 rounded-2xl p-5 shadow-sm flex justify-between items-center mb-4 hover:border-[#7B5556]/30 transition-colors">
            <div class="space-y-1">
                <label class="text-[10px] font-bold text-[#797B78] uppercase tracking-widest block">Total Analisis Wajah</label>
                <p class="text-xs text-[#5D605C] font-medium">Akumulasi pemindaian AI & Kuesioner</p>
            </div>
            <div class="bg-gray-50 px-4 py-2 rounded-xl text-[#7B5556] font-black text-lg border border-[#E1E3DE]">
                {{ $totalScan }} 
            </div>
        </div>

        <div class="bg-white/80 border border-[#E1E3DE]/40 rounded-2xl p-5 shadow-sm flex flex-col gap-2 hover:border-[#7B5556]/30 transition-colors">
            <label class="text-[10px] font-bold text-[#797B78] uppercase tracking-widest block">Pemeriksaan Terakhir</label>
            @if($latestScan)
                <div class="flex justify-between items-center">
                    <p class="text-sm font-bold text-[#5D605C] truncate pr-4">
                        {{ $latestScan->skinProblem->name ?? 'Masalah Terdeteksi' }}
                    </p>
                    <div class="shrink-0 text-right">
                        <span class="block text-xs font-bold text-[#7B5556]">
                            {{ $latestScan->created_at->translatedFormat('d M Y') }}
                        </span>
                        <span class="text-[10px] text-gray-400 font-medium">
                            Skor CF: {{ round($latestScan->confidence_score) }}%
                        </span>
                    </div>
                </div>
            @else
                <p class="text-xs text-gray-500 italic mt-1">Anda belum pernah melakukan pemindaian wajah.</p>
            @endif
        </div>
    </div>
    
    <div class="mt-6 pt-5 border-t border-[#E1E3DE]/50">
        <a href="{{ route('pasien.history') }}" class="w-full flex items-center justify-center gap-2 py-3 bg-[#F7F5F4] hover:bg-[#E1E3DE]/40 border border-[#E1E3DE] rounded-xl text-xs font-bold text-[#5D605C] transition-colors group">
            Lihat Riwayat Lengkap
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
            </svg>
        </a>
    </div>
</div>

                <div class="bg-gradient-to-br from-[#F7F5F4] to-white rounded-[32px] p-8 flex-1 flex flex-col justify-center border border-white shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                    <div class="flex items-center gap-3 mb-8 justify-center">
                        <div class="p-2.5 bg-white rounded-2xl shadow-[0_2px_10px_rgb(0,0,0,0.02)]">
                            <svg class="w-5 h-5 text-[#134E4A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <h3 class="font-extrabold text-[#2A3435] text-lg tracking-wide">Pengaturan Akun</h3>
                    </div>
                    
                    <div class="px-2 mt-auto">
                        <button onclick="openModal()" class="w-full py-3.5 px-4 rounded-2xl border-2 border-[#A9B4B5]/40 text-[#0A6879] font-bold uppercase tracking-wide hover:bg-[#0A6879] hover:text-white hover:border-[#0A6879] hover:shadow-[0_8px_20px_rgba(10,104,121,0.2)] transition-all duration-300">
                            Ubah Data Diri
                        </button>
                    </div>
                </div>

            </div>
        </div>

        <div class="w-full xl:w-72 flex-shrink-0 pt-2">
            <h4 class="text-[11px] font-extrabold text-red-400/80 uppercase tracking-widest mb-4 px-2 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-red-400 animate-pulse"></span>
                Zona Berbahaya
            </h4>
            <div class="bg-gradient-to-br from-[#FFF7F7] to-white border border-red-100/60 rounded-[32px] p-8 shadow-sm hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-red-50 rounded-2xl flex items-center justify-center mb-6">
                    <svg class="w-6 h-6 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <p class="text-sm text-[#797B78] mb-8 leading-relaxed font-medium">
                    Tindakan ini tidak dapat dibatalkan. Menghapus akun akan memusnahkan semua riwayat medis Anda.
                </p>
            <button onclick="openDeleteModal()" class="w-full py-3.5 px-4 rounded-2xl border-2 border-red-100 text-red-500 font-bold hover:bg-red-500 hover:text-white hover:border-red-500 hover:shadow-[0_8px_20px_rgba(239,68,68,0.2)] transition-all duration-300">
                Hapus Akun Permanen
            </button>
            </div>
        </div>

    </div>

    <div id="profileModal" class="fixed inset-0 z-50 hidden bg-[#2A3435]/60 backdrop-blur-md flex items-center justify-center p-4 transition-opacity opacity-0">
        <div class="bg-white rounded-[40px] w-full max-w-lg p-10 shadow-[0_20px_50px_rgba(0,0,0,0.1)] transform scale-95 transition-transform duration-300 border border-white/40">
            
            <div class="flex justify-between items-center mb-8">
                <h3 class="font-extrabold text-[#2A3435] text-2xl tracking-tight">Ubah Data Diri</h3>
                <button onclick="closeModal()" class="w-10 h-10 flex items-center justify-center rounded-full bg-[#F7F5F4] text-[#576162] hover:bg-red-50 hover:text-red-500 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <form action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data" id="formUpdateProfile">
                @csrf
                @method('PUT')

            @if($errors->has('current_password'))
                <div class="bg-red-50 border border-red-200 rounded-2xl p-4 flex items-start gap-3 transition-all duration-300">
                <div class="w-8 h-8 rounded-xl bg-red-100 text-red-600 flex items-center justify-center shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                </div>
                    <div class="flex-1 min-w-0">
                    <h5 class="text-xs font-bold text-red-800 uppercase tracking-wider">Verifikasi Keamanan Gagal</h5>
                    <p class="text-[11px] text-red-600 font-medium mt-0.5 leading-relaxed">
                    {{ $errors->first('current_password') }}
                    </p>
                    </div>
                </div>
            @endif

                <div class="flex flex-col items-center mb-10">
                    <div class="relative group cursor-pointer" onclick="document.getElementById('fileUpload').click()">
                        <div class="absolute inset-0 bg-gradient-to-tr from-[#0A6879]/20 to-[#68575E]/20 rounded-full blur-lg transform scale-110 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <div class="w-28 h-28 rounded-full border-4 border-white shadow-lg overflow-hidden bg-white relative z-10">
                            <img id="avatarPreview" src="{{ Auth::user()->avatar ? asset('storage/avatars/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=2A3435&color=fff&size=120' }}" alt="Preview" class="w-full h-full object-cover group-hover:opacity-40 transition-opacity duration-300">
                        </div>
                        <div class="absolute inset-0 z-20 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <div class="bg-[#2A3435]/80 p-3 rounded-full backdrop-blur-sm">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"></path></svg>
                            </div>
                        </div>
                    </div>
                    <input type="file" name="avatar" id="fileUpload" class="hidden" accept="image/png, image/jpeg, image/jpg" onchange="previewImage(event)">
                    <p class="text-[11px] text-[#797B78] mt-3 font-bold uppercase tracking-widest">Ketuk foto untuk mengganti</p>
                </div>

                <div class="space-y-5 mb-10">
                    <div>
                        <label class="block text-[11px] font-bold text-[#797B78] uppercase tracking-widest mb-2 px-2">Nama Panjang</label>
                        <input type="text" name="name" value="{{ Auth::user()->name }}" class="w-full bg-[#F7F5F4] border border-transparent text-[#2A3435] font-semibold rounded-2xl px-5 py-4 outline-none focus:bg-white focus:border-[#0A6879]/30 focus:ring-4 focus:ring-[#0A6879]/10 transition-all shadow-inner">
                    </div>

                <div>
                   <label class="block text-[11px] font-bold text-[#797B78] uppercase tracking-widest mb-2 px-2">Kata Sandi Saat Ini</label>
                    <div class="relative">
                    <input type="password" id="currentPasswordInput" name="current_password" placeholder="Wajib diisi jika ingin mengubah sandi baru" class="w-full bg-[#F7F5F4] border @error('current_password') border-red-300 @else border-transparent @enderror text-[#2A3435] font-semibold rounded-2xl pl-5 pr-12 py-4 outline-none focus:bg-white focus:border-[#7B5556]/30 transition-all shadow-inner placeholder-[#A9B4B5]">
            
             <button type="button" onclick="toggleCurrentPassword()" class="absolute inset-y-0 right-0 px-4 flex items-center text-[#A9B4B5] hover:text-[#7B5556] focus:outline-none transition-colors">
                <svg id="currentEyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
            </button>
        </div>
    </div>
                    
                    <div>
                        <label class="block text-[11px] font-bold text-[#797B78] uppercase tracking-widest mb-2 px-2">Kata Sandi Baru (Opsional)</label>
                        <div class="relative">
                            <input type="password" id="passwordInput" name="password" placeholder="Biarkan kosong jika tidak diubah" class="w-full bg-[#F7F5F4] border border-transparent text-[#2A3435] font-semibold rounded-2xl pl-5 pr-12 py-4 outline-none focus:bg-white focus:border-[#0A6879]/30 focus:ring-4 focus:ring-[#0A6879]/10 transition-all shadow-inner placeholder-[#A9B4B5]">
                            
                            <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 px-4 flex items-center text-[#A9B4B5] hover:text-[#0A6879] focus:outline-none transition-colors">
                                <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="flex gap-4">
                    <button type="button" onclick="closeModal()" class="w-1/3 py-4 px-6 rounded-2xl border-2 border-[#E1E3DE] text-[#797B78] font-bold text-sm hover:bg-[#F7F5F4] hover:text-[#2A3435] transition-colors">
                        BATAL
                    </button>
                    <button type="submit" class="w-2/3 py-4 px-6 rounded-2xl bg-gradient-to-r from-[#0A6879] to-[#134E4A] text-white font-bold text-sm shadow-[0_8px_20px_rgba(10,104,121,0.25)] hover:shadow-[0_10px_25px_rgba(10,104,121,0.35)] transition-all transform hover:-translate-y-1">
                        SIMPAN PERUBAHAN
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div id="deleteModal" class="fixed inset-0 z-50 hidden bg-[#2A3435]/70 backdrop-blur-md flex items-center justify-center p-4 transition-opacity opacity-0">
    <div class="bg-white rounded-[40px] w-full max-w-sm p-8 shadow-[0_20px_50px_rgba(0,0,0,0.2)] transform scale-95 transition-transform duration-300 border border-red-100 text-center">
        
        <div class="w-20 h-20 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
        </div>

        <h3 class="font-extrabold text-[#2A3435] text-2xl tracking-tight mb-3">Yakin Hapus Akun?</h3>
        <p class="text-sm text-[#797B78] mb-8 leading-relaxed font-medium">
            Semua data, foto, dan riwayat konsultasi akan dihapus <span class="text-red-500 font-bold">selamanya</span>. Tindakan ini tidak dapat dibatalkan.
        </p>

        <form action="{{ route('profil.destroy') }}" method="POST" class="flex flex-col gap-3">
            @csrf
            @method('DELETE')
            <button type="submit" class="w-full py-4 px-6 rounded-2xl bg-red-500 text-white font-bold text-sm shadow-[0_8px_20px_rgba(239,68,68,0.3)] hover:bg-red-600 hover:-translate-y-1 transition-all">
                YA, HAPUS PERMANEN
            </button>
            <button type="button" onclick="closeDeleteModal()" class="w-full py-4 px-6 rounded-2xl border-2 border-[#E1E3DE] text-[#797B78] font-bold text-sm hover:bg-[#F7F5F4] transition-all">
                BATAL
            </button>
        </form>
    </div>
</div>
</div>
@endsection

@push('scripts')
<script>
    // Logika Modal
    const modal = document.getElementById('profileModal');
    const modalBox = modal.querySelector('div');

    function openModal() {
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            modalBox.classList.remove('scale-95');
            modalBox.classList.add('scale-100');
        }, 10);
    }

    function closeModal() {
        modal.classList.add('opacity-0');
        modalBox.classList.remove('scale-100');
        modalBox.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    // Preview Gambar
    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            document.getElementById('avatarPreview').src = URL.createObjectURL(file);
        }
    }

    // TOGGLE MATA UNTUK SANDI LAMA (CURRENT_PASSWORD)
    function toggleCurrentPassword() {
        const currentPwdInput = document.getElementById('currentPasswordInput');
        const currentEyeIcon = document.getElementById('currentEyeIcon');

        if (currentPwdInput.type === 'password') {
            currentPwdInput.type = 'text';
            currentEyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
            `;
        } else {
            currentPwdInput.type = 'password';
            currentEyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            `;
        }
    }

    // Toggle Tampilkan/Sembunyikan Password
    function togglePassword() {
        const pwdInput = document.getElementById('passwordInput');
        const eyeIcon = document.getElementById('eyeIcon');
        
        if (pwdInput.type === 'password') {
            pwdInput.type = 'text';
            // Ganti icon menjadi mata tertutup (dicoret)
            eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
            `;
        } else {
            pwdInput.type = 'password';
            // Kembalikan ke icon mata terbuka
            eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            `;
        }
    }
    // Logika Modal Hapus Akun
    const deleteModal = document.getElementById('deleteModal');
    const deleteModalBox = deleteModal.querySelector('div');

    function openDeleteModal() {
        deleteModal.classList.remove('hidden');
        setTimeout(() => {
            deleteModal.classList.remove('opacity-0');
            deleteModalBox.classList.remove('scale-95');
            deleteModalBox.classList.add('scale-100');
        }, 10);
    }

    function closeDeleteModal() {
        deleteModal.classList.add('opacity-0');
        deleteModalBox.classList.remove('scale-100');
        deleteModalBox.classList.add('scale-95');
        setTimeout(() => {
            deleteModal.classList.add('hidden');
        }, 300);
    }
    // Cek jika ada error validasi dari Laravel, maka otomatis buka modal profil
    @if($errors->has('name') || $errors->has('current_password') || $errors->has('password') || $errors->has('avatar'))
        document.addEventListener('DOMContentLoaded', function() {
            openModal();
        });
    @endif
</script>
@endpush