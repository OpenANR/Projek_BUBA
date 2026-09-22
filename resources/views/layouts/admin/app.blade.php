<!DOCTYPE html>
<html lang="id" class="h-full bg-[#0f172a]">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buba Dashboard</title>
    <!-- Tailwind CSS via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Font Awesome untuk ikon (opsional, jika tidak pakai SVG) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="h-full font-sans text-slate-200 overflow-hidden">

    <div class="flex h-screen w-full bg-[#0f172a]">

        <!-- SIDEBAR -->
        @include('layouts.admin.sidebar')

        <!-- MAIN CONTENT WRAPPER -->
        <div class="flex-1 flex flex-col h-screen overflow-hidden relative">

            <!-- NAVBAR ATAS -->
            @include('layouts.admin.navbar')

            <!-- KONTEN UTAMA (Nanti diisi oleh halaman lain) -->
            <main class="flex-1 overflow-y-auto p-6 bg-[#0f172a]">
                @yield('content')
            </main>

        </div>
    </div>

</body>

</html>
