@extends('landingpage.app')

@section('title', 'Beranda - The Ethereal Clinic')

@section('content')

    <div class="bg-[#FFEFF3] w-full">
        <main id="beranda" class="max-w-7xl mx-auto px-6 lg:px-16 py-10 lg:py-16">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                
                <div class="max-w-xl z-10">
                    <div class="inline-flex items-center px-4 py-1.5 rounded-full bg-[#FAE2EA] text-[#68575E] text-xs font-bold tracking-wider mb-6">
                        CERTAINTY FACTOR POWERED
                    </div>

                    <h1 class="text-5xl lg:text-[64px] font-extrabold text-[#72544E] leading-[1.1] tracking-tight mb-6">
                        Pahami Kulitmu, <br>
                        Temukan <br>
                        Solusinya
                    </h1>
                    
                    <p class="text-lg text-[#68575E] leading-relaxed mb-10 max-w-md">
                        Sistem pakar kami menggunakan algoritma Certainty Factor untuk memberikan akurasi diagnosis kesehatan kulit yang terpercaya, layaknya berkonsultasi langsung dengan ahli dermatologi.
                    </p>

                </div>

                <div class="relative w-full flex justify-end">
                    <div class="relative w-[90%] md:w-[85%] lg:w-[480px]">
                        
                        <img 
                            src="{{ asset('assets/img/banner.jpeg') }}" 
                            alt="Skincare Products" 
                            class="w-full h-auto object-cover rounded-[40px] shadow-2xl"
                        >

                    </div>
                </div>

            </div>
        </main>
    </div>

    <section id="layanan" class="w-full bg-[#FFEDE9] py-20 lg:py-28 px-6 lg:px-16">
        <div class="max-w-7xl mx-auto">
            
            <div class="text-center max-w-2xl mx-auto mb-16 md:mb-20">
                <h2 class="text-3xl md:text-[40px] font-bold text-[#68575E] tracking-tight mb-6">
                    Cara Kerja Sistem
                </h2>
                <p class="text-base md:text-lg text-[#72544E] leading-relaxed opacity-90">
                    Proses diagnosa cerdas yang dirancang untuk memberikan hasil yang personal dan akurat.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-10">
                
                <div class="bg-white rounded-[32px] p-8 lg:p-10 shadow-[0_15px_50px_rgba(104,87,94,0.06)] hover:-translate-y-2 transition-transform duration-300">
                    <div class="w-16 h-16 rounded-2xl bg-[#FAE2EA] flex items-center justify-center text-[#68575E] mb-8">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-[#68575E] mb-4">Scan</h3>
                    <p class="text-[#72544E] leading-relaxed opacity-80 text-sm md:text-base">
                        Ambil foto area kulit atau jawab beberapa pertanyaan mendalam mengenai kondisi kulit Anda saat ini.
                    </p>
                </div>

                <div class="bg-white rounded-[32px] p-8 lg:p-10 shadow-[0_15px_50px_rgba(104,87,94,0.06)] hover:-translate-y-2 transition-transform duration-300">
                    <div class="w-16 h-16 rounded-2xl bg-[#FAE2EA] flex items-center justify-center text-[#68575E] mb-8">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-[#68575E] mb-4">Validasi</h3>
                    <p class="text-[#72544E] leading-relaxed opacity-80 text-sm md:text-base">
                        Sistem melakukan kalkulasi Certainty Factor berdasarkan basis pengetahuan pakar dermatologi kelas dunia.
                    </p>
                </div>

                <div class="bg-white rounded-[32px] p-8 lg:p-10 shadow-[0_15px_50px_rgba(104,87,94,0.06)] hover:-translate-y-2 transition-transform duration-300">
                    <div class="w-16 h-16 rounded-2xl bg-[#FAE2EA] flex items-center justify-center text-[#68575E] mb-8">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-[#68575E] mb-4">Diagnosa</h3>
                    <p class="text-[#72544E] leading-relaxed opacity-80 text-sm md:text-base">
                        Dapatkan laporan detail mengenai kondisi kulit Anda beserta rekomendasi produk dan penanganan yang tepat.
                    </p>
                </div>

            </div>
        </div>
    </section>

    <div class="bg-[#FFEFF3] w-full pb-20">
        <section id="tentang" class="max-w-7xl mx-auto px-6 lg:px-16 py-20 lg:py-28">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-24 items-center">
                
                <div class="relative w-full max-w-md mx-auto lg:mx-0 h-[380px] sm:h-[450px]">
                    <img 
                        src="{{ asset('assets/img/land1.jpg') }}" 
                        alt="Skincare Cream" 
                        class="absolute top-0 right-0 w-[65%] h-[75%] object-cover rounded-[40px] shadow-lg"
                    >
                    <img 
                        src="{{ asset('assets/img/land2.avif') }}" 
                        alt="Skincare Serum" 
                        class="absolute bottom-0 left-0 w-[65%] h-[75%] object-cover rounded-[40px] shadow-2xl border-8 border-[#FFEFF3]"
                    >
                </div>

                <div>
                    <h2 class="text-3xl lg:text-4xl font-extrabold text-[#68575E] tracking-tight mb-10">
                        Mengapa Memilih Kami?
                    </h2>

                    <div class="space-y-8">
                        <div class="flex gap-5">
                            <div class="flex-shrink-0 w-12 h-12 rounded-full bg-[#FFE2DB] flex items-center justify-center text-[#68575E]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.042 21.672L13.684 16.6m0 0l-2.51 2.225.569-9.47 5.227 7.917-3.286-.672zm-7.518-.267A8.25 8.25 0 1120.25 10.5M8.288 14.212A5.25 5.25 0 1117.25 10.5" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-[#68575E] mb-1.5">Akurasi Berstandar Medis</h4>
                                <p class="text-[#72544E] text-sm leading-relaxed">
                                    Algoritma Certainty Factor kami meminimalisir ketidakpastian dalam diagnosa mandiri.
                                </p>
                            </div>
                        </div>

                        <div class="flex gap-5">
                            <div class="flex-shrink-0 w-12 h-12 rounded-full bg-[#FFE2DB] flex items-center justify-center text-[#68575E]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-[#68575E] mb-1.5">Cepat & Real-time</h4>
                                <p class="text-[#72544E] text-sm leading-relaxed">
                                    Dapatkan hasil diagnosa hanya dalam hitungan detik tanpa perlu mengantre di klinik.
                                </p>
                            </div>
                        </div>

                        <div class="flex gap-5">
                            <div class="flex-shrink-0 w-12 h-12 rounded-full bg-[#FFE2DB] flex items-center justify-center text-[#68575E]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-[#68575E] mb-1.5">Rekomendasi Terpercaya</h4>
                                <p class="text-[#72544E] text-sm leading-relaxed">
                                    Saran produk yang netral dan berbasis pada kebutuhan molekuler kulit Anda.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-24 lg:mt-32 w-full bg-[#68575E] rounded-[40px] px-6 py-16 md:py-24 text-center shadow-2xl relative overflow-hidden">
                <div class="absolute top-0 left-1/2 -translate-x-1/2 w-96 h-96 bg-white/10 rounded-full blur-3xl -z-0"></div>
                <div class="relative z-10 max-w-2xl mx-auto">
                    <h2 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-white tracking-tight mb-6 leading-tight">
                        Siap Mengenal Kulitmu Lebih Dalam?
                    </h2>
                    <p class="text-[#E4E4CC] text-sm md:text-base leading-relaxed mb-10 max-w-lg mx-auto opacity-90">
                        Bergabunglah dengan ribuan pengguna yang telah menemukan rutinitas skincare yang tepat melalui sistem kami.
                    </p>
                    <a href="/login" class="inline-block px-10 py-4 rounded-full bg-[#FFEFF3] text-[#68575E] font-bold hover:bg-white hover:scale-105 transition-all shadow-lg">
                        Mulai Konsultasi Gratis
                    </a>
                </div>
            </div>
        </section>
    </div>

@endsection