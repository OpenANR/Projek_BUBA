@extends('layouts.siswa.app')

@section('title', 'Pilih Konten - BUBA')

@section('content')

    <!-- Container Utama (Fullscreen responsif) -->
    <div class="relative w-full h-screen min-h-[600px] flex flex-col justify-between items-center overflow-x-hidden overflow-y-auto sm:overflow-hidden select-none py-5 px-4 sm:px-6 md:px-8">

        <!-- 1. Background Image -->
        <img src="{{ asset('images/backgroundSplash.png') }}" alt="BUBA Background"
            class="absolute inset-0 w-full h-full object-cover object-bottom z-0 pointer-events-none select-none">

        <!-- 2. Tombol Kembali (Top Left) -->
        <div class="absolute top-4 left-4 sm:top-6 sm:left-6 md:top-8 md:left-8 z-30">
            <a href="{{ route('splash') }}"
                class="group flex items-center justify-center w-12 h-12 sm:w-14 sm:h-14 md:w-16 md:h-16 rounded-full bg-[#5ebef3] hover:bg-[#47ade7] active:bg-[#349bd5] border-[4px] md:border-[5px] border-white shadow-[0_6px_14px_rgba(0,0,0,0.18)] transition-all duration-200 hover:scale-110 hover:shadow-xl active:scale-90 active:translate-y-0.5 focus:outline-none focus:ring-4 focus:ring-white/70"
                aria-label="Kembali ke Halaman Splash">
                <!-- Panah Segitiga Putih -->
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                    class="w-6 h-6 sm:w-7 sm:h-7 md:w-8 md:h-8 text-white drop-shadow transition-transform duration-200 group-hover:-translate-x-0.5">
                    <path d="M16 5.5a1 1 0 0 0-1.6-.8l-9 7a1 1 0 0 0 0 1.6l9 7A1 1 0 0 0 16 19.5V5.5z" />
                </svg>
            </a>
        </div>

        <!-- 3. Header Banner: PILIH KONTEN (Center Top) -->
        <div class="relative z-10 pt-2 sm:pt-4 md:pt-6 flex justify-center items-center">
            <div class="rounded-2xl sm:rounded-[2rem] md:rounded-[2.2rem] border-[4px] sm:border-[5px] md:border-[6px] border-white bg-[#1e60be] px-7 py-2 sm:px-10 sm:py-3 md:px-14 md:py-3.5 shadow-[0_8px_20px_rgba(0,0,0,0.2)] transition-transform duration-300 hover:scale-105">
                <h1 class="text-white font-black text-2xl sm:text-3xl md:text-4xl lg:text-[2.6rem] tracking-wider text-center drop-shadow-[0_2px_4px_rgba(0,0,0,0.3)] font-sans">
                    PILIH KONTEN
                </h1>
            </div>
        </div>

        <!-- 4. Pilihan Menu Kartu: MATERI & KUIS (Center) -->
        <div class="relative z-10 my-auto flex flex-col sm:flex-row items-center justify-center gap-6 sm:gap-8 md:gap-12 lg:gap-16 w-full max-w-4xl px-4 py-4">

            <!-- Card MATERI (Hijau) -->
            <a href="{{ route('siswa.kelas', ['konten' => 'materi']) }}"
                class="group relative flex flex-col items-center justify-between w-52 h-60 sm:w-60 sm:h-72 md:w-72 md:h-84 lg:w-80 lg:h-92 p-5 sm:p-6 md:p-8 bg-[#71bf4f] border-[6px] sm:border-[7px] md:border-8 border-white rounded-[2rem] sm:rounded-[2.4rem] md:rounded-[2.8rem] shadow-[0_12px_24px_rgba(0,0,0,0.18)] transition-all duration-300 ease-out hover:scale-105 hover:-translate-y-2.5 hover:shadow-[0_22px_36px_rgba(113,191,79,0.45)] active:scale-95 active:translate-y-1 active:shadow-md focus:outline-none focus:ring-4 focus:ring-white/70"
                aria-label="Pilih Materi">

                <!-- Ilustrasi Tumpukan Buku -->
                <div class="flex-1 flex items-center justify-center w-full">
                    <img src="{{ asset('images/icon-materi.png') }}" alt="Materi BUBA"
                        class="w-24 h-24 sm:w-32 sm:h-32 md:w-40 md:h-40 object-contain drop-shadow-md transition-all duration-300 ease-out group-hover:scale-110 group-hover:-rotate-3 group-hover:-translate-y-1">
                </div>

                <!-- Text Label MATERI -->
                <span class="text-white font-black text-2xl sm:text-3xl md:text-4xl tracking-wider text-center drop-shadow-[0_2px_4px_rgba(0,0,0,0.25)] font-sans">
                    MATERI
                </span>
            </a>

            <!-- Card KUIS (Oranye) -->
            <a href="{{ route('siswa.kelas', ['konten' => 'kuis']) }}"
                class="group relative flex flex-col items-center justify-between w-52 h-60 sm:w-60 sm:h-72 md:w-72 md:h-84 lg:w-80 lg:h-92 p-5 sm:p-6 md:p-8 bg-[#faa63a] border-[6px] sm:border-[7px] md:border-8 border-white rounded-[2rem] sm:rounded-[2.4rem] md:rounded-[2.8rem] shadow-[0_12px_24px_rgba(0,0,0,0.18)] transition-all duration-300 ease-out hover:scale-105 hover:-translate-y-2.5 hover:shadow-[0_22px_36px_rgba(250,166,58,0.45)] active:scale-95 active:translate-y-1 active:shadow-md focus:outline-none focus:ring-4 focus:ring-white/70"
                aria-label="Pilih Kuis">

                <!-- Ilustrasi Pensil -->
                <div class="flex-1 flex items-center justify-center w-full">
                    <img src="{{ asset('images/icon-kuis.png') }}" alt="Kuis BUBA"
                        class="w-24 h-24 sm:w-32 sm:h-32 md:w-40 md:h-40 object-contain drop-shadow-md transition-all duration-300 ease-out group-hover:scale-110 group-hover:rotate-12 group-hover:-translate-y-1">
                </div>

                <!-- Text Label KUIS -->
                <span class="text-white font-black text-2xl sm:text-3xl md:text-4xl tracking-wider text-center drop-shadow-[0_2px_4px_rgba(0,0,0,0.25)] font-sans">
                    KUIS
                </span>
            </a>

        </div>

        <!-- 5. Spacer Bawah (Memberikan ruang agar ilustrasi rumput & anak-anak di background tetap terlihat) -->
        <div class="relative z-10 h-6 sm:h-10 md:h-14"></div>

    </div>

@endsection
