@extends('layouts.siswa.app')

@section('title', 'Pengerjaan Kuis - BUBA')

@section('content')

@php
    $palettes = [
        ['bg' => 'bg-[#71bf4f]', 'hover' => 'hover:bg-[#62aa43]', 'shadow' => 'hover:shadow-[0_22px_36px_rgba(113,191,79,0.35)]'],
        ['bg' => 'bg-[#faa63a]', 'hover' => 'hover:bg-[#e89427]', 'shadow' => 'hover:shadow-[0_22px_36px_rgba(250,166,58,0.35)]'],
        ['bg' => 'bg-[#d8759c]', 'hover' => 'hover:bg-[#ca5e88]', 'shadow' => 'hover:shadow-[0_22px_36px_rgba(216,117,156,0.35)]'],
        ['bg' => 'bg-[#5ebef3]', 'hover' => 'hover:bg-[#47ade7]', 'shadow' => 'hover:shadow-[0_22px_36px_rgba(94,190,243,0.35)]'],
        ['bg' => 'bg-[#9c65cd]', 'hover' => 'hover:bg-[#894fc0]', 'shadow' => 'hover:shadow-[0_22px_36px_rgba(156,101,205,0.35)]'],
        ['bg' => 'bg-[#ffd629]', 'hover' => 'hover:bg-[#f0c313]', 'shadow' => 'hover:shadow-[0_22px_36px_rgba(255,214,41,0.35)]'],
        ['bg' => 'bg-[#3cbdb1]', 'hover' => 'hover:bg-[#2fa89d]', 'shadow' => 'hover:shadow-[0_22px_36px_rgba(60,189,177,0.35)]'],
        ['bg' => 'bg-[#f36b6b]', 'hover' => 'hover:bg-[#df5555]', 'shadow' => 'hover:shadow-[0_22px_36px_rgba(243,107,107,0.35)]'],
    ];

    $urlHasilKuis = route('siswa.kuis', [
        'konten' => request()->route('konten'),
        'kelas' => $kelas->nama_kelas,
        'kategori' => $kategori->slug,
    ]);

    $daftarSoal = $quis instanceof \Illuminate\Support\Collection
        ? $quis->values()
        : collect([$quis])->filter()->values();

    $indexAwal = 0;

    $urlUlangKuis = isset($kuisDipilih)
        ? route('siswa.showKuis', [
            'konten' => request()->route('konten'),
            'kelas' => $kelas->nama_kelas,
            'kategori' => $kategori->slug,
            'kuis' => $kuisDipilih->kode_kuis,
        ]) . '?ulang=1'
        : $urlHasilKuis;

    $urlSimpanHasil = isset($kuisDipilih)
        ? route('siswa.simpanHasil', [
            'konten' => request()->route('konten'),
            'kelas' => $kelas->nama_kelas,
            'kategori' => $kategori->slug,
            'kuis' => $kuisDipilih->kode_kuis,
        ])
        : null;
@endphp

<div class="relative flex min-h-screen w-full flex-col items-center overflow-x-hidden px-4 py-5 select-none sm:px-6 md:px-8">

    <img
        src="{{ asset('images/backgroundSplash.png') }}"
        alt="BUBA Background"
        class="pointer-events-none fixed inset-0 z-0 h-full w-full select-none object-cover object-bottom"
    >

    <div class="absolute left-4 top-4 z-30 sm:left-6 sm:top-6 md:left-8 md:top-8">
        <a
            href="javascript:history.back()"
            class="group flex h-12 w-12 items-center justify-center rounded-full border-[4px] border-white bg-[#5ebef3] text-white shadow-lg transition-all hover:scale-110 hover:bg-[#47ade7] active:scale-90 sm:h-14 sm:w-14 md:h-16 md:w-16"
            aria-label="Kembali"
        >
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                class="h-6 w-6 sm:h-7 sm:w-7 md:h-8 md:w-8">
                <path d="M16 5.5a1 1 0 0 0-1.6-.8l-9 7a1 1 0 0 0 0 1.6l9 7A1 1 0 0 0 16 19.5V5.5z"/>
            </svg>
        </a>
    </div>

    <header class="relative z-10 mb-7 flex items-center justify-center pt-4">
        <div class="rounded-2xl border-4 border-white bg-[#1e60be] px-7 py-3 shadow-lg sm:px-10 md:px-14">
            <h1 class="text-center text-xl font-black tracking-wider text-white sm:text-2xl md:text-3xl">
                KUIS KELAS {{ strtoupper($kelas->nama_kelas ?? 'ANAK') }}
            </h1>
        </div>
    </header>

    <main class="relative z-10 mx-auto w-full max-w-5xl">

        <div class="mb-6 text-center">
            <h2 class="mb-3 text-2xl font-black text-white drop-shadow-lg sm:text-3xl md:text-4xl">
                Ayo Bermain Kuis! 🌈
            </h2>

            <p class="inline-block rounded-full border-2 border-white bg-white px-5 py-2 text-sm font-black text-[#1e60be] shadow-md sm:text-base">
                Kategori: {{ $kategori->nama_kategori ?? 'Pembelajaran' }}
            </p>

            <p class="mt-3 font-bold text-white drop-shadow-lg">
                Ayo jawab pertanyaannya dengan benar!
            </p>
        </div>

        @if($daftarSoal->isNotEmpty())

            <div id="progressArea" class="mx-auto mb-5 max-w-2xl rounded-3xl border-4 border-white bg-white/95 p-4 shadow-lg sm:p-5">

                <div class="mb-3 flex flex-wrap justify-between gap-2 text-sm font-black text-[#1e60be] sm:text-base">
                    <span id="progressLabel">Soal 1 dari {{ $daftarSoal->count() }}</span>
                    <span id="progressCount">0/{{ $daftarSoal->count() }} dijawab</span>
                </div>

                <div class="h-4 overflow-hidden rounded-full bg-slate-200 shadow-inner">
                    <div id="progressFill" class="h-full rounded-full bg-[#ffd629] transition-all duration-300" style="width: 0%"></div>
                </div>

            </div>

            @foreach($daftarSoal as $index => $item)

                @php
                    $gambar = $item->gambar ?? [];

                    if (is_string($gambar)) {
                        $decoded = json_decode($gambar, true);

                        $gambar = json_last_error() === JSON_ERROR_NONE && is_array($decoded)
                            ? $decoded
                            : [$gambar];
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
                    class="question-card {{ $index === $indexAwal ? '' : 'hidden' }} mb-6 rounded-[2rem] border-[5px] border-white bg-white/95 p-5 text-center shadow-xl sm:p-8"
                    data-id="{{ $item->id }}"
                    data-index="{{ $index }}"
                    data-answer="{{ strtoupper($item->jawaban ?? '') }}"
                    data-question="{{ $item->pertanyaan }}"
                    data-option-a="{{ $item->pilihan_a }}"
                    data-option-b="{{ $item->pilihan_b }}"
                    data-option-c="{{ $item->pilihan_c }}"
                    data-option-d="{{ $item->pilihan_d }}"
                >

                    <div class="mb-5 inline-block rounded-full border-2 border-white bg-[#1e60be] px-6 py-2 text-sm font-black text-white shadow-md">
                        SOAL {{ $index + 1 }}
                    </div>

                    <h3 class="mx-auto mb-5 max-w-2xl text-xl font-black leading-relaxed text-slate-800 sm:text-2xl">
                        {{ $item->pertanyaan }}
                    </h3>

                    @if($audioPertanyaan)
                        <div class="mb-5 flex justify-center">
                            <button
                                type="button"
                                onclick="putarAudio(this)"
                                data-audio="{{ asset('storage/' . $audioPertanyaan) }}"
                                class="flex items-center gap-2 rounded-full border-2 border-white bg-[#5ebef3] px-5 py-3 font-black text-white shadow-md transition hover:scale-105"
                            >
                                🔊 Dengarkan Pertanyaan
                            </button>
                        </div>
                    @endif

                    @if(count($gambar) > 0)
                        <div class="mb-6 flex flex-wrap items-center justify-center gap-4">
                            @foreach($gambar as $file)
                                <img
                                    src="{{ asset('storage/' . $file) }}"
                                    alt="Gambar soal {{ $index + 1 }}"
                                    class="h-28 w-28 rounded-2xl border-4 border-white bg-sky-50 object-contain p-1 shadow-md sm:h-36 sm:w-36"
                                    onerror="this.style.display='none'"
                                >
                            @endforeach
                        </div>
                    @endif

                    <div class="options mx-auto grid max-w-2xl grid-cols-1 gap-4 sm:grid-cols-2">

                        @foreach($pilihan as $huruf => $teks)

                            @if($teks !== null && trim((string) $teks) !== '')

                                <button
                                    type="button"
                                    class="option group flex min-h-[75px] items-center gap-3 rounded-2xl border-4 border-white {{ $palette['bg'] }} p-3 text-left text-white shadow-md transition-all {{ $palette['hover'] }} hover:-translate-y-1 active:scale-95"
                                    data-letter="{{ $huruf }}"
                                    onclick="pilihJawaban({{ $index }}, '{{ $huruf }}', this)"
                                >

                                    <span class="option-letter flex h-11 w-11 shrink-0 items-center justify-center rounded-full border-2 border-white bg-white text-base font-black text-[#1e60be]">
                                        {{ $huruf }}
                                    </span>

                                    <span class="flex-1 text-sm font-extrabold leading-snug sm:text-base">
                                        {{ $teks }}
                                    </span>

                                    @if(!empty($audioPilihan[$huruf]))
                                        <span
                                            role="button"
                                            tabindex="0"
                                            onclick="event.stopPropagation(); putarAudio(this)"
                                            onkeydown="if(event.key === 'Enter' || event.key === ' ') { event.preventDefault(); event.stopPropagation(); putarAudio(this); }"
                                            data-audio="{{ asset('storage/' . $audioPilihan[$huruf]) }}"
                                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full border-2 border-white bg-white text-lg text-[#1e60be] shadow-md transition hover:scale-110"
                                            title="Dengarkan pilihan {{ $huruf }}"
                                            aria-label="Dengarkan pilihan {{ $huruf }}"
                                        >
                                            🔊
                                        </span>
                                    @endif

                                </button>

                            @endif

                        @endforeach

                    </div>

                    <div class="feedback mt-5 min-h-6 text-sm font-extrabold text-[#1e60be]" aria-live="polite"></div>

                </section>

            @endforeach

            <div id="quizActions" class="my-6 flex flex-wrap justify-center gap-3 sm:gap-4">

                <button
                    type="button"
                    id="prevButton"
                    onclick="soalSebelumnya()"
                    disabled
                    class="rounded-2xl border-4 border-white bg-[#5ebef3] px-6 py-3 font-black text-white shadow-lg transition hover:scale-105 disabled:cursor-not-allowed disabled:opacity-40"
                >
                    ← Sebelumnya
                </button>

                <button
                    type="button"
                    id="nextButton"
                    onclick="soalBerikutnya()"
                    class="rounded-2xl border-4 border-white bg-[#ffd629] px-6 py-3 font-black text-[#493b00] shadow-lg transition hover:scale-105"
                >
                    Berikutnya →
                </button>

                <button
                    type="button"
                    id="finishButton"
                    onclick="selesaiKuis()"
                    class="rounded-2xl border-4 border-white bg-[#71bf4f] px-6 py-3 font-black text-white shadow-lg transition hover:scale-105"
                >
                    Selesai ⭐
                </button>

            </div>

        @else

            <section class="mx-auto max-w-xl rounded-[2rem] border-4 border-white bg-white/95 px-5 py-8 text-center shadow-xl sm:px-8">

                <div class="mb-3 text-5xl">📚</div>

                <h2 class="mb-3 text-2xl font-black text-[#1e60be]">
                    Belum Ada Soal
                </h2>

                <p class="mb-6 font-semibold text-slate-700">
                    Kuis ini belum memiliki pertanyaan. Yuk, kembali dan pilih kuis lainnya!
                </p>

                <a
                    href="{{ $urlHasilKuis }}"
                    class="inline-block rounded-2xl border-4 border-white bg-[#5ebef3] px-8 py-3 font-black text-white shadow-lg transition hover:scale-105"
                >
                    ← Kembali
                </a>

            </section>

        @endif

        <p class="my-8 text-center text-sm font-black text-white drop-shadow-lg">
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
        box-shadow: 0 0 0 3px #93c5fd, 0 8px 18px rgba(30, 96, 190, 0.2);
        transform: translateY(-2px);
    }

    .option.selected .option-letter {
        background: #ffd629;
        color: #493b00;
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

@if($daftarSoal->isNotEmpty())

<script>
    const cards = [...document.querySelectorAll('.question-card')];
    const totalSoal = cards.length;
    const jawabanPengguna = {};

    let nomorAktif = {{ $indexAwal }};
    let sudahSelesai = false;
    let audioAktif = null;

    const urlHasilKuis = @json($urlHasilKuis);
    const urlUlangKuis = @json($urlUlangKuis);
    const namaKategori = @json($kategori->nama_kategori ?? 'Pembelajaran');
    const urlSimpanHasil = @json($urlSimpanHasil);
    const tokenCsrf = @json(csrf_token());

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

    function hentikanAudio() {
        if (audioAktif) {
            audioAktif.pause();
            audioAktif.currentTime = 0;
            audioAktif = null;
        }
    }

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

    function pulihkanJawaban(index) {
        const card = cards[index];
        const jawaban = jawabanPengguna[index];

        card.querySelectorAll('.option').forEach(option => {
            option.classList.toggle(
                'selected',
                option.dataset.letter === jawaban
            );
        });

        const feedback = card.querySelector('.feedback');

        if (feedback) {
            feedback.textContent = jawaban
                ? 'Jawabanmu sudah dipilih! Kamu boleh menggantinya 😊'
                : '';
        }
    }

    function tampilkanSoal(index) {
        if (index < 0 || index >= totalSoal) return;

        hentikanAudio();

        cards.forEach((card, i) => {
            card.classList.toggle('hidden', i !== index);
        });

        nomorAktif = index;

        pulihkanJawaban(nomorAktif);
        perbaruiProgres();

        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }

    function pilihJawaban(index, huruf) {
        if (sudahSelesai) return;

        jawabanPengguna[index] = huruf;

        const card = cards[index];

        card.querySelectorAll('.option').forEach(option => {
            option.classList.toggle(
                'selected',
                option.dataset.letter === huruf
            );
        });

        const feedback = card.querySelector('.feedback');

        if (feedback) {
            feedback.textContent =
                'Jawaban berhasil dipilih! Yuk, lanjut 😊';
        }

        perbaruiProgres();
    }

    function soalSebelumnya() {
        if (!sudahSelesai && nomorAktif > 0) {
            tampilkanSoal(nomorAktif - 1);
        }
    }

    function soalBerikutnya() {
        if (!sudahSelesai && nomorAktif < totalSoal - 1) {
            tampilkanSoal(nomorAktif + 1);
        }
    }

    async function selesaiKuis() {
        if (sudahSelesai) return;

        const belumDijawab = cards.findIndex((_, index) => {
            return jawabanPengguna[index] === undefined;
        });

        if (belumDijawab !== -1) {
            tampilkanSoal(belumDijawab);
            alert('Ayo jawab semua pertanyaan terlebih dahulu! 😊');
            return;
        }

        hentikanAudio();

        const tombolSelesai = document.getElementById('finishButton');

        tombolSelesai.disabled = true;
        tombolSelesai.textContent = 'Menyimpan hasil...';

        const jawabanUntukServer = {};

        cards.forEach((card, index) => {
            jawabanUntukServer[card.dataset.id] =
                jawabanPengguna[index];
        });

        try {
            const response = await fetch(urlSimpanHasil, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': tokenCsrf,
                },
                body: JSON.stringify({
                    jawaban: jawabanUntukServer
                })
            });

            const hasilServer = await response.json();

            if (!response.ok) {
                if (hasilServer.terkunci) {
                    alert(hasilServer.message || 'Kuis sudah terkunci.');
                    window.location.href = urlHasilKuis;
                    return;
                }

                throw new Error(
                    hasilServer.message || 'Hasil kuis gagal disimpan.'
                );
            }

            sudahSelesai = true;

            const daftarJawaban = [];

            cards.forEach((card, index) => {
                const jawabanBenar = card.dataset.answer;
                const jawabanAnak = jawabanPengguna[index];

                const pilihanAnak =
                    card.dataset['option' + jawabanAnak] || jawabanAnak;

                const pilihanBenar =
                    card.dataset['option' + jawabanBenar] || jawabanBenar;

                const isBenar = jawabanAnak === jawabanBenar;

                daftarJawaban.push({
                    nomor: index + 1,
                    pertanyaan: card.dataset.question || '',
                    jawabanAnakHuruf: jawabanAnak,
                    jawabanAnak: pilihanAnak,
                    jawabanBenarHuruf: jawabanBenar,
                    jawabanBenar: pilihanBenar,
                    benar: isBenar
                });
            });

            sessionStorage.setItem('hasilKuisBuba', JSON.stringify({
                nilai: hasilServer.nilai,
                benar: hasilServer.benar,
                salah: hasilServer.salah,
                total: hasilServer.total,
                jumlah_bintang: hasilServer.jumlah_bintang,
                namaKuis: 'Kuis BUBA',
                namaKategori: namaKategori,
                daftarJawaban: daftarJawaban,
                retryUrl: urlUlangKuis
            }));

            window.location.href = urlHasilKuis;

        } catch (error) {
            console.error('Gagal menyimpan hasil:', error);

            alert(error.message || 'Terjadi kesalahan saat menyimpan hasil kuis.');

            tombolSelesai.disabled = false;
            tombolSelesai.textContent = 'Selesai ⭐';
        }
    }

    tampilkanSoal(nomorAktif);
</script>

@endif

@endsection
