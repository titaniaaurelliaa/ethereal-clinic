<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'The Ethereal Clinic')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- SweetAlert2 CSS dan JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #E1E3DE;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #B0B3AE;
        }
    </style>
</head>

<body class="bg-[#FFF7F6] min-h-screen m-0 p-0 overflow-x-hidden">

    <div class="w-full min-h-screen flex flex-col md:flex-row">

        @include('layouts_admin.sidebar')

        <div id="adminContent" class="flex-1 flex flex-col transition-all duration-300">

            @include('layouts_admin.app-navbar')

            <main class="flex-1 overflow-y-auto bg-white/50 px-4 py-6 md:px-6 md:py-8 relative">
                @yield('content')
            </main>

        </div>

    </div>

    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 2000,
            showConfirmButton: false,
            background: 'white',
            iconColor: '#22C55E'
        });
    </script>
    @endif

    @if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session('error') }}',
            timer: 2000,
            showConfirmButton: false,
            background: 'white'
        });
    </script>
    @endif

</body>

</html>