<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'The Ethereal Clinic')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #E1E3DE; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #B0B3AE; }
    </style>
</head>
<body class="bg-[#FFF7F6] min-h-screen m-0 p-0 overflow-x-hidden">

    <div class="w-full min-h-screen flex flex-col md:flex-row">

        @include('layouts_pasien.sidebar')

        <div class="flex-1 flex flex-col">
            
            @include('layouts_pasien.navbar')

            <main class="flex-1 overflow-y-auto bg-white/50 relative flex justify-center">
                <div class="w-full max-w-6xl p-4 md:p-6 lg:p-10">
                    @yield('content')
                </div>
            </main>

        </div>

    </div>

    @if (session('success'))
        <div id="toast-success" class="fixed top-10 right-10 z-[100] flex items-center w-full max-w-sm p-5 text-[#2A3435] bg-white/95 backdrop-blur-xl rounded-[24px] shadow-[0_20px_50px_rgba(0,0,0,0.1)] border border-white transform transition-all duration-500 translate-x-[120%] opacity-0" role="alert">
            <div class="inline-flex items-center justify-center flex-shrink-0 w-12 h-12 bg-gradient-to-br from-[#0A6879]/20 to-[#134E4A]/10 rounded-2xl text-[#0A6879] shadow-inner">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <div class="ml-4 mr-2">
                <h4 class="text-sm font-extrabold tracking-wide text-[#2A3435] mb-0.5">Berhasil!</h4>
                <p class="text-xs font-medium text-[#797B78]">{{ session('success') }}</p>
            </div>
            <button type="button" onclick="closeToast()" class="ml-auto bg-transparent text-[#A9B4B5] hover:text-red-500 rounded-xl p-1.5 hover:bg-red-50 transition-colors focus:outline-none">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const toast = document.getElementById('toast-success');
                if (toast) {
                    // Animasi Masuk (Slide in dari kanan) setelah halaman dimuat
                    setTimeout(() => {
                        toast.classList.remove('translate-x-[120%]', 'opacity-0');
                    }, 100);

                    // Auto close setelah 4.5 detik
                    setTimeout(() => {
                        closeToast();
                    }, 4500);
                }
            });

            function closeToast() {
                const toast = document.getElementById('toast-success');
                if (toast) {
                    // Animasi Keluar (Geser kembali ke kanan)
                    toast.classList.add('translate-x-[120%]', 'opacity-0');
                    setTimeout(() => {
                        toast.remove();
                    }, 500); // Hapus elemen dari DOM setelah animasi selesai
                }
            }
        </script>
    @endif

@stack('scripts')
</body>
</html>