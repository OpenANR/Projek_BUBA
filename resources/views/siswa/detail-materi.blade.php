@extends('layouts.siswa.app')

@section('title', 'Detail Materi - BUBA')

@section('content')

@php
    $palettes = [
        ['bg' => 'bg-[#71bf4f]', 'hover' => 'hover:bg-[#62aa43]', 'text' => 'text-[#4b9631]'],
        ['bg' => 'bg-[#faa63a]', 'hover' => 'hover:bg-[#e89427]', 'text' => 'text-[#b87513]'],
        ['bg' => 'bg-[#d8759c]', 'hover' => 'hover:bg-[#ca5e88]', 'text' => 'text-[#b34f79]'],
        ['bg' => 'bg-[#5ebef3]', 'hover' => 'hover:bg-[#47ade7]', 'text' => 'text-[#1e60be]'],
        ['bg' => 'bg-[#9c65cd]', 'hover' => 'hover:bg-[#894fc0]', 'text' => 'text-[#7944a6]'],
        ['bg' => 'bg-[#ffd629]', 'hover' => 'hover:bg-[#f0c313]', 'text' => 'text-[#967500]'],
        ['bg' => 'bg-[#3cbdb1]', 'hover' => 'hover:bg-[#2fa89d]', 'text' => 'text-[#218b82]'],
        ['bg' => 'bg-[#f36b6b]', 'hover' => 'hover:bg-[#df5555]', 'text' => 'text-[#c74646]'],
    ];

    $kontenAktif = request()->route('konten');

    // URL kembali ke daftar materi
    $urlDaftarMateri = route('siswa.materi', [
        'konten' => $kontenAktif,
        'kelas' => trim($kelas->nama_kelas),
        'kategori' => $kategori->slug,
    ]);

    // Menghitung nomor materi berdasarkan urutan ID
    $daftarMateri = \App\Models\Materi::where('kelas_id', $kelas->id)
        ->where('kategori_id', $kategori->id)
        ->orderBy('id')
        ->get();

    $nomorMateri = $daftarMateri->search(
        fn ($materi) => $materi->id == $dataMateri->id
    );

    $nomorMateri = $nomorMateri === false ? 1 : $nomorMateri + 1;

    // Mengambil gambar materi, mendukung path biasa atau JSON
    $gambar = $dataMateri->gambar ?? null;

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

    $palette = $palettes[0];
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
            href="{{ $urlDaftarMateri }}"
            class="group flex h-12 w-12 items-center justify-center rounded-full border-[4px] border-white bg-[#5ebef3] text-white shadow-[0_6px_14px_rgba(0,0,0,0.18)] transition-all duration-200 hover:scale-110 hover:bg-[#47ade7] hover:shadow-xl active:scale-90 sm:h-14 sm:w-14 md:h-16 md:w-16 md:border-[5px]"
            aria-label="Kembali ke daftar materi"
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
            <h1 class="text-center font-sans text-xl font-black tracking-wider text-white drop-shadow-[0_2px_4px_rgba(0,0,0,0.3)] sm:text-2xl md:text-3xl lg:text-[2.6rem]">
                MATERI KELAS {{ strtoupper($kelas->nama_kelas ?? 'ANAK') }}
            </h1>
        </div>
    </header>

    <main class="relative z-10 mx-auto w-full max-w-5xl">

        {{-- Informasi Materi --}}
        <div class="mb-6 text-center">
            <h2 class="mb-3 text-2xl font-black text-white drop-shadow-[0_3px_3px_rgba(0,0,0,0.4)] sm:text-3xl md:text-4xl">
                Yuk, Belajar Bersama! 🌈
            </h2>

            <p class="inline-block rounded-full border-[3px] border-white bg-white/95 px-5 py-2 text-sm font-black text-[#1e60be] shadow-md sm:text-base">
                Kategori: {{ $kategori->nama_kategori ?? 'Pembelajaran' }}
            </p>

            <p class="mt-3 font-bold text-white drop-shadow-[0_2px_3px_rgba(0,0,0,0.5)]">
                Pelajari materi berikut dengan semangat!
            </p>
        </div>

        {{-- Card Detail Materi --}}
        <section class="overflow-hidden rounded-[2rem] border-[5px] border-white bg-white/95 p-5 text-center shadow-[0_12px_24px_rgba(0,0,0,0.18)] transition-all duration-300 sm:rounded-[2.4rem] sm:border-[6px] sm:p-8">

            {{-- Nomor Materi --}}
            <div class="mb-5 inline-block rounded-full border-[3px] border-white bg-[#1e60be] px-6 py-2 text-sm font-black tracking-wide text-white shadow-md sm:text-base">
                Materi {{ $nomorMateri }}
            </div>

            {{-- Nama Materi --}}
            <h2 class="mx-auto mb-6 max-w-3xl text-2xl font-black leading-relaxed text-slate-800 sm:text-3xl">
                {{ $dataMateri->nama_materi }}
            </h2>

            {{-- Gambar Materi --}}
            @if (count($gambar) > 0)
                <div class="mb-7 flex flex-wrap items-center justify-center gap-4">
                    @foreach ($gambar as $file)
                        <div class="flex w-full max-w-2xl items-center justify-center overflow-hidden rounded-[1.5rem] border-[4px] border-white bg-[#eaf5ff] p-3 shadow-md">
                            <img
                                src="{{ asset('storage/' . $file) }}"
                                alt="{{ $dataMateri->nama_materi }}"
                                class="max-h-[420px] w-full rounded-xl object-contain"
                                onerror="this.style.display='none'"
                            >
                        </div>
                    @endforeach
                </div>
            @else
                <div class="mb-7 flex h-44 items-center justify-center rounded-[1.5rem] border-[4px] border-white bg-[#eaf5ff] shadow-inner sm:h-56">
                    <span class="text-7xl">📚</span>
                </div>
            @endif

            {{-- Isi Materi --}}
            <div class="mb-6 rounded-[1.5rem] border-[4px] border-white bg-[#eaf5ff] p-5 text-left shadow-sm sm:p-7">
                <div class="mb-4 flex items-center gap-3">
                    <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full border-2 border-white bg-[#5ebef3] text-2xl shadow-sm">
                        📖
                    </span>

                    <h3 class="text-xl font-black text-[#1e60be] sm:text-2xl">
                        Isi Materi
                    </h3>
                </div>

                <div class="whitespace-pre-line break-words text-base font-medium leading-8 text-slate-700 sm:text-lg">
                    {{ $dataMateri->isi_materi ?: 'Isi materi belum tersedia.' }}
                </div>
            </div>

            {{-- Audio Materi --}}
            @if ($dataMateri->audio)
                <div class="mb-6 rounded-[1.5rem] border-[4px] border-white bg-[#fff7d6] p-5 text-left shadow-sm sm:p-7">
                    <div class="mb-4 flex items-center gap-3">
                        <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full border-2 border-white bg-[#ffd629] text-2xl shadow-sm">
                            🎵
                        </span>

                        <h3 class="text-xl font-black text-[#967500] sm:text-2xl">
                            Dengarkan Materi
                        </h3>
                    </div>

                    <audio controls preload="metadata" class="w-full">
                        <source src="{{ asset('storage/' . $dataMateri->audio) }}">
                        Browser kamu tidak mendukung pemutar audio.
                    </audio>
                </div>
            @endif

            {{-- Tombol Navigasi --}}
            <div class="mt-7 flex flex-wrap justify-center gap-3 sm:gap-4">
                <a
                    href="{{ $urlDaftarMateri }}"
                    class="inline-flex items-center justify-center gap-2 rounded-2xl border-[4px] border-white bg-[#5ebef3] px-6 py-3 font-black text-white shadow-lg transition hover:-translate-y-1 hover:scale-105 hover:bg-[#47ade7] active:scale-95 sm:px-8"
                >
                    ← Daftar Materi
                </a>

                <a
                    href="{{ route('siswa.konten') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-2xl border-[4px] border-white bg-[#71bf4f] px-6 py-3 font-black text-white shadow-lg transition hover:-translate-y-1 hover:scale-105 hover:bg-[#62aa43] active:scale-95 sm:px-8"
                >
                    Beranda 🏠
                </a>
            </div>

        </section>

        {{-- Footer --}}
        <p class="my-8 text-center text-sm font-black text-white drop-shadow-[0_2px_3px_rgba(0,0,0,0.5)]">
            BUBA • Belajar sambil bermain 🌈
        </p>

    </main>
</div>

@endsection