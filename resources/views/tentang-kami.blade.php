@extends('landingpage.app')

@section('title', 'Tentang Kami - The Ethereal Clinic')

@section('content')
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

    <section class="w-full bg-[#FAFAFA] py-24">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-[#68575E] mb-4">Bertemu Dengan Tim Ahli Kami</h2>
                <p class="text-[#72544E] max-w-2xl mx-auto text-lg">Sistem kami didukung oleh keahlian para dokter spesialis kulit yang berdedikasi tinggi.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 text-center group">
                    <div class="w-40 h-40 mx-auto rounded-full overflow-hidden mb-6 border-4 border-[#FFEFF3] group-hover:scale-105 transition-transform duration-500">
                        <img src="https://images.unsplash.com/photo-1559839734-2b71ea197ec2?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80" alt="Dr. Sarah" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-xl font-bold text-[#68575E]">Dr. Sarah Wiratama, Sp.KK</h3>
                    <p class="text-[#8A3033] font-medium text-sm mt-1">Chief Dermatologist</p>
                    <p class="text-gray-500 text-sm mt-4 px-4">Spesialis dalam penanganan jerawat hormonal dan teknologi anti-aging.</p>
                </div>

                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 text-center group">
                    <div class="w-40 h-40 mx-auto rounded-full overflow-hidden mb-6 border-4 border-[#FFEFF3] group-hover:scale-105 transition-transform duration-500">
                        <img src="https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80" alt="Dr. Budi" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-xl font-bold text-[#68575E]">Dr. Andi Hakim, Sp.DV</h3>
                    <p class="text-[#8A3033] font-medium text-sm mt-1">Aesthetic Medical Doctor</p>
                    <p class="text-gray-500 text-sm mt-4 px-4">Berpengalaman lebih dari 10 tahun di bidang restorasi skin barrier.</p>
                </div>

                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 text-center group">
                    <div class="w-40 h-40 mx-auto rounded-full overflow-hidden mb-6 border-4 border-[#FFEFF3] group-hover:scale-105 transition-transform duration-500">
                        <img src="https://images.unsplash.com/photo-1594824432466-571221ab399b?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80" alt="Dr. Diana" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-xl font-bold text-[#68575E]">Dr. Diana Lestari, M.Biomed</h3>
                    <p class="text-[#8A3033] font-medium text-sm mt-1">Dermatology Researcher</p>
                    <p class="text-gray-500 text-sm mt-4 px-4">Pengawas algoritma medis untuk memastikan keakuratan AI klinik kami.</p>
                </div>
            </div>
        </div>
    </section>
@endsection