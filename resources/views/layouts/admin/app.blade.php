<!DOCTYPE html>
<html lang="id" class="h-full bg-[#0f172a]">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Buba Dashboard</title>
    <script>
        // Terapkan state sidebar sebelum halaman dilukis agar tidak berkedip
        // (membuka lalu menyusut) setiap kali berpindah menu.
        (function () {
            try {
                var collapsed = localStorage.getItem('admin-sidebar-collapsed') === 'true';
                document.documentElement.classList.toggle('sidebar-collapsed', collapsed);
            } catch (error) {
                // localStorage bisa diblokir; gunakan sidebar terbuka.
            }
        })();
    </script>
    @include('layouts.partials.favicon')
    <!-- Tailwind CSS via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Font Awesome untuk ikon (opsional, jika tidak pakai SVG) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.4/css/dataTables.dataTables.min.css">
</head>

@php
    $realtimePage = match (true) {
        request()->routeIs('admin.dashboard') => 'dashboard',
        request()->routeIs('kelas.index') => 'kelas',
        request()->routeIs('kategori.index') => 'kategori',
        request()->routeIs('materi.index') => 'materi',
        request()->routeIs('kuis.index') => 'kuis',
        request()->routeIs('siswa.index') => 'siswa',
        request()->routeIs('reward.index') => 'reward',
        default => '',
    };
@endphp

<body class="h-full font-sans text-black overflow-hidden"
      data-realtime-page="{{ $realtimePage }}"
      data-realtime-role="{{ auth()->user()?->role }}"
      data-realtime-user-id="{{ auth()->id() }}">

    <div class="flex h-screen w-full bg-[white]"
         x-data="{
             sidebarCollapsed: document.documentElement.classList.contains('sidebar-collapsed'),
             init() {
                 this.$watch('sidebarCollapsed', (collapsed) => {
                     document.documentElement.classList.toggle('sidebar-collapsed', collapsed);
                     try {
                         localStorage.setItem('admin-sidebar-collapsed', String(collapsed));
                     } catch (error) {
                         // localStorage bisa diblokir; state tetap berlaku di halaman ini.
                     }
                 });
             }
         }">

        <!-- SIDEBAR -->
        @include('layouts.admin.sidebar')

        <!-- MAIN CONTENT WRAPPER -->
        <div class="flex-1 flex flex-col h-screen overflow-hidden relative">

            <!-- NAVBAR ATAS -->
            @include('layouts.admin.navbar')

            <!-- KONTEN UTAMA (Nanti diisi oleh halaman lain) -->
            <main class="flex-1 overflow-y-auto p-6 bg-[white]">
                @yield('content')
            </main>

        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.4/js/dataTables.min.js"></script>
    @stack('scripts')

</body>

</html>
