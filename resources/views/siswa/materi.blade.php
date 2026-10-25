@extends('layouts.siswa.app')

@section('title', 'Materi - BUBA')

@section('content')
<div class="relative flex min-h-screen w-full flex-col overflow-x-hidden px-4 py-5 select-none sm:px-6 md:px-8">

    {{-- Background BUBA --}}
    <img src="{{ asset('images/backgroundSplash.png') }}"
        alt="BUBA Background"
        class="pointer-events-none fixed inset-0 z-0 h-full w-full object-cover object-bottom">

    {{-- Tombol Kembali --}}
    <div class="absolute left-4 top-4 z-30 sm:left-6 sm:top-6 md:left-8 md:top-8">
        <a href="javascript:history.back()"
            class="group flex h-12 w-12 items-center justify-center rounded-full border-4 border-white bg-[#5ebef3] text-white shadow-lg transition hover:scale-110 hover:bg-[#47ade7] active:scale-90 sm:h-14 sm:w-14 md:h-16 md:w-16"
            aria-label="Kembali">

            <svg xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                fill="currentColor"
                class="h-6 w-6 transition-transform group-hover:-translate-x-1 sm:h-7 sm:w-7 md:h-8 md:w-8">
                <path d="M16 5.5a1 1 0 0 0-1.6-.8l-9 7a1 1 0 0 0 0 1.6l9 7A1 1 0 0 0 16 19.5V5.5z"/>
            </svg>
        </a>
    </div>

    {{-- Header Kelas --}}
    <header class="relative z-10 mb-7 flex items-center justify-center pt-2 sm:pt-4 md:pt-6">
        <div class="rounded-2xl border-4 border-white bg-[#1e60be] px-7 py-3 shadow-lg sm:rounded-[2rem] sm:border-[5px] sm:px-10 md:rounded-[2.2rem] md:border-[6px] md:px-14">

            <h1 class="text-center font-sans text-xl font-black tracking-wider text-white drop-shadow sm:text-2xl md:text-3xl">
                MATERI {{ strtoupper($kelas->nama_kelas ?? 'ANAK') }}
            </h1>
        </div>
    </header>

    <main class="relative z-10 mx-auto w-full max-w-3xl">

        {{-- Judul Materi --}}
        <div class="mb-6 text-center">
            <h2 class="mb-2 text-2xl font-black text-white drop-shadow-[0_3px_3px_rgba(0,0,0,0.4)] sm:text-3xl">
                Yuk, Belajar Bersama! 📚
            </h2>

            <p class="inline-block rounded-full border-2 border-white bg-white/90 px-5 py-2 text-sm font-bold text-[#1e60be] shadow-md sm:text-base">
                Kategori:
                {{ $kategori->nama_kategori ?? 'Pembelajaran' }}
            </p>
        </div>

        {{-- Daftar Materi --}}
        @if(isset($materis) && $materis->count() > 0)

            <div class="mb-5 rounded-2xl border-2 border-white bg-white/80 p-4 text-center shadow-md">
                <p class="font-black text-[#1e60be]">
                    📖 Ada {{ $materis->count() }} materi yang bisa kamu pelajari!
                </p>
            </div>

            @foreach($materis as $index => $item)

                @php
                    // Mengambil gambar materi
                    $gambar = $item->gambar ?? [];

                    // Jika gambar berbentuk teks JSON, ubah menjadi array
                    if (is_string($gambar)) {
                        $decoded = json_decode($gambar, true);

                        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                            $gambar = $decoded;
                        } else {
                            $gambar = trim($gambar) !== '' ? [$gambar] : [];
                        }
                    }

                    // Pastikan gambar berbentuk array
                    if (!is_array($gambar)) {
                        $gambar = [];
                    }

                    // Menghapus data gambar kosong
                    $gambar = array_values(array_filter($gambar, function ($file) {
                        return is_string($file) && trim($file) !== '';
                    }));

                    // Mengambil audio materi
                    $audioMateri = $item->audio ?? null;
                @endphp

                <section class="mb-6 overflow-hidden rounded-[1.7rem] border-4 border-white bg-white/95 shadow-[0_10px_25px_rgba(0,0,0,0.18)] sm:rounded-[2rem]">

                    {{-- Header Kartu Materi --}}
                    <div class="bg-[#1e60be] px-5 py-4 text-center sm:px-7">
                        <span class="mb-2 inline-block rounded-full border-2 border-white bg-[#ffd629] px-4 py-1 text-sm font-black text-[#493b00] shadow">
                            MATERI {{ $index + 1 }}
                        </span>

                        <h3 class="text-xl font-black leading-relaxed text-white sm:text-2xl">
                            {{ $item->nama_materi ?? 'Materi Pembelajaran' }}
                        </h3>
                    </div>

                    <div class="p-5 sm:p-7">

                        {{-- Gambar Materi --}}
                        @if(count($gambar) > 0)
                            <div class="mb-5 flex flex-wrap items-center justify-center gap-3">
                                @foreach($gambar as $file)
                                    <img
                                        src="{{ asset('storage/' . $file) }}"
                                        alt="Gambar {{ $item->nama_materi }}"
                                        class="max-h-64 w-auto max-w-full rounded-2xl border-4 border-white bg-sky-50 object-contain p-1 shadow-md"
                                        onerror="this.style.display='none'">
                                @endforeach
                            </div>
                        @else
                            <div class="mb-5 flex justify-center">
                                <div class="flex h-24 w-24 items-center justify-center rounded-3xl border-4 border-white bg-[#dff4ff] text-5xl shadow-md">
                                    📚
                                </div>
                            </div>
                        @endif

                        {{-- Isi Materi --}}
                        <div class="rounded-2xl border-2 border-sky-100 bg-sky-50 p-4 sm:p-5">
                            <h4 class="mb-3 text-lg font-black text-[#1e60be]">
                                🌈 Ayo Kita Pelajari!
                            </h4>

                            <div class="whitespace-pre-line break-words text-base font-semibold leading-relaxed text-slate-700">
                                {{ $item->isi_materi ?? 'Materi pembelajaran belum memiliki isi.' }}
                            </div>
                        </div>

                        {{-- Audio Materi --}}
                        @if($audioMateri)
                            <div class="mt-5 flex flex-col items-center">
                                <p class="mb-3 text-center font-bold text-[#1e60be]">
                                    🔊 Dengarkan materi ini, yuk!
                                </p>

                                <audio controls preload="none"
                                    class="w-full max-w-md">
                                    <source src="{{ asset('storage/' . $audioMateri) }}">
                                    Browser kamu belum mendukung pemutaran audio.
                                </audio>
                            </div>
                        @endif

                        {{-- Pesan Penyemangat --}}
                        <div class="mt-5 rounded-2xl border-2 border-white bg-[#fff4bd] p-4 text-center shadow-sm">
                            <p class="font-black text-[#735800]">
                                ⭐ Hebat! Terus semangat belajar, ya! ⭐
                            </p>
                        </div>

                    </div>
                </section>

            @endforeach

        @else

            {{-- Jika Belum Ada Materi --}}
            <section class="rounded-[2rem] border-4 border-white bg-white/90 px-5 py-8 text-center shadow-xl sm:px-8">

                <div class="mb-3 text-5xl">📚</div>

                <h2 class="mb-3 text-2xl font-black text-[#1e60be]">
                    Belum Ada Materi
                </h2>

                <p class="mb-6 font-semibold leading-relaxed text-slate-700">
                    Materi untuk kelas dan kategori ini belum tersedia.
                    Yuk, coba kategori pembelajaran lainnya!
                </p>

                <a href="{{ route('siswa.konten') }}"
                    class="inline-block rounded-2xl border-4 border-white bg-[#d8759c] px-8 py-3 font-black text-white shadow-lg transition hover:scale-105 hover:bg-[#ca5e88]">
                    Kembali
                </a>
            </section>

        @endif

        {{-- Tombol Kembali ke Pilihan Konten --}}
        <div class="my-6 flex justify-center">
            <a href="{{ route('siswa.konten') }}"
                class="rounded-2xl border-4 border-white bg-[#ffd629] px-6 py-3 font-black text-[#493b00] shadow-lg transition hover:-translate-y-1 hover:scale-105 active:scale-95 sm:px-8">
                🏠 Kembali ke Pilihan Konten
            </a>
        </div>

        {{-- Footer --}}
        <p class="my-6 text-center text-sm font-black text-white drop-shadow-[0_2px_3px_rgba(0,0,0,0.5)]">
            BUBA • Belajar sambil bermain 🌈
        </p>

    </main>
</div>
@endsection