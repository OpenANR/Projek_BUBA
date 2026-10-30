@extends('layouts.siswa.app')

@section('title', 'Pengerjaan Kuis - BUBA')

@section('content')

@php
    $daftarSoal = $quis instanceof \Illuminate\Support\Collection
        ? $quis->values()
        : collect([$quis])->filter()->values();

    $urlDaftarKuis = route('siswa.kuis', [
        'konten' => request()->route('konten'),
        'kelas' => trim($kelas->nama_kelas),
        'kategori' => $kategori->slug,
    ]);

    $urlHasilKuis = route('siswa.hasilKuis', [
        'konten' => request()->route('konten'),
        'kelas' => trim($kelas->nama_kelas),
        'kategori' => $kategori->slug,
        'kuis' => $kuisDipilih->kode_kuis,
    ]);

    $urlUlangKuis = route('siswa.showKuis', [
        'konten' => request()->route('konten'),
        'kelas' => trim($kelas->nama_kelas),
        'kategori' => $kategori->slug,
        'kuis' => $kuisDipilih->kode_kuis,
    ]) . '?ulang=1';

    $urlSimpanHasil = route('siswa.simpanHasil', [
        'konten' => request()->route('konten'),
        'kelas' => trim($kelas->nama_kelas),
        'kategori' => $kategori->slug,
        'kuis' => $kuisDipilih->kode_kuis,
    ]);
@endphp

<input type="hidden" id="csrfTokenBuba" value="{{ csrf_token() }}">

<div class="relative flex min-h-screen w-full flex-col items-center overflow-x-hidden px-4 py-5 select-none sm:px-6 md:px-8">

    <img
        src="{{ asset('images/backgroundSplash.png') }}"
        alt="BUBA Background"
        class="pointer-events-none fixed inset-0 z-0 h-full w-full object-cover object-bottom"
    >

    {{-- TOMBOL KEMBALI --}}
    <div class="absolute left-4 top-4 z-30 sm:left-6 sm:top-6 md:left-8 md:top-8">
        <a href="{{ $urlDaftarKuis }}"
           aria-label="Kembali ke daftar kuis"
           class="group flex h-12 w-12 items-center justify-center rounded-full border-[4px] border-white bg-[#5ebef3] text-white shadow-lg transition-all hover:scale-110 hover:bg-[#47ade7] active:scale-90 sm:h-14 sm:w-14 md:h-16 md:w-16">
            <svg xmlns="http://www.w3.org/2000/svg"
                 viewBox="0 0 24 24"
                 fill="currentColor"
                 class="h-6 w-6 transition-transform group-hover:-translate-x-1 sm:h-7 sm:w-7">
                <path d="M16 5.5a1 1 0 0 0-1.6-.8l-9 7a1 1 0 0 0 0 1.6l9 7A1 1 0 0 0 16 19.5V5.5z"/>
            </svg>
        </a>
    </div>

    {{-- HEADER --}}
    <header class="relative z-10 mb-7 flex w-full items-center justify-center pt-2 sm:pt-4 md:pt-6">
        <div class="max-w-full rounded-2xl border-[4px] border-white bg-[#1e60be] px-7 py-2 shadow-lg sm:rounded-[2rem] sm:border-[5px] sm:px-10 sm:py-3 md:rounded-[2.2rem] md:border-[6px] md:px-14 md:py-3.5">
            <h1 class="text-center font-sans text-xl font-black tracking-wider text-white sm:text-3xl md:text-4xl">
                KUIS KELAS {{ strtoupper($kelas->nama_kelas) }}
            </h1>
        </div>
    </header>

    <main class="relative z-10 mx-auto my-auto w-full max-w-5xl">

        {{-- JUDUL --}}
        <div class="mb-7 text-center">
            <h2 class="mb-3 text-2xl font-black text-white drop-shadow-lg sm:text-3xl md:text-4xl">
                🎮 AYO KERJAKAN KUIS!
            </h2>

            <p class="font-bold text-white drop-shadow-lg sm:text-lg">
                Jawab semua pertanyaan dengan benar, ya!
            </p>

            <div class="mt-4 inline-block rounded-full border-[3px] border-white bg-white/95 px-6 py-2 text-sm font-black text-[#1e60be] shadow-md sm:text-base">
                {{ strtoupper($kategori->nama_kategori) }}
            </div>
        </div>

        @if($daftarSoal->isNotEmpty())

            {{-- PROGRESS --}}
            <div class="mx-auto mb-5 w-full max-w-2xl rounded-[1.5rem] border-[4px] border-white bg-white/95 p-4 shadow-[0_10px_25px_rgba(0,0,0,0.18)] sm:p-5">
                <div class="mb-3 flex items-center justify-between gap-3">
                    <span class="font-black text-[#1e60be]">
                        ⭐ PROGRESS KUIS
                    </span>

                    <span id="progressText" class="font-black text-[#1e60be]">
                        0 / {{ $daftarSoal->count() }}
                    </span>
                </div>

                <div class="h-4 overflow-hidden rounded-full border-2 border-white bg-slate-200 shadow-inner">
                    <div id="progressBar"
                         class="h-full rounded-full bg-[#ffd629] transition-all duration-300"
                         style="width: 0%">
                    </div>
                </div>
            </div>

            {{-- DAFTAR SOAL --}}
            <div id="daftarSoal">

                @foreach($daftarSoal as $index => $soal)

                    @php
                        $gambarSoal = $soal->gambar ?? [];

                        if (is_string($gambarSoal)) {
                            $decoded = json_decode($gambarSoal, true);

                            $gambarSoal = json_last_error() === JSON_ERROR_NONE && is_array($decoded)
                                ? $decoded
                                : [$gambarSoal];
                        }

                        if (!is_array($gambarSoal)) {
                            $gambarSoal = [];
                        }

                        $gambarSoal = array_values(array_filter($gambarSoal, function ($gambar) {
                            return is_string($gambar) && trim($gambar) !== '';
                        }));
                    @endphp

                    <section
                        class="soal-card {{ $index === 0 ? '' : 'hidden' }} mx-auto mb-6 w-full max-w-2xl rounded-[2rem] border-[5px] border-white bg-white/95 p-5 text-center shadow-[0_12px_24px_rgba(0,0,0,0.18)] transition-all duration-300 sm:rounded-[2.4rem] sm:border-[6px] sm:p-8"
                        data-id="{{ $soal->id }}"
                        data-answer="{{ strtoupper($soal->jawaban ?? '') }}"
                        data-question="{{ $soal->pertanyaan }}"
                        data-option-a="{{ $soal->pilihan_a }}"
                        data-option-b="{{ $soal->pilihan_b }}"
                        data-option-c="{{ $soal->pilihan_c }}"
                        data-option-d="{{ $soal->pilihan_d }}"
                    >

                        <div class="mb-5 flex items-center justify-between gap-3">
                            <span class="rounded-full border-[3px] border-white bg-[#1e60be] px-5 py-2 text-sm font-black text-white shadow-md sm:text-base">
                                📝 SOAL {{ $index + 1 }}
                            </span>

                            <span class="text-sm font-black text-[#1e60be] sm:text-base">
                                {{ $index + 1 }} / {{ $daftarSoal->count() }}
                            </span>
                        </div>

                        {{-- PERTANYAAN --}}
                        <div class="mb-5 rounded-[1.5rem] border-2 border-blue-100 bg-blue-50/80 p-4 text-center sm:p-5">
                            <h2 class="text-xl font-black leading-relaxed text-[#1e60be] sm:text-2xl">
                                {{ $soal->pertanyaan }}
                            </h2>

                            @if($soal->audio_pertanyaan)
                                <div class="mt-4 flex justify-center">
                                    <audio controls class="w-full max-w-sm">
                                        <source src="{{ asset('storage/' . $soal->audio_pertanyaan) }}">
                                        Browser tidak mendukung audio.
                                    </audio>
                                </div>
                            @endif
                        </div>

                        {{-- GAMBAR --}}
                        @if(count($gambarSoal))
                            <div class="mb-6 flex flex-wrap justify-center gap-4">
                                @foreach($gambarSoal as $gambar)
                                    <div class="rounded-2xl border-[4px] border-white bg-white p-1 shadow-md">
                                        <img
                                            src="{{ asset('storage/' . $gambar) }}"
                                            alt="Gambar soal {{ $index + 1 }}"
                                            class="h-28 w-28 rounded-xl object-contain sm:h-36 sm:w-36"
                                            onerror="this.style.display='none'"
                                        >
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        {{-- PILIHAN JAWABAN --}}
                        <h3 class="mb-4 text-center text-base font-black text-[#1e60be] sm:text-lg">
                            🌈 PILIH JAWABAN YANG BENAR!
                        </h3>

                        <div class="mx-auto grid w-full max-w-xl grid-cols-1 gap-3 sm:grid-cols-2 sm:gap-4">

                            @foreach(['A', 'B', 'C', 'D'] as $huruf)

                                @php
                                    $fieldPilihan = 'pilihan_' . strtolower($huruf);
                                    $fieldAudio = 'audio_pilihan_' . strtolower($huruf);
                                @endphp

                                @if($soal->$fieldPilihan !== null && trim((string) $soal->$fieldPilihan) !== '')

                                    <button
                                        type="button"
                                        class="pilihan-jawaban group flex min-h-[70px] w-full items-center gap-3 rounded-2xl border-[4px] border-white bg-[#71bf4f] p-3 text-left text-white shadow-[0_5px_10px_rgba(0,0,0,0.12)] transition-all duration-200 hover:-translate-y-1 hover:bg-[#62aa43] hover:shadow-[0_22px_36px_rgba(113,191,79,0.35)] active:scale-95"
                                        data-option="{{ $huruf }}"
                                    >

                                        <span class="huruf-pilihan flex h-10 w-10 shrink-0 items-center justify-center rounded-full border-2 border-white bg-white text-base font-black text-[#1e60be] shadow">
                                            {{ $huruf }}
                                        </span>

                                        <span class="min-w-0 flex-1 break-words text-sm font-extrabold leading-snug sm:text-base">
                                            {{ $soal->$fieldPilihan }}
                                        </span>

                                        @if($soal->$fieldAudio)
                                            <span
                                                class="audio-pilihan flex h-9 w-9 shrink-0 cursor-pointer items-center justify-center rounded-full border-2 border-white bg-white/25 text-xl transition hover:scale-110 hover:bg-white/40"
                                                data-audio="{{ asset('storage/' . $soal->$fieldAudio) }}"
                                                title="Putar audio"
                                                role="button"
                                                aria-label="Putar audio pilihan {{ $huruf }}"
                                            >
                                                🔊
                                            </span>
                                        @endif

                                    </button>

                                @endif

                            @endforeach

                        </div>

                    </section>

                @endforeach

            </div>

            {{-- NAVIGASI --}}
            <div class="mx-auto mt-6 flex w-full max-w-2xl flex-wrap items-center justify-center gap-3 sm:gap-4">

                <button id="btnSebelumnya" type="button"
                        class="rounded-2xl border-[4px] border-white bg-[#5ebef3] px-5 py-3 font-black text-white shadow-lg transition hover:scale-105 hover:bg-[#47ade7] active:scale-95 disabled:cursor-not-allowed disabled:opacity-40 sm:px-7">
                    ← SEBELUMNYA
                </button>

                <button id="btnSelanjutnya" type="button"
                        class="rounded-2xl border-[4px] border-white bg-[#ffd629] px-5 py-3 font-black text-[#493b00] shadow-lg transition hover:scale-105 hover:bg-[#f0c313] active:scale-95 sm:px-7">
                    SELANJUTNYA →
                </button>

                <button id="btnSelesai" type="button"
                        class="hidden rounded-2xl border-[4px] border-white bg-[#71bf4f] px-7 py-3 font-black text-white shadow-lg transition hover:scale-105 hover:bg-[#62aa43] active:scale-95">
                    SELESAI ✓
                </button>

            </div>

        @else

            <div class="mx-auto w-full max-w-md rounded-[2rem] border-[5px] border-white bg-white/95 p-8 text-center shadow-lg">
                <div class="mb-3 text-6xl">📚</div>

                <h2 class="text-2xl font-black text-[#1e60be]">
                    Belum Ada Soal
                </h2>

                <p class="mt-2 font-semibold text-slate-600">
                    Soal kuis belum tersedia. Silakan kembali ke daftar kuis.
                </p>

                <a href="{{ $urlDaftarKuis }}"
                   class="mt-5 inline-flex rounded-2xl border-4 border-white bg-[#5ebef3] px-7 py-3 font-black text-white shadow-lg transition hover:scale-105 hover:bg-[#47ade7]">
                    ← KEMBALI
                </a>
            </div>

        @endif

    </main>

    <p class="relative z-10 my-8 text-center text-sm font-black text-white drop-shadow-lg">
        BUBA • Belajar sambil bermain 🌈
    </p>

</div>

{{-- MODAL KONFIRMASI --}}
<div id="modalKonfirmasi"
     class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 px-4">

    <div class="w-full max-w-sm rounded-[2rem] border-[5px] border-white bg-white p-6 text-center shadow-2xl sm:p-7">
        <div class="mb-3 text-6xl">🌟</div>

        <h2 class="text-2xl font-black text-[#1e60be]">
            SELESAIKAN KUIS?
        </h2>

        <p class="mt-3 font-bold text-slate-600">
            Apakah kamu yakin ingin mengumpulkan semua jawaban?
        </p>

        <div class="mt-6 flex flex-wrap justify-center gap-3">
            <button id="btnBatal" type="button"
                    class="rounded-full border-2 border-white bg-slate-300 px-6 py-3 font-black text-slate-700 shadow transition hover:scale-105">
                BELUM
            </button>

            <button id="btnKonfirmasiSelesai" type="button"
                    class="rounded-full border-2 border-white bg-[#71bf4f] px-6 py-3 font-black text-white shadow transition hover:scale-105 hover:bg-[#62aa43]">
                YA, SELESAI!
            </button>
        </div>
    </div>

</div>

{{-- LOADING --}}
<div id="loadingKuis"
     class="fixed inset-0 z-[60] hidden items-center justify-center bg-black/60 px-4">
    <div class="w-full max-w-xs rounded-[2rem] border-[5px] border-white bg-white p-8 text-center shadow-xl">
        <div class="mx-auto mb-4 h-12 w-12 animate-spin rounded-full border-4 border-blue-100 border-t-[#1e60be]"></div>

        <p class="font-black text-[#1e60be]">
            Menghitung hasil kuis...
        </p>

        <p class="mt-2 text-sm font-semibold text-slate-500">
            Tunggu sebentar, ya! ⭐
        </p>
    </div>
</div>

<style>
    .soal-card:not(.hidden) {
        display: block;
        animation: bubaAppear .25s ease;
    }

    .pilihan-jawaban.selected {
        background: #1e60be !important;
        border-color: #ffffff !important;
        box-shadow: 0 0 0 3px #93c5fd, 0 8px 18px rgba(30, 96, 190, 0.2);
        transform: translateY(-2px);
    }

    .pilihan-jawaban.selected .huruf-pilihan {
        background: #ffd629;
        color: #493b00;
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

<script>
document.addEventListener('DOMContentLoaded', function () {

    const cards = Array.from(document.querySelectorAll('.soal-card'));

    if (!cards.length) return;

    const totalSoal = cards.length;

    const urlSimpanHasil = @json($urlSimpanHasil);
    const urlHasilKuis = @json($urlHasilKuis);
    const urlDaftarKuis = @json($urlDaftarKuis);
    const urlUlangKuis = @json($urlUlangKuis);
    const namaKategori = @json($kategori->nama_kategori);

    const progressText = document.getElementById('progressText');
    const progressBar = document.getElementById('progressBar');

    const btnSebelumnya = document.getElementById('btnSebelumnya');
    const btnSelanjutnya = document.getElementById('btnSelanjutnya');
    const btnSelesai = document.getElementById('btnSelesai');

    const modal = document.getElementById('modalKonfirmasi');
    const loading = document.getElementById('loadingKuis');

    const btnBatal = document.getElementById('btnBatal');
    const btnKonfirmasiSelesai = document.getElementById('btnKonfirmasiSelesai');

    let nomorAktif = 0;
    let jawabanPengguna = {};
    let sedangMengirim = false;
    let audioAktif = null;

    // MENGHENTIKAN AUDIO
    function hentikanAudio() {
        if (audioAktif) {
            audioAktif.pause();
            audioAktif.currentTime = 0;
            audioAktif = null;
        }
    }

    // MEMUTAR AUDIO PILIHAN
    function putarAudio(sumber) {
        if (!sumber) return;

        hentikanAudio();

        audioAktif = new Audio(sumber);

        audioAktif.play().catch(error => {
            console.error('Audio gagal diputar:', error);
        });
    }

    // UPDATE PROGRESS
    function perbaruiProgress() {
        const jumlah = Object.keys(jawabanPengguna).length;

        progressText.textContent = `${jumlah} / ${totalSoal}`;
        progressBar.style.width = `${(jumlah / totalSoal) * 100}%`;
    }

    // MENAMPILKAN SOAL
    function tampilkanSoal(index) {
        if (index < 0 || index >= totalSoal) return;

        hentikanAudio();

        nomorAktif = index;

        cards.forEach((card, i) => {
            card.classList.toggle('hidden', i !== index);
        });

        const id = cards[index].dataset.id;

        cards[index].querySelectorAll('.pilihan-jawaban').forEach(button => {
            const dipilih = jawabanPengguna[id] === button.dataset.option;

            button.classList.toggle('selected', dipilih);
        });

        btnSebelumnya.disabled = index === 0;

        btnSelanjutnya.classList.toggle(
            'hidden',
            index === totalSoal - 1
        );

        btnSelesai.classList.toggle(
            'hidden',
            index !== totalSoal - 1
        );

        perbaruiProgress();

        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }

    // MEMILIH JAWABAN
    cards.forEach(card => {

        const id = card.dataset.id;

        card.querySelectorAll('.pilihan-jawaban').forEach(button => {

            button.addEventListener('click', function () {

                if (sedangMengirim) return;

                jawabanPengguna[id] = this.dataset.option;

                card.querySelectorAll('.pilihan-jawaban').forEach(item => {
                    item.classList.remove('selected');
                });

                this.classList.add('selected');

                perbaruiProgress();
            });

        });

        // AUDIO PILIHAN JAWABAN
        card.querySelectorAll('.audio-pilihan').forEach(audioButton => {

            audioButton.addEventListener('click', function (event) {
                event.stopPropagation();
                putarAudio(this.dataset.audio);
            });

            audioButton.addEventListener('keydown', function (event) {

                if (event.key === 'Enter' || event.key === ' ') {
                    event.preventDefault();
                    event.stopPropagation();
                    putarAudio(this.dataset.audio);
                }

            });

            audioButton.setAttribute('tabindex', '0');

        });

    });

    // SOAL SEBELUMNYA
    btnSebelumnya.addEventListener('click', function () {

        if (!sedangMengirim && nomorAktif > 0) {
            tampilkanSoal(nomorAktif - 1);
        }

    });

    // SOAL SELANJUTNYA
    btnSelanjutnya.addEventListener('click', function () {

        if (!sedangMengirim && nomorAktif < totalSoal - 1) {
            tampilkanSoal(nomorAktif + 1);
        }

    });

    // SELESAI KUIS
    btnSelesai.addEventListener('click', function () {

        if (Object.keys(jawabanPengguna).length < totalSoal) {

            const soalBelumDijawab = cards.findIndex(card => {
                return jawabanPengguna[card.dataset.id] === undefined;
            });

            if (soalBelumDijawab !== -1) {
                tampilkanSoal(soalBelumDijawab);
            }

            alert('Masih ada soal yang belum dijawab. Yuk, lengkapi dulu!');

            return;
        }

        modal.classList.remove('hidden');
        modal.classList.add('flex');

    });

    // BATAL SELESAI
    btnBatal.addEventListener('click', function () {

        modal.classList.add('hidden');
        modal.classList.remove('flex');

    });

    // KONFIRMASI DAN KIRIM HASIL
    btnKonfirmasiSelesai.addEventListener('click', async function () {

        if (sedangMengirim) return;

        sedangMengirim = true;

        this.disabled = true;

        loading.classList.remove('hidden');
        loading.classList.add('flex');

        try {

            const csrfMeta = document.querySelector('meta[name="csrf-token"]');
            const csrfInput = document.getElementById('csrfTokenBuba');

            const csrfToken = csrfMeta?.content || csrfInput?.value;

            if (!csrfToken) {
                throw new Error(
                    'Token keamanan tidak ditemukan. Periksa CSRF Token pada layout.'
                );
            }

            const response = await fetch(urlSimpanHasil, {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    jawaban: jawabanPengguna
                })
            });

            const hasilServer = await response.json();

            // JIKA KATEGORI SUDAH TERKUNCI
            if (response.status === 403 && hasilServer.terkunci) {
                window.location.href = urlDaftarKuis;
                return;
            }

            // JIKA SESSION BERAKHIR
            if (response.status === 419) {
                throw new Error(
                    'Sesi keamanan telah berakhir. Silakan muat ulang halaman dan kerjakan kembali kuis.'
                );
            }

            // JIKA SERVER GAGAL MENYIMPAN
            if (!response.ok) {
                throw new Error(
                    hasilServer.message || 'Gagal menyimpan hasil kuis.'
                );
            }

            // SIMPAN HASIL DARI SERVER
            sessionStorage.setItem('hasilKuisBuba', JSON.stringify({
                nilai: hasilServer.nilai,
                benar: hasilServer.benar,
                salah: hasilServer.salah,
                total: hasilServer.total,
                jumlah_bintang: hasilServer.jumlah_bintang,
                namaKuis: 'Kuis BUBA',
                namaKategori: namaKategori,
                daftarJawaban: hasilServer.daftarJawaban || [],
                retryUrl: urlUlangKuis
            }));

            // PINDAH KE HALAMAN HASIL
            window.location.assign(urlHasilKuis);

        } catch (error) {

            console.error(error);

            alert(
                error.message || 'Terjadi kesalahan saat mengirim jawaban.'
            );

            sedangMengirim = false;

            this.disabled = false;

            loading.classList.add('hidden');
            loading.classList.remove('flex');

            modal.classList.add('hidden');
            modal.classList.remove('flex');

        }

    });

    // TAMPILKAN SOAL PERTAMA
    tampilkanSoal(0);

});
</script>

@endsection
