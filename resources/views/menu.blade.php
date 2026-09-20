<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Menu Navigasi dengan Link - Tailwind</title>

    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'Segoe UI', 'system-ui', 'sans-serif'],
                    },
                },
            },
        };
    </script>
</head>

<body
    class="min-h-screen bg-gradient-to-br from-slate-100 via-slate-50 to-blue-100 flex items-center justify-center p-4 sm:p-6">

    <!-- Kartu Menu -->
    <main
        class="w-full max-w-3xl bg-white/70 backdrop-blur-xl border border-white/60 rounded-[2.5rem] shadow-2xl shadow-slate-400/30 p-6 sm:p-10">

        <!-- Judul -->
        <h1
            class="flex items-center justify-center gap-3 text-2xl sm:text-3xl font-bold text-slate-800 tracking-tight mb-8">
            <i class="fas fa-compass text-blue-700"></i>
            MENU ADMIN | BUBA DEVELOPMENT
        </h1>

        <!-- Grid Tombol (Link) -->
        <nav class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3 sm:gap-4">

            <!-- HOME → home.html -->
            <a href="{{ route('home') }}"
                class="menu-link group flex flex-col items-center justify-center gap-2 rounded-2xl px-4 py-5
                bg-white text-slate-800 font-semibold text-sm sm:text-base
                border border-white/70 shadow-md shadow-slate-300/40
                hover:-translate-y-1 hover:shadow-xl hover:shadow-blue-200/60
                active:translate-y-0 active:scale-95
                transition-all duration-300 ease-out">
                <i class="fas fa-home text-xl sm:text-2xl text-blue-600 group-hover:scale-110 transition-transform"></i>
                HOME
            </a>

            <a href="{{ route('kelas.index') }}"
                class="menu-link group flex flex-col items-center justify-center gap-2 rounded-2xl px-4 py-5
                bg-white text-slate-800 font-semibold text-sm sm:text-base
                border border-white/70 shadow-md shadow-slate-300/40
                hover:-translate-y-1 hover:shadow-xl hover:shadow-blue-200/60
                active:translate-y-0 active:scale-95
                transition-all duration-300 ease-out">
                <i class="fas fa-school text-xl sm:text-2xl text-blue-600 group-hover:scale-110 transition-transform"></i>
                KELAS
            </a>   

            <!-- KATEGORI → kategori.html -->
            <a href="{{ route('kategori.index') }}"
                class="menu-link group flex flex-col items-center justify-center gap-2 rounded-2xl px-4 py-5
                bg-white text-slate-800 font-semibold text-sm sm:text-base
                border border-white/70 shadow-md shadow-slate-300/40
                hover:-translate-y-1 hover:shadow-xl hover:shadow-emerald-200/60
                active:translate-y-0 active:scale-95
                transition-all duration-300 ease-out">
                <i
                    class="fas fa-layer-group text-xl sm:text-2xl text-emerald-600 group-hover:scale-110 transition-transform"></i>
                KATEGORI
            </a>

            <!-- MATERI → materi.html -->
            <a href="{{ route('materi.index') }}"
                class="menu-link group flex flex-col items-center justify-center gap-2 rounded-2xl px-4 py-5
                bg-white text-slate-800 font-semibold text-sm sm:text-base
                border border-white/70 shadow-md shadow-slate-300/40
                hover:-translate-y-1 hover:shadow-xl hover:shadow-amber-200/60
                active:translate-y-0 active:scale-95
                transition-all duration-300 ease-out">
                <i
                    class="fas fa-book-open text-xl sm:text-2xl text-amber-600 group-hover:scale-110 transition-transform"></i>
                MATERI
            </a>

            <!-- KUIS → kuis.html -->
            <a href="{{ route('kuis.index') }}"
                class="menu-link group flex flex-col items-center justify-center gap-2 rounded-2xl px-4 py-5
                bg-white text-slate-800 font-semibold text-sm sm:text-base
                border border-white/70 shadow-md shadow-slate-300/40
                hover:-translate-y-1 hover:shadow-xl hover:shadow-pink-200/60
                active:translate-y-0 active:scale-95
                transition-all duration-300 ease-out">
                <i
                    class="fas fa-question-circle text-xl sm:text-2xl text-pink-600 group-hover:scale-110 transition-transform"></i>
                KUIS
            </a>

            <!-- SISWA → siswa.html -->
            <a href="{{ route('siswa.index') }}"
                class="menu-link group flex flex-col items-center justify-center gap-2 rounded-2xl px-4 py-5
                bg-white text-slate-800 font-semibold text-sm sm:text-base
                border border-white/70 shadow-md shadow-slate-300/40
                hover:-translate-y-1 hover:shadow-xl hover:shadow-violet-200/60
                active:translate-y-0 active:scale-95
                transition-all duration-300 ease-out
                col-span-2 sm:col-span-1">
                <i
                    class="fas fa-users text-xl sm:text-2xl text-violet-600 group-hover:scale-110 transition-transform"></i>
                SISWA
            </a>

        </nav>

        <!-- Panel Info (opsional, bisa dihapus kalau sudah pakai link) -->
        <p class="mt-8 text-center text-sm text-slate-500">
            Klik salah satu menu untuk berpindah halaman.
        </p>

    </main>

</body>

</html>
