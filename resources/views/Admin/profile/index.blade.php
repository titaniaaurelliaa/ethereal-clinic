@extends('layouts_admin.app')

@section('title', 'Profile Admin - The Ethereal Clinic')

@section('content')
<div class="w-full px-4 md:px-6">
    
    <!-- Header Section dengan Background -->
    <div class="bg-gradient-to-r from-[#7B5556] to-[#9B6B6C] rounded-2xl px-6 py-4 md:py-5 mb-6 shadow-sm">
        <div class="max-w-7xl mx-auto">
            <h1 class="text-xl md:text-2xl font-bold text-white">Profile Saya</h1>
            <p class="text-white/80 text-sm mt-0.5">Informasi akun administrator Anda</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto">
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- SIDE KIRI: Foto Profile & Info Singkat -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-[#E1E3DE] overflow-hidden sticky top-6">
                    
                    <!-- Foto Profile dengan Upload -->
                    <div class="text-center py-6 px-4 border-b border-[#E1E3DE]">
                        <div class="relative inline-block group">
                            <div class="w-24 h-24 mx-auto rounded-full overflow-hidden shadow-md bg-gradient-to-br from-[#7B5556] to-[#9B6B6C]">
                                @if($user->avatar && file_exists(public_path('storage/avatars/' . $user->avatar)))
                                    <img id="avatarPreview" src="{{ asset('storage/avatars/' . $user->avatar) }}" alt="Profile" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            
                            <label for="avatarUpload" class="absolute bottom-0 right-0 bg-pink-500 rounded-full p-1.5 cursor-pointer hover:bg-pink-600 transition shadow-md">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </label>
                            <form id="avatarForm" action="{{ route('admin.profile.update-avatar') }}" method="POST" enctype="multipart/form-data" class="hidden">
                                @csrf
                                @method('PUT')
                                <input type="file" id="avatarUpload" name="avatar" accept="image/*" onchange="submitAvatarForm()">
                            </form>
                        </div>
                        <h2 class="text-lg font-bold text-[#5D605C] mt-3">{{ $user->name }}</h2>
                        <p class="text-[#797B78] text-xs">Administrator</p>
                    </div>

                    <!-- Informasi Singkat -->
                    <div class="p-4">
                        <div class="flex items-center gap-2 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#7B5556]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span class="text-[#797B78] text-xs break-all">{{ $user->email }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SIDE KANAN: Detail Informasi Profile -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Informasi Pribadi -->
                <div class="bg-white rounded-2xl shadow-sm border border-[#E1E3DE] overflow-hidden">
                    <div class="px-5 py-3 border-b border-[#E1E3DE] bg-gray-50">
                        <div>
                            <h3 class="text-base font-bold text-[#5D605C]">Informasi Pribadi</h3>
                            <p class="text-[#797B78] text-xs">Data diri administrator</p>
                        </div>
                    </div>
                    
                    <div class="p-5">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-gray-50 rounded-xl p-3">
                                <label class="block text-[#797B78] text-xs mb-1">Nama Lengkap</label>
                                <p class="text-[#5D605C] text-sm font-semibold">{{ $user->name }}</p>
                            </div>
                            <div class="bg-gray-50 rounded-xl p-3">
                                <label class="block text-[#797B78] text-xs mb-1">Alamat Email</label>
                                <p class="text-[#5D605C] text-sm font-semibold">{{ $user->email }}</p>
                            </div>
                            <div class="bg-gray-50 rounded-xl p-3">
                                <label class="block text-[#797B78] text-xs mb-1">Jabatan</label>
                                <p class="text-[#5D605C] text-sm font-semibold">Administrator</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pengaturan Akun (Tombol buka modal) -->
                <div class="bg-white rounded-2xl shadow-sm border border-[#E1E3DE] overflow-hidden">
                    <div class="px-5 py-3 border-b border-[#E1E3DE] bg-gray-50">
                        <h3 class="text-base font-bold text-[#5D605C]">Pengaturan Akun</h3>
                        <p class="text-[#797B78] text-xs">Kelola data diri dan keamanan akun Anda</p>
                    </div>
                    
                    <div class="p-5 flex flex-col sm:flex-row gap-4">
                        <button onclick="openEditProfileModal()" 
                            class="flex-1 py-3 px-4 rounded-xl border-2 border-[#7B5556]/30 text-[#7B5556] font-bold hover:bg-[#7B5556] hover:text-white transition-all duration-300 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                            Ubah Data Diri
                        </button>
                        <button onclick="openChangePasswordModal()" 
                            class="flex-1 py-3 px-4 rounded-xl border-2 border-[#7B5556]/30 text-[#7B5556] font-bold hover:bg-[#7B5556] hover:text-white transition-all duration-300 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            Ubah Password
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL EDIT DATA DIRI --}}
<div id="editProfileModal" class="fixed inset-0 z-50 hidden bg-[#2A3435]/60 backdrop-blur-md flex items-center justify-center p-4 transition-opacity opacity-0">
    <div class="bg-white rounded-[40px] w-full max-w-lg p-10 shadow-[0_20px_50px_rgba(0,0,0,0.1)] transform scale-95 transition-transform duration-300 border border-white/40">
        
        <div class="flex justify-between items-center mb-8">
            <h3 class="font-extrabold text-[#2A3435] text-2xl tracking-tight">Ubah Data Diri</h3>
            <button onclick="closeEditProfileModal()" class="w-10 h-10 flex items-center justify-center rounded-full bg-[#F7F5F4] text-[#576162] hover:bg-red-50 hover:text-red-500 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <form action="{{ route('admin.profile.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-5 mb-10">
                <div>
                    <label class="block text-[11px] font-bold text-[#797B78] uppercase tracking-widest mb-2 px-2">Nama Panjang</label>
                    <input type="text" name="name" value="{{ $user->name }}" required
                        class="w-full bg-[#F7F5F4] border border-transparent text-[#2A3435] font-semibold rounded-2xl px-5 py-4 outline-none focus:bg-white focus:border-[#7B5556]/30 focus:ring-4 focus:ring-[#7B5556]/10 transition-all">
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-[#797B78] uppercase tracking-widest mb-2 px-2">Email</label>
                    <input type="email" name="email" value="{{ $user->email }}" required
                        class="w-full bg-[#F7F5F4] border border-transparent text-[#2A3435] font-semibold rounded-2xl px-5 py-4 outline-none focus:bg-white focus:border-[#7B5556]/30 focus:ring-4 focus:ring-[#7B5556]/10 transition-all">
                </div>
            </div>

            <div class="flex gap-4">
                <button type="button" onclick="closeEditProfileModal()" class="w-1/3 py-4 px-6 rounded-2xl border-2 border-[#E1E3DE] text-[#797B78] font-bold text-sm hover:bg-[#F7F5F4] hover:text-[#2A3435] transition-colors">
                    BATAL
                </button>
                <button type="submit" class="w-2/3 py-4 px-6 rounded-2xl bg-gradient-to-r from-[#7B5556] to-[#9B6B6C] text-white font-bold text-sm shadow-[0_8px_20px_rgba(123,85,86,0.25)] hover:shadow-[0_10px_25px_rgba(123,85,86,0.35)] transition-all transform hover:-translate-y-1">
                    SIMPAN PERUBAHAN
                </button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL UBAH PASSWORD --}}
<div id="changePasswordModal" class="fixed inset-0 z-50 hidden bg-[#2A3435]/60 backdrop-blur-md flex items-center justify-center p-4 transition-opacity opacity-0">
    <div class="bg-white rounded-[40px] w-full max-w-lg p-10 shadow-[0_20px_50px_rgba(0,0,0,0.1)] transform scale-95 transition-transform duration-300 border border-white/40">
        
        <div class="flex justify-between items-center mb-8">
            <h3 class="font-extrabold text-[#2A3435] text-2xl tracking-tight">Ubah Password</h3>
            <button onclick="closeChangePasswordModal()" class="w-10 h-10 flex items-center justify-center rounded-full bg-[#F7F5F4] text-[#576162] hover:bg-red-50 hover:text-red-500 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <form action="{{ route('admin.profile.update-password') }}" method="POST" onsubmit="return validatePasswordForm()">
            @csrf
            @method('PUT')

            <div class="space-y-5 mb-10">
                <div>
                    <label class="block text-[11px] font-bold text-[#797B78] uppercase tracking-widest mb-2 px-2">Password Saat Ini</label>
                    <div class="relative">
                        <input type="password" id="current_password" name="current_password" required
                            class="w-full bg-[#F7F5F4] border border-transparent text-[#2A3435] font-semibold rounded-2xl pl-5 pr-12 py-4 outline-none focus:bg-white focus:border-[#7B5556]/30 focus:ring-4 focus:ring-[#7B5556]/10 transition-all">
                        <button type="button" onclick="toggleCurrentPassword()" class="absolute inset-y-0 right-0 px-4 flex items-center text-[#A9B4B5] hover:text-[#7B5556] transition-colors">
                            <svg id="currentEyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                    <p id="currentPasswordError" class="text-red-500 text-xs mt-1 hidden"></p>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-[#797B78] uppercase tracking-widest mb-2 px-2">Password Baru</label>
                    <div class="relative">
                        <input type="password" id="new_password" name="new_password" required minlength="8"
                            class="w-full bg-[#F7F5F4] border border-transparent text-[#2A3435] font-semibold rounded-2xl pl-5 pr-12 py-4 outline-none focus:bg-white focus:border-[#7B5556]/30 focus:ring-4 focus:ring-[#7B5556]/10 transition-all">
                        <button type="button" onclick="toggleNewPassword()" class="absolute inset-y-0 right-0 px-4 flex items-center text-[#A9B4B5] hover:text-[#7B5556] transition-colors">
                            <svg id="newEyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                    <p class="text-gray-400 text-xs mt-1">Minimal 8 karakter</p>
                    <p id="newPasswordError" class="text-red-500 text-xs mt-1 hidden"></p>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-[#797B78] uppercase tracking-widest mb-2 px-2">Konfirmasi Password Baru</label>
                    <div class="relative">
                        <input type="password" id="confirm_password" name="confirm_password" required
                            class="w-full bg-[#F7F5F4] border border-transparent text-[#2A3435] font-semibold rounded-2xl pl-5 pr-12 py-4 outline-none focus:bg-white focus:border-[#7B5556]/30 focus:ring-4 focus:ring-[#7B5556]/10 transition-all">
                        <button type="button" onclick="toggleConfirmPassword()" class="absolute inset-y-0 right-0 px-4 flex items-center text-[#A9B4B5] hover:text-[#7B5556] transition-colors">
                            <svg id="confirmEyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                    <p id="confirmPasswordError" class="text-red-500 text-xs mt-1 hidden"></p>
                </div>
            </div>

            <div class="flex gap-4">
                <button type="button" onclick="closeChangePasswordModal()" class="w-1/3 py-4 px-6 rounded-2xl border-2 border-[#E1E3DE] text-[#797B78] font-bold text-sm hover:bg-[#F7F5F4] hover:text-[#2A3435] transition-colors">
                    BATAL
                </button>
                <button type="submit" class="w-2/3 py-4 px-6 rounded-2xl bg-gradient-to-r from-[#7B5556] to-[#9B6B6C] text-white font-bold text-sm shadow-[0_8px_20px_rgba(123,85,86,0.25)] hover:shadow-[0_10px_25px_rgba(123,85,86,0.35)] transition-all transform hover:-translate-y-1">
                    UPDATE PASSWORD
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Upload Avatar
    function submitAvatarForm() {
        const fileInput = document.getElementById('avatarUpload');
        if (fileInput.files.length > 0) {
            const file = fileInput.files[0];
            const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
            
            if (!allowedTypes.includes(file.type)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Format file tidak didukung. Gunakan JPG, PNG, atau GIF.',
                    timer: 2000,
                    showConfirmButton: false
                });
                return;
            }
            
            if (file.size > 2 * 1024 * 1024) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Ukuran file maksimal 2MB.',
                    timer: 2000,
                    showConfirmButton: false
                });
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('avatarPreview');
                if (preview) preview.src = e.target.result;
            }
            reader.readAsDataURL(file);
            
            document.getElementById('avatarForm').submit();
        }
    }
    
    // Modal Edit Data Diri
    const editModal = document.getElementById('editProfileModal');
    const editModalBox = editModal ? editModal.querySelector('div') : null;

    function openEditProfileModal() {
        if (!editModal) return;
        editModal.classList.remove('hidden');
        setTimeout(() => {
            editModal.classList.remove('opacity-0');
            if (editModalBox) {
                editModalBox.classList.remove('scale-95');
                editModalBox.classList.add('scale-100');
            }
        }, 10);
    }

    function closeEditProfileModal() {
        if (!editModal) return;
        editModal.classList.add('opacity-0');
        if (editModalBox) {
            editModalBox.classList.remove('scale-100');
            editModalBox.classList.add('scale-95');
        }
        setTimeout(() => {
            editModal.classList.add('hidden');
        }, 300);
    }
    
    // Modal Ubah Password
    const pwdModal = document.getElementById('changePasswordModal');
    const pwdModalBox = pwdModal ? pwdModal.querySelector('div') : null;

    function openChangePasswordModal() {
        if (!pwdModal) return;
        resetPasswordForm();
        pwdModal.classList.remove('hidden');
        setTimeout(() => {
            pwdModal.classList.remove('opacity-0');
            if (pwdModalBox) {
                pwdModalBox.classList.remove('scale-95');
                pwdModalBox.classList.add('scale-100');
            }
        }, 10);
    }

    function closeChangePasswordModal() {
        if (!pwdModal) return;
        pwdModal.classList.add('opacity-0');
        if (pwdModalBox) {
            pwdModalBox.classList.remove('scale-100');
            pwdModalBox.classList.add('scale-95');
        }
        setTimeout(() => {
            pwdModal.classList.add('hidden');
        }, 300);
    }

    function resetPasswordForm() {
        document.getElementById('current_password').value = '';
        document.getElementById('new_password').value = '';
        document.getElementById('confirm_password').value = '';
        document.getElementById('currentPasswordError').classList.add('hidden');
        document.getElementById('newPasswordError').classList.add('hidden');
        document.getElementById('confirmPasswordError').classList.add('hidden');
    }

    // Toggle Password Current
    function toggleCurrentPassword() {
        const input = document.getElementById('current_password');
        const icon = document.getElementById('currentEyeIcon');
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />`;
        } else {
            input.type = 'password';
            icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
        }
    }

    // Toggle Password New
    function toggleNewPassword() {
        const input = document.getElementById('new_password');
        const icon = document.getElementById('newEyeIcon');
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />`;
        } else {
            input.type = 'password';
            icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
        }
    }

    // Toggle Password Confirm
    function toggleConfirmPassword() {
        const input = document.getElementById('confirm_password');
        const icon = document.getElementById('confirmEyeIcon');
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />`;
        } else {
            input.type = 'password';
            icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
        }
    }
    
    // Validasi Password
    function validatePasswordForm() {
        const currentPassword = document.getElementById('current_password');
        const newPassword = document.getElementById('new_password');
        const confirmPassword = document.getElementById('confirm_password');
        
        let isValid = true;
        
        document.getElementById('currentPasswordError').classList.add('hidden');
        document.getElementById('newPasswordError').classList.add('hidden');
        document.getElementById('confirmPasswordError').classList.add('hidden');
        
        if (newPassword.value.length < 6) {
            document.getElementById('newPasswordError').textContent = 'Password baru minimal 6 karakter';
            document.getElementById('newPasswordError').classList.remove('hidden');
            isValid = false;
        }
        
        if (newPassword.value !== confirmPassword.value) {
            document.getElementById('confirmPasswordError').textContent = 'Konfirmasi password tidak sesuai';
            document.getElementById('confirmPasswordError').classList.remove('hidden');
            isValid = false;
        }
        
        return isValid;
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