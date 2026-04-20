<aside id="desktopSidebar" class="hidden md:flex flex-col w-64 bg-white border-r border-[#E1E3DE]/60 min-h-screen transition-all duration-300 relative z-40 shrink-0">
    
    <button id="toggleSidebar" class="absolute -right-3.5 top-8 w-7 h-7 bg-white border border-[#E1E3DE] rounded-full flex items-center justify-center text-[#68575E] hover:text-[#7B5556] shadow-sm z-50 transition-all hover:scale-110 focus:outline-none">
        <svg id="toggleIcon" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
    </button>

    <div class="h-20 flex items-center justify-center border-b border-[#E1E3DE]/40 px-4 overflow-hidden">
        <a href="{{ route('pasien.dashboard') ?? '#' }}" class="text-xl font-extrabold text-[#7B5556] tracking-tight whitespace-nowrap" id="sidebarLogo">
            The Ethereal
        </a>
        <a href="{{ route('pasien.dashboard') ?? '#' }}" class="hidden text-xl font-extrabold text-[#7B5556] tracking-tight" id="sidebarLogoMini">
            TE
        </a>
    </div>

    <div class="py-6 border-b border-[#E1E3DE]/30 overflow-hidden">
        <div class="flex items-center px-4">
            <div class="w-12 h-12 rounded-full overflow-hidden border-2 border-[#7B5556]/20 shrink-0 shadow-sm">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Pasien') }}&background=68575E&color=fff" alt="Profile" class="w-full h-full object-cover">
            </div>
            <div class="ml-3 sidebar-text whitespace-nowrap">
                <p class="text-base font-bold text-[#5D605C]">{{ Auth::user() ? explode(' ', Auth::user()->name)[0] : 'Pasien' }}</p>
                <p class="text-[11px] text-[#797B78] uppercase tracking-wider font-bold mt-0.5">Pasien</p>
            </div>
        </div>
    </div>

    <nav class="flex-1 py-4 px-4 space-y-2 overflow-hidden">
        <a href="{{ route('pasien.dashboard') ?? '#' }}" class="flex items-center px-3 py-3 bg-[#FFEFF3] text-[#7B5556] rounded-xl font-semibold transition-colors group" title="Dashboard">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
            </svg>
            <span class="ml-3 whitespace-nowrap sidebar-text">Dashboard</span>
        </a>

        <a href="#" class="flex items-center px-3 py-3 text-[#797B78] hover:bg-[#F5F5F5] hover:text-[#5D605C] rounded-xl font-medium transition-colors group" title="Konsultasi">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
            </svg>
            <span class="ml-3 whitespace-nowrap sidebar-text">Analisis</span>
        </a>

        <a href="#" class="flex items-center px-3 py-3 text-[#797B78] hover:bg-[#F5F5F5] hover:text-[#5D605C] rounded-xl font-medium transition-colors group" title="Riwayat">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="ml-3 whitespace-nowrap sidebar-text">Riwayat</span>
        </a>

        <a href="#" class="flex items-center px-3 py-3 text-[#797B78] hover:bg-[#F5F5F5] hover:text-[#5D605C] rounded-xl font-medium transition-colors group" title="Profil">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <span class="ml-3 whitespace-nowrap sidebar-text">Profil</span>
        </a>
    </nav>

    <div class="p-4 border-t border-[#E1E3DE]/40 overflow-hidden">
        <button type="button" id="logoutBtn" class="flex items-center w-full px-3 py-2.5 text-[#8A3033] hover:bg-[#FFF7F6] rounded-xl font-medium transition-colors" title="Logout">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
            <span class="ml-3 whitespace-nowrap sidebar-text">Logout</span>
        </button>
        
        <form id="logoutForm" action="{{ route('logout') ?? '#' }}" method="POST" class="hidden">
            @csrf
        </form>
    </div>
</aside>

<div id="logoutModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm transition-opacity duration-300">
    <div class="bg-white rounded-3xl shadow-2xl p-6 md:p-8 w-[90%] max-w-sm transform scale-95 transition-transform duration-300 relative">
        <div class="mx-auto w-16 h-16 bg-[#FFF7F6] rounded-full flex items-center justify-center mb-5 shadow-inner">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#8A3033]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
        </div>
        <h3 class="text-xl font-bold text-[#5D605C] text-center mb-2">Konfirmasi Keluar</h3>
        <p class="text-sm text-[#797B78] text-center mb-8 leading-relaxed">
            Apakah Anda yakin ingin keluar dari sesi ini? Anda harus login kembali untuk mengakses layanan klinik.
        </p>
        <div class="flex gap-3">
            <button type="button" id="cancelLogout" class="flex-1 px-4 py-2.5 rounded-full border border-[#E1E3DE] text-[#68575E] font-semibold hover:bg-[#F5F5F5] transition-colors">
                Batal
            </button>
            <button type="button" id="confirmLogout" class="flex-1 px-4 py-2.5 rounded-full bg-gradient-to-r from-[#7B5556] to-[#EBDBDD] text-white font-semibold shadow-md hover:scale-105 transition-transform">
                Ya, Keluar
            </button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('desktopSidebar');
        const toggleBtn = document.getElementById('toggleSidebar');
        const toggleIcon = document.getElementById('toggleIcon');
        const sidebarTexts = document.querySelectorAll('.sidebar-text');
        const sidebarLogo = document.getElementById('sidebarLogo');
        const sidebarLogoMini = document.getElementById('sidebarLogoMini');

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('w-64');
            sidebar.classList.toggle('w-20');
            
            if (sidebar.classList.contains('w-20')) {
                toggleIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />';
                sidebarLogo.classList.add('hidden');
                sidebarLogoMini.classList.remove('hidden');
                sidebarTexts.forEach(el => {
                    el.style.opacity = '0';
                    setTimeout(() => el.classList.add('hidden'), 150);
                });
            } else {
                toggleIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />';
                sidebarLogo.classList.remove('hidden');
                sidebarLogoMini.classList.add('hidden');
                sidebarTexts.forEach(el => {
                    el.classList.remove('hidden');
                    setTimeout(() => el.style.opacity = '1', 50);
                });
            }
        });

        const logoutBtn = document.getElementById('logoutBtn');
        const logoutModal = document.getElementById('logoutModal');
        const cancelLogout = document.getElementById('cancelLogout');
        const confirmLogout = document.getElementById('confirmLogout');
        const logoutForm = document.getElementById('logoutForm');
        const modalContent = logoutModal.querySelector('.bg-white');

        logoutBtn.addEventListener('click', () => {
            logoutModal.classList.remove('hidden');
            setTimeout(() => {
                modalContent.classList.remove('scale-95');
                modalContent.classList.add('scale-100');
            }, 10);
        });

        cancelLogout.addEventListener('click', () => {
            modalContent.classList.remove('scale-100');
            modalContent.classList.add('scale-95');
            setTimeout(() => {
                logoutModal.classList.add('hidden');
            }, 200);
        });

        confirmLogout.addEventListener('click', () => {
            logoutForm.submit();
        });
    });
</script>