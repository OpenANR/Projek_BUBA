@extends('layouts.siswa.app')

@section('title', 'Paket Kuis - BUBA')

@section('content')

@php
    $palettes = [
        [
            'bg' => 'bg-[#71bf4f]',
            'hover_bg' => 'hover:bg-[#62aa43]',
            'shadow' => 'hover:shadow-[0_22px_36px_rgba(113,191,79,0.45)]',
            'base_shadow' => 'shadow-[0_12px_24px_rgba(0,0,0,0.18)]',
        ],
        [
            'bg' => 'bg-[#faa63a]',
            'hover_bg' => 'hover:bg-[#e89427]',
            'shadow' => 'hover:shadow-[0_22px_36px_rgba(250,166,58,0.45)]',
            'base_shadow' => 'shadow-[0_12px_24px_rgba(0,0,0,0.18)]',
        ],
        [
            'bg' => 'bg-[#d8759c]',
            'hover_bg' => 'hover:bg-[#ca5e88]',
            'shadow' => 'hover:shadow-[0_22px_36px_rgba(216,117,156,0.45)]',
            'base_shadow' => 'shadow-[0_12px_24px_rgba(0,0,0,0.18)]',
        ],
        [
            'bg' => 'bg-[#5ebef3]',
            'hover_bg' => 'hover:bg-[#47ade7]',
            'shadow' => 'hover:shadow-[0_22px_36px_rgba(94,190,243,0.45)]',
            'base_shadow' => 'shadow-[0_12px_24px_rgba(0,0,0,0.18)]',
        ],
        [
            'bg' => 'bg-[#9c65cd]',
            'hover_bg' => 'hover:bg-[#894fc0]',
            'shadow' => 'hover:shadow-[0_22px_36px_rgba(156,101,205,0.45)]',
            'base_shadow' => 'shadow-[0_12px_24px_rgba(0,0,0,0.18)]',
        ],
        [
            'bg' => 'bg-[#ffd629]',
            'hover_bg' => 'hover:bg-[#f0c313]',
            'shadow' => 'hover:shadow-[0_22px_36px_rgba(255,214,41,0.45)]',
            'base_shadow' => 'shadow-[0_12px_24px_rgba(0,0,0,0.18)]',
        ],
        [
            'bg' => 'bg-[#3cbdb1]',
            'hover_bg' => 'hover:bg-[#2fa89d]',
            'shadow' => 'hover:shadow-[0_22px_36px_rgba(60,189,177,0.45)]',
            'base_shadow' => 'shadow-[0_12px_24px_rgba(0,0,0,0.18)]',
        ],
        [
            'bg' => 'bg-[#f36b6b]',
            'hover_bg' => 'hover:bg-[#df5555]',
            'shadow' => 'hover:shadow-[0_22px_36px_rgba(243,107,107,0.45)]',
            'base_shadow' => 'shadow-[0_12px_24px_rgba(0,0,0,0.18)]',
        ],
    ];

    $icons = ['📚', '🎨', '🧩', '🌈', '⭐', '🎵', '🐻', '🎯'];

    $urlDaftarKuis = route('siswa.kuis', [
        'konten' => request()->route('konten'),
        'kelas' => trim($kelas->nama_kelas),
        'kategori' => $kategori->slug,
    ]);
@endphp

<div class="relative flex min-h-screen w-full flex-col items-center overflow-x-hidden overflow-y-auto px-4 py-5 select-none sm:px-6 md:px-8">

    {{-- Background BUBA --}}
    <img
        src="{{ asset('images/backgroundSplash.png') }}"
        alt="BUBA Background"
        class="pointer-events-none fixed inset-0 z-0 h-full w-full select-none object-cover object-bottom"
    >

    {{-- Tombol Kembali --}}
    <div class="absolute left-4 top-4 z-30 sm:left-6 sm:top-6 md:left-8 md:top-8">

        <a href="javascript:history.back()"
            class="group flex h-12 w-12 items-center justify-center rounded-full border-[4px] border-white bg-[#5ebef3] text-white shadow-[0_6px_14px_rgba(0,0,0,0.18)] transition-all duration-200 hover:scale-110 hover:bg-[#47ade7] hover:shadow-xl active:scale-90 sm:h-14 sm:w-14 md:h-16 md:w-16 md:border-[5px]"
            aria-label="Kembali">

            <svg xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                fill="currentColor"
                class="h-6 w-6 text-white drop-shadow transition-transform duration-200 group-hover:-translate-x-0.5 sm:h-7 sm:w-7 md:h-8 md:w-8">

                <path d="M16 5.5a1 1 0 0 0-1.6-.8l-9 7a1 1 0 0 0 0 1.6l9 7A1 1 0 0 0 16 19.5V5.5z" />

            </svg>

        </a>

    </div>

    {{-- Header --}}
    <div class="relative z-10 flex items-center justify-center pt-2 sm:pt-4 md:pt-6">

        <div class="rounded-2xl border-[4px] border-white bg-[#1e60be] px-7 py-2 shadow-[0_8px_20px_rgba(0,0,0,0.2)] transition-transform duration-300 hover:scale-105 sm:rounded-[2rem] sm:border-[5px] sm:px-10 sm:py-3 md:rounded-[2.2rem] md:border-[6px] md:px-14 md:py-3.5">

            <h1 class="text-center font-sans text-2xl font-black tracking-wider text-white drop-shadow-[0_2px_4px_rgba(0,0,0,0.3)] sm:text-3xl md:text-4xl lg:text-[2.6rem]">
                KUIS KELAS {{ strtoupper($kelas->nama_kelas) }}
            </h1>

        </div>

    </div>

    {{-- HALAMAN DAFTAR PAKET KUIS --}}
    <div id="packagePage" class="relative z-10 my-auto flex w-full flex-col items-center">

        <div class="mb-5 mt-8 text-center sm:mt-10">

            <h2 class="text-2xl font-black tracking-wide text-[#1e60be] drop-shadow-sm sm:text-3xl md:text-4xl">
                🎮 PILIH PAKET KUIS!
            </h2>

            <p class="mt-2 font-bold text-slate-700 sm:text-lg">
                Yuk, pilih permainan yang ingin kamu kerjakan! 🌈
            </p>

            <div class="mt-3 inline-block rounded-full border-[3px] border-white bg-[#ffd629] px-6 py-2 font-black uppercase tracking-wide text-[#704900] shadow-md">
                {{ $kategori->nama_kategori ?? 'Pembelajaran' }}
            </div>

        </div>

        @if(isset($paketKuis) && $paketKuis->count() > 0)

            <div class="flex w-full max-w-5xl flex-wrap items-center justify-center gap-5 px-2 py-4 sm:gap-8 md:gap-10">

                @foreach($paketKuis as $index => $paket)

                    @php
                        $palette = $palettes[$index % count($palettes)];
                        $icon = $icons[$index % count($icons)];
                    @endphp

                    <a href="{{ route('siswa.showKuis', [
                        'konten' => request()->route('konten'),
                        'kelas' => trim($kelas->nama_kelas),
                        'kategori' => $kategori->slug,
                        'kuis' => $paket->id
                    ]) }}"
                        class="group relative flex min-h-[240px] w-64 flex-col items-center justify-between rounded-[2rem] border-[5px] border-white p-5 {{ $palette['bg'] }} {{ $palette['hover_bg'] }} {{ $palette['base_shadow'] }} transition-all duration-300 ease-out hover:-translate-y-2.5 hover:scale-105 {{ $palette['shadow'] }} active:scale-95 active:translate-y-1 active:shadow-md focus:outline-none focus:ring-4 focus:ring-white/70 sm:min-h-[280px] sm:w-64 sm:rounded-[2.4rem] sm:border-[6px] sm:p-6 md:min-h-[320px] md:w-64 md:rounded-[2.8rem] md:border-8 md:p-7">

                        {{-- Ikon Paket --}}
                        <div class="flex w-full flex-1 items-center justify-center">

                            <span class="select-none text-6xl drop-shadow-md transition-all duration-300 ease-out group-hover:-translate-y-1 group-hover:scale-110 group-hover:-rotate-6 sm:text-7xl md:text-8xl">
                                {{ $icon }}
                            </span>

                        </div>

                        {{-- Nama Paket --}}
                        <div class="w-full">

                            <h3 class="w-full whitespace-normal break-words text-center font-sans text-lg font-black uppercase leading-tight tracking-wide text-white drop-shadow-[0_2px_4px_rgba(0,0,0,0.25)] sm:text-xl md:text-2xl">
                                {{ $paket->nama_kuis }}
                            </h3>

                            <p class="mt-3 text-center text-sm font-black text-white drop-shadow sm:text-base">
                                {{ $paket->jumlah_pertanyaan ?? 0 }} Pertanyaan
                            </p>

                        </div>

                    </a>

                @endforeach

            </div>

        @else

            <div class="relative z-10 my-auto flex max-w-md flex-col items-center justify-center rounded-[2rem] border-[5px] border-white bg-white/95 px-8 py-6 text-center shadow-[0_10px_25px_rgba(0,0,0,0.18)]">

                <span class="mb-2 text-6xl">📁</span>

                <p class="text-lg font-black text-[#1e60be]">
                    Belum Ada Paket Kuis
                </p>

                <p class="mt-1 text-sm font-semibold text-slate-600">
                    Paket kuis untuk kategori ini belum tersedia.
                </p>

            </div>

        @endif

        <div class="relative z-10 mt-5 h-6 shrink-0 sm:h-10 md:h-14"></div>

    </div>

    {{-- HALAMAN HASIL KUIS --}}
    <div id="resultPage" class="relative z-10 my-auto hidden w-full flex-col items-center px-2 py-6">

        <div class="mb-5 text-center">

            <h2 class="text-3xl font-black tracking-wider text-[#1e60be] drop-shadow-sm sm:text-4xl">
                HASIL KUIS 🎉
            </h2>

            <p class="mt-2 font-bold text-slate-700 sm:text-lg">
                Yeay! Kamu sudah menyelesaikan permainan! 🌈
            </p>

        </div>

        <div class="w-full max-w-3xl rounded-[2rem] border-[5px] border-white bg-[#fff8dc]/95 p-5 shadow-[0_12px_24px_rgba(0,0,0,0.18)] sm:rounded-[2.5rem] sm:border-[6px] sm:p-8">

            {{-- Piala --}}
            <div class="text-center">

                <div class="text-7xl drop-shadow-md sm:text-8xl">
                    🏆
                </div>

                <h3 class="mt-3 text-2xl font-black text-[#1e60be] sm:text-3xl">
                    Kuis Selesai!
                </h3>

                <p class="mt-2 font-bold text-slate-600">
                    Hebat sekali! Terus semangat belajar, ya!
                </p>

            </div>

            {{-- Nama Paket --}}
            <div class="mt-6 rounded-[1.8rem] border-[4px] border-white bg-[#5ebef3] p-4 text-center shadow-md sm:p-5">

                <p class="font-black tracking-wider text-white">
                    PAKET KUIS
                </p>

                <p id="hasilNamaPaket" class="mt-2 break-words whitespace-normal text-xl font-black uppercase text-white drop-shadow-md sm:text-2xl">
                    Nama Paket Kuis
                </p>

                <p id="hasilKategori" class="mt-1 font-bold text-white">
                    Kategori Pembelajaran
                </p>

            </div>

            {{-- Nilai --}}
            <div class="mt-5 rounded-[1.8rem] border-[4px] border-white bg-[#ffd629] p-5 text-center shadow-md sm:p-6">

                <p class="text-lg font-black tracking-wider text-[#704900]">
                    NILAI KAMU
                </p>

                <p id="hasilNilai" class="mt-1 text-7xl font-black text-white drop-shadow-[0_3px_5px_rgba(0,0,0,0.25)] sm:text-8xl">
                    0
                </p>

                <p id="pesanHasil" class="mt-2 font-black text-[#704900] sm:text-lg">
                    Kamu hebat! Terus semangat belajar! 🌈
                </p>

            </div>

            {{-- Rincian Jawaban --}}
            <div class="mt-5 grid grid-cols-1 gap-4 sm:grid-cols-3">

                <div class="rounded-[1.7rem] border-[4px] border-white bg-[#71bf4f] p-5 text-center shadow-md">

                    <div class="text-5xl">✅</div>

                    <p id="hasilBenar" class="mt-2 text-4xl font-black text-white">
                        0
                    </p>

                    <p class="font-black text-white">
                        Jawaban Benar
                    </p>

                </div>

                <div class="rounded-[1.7rem] border-[4px] border-white bg-[#f36b6b] p-5 text-center shadow-md">

                    <div class="text-5xl">❌</div>

                    <p id="hasilSalah" class="mt-2 text-4xl font-black text-white">
                        0
                    </p>

                    <p class="font-black text-white">
                        Jawaban Salah
                    </p>

                </div>

                <div class="rounded-[1.7rem] border-[4px] border-white bg-[#9c65cd] p-5 text-center shadow-md">

                    <div class="text-5xl">📝</div>

                    <p id="hasilTotal" class="mt-2 text-4xl font-black text-white">
                        0
                    </p>

                    <p class="font-black text-white">
                        Total Pertanyaan
                    </p>

                </div>

            </div>

            {{-- Pesan --}}
            <div class="mt-6 rounded-[1.5rem] border-[4px] border-white bg-[#3cbdb1] p-4 text-center shadow-md">

                <p class="font-black text-white sm:text-lg">
                    🌟 BUBA • Belajar sambil bermain! 🌟
                </p>

            </div>

            {{-- Kembali ke Daftar Paket --}}
            <div class="mt-7 flex justify-center">

                <a href="{{ $urlDaftarKuis }}"
                    onclick="sessionStorage.removeItem('hasilKuisBuba')"
                    class="group flex items-center justify-center gap-2 rounded-full border-[4px] border-white bg-[#71bf4f] px-7 py-4 text-center font-black text-white shadow-[0_6px_0_#4b9632] transition-all duration-200 hover:-translate-y-1 hover:bg-[#62aa43] hover:shadow-lg active:translate-y-1 active:shadow-none">

                    <span class="text-xl transition-transform group-hover:-translate-x-1">
                        ←
                    </span>

                    KEMBALI KE DAFTAR PAKET

                </a>

            </div>

        </div>

        <div class="mt-6 h-6 shrink-0 sm:h-10"></div>

    </div>

</div>

{{-- JAVASCRIPT HASIL KUIS --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const dataHasil = sessionStorage.getItem('hasilKuisBuba');

    // Jika belum ada hasil, tampilkan daftar paket
    if (!dataHasil) {
        return;
    }

    try {

        const hasil = JSON.parse(dataHasil);

        // Sembunyikan daftar paket
        document.getElementById('packagePage').classList.add('hidden');

        // Tampilkan halaman hasil
        const resultPage = document.getElementById('resultPage');
        resultPage.classList.remove('hidden');
        resultPage.classList.add('flex');

        // Tampilkan data hasil
        document.getElementById('hasilNilai').textContent = hasil.nilai ?? 0;
        document.getElementById('hasilBenar').textContent = hasil.benar ?? 0;
        document.getElementById('hasilSalah').textContent = hasil.salah ?? 0;
        document.getElementById('hasilTotal').textContent = hasil.total ?? 0;

        document.getElementById('hasilNamaPaket').textContent =
            hasil.namaPaket ?? 'Kuis BUBA';

        document.getElementById('hasilKategori').textContent =
            'Kategori: ' + (hasil.namaKategori ?? 'Pembelajaran');

        // Pesan berdasarkan nilai
        const nilai = Number(hasil.nilai ?? 0);
        const pesan = document.getElementById('pesanHasil');

        if (nilai === 100) {
            pesan.textContent = 'Wah, sempurna! Kamu pintar sekali! 🌟';
        } else if (nilai >= 80) {
            pesan.textContent = 'Hebat! Jawabanmu banyak yang benar! 🎉';
        } else if (nilai >= 60) {
            pesan.textContent = 'Bagus! Terus berlatih, ya! 💪';
        } else {
            pesan.textContent = 'Tidak apa-apa! Ayo belajar dan coba lagi! ❤️';
        }

    } catch (error) {

        console.error('Gagal membaca hasil kuis:', error);

        sessionStorage.removeItem('hasilKuisBuba');

    }

});
</script>

@endsection
