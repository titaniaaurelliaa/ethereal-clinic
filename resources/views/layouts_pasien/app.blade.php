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

</body>
</html>