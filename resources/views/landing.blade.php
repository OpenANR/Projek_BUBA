@php
    // Ganti tanda '#' dengan tautan Play Store / App Store / file APK jika sudah tersedia.
    $androidUrl = '#';
    $iosUrl = '#';
    $webUrl = route('login');
@endphp

<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="BUBA adalah aplikasi e-learning interaktif untuk guru dan siswa. Belajar materi bergambar, kuis ber-audio, dan reward bintang dengan cara yang menyenangkan.">
    <meta name="theme-color" content="#1e60be">
    <title>BUBA - Belajar, Bermain, Berkembang</title>

    <link rel="icon" type="image/png" href="{{ asset('images/logoBuba.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@500;600;700;800&family=Nunito:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Nunito', system-ui, -apple-system, sans-serif;
        }

        .font-display {
            font-family: 'Baloo 2', 'Nunito', system-ui, sans-serif;
        }

        summary::-webkit-details-marker {
            display: none;
        }

        .bg-dotted {
            background-image: radial-gradient(rgba(30, 96, 190, 0.14) 1.5px, transparent 1.5px);
            background-size: 24px 24px;
        }

        .bg-dotted-light {
            background-image: radial-gradient(rgba(255, 255, 255, 0.16) 1.5px, transparent 1.5px);
            background-size: 26px 26px;
        }
    </style>
</head>

<body class="overflow-x-hidden bg-[#FFF9EF] text-slate-800 antialiased">

    <a href="#beranda"
        class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-[100] focus:rounded-full focus:bg-[#1e60be] focus:px-5 focus:py-3 focus:text-sm focus:font-bold focus:text-white">
        Lewati ke konten utama
    </a>

    {{-- =========================================================
         NAVBAR
    ========================================================== --}}
    <header x-data="{ open: false, scrolled: false }" @scroll.window="scrolled = window.scrollY > 24"
        class="fixed inset-x-0 top-0 z-50 px-3 sm:px-5">
        <nav :class="scrolled || open ? 'bg-white/95 shadow-xl shadow-blue-900/5' : 'bg-white/80 shadow-lg shadow-blue-900/5'"
            class="mx-auto mt-3 flex max-w-7xl items-center justify-between gap-3 rounded-2xl border border-white/80 px-3 py-2.5 backdrop-blur-xl transition-all duration-300 sm:px-5">

            {{-- Logo --}}
            <a href="#beranda" class="flex shrink-0 items-center gap-2 rounded-xl focus:outline-none focus-visible:ring-4 focus-visible:ring-sky-200"
                aria-label="BUBA - kembali ke beranda">
                <img src="{{ asset('images/logoBuba.png') }}" alt="Logo BUBA"
                    class="h-11 w-auto object-contain sm:h-14">
            </a>

            {{-- Menu desktop --}}
            <ul class="hidden items-center gap-1 lg:flex">
                <li><a href="#beranda"
                        class="rounded-full px-4 py-2 text-sm font-extrabold text-slate-600 transition hover:bg-sky-50 hover:text-[#1e60be]">Beranda</a>
                </li>
                <li><a href="#fitur"
                        class="rounded-full px-4 py-2 text-sm font-extrabold text-slate-600 transition hover:bg-sky-50 hover:text-[#1e60be]">Fitur</a>
                </li>
                <li><a href="#cara-kerja"
                        class="rounded-full px-4 py-2 text-sm font-extrabold text-slate-600 transition hover:bg-sky-50 hover:text-[#1e60be]">Cara
                        Kerja</a></li>
                <li><a href="#unduh"
                        class="rounded-full px-4 py-2 text-sm font-extrabold text-slate-600 transition hover:bg-sky-50 hover:text-[#1e60be]">Unduh</a>
                </li>
                <li><a href="#faq"
                        class="rounded-full px-4 py-2 text-sm font-extrabold text-slate-600 transition hover:bg-sky-50 hover:text-[#1e60be]">FAQ</a>
                </li>
            </ul>

            {{-- Aksi desktop --}}
            <div class="hidden items-center gap-2 sm:flex">
                <a href="{{ $webUrl }}"
                    class="hidden items-center gap-2 rounded-full px-4 py-2.5 text-sm font-extrabold text-[#1e60be] transition hover:bg-sky-50 md:inline-flex">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2.2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                    </svg>
                    Masuk
                </a>
                <a href="#unduh"
                    class="group inline-flex items-center gap-2 rounded-full border-2 border-white bg-[#1e60be] px-5 py-2.5 text-sm font-extrabold text-white shadow-[0_5px_0_#154a94] transition-all duration-200 hover:-translate-y-0.5 hover:bg-[#2b73d1] hover:shadow-[0_7px_0_#154a94] active:translate-y-1 active:shadow-[0_2px_0_#154a94]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2.4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                    </svg>
                    Unduh Aplikasi
                </a>
            </div>

            {{-- Tombol menu mobile --}}
            <button type="button" @click="open = !open"
                class="inline-flex h-11 w-11 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-700 transition hover:bg-slate-50 focus:outline-none focus-visible:ring-4 focus-visible:ring-sky-200 lg:hidden"
                :aria-expanded="open" aria-controls="menu-mobile" aria-label="Buka menu navigasi">
                <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <svg x-show="open" x-cloak xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </nav>

        {{-- Menu mobile --}}
        <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2" id="menu-mobile"
            class="mx-auto mt-2 max-w-7xl rounded-2xl border border-white bg-white p-3 shadow-2xl shadow-blue-900/10 lg:hidden">
            <nav class="grid gap-1">
                <a href="#beranda" @click="open = false"
                    class="rounded-xl px-4 py-3 text-sm font-extrabold text-slate-700 transition hover:bg-sky-50 hover:text-[#1e60be]">Beranda</a>
                <a href="#fitur" @click="open = false"
                    class="rounded-xl px-4 py-3 text-sm font-extrabold text-slate-700 transition hover:bg-sky-50 hover:text-[#1e60be]">Fitur</a>
                <a href="#cara-kerja" @click="open = false"
                    class="rounded-xl px-4 py-3 text-sm font-extrabold text-slate-700 transition hover:bg-sky-50 hover:text-[#1e60be]">Cara
                    Kerja</a>
                <a href="#unduh" @click="open = false"
                    class="rounded-xl px-4 py-3 text-sm font-extrabold text-slate-700 transition hover:bg-sky-50 hover:text-[#1e60be]">Unduh</a>
                <a href="#faq" @click="open = false"
                    class="rounded-xl px-4 py-3 text-sm font-extrabold text-slate-700 transition hover:bg-sky-50 hover:text-[#1e60be]">FAQ</a>
            </nav>
            <div class="mt-3 grid grid-cols-2 gap-2 border-t border-slate-100 pt-3">
                <a href="{{ $webUrl }}"
                    class="inline-flex items-center justify-center rounded-xl border-2 border-[#1e60be]/20 px-4 py-3 text-sm font-extrabold text-[#1e60be] transition hover:bg-sky-50">Masuk</a>
                <a href="#unduh" @click="open = false"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#1e60be] px-4 py-3 text-sm font-extrabold text-white transition hover:bg-[#2b73d1]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2.4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                    </svg>
                    Unduh
                </a>
            </div>
        </div>
    </header>

    {{-- =========================================================
         HERO
    ========================================================== --}}
    <section id="beranda" class="relative overflow-hidden pb-16 pt-32 sm:pt-36 lg:pb-24 lg:pt-44">
        {{-- Dekorasi latar --}}
        <div class="pointer-events-none absolute inset-0 -z-10" aria-hidden="true">
            <div class="absolute -left-28 top-12 h-80 w-80 rounded-full bg-[#5ebef3]/25 blur-3xl"></div>
            <div class="absolute -right-24 top-24 h-96 w-96 rounded-full bg-[#ffd629]/20 blur-3xl"></div>
            <div class="absolute bottom-0 left-1/3 h-72 w-72 rounded-full bg-[#d8759c]/10 blur-3xl"></div>
            <div class="bg-dotted absolute inset-x-0 top-0 h-[34rem] opacity-50 [mask-image:linear-gradient(to_bottom,black,transparent)]"></div>
        </div>

        <div class="mx-auto grid max-w-7xl items-center gap-14 px-4 sm:px-6 lg:grid-cols-2 lg:gap-10 lg:px-8">
            {{-- Teks hero --}}
            <div class="text-center lg:text-left">
                <span
                    class="inline-flex items-center gap-2 rounded-full border-2 border-[#ffd629]/70 bg-[#fff4c2] px-4 py-1.5 text-[11px] font-extrabold uppercase tracking-[0.14em] text-[#8a6d00] shadow-sm sm:text-xs">
                    <span class="h-2 w-2 animate-pulse rounded-full bg-[#ffd629]"></span>
                    Belajar • Bermain • Berkembang
                </span>

                <h1
                    class="font-display mt-5 text-4xl font-extrabold leading-[1.08] tracking-tight text-[#102a56] sm:text-5xl lg:text-6xl">
                    Belajar Jadi
                    <span class="relative inline-block text-[#1e60be]">
                        Petualangan
                        <svg class="absolute -bottom-2 left-0 h-3 w-full text-[#ffd629]" viewBox="0 0 200 14"
                            fill="none" preserveAspectRatio="none" aria-hidden="true">
                            <path d="M3 10C50 2 150 2 197 10" stroke="currentColor" stroke-width="7"
                                stroke-linecap="round" />
                        </svg>
                    </span>
                    Seru Bersama
                    <span class="text-[#d8759c]">BUBA</span>
                </h1>

                <p class="mx-auto mt-6 max-w-xl text-base font-semibold leading-relaxed text-slate-500 sm:text-lg lg:mx-0">
                    BUBA adalah aplikasi e-learning interaktif untuk guru dan siswa. Materi bergambar, kuis ber-audio,
                    dan reward bintang membuat setiap pelajaran terasa seperti bermain — di web maupun di ponsel.
                </p>

                <div class="mt-8 flex flex-col items-center justify-center gap-3 sm:flex-row lg:justify-start">
                    <a href="{{ $webUrl }}"
                        class="group inline-flex w-full items-center justify-center gap-2.5 rounded-2xl border-[3px] border-white bg-[#5ebef3] px-7 py-4 text-base font-extrabold text-white shadow-[0_7px_0_#3898cf] transition-all duration-200 hover:-translate-y-0.5 hover:bg-[#47ade7] hover:shadow-[0_9px_0_#3898cf] active:translate-y-1 active:shadow-[0_3px_0_#3898cf] sm:w-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="h-5 w-5 transition-transform group-hover:translate-x-0.5">
                            <path fill-rule="evenodd"
                                d="M4.5 5.653c0-1.426 1.529-2.33 2.779-1.643l11.54 6.348c1.295.712 1.295 2.573 0 3.285L7.28 19.991c-1.25.687-2.779-.217-2.779-1.643V5.653z"
                                clip-rule="evenodd" />
                        </svg>
                        Mulai Belajar
                    </a>

                    <a href="#unduh"
                        class="inline-flex w-full items-center justify-center gap-2.5 rounded-2xl border-2 border-[#1e60be]/20 bg-white px-7 py-4 text-base font-extrabold text-[#1e60be] shadow-lg shadow-blue-900/5 transition-all duration-200 hover:-translate-y-0.5 hover:border-[#5ebef3] hover:bg-sky-50 sm:w-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2.4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                        </svg>
                        Unduh Aplikasi
                    </a>
                </div>

                {{-- Platform --}}
                <div class="mt-6 flex flex-wrap items-center justify-center gap-2.5 text-xs font-extrabold text-slate-500 lg:justify-start">
                    <span class="inline-flex items-center gap-1.5 rounded-full border border-slate-200 bg-white px-3 py-1.5 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-[#1e60be]" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 21a9 9 0 100-18 9 9 0 000 18zM3.6 9h16.8M3.6 15h16.8M12 3c2.5 2.45 3.75 5.45 3.75 9S14.5 18.55 12 21c-2.5-2.45-3.75-5.45-3.75-9S9.5 5.45 12 3z" />
                        </svg>
                        Web App
                    </span>
                    <span class="inline-flex items-center gap-1.5 rounded-full border border-slate-200 bg-white px-3 py-1.5 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-[#71bf4f]" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 3v18m8-18v18M3 8h18M3 16h18M5 3h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2z" />
                        </svg>
                        Android &amp; iOS
                    </span>
                    <span class="inline-flex items-center gap-1.5 rounded-full border border-slate-200 bg-white px-3 py-1.5 shadow-sm">
                        <span class="text-sm">🎒</span>
                        Untuk Guru &amp; Siswa
                    </span>
                </div>

                {{-- Checklist singkat --}}
                <ul class="mx-auto mt-8 grid max-w-lg grid-cols-1 gap-2.5 text-left sm:grid-cols-3 lg:mx-0">
                    <li class="flex items-center gap-2 rounded-xl bg-white/70 px-3 py-2 text-xs font-extrabold text-slate-600 shadow-sm ring-1 ring-slate-100">
                        <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-[#71bf4f]/20 text-[10px] text-[#4f9634]">✓</span>
                        Materi + Audio
                    </li>
                    <li class="flex items-center gap-2 rounded-xl bg-white/70 px-3 py-2 text-xs font-extrabold text-slate-600 shadow-sm ring-1 ring-slate-100">
                        <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-[#5ebef3]/20 text-[10px] text-[#1e60be]">✓</span>
                        Kuis Interaktif
                    </li>
                    <li class="flex items-center gap-2 rounded-xl bg-white/70 px-3 py-2 text-xs font-extrabold text-slate-600 shadow-sm ring-1 ring-slate-100">
                        <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-[#ffd629]/25 text-[10px] text-[#967500]">✓</span>
                        Reward Bintang
                    </li>
                </ul>
            </div>

            {{-- Visual hero --}}
            <div class="relative mx-auto w-full max-w-xl lg:max-w-none">
                <div class="pointer-events-none absolute -inset-6 -z-10 rounded-full bg-gradient-to-br from-[#5ebef3]/25 via-[#ffd629]/10 to-[#d8759c]/20 blur-2xl"
                    aria-hidden="true"></div>

                <div class="relative mx-auto max-w-md">
                    {{-- Kartu utama --}}
                    <div
                        class="relative rotate-1 rounded-[2.5rem] border-[6px] border-white bg-gradient-to-br from-[#eaf6ff] via-white to-[#fff6dc] p-3 shadow-[0_30px_60px_-20px_rgba(30,96,190,0.35)] transition-transform duration-500 hover:rotate-0 sm:p-4">
                        <div class="rounded-[2rem] bg-[#1e60be] p-4 text-white sm:p-5">
                            <div class="flex items-center justify-between gap-3">
                                <div class="flex items-center gap-2">
                                    <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-white/20 text-lg">🐻</span>
                                    <span class="font-display text-lg font-extrabold tracking-wide">BUBA</span>
                                </div>
                                <div class="flex gap-1.5" aria-hidden="true">
                                    <span class="h-2.5 w-2.5 rounded-full bg-[#ffd629]"></span>
                                    <span class="h-2.5 w-2.5 rounded-full bg-[#d8759c]"></span>
                                    <span class="h-2.5 w-2.5 rounded-full bg-[#71bf4f]"></span>
                                </div>
                            </div>

                            <div class="mt-5 text-center">
                                <p class="inline-block rounded-2xl border-2 border-white/80 bg-white/10 px-5 py-1.5 font-display text-sm font-extrabold tracking-[0.16em]">
                                    PILIH KONTEN
                                </p>
                                <p class="mt-2 text-xs font-bold text-blue-100">Mau belajar apa hari ini?</p>
                            </div>

                            <div class="mt-4 grid grid-cols-3 gap-2.5">
                                <div class="rounded-2xl border-2 border-white/60 bg-[#71bf4f] p-2.5 text-center shadow-lg">
                                    <img src="{{ asset('images/icon-materi.png') }}" alt="Materi"
                                        class="mx-auto h-10 w-10 object-contain drop-shadow sm:h-12 sm:w-12">
                                    <p class="mt-1.5 font-display text-xs font-extrabold tracking-wide">MATERI</p>
                                </div>
                                <div class="rounded-2xl border-2 border-white/60 bg-[#5ebef3] p-2.5 text-center shadow-lg">
                                    <img src="{{ asset('images/icon-kuis.png') }}" alt="Kuis"
                                        class="mx-auto h-10 w-10 object-contain drop-shadow sm:h-12 sm:w-12">
                                    <p class="mt-1.5 font-display text-xs font-extrabold tracking-wide">KUIS</p>
                                </div>
                                <div class="rounded-2xl border-2 border-white/60 bg-[#faa63a] p-2.5 text-center shadow-lg">
                                    <img src="{{ asset('images/icon-piala.png') }}" alt="Riwayat"
                                        class="mx-auto h-10 w-10 object-contain drop-shadow sm:h-12 sm:w-12">
                                    <p class="mt-1.5 font-display text-xs font-extrabold tracking-wide">RIWAYAT</p>
                                </div>
                            </div>

                            <div class="mt-4 rounded-2xl bg-white/10 p-3 ring-1 ring-white/20">
                                <div class="flex items-center justify-between text-[11px] font-extrabold">
                                    <span class="text-blue-100">Semangat belajar hari ini</span>
                                    <span class="text-[#ffd629]">⭐⭐⭐</span>
                                </div>
                                <div class="mt-2 h-2 overflow-hidden rounded-full bg-white/20">
                                    <div class="h-full w-4/5 rounded-full bg-[#ffd629]"></div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between gap-2 px-2 pb-1 pt-3 text-[10px] font-extrabold text-slate-500 sm:text-xs">
                            <span class="inline-flex items-center gap-1.5"><span class="text-sm">📚</span> Materi bergambar</span>
                            <span class="inline-flex items-center gap-1.5"><span class="text-sm">🎧</span> Audio pendukung</span>
                        </div>
                    </div>

                    {{-- Kartu mengambang: materi --}}
                    <div
                        class="absolute -left-4 top-20 hidden animate-buba-float items-center gap-2.5 rounded-2xl border-2 border-white bg-white p-2.5 pr-4 shadow-xl shadow-blue-900/10 sm:flex lg:-left-8">
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#71bf4f]/20">
                            <img src="{{ asset('images/icon-materi.png') }}" alt="" class="h-7 w-7 object-contain">
                        </span>
                        <span>
                            <span class="block text-[10px] font-extrabold uppercase tracking-wider text-slate-400">Belajar</span>
                            <span class="font-display block text-sm font-extrabold text-slate-800">Materi + Audio</span>
                        </span>
                    </div>

                    {{-- Kartu mengambang: kuis --}}
                    <div
                        class="absolute -bottom-5 left-4 hidden animate-buba-float-slow items-center gap-2.5 rounded-2xl border-2 border-white bg-white p-2.5 pr-4 shadow-xl shadow-blue-900/10 sm:flex lg:-left-4">
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#5ebef3]/20">
                            <img src="{{ asset('images/icon-kuis.png') }}" alt="" class="h-7 w-7 object-contain">
                        </span>
                        <span>
                            <span class="block text-[10px] font-extrabold uppercase tracking-wider text-slate-400">Tantangan</span>
                            <span class="font-display block text-sm font-extrabold text-slate-800">Kuis Pilihan A–D</span>
                        </span>
                    </div>

                    {{-- Kartu mengambang: bintang --}}
                    <div
                        class="absolute -right-3 top-8 hidden animate-buba-wiggle flex-col items-center rounded-2xl border-2 border-white bg-[#ffd629] px-3 py-2 text-[#6b5200] shadow-xl shadow-yellow-500/20 sm:flex lg:-right-7">
                        <img src="{{ asset('images/icon-piala.png') }}" alt="" class="h-8 w-8 object-contain">
                        <span class="font-display mt-0.5 text-xs font-extrabold">5 Bintang</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- =========================================================
         STATISTIK RINGKAS
    ========================================================== --}}
    <section class="relative z-10 pb-16 sm:pb-20">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            <div
                class="grid grid-cols-2 gap-px overflow-hidden rounded-[1.8rem] border-2 border-white bg-slate-100 shadow-xl shadow-blue-900/5 sm:grid-cols-4">
                <div class="bg-white p-5 text-center sm:p-6">
                    <p class="font-display text-3xl font-extrabold text-[#1e60be] sm:text-4xl">3</p>
                    <p class="mt-1 text-[11px] font-extrabold uppercase tracking-wider text-slate-400 sm:text-xs">Menu Belajar</p>
                </div>
                <div class="bg-white p-5 text-center sm:p-6">
                    <p class="font-display text-3xl font-extrabold text-[#f0b400] sm:text-4xl">5</p>
                    <p class="mt-1 text-[11px] font-extrabold uppercase tracking-wider text-slate-400 sm:text-xs">Bintang Prestasi</p>
                </div>
                <div class="bg-white p-5 text-center sm:p-6">
                    <p class="font-display text-3xl font-extrabold text-[#d8759c] sm:text-4xl">A–D</p>
                    <p class="mt-1 text-[11px] font-extrabold uppercase tracking-wider text-slate-400 sm:text-xs">Pilihan Jawaban</p>
                </div>
                <div class="bg-white p-5 text-center sm:p-6">
                    <p class="font-display text-3xl font-extrabold text-[#71bf4f] sm:text-4xl">2</p>
                    <p class="mt-1 text-[11px] font-extrabold uppercase tracking-wider text-slate-400 sm:text-xs">Peran Pengguna</p>
                </div>
            </div>
        </div>
    </section>

    {{-- =========================================================
         FITUR
    ========================================================== --}}
    <section id="fitur" class="relative overflow-hidden py-16 sm:py-24">
        <div class="pointer-events-none absolute inset-0 -z-10" aria-hidden="true">
            <div class="absolute -right-32 top-20 h-80 w-80 rounded-full bg-[#71bf4f]/10 blur-3xl"></div>
            <div class="absolute -left-32 bottom-10 h-80 w-80 rounded-full bg-[#5ebef3]/10 blur-3xl"></div>
        </div>

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <span class="inline-flex items-center gap-2 rounded-full bg-[#d8759c]/10 px-4 py-1.5 text-xs font-extrabold uppercase tracking-wider text-[#b34f79]">
                    ✨ Fitur Unggulan
                </span>
                <h2 class="font-display mt-4 text-3xl font-extrabold leading-tight text-[#102a56] sm:text-4xl lg:text-5xl">
                    Lengkap untuk <span class="text-[#1e60be]">Belajar</span> dan <span class="text-[#d8759c]">Mengajar</span>
                </h2>
                <p class="mt-4 text-base font-semibold leading-relaxed text-slate-500 sm:text-lg">
                    Satu aplikasi dengan pengalaman berbeda untuk siswa dan guru. Semua fitur dirancang agar
                    pembelajaran lebih terstruktur, visual, dan menyenangkan.
                </p>
            </div>

            <div class="mt-12 grid gap-6 lg:grid-cols-2 lg:gap-8">
                {{-- Panel siswa --}}
                <div class="relative overflow-hidden rounded-[2rem] border-2 border-[#71bf4f]/20 bg-white p-6 shadow-xl shadow-green-900/5 sm:p-8">
                    <div class="pointer-events-none absolute -right-14 -top-14 h-44 w-44 rounded-full bg-[#71bf4f]/10" aria-hidden="true"></div>

                    <div class="relative flex items-start gap-4">
                        <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl border-2 border-white bg-[#71bf4f] text-2xl shadow-lg shadow-green-500/20">
                            🎒
                        </div>
                        <div>
                            <p class="text-[11px] font-extrabold uppercase tracking-[0.16em] text-[#4f9634]">Pengalaman Siswa</p>
                            <h3 class="font-display text-2xl font-extrabold text-slate-800">Belajar Sambil Bermain</h3>
                            <p class="mt-1 text-sm font-semibold leading-relaxed text-slate-500">
                                Materi dan kuis disusun sesuai kelas serta kategori, dengan tampilan yang ramah anak.
                            </p>
                        </div>
                    </div>

                    <ul class="relative mt-6 space-y-1.5">
                        <li class="flex gap-3.5 rounded-2xl p-3 transition hover:bg-[#f4fbef]">
                            <span class="mt-0.5 flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#71bf4f]/10 text-lg">🏫</span>
                            <div>
                                <h4 class="font-display text-base font-extrabold text-slate-800">Pilih Kelas &amp; Kategori</h4>
                                <p class="mt-0.5 text-sm font-semibold leading-relaxed text-slate-500">Materi dan kuis tersusun rapi berdasarkan kelas dan kategori pembelajaran.</p>
                            </div>
                        </li>
                        <li class="flex gap-3.5 rounded-2xl p-3 transition hover:bg-[#f4fbef]">
                            <span class="mt-0.5 flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#71bf4f]/10">
                                <img src="{{ asset('images/icon-materi.png') }}" alt="" class="h-7 w-7 object-contain">
                            </span>
                            <div>
                                <h4 class="font-display text-base font-extrabold text-slate-800">Materi Multimedia</h4>
                                <p class="mt-0.5 text-sm font-semibold leading-relaxed text-slate-500">Teks materi dilengkapi banyak gambar dan audio pendukung agar mudah dipahami.</p>
                            </div>
                        </li>
                        <li class="flex gap-3.5 rounded-2xl p-3 transition hover:bg-[#f4fbef]">
                            <span class="mt-0.5 flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#5ebef3]/10">
                                <img src="{{ asset('images/icon-kuis.png') }}" alt="" class="h-7 w-7 object-contain">
                            </span>
                            <div>
                                <h4 class="font-display text-base font-extrabold text-slate-800">Kuis Interaktif</h4>
                                <p class="mt-0.5 text-sm font-semibold leading-relaxed text-slate-500">Soal pilihan ganda A–D, bisa dilengkapi gambar serta audio pertanyaan dan pilihan.</p>
                            </div>
                        </li>
                        <li class="flex gap-3.5 rounded-2xl p-3 transition hover:bg-[#f4fbef]">
                            <span class="mt-0.5 flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#faa63a]/10 text-lg">📈</span>
                            <div>
                                <h4 class="font-display text-base font-extrabold text-slate-800">Progres &amp; Pembahasan</h4>
                                <p class="mt-0.5 text-sm font-semibold leading-relaxed text-slate-500">Lihat progres pengerjaan, nilai, jumlah benar/salah, serta pembahasan jawaban.</p>
                            </div>
                        </li>
                        <li class="flex gap-3.5 rounded-2xl p-3 transition hover:bg-[#f4fbef]">
                            <span class="mt-0.5 flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#ffd629]/20">
                                <img src="{{ asset('images/icon-piala.png') }}" alt="" class="h-7 w-7 object-contain">
                            </span>
                            <div>
                                <h4 class="font-display text-base font-extrabold text-slate-800">Reward Bintang</h4>
                                <p class="mt-0.5 text-sm font-semibold leading-relaxed text-slate-500">Raih hingga 5 bintang. Minimal 3 bintang menjadi pencapaian yang mengunci kategori.</p>
                            </div>
                        </li>
                        <li class="flex gap-3.5 rounded-2xl p-3 transition hover:bg-[#f4fbef]">
                            <span class="mt-0.5 flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#9c65cd]/10 text-lg">👤</span>
                            <div>
                                <h4 class="font-display text-base font-extrabold text-slate-800">Profil &amp; Riwayat</h4>
                                <p class="mt-0.5 text-sm font-semibold leading-relaxed text-slate-500">Akses profil siswa, info aplikasi, riwayat belajar, dan keluar akun dengan mudah.</p>
                            </div>
                        </li>
                        <li class="flex gap-3.5 rounded-2xl p-3 transition hover:bg-[#f4fbef]">
                            <span class="mt-0.5 flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#3cbdb1]/10 text-lg">📱</span>
                            <div>
                                <h4 class="font-display text-base font-extrabold text-slate-800">Tampilan Ramah Anak</h4>
                                <p class="mt-0.5 text-sm font-semibold leading-relaxed text-slate-500">Tombol besar, warna ceria, dan navigasi sederhana di web maupun ponsel.</p>
                            </div>
                        </li>
                    </ul>
                </div>

                {{-- Panel guru/admin --}}
                <div class="relative overflow-hidden rounded-[2rem] border-2 border-[#5ebef3]/25 bg-white p-6 shadow-xl shadow-blue-900/5 sm:p-8">
                    <div class="pointer-events-none absolute -right-14 -top-14 h-44 w-44 rounded-full bg-[#5ebef3]/10" aria-hidden="true"></div>

                    <div class="relative flex items-start gap-4">
                        <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl border-2 border-white bg-[#1e60be] text-2xl shadow-lg shadow-blue-500/20">
                            🧑‍🏫
                        </div>
                        <div>
                            <p class="text-[11px] font-extrabold uppercase tracking-[0.16em] text-[#1e60be]">Panel Guru &amp; Admin</p>
                            <h3 class="font-display text-2xl font-extrabold text-slate-800">Kelola Semua Kebutuhan</h3>
                            <p class="mt-1 text-sm font-semibold leading-relaxed text-slate-500">
                                Siapkan konten, atur pengguna, dan pantau hasil belajar siswa dari satu dashboard.
                            </p>
                        </div>
                    </div>

                    <ul class="relative mt-6 space-y-1.5">
                        <li class="flex gap-3.5 rounded-2xl p-3 transition hover:bg-sky-50">
                            <span class="mt-0.5 flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#1e60be]/10 text-lg">📊</span>
                            <div>
                                <h4 class="font-display text-base font-extrabold text-slate-800">Dashboard Statistik</h4>
                                <p class="mt-0.5 text-sm font-semibold leading-relaxed text-slate-500">Ringkasan total kelas, kategori, materi, kuis, dan komposisi konten.</p>
                            </div>
                        </li>
                        <li class="flex gap-3.5 rounded-2xl p-3 transition hover:bg-sky-50">
                            <span class="mt-0.5 flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#faa63a]/10 text-lg">🏷️</span>
                            <div>
                                <h4 class="font-display text-base font-extrabold text-slate-800">Kelola Kelas &amp; Kategori</h4>
                                <p class="mt-0.5 text-sm font-semibold leading-relaxed text-slate-500">Tambah, ubah, dan hapus kelas beserta kategori pembelajaran di dalamnya.</p>
                            </div>
                        </li>
                        <li class="flex gap-3.5 rounded-2xl p-3 transition hover:bg-sky-50">
                            <span class="mt-0.5 flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#71bf4f]/10">
                                <img src="{{ asset('images/icon-materi.png') }}" alt="" class="h-7 w-7 object-contain">
                            </span>
                            <div>
                                <h4 class="font-display text-base font-extrabold text-slate-800">Kelola Materi</h4>
                                <p class="mt-0.5 text-sm font-semibold leading-relaxed text-slate-500">Buat materi dengan isi teks, banyak gambar, audio, kelas, dan kategori.</p>
                            </div>
                        </li>
                        <li class="flex gap-3.5 rounded-2xl p-3 transition hover:bg-sky-50">
                            <span class="mt-0.5 flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#5ebef3]/10">
                                <img src="{{ asset('images/icon-kuis.png') }}" alt="" class="h-7 w-7 object-contain">
                            </span>
                            <div>
                                <h4 class="font-display text-base font-extrabold text-slate-800">Kelola Kuis</h4>
                                <p class="mt-0.5 text-sm font-semibold leading-relaxed text-slate-500">Susun banyak soal sekaligus dengan empat pilihan, kunci jawaban, gambar, dan audio.</p>
                            </div>
                        </li>
                        <li class="flex gap-3.5 rounded-2xl p-3 transition hover:bg-sky-50">
                            <span class="mt-0.5 flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#ffd629]/20">
                                <img src="{{ asset('images/icon-piala.png') }}" alt="" class="h-7 w-7 object-contain">
                            </span>
                            <div>
                                <h4 class="font-display text-base font-extrabold text-slate-800">Monitoring Hasil Reward</h4>
                                <p class="mt-0.5 text-sm font-semibold leading-relaxed text-slate-500">Pantau nilai, jawaban benar/salah, dan bintang yang diperoleh setiap siswa.</p>
                            </div>
                        </li>
                        <li class="flex gap-3.5 rounded-2xl p-3 transition hover:bg-sky-50">
                            <span class="mt-0.5 flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#d8759c]/10 text-lg">👨‍🎓</span>
                            <div>
                                <h4 class="font-display text-base font-extrabold text-slate-800">Kelola Akun Siswa</h4>
                                <p class="mt-0.5 text-sm font-semibold leading-relaxed text-slate-500">Buat dan atur akun siswa, termasuk menghubungkan siswa dengan kelasnya.</p>
                            </div>
                        </li>
                        <li class="flex gap-3.5 rounded-2xl p-3 transition hover:bg-sky-50">
                            <span class="mt-0.5 flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#3cbdb1]/10 text-lg">🔐</span>
                            <div>
                                <h4 class="font-display text-base font-extrabold text-slate-800">Akses Berbasis Peran</h4>
                                <p class="mt-0.5 text-sm font-semibold leading-relaxed text-slate-500">Guru dan siswa memiliki hak akses berbeda agar data serta konten tetap aman.</p>
                            </div>
                        </li>
                        <li class="flex gap-3.5 rounded-2xl p-3 transition hover:bg-sky-50">
                            <span class="mt-0.5 flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#9c65cd]/10 text-lg">⚙️</span>
                            <div>
                                <h4 class="font-display text-base font-extrabold text-slate-800">Profil &amp; Keamanan Akun</h4>
                                <p class="mt-0.5 text-sm font-semibold leading-relaxed text-slate-500">Perbarui profil, ganti kata sandi, dan kelola keamanan akun admin.</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Fitur pendukung --}}
            <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#5ebef3]/10 text-xl">🌐</span>
                    <h3 class="font-display mt-4 text-base font-extrabold text-slate-800">Web &amp; Mobile</h3>
                    <p class="mt-1 text-sm font-semibold leading-relaxed text-slate-500">Akses lewat browser, tablet, atau ponsel dengan tampilan yang responsif.</p>
                </div>
                <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#71bf4f]/10 text-xl">🎧</span>
                    <h3 class="font-display mt-4 text-base font-extrabold text-slate-800">Media Gambar &amp; Audio</h3>
                    <p class="mt-1 text-sm font-semibold leading-relaxed text-slate-500">Materi dan kuis dapat memuat gambar serta audio untuk pengalaman belajar lebih kaya.</p>
                </div>
                <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#ffd629]/20 text-xl">⭐</span>
                    <h3 class="font-display mt-4 text-base font-extrabold text-slate-800">Gamifikasi Bintang</h3>
                    <p class="mt-1 text-sm font-semibold leading-relaxed text-slate-500">Reward bintang dan pencapaian membuat siswa lebih semangat menyelesaikan kuis.</p>
                </div>
                <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#d8759c]/10 text-xl">🧩</span>
                    <h3 class="font-display mt-4 text-base font-extrabold text-slate-800">Konten Terstruktur</h3>
                    <p class="mt-1 text-sm font-semibold leading-relaxed text-slate-500">Kelas, kategori, materi, dan kuis tersusun rapi sehingga mudah diikuti.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- =========================================================
         CARA KERJA
    ========================================================== --}}
    <section id="cara-kerja" class="relative overflow-hidden bg-white py-16 sm:py-24">
        <div class="pointer-events-none absolute inset-x-0 top-0 -z-10 h-64 bg-gradient-to-b from-[#FFF9EF] to-transparent" aria-hidden="true"></div>

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <span class="inline-flex items-center gap-2 rounded-full bg-[#5ebef3]/10 px-4 py-1.5 text-xs font-extrabold uppercase tracking-wider text-[#1e60be]">
                    🚀 Mudah Dimulai
                </span>
                <h2 class="font-display mt-4 text-3xl font-extrabold leading-tight text-[#102a56] sm:text-4xl lg:text-5xl">
                    Empat Langkah Menuju <span class="text-[#1e60be]">Belajar Ceria</span>
                </h2>
                <p class="mt-4 text-base font-semibold leading-relaxed text-slate-500 sm:text-lg">
                    Guru menyiapkan pengalaman belajar, siswa tinggal masuk dan bermain. Semuanya terhubung dalam satu alur.
                </p>
            </div>

            <div class="relative mt-14 grid gap-8 md:grid-cols-2 lg:grid-cols-4">
                <div class="pointer-events-none absolute left-[12%] right-[12%] top-10 hidden h-1 rounded-full bg-gradient-to-r from-[#5ebef3] via-[#d8759c] to-[#71bf4f] opacity-30 lg:block" aria-hidden="true"></div>

                <div class="relative text-center">
                    <div class="relative z-10 mx-auto flex h-24 w-24 items-center justify-center rounded-[1.8rem] border-4 border-white bg-[#eaf6ff] text-4xl shadow-xl shadow-blue-900/5">
                        🧑‍🏫
                        <span class="absolute -right-2 -top-2 flex h-9 w-9 items-center justify-center rounded-full border-2 border-white bg-[#1e60be] font-display text-sm font-extrabold text-white shadow-lg">1</span>
                    </div>
                    <h3 class="font-display mt-5 text-lg font-extrabold text-slate-800">Guru Menyiapkan Konten</h3>
                    <p class="mt-2 text-sm font-semibold leading-relaxed text-slate-500">Atur kelas, kategori, materi, dan kuis melalui dashboard guru/admin.</p>
                </div>

                <div class="relative text-center">
                    <div class="relative z-10 mx-auto flex h-24 w-24 items-center justify-center rounded-[1.8rem] border-4 border-white bg-[#fff7d6] text-4xl shadow-xl shadow-yellow-900/5">
                        🎒
                        <span class="absolute -right-2 -top-2 flex h-9 w-9 items-center justify-center rounded-full border-2 border-white bg-[#f0b400] font-display text-sm font-extrabold text-white shadow-lg">2</span>
                    </div>
                    <h3 class="font-display mt-5 text-lg font-extrabold text-slate-800">Siswa Masuk dengan Akun</h3>
                    <p class="mt-2 text-sm font-semibold leading-relaxed text-slate-500">Akun siswa dibuat oleh guru dan terhubung dengan kelas yang sesuai.</p>
                </div>

                <div class="relative text-center">
                    <div class="relative z-10 mx-auto flex h-24 w-24 items-center justify-center rounded-[1.8rem] border-4 border-white bg-[#f2fbee] text-4xl shadow-xl shadow-green-900/5">
                        📚
                        <span class="absolute -right-2 -top-2 flex h-9 w-9 items-center justify-center rounded-full border-2 border-white bg-[#71bf4f] font-display text-sm font-extrabold text-white shadow-lg">3</span>
                    </div>
                    <h3 class="font-display mt-5 text-lg font-extrabold text-slate-800">Belajar &amp; Mengerjakan Kuis</h3>
                    <p class="mt-2 text-sm font-semibold leading-relaxed text-slate-500">Pilih materi atau kuis, lalu kerjakan soal bergambar dan ber-audio satu per satu.</p>
                </div>

                <div class="relative text-center">
                    <div class="relative z-10 mx-auto flex h-24 w-24 items-center justify-center rounded-[1.8rem] border-4 border-white bg-[#fdf0f5] text-4xl shadow-xl shadow-pink-900/5">
                        🏆
                        <span class="absolute -right-2 -top-2 flex h-9 w-9 items-center justify-center rounded-full border-2 border-white bg-[#d8759c] font-display text-sm font-extrabold text-white shadow-lg">4</span>
                    </div>
                    <h3 class="font-display mt-5 text-lg font-extrabold text-slate-800">Pantau Hasil &amp; Raih Bintang</h3>
                    <p class="mt-2 text-sm font-semibold leading-relaxed text-slate-500">Siswa melihat nilai dan pembahasan, guru memantau hasil reward di dashboard.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- =========================================================
         SHOWCASE TAMPILAN
    ========================================================== --}}
    <section class="relative overflow-hidden bg-[#133a7a] py-16 text-white sm:py-24">
        <div class="pointer-events-none absolute inset-0" aria-hidden="true">
            <div class="absolute -left-20 top-10 h-72 w-72 rounded-full bg-[#5ebef3]/20 blur-3xl"></div>
            <div class="absolute -right-20 bottom-0 h-80 w-80 rounded-full bg-[#d8759c]/20 blur-3xl"></div>
            <div class="bg-dotted-light absolute inset-0 opacity-30"></div>
        </div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <span class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-4 py-1.5 text-xs font-extrabold uppercase tracking-wider text-blue-100 backdrop-blur">
                    👀 Tampilan Aplikasi
                </span>
                <h2 class="font-display mt-4 text-3xl font-extrabold leading-tight sm:text-4xl lg:text-5xl">
                    Ramah Anak, <span class="text-[#ffd629]">Mudah</span> untuk Guru
                </h2>
                <p class="mt-4 text-base font-semibold leading-relaxed text-blue-100 sm:text-lg">
                    Antarmuka penuh warna dengan tombol besar, ikon yang jelas, dan alur sederhana agar siapa pun bisa langsung menggunakan BUBA.
                </p>
            </div>

            <div class="mt-12 grid gap-5 lg:grid-cols-3">
                {{-- Mockup 1: pilih konten --}}
                <div class="rounded-[2rem] border border-white/20 bg-white/10 p-3 shadow-2xl shadow-black/10 backdrop-blur">
                    <div class="rounded-[1.5rem] bg-[#eaf6ff] p-4 text-slate-800">
                        <div class="flex items-center justify-between">
                            <span class="inline-flex items-center gap-1.5 font-display text-xs font-extrabold text-[#1e60be]">🐻 BUBA</span>
                            <span class="text-[10px] font-extrabold text-slate-400">PILIH KONTEN</span>
                        </div>
                        <div class="mt-4 grid grid-cols-3 gap-2">
                            <div class="rounded-xl border-2 border-white bg-[#71bf4f] p-2 text-center shadow">
                                <img src="{{ asset('images/icon-materi.png') }}" alt="" class="mx-auto h-9 w-9 object-contain">
                                <p class="mt-1 text-[9px] font-extrabold text-white">MATERI</p>
                            </div>
                            <div class="rounded-xl border-2 border-white bg-[#5ebef3] p-2 text-center shadow">
                                <img src="{{ asset('images/icon-kuis.png') }}" alt="" class="mx-auto h-9 w-9 object-contain">
                                <p class="mt-1 text-[9px] font-extrabold text-white">KUIS</p>
                            </div>
                            <div class="rounded-xl border-2 border-white bg-[#faa63a] p-2 text-center shadow">
                                <img src="{{ asset('images/icon-piala.png') }}" alt="" class="mx-auto h-9 w-9 object-contain">
                                <p class="mt-1 text-[9px] font-extrabold text-white">RIWAYAT</p>
                            </div>
                        </div>
                        <div class="mt-3 rounded-xl bg-white p-3 shadow-sm">
                            <p class="text-[10px] font-extrabold text-[#1e60be]">Belajar hari ini</p>
                            <div class="mt-1.5 h-1.5 overflow-hidden rounded-full bg-slate-100">
                                <div class="h-full w-2/3 rounded-full bg-[#71bf4f]"></div>
                            </div>
                            <p class="mt-1 text-[9px] font-bold text-slate-400">2 dari 3 aktivitas selesai</p>
                        </div>
                    </div>
                    <p class="mt-3 text-center text-xs font-extrabold text-blue-100">Pilih materi, kuis, atau riwayat</p>
                </div>

                {{-- Mockup 2: kuis --}}
                <div class="rounded-[2rem] border border-white/20 bg-white/10 p-3 shadow-2xl shadow-black/10 backdrop-blur">
                    <div class="rounded-[1.5rem] bg-white p-4 text-slate-800">
                        <div class="flex items-center justify-between text-[10px] font-extrabold">
                            <span class="text-[#1e60be]">⭐ PROGRESS KUIS</span>
                            <span class="text-slate-400">2 / 5</span>
                        </div>
                        <div class="mt-2 h-2 overflow-hidden rounded-full bg-slate-100">
                            <div class="h-full w-2/5 rounded-full bg-[#ffd629]"></div>
                        </div>
                        <p class="mt-4 text-xs font-extrabold text-slate-500">Pertanyaan 2</p>
                        <p class="mt-1 text-sm font-extrabold leading-snug text-slate-800">Huruf pertama dari kata "Bola" adalah ...</p>
                        <div class="mt-3 grid grid-cols-2 gap-2 text-[11px] font-extrabold">
                            <span class="rounded-lg border-2 border-[#71bf4f] bg-[#71bf4f]/10 px-2 py-1.5 text-[#4f9634]">A. B</span>
                            <span class="rounded-lg border-2 border-slate-100 bg-slate-50 px-2 py-1.5 text-slate-500">B. O</span>
                            <span class="rounded-lg border-2 border-slate-100 bg-slate-50 px-2 py-1.5 text-slate-500">C. L</span>
                            <span class="rounded-lg border-2 border-slate-100 bg-slate-50 px-2 py-1.5 text-slate-500">D. A</span>
                        </div>
                    </div>
                    <p class="mt-3 text-center text-xs font-extrabold text-blue-100">Soal bergambar &amp; ber-audio</p>
                </div>

                {{-- Mockup 3: hasil --}}
                <div class="rounded-[2rem] border border-white/20 bg-white/10 p-3 shadow-2xl shadow-black/10 backdrop-blur">
                    <div class="rounded-[1.5rem] bg-white p-4 text-center text-slate-800">
                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-[#fff7d6]">
                            <img src="{{ asset('images/icon-piala.png') }}" alt="" class="h-9 w-9 object-contain">
                        </div>
                        <p class="mt-2 text-[10px] font-extrabold uppercase tracking-wider text-slate-400">Nilai Kamu</p>
                        <p class="font-display text-3xl font-extrabold text-[#1e60be]">100</p>
                        <p class="text-lg tracking-widest" aria-label="Lima bintang">⭐⭐⭐⭐⭐</p>
                        <div class="mt-3 grid grid-cols-3 gap-1.5 text-[10px] font-extrabold">
                            <span class="rounded-lg bg-green-50 px-1.5 py-1 text-green-600">5 Benar</span>
                            <span class="rounded-lg bg-red-50 px-1.5 py-1 text-red-500">0 Salah</span>
                            <span class="rounded-lg bg-yellow-50 px-1.5 py-1 text-yellow-600">5 Total</span>
                        </div>
                    </div>
                    <p class="mt-3 text-center text-xs font-extrabold text-blue-100">Nilai, pembahasan, &amp; bintang</p>
                </div>
            </div>

            <div class="mt-8 flex flex-wrap items-center justify-center gap-2.5 text-xs font-extrabold text-blue-100">
                <span class="inline-flex items-center gap-1.5 rounded-full bg-white/10 px-3 py-1.5 ring-1 ring-white/20">🎨 Warna ceria</span>
                <span class="inline-flex items-center gap-1.5 rounded-full bg-white/10 px-3 py-1.5 ring-1 ring-white/20">👆 Tombol besar</span>
                <span class="inline-flex items-center gap-1.5 rounded-full bg-white/10 px-3 py-1.5 ring-1 ring-white/20">📱 Responsif</span>
                <span class="inline-flex items-center gap-1.5 rounded-full bg-white/10 px-3 py-1.5 ring-1 ring-white/20">🧭 Navigasi sederhana</span>
            </div>
        </div>
    </section>

    {{-- =========================================================
         UNDUH APLIKASI
    ========================================================== --}}
    <section id="unduh" class="relative py-16 sm:py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div
                class="relative overflow-hidden rounded-[2.2rem] border-[6px] border-white bg-gradient-to-br from-[#1e60be] via-[#2b73d1] to-[#5ebef3] p-6 shadow-2xl shadow-blue-900/20 sm:rounded-[2.8rem] sm:p-10 lg:p-14">
                <div class="pointer-events-none absolute inset-0" aria-hidden="true">
                    <div class="absolute -right-16 -top-16 h-64 w-64 rounded-full bg-white/10"></div>
                    <div class="absolute -bottom-24 -left-10 h-80 w-80 rounded-full bg-white/10"></div>
                    <div class="absolute right-1/4 top-6 text-3xl opacity-70 animate-buba-float">⭐</div>
                    <div class="absolute bottom-10 left-1/3 text-3xl opacity-60 animate-buba-float-slow">🎈</div>
                </div>

                <div class="relative grid items-center gap-10 lg:grid-cols-[1.2fr_0.8fr]">
                    <div class="text-center lg:text-left">
                        <span class="inline-flex items-center gap-2 rounded-full border border-white/25 bg-white/20 px-4 py-1.5 text-xs font-extrabold uppercase tracking-wider text-white backdrop-blur">
                            📲 Download Aplikasi
                        </span>
                        <h2 class="font-display mt-4 text-3xl font-extrabold leading-tight text-white sm:text-4xl lg:text-5xl">
                            Bawa BUBA ke Mana Saja
                        </h2>
                        <p class="mx-auto mt-4 max-w-xl text-base font-semibold leading-relaxed text-blue-50 lg:mx-0">
                            Belajar dari sekolah, rumah, atau perjalanan. BUBA tersedia sebagai aplikasi web yang
                            responsif dan aplikasi mobile untuk Android serta iOS.
                        </p>

                        <div class="mt-8 flex flex-col items-center gap-3 sm:flex-row sm:flex-wrap lg:justify-start">
                            {{-- Google Play --}}
                            <a href="{{ $androidUrl }}"
                                class="group inline-flex w-full items-center justify-center gap-3 rounded-2xl border-2 border-white bg-white px-5 py-3 text-left shadow-lg transition-all duration-200 hover:-translate-y-1 hover:shadow-xl sm:w-auto">
                                <svg class="h-7 w-7 shrink-0 text-[#1e60be]" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M3.609 1.814L13.792 12 3.61 22.186a1.49 1.49 0 01-.61-1.204V3.018c0-.47.234-.892.61-1.204zm1.47-.51l11.254 6.55-2.407 2.407L5.08 1.304zM18.86 9.32l2.517 1.465a1.49 1.49 0 010 2.574l-2.518 1.465-2.65-2.65 2.65-2.854zM5.08 22.696l8.846-8.846 2.407 2.407L7.08 22.807c-.472.276-1.006.211-1.399-.11l-.601-.001z" />
                                </svg>
                                <span class="leading-tight">
                                    <span class="block text-[10px] font-extrabold uppercase tracking-widest text-slate-400">Unduh di</span>
                                    <span class="font-display block text-base font-extrabold text-slate-900">Google Play</span>
                                </span>
                            </a>

                            {{-- App Store --}}
                            <a href="{{ $iosUrl }}"
                                class="group inline-flex w-full items-center justify-center gap-3 rounded-2xl border-2 border-white bg-white px-5 py-3 text-left shadow-lg transition-all duration-200 hover:-translate-y-1 hover:shadow-xl sm:w-auto">
                                <svg class="h-7 w-7 shrink-0 text-slate-900" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M16.365 1.43c0 1.14-.46 2.2-1.205 3.02-.87.96-2.28 1.7-3.61 1.6-.16-1.1.43-2.27 1.12-3.02.79-.86 2.18-1.55 3.47-1.6h.225zm3.72 17.15c-.62 1.42-.92 2.05-1.72 3.3-1.12 1.74-2.7 3.9-4.66 3.92-1.73.02-2.18-1.13-4.53-1.11-2.35.01-2.84 1.14-4.57 1.12-1.96-.02-3.46-1.98-4.58-3.72-3.13-4.86-3.46-10.57-1.53-13.6 1.37-2.15 3.54-3.41 5.58-3.41 2.06 0 3.36 1.13 5.07 1.13 1.66 0 2.67-1.13 5.06-1.13 1.81 0 3.73.99 5.09 2.7-4.47 2.45-3.75 8.84.29 10.8z" />
                                </svg>
                                <span class="leading-tight">
                                    <span class="block text-[10px] font-extrabold uppercase tracking-widest text-slate-400">Unduh di</span>
                                    <span class="font-display block text-base font-extrabold text-slate-900">App Store</span>
                                </span>
                            </a>

                            {{-- Web --}}
                            <a href="{{ $webUrl }}"
                                class="group inline-flex w-full items-center justify-center gap-2.5 rounded-2xl border-2 border-[#ffd629] bg-[#ffd629] px-5 py-3.5 text-sm font-extrabold text-[#102a56] shadow-[0_5px_0_#c9a800] transition-all duration-200 hover:-translate-y-1 hover:bg-[#ffdf5c] sm:w-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 21a9 9 0 100-18 9 9 0 000 18zM3.6 9h16.8M3.6 15h16.8M12 3c2.5 2.45 3.75 5.45 3.75 9S14.5 18.55 12 21c-2.5-2.45-3.75-5.45-3.75-9S9.5 5.45 12 3z" />
                                </svg>
                                Buka Versi Web
                            </a>
                        </div>

                        <p class="mt-4 text-xs font-semibold leading-relaxed text-blue-100">
                            Gunakan akun yang diberikan guru/admin untuk masuk. Tersedia untuk Android, iOS, dan browser.
                        </p>
                    </div>

                    {{-- Mockup ponsel --}}
                    <div class="relative mx-auto w-56 sm:w-64">
                        <div class="absolute -inset-4 rounded-full bg-white/10 blur-xl" aria-hidden="true"></div>
                        <div class="relative rounded-[2.6rem] border-[6px] border-white/80 bg-[#0d2b5b] p-2 shadow-2xl">
                            <div class="mx-auto mb-1.5 h-1.5 w-16 rounded-full bg-white/20"></div>
                            <div class="rounded-[2rem] bg-[#eaf6ff] p-4 text-center text-slate-800">
                                <img src="{{ asset('images/logoBuba.png') }}" alt="Logo BUBA"
                                    class="mx-auto h-20 w-auto object-contain">
                                <p class="mt-2 font-display text-[11px] font-extrabold tracking-[0.16em] text-[#1e60be]">PILIH KONTEN</p>
                                <div class="mt-3 grid grid-cols-3 gap-1.5">
                                    <div class="rounded-xl border-2 border-white bg-[#71bf4f] p-1.5 shadow">
                                        <img src="{{ asset('images/icon-materi.png') }}" alt="" class="mx-auto h-6 w-6 object-contain">
                                    </div>
                                    <div class="rounded-xl border-2 border-white bg-[#5ebef3] p-1.5 shadow">
                                        <img src="{{ asset('images/icon-kuis.png') }}" alt="" class="mx-auto h-6 w-6 object-contain">
                                    </div>
                                    <div class="rounded-xl border-2 border-white bg-[#faa63a] p-1.5 shadow">
                                        <img src="{{ asset('images/icon-piala.png') }}" alt="" class="mx-auto h-6 w-6 object-contain">
                                    </div>
                                </div>
                                <div class="mt-3 rounded-xl bg-white p-2.5 text-left shadow-sm">
                                    <p class="text-[9px] font-extrabold text-[#1e60be]">Semangat belajar!</p>
                                    <div class="mt-1.5 h-1.5 overflow-hidden rounded-full bg-slate-100">
                                        <div class="h-full w-3/4 rounded-full bg-[#ffd629]"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="absolute -right-3 top-14 flex animate-buba-wiggle items-center gap-1 rounded-xl border-2 border-white bg-[#ffd629] px-2.5 py-1.5 text-[10px] font-extrabold text-[#6b5200] shadow-lg">
                            <span>⭐</span> 5 Bintang
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- =========================================================
         FAQ
    ========================================================== --}}
    <section id="faq" class="relative bg-white py-16 sm:py-24">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <span class="inline-flex items-center gap-2 rounded-full bg-[#9c65cd]/10 px-4 py-1.5 text-xs font-extrabold uppercase tracking-wider text-[#7944a6]">
                    ❓ FAQ
                </span>
                <h2 class="font-display mt-4 text-3xl font-extrabold leading-tight text-[#102a56] sm:text-4xl lg:text-5xl">
                    Pertanyaan yang Sering Diajukan
                </h2>
                <p class="mt-4 text-base font-semibold leading-relaxed text-slate-500">
                    Belum yakin? Temukan jawaban singkat tentang penggunaan BUBA di sini.
                </p>
            </div>

            <div class="mt-10 space-y-3">
                <details class="group rounded-2xl border-2 border-slate-100 bg-[#FFF9EF] p-5 transition open:border-[#5ebef3]/40 open:bg-white open:shadow-lg open:shadow-blue-900/5 sm:p-6">
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4 font-display text-base font-extrabold text-slate-800 sm:text-lg">
                        Apa itu aplikasi BUBA?
                        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#5ebef3]/10 text-[#1e60be] transition-transform duration-200 group-open:rotate-45">+</span>
                    </summary>
                    <p class="mt-3 text-sm font-semibold leading-relaxed text-slate-500 sm:text-base">
                        BUBA adalah aplikasi e-learning interaktif yang mempertemukan guru dan siswa dalam satu platform.
                        Guru dapat menyiapkan kelas, kategori, materi, dan kuis, sedangkan siswa belajar melalui materi
                        bergambar serta kuis ber-audio dengan reward bintang.
                    </p>
                </details>

                <details class="group rounded-2xl border-2 border-slate-100 bg-[#FFF9EF] p-5 transition open:border-[#5ebef3]/40 open:bg-white open:shadow-lg open:shadow-blue-900/5 sm:p-6">
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4 font-display text-base font-extrabold text-slate-800 sm:text-lg">
                        Siapa saja yang dapat menggunakan BUBA?
                        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#5ebef3]/10 text-[#1e60be] transition-transform duration-200 group-open:rotate-45">+</span>
                    </summary>
                    <p class="mt-3 text-sm font-semibold leading-relaxed text-slate-500 sm:text-base">
                        Ada dua peran utama: guru/admin dan siswa. Guru mengelola konten serta memantau hasil belajar,
                        sementara siswa mengakses materi dan kuis sesuai kelasnya. Setiap peran memiliki hak akses yang berbeda.
                    </p>
                </details>

                <details class="group rounded-2xl border-2 border-slate-100 bg-[#FFF9EF] p-5 transition open:border-[#5ebef3]/40 open:bg-white open:shadow-lg open:shadow-blue-900/5 sm:p-6">
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4 font-display text-base font-extrabold text-slate-800 sm:text-lg">
                        Bagaimana siswa mendapatkan akun?
                        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#5ebef3]/10 text-[#1e60be] transition-transform duration-200 group-open:rotate-45">+</span>
                    </summary>
                    <p class="mt-3 text-sm font-semibold leading-relaxed text-slate-500 sm:text-base">
                        Akun siswa dibuat oleh guru/admin melalui menu Kelola Siswa. Saat membuat akun, siswa dihubungkan
                        dengan kelasnya. Setelah itu siswa dapat masuk melalui halaman login menggunakan akun tersebut.
                    </p>
                </details>

                <details class="group rounded-2xl border-2 border-slate-100 bg-[#FFF9EF] p-5 transition open:border-[#5ebef3]/40 open:bg-white open:shadow-lg open:shadow-blue-900/5 sm:p-6">
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4 font-display text-base font-extrabold text-slate-800 sm:text-lg">
                        Materi dan kuis seperti apa yang tersedia?
                        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#5ebef3]/10 text-[#1e60be] transition-transform duration-200 group-open:rotate-45">+</span>
                    </summary>
                    <p class="mt-3 text-sm font-semibold leading-relaxed text-slate-500 sm:text-base">
                        Materi berisi teks penjelasan yang dapat dilengkapi banyak gambar dan audio. Kuis berbentuk
                        pilihan ganda A–D dan dapat memuat gambar soal, audio pertanyaan, serta audio untuk setiap pilihan
                        jawaban. Semua konten dikelompokkan berdasarkan kelas dan kategori.
                    </p>
                </details>

                <details class="group rounded-2xl border-2 border-slate-100 bg-[#FFF9EF] p-5 transition open:border-[#5ebef3]/40 open:bg-white open:shadow-lg open:shadow-blue-900/5 sm:p-6">
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4 font-display text-base font-extrabold text-slate-800 sm:text-lg">
                        Bagaimana sistem reward bintang bekerja?
                        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#5ebef3]/10 text-[#1e60be] transition-transform duration-200 group-open:rotate-45">+</span>
                    </summary>
                    <p class="mt-3 text-sm font-semibold leading-relaxed text-slate-500 sm:text-base">
                        Bintang diberikan berdasarkan nilai kuis: nilai 90 ke atas mendapat 5 bintang, 70–89 mendapat
                        4 bintang, 50–69 mendapat 3 bintang, 20–49 mendapat 2 bintang, dan 1–19 mendapat 1 bintang.
                        Setelah siswa memperoleh minimal 3 bintang pada suatu kategori, kategori tersebut terkunci sebagai
                        tanda pencapaian.
                    </p>
                </details>

                <details class="group rounded-2xl border-2 border-slate-100 bg-[#FFF9EF] p-5 transition open:border-[#5ebef3]/40 open:bg-white open:shadow-lg open:shadow-blue-900/5 sm:p-6">
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4 font-display text-base font-extrabold text-slate-800 sm:text-lg">
                        Apakah hasil kuis bisa dilihat kembali?
                        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#5ebef3]/10 text-[#1e60be] transition-transform duration-200 group-open:rotate-45">+</span>
                    </summary>
                    <p class="mt-3 text-sm font-semibold leading-relaxed text-slate-500 sm:text-base">
                        Bisa. Setelah menyelesaikan kuis, siswa melihat nilai, jumlah benar/salah, bintang yang diperoleh,
                        serta pembahasan jawaban. Guru juga dapat memantau hasil tersebut melalui menu Hasil Reward di
                        dashboard admin.
                    </p>
                </details>

                <details class="group rounded-2xl border-2 border-slate-100 bg-[#FFF9EF] p-5 transition open:border-[#5ebef3]/40 open:bg-white open:shadow-lg open:shadow-blue-900/5 sm:p-6">
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4 font-display text-base font-extrabold text-slate-800 sm:text-lg">
                        Apakah BUBA bisa diakses lewat HP?
                        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#5ebef3]/10 text-[#1e60be] transition-transform duration-200 group-open:rotate-45">+</span>
                    </summary>
                    <p class="mt-3 text-sm font-semibold leading-relaxed text-slate-500 sm:text-base">
                        Ya. BUBA dapat dibuka melalui browser di komputer, tablet, maupun ponsel. Aplikasi mobile juga
                        tersedia untuk Android dan iOS melalui tombol unduh di halaman ini.
                    </p>
                </details>
            </div>
        </div>
    </section>

    {{-- =========================================================
         FOOTER
    ========================================================== --}}
    <footer class="relative overflow-hidden bg-[#0d2b5b] text-white">
        <div class="pointer-events-none absolute inset-0" aria-hidden="true">
            <div class="absolute -left-24 top-0 h-72 w-72 rounded-full bg-[#5ebef3]/10 blur-3xl"></div>
            <div class="absolute -right-24 bottom-0 h-80 w-80 rounded-full bg-[#d8759c]/10 blur-3xl"></div>
            <div class="bg-dotted-light absolute inset-0 opacity-20"></div>
        </div>

        <div class="relative mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
            <div class="grid gap-10 md:grid-cols-2 lg:grid-cols-4">
                {{-- Brand --}}
                <div class="lg:col-span-1">
                    <a href="#beranda" class="inline-flex rounded-2xl bg-white p-3 shadow-lg" aria-label="BUBA">
                        <img src="{{ asset('images/logoBuba.png') }}" alt="Logo BUBA" class="h-16 w-auto object-contain">
                    </a>
                    <p class="mt-4 max-w-xs text-sm font-semibold leading-relaxed text-blue-100">
                        Aplikasi e-learning interaktif untuk guru dan siswa. Belajar, bermain, dan berkembang bersama BUBA.
                    </p>
                    <div class="mt-4 flex flex-wrap gap-2 text-[11px] font-extrabold text-blue-100">
                        <span class="rounded-full bg-white/10 px-3 py-1.5 ring-1 ring-white/10">Web</span>
                        <span class="rounded-full bg-white/10 px-3 py-1.5 ring-1 ring-white/10">Android</span>
                        <span class="rounded-full bg-white/10 px-3 py-1.5 ring-1 ring-white/10">iOS</span>
                    </div>
                </div>

                {{-- Navigasi --}}
                <div>
                    <h3 class="font-display text-sm font-extrabold uppercase tracking-[0.16em] text-[#ffd629]">Navigasi</h3>
                    <ul class="mt-4 space-y-2.5 text-sm font-semibold text-blue-100">
                        <li><a href="#beranda" class="transition hover:text-white hover:underline">Beranda</a></li>
                        <li><a href="#fitur" class="transition hover:text-white hover:underline">Fitur</a></li>
                        <li><a href="#cara-kerja" class="transition hover:text-white hover:underline">Cara Kerja</a></li>
                        <li><a href="#unduh" class="transition hover:text-white hover:underline">Unduh Aplikasi</a></li>
                        <li><a href="#faq" class="transition hover:text-white hover:underline">FAQ</a></li>
                    </ul>
                </div>

                {{-- Fitur --}}
                <div>
                    <h3 class="font-display text-sm font-extrabold uppercase tracking-[0.16em] text-[#ffd629]">Fitur</h3>
                    <ul class="mt-4 space-y-2.5 text-sm font-semibold text-blue-100">
                        <li><a href="#fitur" class="transition hover:text-white hover:underline">Materi Bergambar &amp; Audio</a></li>
                        <li><a href="#fitur" class="transition hover:text-white hover:underline">Kuis Interaktif</a></li>
                        <li><a href="#fitur" class="transition hover:text-white hover:underline">Reward Bintang</a></li>
                        <li><a href="#fitur" class="transition hover:text-white hover:underline">Dashboard Guru</a></li>
                        <li><a href="#fitur" class="transition hover:text-white hover:underline">Kelola Siswa</a></li>
                    </ul>
                </div>

                {{-- Platform --}}
                <div>
                    <h3 class="font-display text-sm font-extrabold uppercase tracking-[0.16em] text-[#ffd629]">Akses</h3>
                    <ul class="mt-4 space-y-2.5 text-sm font-semibold text-blue-100">
                        <li><a href="{{ $webUrl }}" class="transition hover:text-white hover:underline">Masuk ke Aplikasi</a></li>
                        <li><a href="#unduh" class="transition hover:text-white hover:underline">Google Play</a></li>
                        <li><a href="#unduh" class="transition hover:text-white hover:underline">App Store</a></li>
                        <li><a href="#faq" class="transition hover:text-white hover:underline">Pusat Bantuan</a></li>
                    </ul>
                </div>
            </div>

            <div class="mt-12 flex flex-col items-center justify-between gap-3 border-t border-white/10 pt-6 text-center text-xs font-semibold text-blue-200 sm:flex-row sm:text-left">
                <p>&copy; {{ date('Y') }} BUBA E-Learning. Belajar • Bermain • Berkembang.</p>
                <p>Dibuat dengan <span class="text-[#f36b6b]">❤</span> untuk pembelajaran yang menyenangkan.</p>
            </div>
        </div>
    </footer>

    {{-- Tombol kembali ke atas --}}
    <a href="#beranda"
        class="fixed bottom-5 right-5 z-40 flex h-11 w-11 items-center justify-center rounded-full border-2 border-white bg-[#1e60be] text-white shadow-xl shadow-blue-900/20 transition hover:-translate-y-1 hover:bg-[#2b73d1] focus:outline-none focus-visible:ring-4 focus-visible:ring-sky-200"
        aria-label="Kembali ke atas" title="Kembali ke atas">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
            stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
        </svg>
    </a>

</body>

</html>
