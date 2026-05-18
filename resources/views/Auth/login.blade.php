<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - The Ethereal Clinic</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        /* Animasi masuk agar smooth */
        .fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="bg-[#FFEFF3] min-h-screen flex items-center justify-center p-4">

    <div class="fade-in-up bg-white w-full max-w-5xl min-h-[600px] rounded-[40px] shadow-2xl overflow-hidden flex flex-col md:flex-row">
        
        <div class="w-full md:w-1/2 p-8 lg:p-16 flex flex-col justify-center">
            
            <div class="mb-8">
                <a href="/" class="group inline-flex items-center text-sm font-bold text-[#8A3033] transition-all hover:opacity-80">
                    <span class="mr-2 transition-transform group-hover:-translate-x-1">←</span>
                    Kembali
                </a>
            </div>

            <div class="mb-10">
                <h1 class="text-xl font-extrabold text-[#8A3033] tracking-tight">The Ethereal Clinic</h1>
                <h2 class="text-3xl font-bold text-[#68575E] mt-6 tracking-tight">Selamat Datang</h2>
                <p class="text-[#72544E] mt-2 opacity-80">Silakan masuk untuk melanjutkan konsultasi kulit Anda.</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-600 text-sm">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-200 text-green-600 text-sm font-medium">
                    {{ session('success') }}
                </div>
            @endif
            <form action="{{ route('login.post') }}" method="POST" class="space-y-6">
                @csrf
                <div class="group">
                    <label class="block text-sm font-bold text-[#68575E] mb-2 ml-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required
                        class="w-full px-5 py-4 rounded-2xl bg-[#FFEFF3] border-2 border-transparent focus:border-[#CAA59C] focus:bg-white text-[#68575E] outline-none transition-all duration-300 shadow-sm">
                </div>

                <div class="group">
                    <div class="flex justify-between mb-2 px-1">
                        <label class="block text-sm font-bold text-[#68575E]">Password</label>
                        <a href="#" class="text-xs text-[#8A3033] font-bold hover:underline underline-offset-4">Lupa Password?</a>
                    </div>
                    <div class="relative">
                        <input type="password" id="login-password" name="password" placeholder="••••••••" required
                            class="w-full px-5 py-4 rounded-2xl bg-[#FFEFF3] border-2 border-transparent focus:border-[#CAA59C] focus:bg-white text-[#68575E] outline-none transition-all duration-300 shadow-sm pr-12">
                        
                        <button type="button" onclick="togglePassword('login-password')" class="absolute inset-y-0 right-0 pr-4 flex items-center text-[#68575E] hover:text-[#8A3033] transition-colors">
                            <svg id="eye-login-password" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg id="eye-off-login-password" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                            </svg>
                        </button>
                    </div>
                </div>

                <button type="submit" 
                    class="w-full py-4 bg-gradient-to-r from-[#7B5556] to-[#EFBDBD] 
                    text-white font-bold rounded-2xl shadow-lg shadow-[#7B5556]/20
                    hover:scale-[1.02] hover:shadow-xl active:scale-[0.98] 
                    transition-all duration-300 uppercase tracking-wider text-sm">
                    Masuk Sekarang
                </button>
            </form>

            <p class="mt-8 text-center text-sm text-[#72544E] font-medium">
                Belum punya akun? 
                <a href="/register" class="text-[#8A3033] font-extrabold hover:underline decoration-2 underline-offset-4">Daftar Gratis</a>
            </p>
        </div>

        <div class="hidden md:block w-1/2 relative group">
            <img src="https://images.unsplash.com/photo-1598440947619-2c35fc9aa908?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" 
                alt="Login Skincare HD" 
                class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
            
            <div class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-[#68575E]/80"></div>
            
            <div class="absolute bottom-12 left-12 right-12 text-white">
                <div class="w-12 h-1 bg-[#EFBDBD] mb-6 rounded-full"></div>
                <p class="text-2xl font-bold leading-tight tracking-tight italic opacity-95">
                    "Kulit yang sehat adalah investasi terbaik untuk masa depan."
                </p>
                <p class="mt-4 text-sm font-medium opacity-80 uppercase tracking-[0.2em]">The Ethereal Clinic</p>
            </div>
        </div>

    </div>

    <script>
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const eye = document.getElementById('eye-' + inputId);
            const eyeOff = document.getElementById('eye-off-' + inputId);

            if (input.type === 'password') {
                input.type = 'text';
                eye.classList.add('hidden');
                eyeOff.classList.remove('hidden');
            } else {
                input.type = 'password';
                eye.classList.remove('hidden');
                eyeOff.classList.add('hidden');
            }
        }
    </script>
</body>
</html>