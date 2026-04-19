<aside class="w-full md:w-72 bg-[#FFF7F6] md:border-r border-[#E1E3DE]/60 flex flex-col justify-between hidden md:flex shrink-0">
            
    <div class="p-8">
        <div class="mb-12">
            <h1 class="text-xl font-extrabold text-[#7B5556] tracking-tight">The Ethereal Clinic</h1>
            <p class="text-xs text-[#B0B3AE] mt-1">Admin Panel</p>
        </div>

        <div class="flex flex-col items-center mb-10">
            <div class="w-24 h-24 rounded-full p-1 border-2 border-[#7B5556]/20 mb-4 overflow-hidden">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=68575E&color=fff" alt="Profile" class="w-full h-full rounded-full object-cover">
            </div>
            <h2 class="text-[#5D605C] font-bold text-lg">{{ Auth::user()->name }}</h2>
            <p class="text-[#797B78] text-sm mt-0.5">Administrator</p>
        </div>

        <nav class="space-y-2">
            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}" 
               class="flex items-center space-x-3 px-5 py-3.5 rounded-2xl font-medium transition-all
               {{ request()->routeIs('admin.dashboard') ? 'bg-white text-[#7B5556] shadow-sm border border-[#E1E3DE]/40 font-semibold' : 'text-[#797B78] hover:bg-[#E1E3DE]/30' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
                <span>Dashboard</span>
            </a>
            
            <!-- Data Gejala -->
            <a href="#" 
               class="flex items-center space-x-3 px-5 py-3.5 rounded-2xl font-medium transition-all
               {{ request()->routeIs('admin.gejala*') ? 'bg-white text-[#7B5556] shadow-sm border border-[#E1E3DE]/40 font-semibold' : 'text-[#797B78] hover:bg-[#E1E3DE]/30' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
                <span>Data Gejala</span>
            </a>
            
            <!-- Data Produk -->
            <a href="#" 
               class="flex items-center space-x-3 px-5 py-3.5 rounded-2xl font-medium transition-all
               {{ request()->routeIs('admin.produk*') ? 'bg-white text-[#7B5556] shadow-sm border border-[#E1E3DE]/40 font-semibold' : 'text-[#797B78] hover:bg-[#E1E3DE]/30' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
                <span>Data Produk</span>
            </a>
            
            <!-- Data Masalah Kulit -->
            <a href="#" 
               class="flex items-center space-x-3 px-5 py-3.5 rounded-2xl font-medium transition-all
               {{ request()->routeIs('admin.masalah-kulit*') ? 'bg-white text-[#7B5556] shadow-sm border border-[#E1E3DE]/40 font-semibold' : 'text-[#797B78] hover:bg-[#E1E3DE]/30' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Data Masalah Kulit</span>
            </a>
            
            <!-- Data Basic Treatment -->
            <a href="#" 
               class="flex items-center space-x-3 px-5 py-3.5 rounded-2xl font-medium transition-all
               {{ request()->routeIs('admin.basic-treatment*') ? 'bg-white text-[#7B5556] shadow-sm border border-[#E1E3DE]/40 font-semibold' : 'text-[#797B78] hover:bg-[#E1E3DE]/30' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                </svg>
                <span>Data Basic Treatment</span>
            </a>
            
            <!-- Data Rule + CF Pakar -->
            <a href="#" 
               class="flex items-center space-x-3 px-5 py-3.5 rounded-2xl font-medium transition-all
               {{ request()->routeIs('admin.rule-cf*') ? 'bg-white text-[#7B5556] shadow-sm border border-[#E1E3DE]/40 font-semibold' : 'text-[#797B78] hover:bg-[#E1E3DE]/30' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                </svg>
                <span>Data Rule + CF Pakar</span>
            </a>
            
            <!-- Data Riwayat Analisis -->
            <a href="#" 
               class="flex items-center space-x-3 px-5 py-3.5 rounded-2xl font-medium transition-all
               {{ request()->routeIs('admin.riwayat-analisis*') ? 'bg-white text-[#7B5556] shadow-sm border border-[#E1E3DE]/40 font-semibold' : 'text-[#797B78] hover:bg-[#E1E3DE]/30' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Riwayat Analisis</span>
            </a>

            <!-- Profile -->
            <a href="{{ route('admin.profile') }}" 
               class="flex items-center space-x-3 px-5 py-3.5 rounded-2xl font-medium transition-all
               {{ request()->routeIs('admin.profile*') ? 'bg-white text-[#7B5556] shadow-sm border border-[#E1E3DE]/40 font-semibold' : 'text-[#797B78] hover:bg-[#E1E3DE]/30' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span>Profile</span>
            </a>
        </nav>
    </div>

    <div class="p-8 space-y-2 border-t border-[#E1E3DE]/60">
        <!-- Logout -->
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full flex items-center space-x-3 px-5 py-3 text-[#B0B3AE] hover:text-[#8A3033] font-medium transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span>Logout</span>
            </button>
        </form>
    </div>
</aside>