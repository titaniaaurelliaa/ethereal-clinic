<nav class="md:hidden flex items-center justify-between bg-[#FFF7F6] p-5 border-b border-[#E1E3DE]/60 relative z-50 shadow-sm">
    
    <a href="{{ route('pasien.dashboard') }}" class="text-lg font-extrabold text-[#7B5556] tracking-tight">
        The Ethereal Clinic
    </a>

    <button id="mobileMenuBtn" class="text-[#68575E] hover:text-[#7B5556] focus:outline-none transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>

    <div id="mobileMenu" class="hidden absolute top-full left-0 w-full bg-white shadow-xl border-b border-[#E1E3DE]/60 flex-col py-4 px-6 space-y-4">
        
        <div class="flex items-center space-x-3 mb-2 pb-4 border-b border-[#E1E3DE]/40">
            <div class="w-10 h-10 rounded-full overflow-hidden border border-[#7B5556]/20">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=68575E&color=fff" alt="Profile" class="w-full h-full object-cover">
            </div>
            <div>
                <p class="text-sm font-bold text-[#5D605C]">{{ Auth::user()->name }}</p>
                <p class="text-xs text-[#797B78]">Pasien</p>
            </div>
        </div>

        <a href="{{ route('pasien.dashboard') }}" class="flex items-center space-x-3 text-[#7B5556] font-semibold">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
            <span>Dashboard</span>
        </a>
        <a href="#" class="flex items-center space-x-3 text-[#797B78] font-medium">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
            <span>Konsultasi</span>
        </a>
        <a href="#" class="flex items-center space-x-3 text-[#797B78] font-medium">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            <span>Riwayat</span>
        </a>

        <form action="{{ route('logout') }}" method="POST" class="pt-4 mt-2 border-t border-[#E1E3DE]/40">
            @csrf
            <button type="submit" class="flex items-center space-x-3 text-[#8A3033] font-medium w-full text-left">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                <span>Logout</span>
            </button>
        </form>
    </div>
</nav>

<script>
    document.getElementById('mobileMenuBtn').addEventListener('click', function() {
        var menu = document.getElementById('mobileMenu');
        menu.classList.toggle('hidden');
        menu.classList.toggle('flex');
    });
</script>