<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Jam BUBA menampilkan waktu Indonesia Barat (WIB) dengan tampilan ceria untuk teman belajar.">
    <meta name="theme-color" content="#1e60be">
    <title>Jam BUBA - Waktu Indonesia Barat</title>

    @include('layouts.partials.favicon')

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@600;700;800&family=Nunito:wght@500;600;700;800;900&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Nunito', system-ui, -apple-system, sans-serif;
        }

        .font-display {
            font-family: 'Baloo 2', 'Nunito', system-ui, sans-serif;
        }

        /* =====================================================
           BUBA CLOCK — Animasi & Komponen Khusus Halaman Jam
           ===================================================== */

        @keyframes clockColonBlink {
            0%, 45% {
                opacity: 1;
                transform: translateY(-0.06em) scale(1);
            }
            50%, 95% {
                opacity: 0.25;
                transform: translateY(-0.06em) scale(0.92);
            }
            100% {
                opacity: 1;
                transform: translateY(-0.06em) scale(1);
            }
        }

        @keyframes clockDigitPop {
            0% {
                transform: translateY(-10px) scale(1.12);
                filter: brightness(1.45);
            }
            60% {
                transform: translateY(2px) scale(0.98);
            }
            100% {
                transform: translateY(0) scale(1);
                filter: brightness(1);
            }
        }

        @keyframes clockGreetingPop {
            0% {
                opacity: 0;
                transform: translateY(6px) scale(0.96);
            }
            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @keyframes clockTwinkle {
            0%, 100% {
                opacity: 0.35;
                transform: scale(0.85) rotate(-6deg);
            }
            50% {
                opacity: 1;
                transform: scale(1.15) rotate(8deg);
            }
        }

        @keyframes clockSunSpin {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }

        @keyframes clockShadowPulse {
            0%, 100% {
                opacity: 0.55;
                transform: scale(0.96);
            }
            50% {
                opacity: 0.85;
                transform: scale(1.03);
            }
        }

        .clock-time-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr)) auto repeat(2, minmax(0, 1fr)) auto repeat(2, minmax(0, 1fr));
            align-items: center;
            gap: 3px;
            width: 100%;
            max-width: 34rem;
            margin-inline: auto;
            container-type: inline-size;
        }

        @media (min-width: 640px) {
            .clock-time-grid {
                gap: 6px;
            }
        }

        .clock-tile {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            min-width: 0;
            height: auto;
            aspect-ratio: 0.66;
            overflow: hidden;
            border: 3px solid #ffffff;
            border-radius: clamp(0.6rem, 2.2cqw, 1.35rem);
            background: linear-gradient(180deg, #2f7ad8 0%, #1e60be 58%, #154a94 100%);
            box-shadow:
                0 6px 0 #123d7d,
                0 12px 18px rgba(21, 74, 148, 0.22),
                inset 0 2px 0 rgba(255, 255, 255, 0.35);
            color: #ffffff;
            font-family: 'Baloo 2', 'Nunito', system-ui, sans-serif;
            font-size: clamp(1.35rem, 7vw, 4.2rem);
            font-size: 11cqw;
            font-weight: 800;
            line-height: 1;
            text-shadow: 0 3px 0 rgba(0, 0, 0, 0.18);
        }

        .clock-tile::after {
            content: '';
            position: absolute;
            inset: 0 0 52% 0;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.28), rgba(255, 255, 255, 0));
            pointer-events: none;
        }

        .clock-colon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0 0.1rem;
            color: #1e60be;
            font-family: 'Baloo 2', 'Nunito', system-ui, sans-serif;
            font-size: clamp(1.25rem, 5.5vw, 3.8rem);
            font-size: 9cqw;
            font-weight: 800;
            line-height: 1;
            text-shadow: 0 3px 0 #ffffff;
            animation: clockColonBlink 1s steps(1, end) infinite;
        }

        .digit-pop {
            animation: clockDigitPop 0.38s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .greeting-pop {
            animation: clockGreetingPop 0.45s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .clock-hand {
            position: absolute;
            left: 50%;
            bottom: 50%;
            z-index: 10;
            transform-origin: 50% 100%;
            border-radius: 999px;
            will-change: transform;
        }

        .hand-hour {
            width: 6px;
            height: 26%;
            margin-left: -3px;
            background: linear-gradient(180deg, #2f7ad8, #1e60be);
            box-shadow: 0 1px 3px rgba(30, 96, 190, 0.35);
            transition: transform 0.35s cubic-bezier(0.4, 1.6, 0.6, 1);
        }

        .hand-minute {
            width: 4px;
            height: 35%;
            margin-left: -2px;
            background: linear-gradient(180deg, #7dd3fc, #3898cf);
            box-shadow: 0 1px 3px rgba(56, 152, 207, 0.35);
            transition: transform 0.35s cubic-bezier(0.4, 1.6, 0.6, 1);
        }

        .hand-second {
            width: 2px;
            height: 41%;
            margin-left: -1px;
            background: #f36b6b;
            box-shadow: 0 1px 3px rgba(243, 107, 107, 0.4);
            transition: transform 0.18s cubic-bezier(0.34, 2.2, 0.64, 1);
        }

        .hand-second::after {
            content: '';
            position: absolute;
            bottom: -18%;
            left: 50%;
            width: 5px;
            height: 18%;
            transform: translateX(-50%);
            border-radius: 999px;
            background: #f36b6b;
        }

        .clock-sun {
            animation: clockSunSpin 28s linear infinite;
        }

        .clock-twinkle {
            animation: clockTwinkle 3.2s ease-in-out infinite;
        }

        .clock-twinkle-slow {
            animation: clockTwinkle 5s ease-in-out infinite;
            animation-delay: 0.8s;
        }

        .clock-glow {
            animation: clockShadowPulse 4s ease-in-out infinite;
        }

        .clock-seconds-bar {
            transition: width 1s linear;
        }

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                animation-duration: 0.001ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.001ms !important;
            }
        }
    </style>
</head>

<body class="relative min-h-screen overflow-x-hidden bg-[#0b3b75] text-slate-800 antialiased">

    <!-- =====================================================
         LATAR BELAKANG BUBA
         ====================================================== -->
    <img src="{{ asset('images/backgroundSplash.png') }}" alt=""
        class="pointer-events-none fixed inset-0 z-0 h-full w-full select-none object-cover object-bottom"
        aria-hidden="true">
    <div class="pointer-events-none fixed inset-0 z-0 bg-gradient-to-b from-sky-400/10 via-transparent to-[#0b3b75]/40"
        aria-hidden="true"></div>

    <!-- Dekorasi: awan, bintang, dan bentuk mengambang -->
    <div class="pointer-events-none fixed inset-0 z-0 overflow-hidden select-none" aria-hidden="true">
        <!-- Awan kiri -->
        <div class="animate-buba-cloud-1 absolute left-[4%] top-[7%] opacity-70">
            <svg class="h-auto w-20 text-white drop-shadow-md sm:w-28 md:w-36" viewBox="0 0 100 60" fill="currentColor">
                <path
                    d="M20 50 C10 50 2 42 2 32 C2 24 8 18 16 16 C19 8 28 2 38 2 C49 2 58 8 62 18 C66 16 70 16 74 18 C83 19 90 26 90 35 C90 43 83 50 74 50 Z" />
            </svg>
        </div>

        <!-- Awan kanan -->
        <div class="animate-buba-cloud-2 absolute right-[5%] top-[13%] hidden opacity-65 sm:block">
            <svg class="h-auto w-24 text-white drop-shadow-md sm:w-32 md:w-40" viewBox="0 0 100 60" fill="currentColor">
                <path
                    d="M20 50 C10 50 2 42 2 32 C2 24 8 18 16 16 C19 8 28 2 38 2 C49 2 58 8 62 18 C66 16 70 16 74 18 C83 19 90 26 90 35 C90 43 83 50 74 50 Z" />
            </svg>
        </div>

        <!-- Matahari berputar pelan di balik logo -->
        <div class="clock-sun absolute left-1/2 top-[10%] hidden h-44 w-44 -translate-x-1/2 text-[#ffd629]/50 sm:block">
            <svg viewBox="0 0 100 100" fill="currentColor" class="h-full w-full">
                <path
                    d="M50 2l4.8 12.9 12.2-5.7 1.5 14.2L82.6 19l-2 13.9L94 37.2 85.6 48 98 55.7 85.9 63.2l8.7 10.9-13.8 3.7 2.7 13.7-14.1-1.9-1.2 14.2L56.7 98 50 85.8 43.3 98l-11.5-6.2-1.2-14.2-14.1 1.9 2.7-13.7-13.8-3.7 8.7-10.9L2 55.7 14.4 48 6 37.2l13.4-4.3-2-13.9 14.1 5.4 1.5-14.2L45.2 15.9 50 2z" />
            </svg>
        </div>

        <!-- Bintang berkelip -->
        <span class="clock-twinkle absolute left-[9%] top-[28%] text-2xl drop-shadow sm:text-3xl">⭐</span>
        <span class="clock-twinkle-slow absolute right-[10%] top-[30%] text-2xl drop-shadow sm:text-3xl">✨</span>
        <span class="clock-twinkle absolute bottom-[22%] left-[7%] hidden text-2xl drop-shadow sm:block">✨</span>
        <span class="clock-twinkle-slow absolute bottom-[18%] right-[8%] hidden text-2xl drop-shadow sm:block">⭐</span>

        <!-- Bulatan warna khas BUBA -->
        <span class="animate-buba-float absolute left-[14%] top-[56%] hidden h-4 w-4 rounded-full bg-[#71bf4f]/80 shadow-md sm:block"></span>
        <span class="animate-buba-float-slow absolute right-[16%] top-[58%] hidden h-5 w-5 rounded-full bg-[#faa63a]/80 shadow-md sm:block"></span>
        <span class="animate-buba-float absolute bottom-[12%] left-[22%] hidden h-3 w-3 rounded-full bg-[#d8759c]/80 shadow-md md:block"></span>
        <span class="animate-buba-float-slow absolute bottom-[30%] right-[20%] hidden h-3.5 w-3.5 rounded-full bg-[#5ebef3]/90 shadow-md md:block"></span>
    </div>

    <!-- Tombol kembali ke beranda -->
    <div class="absolute left-4 top-4 z-30 sm:left-6 sm:top-6 md:left-8 md:top-8">
        <a href="{{ url('/') }}"
            class="group flex h-12 w-12 items-center justify-center rounded-full border-[4px] border-white bg-[#5ebef3] text-white shadow-[0_6px_14px_rgba(0,0,0,0.18)] transition-all duration-200 hover:scale-110 hover:bg-[#47ade7] hover:shadow-xl active:translate-y-0.5 active:scale-90 focus:outline-none focus:ring-4 focus:ring-white/70 sm:h-14 sm:w-14 md:h-16 md:w-16 md:border-[5px]"
            aria-label="Kembali ke beranda BUBA" title="Kembali ke beranda">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                class="h-6 w-6 text-white drop-shadow transition-transform duration-200 group-hover:-translate-x-0.5 sm:h-7 sm:w-7 md:h-8 md:w-8">
                <path d="M16 5.5a1 1 0 0 0-1.6-.8l-9 7a1 1 0 0 0 0 1.6l9 7A1 1 0 0 0 16 19.5V5.5z" />
            </svg>
        </a>
    </div>

    <!-- Tombol layar penuh -->
    <div class="absolute right-4 top-4 z-30 sm:right-6 sm:top-6 md:right-8 md:top-8">
        <button id="fullscreen-btn" type="button"
            class="group flex h-12 w-12 items-center justify-center rounded-full border-[4px] border-white bg-[#5ebef3] text-white shadow-[0_6px_14px_rgba(0,0,0,0.18)] transition-all duration-200 hover:scale-110 hover:bg-[#47ade7] hover:shadow-xl active:translate-y-0.5 active:scale-90 focus:outline-none focus:ring-4 focus:ring-white/70 sm:h-14 sm:w-14 md:h-16 md:w-16 md:border-[5px]"
            aria-label="Tampilkan layar penuh" title="Tampilkan layar penuh">
            <!-- Ikon masuk layar penuh -->
            <svg id="fs-enter-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke-width="2.4" stroke="currentColor"
                class="h-6 w-6 text-white drop-shadow transition-transform duration-200 group-hover:scale-110 sm:h-7 sm:w-7 md:h-8 md:w-8">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15" />
            </svg>
            <!-- Ikon keluar layar penuh -->
            <svg id="fs-exit-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke-width="2.4" stroke="currentColor"
                class="hidden h-6 w-6 text-white drop-shadow transition-transform duration-200 group-hover:scale-110 sm:h-7 sm:w-7 md:h-8 md:w-8">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9 9V4.5M9 9H4.5M9 9L3.75 3.75M9 15v4.5M9 15H4.5M9 15l-5.25 5.25M15 9h4.5M15 9V4.5M15 9l5.25-5.25M15 15h4.5M15 15v4.5M15 15l5.25 5.25" />
            </svg>
        </button>
    </div>

    <!-- =====================================================
         KONTEN UTAMA
         ====================================================== -->
    <div class="relative z-10 flex min-h-screen w-full flex-col items-center px-4 py-5 sm:px-6 sm:py-7">

        <!-- Logo BUBA -->
        <header class="flex flex-col items-center pt-10 sm:pt-8">
            <a href="{{ url('/') }}"
                class="group relative block w-40 rounded-3xl transition-transform duration-300 hover:scale-105 focus:outline-none focus:ring-4 focus:ring-white/70 sm:w-52 md:w-60"
                aria-label="Logo BUBA - kembali ke beranda">
                <span class="clock-glow absolute -inset-4 rounded-full bg-white/35 blur-2xl" aria-hidden="true"></span>
                <img src="{{ asset('images/logoBuba.png') }}" alt="Logo BUBA"
                    class="animate-buba-float relative h-auto w-full select-none drop-shadow-[0_12px_24px_rgba(0,0,0,0.28)]">
            </a>

            <p
                class="mt-2 inline-flex items-center gap-2 rounded-full border-2 border-white/80 bg-white/90 px-4 py-1 text-[10px] font-black uppercase tracking-[0.2em] text-[#1e60be] shadow-md backdrop-blur sm:text-xs">
                <span class="relative flex h-2 w-2">
                    <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-[#71bf4f] opacity-75"></span>
                    <span class="relative inline-flex h-2 w-2 rounded-full bg-[#71bf4f]"></span>
                </span>
                Belajar • Bermain • Berkembang
            </p>
        </header>

        <!-- Kartu Jam -->
        <main class="my-5 flex w-full max-w-3xl flex-1 flex-col items-center justify-center sm:my-7">
            <section class="relative w-full" aria-labelledby="clock-title">

                <!-- Banner judul -->
                <div
                    class="absolute -top-5 left-1/2 z-20 -translate-x-1/2 whitespace-nowrap rounded-2xl border-[4px] border-white bg-[#1e60be] px-5 py-2 shadow-[0_8px_20px_rgba(30,96,190,0.42)] sm:-top-6 sm:rounded-[1.6rem] sm:border-[5px] sm:px-8 sm:py-3">
                    <h1 id="clock-title"
                        class="font-display flex items-center gap-2 text-lg font-extrabold tracking-wider text-white drop-shadow-[0_2px_4px_rgba(0,0,0,0.3)] sm:text-2xl">
                        <span aria-hidden="true">🕐</span>
                        JAM BUBA
                        <span aria-hidden="true">✨</span>
                    </h1>
                </div>

                <div
                    class="animate-buba-pop relative overflow-hidden rounded-[2rem] border-[5px] border-white bg-white/95 px-4 pb-6 pt-12 shadow-[0_20px_50px_rgba(0,0,0,0.3)] backdrop-blur sm:rounded-[2.8rem] sm:border-[6px] sm:px-8 sm:pb-8 sm:pt-16">

                    <!-- Hiasan lembut di dalam kartu -->
                    <div class="pointer-events-none absolute -left-16 -top-16 h-48 w-48 rounded-full bg-[#5ebef3]/20 blur-2xl"
                        aria-hidden="true"></div>
                    <div class="pointer-events-none absolute -bottom-20 -right-16 h-56 w-56 rounded-full bg-[#ffd629]/20 blur-2xl"
                        aria-hidden="true"></div>

                    <div class="relative flex flex-col items-center gap-5 sm:gap-6 lg:flex-row lg:gap-8">

                        <!-- Jam analog -->
                        <div class="order-2 shrink-0 lg:order-1">
                            <div class="relative h-36 w-36 sm:h-44 sm:w-44 md:h-52 md:w-52">
                                <span class="clock-glow absolute inset-2 rounded-full bg-[#5ebef3]/45 blur-xl"
                                    aria-hidden="true"></span>

                                <div class="relative h-full w-full rounded-full border-[5px] border-white bg-gradient-to-br from-white via-sky-50 to-[#dff3ff] shadow-[0_12px_22px_rgba(30,96,190,0.28),inset_0_4px_10px_rgba(30,96,190,0.12)] ring-[5px] ring-[#5ebef3] sm:border-[6px] sm:ring-[6px]"
                                    aria-hidden="true">

                                    <!-- Garis penanda menit & jam -->
                                    @for ($i = 0; $i < 60; $i++)
                                        <span class="absolute inset-0" style="transform: rotate({{ $i * 6 }}deg);">
                                            <span
                                                class="{{ $i % 5 === 0 ? 'absolute left-1/2 top-[5%] h-[9%] w-[3px] -translate-x-1/2 rounded-full bg-[#1e60be]' : 'absolute left-1/2 top-[6%] h-[4.5%] w-[1.5px] -translate-x-1/2 rounded-full bg-[#5ebef3]/70' }}"></span>
                                        </span>
                                    @endfor

                                    <!-- Angka jam -->
                                    <span
                                        class="font-display absolute left-1/2 top-[17%] -translate-x-1/2 -translate-y-1/2 text-sm font-extrabold text-[#1e60be] sm:text-base">12</span>
                                    <span
                                        class="font-display absolute right-[14%] top-1/2 -translate-y-1/2 text-sm font-extrabold text-[#1e60be] sm:text-base">3</span>
                                    <span
                                        class="font-display absolute bottom-[17%] left-1/2 -translate-x-1/2 translate-y-1/2 text-sm font-extrabold text-[#1e60be] sm:text-base">6</span>
                                    <span
                                        class="font-display absolute left-[14%] top-1/2 -translate-y-1/2 text-sm font-extrabold text-[#1e60be] sm:text-base">9</span>

                                    <!-- Jarum jam -->
                                    <div id="hour-hand" class="clock-hand hand-hour"></div>
                                    <div id="minute-hand" class="clock-hand hand-minute"></div>
                                    <div id="second-hand" class="clock-hand hand-second"></div>

                                    <!-- Pusat jam -->
                                    <span
                                        class="absolute left-1/2 top-1/2 z-20 h-4 w-4 -translate-x-1/2 -translate-y-1/2 rounded-full border-[3px] border-white bg-[#f36b6b] shadow-md"></span>
                                    <span
                                        class="absolute left-1/2 top-1/2 z-0 h-2 w-2 -translate-x-1/2 -translate-y-1/2 rounded-full bg-[#1e60be]"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Jam digital -->
                        <div class="order-1 flex w-full min-w-0 flex-1 flex-col items-center lg:order-2">
                            <p id="greeting"
                                class="font-display text-center text-base font-extrabold tracking-wide text-[#1e60be] sm:text-xl">
                                Halo Teman BUBA! 👋
                            </p>

                            <div class="clock-time-grid mt-2" aria-hidden="true">
                                <span id="hour-tens" class="clock-tile">0</span>
                                <span id="hour-ones" class="clock-tile">0</span>
                                <span class="clock-colon">:</span>
                                <span id="minute-tens" class="clock-tile">0</span>
                                <span id="minute-ones" class="clock-tile">0</span>
                                <span class="clock-colon">:</span>
                                <span id="second-tens" class="clock-tile">0</span>
                                <span id="second-ones" class="clock-tile">0</span>
                            </div>

                            <!-- Teks waktu untuk pembaca layar -->
                            <time id="clock-time" class="sr-only" aria-live="off">--:--:--</time>

                            <!-- Tanggal -->
                            <div class="mt-4 inline-flex max-w-full items-center justify-center gap-2 rounded-full border-2 border-[#ffd629] bg-[#ffd629]/25 px-3.5 py-1.5 shadow-sm">
                                <span aria-hidden="true">📅</span>
                                <time id="date-display"
                                    class="font-display text-center text-sm font-extrabold text-[#8a6700] sm:text-base">
                                    --
                                </time>
                            </div>

                            <!-- Progres detik & zona waktu -->
                            <div class="mt-3 w-full max-w-sm">
                                <div class="flex items-center gap-2">
                                    <div class="h-2.5 flex-1 overflow-hidden rounded-full border-2 border-white bg-sky-100 shadow-inner">
                                        <div id="seconds-bar"
                                            class="clock-seconds-bar h-full w-0 rounded-full bg-gradient-to-r from-[#5ebef3] via-[#71bf4f] to-[#ffd629]">
                                        </div>
                                    </div>
                                    <span class="font-display text-[10px] font-extrabold tracking-wider text-[#3898cf] sm:text-xs">DETIK</span>
                                </div>

                                <div class="mt-3 flex justify-center">
                                    <span
                                        class="inline-flex items-center gap-2 rounded-full border-2 border-[#71bf4f]/40 bg-[#71bf4f]/10 px-3 py-1 text-[10px] font-extrabold text-[#5ba23c] sm:text-xs">
                                        <span class="relative flex h-2.5 w-2.5">
                                            <span
                                                class="absolute inline-flex h-full w-full animate-ping rounded-full bg-[#71bf4f] opacity-75"></span>
                                            <span class="relative inline-flex h-2.5 w-2.5 rounded-full bg-[#71bf4f]"></span>
                                        </span>
                                        WIB • Asia/Jakarta
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <!-- Footer -->
        <footer class="flex flex-col items-center gap-1 pb-2 text-center">
            <p class="font-display text-xs font-bold tracking-wide text-white drop-shadow-[0_2px_4px_rgba(0,0,0,0.3)] sm:text-sm">
                Buba E-Learning Application
            </p>
            <p class="text-[10px] font-semibold text-white/80 sm:text-xs">
                &copy; {{ date('Y') }} NAJATIF. All Right Reserved.
            </p>
        </footer>
    </div>

    <script>
        (function () {
            'use strict';

            const TIME_ZONE = 'Asia/Jakarta';

            // Format tanggal dalam Bahasa Indonesia.
            const dateFormatter = new Intl.DateTimeFormat('id-ID', {
                timeZone: TIME_ZONE,
                weekday: 'long',
                day: '2-digit',
                month: 'long',
                year: 'numeric',
            });

            // Format angka tanggal untuk atribut datetime pada elemen <time>.
            const isoDateFormatter = new Intl.DateTimeFormat('en-GB', {
                timeZone: TIME_ZONE,
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
            });

            // Ambil jam, menit, dan detik WIB dalam format 24 jam.
            const timePartsFormatter = new Intl.DateTimeFormat('en-GB', {
                timeZone: TIME_ZONE,
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hourCycle: 'h23',
            });

            const digitElements = {
                hourTens: document.getElementById('hour-tens'),
                hourOnes: document.getElementById('hour-ones'),
                minuteTens: document.getElementById('minute-tens'),
                minuteOnes: document.getElementById('minute-ones'),
                secondTens: document.getElementById('second-tens'),
                secondOnes: document.getElementById('second-ones'),
            };

            const clockTime = document.getElementById('clock-time');
            const dateDisplay = document.getElementById('date-display');
            const greetingDisplay = document.getElementById('greeting');
            const secondsBar = document.getElementById('seconds-bar');
            const hourHand = document.getElementById('hour-hand');
            const minuteHand = document.getElementById('minute-hand');
            const secondHand = document.getElementById('second-hand');

            let lastGreeting = '';

            function getPart(parts, type) {
                const found = parts.find(function (part) {
                    return part.type === type;
                });

                return found ? found.value : '';
            }

            function setDigit(element, value) {
                if (!element || element.textContent === value) {
                    return;
                }

                element.textContent = value;

                // Ulangi animasi pop setiap digit berubah.
                element.classList.remove('digit-pop');
                void element.offsetWidth;
                element.classList.add('digit-pop');
            }

            function getGreeting(hour) {
                if (hour >= 4 && hour < 11) {
                    return 'Selamat Pagi! 🌅';
                }

                if (hour >= 11 && hour < 15) {
                    return 'Selamat Siang! ☀️';
                }

                if (hour >= 15 && hour < 18) {
                    return 'Selamat Sore! 🌇';
                }

                return 'Selamat Malam! 🌙';
            }

            function updateClock() {
                const now = new Date();

                // --- Jam digital (WIB) ---
                const timeParts = timePartsFormatter.formatToParts(now);
                const hour = Number(getPart(timeParts, 'hour'));
                const minute = Number(getPart(timeParts, 'minute'));
                const second = Number(getPart(timeParts, 'second'));

                const hourText = String(hour).padStart(2, '0');
                const minuteText = String(minute).padStart(2, '0');
                const secondText = String(second).padStart(2, '0');
                const timeText = hourText + ':' + minuteText + ':' + secondText;

                setDigit(digitElements.hourTens, hourText[0]);
                setDigit(digitElements.hourOnes, hourText[1]);
                setDigit(digitElements.minuteTens, minuteText[0]);
                setDigit(digitElements.minuteOnes, minuteText[1]);
                setDigit(digitElements.secondTens, secondText[0]);
                setDigit(digitElements.secondOnes, secondText[1]);

                clockTime.textContent = timeText;
                clockTime.setAttribute('datetime', timeText);

                // --- Tanggal (WIB) ---
                const dateParts = dateFormatter.formatToParts(now);
                const weekday = getPart(dateParts, 'weekday');
                const day = getPart(dateParts, 'day');
                const month = getPart(dateParts, 'month');
                const year = getPart(dateParts, 'year');

                dateDisplay.textContent = weekday + ', ' + day + ' ' + month + ' ' + year;

                const isoParts = isoDateFormatter.formatToParts(now);
                dateDisplay.setAttribute('datetime',
                    getPart(isoParts, 'year') + '-' +
                    getPart(isoParts, 'month') + '-' +
                    getPart(isoParts, 'day')
                );

                // --- Sapaan sesuai waktu WIB ---
                const greeting = getGreeting(hour);

                if (greeting !== lastGreeting) {
                    greetingDisplay.textContent = greeting;
                    greetingDisplay.classList.remove('greeting-pop');
                    void greetingDisplay.offsetWidth;
                    greetingDisplay.classList.add('greeting-pop');
                    lastGreeting = greeting;
                }

                // --- Progres detik ---
                secondsBar.style.width = ((second / 60) * 100).toFixed(2) + '%';

                // --- Jarum jam analog ---
                const secondValue = second + now.getMilliseconds() / 1000;
                const minuteValue = minute + secondValue / 60;
                const hourValue = (hour % 12) + minuteValue / 60;

                hourHand.style.transform = 'rotate(' + (hourValue * 30) + 'deg)';
                minuteHand.style.transform = 'rotate(' + (minuteValue * 6) + 'deg)';
                secondHand.style.transform = 'rotate(' + (secondValue * 6) + 'deg)';
            }

            // Selaraskan pembaruan jam dengan pergantian detik.
            function scheduleNextTick() {
                const delay = 1000 - (Date.now() % 1000);
                window.setTimeout(function () {
                    updateClock();
                    scheduleNextTick();
                }, delay + 15);
            }

            updateClock();
            scheduleNextTick();

            // --- Tombol layar penuh ---
            const fullscreenButton = document.getElementById('fullscreen-btn');
            const enterIcon = document.getElementById('fs-enter-icon');
            const exitIcon = document.getElementById('fs-exit-icon');

            if (fullscreenButton) {
                fullscreenButton.addEventListener('click', function () {
                    if (!document.fullscreenElement) {
                        if (document.documentElement.requestFullscreen) {
                            document.documentElement.requestFullscreen().catch(function () {});
                        }
                    } else if (document.exitFullscreen) {
                        document.exitFullscreen().catch(function () {});
                    }
                });

                document.addEventListener('fullscreenchange', function () {
                    const isFullscreen = Boolean(document.fullscreenElement);
                    const label = isFullscreen ? 'Keluar dari layar penuh' : 'Tampilkan layar penuh';

                    enterIcon.classList.toggle('hidden', isFullscreen);
                    exitIcon.classList.toggle('hidden', !isFullscreen);
                    fullscreenButton.setAttribute('aria-label', label);
                    fullscreenButton.setAttribute('title', label);
                });
            }

            // Segarkan tampilan saat tab kembali dibuka.
            document.addEventListener('visibilitychange', function () {
                if (!document.hidden) {
                    updateClock();
                }
            });
        })();
    </script>
</body>

</html>
