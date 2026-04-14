<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Ethereal Clinic</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#FFEFF3] min-h-screen"> 
   <nav class="w-full px-6 py-5 md:px-16 flex items-center justify-between bg-white shadow-sm">
        
        <div class="flex-shrink-0">
            <a href="/" class="text-xl md:text-2xl font-extrabold text-[#8A3033] tracking-tight">
                The Ethereal Clinic
            </a>
        </div>

        <div class="hidden md:flex items-center space-x-10 text-sm font-medium">
            <a href="#" class="text-gray-500 hover:text-[#8A3033] transition-colors">Beranda</a>
            <a href="#" class="text-gray-500 hover:text-[#8A3033] transition-colors">Layanan</a>
            <a href="#" class="text-gray-500 hover:text-[#8A3033] transition-colors">Tentang</a>
            <a href="#" class="text-gray-500 hover:text-[#8A3033] transition-colors">Kontak</a>
        </div>

        <div class="flex items-center space-x-5 text-[#68575E]">
            <button class="hover:text-[#8A3033] transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
            </button>
            <button class="hover:text-[#8A3033] transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </button>
            <button class="w-8 h-8 rounded-full overflow-hidden border border-[#8A3033] hover:scale-105 transition-transform shadow-sm">
                <img src="https://ui-avatars.com/api/?name=Ivan&background=8A3033&color=fff" alt="User Profile" class="w-full h-full object-cover">
            </button>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-6 lg:px-16 py-10 lg:py-16">
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

                <div class="flex flex-wrap items-center gap-4">
                    <a href="/konsultasi" class="px-8 py-3.5 rounded-full bg-[#68575E] text-white font-semibold hover:bg-[#52444a] transition-colors shadow-md">
                        Mulai Konsultasi
                    </a>
                    <a href="/login" class="px-10 py-3.5 rounded-full bg-transparent border-[1.5px] border-[#CAA59C] text-[#68575E] font-semibold hover:bg-[#FAE2EA] transition-colors">
                        Login
                    </a>
                </div>
            </div>

            <div class="relative w-full flex justify-end">
                <div class="relative w-[90%] md:w-[85%] lg:w-[480px]">
                    
                    <img 
                        src="https://images.unsplash.com/photo-1620916566398-39f1143ab7be?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                        alt="Skincare Products" 
                        class="w-full h-auto object-cover rounded-[40px] shadow-2xl"
                    >

                    <div class="absolute -bottom-8 -left-8 md:-left-12 bg-white/95 backdrop-blur-sm px-6 py-4 rounded-3xl shadow-[0_20px_50px_rgba(114,84,78,0.15)] flex items-center gap-4 border border-white">
                        <div class="w-10 h-10 rounded-full bg-[#e8eed2] flex items-center justify-center text-[#5B5D4A]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-[#333333] font-bold text-lg leading-tight">Akurasi 98%</p>
                            <p class="text-gray-500 text-xs font-medium">Hasil Validasi Pakar</p>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </main>
    <section class="w-full bg-[#FFEDE9] py-20 lg:py-28 px-6 lg:px-16">
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
    <section class="max-w-7xl mx-auto px-6 lg:px-16 py-20 lg:py-28">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-24 items-center">
            
            <div class="relative w-full max-w-md mx-auto lg:mx-0 h-[380px] sm:h-[450px]">
                <img 
                    src="https://images.unsplash.com/photo-1570194065650-d99fb4b8f7fa?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" 
                    alt="Skincare Cream" 
                    class="absolute top-0 right-0 w-[65%] h-[75%] object-cover rounded-[40px] shadow-lg"
                >
                <img 
                    src="https://images.unsplash.com/photo-1608248543803-ba4f8c70ae0b?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" 
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
                <a href="/konsultasi" class="inline-block px-10 py-4 rounded-full bg-[#FFEFF3] text-[#68575E] font-bold hover:bg-white hover:scale-105 transition-all shadow-lg">
                    Mulai Konsultasi Gratis
                </a>
            </div>
        </div>
    </section>

<footer class="bg-white pt-20 pb-10 px-6 lg:px-16 border-t border-[#FFE2DB]">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
            
            <div class="space-y-6">
                <h2 class="text-2xl font-extrabold text-[#72544E] tracking-tight">
                    The Ethereal Clinic
                </h2>
                <p class="text-[#68575E] text-sm leading-relaxed opacity-90">
                    Membawa keahlian dermatologi ke genggaman tangan Anda melalui teknologi kecerdasan buatan terdepan.
                </p>
              <div class="flex space-x-4">
             <a href="#" class="w-8 h-8 rounded-full bg-[#FFE2DB] flex items-center justify-center text-[#72544E] hover:opacity-80 transition-opacity">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
            </a>
    
            <a href="#" class="w-8 h-8 rounded-full bg-[#FFE2DB] flex items-center justify-center text-[#72544E] hover:opacity-80 transition-opacity">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"></path></svg>
            </a>
         </div>
            </div>

            <div>
                <h4 class="text-[#72544E] font-bold mb-6">Menu Utama</h4>
                <ul class="space-y-4 text-sm text-[#68575E]">
                    <li><a href="#" class="hover:text-[#72544E] transition-colors">Beranda</a></li>
                    <li><a href="#" class="hover:text-[#72544E] transition-colors">Proses Diagnosa</a></li>
                    <li><a href="#" class="hover:text-[#72544E] transition-colors">Keunggulan</a></li>
                    <li><a href="#" class="hover:text-[#72544E] transition-colors">Testimoni</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-[#72544E] font-bold mb-6">Tentang Kami</h4>
                <ul class="space-y-4 text-sm text-[#68575E]">
                    <li><a href="#" class="hover:text-[#72544E] transition-colors">Visi & Misi</a></li>
                    <li><a href="#" class="hover:text-[#72544E] transition-colors">Tim Ahli</a></li>
                    <li><a href="#" class="hover:text-[#72544E] transition-colors">Kebijakan Privasi</a></li>
                    <li><a href="#" class="hover:text-[#72544E] transition-colors">Syarat & Ketentuan</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-[#72544E] font-bold mb-6">Kontak</h4>
                <ul class="space-y-4 text-sm text-[#68575E]">
                    <li class="flex items-start gap-3">
                        <span class="text-[#72544E]">📍</span>
                        <span>Jl. Serenity No. 88, <br>Jakarta Selatan</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="text-[#72544E]">📞</span>
                        <span>+62 21 555 1234</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="text-[#72544E]">✉️</span>
                        <span>hello@etherealclinic.id</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="pt-8 border-t border-[#FFE2DB] flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-[#68575E]">
            <p>© 2026 The Ethereal Clinic. All rights reserved.</p>
            <div class="flex space-x-6">
                <a href="#" class="hover:text-[#72544E] transition-colors">Cookie Policy</a>
                <a href="#" class="hover:text-[#72544E] transition-colors">Legal Disclaimer</a>
            </div>
        </div>
    </div>
</footer>

</body>
</html>