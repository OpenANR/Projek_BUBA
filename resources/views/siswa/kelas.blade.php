@extends('layouts.siswa.app')

@section('title', 'Pilih Kelas - BUBA')

@section('content')
    <!-- Container Utama (Fullscreen responsif) -->
    <div class="relative flex h-screen min-h-[600px] w-full flex-col items-center justify-between overflow-x-hidden overflow-y-auto px-4 py-5 select-none sm:overflow-hidden sm:px-6 md:px-8">

        <!-- Background Image -->
        <img src="{{ asset('images/backgroundSplash.png') }}" alt="BUBA Background"
            class="pointer-events-none absolute inset-0 z-0 h-full w-full select-none object-cover object-bottom">

        <!-- Tombol Kembali (Top Left) -->
        <div class="absolute left-4 top-4 z-30 sm:left-6 sm:top-6 md:left-8 md:top-8">
            <a href="{{ route('siswa.konten') }}"
                class="group flex h-12 w-12 items-center justify-center rounded-full border-[4px] border-white bg-[#5ebef3] text-white shadow-[0_6px_14px_rgba(0,0,0,0.18)] transition-all duration-200 hover:scale-110 hover:bg-[#47ade7] hover:shadow-xl active:scale-90 active:translate-y-0.5 focus:outline-none focus:ring-4 focus:ring-white/70 sm:h-14 sm:w-14 md:h-16 md:w-16 md:border-[5px]"
                aria-label="Kembali ke pilihan konten">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                    class="h-6 w-6 text-white transition-transform duration-200 group-hover:-translate-x-0.5 sm:h-7 sm:w-7 md:h-8 md:w-8">
                    <path d="M16 5.5a1 1 0 0 0-1.6-.8l-9 7a1 1 0 0 0 0 1.6l9 7A1 1 0 0 0 16 19.5V5.5z" />
                </svg>
            </a>
        </div>

        <!-- Header Banner: PILIH KELAS (Center Top) -->
        <div class="relative z-10 flex items-center justify-center pt-2 sm:pt-4 md:pt-6">
            <div class="rounded-2xl border-[4px] border-white bg-[#1e60be] px-7 py-2 shadow-[0_8px_20px_rgba(0,0,0,0.2)] transition-transform duration-300 hover:scale-105 sm:rounded-[2rem] sm:border-[5px] sm:px-10 sm:py-3 md:rounded-[2.2rem] md:border-[6px] md:px-14 md:py-3.5">
                <h1 class="text-center font-sans text-2xl font-black tracking-wider text-white drop-shadow-[0_2px_4px_rgba(0,0,0,0.3)] sm:text-3xl md:text-4xl lg:text-[2.6rem]">
                    PILIH KELAS
                </h1>
            </div>
        </div>

        <!-- Pilihan Kelas (Center) -->
        @if ($kelas->isNotEmpty())
            <div class="relative z-10 my-auto flex w-full max-w-4xl items-center justify-center gap-4 px-2 py-4 sm:gap-8 md:gap-12">
                @foreach ($kelas as $item)
                    <a href="{{ route('siswa.kategori', ['konten' => $konten, 'kelas' => trim($item->nama_kelas)]) }}"
                        class="group relative flex aspect-square w-[min(40vw,8rem)] shrink-0 items-center justify-center rounded-[1.7rem] border-[5px] border-white bg-[#d8759c] px-3 text-center text-3xl font-black text-white shadow-[0_10px_20px_rgba(0,0,0,0.18)] transition-all duration-300 ease-out hover:scale-105 hover:-translate-y-2 hover:bg-[#ca5e88] hover:shadow-[0_18px_30px_rgba(216,117,156,0.45)] active:scale-95 active:translate-y-1 active:shadow-md focus:outline-none focus:ring-4 focus:ring-white/70 sm:w-44 sm:rounded-[2rem] sm:border-[6px] sm:text-4xl md:w-52 md:rounded-[2.4rem] md:border-8 md:text-5xl lg:w-56"
                        aria-label="Pilih kelas {{ $item->nama_kelas }}">
                        {{ $item->nama_kelas }}
                    </a>
                @endforeach
            </div>
        @else
            <p class="relative z-10 my-auto rounded-2xl border-4 border-white bg-white/90 px-6 py-4 text-center font-semibold text-slate-700 shadow-lg">
                Akun kamu belum terdaftar di kelas mana pun.
            </p>
        @endif

        <!-- Spacer Bawah (Menjaga ilustrasi rumput tetap terlihat) -->
        <div class="relative z-10 h-6 shrink-0 sm:h-10 md:h-14"></div>
    </div>
@endsection