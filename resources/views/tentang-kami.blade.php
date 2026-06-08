@extends('landingpage.app')

@section('title', 'Tentang Kami - The Ethereal Clinic')

@section('content')
    {{-- ─── HERO SECTION ────────────────────────────────────────────── --}}
    <section class="w-full bg-[#FFEFF3] py-20 lg:py-32">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <span class="text-[#7B5556] font-bold tracking-[0.2em] uppercase text-sm mb-4 block">Di Balik Layar</span>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-[#68575E] leading-tight tracking-tight mb-6">
                Merevolusi Dermatologi Melalui <span class="text-[#8A3033]">Teknologi Cerdas</span>
            </h1>
            <p class="text-lg text-[#72544E] leading-relaxed max-w-2xl mx-auto opacity-90">
                Kami menggabungkan kepakaran medis dengan kecerdasan buatan untuk memberikan analisis dan perawatan kulit yang personal, akurat, dan dapat diakses dari mana saja.
            </p>
        </div>
    </section>

    {{-- ─── VISI & MISI SECTION ────────────────────────────────────────────── --}}
    <section class="max-w-7xl mx-auto px-6 py-24">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
            <div class="bg-white p-10 rounded-[32px] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 hover:-translate-y-2 transition-transform duration-500">
                <div class="w-14 h-14 bg-[#FFEFF3] rounded-2xl flex items-center justify-center mb-8 text-[#8A3033]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                </div>
                <h2 class="text-3xl font-bold text-[#68575E] mb-4">Visi Kami</h2>
                <p class="text-[#72544E] leading-relaxed text-lg">
                    Menjadi pelopor klinik kesehatan kulit digital di Indonesia yang menjadikan perawatan kulit berkualitas tinggi terjangkau dan mudah diakses oleh semua lapisan masyarakat, dengan memanfaatkan inovasi AI terdepan.
                </p>
            </div>

            <div>
                <h2 class="text-3xl font-bold text-[#68575E] mb-8">Misi Utama</h2>
                <ul class="space-y-6">
                    <li class="flex items-start">
                        <div class="mt-1 bg-[#8A3033] rounded-full p-1 mr-4 shrink-0 text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                        </div>
                        <p class="text-[#72544E] text-lg">Memberikan diagnosis kulit yang presisi melalui sistem pakar yang divalidasi oleh dokter spesialis.</p>
                    </li>
                    <li class="flex items-start">
                        <div class="mt-1 bg-[#8A3033] rounded-full p-1 mr-4 shrink-0 text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                        </div>
                        <p class="text-[#72544E] text-lg">Membangun ekosistem kesehatan terintegrasi yang menghubungkan pasien langsung dengan ahli dermatologi.</p>
                    </li>
                    <li class="flex items-start">
                        <div class="mt-1 bg-[#8A3033] rounded-full p-1 mr-4 shrink-0 text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                        </div>
                        <p class="text-[#72544E] text-lg">Menjaga privasi dan kerahasiaan data medis pasien sesuai standar kepatuhan tertinggi.</p>
                    </li>
                </ul>
            </div>
        </div>
    </section>

    {{-- ─── SECTION TIM DEVELOPER ────────────────────────────────────────────── --}}
    <section class="relative w-full bg-[#FAFAFA] py-24 overflow-hidden">
        <div class="absolute top-0 left-0 w-64 h-64 bg-[#FFEFF3] rounded-full mix-blend-multiply filter blur-3xl opacity-50 -translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 right-0 w-80 h-80 bg-[#FFEFF3] rounded-full mix-blend-multiply filter blur-3xl opacity-50 translate-x-1/3 translate-y-1/3"></div>

        <div class="relative max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <span class="text-[#7B5556] font-bold tracking-[0.2em] uppercase text-sm mb-3 block">Tim Pengembang</span>
                <h2 class="text-3xl md:text-4xl font-bold text-[#68575E] mb-4">Talenta di Balik Ethereal Clinic</h2>
                <p class="text-[#72544E] max-w-2xl mx-auto text-lg">Kolaborasi solid mahasiswa Sistem Informasi dalam merancang arsitektur kecerdasan buatan dan sistem pakar medis.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6">
                

                {{-- Developer 2: Titania --}}
                <div class="relative bg-white rounded-[2rem] p-6 shadow-[0_4px_20px_rgba(0,0,0,0.02)] border border-[#FFEFF3] hover:shadow-[0_8px_30px_rgba(138,48,51,0.08)] hover:-translate-y-2 transition-all duration-500 group overflow-hidden z-10 flex flex-col h-full">
                    <div class="absolute -right-10 -top-10 w-32 h-32 bg-[#FFEFF3] rounded-full opacity-0 group-hover:opacity-100 group-hover:scale-150 transition-all duration-700 -z-10"></div>
                    <div class="w-28 h-28 mx-auto rounded-full overflow-hidden mb-5 border-[3px] border-white shadow-lg ring-4 ring-[#FFEFF3] group-hover:ring-[#8A3033]/20 transition-all duration-300 bg-gray-50 shrink-0">
                        <img src="{{ asset('assets/img/titan.jpeg') }}" 
                             onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name=Titania+A&background=FFEFF3&color=8A3033&size=150';" 
                             alt="Titania Aurellia" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-[17px] font-bold text-[#68575E] leading-tight text-center">Titania Aurellia</h3>
                    <p class="text-[#8A3033] font-semibold text-[11px] mt-1.5 mb-3 uppercase tracking-wider text-center">Project Manager & Git Master</p>
                    <p class="text-[#72544E]/80 text-xs text-center leading-relaxed flex-grow">Mengawal timeline proyek, resolusi konflik repositori, dan merapikan dokumentasi sistem.</p>
                    <div class="mt-5 pt-4 border-t border-gray-100 flex justify-center gap-3 shrink-0">
                        <div class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center text-gray-400 hover:text-[#8A3033] hover:bg-[#FFEFF3] transition-colors cursor-pointer">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"/></svg>
                        </div>
                    </div>
                </div>

                {{-- Developer 3: Haura --}}
                <div class="relative bg-white rounded-[2rem] p-6 shadow-[0_4px_20px_rgba(0,0,0,0.02)] border border-[#FFEFF3] hover:shadow-[0_8px_30px_rgba(138,48,51,0.08)] hover:-translate-y-2 transition-all duration-500 group overflow-hidden z-10 flex flex-col h-full">
                    <div class="absolute -right-10 -top-10 w-32 h-32 bg-[#FFEFF3] rounded-full opacity-0 group-hover:opacity-100 group-hover:scale-150 transition-all duration-700 -z-10"></div>
                    <div class="w-28 h-28 mx-auto rounded-full overflow-hidden mb-5 border-[3px] border-white shadow-lg ring-4 ring-[#FFEFF3] group-hover:ring-[#8A3033]/20 transition-all duration-300 bg-gray-50 shrink-0">
                        <img src="{{ asset('assets/img/haura.jpeg') }}" 
                             onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name=Haura+M&background=FFEFF3&color=8A3033&size=150';" 
                             alt="Haura" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-[17px] font-bold text-[#68575E] leading-tight text-center">Haura</h3>
                    <p class="text-[#8A3033] font-semibold text-[11px] mt-1.5 mb-3 uppercase tracking-wider text-center">UI/UX Researcher</p>
                    <p class="text-[#72544E]/80 text-xs text-center leading-relaxed flex-grow">Merancang arsitektur interaksi, alur pengalaman pengguna, dan riset desain visual.</p>
                    <div class="mt-5 pt-4 border-t border-gray-100 flex justify-center gap-3 shrink-0">
                        <div class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center text-gray-400 hover:text-[#8A3033] hover:bg-[#FFEFF3] transition-colors cursor-pointer">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"/></svg>
                        </div>
                    </div>
                </div>

                                {{-- Developer 1: Ivan --}}
                <div class="relative bg-white rounded-[2rem] p-6 shadow-[0_4px_20px_rgba(0,0,0,0.02)] border border-[#FFEFF3] hover:shadow-[0_8px_30px_rgba(138,48,51,0.08)] hover:-translate-y-2 transition-all duration-500 group overflow-hidden z-10 flex flex-col h-full">
                    <div class="absolute -right-10 -top-10 w-32 h-32 bg-[#FFEFF3] rounded-full opacity-0 group-hover:opacity-100 group-hover:scale-150 transition-all duration-700 -z-10"></div>
                    <div class="w-28 h-28 mx-auto rounded-full overflow-hidden mb-5 border-[3px] border-white shadow-lg ring-4 ring-[#FFEFF3] group-hover:ring-[#8A3033]/20 transition-all duration-300 bg-gray-50 shrink-0">
                        <img src="{{ asset('assets/img/ivan.jpeg') }}" 
                             onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name=Ivan+R&background=FFEFF3&color=8A3033&size=150';" 
                             alt="Ivan Rizal Ahmadi" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-[17px] font-bold text-[#68575E] leading-tight text-center">Ivan Rizal Ahmadi</h3>
                    <p class="text-[#8A3033] font-semibold text-[11px] mt-1.5 mb-3 uppercase tracking-wider text-center">Lead Backend & AI Engineer</p>
                    <p class="text-[#72544E]/80 text-xs text-center leading-relaxed flex-grow">Arsitek logika hybrid Certainty Factor, relasi database, dan integrasi mulus API Roboflow.</p>
                    <div class="mt-5 pt-4 border-t border-gray-100 flex justify-center gap-3 shrink-0">
                        <div class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center text-gray-400 hover:text-[#8A3033] hover:bg-[#FFEFF3] transition-colors cursor-pointer">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"/></svg>
                        </div>
                    </div>
                </div>

                {{-- Developer 4: Luthfi --}}
                <div class="relative bg-white rounded-[2rem] p-6 shadow-[0_4px_20px_rgba(0,0,0,0.02)] border border-[#FFEFF3] hover:shadow-[0_8px_30px_rgba(138,48,51,0.08)] hover:-translate-y-2 transition-all duration-500 group overflow-hidden z-10 flex flex-col h-full">
                    <div class="absolute -right-10 -top-10 w-32 h-32 bg-[#FFEFF3] rounded-full opacity-0 group-hover:opacity-100 group-hover:scale-150 transition-all duration-700 -z-10"></div>
                    <div class="w-28 h-28 mx-auto rounded-full overflow-hidden mb-5 border-[3px] border-white shadow-lg ring-4 ring-[#FFEFF3] group-hover:ring-[#8A3033]/20 transition-all duration-300 bg-gray-50 shrink-0">
                        <img src="{{ asset('assets/img/luthfi.jpeg') }}" 
                             onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name=Luthfi+M&background=FFEFF3&color=8A3033&size=150';" 
                             alt="Luthfi Mahardika" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-[17px] font-bold text-[#68575E] leading-tight text-center">Luthfi Mahardika</h3>
                    <p class="text-[#8A3033] font-semibold text-[11px] mt-1.5 mb-3 uppercase tracking-wider text-center">Front-End Developer</p>
                    <p class="text-[#72544E]/80 text-xs text-center leading-relaxed flex-grow">Menerjemahkan desain figma menjadi komponen antarmuka web responsif dengan Tailwind CSS.</p>
                    <div class="mt-5 pt-4 border-t border-gray-100 flex justify-center gap-3 shrink-0">
                        <div class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center text-gray-400 hover:text-[#8A3033] hover:bg-[#FFEFF3] transition-colors cursor-pointer">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"/></svg>
                        </div>
                    </div>
                </div>

                {{-- Developer 5: Malik --}}
                <div class="relative bg-white rounded-[2rem] p-6 shadow-[0_4px_20px_rgba(0,0,0,0.02)] border border-[#FFEFF3] hover:shadow-[0_8px_30px_rgba(138,48,51,0.08)] hover:-translate-y-2 transition-all duration-500 group overflow-hidden z-10 flex flex-col h-full">
                    <div class="absolute -right-10 -top-10 w-32 h-32 bg-[#FFEFF3] rounded-full opacity-0 group-hover:opacity-100 group-hover:scale-150 transition-all duration-700 -z-10"></div>
                    <div class="w-28 h-28 mx-auto rounded-full overflow-hidden mb-5 border-[3px] border-white shadow-lg ring-4 ring-[#FFEFF3] group-hover:ring-[#8A3033]/20 transition-all duration-300 bg-gray-50 shrink-0">
                        <img src="{{ asset('assets/img/malik.jpeg') }}" 
                             onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name=Malik&background=FFEFF3&color=8A3033&size=150';" 
                             alt="Malik" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-[17px] font-bold text-[#68575E] leading-tight text-center">Malik</h3>
                    <p class="text-[#8A3033] font-semibold text-[11px] mt-1.5 mb-3 uppercase tracking-wider text-center">Database & QA Specialist</p>
                    <p class="text-[#72544E]/80 text-xs text-center leading-relaxed flex-grow">Menguji validitas input-output metode Certainty Factor dan optimalisasi struktur kueri.</p>
                    <div class="mt-5 pt-4 border-t border-gray-100 flex justify-center gap-3 shrink-0">
                        <div class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center text-gray-400 hover:text-[#8A3033] hover:bg-[#FFEFF3] transition-colors cursor-pointer">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"/></svg>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection