@extends('layouts.siswa.app')

@section('title', 'Pengerjaan Kuis - BUBA')

@section('content')
@php
    $palettes = [
        ['bg' => 'bg-[#71bf4f]', 'hover' => 'hover:bg-[#62aa43]'],
        ['bg' => 'bg-[#faa63a]', 'hover' => 'hover:bg-[#e89427]'],
        ['bg' => 'bg-[#d8759c]', 'hover' => 'hover:bg-[#ca5e88]'],
        ['bg' => 'bg-[#5ebef3]', 'hover' => 'hover:bg-[#47ade7]'],
        ['bg' => 'bg-[#9c65cd]', 'hover' => 'hover:bg-[#894fc0]'],
        ['bg' => 'bg-[#ffd629]', 'hover' => 'hover:bg-[#f0c313]'],
        ['bg' => 'bg-[#3cbdb1]', 'hover' => 'hover:bg-[#2fa89d]'],
        ['bg' => 'bg-[#f36b6b]', 'hover' => 'hover:bg-[#df5555]'],
    ];

    // URL halaman hasil kuis
    $urlHasilKuis = route('siswa.kuis', [
        'konten' => request()->route('konten'),
        'kelas' => $kelas->nama_kelas,
        'kategori' => $kategori->slug,
    ]);
@endphp

<div class="relative flex min-h-screen w-full flex-col items-center overflow-x-hidden px-4 py-5 select-none sm:px-6 md:px-8">

    {{-- Background BUBA --}}
    <img src="{{ asset('images/backgroundSplash.png') }}"
        alt="BUBA Background"
        class="pointer-events-none fixed inset-0 z-0 h-full w-full object-cover object-bottom">

    {{-- Tombol Kembali --}}
    <div class="absolute left-4 top-4 z-30 sm:left-6 sm:top-6 md:left-8 md:top-8">
        <a href="javascript:history.back()"
            class="group flex h-12 w-12 items-center justify-center rounded-full border-[4px] border-white bg-[#5ebef3] text-white shadow-[0_6px_14px_rgba(0,0,0,0.18)] transition-all duration-200 hover:scale-110 hover:bg-[#47ade7] active:scale-90 sm:h-14 sm:w-14 md:h-16 md:w-16"
            aria-label="Kembali">
            <svg xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                fill="currentColor"
                class="h-6 w-6 transition-transform group-hover:-translate-x-1 sm:h-7 sm:w-7 md:h-8 md:w-8">
                <path d="M16 5.5a1 1 0 0 0-1.6-.8l-9 7a1 1 0 0 0 0 1.6l9 7A1 1 0 0 0 16 19.5V5.5z"/>
            </svg>
        </a>
    </div>

    {{-- Header Banner --}}
    <header class="relative z-10 mb-7 flex items-center justify-center pt-2 sm:pt-4 md:pt-6">
        <div class="rounded-2xl border-[4px] border-white bg-[#1e60be] px-7 py-2 shadow-[0_8px_20px_rgba(0,0,0,0.2)] sm:rounded-[2rem] sm:border-[5px] sm:px-10 sm:py-3 md:rounded-[2.2rem] md:border-[6px] md:px-14 md:py-3.5">
            <h1 class="text-center font-sans text-xl font-black tracking-wider text-white drop-shadow sm:text-2xl md:text-3xl">
                KUIS KELAS {{ strtoupper($kelas->nama_kelas ?? 'ANAK') }}
            </h1>
        </div>
    </header>

    <main class="relative z-10 mx-auto w-full max-w-5xl">

        {{-- Informasi Paket --}}
        <div class="mb-6 text-center">
            <h2 class="mb-2 text-2xl font-black text-white drop-shadow-[0_3px_3px_rgba(0,0,0,0.4)] sm:text-3xl">
                {{ $paket->nama_kuis ?? 'Ayo Bermain Kuis!' }}
            </h2>

            <p class="inline-block rounded-full border-2 border-white bg-white/90 px-5 py-2 text-sm font-bold text-[#1e60be] shadow-md sm:text-base">
                Kategori: {{ $kategori->nama_kategori ?? 'Pembelajaran' }}
            </p>

            <p class="mt-3 font-bold text-white drop-shadow">
                Ayo jawab pertanyaannya dengan benar! 🌈
            </p>
        </div>

        @if($quis->count() > 0)

            {{-- Progress --}}
            <div id="progressArea" class="mx-auto mb-5 max-w-2xl rounded-2xl border-4 border-white bg-white/90 p-4 shadow-lg">
                <div class="mb-2 flex justify-between gap-3 text-sm font-black text-[#1e60be]">
                    <span id="progressLabel">Soal 1 dari {{ $quis->count() }}</span>
                    <span id="progressCount">0/{{ $quis->count() }} dijawab</span>
                </div>

                <div class="h-3 overflow-hidden rounded-full border-2 border-white bg-slate-200">
                    <div id="progressFill"
                        class="h-full rounded-full bg-[#ffd629] transition-all duration-300"
                        style="width: 0%">
                    </div>
                </div>
            </div>

            {{-- Daftar Soal --}}
            @foreach($quis as $index => $item)

                @php
                    $gambar = $item->gambar ?? [];

                    if (is_string($gambar)) {
                        $decoded = json_decode($gambar, true);

                        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                            $gambar = $decoded;
                        } else {
                            $gambar = [$gambar];
                        }
                    }

                    if (!is_array($gambar)) {
                        $gambar = [];
                    }

                    $gambar = array_values(array_filter($gambar, function ($file) {
                        return is_string($file) && trim($file) !== '';
                    }));

                    $pilihan = [
                        'A' => $item->pilihan_a,
                        'B' => $item->pilihan_b,
                        'C' => $item->pilihan_c,
                        'D' => $item->pilihan_d,
                    ];

                    $audioPertanyaan = $item->audio_pertanyaan ?? null;

                    $audioPilihan = [
                        'A' => $item->audio_pilihan_a ?? null,
                        'B' => $item->audio_pilihan_b ?? null,
                        'C' => $item->audio_pilihan_c ?? null,
                        'D' => $item->audio_pilihan_d ?? null,
                    ];

                    $palette = $palettes[$index % count($palettes)];
                @endphp

                <section
                    class="question-card {{ $index === 0 ? '' : 'hidden' }} mb-6 rounded-[2rem] border-[5px] border-white bg-white/95 p-5 text-center shadow-[0_12px_24px_rgba(0,0,0,0.18)] sm:p-8"
                    data-index="{{ $index }}"
                    data-answer="{{ strtoupper($item->jawaban ?? '') }}">

                    {{-- Nomor Soal --}}
                    <div class="mb-5 inline-block rounded-full border-2 border-white bg-[#1e60be] px-6 py-2 text-sm font-black tracking-wide text-white shadow-md">
                        SOAL {{ $index + 1 }}
                    </div>

                    {{-- Pertanyaan --}}
                    <h3 class="mx-auto mb-4 max-w-2xl text-xl font-black leading-relaxed text-slate-800 sm:text-2xl">
                        {{ $item->pertanyaan }}
                    </h3>

                    {{-- Audio Pertanyaan --}}
                    @if($audioPertanyaan)
                        <div class="mb-5 flex justify-center">
                            <button
                                type="button"
                                onclick="putarAudio(this)"
                                data-audio="{{ asset('storage/' . $audioPertanyaan) }}"
                                class="flex items-center gap-2 rounded-full border-4 border-white bg-[#5ebef3] px-5 py-3 font-black text-white shadow-md transition hover:scale-105 hover:bg-[#47ade7] active:scale-95">
                                <span class="text-xl">🔊</span>
                                <span>Dengarkan Pertanyaan</span>
                            </button>
                        </div>
                    @endif

                    {{-- Gambar Soal --}}
                    @if(count($gambar) > 0)
                        <div class="mb-6 flex flex-wrap items-center justify-center gap-4">
                            @foreach($gambar as $file)
                                <img
                                    src="{{ asset('storage/' . $file) }}"
                                    alt="Gambar soal {{ $index + 1 }}"
                                    class="h-28 w-28 rounded-2xl border-4 border-white bg-sky-50 object-contain p-1 shadow-md sm:h-36 sm:w-36"
                                    onerror="this.style.display='none'">
                            @endforeach
                        </div>
                    @endif

                    {{-- Pilihan Jawaban --}}
                    <div class="options mx-auto grid max-w-2xl grid-cols-1 gap-4 sm:grid-cols-2">
                        @foreach($pilihan as $huruf => $teks)
                            @if($teks !== null && $teks !== '')
                                <button
                                    type="button"
                                    class="option group flex min-h-[75px] items-center gap-3 rounded-2xl border-4 border-white {{ $palette['bg'] }} p-3 text-left text-white shadow-[0_5px_10px_rgba(0,0,0,0.12)] transition duration-200 hover:-translate-y-1 {{ $palette['hover'] }} hover:shadow-lg"
                                    data-letter="{{ $huruf }}"
                                    onclick="pilihJawaban({{ $index }}, '{{ $huruf }}', this)">

                                    <span class="option-letter flex h-11 w-11 shrink-0 items-center justify-center rounded-full border-2 border-white bg-white text-base font-black text-[#1e60be]">
                                        {{ $huruf }}
                                    </span>

                                    <span class="flex-1 text-sm font-extrabold leading-snug sm:text-base">
                                        {{ $teks }}
                                    </span>

                                    {{-- Audio Pilihan --}}
                                    @if(!empty($audioPilihan[$huruf]))
                                        <span
                                            role="button"
                                            tabindex="0"
                                            onclick="event.stopPropagation(); putarAudio(this)"
                                            onkeydown="if(event.key === 'Enter' || event.key === ' ') { event.preventDefault(); event.stopPropagation(); putarAudio(this); }"
                                            data-audio="{{ asset('storage/' . $audioPilihan[$huruf]) }}"
                                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full border-2 border-white bg-white text-lg text-[#1e60be] shadow-md transition hover:scale-110"
                                            title="Dengarkan pilihan {{ $huruf }}">
                                            🔊
                                        </span>
                                    @endif
                                </button>
                            @endif
                        @endforeach
                    </div>

                    {{-- Feedback --}}
                    <div class="feedback mt-5 min-h-6 text-sm font-extrabold text-[#1e60be]" aria-live="polite"></div>
                </section>
            @endforeach

            {{-- Tombol Navigasi --}}
            <div id="quizActions" class="my-6 flex flex-wrap justify-center gap-3 sm:gap-4">
                <button
                    type="button"
                    id="prevButton"
                    onclick="soalSebelumnya()"
                    disabled
                    class="rounded-2xl border-4 border-white bg-[#5ebef3] px-6 py-3 font-black text-white shadow-lg transition hover:-translate-y-1 hover:scale-105 active:scale-95 disabled:cursor-not-allowed disabled:opacity-40 sm:px-8">
                    ← Sebelumnya
                </button>

                <button
                    type="button"
                    id="nextButton"
                    onclick="soalBerikutnya()"
                    class="rounded-2xl border-4 border-white bg-[#ffd629] px-6 py-3 font-black text-[#493b00] shadow-lg transition hover:-translate-y-1 hover:scale-105 active:scale-95 sm:px-8">
                    Berikutnya →
                </button>

                <button
                    type="button"
                    id="finishButton"
                    onclick="selesaiKuis()"
                    class="rounded-2xl border-4 border-white bg-[#71bf4f] px-6 py-3 font-black text-white shadow-lg transition hover:-translate-y-1 hover:scale-105 active:scale-95 sm:px-8">
                    Selesai ⭐
                </button>
            </div>

        @else

            {{-- Jika Belum Ada Soal --}}
            <section class="rounded-[2rem] border-[5px] border-white bg-white/95 px-5 py-8 text-center shadow-xl sm:px-8">
                <div class="mb-3 text-5xl">📚</div>

                <h2 class="mb-3 text-2xl font-black text-[#1e60be]">
                    Belum Ada Soal
                </h2>

                <p class="mb-6 font-semibold text-slate-700">
                    Paket kuis ini belum memiliki pertanyaan.
                    Yuk, coba paket lainnya!
                </p>

                <button
                    type="button"
                    onclick="history.back()"
                    class="rounded-2xl border-4 border-white bg-[#5ebef3] px-8 py-3 font-black text-white shadow-lg transition hover:scale-105">
                    ← Kembali
                </button>
            </section>

        @endif

        <p class="my-8 text-center text-sm font-black text-white drop-shadow-[0_2px_3px_rgba(0,0,0,0.5)]">
            BUBA • Belajar sambil bermain 🌈
        </p>
    </main>
</div>

<style>
    .question-card:not(.hidden) {
        display: block;
        animation: bubaAppear .25s ease;
    }

    .option.selected {
        background: #1e60be !important;
        border-color: #ffffff !important;
        box-shadow: 0 0 0 3px #93c5fd;
    }

    .option:disabled {
        cursor: default;
        transform: none;
    }

    @keyframes bubaAppear {
        from {
            opacity: 0;
            transform: translateY(8px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

@if($quis->count() > 0)
<script>
    const cards = [...document.querySelectorAll('.question-card')];
    const totalSoal = cards.length;
    const jawabanPengguna = {};

    let nomorAktif = 0;
    let sudahSelesai = false;
    let audioAktif = null;

    // Memutar audio
    function putarAudio(tombol) {
        const sumberAudio = tombol.dataset.audio;

        if (!sumberAudio) return;

        hentikanAudio();

        audioAktif = new Audio(sumberAudio);

        audioAktif.play().catch(error => {
            console.error('Audio gagal diputar:', error);
            alert('Audio tidak dapat diputar. Silakan coba lagi.');
        });
    }

    // Menghentikan audio
    function hentikanAudio() {
        if (audioAktif) {
            audioAktif.pause();
            audioAktif.currentTime = 0;
            audioAktif = null;
        }
    }

    // Memperbarui progress
    function perbaruiProgres() {
        const dijawab = Object.keys(jawabanPengguna).length;

        document.getElementById('progressLabel').textContent =
            `Soal ${nomorAktif + 1} dari ${totalSoal}`;

        document.getElementById('progressCount').textContent =
            `${dijawab}/${totalSoal} dijawab`;

        document.getElementById('progressFill').style.width =
            `${(dijawab / totalSoal) * 100}%`;

        document.getElementById('prevButton').disabled =
            nomorAktif === 0;

        document.getElementById('nextButton').classList.toggle(
            'hidden',
            nomorAktif === totalSoal - 1
        );

        document.getElementById('finishButton').classList.toggle(
            'hidden',
            nomorAktif !== totalSoal - 1
        );
    }

    // Menampilkan soal
    function tampilkanSoal(index) {
        hentikanAudio();

        cards.forEach((card, i) => {
            card.classList.toggle('hidden', i !== index);
        });

        nomorAktif = index;
        perbaruiProgres();

        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }

    // Memilih jawaban
    function pilihJawaban(index, huruf, tombol) {
        if (sudahSelesai) return;

        const card = cards[index];

        jawabanPengguna[index] = huruf;

        card.querySelectorAll('.option').forEach(option => {
            option.classList.remove('selected');
        });

        tombol.classList.add('selected');

        card.querySelector('.feedback').textContent =
            'Jawaban dipilih! Yuk, lanjut ke soal berikutnya 😊';

        perbaruiProgres();
    }

    // Soal sebelumnya
    function soalSebelumnya() {
        if (!sudahSelesai && nomorAktif > 0) {
            tampilkanSoal(nomorAktif - 1);
        }
    }

    // Soal berikutnya
    function soalBerikutnya() {
        if (!sudahSelesai && nomorAktif < totalSoal - 1) {
            tampilkanSoal(nomorAktif + 1);
        }
    }

    // Menyelesaikan kuis dan menuju halaman hasil
    function selesaiKuis() {
        if (sudahSelesai) return;

        const belumDijawab = cards.findIndex(
            (_, index) => jawabanPengguna[index] === undefined
        );

        if (belumDijawab !== -1) {
            tampilkanSoal(belumDijawab);
            alert('Ayo jawab semua pertanyaan terlebih dahulu! 😊');
            return;
        }

        sudahSelesai = true;
        hentikanAudio();

        let benar = 0;

        cards.forEach((card, index) => {
            const jawabanBenar = card.dataset.answer;
            const jawaban = jawabanPengguna[index];

            if (jawaban === jawabanBenar) {
                benar++;
            }
        });

        const salah = totalSoal - benar;
        const nilai = totalSoal > 0
            ? Math.round((benar / totalSoal) * 100)
            : 0;

        // Simpan hasil sementara di browser
        sessionStorage.setItem('hasilKuisBuba', JSON.stringify({
            nilai: nilai,
            benar: benar,
            salah: salah,
            total: totalSoal,
            namaPaket: @json($paket->nama_kuis ?? 'Kuis'),
            namaKategori: @json($kategori->nama_kategori ?? 'Pembelajaran')
        }));

        // Pindah ke halaman hasil
        window.location.href = @json($urlHasilKuis);
    }

    // Menampilkan soal pertama
    tampilkanSoal(0);
</script>
@endif

@endsection
