<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full overflow-x-hidden">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Autentikasi') - {{ config('app.name', 'BUBA') }}</title>
    @include('layouts.partials.favicon')

    <!-- Google / Bunny Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="h-full font-sans antialiased text-gray-900 bg-[#eaf4fe] selection:bg-[#5ebef3] selection:text-white overflow-x-hidden">

    <div class="min-h-screen flex flex-col lg:flex-row w-full relative">

        <!-- ========================================================
             SISI KIRI: Visual Branding & Hero Ilustrasi Interaktif
             ======================================================== -->
        <div class="relative w-full lg:w-[52%] xl:w-[55%] min-h-[380px] sm:min-h-[440px] lg:min-h-screen flex flex-col justify-between p-6 sm:p-10 lg:p-12 xl:p-14 bg-cover bg-center bg-no-repeat overflow-hidden select-none"
            style="background-image: url('{{ asset('images/backgroundAuth.jpg') }}');">

            <!-- Overlay Halus untuk Kontras Estetis -->
            <div
                class="absolute inset-0 bg-gradient-to-t from-black/45 via-black/10 to-transparent pointer-events-none">
            </div>

            <!-- Awan Animasi Tambahan di Lapisan Langit -->
            <div class="pointer-events-none absolute inset-0 overflow-hidden z-0">
                <!-- Awan Mengambang 1 -->
                <div class="absolute top-[12%] left-[10%] opacity-80 animate-buba-cloud-1 hidden sm:block">
                    <svg class="w-24 sm:w-32 h-auto text-white/90 drop-shadow-md" viewBox="0 0 100 60"
                        fill="currentColor">
                        <path
                            d="M20 50 C10 50 2 42 2 32 C2 24 8 18 16 16 C19 8 28 2 38 2 C49 2 58 8 62 18 C66 16 70 16 74 18 C83 19 90 26 90 35 C90 43 83 50 74 50 Z" />
                    </svg>
                </div>
                <!-- Awan Mengambang 2 -->
                <div class="absolute top-[28%] right-[14%] opacity-75 animate-buba-cloud-2 hidden md:block">
                    <svg class="w-28 sm:w-36 h-auto text-white/85 drop-shadow-md" viewBox="0 0 100 60"
                        fill="currentColor">
                        <path
                            d="M20 50 C10 50 2 42 2 32 C2 24 8 18 16 16 C19 8 28 2 38 2 C49 2 58 8 62 18 C66 16 70 16 74 18 C83 19 90 26 90 35 C90 43 83 50 74 50 Z" />
                    </svg>
                </div>
            </div>

            <!-- Header Visual: Tombol Kembali & Logo BUBA -->
            <div class="relative z-10 flex items-center justify-between gap-4">
                <!-- Tombol Kembali ke Splash/Beranda (Konsisten dengan view Siswa) -->
                <a href="{{ url('/') }}"
                    class="group flex h-16 w-16 sm:h-20 sm:w-20 items-center justify-center rounded-full border-[3.5px] border-white bg-[#5ebef3] text-white shadow-[0_6px_14px_rgba(0,0,0,0.18)] transition-all duration-200 hover:scale-110 hover:bg-[#47ade7] hover:shadow-xl active:scale-95 focus:outline-none focus:ring-4 focus:ring-white/70"
                    aria-label="Kembali ke Beranda" title="Kembali ke Beranda">
                    <svg xmlns="http://www.w3.org/2000/svg" height="50" width="50"
                        viewBox="0 0 640 640"><!--!Font Awesome Free v7.3.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2026 Fonticons, Inc.-->
                        <path fill="rgb(255, 255, 255)"
                            d="M341.8 72.6C329.5 61.2 310.5 61.2 298.3 72.6L74.3 280.6C64.7 289.6 61.5 303.5 66.3 315.7C71.1 327.9 82.8 336 96 336L112 336L112 512C112 547.3 140.7 576 176 576L464 576C499.3 576 528 547.3 528 512L528 336L544 336C557.2 336 569 327.9 573.8 315.7C578.6 303.5 575.4 289.5 565.8 280.6L341.8 72.6zM304 384L336 384C362.5 384 384 405.5 384 432L384 528L256 528L256 432C256 405.5 277.5 384 304 384z" />
                    </svg>
                </a>

                <!-- Logo BUBA Beranimasi Mengambang -->
                <a href="{{ url('/login') }}"
                    class="inline-block transition-transform hover:scale-105 duration-300 animate-buba-float">
                    <img src="{{ asset('images/logoBuba.png') }}" alt="Logo BUBA"
                        class="w-32 sm:w-40 md:w-48 h-auto object-contain drop-shadow-[0_8px_16px_rgba(0,0,0,0.25)]">
                </a>
            </div>

            <!-- Floating Badges Interaktif (Siswa Style) - Tampak di Desktop -->
            <div class="relative z-10 hidden lg:flex flex-col gap-3 my-auto max-w-sm">
                <!-- Badge 1: Kuis Interaktif -->
                <div
                    class="inline-flex items-center gap-2.5 px-4 py-2 rounded-2xl bg-[#faa63a] border-[3px] border-white text-white font-extrabold text-sm shadow-[0_8px_18px_rgba(250,166,58,0.35)] w-fit animate-buba-float-slow hover:scale-105 transition-transform duration-200">
                    <span class="text-lg">⭐</span>
                    <span>Kuis Seru &amp; Berhadiah Bintang</span>
                </div>

                <!-- Badge 2: Materi Menyenangkan -->
                <div
                    class="inline-flex items-center gap-2.5 px-4 py-2 rounded-2xl bg-[#71bf4f] border-[3px] border-white text-white font-extrabold text-sm shadow-[0_8px_18px_rgba(113,191,79,0.35)] w-fit ml-6 animate-buba-wiggle hover:scale-105 transition-transform duration-200">
                    <span class="text-lg">📚</span>
                    <span>Materi Interaktif PAUD &amp; TK</span>
                </div>

                <!-- Badge 3: Sahabat Tumbuh Kembang -->
                <div
                    class="inline-flex items-center gap-2.5 px-4 py-2 rounded-2xl bg-[#d8759c] border-[3px] border-white text-white font-extrabold text-sm shadow-[0_8px_18px_rgba(216,117,156,0.35)] w-fit animate-buba-float hover:scale-105 transition-transform duration-200">
                    <span class="text-lg">🎨</span>
                    <span>Bermain Sambil Belajar</span>
                </div>
            </div>

            <!-- Teks Hero Branding di Bagian Bawah Kiri -->
            <div class="relative z-10 mt-8 lg:mt-auto">
                <div
                    class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/20 backdrop-blur-md border border-white/40 text-white text-[11px] sm:text-xs font-black uppercase tracking-wider mb-2.5 shadow-xs">
                    <span class="animate-pulse">✨</span>
                    <span>Aplikasi Pembelajaran Anak Usia Dini</span>
                </div>

                <h1
                    class="text-2xl sm:text-4xl lg:text-5xl font-black text-white uppercase tracking-wider leading-tight drop-shadow-[0_3px_6px_rgba(0,0,0,0.55)]">
                    BELAJAR, BERMAIN,<br>
                    <span class="text-[#ffd629] drop-shadow-[0_3px_6px_rgba(0,0,0,0.65)]">BERKEMBANG!</span>
                </h1>

                <p
                    class="text-white/95 text-xs sm:text-sm md:text-base font-semibold mt-2 sm:mt-3 max-w-lg leading-relaxed drop-shadow-[0_2px_4px_rgba(0,0,0,0.5)]">
                    Aplikasi interaktif yang dirancang khusus untuk memacu imajinasi, kecerdasan, dan keceriaan buah
                    hati Anda.
                </p>
            </div>
        </div>

        <!-- ========================================================
             SISI KANAN: Form Autentikasi dengan Siswa Aesthetics
             ======================================================== -->
        <div
            class="w-full lg:w-[48%] xl:w-[45%] flex flex-col justify-center items-center p-4 sm:p-8 lg:p-10 xl:p-12 relative min-h-[480px] lg:min-h-screen bg-gradient-to-br from-[#ebf5ff] via-[#f7fbff] to-[#fffdf5] overflow-y-auto overflow-x-hidden">

            <!-- Ornamen Blur Geometris Halus di Background Kanan
                 Dibungkus overflow-hidden agar tidak memicu scroll horizontal -->
            <div class="pointer-events-none absolute inset-0 overflow-hidden" aria-hidden="true">
                <div class="absolute -top-16 -right-16 w-64 h-64 bg-[#5ebef3]/20 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-16 -left-16 w-64 h-64 bg-[#ffd629]/25 rounded-full blur-3xl"></div>
                <div class="absolute top-1/2 -right-10 w-48 h-48 bg-[#d8759c]/15 rounded-full blur-2xl"></div>
            </div>

            <!-- Kartu Kontainer Utama Form Autentikasi -->
            <div class="w-full max-w-[420px] mx-auto relative z-10 animate-buba-pop">
                @yield('content')
            </div>

            <!-- Footer Hak Cipta Ringkas -->
            <div class="relative z-10 mt-6 text-center text-xs font-semibold text-slate-400">
                <p class="italic">BUBA E-Learning Application | version 1.0</p>
                <p class="font-bold">&copy; {{ date('Y') }} NAJATIF. All Right Reserved.</p>
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
