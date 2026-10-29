<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Autentikasi') - {{ config('app.name', 'BUBA') }}</title>

    <!-- Google / Bunny Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans antialiased text-gray-900 bg-[#eaf4fe] selection:bg-[#5ebef3] selection:text-white overflow-x-hidden">

    <div class="min-h-screen flex flex-col lg:flex-row w-full relative">

        <!-- ========================================================
             SISI KIRI: Visual Branding & Hero Ilustrasi Interaktif
             ======================================================== -->
        <div class="relative w-full lg:w-[52%] xl:w-[55%] min-h-[380px] sm:min-h-[440px] lg:min-h-screen flex flex-col justify-between p-6 sm:p-10 lg:p-12 xl:p-14 bg-cover bg-center bg-no-repeat overflow-hidden select-none"
             style="background-image: url('{{ asset('images/backgroundAuth.jpg') }}');">

            <!-- Overlay Halus untuk Kontras Estetis -->
            <div class="absolute inset-0 bg-gradient-to-t from-black/45 via-black/10 to-transparent pointer-events-none"></div>

            <!-- Awan Animasi Tambahan di Lapisan Langit -->
            <div class="pointer-events-none absolute inset-0 overflow-hidden z-0">
                <!-- Awan Mengambang 1 -->
                <div class="absolute top-[12%] left-[10%] opacity-80 animate-buba-cloud-1 hidden sm:block">
                    <svg class="w-24 sm:w-32 h-auto text-white/90 drop-shadow-md" viewBox="0 0 100 60" fill="currentColor">
                        <path d="M20 50 C10 50 2 42 2 32 C2 24 8 18 16 16 C19 8 28 2 38 2 C49 2 58 8 62 18 C66 16 70 16 74 18 C83 19 90 26 90 35 C90 43 83 50 74 50 Z" />
                    </svg>
                </div>
                <!-- Awan Mengambang 2 -->
                <div class="absolute top-[28%] right-[14%] opacity-75 animate-buba-cloud-2 hidden md:block">
                    <svg class="w-28 sm:w-36 h-auto text-white/85 drop-shadow-md" viewBox="0 0 100 60" fill="currentColor">
                        <path d="M20 50 C10 50 2 42 2 32 C2 24 8 18 16 16 C19 8 28 2 38 2 C49 2 58 8 62 18 C66 16 70 16 74 18 C83 19 90 26 90 35 C90 43 83 50 74 50 Z" />
                    </svg>
                </div>
            </div>

            <!-- Header Visual: Tombol Kembali & Logo BUBA -->
            <div class="relative z-10 flex items-center justify-between gap-4">
                <!-- Tombol Kembali ke Splash/Beranda (Konsisten dengan view Siswa) -->
                {{-- <a href="{{ url('/') }}"
                   class="group flex h-11 w-11 sm:h-12 sm:w-12 items-center justify-center rounded-full border-[3.5px] border-white bg-[#5ebef3] text-white shadow-[0_6px_14px_rgba(0,0,0,0.18)] transition-all duration-200 hover:scale-110 hover:bg-[#47ade7] hover:shadow-xl active:scale-95 focus:outline-none focus:ring-4 focus:ring-white/70"
                   aria-label="Kembali ke Beranda"
                   title="Kembali ke Beranda">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                         class="h-5 w-5 sm:h-6 sm:w-6 text-white drop-shadow transition-transform duration-200 group-hover:-translate-x-0.5">
                        <path d="M16 5.5a1 1 0 0 0-1.6-.8l-9 7a1 1 0 0 0 0 1.6l9 7A1 1 0 0 0 16 19.5V5.5z" />
                    </svg>
                </a> --}}

                <!-- Logo BUBA Beranimasi Mengambang -->
                <a href="{{ url('/login') }}" class="inline-block transition-transform hover:scale-105 duration-300 animate-buba-float">
                    <img src="{{ asset('images/logoBuba.png') }}" alt="Logo BUBA"
                         class="w-32 sm:w-40 md:w-48 h-auto object-contain drop-shadow-[0_8px_16px_rgba(0,0,0,0.25)]">
                </a>
            </div>

            <!-- Floating Badges Interaktif (Siswa Style) - Tampak di Desktop -->
            <div class="relative z-10 hidden lg:flex flex-col gap-3 my-auto max-w-sm">
                <!-- Badge 1: Kuis Interaktif -->
                <div class="inline-flex items-center gap-2.5 px-4 py-2 rounded-2xl bg-[#faa63a] border-[3px] border-white text-white font-extrabold text-sm shadow-[0_8px_18px_rgba(250,166,58,0.35)] w-fit animate-buba-float-slow hover:scale-105 transition-transform duration-200">
                    <span class="text-lg">⭐</span>
                    <span>Kuis Seru &amp; Berhadiah Bintang</span>
                </div>

                <!-- Badge 2: Materi Menyenangkan -->
                <div class="inline-flex items-center gap-2.5 px-4 py-2 rounded-2xl bg-[#71bf4f] border-[3px] border-white text-white font-extrabold text-sm shadow-[0_8px_18px_rgba(113,191,79,0.35)] w-fit ml-6 animate-buba-wiggle hover:scale-105 transition-transform duration-200">
                    <span class="text-lg">📚</span>
                    <span>Materi Interaktif PAUD &amp; TK</span>
                </div>

                <!-- Badge 3: Sahabat Tumbuh Kembang -->
                <div class="inline-flex items-center gap-2.5 px-4 py-2 rounded-2xl bg-[#d8759c] border-[3px] border-white text-white font-extrabold text-sm shadow-[0_8px_18px_rgba(216,117,156,0.35)] w-fit animate-buba-float hover:scale-105 transition-transform duration-200">
                    <span class="text-lg">🎨</span>
                    <span>Bermain Sambil Belajar</span>
                </div>
            </div>

            <!-- Teks Hero Branding di Bagian Bawah Kiri -->
            <div class="relative z-10 mt-8 lg:mt-auto">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/20 backdrop-blur-md border border-white/40 text-white text-[11px] sm:text-xs font-black uppercase tracking-wider mb-2.5 shadow-xs">
                    <span class="animate-pulse">✨</span>
                    <span>Aplikasi Pembelajaran Anak Usia Dini</span>
                </div>

                <h1 class="text-2xl sm:text-4xl lg:text-5xl font-black text-white uppercase tracking-wider leading-tight drop-shadow-[0_3px_6px_rgba(0,0,0,0.55)]">
                    BELAJAR, BERMAIN,<br>
                    <span class="text-[#ffd629] drop-shadow-[0_3px_6px_rgba(0,0,0,0.65)]">BERKEMBANG!</span>
                </h1>

                <p class="text-white/95 text-xs sm:text-sm md:text-base font-semibold mt-2 sm:mt-3 max-w-lg leading-relaxed drop-shadow-[0_2px_4px_rgba(0,0,0,0.5)]">
                    Aplikasi interaktif yang dirancang khusus untuk memacu imajinasi, kecerdasan, dan keceriaan buah hati Anda.
                </p>
            </div>
        </div>

        <!-- ========================================================
             SISI KANAN: Form Autentikasi dengan Siswa Aesthetics
             ======================================================== -->
        <div class="w-full lg:w-[48%] xl:w-[45%] flex flex-col justify-center items-center p-4 sm:p-8 lg:p-10 xl:p-12 relative min-h-[480px] lg:min-h-screen bg-gradient-to-br from-[#ebf5ff] via-[#f7fbff] to-[#fffdf5] overflow-y-auto">

            <!-- Ornamen Blur Geometris Halus di Background Kanan -->
            <div class="pointer-events-none absolute -top-16 -right-16 w-64 h-64 bg-[#5ebef3]/20 rounded-full blur-3xl"></div>
            <div class="pointer-events-none absolute -bottom-16 -left-16 w-64 h-64 bg-[#ffd629]/25 rounded-full blur-3xl"></div>
            <div class="pointer-events-none absolute top-1/2 -right-10 w-48 h-48 bg-[#d8759c]/15 rounded-full blur-2xl"></div>

            <!-- Kartu Kontainer Utama Form Autentikasi -->
            <div class="w-full max-w-[420px] relative z-10 animate-buba-pop">
                @yield('content')
            </div>

            <!-- Footer Hak Cipta Ringkas -->
            <div class="relative z-10 mt-6 text-center text-xs font-semibold text-slate-400">
                &copy; {{ date('Y') }} BUBA. Seluruh hak cipta dilindungi.
            </div>
        </div>
    </div>

    <!-- Script Global untuk Autentikasi (Password Toggle, dsb) -->
    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (!input || !icon) return;

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>

    @stack('scripts')
</body>
</html>
