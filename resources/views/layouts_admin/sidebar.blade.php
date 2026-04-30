<aside id="desktopSidebar"
    class="flex flex-col w-64 bg-white border-r border-[#E1E3DE]/60 min-h-screen transition-all duration-300 relative z-40 shrink-0">

    <!-- Tombol Toggle dengan Icon Garis 3 -->
    <button id="toggleSidebar"
        class="absolute -right-3.5 top-8 w-7 h-7 bg-white border border-[#E1E3DE] rounded-full flex items-center justify-center text-[#68575E] hover:text-[#7B5556] shadow-md z-50 transition-all hover:scale-110 focus:outline-none">
        <svg id="toggleIcon" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-all duration-300" fill="none"
            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <!-- Icon garis 3 (hamburger) - tampil saat sidebar terbuka -->
            <path id="iconHamburger" stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            <!-- Icon panah kiri - tampil saat sidebar tertutup -->
            <path id="iconArrow" stroke-linecap="round" stroke-linejoin="round" class="hidden" d="M9 5l7 7-7 7" />
        </svg>
    </button>

    <!-- Logo Section -->
    <div class="h-20 flex items-center justify-center border-b border-[#E1E3DE]/40 px-4 overflow-hidden">
        <a href="{{ route('admin.dashboard') }}"
            class="text-xl font-extrabold text-[#7B5556] tracking-tight whitespace-nowrap" id="sidebarLogo">
            The Ethereal Clinic
        </a>
        <a href="{{ route('admin.dashboard') }}" class="hidden text-xl font-extrabold text-[#7B5556] tracking-tight"
            id="sidebarLogoMini">
            TEC
        </a>
    </div>

    <!-- Profile Section -->
    <div class="py-6 border-b border-[#E1E3DE]/30 overflow-hidden">
        <div class="flex items-center px-4">
            <div
                class="w-12 h-12 rounded-full overflow-hidden border-2 border-[#7B5556]/20 shrink-0 shadow-sm bg-white">
                <img src="{{ Auth::user()->avatar ? asset('storage/avatars/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name ?? 'Admin') . '&background=68575E&color=fff' }}"
                    alt="Profile" class="w-full h-full object-cover">
            </div>
            <div class="ml-3 sidebar-text whitespace-nowrap">
                <p class="text-base font-bold text-[#5D605C]">
                    {{ Auth::user() ? explode(' ', Auth::user()->name)[0] : 'Admin' }}</p>
                <p class="text-[11px] text-[#797B78] uppercase tracking-wider font-bold mt-0.5">Administrator</p>
            </div>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-1 py-4 px-4 space-y-2 overflow-y-auto">
        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}"
            class="flex items-center px-3 py-3 rounded-xl transition-colors group {{ request()->routeIs('admin.dashboard') ? 'bg-[#FFEFF3] text-[#7B5556] font-semibold' : 'text-[#797B78] hover:bg-[#F5F5F5] hover:text-[#5D605C] font-medium' }}"
            title="Dashboard">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
            </svg>
            <span class="ml-3 whitespace-nowrap sidebar-text">Dashboard</span>
        </a>

        <!-- Data Gejala -->
        <a href="{{ route('admin.symptoms.index') }}"
            class="flex items-center px-3 py-3 rounded-xl transition-colors group {{ request()->routeIs('symptoms.*') ? 'bg-[#FFEFF3] text-[#7B5556] font-semibold' : 'text-[#797B78] hover:bg-[#F5F5F5] hover:text-[#5D605C] font-medium' }}"
            title="Data Gejala">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
            </svg>
            <span class="ml-3 whitespace-nowrap sidebar-text">Data Gejala</span>
        </a>

        <!-- Data Produk -->
        <a href="{{ route('admin.dataproduk.index') }}"
            class="flex items-center px-3 py-3 rounded-xl transition-colors group text-[#797B78] hover:bg-[#F5F5F5] hover:text-[#5D605C] font-medium"
            title="Data Produk">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
            </svg>
            <span class="ml-3 whitespace-nowrap sidebar-text">Data Produk</span>
        </a>

        <!-- Data Masalah Kulit -->
        <a href="{{ route('admin.skin-problems.index') }}"
            class="flex items-center px-3 py-3 rounded-xl transition-colors group text-[#797B78] hover:bg-[#F5F5F5] hover:text-[#5D605C] font-medium"
            title="Data Masalah Kulit">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="ml-3 whitespace-nowrap sidebar-text">Data Masalah Kulit</span>
        </a>

        <!-- Data Treatment -->
        <a href="{{ route('admin.treatment.index') }}"
            class="flex items-center px-3 py-3 rounded-xl transition-colors group text-[#797B78] hover:bg-[#F5F5F5] hover:text-[#5D605C] font-medium"
            title="Data Treatment">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
            </svg>
            <span class="ml-3 whitespace-nowrap sidebar-text">Data Treatment</span>
        </a>

        <!-- Rule + CF Pakar -->
        <a href="#"
            class="flex items-center px-3 py-3 rounded-xl transition-colors group text-[#797B78] hover:bg-[#F5F5F5] hover:text-[#5D605C] font-medium"
            title="Rule & CF Pakar">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
            </svg>
            <span class="ml-3 whitespace-nowrap sidebar-text">Rule + CF Pakar</span>
        </a>

        <!-- Riwayat Analisis -->
        <a href="#"
            class="flex items-center px-3 py-3 rounded-xl transition-colors group text-[#797B78] hover:bg-[#F5F5F5] hover:text-[#5D605C] font-medium"
            title="Riwayat Analisis">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="ml-3 whitespace-nowrap sidebar-text">Riwayat Analisis</span>
        </a>

        <!-- Profile Admin -->
        <a href="{{ route('admin.profile') }}"
            class="flex items-center px-3 py-3 rounded-xl transition-colors group {{ request()->routeIs('admin.profile*') ? 'bg-[#FFEFF3] text-[#7B5556] font-semibold' : 'text-[#797B78] hover:bg-[#F5F5F5] hover:text-[#5D605C] font-medium' }}"
            title="Profile">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <span class="ml-3 whitespace-nowrap sidebar-text">Profile</span>
        </a>
    </nav>

    <!-- Footer / Logout Section -->
    <div class="p-4 border-t border-[#E1E3DE]/40 overflow-hidden">
        <button type="button" id="logoutBtn"
            class="flex items-center w-full px-3 py-2.5 text-[#8A3033] hover:bg-[#FFF7F6] rounded-xl font-medium transition-colors"
            title="Logout">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
            <span class="ml-3 whitespace-nowrap sidebar-text">Logout</span>
        </button>

        <form id="logoutForm" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
        </form>
    </div>
</aside>

<!-- Modal Konfirmasi Logout -->
<div id="logoutModal"
    class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm transition-opacity duration-300">
    <div
        class="bg-white rounded-3xl shadow-2xl p-6 md:p-8 w-[90%] max-w-sm transform scale-95 transition-transform duration-300 relative">
        <div class="mx-auto w-16 h-16 bg-[#FFF7F6] rounded-full flex items-center justify-center mb-5 shadow-inner">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#8A3033]" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
        </div>
        <h3 class="text-xl font-bold text-[#5D605C] text-center mb-2">Konfirmasi Keluar</h3>
        <p class="text-sm text-[#797B78] text-center mb-8 leading-relaxed">
            Apakah Anda yakin ingin keluar dari sesi ini? Anda harus login kembali untuk mengakses panel admin.
        </p>
        <div class="flex gap-3">
            <button type="button" id="cancelLogout"
                class="flex-1 px-4 py-2.5 rounded-full border border-[#E1E3DE] text-[#68575E] font-semibold hover:bg-[#F5F5F5] transition-colors">
                Batal
            </button>
            <button type="button" id="confirmLogout"
                class="flex-1 px-4 py-2.5 rounded-full bg-gradient-to-r from-[#7B5556] to-[#EBDBDD] text-white font-semibold shadow-md hover:scale-105 transition-transform">
                Ya, Keluar
            </button>
        </div>
    </div>
</div>

<!-- CSS untuk Sidebar dan Main Content -->
<style>
    /* Pastikan sidebar selalu terlihat di semua ukuran */
    #desktopSidebar {
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        z-index: 40;
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.05);
    }

    /* Main content - beri margin kiri sesuai lebar sidebar */
    main,
    .main-content,
    .content-wrapper {
        margin-left: 256px;
        transition: margin-left 0.3s ease-in-out;
    }

    /* Sidebar Collapsed State */
    #desktopSidebar.w-20 {
        width: 80px !important;
    }

    #desktopSidebar.w-20 .sidebar-text {
        display: none;
    }

    #desktopSidebar.w-20 .px-4 {
        padding-left: 0.5rem !important;
        padding-right: 0.5rem !important;
    }

    #desktopSidebar.w-20 .flex.items-center.px-4 {
        justify-content: center;
    }

    #desktopSidebar.w-20 .ml-3 {
        margin-left: 0;
    }

    #desktopSidebar.w-20 .py-6 .w-12 {
        margin: 0 auto;
    }

    #desktopSidebar.w-20 nav a {
        justify-content: center;
        padding-left: 0;
        padding-right: 0;
    }

    #desktopSidebar.w-20 nav a svg {
        margin-right: 0;
    }

    #desktopSidebar.w-20 nav a .ml-3 {
        display: none;
    }

    /* Main content saat sidebar collapsed */
    #desktopSidebar.w-20~main,
    #desktopSidebar.w-20~.main-content,
    #desktopSidebar.w-20~.content-wrapper {
        margin-left: 80px !important;
    }

    /* Tombol toggle selalu terlihat */
    #toggleSidebar {
        cursor: pointer;
    }

    /* Scroll untuk menu jika terlalu panjang */
    nav {
        overflow-y: auto;
        scrollbar-width: thin;
    }

    nav::-webkit-scrollbar {
        width: 4px;
    }

    nav::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    nav::-webkit-scrollbar-thumb {
        background: #E1E3DE;
        border-radius: 10px;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('desktopSidebar');
        const toggleBtn = document.getElementById('toggleSidebar');
        const iconHamburger = document.getElementById('iconHamburger');
        const iconArrow = document.getElementById('iconArrow');
        const sidebarTexts = document.querySelectorAll('.sidebar-text');
        const sidebarLogo = document.getElementById('sidebarLogo');
        const sidebarLogoMini = document.getElementById('sidebarLogoMini');

        // Cek local storage untuk status sidebar
        const isSidebarCollapsed = localStorage.getItem('adminSidebarCollapsed') === 'true';

        // Fungsi untuk update margin main content
        function updateMainContentMargin() {
            const mainContent = document.querySelector('main') || document.querySelector('.main-content') ||
                document.querySelector('.content-wrapper');
            if (mainContent) {
                if (sidebar.classList.contains('w-20')) {
                    mainContent.style.marginLeft = '80px';
                } else {
                    mainContent.style.marginLeft = '256px';
                }
            }
        }

        // Set initial state berdasarkan local storage
        if (isSidebarCollapsed) {
            sidebar.classList.add('w-20');
            sidebar.classList.remove('w-64');
            iconHamburger.classList.add('hidden');
            iconArrow.classList.remove('hidden');
            sidebarLogo.classList.add('hidden');
            sidebarLogoMini.classList.remove('hidden');
            sidebarTexts.forEach(el => {
                el.style.display = 'none';
            });
            updateMainContentMargin();
        }

        // Toggle sidebar saat tombol diklik
        if (toggleBtn) {
            toggleBtn.addEventListener('click', function(e) {
                e.preventDefault();

                if (sidebar.classList.contains('w-64')) {
                    // Collapse sidebar
                    sidebar.classList.remove('w-64');
                    sidebar.classList.add('w-20');
                    iconHamburger.classList.add('hidden');
                    iconArrow.classList.remove('hidden');
                    sidebarLogo.classList.add('hidden');
                    sidebarLogoMini.classList.remove('hidden');
                    sidebarTexts.forEach(el => {
                        el.style.display = 'none';
                    });
                    localStorage.setItem('adminSidebarCollapsed', 'true');
                } else {
                    // Expand sidebar
                    sidebar.classList.remove('w-20');
                    sidebar.classList.add('w-64');
                    iconHamburger.classList.remove('hidden');
                    iconArrow.classList.add('hidden');
                    sidebarLogo.classList.remove('hidden');
                    sidebarLogoMini.classList.add('hidden');
                    sidebarTexts.forEach(el => {
                        el.style.display = '';
                    });
                    localStorage.setItem('adminSidebarCollapsed', 'false');
                }
                updateMainContentMargin();
            });
        }

        // Logout Modal Functionality
        const logoutBtn = document.getElementById('logoutBtn');
        const logoutModal = document.getElementById('logoutModal');
        const cancelLogout = document.getElementById('cancelLogout');
        const confirmLogout = document.getElementById('confirmLogout');
        const logoutForm = document.getElementById('logoutForm');

        if (logoutBtn && logoutModal) {
            const modalContent = logoutModal.querySelector('.bg-white');

            function openModal() {
                logoutModal.classList.remove('hidden');
                setTimeout(() => {
                    if (modalContent) {
                        modalContent.classList.remove('scale-95');
                        modalContent.classList.add('scale-100');
                    }
                }, 10);
            }

            function closeModal() {
                if (modalContent) {
                    modalContent.classList.remove('scale-100');
                    modalContent.classList.add('scale-95');
                }
                setTimeout(() => {
                    logoutModal.classList.add('hidden');
                }, 200);
            }

            logoutBtn.addEventListener('click', openModal);

            if (cancelLogout) {
                cancelLogout.addEventListener('click', closeModal);
            }

            if (confirmLogout && logoutForm) {
                confirmLogout.addEventListener('click', () => {
                    logoutForm.submit();
                });
            }

            logoutModal.addEventListener('click', (e) => {
                if (e.target === logoutModal) {
                    closeModal();
                }
            });
        }
    });
</script>
