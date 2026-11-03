@extends('layouts.siswa.app')

@section('title', 'Riwayat Reward - BUBA')

@section('content')

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
            href="{{ route('siswa.konten') }}"
            class="group flex h-12 w-12 items-center justify-center rounded-full border-[4px] border-white bg-[#5ebef3] text-white shadow-[0_6px_14px_rgba(0,0,0,0.18)] transition-all duration-200 hover:scale-110 hover:bg-[#47ade7] hover:shadow-xl active:scale-90 sm:h-14 sm:w-14 md:h-16 md:w-16 md:border-[5px]"
            aria-label="Kembali ke pilihan konten"
        >
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                class="h-6 w-6 transition-transform duration-200 group-hover:-translate-x-1 sm:h-7 sm:w-7 md:h-8 md:w-8">
                <path d="M16 5.5a1 1 0 0 0-1.6-.8l-9 7a1 1 0 0 0 0 1.6l9 7A1 1 0 0 0 16 19.5V5.5z"/>
            </svg>
        </a>
    </div>

    {{-- Header Banner --}}
    <header class="relative z-10 mb-7 flex items-center justify-center pt-2 sm:pt-4 md:pt-6">
        <div class="rounded-2xl border-[4px] border-white bg-[#1e60be] px-7 py-2 shadow-[0_8px_20px_rgba(0,0,0,0.2)] sm:rounded-[2rem] sm:border-[5px] sm:px-10 sm:py-3 md:rounded-[2.2rem] md:border-[6px] md:px-14 md:py-3.5">
            <h1 class="text-center font-sans text-xl font-black tracking-wider text-white drop-shadow-[0_2px_4px_rgba(0,0,0,0.3)] sm:text-3xl md:text-4xl">
                RIWAYAT REWARD
            </h1>
        </div>
    </header>

    {{-- Konten Riwayat Reward --}}
    <main class="relative z-10 mx-auto w-full max-w-5xl">

        <div class="rounded-[2rem] border-[5px] border-white bg-white/95 p-5 shadow-[0_12px_24px_rgba(0,0,0,0.18)] sm:rounded-[2.4rem] sm:border-[6px] sm:p-8 md:p-10">

            {{-- Judul --}}
            <div class="mb-7 text-center">
                <div class="mb-3 text-6xl sm:text-7xl">🏆</div>

                <h2 class="text-2xl font-black text-[#1e60be] sm:text-3xl">
                    PRESTASI BELAJARMU!
                </h2>

                <p class="mt-2 font-bold text-slate-600">
                    Yuk, lihat perjalanan dan hasil belajarmu!
                </p>
            </div>

            {{-- Ringkasan Reward --}}
            <div class="mb-8 grid grid-cols-2 gap-3 sm:grid-cols-4 sm:gap-4">

                {{-- Total Kuis --}}
                <div class="rounded-2xl border-2 border-white bg-[#eaf5ff] p-4 text-center shadow-sm">
                    <div class="text-3xl">📝</div>
                    <p class="mt-2 text-2xl font-black text-[#1e60be]">
                        {{ $totalKuis }}
                    </p>
                    <p class="text-xs font-black text-[#1e60be] sm:text-sm">
                        Kuis Dikerjakan
                    </p>
                </div>

                {{-- Total Bintang --}}
                <div class="rounded-2xl border-2 border-white bg-yellow-100 p-4 text-center shadow-sm">
                    <div class="text-3xl">⭐</div>
                    <p class="mt-2 text-2xl font-black text-yellow-600">
                        {{ $totalBintang }}
                    </p>
                    <p class="text-xs font-black text-yellow-700 sm:text-sm">
                        Total Bintang
                    </p>
                </div>

                {{-- Reward Diperoleh --}}
                <div class="rounded-2xl border-2 border-white bg-green-100 p-4 text-center shadow-sm">
                    <div class="text-3xl">🎁</div>
                    <p class="mt-2 text-2xl font-black text-green-600">
                        {{ $totalReward }}
                    </p>
                    <p class="text-xs font-black text-green-700 sm:text-sm">
                        Reward Diperoleh
                    </p>
                </div>

                {{-- Rata-rata Nilai --}}
                <div class="rounded-2xl border-2 border-white bg-purple-100 p-4 text-center shadow-sm">
                    <div class="text-3xl">🌟</div>
                    <p class="mt-2 text-2xl font-black text-purple-600">
                        {{ $rataRata }}
                    </p>
                    <p class="text-xs font-black text-purple-700 sm:text-sm">
                        Rata-rata Nilai
                    </p>
                </div>

            </div>

            {{-- Judul Daftar Riwayat --}}
            <div class="mb-5 flex flex-wrap items-center justify-between gap-2">
                <h3 class="text-xl font-black text-[#1e60be] sm:text-2xl">
                    📚 Riwayat Kuis
                </h3>

                <span class="rounded-full border-2 border-white bg-[#eaf5ff] px-4 py-2 text-xs font-black text-[#1e60be] shadow-sm">
                    {{ $totalKuis }} Riwayat
                </span>
            </div>

            {{-- Daftar Riwayat --}}
            <div class="space-y-4">

                @forelse ($rewards as $reward)

                    <div class="rounded-2xl border-[3px] border-white bg-[#f4f9ff] p-4 shadow-sm transition-all duration-200 hover:-translate-y-1 hover:shadow-lg sm:p-5">

                        {{-- Header Card --}}
                        <div class="mb-4 flex flex-wrap items-start justify-between gap-3">

                            <div>
                                <h4 class="text-lg font-black text-[#1e60be] sm:text-xl">
                                    {{ $reward->quis->kode_kuis ?? 'Kuis' }}
                                </h4>

                                <p class="mt-1 text-sm font-bold text-slate-500">
                                    {{ $reward->quis->kelas->nama_kelas ?? 'Kelas tidak tersedia' }}
                                    <span class="mx-1">•</span>
                                    {{ $reward->quis->kategori->nama_kategori ?? 'Kategori tidak tersedia' }}
                                </p>
                            </div>

                            <span class="rounded-full border-2 border-white bg-white px-3 py-1 text-xs font-bold text-slate-500 shadow-sm">
                                📅 {{ $reward->created_at->format('d M Y') }}
                            </span>

                        </div>

                        {{-- Nilai dan Hasil --}}
                        <div class="grid grid-cols-3 gap-2 sm:gap-3">

                            {{-- Nilai --}}
                            <div class="rounded-xl border-2 border-white bg-[#eaf5ff] p-3 text-center">
                                <p class="text-xs font-black text-[#1e60be]">
                                    NILAI
                                </p>
                                <p class="mt-1 text-2xl font-black text-[#1e60be]">
                                    {{ $reward->skor }}
                                </p>
                            </div>

                            {{-- Benar --}}
                            <div class="rounded-xl border-2 border-white bg-green-100 p-3 text-center">
                                <p class="text-xs font-black text-green-700">
                                    BENAR
                                </p>
                                <p class="mt-1 text-2xl font-black text-green-600">
                                    {{ $reward->jumlah_benar }}
                                </p>
                            </div>

                            {{-- Salah --}}
                            <div class="rounded-xl border-2 border-white bg-red-100 p-3 text-center">
                                <p class="text-xs font-black text-red-700">
                                    SALAH
                                </p>
                                <p class="mt-1 text-2xl font-black text-red-600">
                                    {{ $reward->jumlah_salah }}
                                </p>
                            </div>

                        </div>

                        {{-- Bintang --}}
                        <div class="mt-4 rounded-xl border-2 border-yellow-200 bg-yellow-50 p-3 text-center">

                            <p class="text-xs font-black text-yellow-700">
                                BINTANG YANG DIPEROLEH
                            </p>

                            <div class="mt-2 text-3xl tracking-widest">
                                @if ($reward->jumlah_bintang > 0)
                                    {{ str_repeat('⭐', min($reward->jumlah_bintang, 5)) }}
                                @else
                                    😢
                                @endif
                            </div>

                            <p class="mt-1 text-sm font-bold text-yellow-700">
                                {{ $reward->jumlah_bintang }} dari 5 bintang
                            </p>

                        </div>

                    </div>

                @empty

                    {{-- Jika Belum Ada Riwayat --}}
                    <div class="rounded-2xl border-2 border-dashed border-[#9bcdf1] bg-[#f4f9ff] px-5 py-12 text-center">

                        <div class="mb-4 text-6xl">
                            📚
                        </div>

                        <h4 class="text-xl font-black text-[#1e60be]">
                            BELUM ADA RIWAYAT
                        </h4>

                        <p class="mt-2 font-bold text-slate-500">
                            Kamu belum mengerjakan kuis.
                            Yuk, mulai belajar dan kumpulkan bintang!
                        </p>

                        <a
                            href="{{ route('siswa.konten') }}"
                            class="mt-6 inline-flex items-center justify-center gap-2 rounded-full border-[3px] border-white bg-[#71bf4f] px-7 py-3 font-black text-white shadow-lg transition hover:scale-105 hover:bg-[#62aa43]"
                        >
                            🏠 Mulai Belajar
                        </a>

                    </div>

                @endforelse

            </div>

            {{-- Tombol Kembali --}}
            <div class="mt-8 flex justify-center">

                <a
                    href="{{ route('siswa.konten') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-full border-[3px] border-white bg-[#5ebef3] px-7 py-3 font-black text-white shadow-lg transition hover:scale-105 hover:bg-[#47ade7]"
                >
                    🏠 Pilih Konten
                </a>

            </div>

        </div>

    </main>

    {{-- Footer --}}
    <p class="relative z-10 my-8 text-center text-sm font-black text-white drop-shadow-[0_2px_3px_rgba(0,0,0,0.5)]">
        BUBA • Belajar sambil bermain 🌈
    </p>

</div>

@endsection
