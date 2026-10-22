@extends('layouts.siswa.app')

@section('title', 'Kuis - BUBA')

@section('content')
<div class="relative flex min-h-screen w-full flex-col overflow-x-hidden px-4 py-5 select-none sm:px-6 md:px-8">

    {{-- Background BUBA --}}
    <img src="{{ asset('images/backgroundSplash.png') }}"
        alt="BUBA Background"
        class="pointer-events-none fixed inset-0 z-0 h-full w-full object-cover object-bottom">

    {{-- Tombol Kembali --}}
    <div class="absolute left-4 top-4 z-30 sm:left-6 sm:top-6 md:left-8 md:top-8">
        <a href="{{ route('siswa.konten') }}"
            class="group flex h-12 w-12 items-center justify-center rounded-full border-4 border-white bg-[#5ebef3] text-white shadow-[0_6px_14px_rgba(0,0,0,0.18)] transition duration-200 hover:scale-110 hover:bg-[#47ade7] active:scale-90 sm:h-14 sm:w-14 md:h-16 md:w-16"
            aria-label="Kembali ke pilihan konten">

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
        <div class="rounded-2xl border-4 border-white bg-[#1e60be] px-7 py-3 shadow-[0_8px_20px_rgba(0,0,0,0.2)] sm:rounded-[2rem] sm:border-[5px] sm:px-10 md:rounded-[2.2rem] md:border-[6px] md:px-14">

            <h1 class="text-center font-sans text-xl font-black tracking-wider text-white drop-shadow sm:text-2xl md:text-3xl">
                KUIS {{ strtoupper($dataKelas->nama_kelas ?? 'ANAK') }}
            </h1>
        </div>
    </header>

    <main class="relative z-10 mx-auto w-full max-w-3xl">

        {{-- Judul Kuis --}}
        <div class="mb-6 text-center">
            <h2 class="mb-2 text-2xl font-black text-white drop-shadow-[0_3px_3px_rgba(0,0,0,0.4)] sm:text-3xl">
                Ayo Bermain Kuis!
            </h2>

            <p class="inline-block rounded-full border-2 border-white bg-white/90 px-5 py-2 text-sm font-bold text-[#1e60be] shadow-md sm:text-base">
                Kategori:
                {{ $dataKategori->nama_kategori ?? 'Pembelajaran' }}
            </p>
        </div>

        @if($quis->count() > 0)

            {{-- Progress Bar --}}
            <div id="progressArea" class="mx-auto mb-5 max-w-xl rounded-2xl border-2 border-white bg-white/80 p-4 shadow-md">

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
                @endphp

                <section
                    class="question-card {{ $index === 0 ? 'active' : 'hidden' }} mb-5 rounded-[1.7rem] border-4 border-white bg-white/95 p-5 text-center shadow-[0_10px_25px_rgba(0,0,0,0.18)] sm:rounded-[2rem] sm:p-7"
                    data-index="{{ $index }}"
                    data-answer="{{ strtoupper($item->jawaban ?? '') }}">

                    {{-- Nomor Soal --}}
                    <div class="mb-4 inline-block rounded-full border-2 border-white bg-[#1e60be] px-5 py-2 text-sm font-black tracking-wide text-white shadow-md">
                        SOAL {{ $index + 1 }}
                    </div>

                    {{-- Pertanyaan --}}
                    <h3 class="mx-auto mb-5 max-w-xl text-lg font-black leading-relaxed text-slate-800 sm:text-xl">
                        {{ $item->pertanyaan }}
                    </h3>

                    {{-- Gambar Soal --}}
                    @if(count($gambar) > 0)
                        <div class="mb-5 flex flex-wrap items-center justify-center gap-3">
                            @foreach($gambar as $file)
                                <img
                                    src="{{ asset('storage/' . $file) }}"
                                    alt="Gambar soal {{ $index + 1 }}"
                                    class="h-24 w-24 rounded-2xl border-4 border-white bg-sky-50 object-contain p-1 shadow-md sm:h-32 sm:w-32"
                                    onerror="this.style.display='none'">
                            @endforeach
                        </div>
                    @endif

                    {{-- Pilihan Jawaban --}}
                    <div class="options mx-auto mt-5 grid max-w-xl grid-cols-1 gap-3 sm:grid-cols-2 sm:gap-4">

                        @foreach($pilihan as $huruf => $teks)
                            @if($teks !== null && $teks !== '')
                                <button
                                    type="button"
                                    class="option group flex min-h-[62px] items-center gap-3 rounded-2xl border-4 border-white bg-[#d8759c] p-3 text-left text-white shadow-[0_5px_10px_rgba(0,0,0,0.12)] transition duration-200 hover:-translate-y-1 hover:bg-[#ca5e88] hover:shadow-lg"
                                    data-letter="{{ $huruf }}"
                                    onclick="pilihJawaban({{ $index }}, '{{ $huruf }}', this)">

                                    <span class="option-letter flex h-10 w-10 shrink-0 items-center justify-center rounded-full border-2 border-white bg-white text-base font-black text-[#d8759c]">
                                        {{ $huruf }}
                                    </span>

                                    <span class="text-sm font-extrabold leading-snug sm:text-base">
                                        {{ $teks }}
                                    </span>
                                </button>
                            @endif
                        @endforeach

                    </div>

                    {{-- Feedback --}}
                    <div class="feedback mt-4 min-h-6 text-sm font-extrabold text-[#1e60be]" aria-live="polite"></div>

                </section>
            @endforeach

            {{-- Tombol Navigasi --}}
            <div id="quizActions" class="my-6 flex flex-wrap justify-center gap-3 sm:gap-4">

                <button
                    type="button"
                    id="nextButton"
                    onclick="soalBerikutnya()"
                    class="rounded-2xl border-4 border-white bg-[#ffd629] px-6 py-3 font-black text-[#493b00] shadow-lg transition hover:-translate-y-1 hover:scale-105 active:scale-95 sm:px-8">
                    Soal Berikutnya ➜
                </button>

                <button
                    type="button"
                    id="finishButton"
                    onclick="selesaiKuis()"
                    class="rounded-2xl border-4 border-white bg-[#1e60be] px-6 py-3 font-black text-white shadow-lg transition hover:-translate-y-1 hover:scale-105 hover:bg-blue-700 active:scale-95 sm:px-8">
                    Lihat Nilai ⭐
                </button>

            </div>

            {{-- Hasil Kuis --}}
            <section id="resultCard"
                class="hidden rounded-[2rem] border-4 border-white bg-white/95 px-5 py-8 text-center shadow-xl sm:px-8">

                <div class="mb-3 text-5xl">🏆</div>

                <h2 class="mb-3 text-2xl font-black text-[#1e60be] sm:text-3xl">
                    Kuis Selesai!
                </h2>

                <p class="mb-4 font-bold text-slate-700">
                    Hebat! Kamu sudah menyelesaikan kuis ini.
                </p>

                <div id="resultScore" class="my-4 text-5xl font-black text-[#d8759c]">
                    0
                </div>

                <p id="resultDetail" class="mb-6 font-bold text-slate-700"></p>

                <div class="flex flex-wrap justify-center gap-3">
                    <button
                        type="button"
                        onclick="location.reload()"
                        class="rounded-2xl border-4 border-white bg-[#ffd629] px-6 py-3 font-black text-[#493b00] shadow-md transition hover:scale-105">
                        Main Lagi 🔄
                    </button>

                    <a href="{{ route('siswa.konten') }}"
                        class="rounded-2xl border-4 border-white bg-[#1e60be] px-6 py-3 font-black text-white shadow-md transition hover:scale-105">
                        Kembali
                    </a>
                </div>
            </section>

        @else

            {{-- Jika Belum Ada Soal --}}
            <section class="rounded-[2rem] border-4 border-white bg-white/90 px-5 py-8 text-center shadow-xl sm:px-8">

                <div class="mb-3 text-5xl">📚</div>

                <h2 class="mb-3 text-2xl font-black text-[#1e60be]">
                    Belum Ada Soal
                </h2>

                <p class="mb-6 font-semibold text-slate-700">
                    Soal untuk kelas dan kategori ini belum tersedia.
                    Yuk, coba kategori pembelajaran lainnya!
                </p>

                <a href="{{ route('siswa.konten') }}"
                    class="inline-block rounded-2xl border-4 border-white bg-[#d8759c] px-8 py-3 font-black text-white shadow-lg transition hover:scale-105 hover:bg-[#ca5e88]">
                    Kembali
                </a>
            </section>

        @endif

        {{-- Footer --}}
        <p class="my-6 text-center text-sm font-black text-white drop-shadow-[0_2px_3px_rgba(0,0,0,0.5)]">
            BUBA • Belajar sambil bermain 🌈
        </p>

    </main>
</div>

{{-- CSS Tambahan --}}
<style>
    .question-card.active {
        display: block;
        animation: bubaAppear .25s ease;
    }

    .option.selected {
        background: #1e60be !important;
        border-color: #ffffff !important;
        box-shadow: 0 0 0 3px #93c5fd;
    }

    .option.selected .option-letter {
        color: #1e60be;
    }

    .option.correct {
        background: #239b55 !important;
    }

    .option.wrong {
        background: #dc4545 !important;
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

    function perbaruiProgres() {
        const dijawab = Object.keys(jawabanPengguna).length;

        document.getElementById('progressLabel').textContent =
            `Soal ${nomorAktif + 1} dari ${totalSoal}`;

        document.getElementById('progressCount').textContent =
            `${dijawab}/${totalSoal} dijawab`;

        document.getElementById('progressFill').style.width =
            `${(dijawab / totalSoal) * 100}%`;

        document.getElementById('nextButton').textContent =
            nomorAktif === totalSoal - 1
                ? 'Periksa Jawaban ✓'
                : 'Soal Berikutnya ➜';
    }

    function tampilkanSoal(index) {
        cards.forEach((card, i) => {
            card.classList.toggle('active', i === index);
            card.classList.toggle('hidden', i !== index);
        });

        nomorAktif = index;
        perbaruiProgres();

        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }

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

    function soalBerikutnya() {
        if (sudahSelesai) return;

        if (nomorAktif < totalSoal - 1) {
            tampilkanSoal(nomorAktif + 1);
            return;
        }

        const belumDijawab = cards.findIndex(
            (_, index) => jawabanPengguna[index] === undefined
        );

        if (belumDijawab !== -1) {
            tampilkanSoal(belumDijawab);
            alert('Ayo jawab semua soal terlebih dahulu! 😊');
        } else {
            selesaiKuis();
        }
    }

    function selesaiKuis() {
        if (sudahSelesai) return;

        const belumDijawab = cards.findIndex(
            (_, index) => jawabanPengguna[index] === undefined
        );

        if (belumDijawab !== -1) {
            tampilkanSoal(belumDijawab);
            alert('Masih ada soal yang belum dijawab, ya! 😊');
            return;
        }

        sudahSelesai = true;

        let benar = 0;

        cards.forEach((card, index) => {
            const jawabanBenar = card.dataset.answer;
            const jawaban = jawabanPengguna[index];

            card.querySelectorAll('.option').forEach(option => {
                const huruf = option.dataset.letter;

                if (huruf === jawabanBenar) {
                    option.classList.add('correct');
                }

                if (huruf === jawaban && huruf !== jawabanBenar) {
                    option.classList.add('wrong');
                }

                option.disabled = true;
            });

            if (jawaban === jawabanBenar) {
                benar++;

                card.querySelector('.feedback').textContent =
                    '🎉 Hebat! Jawaban kamu benar!';
            } else {
                card.querySelector('.feedback').textContent =
                    '💪 Tetap semangat belajar, ya!';
            }
        });

        cards.forEach(card => {
            card.classList.remove('active');
            card.classList.add('hidden');
        });

        document.getElementById('progressArea').classList.add('hidden');
        document.getElementById('quizActions').classList.add('hidden');

        document.getElementById('resultCard').classList.remove('hidden');

        document.getElementById('resultScore').textContent =
            Math.round((benar / totalSoal) * 100);

        document.getElementById('resultDetail').textContent =
            `${benar} jawaban benar dari ${totalSoal} soal.`;

        document.getElementById('resultCard').scrollIntoView({
            behavior: 'smooth',
            block: 'center'
        });
    }

    perbaruiProgres();
</script>
@endif
@endsection
