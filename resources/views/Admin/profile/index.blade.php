@extends('layouts_admin.app')

@section('title', 'Profile Admin - The Ethereal Clinic')

@section('content')
<div class="w-full px-4 md:px-6">
    
    <!-- Header Section dengan Background - LEBIH KECIL & ROUNDED -->
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
                    
                    <!-- Foto Profile -->
                    <div class="text-center py-6 px-4 border-b border-[#E1E3DE]">
                        <div class="relative inline-block">
                            <div class="w-24 h-24 mx-auto bg-gradient-to-br from-[#7B5556] to-[#9B6B6C] rounded-full flex items-center justify-center shadow-md">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
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
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm border border-[#E1E3DE] overflow-hidden">
                    
                    <div class="px-5 py-3 border-b border-[#E1E3DE] bg-gray-50">
                        <h3 class="text-base font-bold text-[#5D605C]">Informasi Pribadi</h3>
                        <p class="text-[#797B78] text-xs">Data diri administrator</p>
                    </div>
                    
                    <div class="p-5">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            
                            <!-- Nama Lengkap -->
                            <div class="bg-gray-50 rounded-xl p-3">
                                <label class="block text-[#797B78] text-xs mb-1">Nama Lengkap</label>
                                <p class="text-[#5D605C] text-sm font-semibold">{{ $user->name }}</p>
                            </div>

                            <!-- Email -->
                            <div class="bg-gray-50 rounded-xl p-3">
                                <label class="block text-[#797B78] text-xs mb-1">Alamat Email</label>
                                <p class="text-[#5D605C] text-sm font-semibold">{{ $user->email }}</p>
                            </div>

                            <!-- Jabatan -->
                            <div class="bg-gray-50 rounded-xl p-3">
                                <label class="block text-[#797B78] text-xs mb-1">Jabatan</label>
                                <p class="text-[#5D605C] text-sm font-semibold">
                                    @if($user->role == 'admin')
                                        Administrator
                                    @elseif($user->role == 'pasien')
                                        Pasien
                                    @else
                                        {{ ucfirst($user->role) }}
                                    @endif
                                </p>
                            </div>

                            <!-- Status Akun -->
                            <div class="bg-gray-50 rounded-xl p-3">
                                <label class="block text-[#797B78] text-xs mb-1">Status Akun</label>
                                <p class="text-green-600 text-sm font-semibold flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Aktif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection