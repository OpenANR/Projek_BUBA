@extends('layouts.siswa.app')

@section('title', 'Materi - BUBA')

@section('content')

@php
    $palettes = [
        ['bg' => 'bg-[#71bf4f]', 'hover' => 'hover:bg-[#62aa43]', 'shadow' => 'hover:shadow-[0_22px_36px_rgba(113,191,79,0.45)]'],
        ['bg' => 'bg-[#faa63a]', 'hover' => 'hover:bg-[#e89427]', 'shadow' => 'hover:shadow-[0_22px_36px_rgba(250,166,58,0.45)]'],
        ['bg' => 'bg-[#d8759c]', 'hover' => 'hover:bg-[#ca5e88]', 'shadow' => 'hover:shadow-[0_22px_36px_rgba(216,117,156,0.45)]'],
        ['bg' => 'bg-[#5ebef3]', 'hover' => 'hover:bg-[#47ade7]', 'shadow' => 'hover:shadow-[0_22px_36px_rgba(94,190,243,0.45)]'],
        ['bg' => 'bg-[#9c65cd]', 'hover' => 'hover:bg-[#894fc0]', 'shadow' => 'hover:shadow-[0_22px_36px_rgba(156,101,205,0.45)]'],
        ['bg' => 'bg-[#ffd629]', 'hover' => 'hover:bg-[#f0c313]', 'shadow' => 'hover:shadow-[0_22px_36px_rgba(255,214,41,0.45)]'],
        ['bg' => 'bg-[#3cbdb1]', 'hover' => 'hover:bg-[#2fa89d]', 'shadow' => 'hover:shadow-[0_22px_36px_rgba(60,189,177,0.45)]'],
        ['bg' => 'bg-[#f36b6b]', 'hover' => 'hover:bg-[#df5555]', 'shadow' => 'hover:shadow-[0_22px_36px_rgba(243,107,107,0.45)]'],
    ];

    $ikonMateri = ['📚', '🎨', '🧩', '🌈', '⭐', '🎵', '🐻', '🎯'];

    $daftarMateri = $dataMateri ?? collect();
@endphp

<div class="relative flex min-h-screen w-full flex-col items-center overflow-x-hidden px-4 py-5 select-none sm:px-6 md:px-8">

    {{-- Background BUBA --}}
    <img
        src="{{ asset('images/backgroundSplash.png') }}"
        alt="BUBA Background"
        class="pointer-events-none fixed inset-0 z-0 h-full w-full select-none object-cover object-bottom"
    >

    {{-- Tombol Kembali --}}
    <div class="absolute left-4 top-4 z-30 sm:left-6 sm:top-6 md:left-8 md:top-8">
        <a
            href="{{ route('siswa.kategori', [
                'konten' => request()->route('konten'),
                'kelas' => trim($kelas->nama_kelas)
            ]) }}"
            class="group flex h-12 w-12 items-center justify-center rounded-full border-[4px] border-white bg-[#5ebef3] text-white shadow-[0_6px_14px_rgba(0,0,0,0.18)] transition-all duration-200 hover:scale-110 hover:bg-[#47ade7] hover:shadow-xl active:scale-90 sm:h-14 sm:w-14 md:h-16 md:w-16 md:border-[5px]"
            aria-label="Kembali"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                fill="currentColor"
                class="h-6 w-6 transition-transform duration-200 group-hover:-translate-x-1 sm:h-7 sm:w-7 md:h-8 md:w-8"
            >
                <path d="M16 5.5a1 1 0 0 0-1.6-.8l-9 7a1 1 0 0 0 0 1.6l9 7A1 1 0 0 0 16 19.5V5.5z"/>
            </svg>
        </a>
    </div>

    {{-- Header Banner --}}
    <header class="relative z-10 mb-7 flex items-center justify-center pt-2 sm:pt-4 md:pt-6">
        <div class="rounded-2xl border-[4px] border-white bg-[#1e60be] px-7 py-2 shadow-[0_8px_20px_rgba(0,0,0,0.2)] transition-transform duration-300 hover:scale-105 sm:rounded-[2rem] sm:border-[5px] sm:px-10 sm:py-3 md:rounded-[2.2rem] md:border-[6px] md:px-14 md:py-3.5">
            <h1 class="text-center font-sans text-2xl font-black tracking-wider text-white drop-shadow-[0_2px_4px_rgba(0,0,0,0.3)] sm:text-3xl md:text-4xl lg:text-[2.6rem]">
                MATERI KELAS {{ strtoupper($kelas->nama_kelas) }}
            </h1>
        </div>
    </header>

    {{-- Konten Halaman Materi --}}
    <main class="relative z-10 mx-auto my-auto w-full max-w-6xl">

        {{-- Informasi Materi --}}
        <div class="mb-8 text-center">
            <h2 class="mb-3 text-2xl font-black text-white drop-shadow-[0_3px_3px_rgba(0,0,0,0.4)] sm:text-3xl md:text-4xl">
                📚 PILIH MATERI!
            </h2>

            <p class="font-bold text-white drop-shadow-[0_2px_3px_rgba(0,0,0,0.5)]">
                Yuk, pilih materi dan mulai belajar!
            </p>

            <div class="mt-4 inline-block rounded-full border-[3px] border-white bg-white/95 px-6 py-2 text-sm font-black text-[#1e60be] shadow-md sm:text-base">
                {{ strtoupper($kategori->nama_kategori) }}
            </div>
        </div>

        {{-- Daftar Card Materi --}}
        @if ($daftarMateri->isNotEmpty())

            <div class="flex w-full flex-wrap items-center justify-center gap-5 px-2 py-4 sm:gap-8 md:gap-10">

                @foreach ($daftarMateri as $index => $item)

                    @php
                        $palette = $palettes[$index % count($palettes)];
                        $ikon = $ikonMateri[$index % count($ikonMateri)];

                        $gambar = $item->gambar ?? null;

                        // Mendukung gambar berupa path biasa atau JSON
                        if (is_string($gambar)) {
                            $decoded = json_decode($gambar, true);

                            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                                $gambar = $decoded;
                            } elseif (trim($gambar) !== '') {
                                $gambar = [$gambar];
                            } else {
                                $gambar = [];
                            }
                        }

                        if (!is_array($gambar)) {
                            $gambar = [];
                        }

                        $gambar = array_values(array_filter(
                            $gambar,
                            fn ($file) => is_string($file) && trim($file) !== ''
                        ));

                        $gambarUtama = $gambar[0] ?? null;
                    @endphp

                    <a
                        href="{{ route('siswa.showMateri', [
                            'konten' => request()->route('konten'),
                            'kelas' => trim($kelas->nama_kelas),
                            'kategori' => $kategori->slug,
                            'materi' => $item->kode_materi,
                        ]) }}"
                        class="group relative flex h-60 w-48 flex-col items-center justify-between overflow-hidden rounded-[2rem] border-[5px] border-white {{ $palette['bg'] }} p-5 shadow-[0_12px_24px_rgba(0,0,0,0.18)] transition-all duration-300 ease-out hover:-translate-y-2.5 hover:scale-105 {{ $palette['hover'] }} {{ $palette['shadow'] }} active:scale-95 sm:h-72 sm:w-56 sm:rounded-[2.4rem] sm:border-[6px] sm:p-6 md:h-80 md:w-64 md:rounded-[2.8rem] md:border-8 md:p-7"
                    >

                        {{-- Hiasan Card --}}
                        <div class="pointer-events-none absolute -right-7 -top-7 h-24 w-24 rounded-full bg-white/20"></div>
                        <div class="pointer-events-none absolute -bottom-8 -left-7 h-28 w-28 rounded-full bg-white/20"></div>

                        {{-- Gambar atau Ikon Materi --}}
                        <div class="relative flex w-full flex-1 items-center justify-center overflow-hidden">

                            @if ($gambarUtama)
                                <img
                                    src="{{ asset('storage/' . $gambarUtama) }}"
                                    alt="{{ $item->nama_materi }}"
                                    class="max-h-32 max-w-full rounded-2xl border-2 border-white/70 object-contain shadow-md transition-all duration-300 group-hover:-translate-y-1 group-hover:rotate-2 group-hover:scale-110 sm:max-h-40 md:max-h-44"
                                >
                            @else
                                <span class="text-6xl drop-shadow-md transition-all duration-300 group-hover:-translate-y-1 group-hover:rotate-6 group-hover:scale-110 sm:text-7xl md:text-8xl">
                                    {{ $ikon }}
                                </span>
                            @endif

                        </div>

                        {{-- Informasi Materi --}}
                        <div class="relative w-full text-center">

                            {{-- Nomor Materi Ditampilkan Terlebih Dahulu --}}
                            <p class="mb-2 text-sm font-black text-white drop-shadow-[0_2px_3px_rgba(0,0,0,0.4)] sm:text-base">
                                Materi {{ $index + 1 }}
                            </p>

                            {{-- Judul Materi di Bawah Nomor --}}
                            <h3 class="line-clamp-2 text-xl font-black tracking-wide text-white drop-shadow-[0_2px_4px_rgba(0,0,0,0.25)] sm:text-2xl">
                                {{ $item->nama_materi }}
                            </h3>

                            {{-- Tombol Lihat Materi --}}
                            <div class="mt-4 inline-flex items-center gap-2 rounded-full border-2 border-white bg-white px-4 py-2 text-sm font-black text-[#1e60be] shadow-md transition-all duration-200 group-hover:bg-[#ffd629] sm:px-5">
                                Lihat Materi
                                <span>➜</span>
                            </div>

                        </div>

                    </a>

                @endforeach

            </div>

        @else

            {{-- Jika Materi Belum Tersedia --}}
            <div class="mx-auto flex max-w-md flex-col items-center justify-center rounded-[2rem] border-[5px] border-white bg-white/95 px-8 py-8 text-center shadow-[0_10px_25px_rgba(0,0,0,0.18)]">

                <span class="mb-3 text-6xl">📚</span>

                <h3 class="text-xl font-black text-[#1e60be] sm:text-2xl">
                    Belum Ada Materi
                </h3>

                <p class="mt-2 text-sm font-semibold text-slate-600">
                    Materi untuk kategori ini belum tersedia. Yuk, coba lagi nanti!
                </p>

            </div>

        @endif

    </main>

    {{-- Footer --}}
    <p class="relative z-10 my-8 text-center text-sm font-black text-white drop-shadow-[0_2px_3px_rgba(0,0,0,0.5)]">
        BUBA • Belajar sambil bermain 🌈
    </p>

</div>

@endsection