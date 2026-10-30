@extends('layouts.siswa.app')

@section('title', 'Hasil Kuis - BUBA')

@section('content')

@php
    $urlDaftarKuis = route('siswa.kuis', [
        'konten' => request()->route('konten'),
        'kelas' => trim($kelas->nama_kelas),
        'kategori' => $kategori->slug,
    ]);

    $urlCobaLagi = route('siswa.showKuis', [
        'konten' => request()->route('konten'),
        'kelas' => trim($kelas->nama_kelas),
        'kategori' => $kategori->slug,
        'kuis' => $kuisDipilih->kode_kuis,
    ]) . '?ulang=1';
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
            href="{{ $urlDaftarKuis }}"
            onclick="sessionStorage.removeItem('hasilKuisBuba')"
            class="group flex h-12 w-12 items-center justify-center rounded-full border-[4px] border-white bg-[#5ebef3] text-white shadow-[0_6px_14px_rgba(0,0,0,0.18)] transition-all duration-200 hover:scale-110 hover:bg-[#47ade7] hover:shadow-xl active:scale-90 sm:h-14 sm:w-14 md:h-16 md:w-16 md:border-[5px]"
            aria-label="Kembali ke daftar kuis"
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
                HASIL KUIS {{ strtoupper($kelas->nama_kelas) }}
            </h1>
        </div>
    </header>

    {{-- Halaman Hasil Kuis --}}
    <main class="relative z-10 mx-auto my-auto w-full max-w-2xl">

        <div class="rounded-[2rem] border-[5px] border-white bg-white/95 p-6 text-center shadow-[0_12px_24px_rgba(0,0,0,0.18)] sm:rounded-[2.4rem] sm:border-[6px] sm:p-10">

            <div class="mb-4 text-7xl">🏆</div>

            <h2 class="text-3xl font-black text-[#1e60be] sm:text-4xl">
                HEBAT SEKALI!
            </h2>

            <p class="mt-2 font-bold text-slate-600">
                Kamu sudah menyelesaikan kuis!
            </p>

            <div class="mt-3 inline-block rounded-full border-2 border-white bg-[#eaf5ff] px-5 py-2 text-sm font-black text-[#1e60be] shadow-sm">
                {{ strtoupper($kategori->nama_kategori) }}
            </div>

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
                href="{{ $urlCobaLagi }}"
                class="mb-4 hidden items-center justify-center gap-2 rounded-full border-[3px] border-white bg-[#f36b6b] px-7 py-3 font-black text-white shadow-lg transition hover:scale-105 hover:bg-[#df5555]"
            >
                🔄 Kerjakan Lagi
            </a>

            {{-- Tombol Navigasi --}}
            <div class="flex flex-wrap items-center justify-center gap-3">

                {{-- Kembali ke Daftar Kuis --}}
                <a
                    href="{{ $urlDaftarKuis }}"
                    onclick="sessionStorage.removeItem('hasilKuisBuba')"
                    class="inline-flex items-center justify-center gap-2 rounded-full border-[3px] border-white bg-[#5ebef3] px-7 py-3 font-black text-white shadow-lg transition hover:scale-105 hover:bg-[#47ade7]"
                >
                    📚 Daftar Kuis
                </a>

                {{-- Kembali ke Pilihan Konten --}}
                <a
                    href="{{ route('siswa.konten') }}"
                    onclick="sessionStorage.removeItem('hasilKuisBuba')"
                    class="inline-flex items-center justify-center gap-2 rounded-full border-[3px] border-white bg-[#71bf4f] px-7 py-3 font-black text-white shadow-lg transition hover:scale-105 hover:bg-[#62aa43]"
                >
                    🏠 Pilih Konten
                </a>

            </div>

        </div>

    </main>

    <p class="relative z-10 my-8 text-center text-sm font-black text-white drop-shadow-[0_2px_3px_rgba(0,0,0,0.5)]">
        BUBA • Belajar sambil bermain 🌈
    </p>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const dataTersimpan = sessionStorage.getItem('hasilKuisBuba');

    const tombolUlang = document.getElementById('tombolKerjakanLagi');

    if (!dataTersimpan) {
        document.getElementById('hasilNilai').textContent = '-';
        document.getElementById('hasilBenar').textContent = '-';
        document.getElementById('hasilSalah').textContent = '-';
        document.getElementById('hasilTotal').textContent = '-';
        document.getElementById('hasilBintang').textContent = '😢';
        document.getElementById('pesanBintang').textContent = 'Data hasil belum ditemukan.';
        document.getElementById('pesanHasil').textContent = 'Silakan kerjakan kuis terlebih dahulu.';

        tombolUlang.classList.add('hidden');

        const pesan = document.createElement('p');
        pesan.className = 'rounded-xl bg-white p-4 text-center font-semibold text-slate-600';
        pesan.textContent = 'Rincian hasil kuis belum tersedia.';

        document.getElementById('daftarBenar').appendChild(pesan);
        return;
    }

    let hasil;

    try {
        hasil = JSON.parse(dataTersimpan);
    } catch (error) {
        console.error('Data hasil kuis tidak valid:', error);
        sessionStorage.removeItem('hasilKuisBuba');
        return;
    }

    const nilai = Number(hasil.nilai ?? 0);
    const benar = Number(hasil.benar ?? 0);
    const salah = Number(hasil.salah ?? 0);
    const total = Number(hasil.total ?? benar + salah);

    document.getElementById('hasilNilai').textContent = nilai;
    document.getElementById('hasilBenar').textContent = benar;
    document.getElementById('hasilSalah').textContent = salah;
    document.getElementById('hasilTotal').textContent = total;

    const pesan = document.getElementById('pesanHasil');
    const bintang = document.getElementById('hasilBintang');
    const pesanBintang = document.getElementById('pesanBintang');

    // Ambil jumlah bintang dari controller.
    const jumlahBintang = Number(hasil.jumlah_bintang ?? 0);

    if (nilai >= 90) {
        pesan.textContent = '🌟 Wah, luar biasa! Kamu pintar sekali!';
        pesanBintang.textContent = 'Luar biasa! Kamu mendapatkan ' + jumlahBintang + ' bintang!';
    } else if (nilai >= 70) {
        pesan.textContent = '🎉 Bagus sekali! Terus tingkatkan kemampuanmu!';
        pesanBintang.textContent = 'Hebat! Kamu mendapatkan ' + jumlahBintang + ' bintang!';
    } else if (nilai >= 50) {
        pesan.textContent = '😊 Bagus! Kamu sudah boleh melanjutkan belajar!';
        pesanBintang.textContent = 'Bagus! Kamu mendapatkan ' + jumlahBintang + ' bintang!';
    } else if (nilai >= 20) {
        pesan.textContent = '💪 Tetap semangat! Ayo coba kerjakan lagi!';
        pesanBintang.textContent = 'Kamu mendapatkan ' + jumlahBintang + ' bintang. Yuk, berlatih lagi!';
    } else if (nilai >= 1) {
        pesan.textContent = '💪 Jangan menyerah! Kamu pasti bisa!';
        pesanBintang.textContent = 'Kamu mendapatkan ' + jumlahBintang + ' bintang. Ayo coba lagi!';
    } else {
        pesan.textContent = '😢 Tidak apa-apa, ya. Ayo belajar dan mencoba lagi!';
        pesanBintang.textContent = 'Belum mendapatkan bintang. Tetap semangat!';
    }

    bintang.textContent = jumlahBintang > 0
        ? '⭐'.repeat(jumlahBintang)
        : '😢';

    // Tampilkan tombol ulang hanya jika bintang kurang dari 3.
    if (jumlahBintang < 3 && hasil.terkunci !== true) {
        tombolUlang.classList.remove('hidden');
        tombolUlang.classList.add('inline-flex');
    } else {
        tombolUlang.classList.add('hidden');
        tombolUlang.classList.remove('inline-flex');
    }

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

    daftarJawaban.forEach((item, index) => {

        const kartu = document.createElement('div');
        kartu.className = 'rounded-xl border-2 p-3';

        kartu.appendChild(
            buatTeks(
                'p',
                'Soal ' + (item.nomor ?? index + 1) + ': ' + item.pertanyaan,
                'mb-2 font-black text-slate-800'
            )
        );

        const jawabanAnakHuruf = item.jawabanAnakHuruf ?? '';
        const jawabanAnak = item.jawabanAnak ?? '';
        const jawabanBenarHuruf = item.jawabanBenarHuruf ?? '';
        const jawabanBenar = item.jawabanBenar ?? '';

        if (item.benar === true) {

            kartu.classList.add('border-green-200', 'bg-white');

            kartu.appendChild(
                buatTeks(
                    'p',
                    'Jawaban kamu: ' + jawabanAnakHuruf + '. ' + jawabanAnak,
                    'text-sm font-bold text-green-700'
                )
            );

            daftarBenar.appendChild(kartu);

        } else {

            kartu.classList.add('border-red-200', 'bg-white');

            kartu.appendChild(
                buatTeks(
                    'p',
                    'Jawaban kamu: ' +
                    (jawabanAnakHuruf
                        ? jawabanAnakHuruf + '. ' + jawabanAnak
                        : 'Belum dijawab'),
                    'text-sm font-bold text-red-600'
                )
            );

            kartu.appendChild(
                buatTeks(
                    'p',
                    'Jawaban yang benar: ' + jawabanBenarHuruf + '. ' + jawabanBenar,
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

});
</script>

@endsection
