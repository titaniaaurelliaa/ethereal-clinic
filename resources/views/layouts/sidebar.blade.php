<aside class="w-full md:w-72 bg-[#FFF7F6] md:border-r border-[#E1E3DE]/60 flex flex-col justify-between hidden md:flex shrink-0">
            
    <div class="p-8">
        <div class="mb-12">
            <h1 class="text-xl font-extrabold text-[#7B5556] tracking-tight">The Ethereal Clinic</h1>
        </div>

        <div class="flex flex-col items-center mb-10">
            <div class="w-24 h-24 rounded-full p-1 border-2 border-[#7B5556]/20 mb-4 overflow-hidden">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=68575E&color=fff" alt="Profile" class="w-full h-full rounded-full object-cover">
            </div>
            <h2 class="text-[#5D605C] font-bold text-lg">{{ Auth::user()->name }}</h2>
            <p class="text-[#797B78] text-sm mt-0.5">Tipe Kulit : Belum Diatur</p>
        </div>

        <nav class="space-y-2">
            <a href="{{ route('pasien.dashboard') }}" class="flex items-center space-x-3 px-5 py-3.5 bg-white text-[#7B5556] rounded-2xl shadow-sm border border-[#E1E3DE]/40 font-semibold transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
                <span>Dashboard</span>
            </a>
            
            <a href="#" class="flex items-center space-x-3 px-5 py-3.5 text-[#797B78] hover:bg-[#E1E3DE]/30 rounded-2xl font-medium transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                <span>Konsultasi</span>
            </a>
            
            <a href="#" class="flex items-center space-x-3 px-5 py-3.5 text-[#797B78] hover:bg-[#E1E3DE]/30 rounded-2xl font-medium transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <span>Riwayat</span>
            </a>
        </nav>
    </div>

    <div class="p-8 space-y-2 border-t border-[#E1E3DE]/60">
        <a href="#" class="flex items-center space-x-3 px-5 py-3 text-[#B0B3AE] hover:text-[#797B78] font-medium transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
            <span>Pengaturan</span>
        </a>
        
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full flex items-center space-x-3 px-5 py-3 text-[#B0B3AE] hover:text-[#8A3033] font-medium transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                <span>Logout</span>
            </button>
        </form>
    </div>
</aside>