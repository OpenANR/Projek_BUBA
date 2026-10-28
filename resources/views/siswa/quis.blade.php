@extends('layouts.siswa.app')

@section('title', 'Kuis - BUBA')

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

    $ikonKuis = [
        '📚',
        '🎨',
        '🧩',
        '🌈',
        '⭐',
        '🎵',
        '🐻',
        '🎯',
    ];

    $daftarKuis = $quis ?? collect();

    $urlDaftarKuis = route('siswa.kuis', [
        'konten' => request()->route('konten'),
        'kelas' => trim($kelas->nama_kelas),
        'kategori' => $kategori->slug,
    ]);
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
            href="javascript:history.back()"
            class="group flex h-12 w-12 items-center justify-center rounded-full border-[4px] border-white bg-[#5ebef3] text-white shadow-[0_6px_14px_rgba(0,0,0,0.18)] transition-all duration-200 hover:scale-110 hover:bg-[#47ade7] hover:shadow-xl active:scale-90 sm:h-14 sm:w-14 md:h-16 md:w-16 md:border-[5px]"
            aria-label="Kembali ke halaman sebelumnya"
        >
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                class="h-6 w-6 transition-transform duration-200 group-hover:-translate-x-1 sm:h-7 sm:w-7 md:h-8 md:w-8">
                <path d="M16 5.5a1 1 0 0 0-1.6-.8l-9 7a1 1 0 0 0 0 1.6l9 7A1 1 0 0 0 16 19.5V5.5z"/>
            </svg>
        </a>
    </div>

    {{-- Header Banner --}}
    <header class="relative z-10 mb-7 flex items-center justify-center pt-2 sm:pt-4 md:pt-6">
        <div class="rounded-2xl border-[4px] border-white bg-[#1e60be] px-7 py-2 shadow-[0_8px_20px_rgba(0,0,0,0.2)] transition-transform duration-300 hover:scale-105 sm:rounded-[2rem] sm:border-[5px] sm:px-10 sm:py-3 md:rounded-[2.2rem] md:border-[6px] md:px-14 md:py-3.5">
            <h1 class="text-center font-sans text-2xl font-black tracking-wider text-white drop-shadow-[0_2px_4px_rgba(0,0,0,0.3)] sm:text-3xl md:text-4xl lg:text-[2.6rem]">
                KUIS KELAS {{ strtoupper($kelas->nama_kelas) }}
            </h1>
        </div>
    </header>

    {{-- Halaman Daftar Kuis --}}
    <main id="quizPage" class="relative z-10 mx-auto my-auto w-full max-w-6xl">

        {{-- Informasi Kuis --}}
        <div class="mb-8 text-center">
            <h2 class="mb-3 text-2xl font-black text-white drop-shadow-[0_3px_3px_rgba(0,0,0,0.4)] sm:text-3xl md:text-4xl">
                🎮 PILIH KUIS!
            </h2>

            <p class="font-bold text-white drop-shadow-[0_2px_3px_rgba(0,0,0,0.5)]">
                Pilih kuis yang ingin kamu kerjakan. Yuk, semangat belajar!
            </p>

            <div class="mt-4 inline-block rounded-full border-[3px] border-white bg-white/95 px-6 py-2 text-sm font-black text-[#1e60be] shadow-md sm:text-base">
                {{ strtoupper($kategori->nama_kategori) }}
            </div>
        </div>

        {{-- Daftar Kartu Kuis --}}
        @if($daftarKuis->isNotEmpty())

            <div class="flex w-full flex-wrap items-center justify-center gap-5 px-2 py-4 sm:gap-8 md:gap-10">

                @foreach($daftarKuis as $index => $item)

                    @php
                        $palette = $palettes[$index % count($palettes)];
                        $ikon = $ikonKuis[$index % count($ikonKuis)];
                    @endphp

                    <a
                        href="{{ route('siswa.showKuis', [
                            'konten' => request()->route('konten'),
                            'kelas' => trim($kelas->nama_kelas),
                            'kategori' => $kategori->slug,
                            'kuis' => $item->kode_kuis,
                        ]) }}"
                        class="group relative flex h-60 w-48 flex-col items-center justify-between overflow-hidden rounded-[2rem] border-[5px] border-white {{ $palette['bg'] }} p-5 shadow-[0_12px_24px_rgba(0,0,0,0.18)] transition-all duration-300 ease-out hover:-translate-y-2.5 hover:scale-105 {{ $palette['hover'] }} {{ $palette['shadow'] }} active:scale-95 sm:h-72 sm:w-56 sm:rounded-[2.4rem] sm:border-[6px] sm:p-6 md:h-80 md:w-64 md:rounded-[2.8rem] md:border-8 md:p-7"
                    >

                        {{-- Hiasan --}}
                        <div class="pointer-events-none absolute -right-7 -top-7 h-24 w-24 rounded-full bg-white/20"></div>
                        <div class="pointer-events-none absolute -bottom-8 -left-7 h-28 w-28 rounded-full bg-white/20"></div>

                        {{-- Ikon Kuis --}}
                        <div class="relative flex flex-1 items-center justify-center text-6xl drop-shadow-md transition-all duration-300 group-hover:-translate-y-1 group-hover:rotate-6 group-hover:scale-110 sm:text-7xl md:text-8xl">
                            {{ $ikon }}
                        </div>

                        {{-- Nomor Kuis --}}
                        <div class="relative w-full text-center">
                            <h3 class="text-xl font-black tracking-wider text-white drop-shadow-[0_2px_4px_rgba(0,0,0,0.25)] sm:text-2xl md:text-3xl">
                                KUIS {{ $index + 1 }}
                            </h3>

                            <p class="mt-2 line-clamp-2 text-sm font-bold leading-snug text-white drop-shadow sm:text-base">
                                {{ \Illuminate\Support\Str::limit($item->pertanyaan, 65) }}
                            </p>

                            <div class="mt-4 inline-flex items-center gap-2 rounded-full border-2 border-white bg-white px-4 py-2 text-sm font-black text-[#1e60be] shadow-md transition-all duration-200 group-hover:bg-[#ffd629] sm:px-5">
                                Kerjakan
                                <span>➜</span>
                            </div>
                        </div>

                    </a>

                @endforeach

            </div>

        @else

            {{-- Jika Belum Ada Kuis --}}
            <div class="mx-auto flex max-w-md flex-col items-center justify-center rounded-[2rem] border-[5px] border-white bg-white/95 px-8 py-8 text-center shadow-[0_10px_25px_rgba(0,0,0,0.18)]">
                <span class="mb-3 text-6xl">📚</span>

                <h3 class="text-xl font-black text-[#1e60be] sm:text-2xl">
                    Belum Ada Kuis
                </h3>

                <p class="mt-2 text-sm font-semibold text-slate-600">
                    Kuis untuk kategori ini belum tersedia. Yuk, coba lagi nanti!
                </p>
            </div>

        @endif

    </main>

    {{-- Halaman Hasil Kuis --}}
    <main id="resultPage" class="relative z-10 mx-auto hidden w-full max-w-2xl">

        <div class="rounded-[2rem] border-[5px] border-white bg-white/95 p-6 text-center shadow-[0_12px_24px_rgba(0,0,0,0.18)] sm:rounded-[2.4rem] sm:border-[6px] sm:p-10">

            <div class="mb-4 text-7xl">🏆</div>

            <h2 class="text-3xl font-black text-[#1e60be] sm:text-4xl">
                HEBAT SEKALI!
            </h2>

            <p class="mt-2 font-bold text-slate-600">
                Kamu sudah menyelesaikan kuis!
            </p>

            {{-- Nilai --}}
            <div class="my-7 rounded-[1.5rem] border-4 border-white bg-[#eaf5ff] p-6 shadow-inner">
                <p class="text-sm font-black text-[#1e60be]">
                    NILAI KAMU
                </p>

                <h3 id="hasilNilai" class="mt-2 text-6xl font-black text-[#1e60be]">
                    0
                </h3>
            </div>

            {{-- Jumlah Benar, Salah, Total --}}
            <div class="mb-6 grid grid-cols-3 gap-3">

                <div class="rounded-2xl border-2 border-white bg-green-100 p-3 shadow-sm sm:p-4">
                    <div class="text-3xl">✅</div>
                    <p id="hasilBenar" class="mt-2 text-2xl font-black text-green-600">0</p>
                    <p class="text-xs font-black text-green-700">Benar</p>
                </div>

                <div class="rounded-2xl border-2 border-white bg-red-100 p-3 shadow-sm sm:p-4">
                    <div class="text-3xl">❌</div>
                    <p id="hasilSalah" class="mt-2 text-2xl font-black text-red-600">0</p>
                    <p class="text-xs font-black text-red-700">Salah</p>
                </div>

                <div class="rounded-2xl border-2 border-white bg-yellow-100 p-3 shadow-sm sm:p-4">
                    <div class="text-3xl">📝</div>
                    <p id="hasilTotal" class="mt-2 text-2xl font-black text-yellow-600">0</p>
                    <p class="text-xs font-black text-yellow-700">Total</p>
                </div>

            </div>

            {{-- Bintang --}}
            <div class="my-5 rounded-2xl border-2 border-yellow-200 bg-yellow-50 p-4">
                <p class="text-sm font-black text-yellow-700">
                    BINTANG KAMU
                </p>

                <div id="hasilBintang" class="mt-2 text-4xl tracking-widest">
                    ⭐⭐⭐⭐⭐
                </div>

                <p id="pesanBintang" class="mt-2 text-sm font-bold text-yellow-700">
                    Hebat sekali!
                </p>
            </div>

            <p id="pesanHasil" class="mb-7 text-lg font-bold text-slate-700">
                Terus semangat belajar, ya!
            </p>

            {{-- Pembahasan Jawaban --}}
            <div class="mb-7 text-left">

                <h3 class="mb-4 text-center text-xl font-black text-[#1e60be]">
                    📖 Pembahasan Jawaban
                </h3>

                {{-- Jawaban Benar --}}
                <div class="mb-5 rounded-2xl border-2 border-green-200 bg-green-50 p-4">
                    <h4 class="mb-3 text-lg font-black text-green-700">
                        ✅ Jawaban Benar
                    </h4>

                    <div id="daftarBenar" class="space-y-3"></div>
                </div>

                {{-- Jawaban Salah --}}
                <div class="rounded-2xl border-2 border-red-200 bg-red-50 p-4">
                    <h4 class="mb-3 text-lg font-black text-red-700">
                        ❌ Jawaban Salah
                    </h4>

                    <div id="daftarSalah" class="space-y-3"></div>
                </div>

            </div>

            {{-- Tombol Kerjakan Lagi --}}
            <a
                id="tombolKerjakanLagi"
                href="#"
                class="mb-4 hidden items-center justify-center gap-2 rounded-full border-[3px] border-white bg-[#f36b6b] px-7 py-3 font-black text-white shadow-lg transition hover:scale-105 hover:bg-[#df5555]"
            >
                🔄 Kerjakan Lagi
            </a>

            {{-- Kembali ke Daftar Kuis --}}
            <a
                href="{{ $urlDaftarKuis }}"
                onclick="sessionStorage.removeItem('hasilKuisBuba')"
                class="inline-flex items-center gap-2 rounded-full border-[3px] border-white bg-[#5ebef3] px-7 py-3 font-black text-white shadow-lg transition hover:scale-105 hover:bg-[#47ade7]"
            >
                ← Kembali ke Daftar Kuis
            </a>

        </div>

    </main>

    <p class="relative z-10 my-8 text-center text-sm font-black text-white drop-shadow-[0_2px_3px_rgba(0,0,0,0.5)]">
        BUBA • Belajar sambil bermain 🌈
    </p>

</div>

{{-- Script Hasil Kuis --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const hasilKuis = sessionStorage.getItem('hasilKuisBuba');

    if (!hasilKuis) {
        return;
    }

    try {
        const hasil = JSON.parse(hasilKuis);

        document.getElementById('quizPage').classList.add('hidden');
        document.getElementById('resultPage').classList.remove('hidden');

        const nilai = Number(hasil.nilai ?? 0);
        const benar = Number(hasil.benar ?? 0);
        const salah = Number(hasil.salah ?? 0);
        const total = Number(hasil.total ?? 0);

        document.getElementById('hasilNilai').textContent = nilai;
        document.getElementById('hasilBenar').textContent = benar;
        document.getElementById('hasilSalah').textContent = salah;
        document.getElementById('hasilTotal').textContent = total;

        const pesan = document.getElementById('pesanHasil');
        const bintang = document.getElementById('hasilBintang');
        const pesanBintang = document.getElementById('pesanBintang');

        let jumlahBintang = 0;

        if (nilai >= 90) {
            jumlahBintang = 5;
            pesan.textContent = '🌟 Wah, luar biasa! Kamu pintar sekali!';
            pesanBintang.textContent = 'Luar biasa! Kamu mendapatkan 5 bintang!';
        } else if (nilai >= 70) {
            jumlahBintang = 4;
            pesan.textContent = '🎉 Bagus sekali! Terus tingkatkan kemampuanmu!';
            pesanBintang.textContent = 'Hebat! Kamu mendapatkan 4 bintang!';
        } else if (nilai >= 50) {
            jumlahBintang = 3;
            pesan.textContent = '😊 Bagus! Kamu sudah boleh melanjutkan belajar!';
            pesanBintang.textContent = 'Bagus! Kamu mendapatkan 3 bintang!';
        } else if (nilai >= 20) {
            jumlahBintang = 2;
            pesan.textContent = '💪 Tetap semangat! Ayo coba kerjakan lagi!';
            pesanBintang.textContent = 'Kamu mendapatkan 2 bintang. Yuk, berlatih lagi!';
        } else if (nilai >= 1) {
            jumlahBintang = 1;
            pesan.textContent = '💪 Jangan menyerah! Kamu pasti bisa!';
            pesanBintang.textContent = 'Kamu mendapatkan 1 bintang. Ayo coba lagi!';
        } else {
            jumlahBintang = 0;
            pesan.textContent = '😢 Tidak apa-apa, ya. Ayo belajar dan mencoba lagi!';
            pesanBintang.textContent = 'Belum mendapatkan bintang. Tetap semangat!';
        }

        bintang.textContent = jumlahBintang > 0
            ? '⭐'.repeat(jumlahBintang)
            : '😢';

        // Tampilkan tombol ulang jika bintang kurang dari 3.
        const tombolUlang = document.getElementById('tombolKerjakanLagi');

        if (jumlahBintang <= 2 && hasil.retryUrl) {
            tombolUlang.href = hasil.retryUrl;
            tombolUlang.classList.remove('hidden');
            tombolUlang.classList.add('inline-flex');
        }

        // Membuat elemen teks dengan aman.
        function buatTeks(tag, isi, className = '') {
            const elemen = document.createElement(tag);
            elemen.className = className;
            elemen.textContent = isi || '-';
            return elemen;
        }

        const daftarBenar = document.getElementById('daftarBenar');
        const daftarSalah = document.getElementById('daftarSalah');

        daftarBenar.replaceChildren();
        daftarSalah.replaceChildren();

        const daftarJawaban = Array.isArray(hasil.daftarJawaban)
            ? hasil.daftarJawaban
            : [];

        daftarJawaban.forEach(item => {

            const kartu = document.createElement('div');
            kartu.className = 'rounded-xl border-2 p-3';

            kartu.appendChild(
                buatTeks(
                    'p',
                    'Soal ' + item.nomor + ': ' + item.pertanyaan,
                    'mb-2 font-black text-slate-800'
                )
            );

            if (item.benar) {

                kartu.classList.add('border-green-200', 'bg-white');

                kartu.appendChild(
                    buatTeks(
                        'p',
                        'Jawaban kamu: ' + item.jawabanAnakHuruf + '. ' + item.jawabanAnak,
                        'text-sm font-bold text-green-700'
                    )
                );

                daftarBenar.appendChild(kartu);

            } else {

                kartu.classList.add('border-red-200', 'bg-white');

                kartu.appendChild(
                    buatTeks(
                        'p',
                        'Jawaban kamu: ' + item.jawabanAnakHuruf + '. ' + item.jawabanAnak,
                        'text-sm font-bold text-red-600'
                    )
                );

                kartu.appendChild(
                    buatTeks(
                        'p',
                        'Jawaban yang benar: ' + item.jawabanBenarHuruf + '. ' + item.jawabanBenar,
                        'mt-2 text-sm font-bold text-green-700'
                    )
                );

                daftarSalah.appendChild(kartu);
            }
        });

        if (daftarBenar.children.length === 0) {
            daftarBenar.appendChild(
                buatTeks(
                    'p',
                    'Belum ada jawaban yang benar.',
                    'text-sm font-semibold text-slate-600'
                )
            );
        }

        if (daftarSalah.children.length === 0) {
            daftarSalah.appendChild(
                buatTeks(
                    'p',
                    'Hebat! Semua jawaban kamu benar! 🎉',
                    'text-sm font-semibold text-green-700'
                )
            );
        }

    } catch (error) {
        console.error('Data hasil kuis tidak valid:', error);
        sessionStorage.removeItem('hasilKuisBuba');
    }

});
</script>

@endsection
