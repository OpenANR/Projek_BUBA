<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuis BUBA</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: "Trebuchet MS", Arial, sans-serif;
            color: white;
            min-height: 100vh;
            overflow-x: hidden;
            background: linear-gradient(
                to bottom,
                #0785c5 0%,
                #42c5ee 48%,
                #b7e88b 49%,
                #5eaf43 75%,
                #39852e 100%
            );
        }

        button {
            font-family: inherit;
            cursor: pointer;
        }

        .game-world {
            position: relative;
            min-height: 100vh;
            padding: 18px 14px 45px;
            overflow: hidden;
        }

        /* Matahari dan awan */
        .sun {
            position: absolute;
            top: 18px;
            right: 6%;
            font-size: 36px;
            filter: drop-shadow(0 2px 3px #866b00);
        }

        .cloud {
            position: absolute;
            top: 25px;
            left: 25%;
            font-size: 29px;
            opacity: .9;
        }

        .hill {
            position: absolute;
            z-index: 0;
            bottom: -85px;
            width: 75vw;
            height: 230px;
            border-radius: 50% 50% 0 0;
            background: #69bd48;
        }

        .hill.left {
            left: -25%;
        }

        .hill.right {
            right: -30%;
            bottom: -110px;
            background: #438e37;
        }

        .tree {
            position: absolute;
            z-index: 1;
            bottom: 65px;
            font-size: 43px;
        }

        .tree.left {
            left: 2%;
        }

        .tree.right {
            right: 2%;
        }

        .topbar,
        .quiz-wrapper {
            position: relative;
            z-index: 2;
        }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 900px;
            margin: 0 auto 24px;
        }

        .back-button {
            width: 38px;
            height: 38px;
            border: 2px solid white;
            border-radius: 50%;
            color: white;
            background: #42b7ed;
            box-shadow: 0 3px 0 #1768a1;
            font-size: 21px;
            font-weight: bold;
        }

        .class-label {
            padding: 7px 22px;
            border: 2px solid white;
            border-radius: 9px;
            background: #1769d3;
            box-shadow: 0 3px 0 #124a94;
            font-size: 13px;
            font-weight: bold;
            text-align: center;
        }

        .quiz-wrapper {
            max-width: 760px;
            margin: 0 auto;
        }

        .quiz-heading {
            text-align: center;
            margin-bottom: 20px;
            text-shadow: 0 2px 2px #39713b;
        }

        .quiz-heading h1 {
            margin: 0 0 7px;
            font-size: clamp(22px, 4vw, 32px);
        }

        .quiz-heading p {
            margin: 0;
            font-size: 14px;
        }

        .progress-area {
            max-width: 480px;
            margin: 0 auto 18px;
        }

        .progress-text {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 6px;
            text-shadow: 0 1px 2px #39713b;
        }

        .progress-track {
            height: 12px;
            background: #ffffffa8;
            border: 2px solid white;
            border-radius: 20px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            width: 0%;
            background: #ffd629;
            border-radius: 20px;
            transition: width .25s;
        }

        .question-card {
            display: none;
            width: 100%;
            min-height: 285px;
            padding: 24px 20px;
            border: 3px solid white;
            border-radius: 17px;
            box-shadow: 0 6px 0 #00000020;
            text-align: center;
            animation: appear .25s ease;
        }

        .question-card.active {
            display: block;
        }

        @keyframes appear {
            from {
                opacity: 0;
                transform: translateY(8px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .question-number {
            display: inline-block;
            padding: 5px 12px;
            margin-bottom: 12px;
            border-radius: 20px;
            background: #ffffff38;
            font-size: 12px;
            font-weight: bold;
        }

        .question-text {
            margin: 0 auto 16px;
            max-width: 550px;
            font-size: clamp(16px, 3vw, 21px);
            line-height: 1.5;
            font-weight: bold;
            text-transform: uppercase;
        }

        .question-images {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            margin: 12px 0 20px;
        }

        .question-images img {
            width: 95px;
            height: 95px;
            object-fit: contain;
            border-radius: 10px;
            background: #ffffffec;
            padding: 5px;
        }

        .options {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
            max-width: 520px;
            margin: 18px auto 0;
        }

        .option {
            min-height: 58px;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border: 2px solid #ffffffde;
            border-radius: 13px;
            color: #263238;
            background: #ffffffed;
            text-align: left;
            font-size: 14px;
            font-weight: bold;
            box-shadow: 0 3px 0 #00000018;
            transition: transform .15s, background .15s;
        }

        .option:hover {
            transform: translateY(-2px);
            background: #fff6bc;
        }

        .option-letter {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            width: 27px;
            height: 27px;
            border-radius: 50%;
            color: white;
            background: #3d8de0;
        }

        .option.selected {
            background: #fff0a1;
            border-color: #ffca28;
        }

        .option.correct {
            background: #b7f5a8;
            border-color: #239b36;
        }

        .option.wrong {
            background: #ffc3c3;
            border-color: #e53935;
        }

        .feedback {
            min-height: 24px;
            margin-top: 14px;
            font-size: 14px;
            font-weight: bold;
        }

        .quiz-actions {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 12px;
            margin: 20px 0;
        }

        .action-button {
            border: 2px solid white;
            border-radius: 12px;
            padding: 12px 22px;
            font-size: 14px;
            font-weight: bold;
            box-shadow: 0 4px 0 #00000024;
        }

        .next-button {
            background: #ffd52e;
            color: #493b00;
        }

        .finish-button {
            background: #138b48;
            color: white;
        }

        .action-button:disabled {
            opacity: .55;
            cursor: not-allowed;
        }

        .result-card,
        .empty-card {
            display: none;
            padding: 30px 20px;
            text-align: center;
            background: white;
            color: #263238;
            border: 3px solid white;
            border-radius: 18px;
            box-shadow: 0 6px 0 #00000020;
        }

        .result-card h2,
        .empty-card h2 {
            color: #258a43;
        }

        .result-score {
            color: #1769d3;
            font-size: 42px;
            font-weight: bold;
        }

        .small-note {
            font-size: 12px;
            opacity: .9;
            margin-top: 18px;
        }

        @media (max-width: 480px) {
            .game-world {
                padding: 14px 10px 35px;
            }

            .topbar {
                margin-bottom: 18px;
            }

            .question-card {
                padding: 20px 12px;
            }

            .options {
                gap: 8px;
            }

            .option {
                padding: 9px 7px;
                font-size: 12px;
                gap: 6px;
            }

            .option-letter {
                width: 24px;
                height: 24px;
            }

            .question-images img {
                width: 75px;
                height: 75px;
            }
        }
    </style>
</head>

<body>
<div class="game-world">

    <div class="sun">☀️</div>
    <div class="cloud">☁️</div>
    <div class="hill left"></div>
    <div class="hill right"></div>
    <div class="tree left">🌳</div>
    <div class="tree right">🌳</div>

    <header class="topbar">
        <button class="back-button"
            onclick="window.location.href='{{ url('/siswa/konten') }}'"
            aria-label="Kembali">‹</button>

        <div class="class-label">
            KUIS {{ strtoupper($dataKelas->nama_kelas ?? 'ANAK') }}
        </div>

        <div style="width:38px"></div>
    </header>

    <main class="quiz-wrapper">

        <div class="quiz-heading">
            <h1>🎮 Ayo Bermain Kuis!</h1>
            <p>
                Kategori:
                <strong>{{ $dataKategori->nama_kategori ?? 'Pembelajaran' }}</strong>
            </p>
        </div>

        @if($quis->count() > 0)

            <div class="progress-area" id="progressArea">
                <div class="progress-text">
                    <span id="progressLabel">Soal 1</span>
                    <span id="progressCount">0/{{ $quis->count() }} dijawab</span>
                </div>
                <div class="progress-track">
                    <div class="progress-fill" id="progressFill"></div>
                </div>
            </div>

            @php
                $warnaKartu = [
                    '#78c95a',
                    '#f4cf18',
                    '#c95ac5',
                    '#56c3ce',
                    '#6048c7',
                    '#079447',
                    '#477f13',
                    '#f28b36',
                ];
            @endphp

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
                    class="question-card {{ $index === 0 ? 'active' : '' }}"
                    data-index="{{ $index }}"
                    data-answer="{{ strtoupper($item->jawaban ?? '') }}"
                    style="background: {{ $warnaKartu[$index % count($warnaKartu)] }}">

                    <div class="question-number">
                        SOAL {{ $index + 1 }}
                    </div>

                    <h2 class="question-text">
                        {{ $item->pertanyaan }}
                    </h2>

                    @if(count($gambar) > 0)
                        <div class="question-images">
                            @foreach($gambar as $file)
                                <img
                                    src="{{ asset('storage/' . $file) }}"
                                    alt="Gambar soal {{ $index + 1 }}"
                                    onerror="this.style.display='none'">
                            @endforeach
                        </div>
                    @endif

                    <div class="options">
                        @foreach($pilihan as $huruf => $teks)
                            @if($teks !== null && $teks !== '')
                                <button
                                    type="button"
                                    class="option"
                                    data-letter="{{ $huruf }}"
                                    onclick="pilihJawaban({{ $index }}, '{{ $huruf }}', this)">

                                    <span class="option-letter">{{ $huruf }}</span>
                                    <span>{{ $teks }}</span>
                                </button>
                            @endif
                        @endforeach
                    </div>

                    <div class="feedback" aria-live="polite"></div>
                </section>
            @endforeach

            <div class="quiz-actions" id="quizActions">
                <button class="action-button next-button"
                    id="nextButton"
                    onclick="soalBerikutnya()">
                    Soal Berikutnya ➜
                </button>

                <button class="action-button finish-button"
                    id="finishButton"
                    onclick="selesaiKuis()">
                    Lihat Nilai ⭐
                </button>
            </div>

            <section class="result-card" id="resultCard">
                <div style="font-size:48px">🏆</div>
                <h2>Kuis Selesai!</h2>
                <p>Hebat! Kamu sudah menyelesaikan kuis ini.</p>
                <div class="result-score" id="resultScore">0</div>
                <p id="resultDetail"></p>

                <button class="action-button next-button"
                    onclick="location.reload()">
                    Main Lagi 🔄
                </button>

                <button class="action-button finish-button"
                    onclick="window.location.href='{{ url('/siswa/konten') }}'">
                    Kembali
                </button>
            </section>

        @else
            <section class="empty-card" style="display:block">
                <div style="font-size:55px">📚</div>
                <h2>Belum Ada Soal</h2>
                <p>Soal untuk kelas dan kategori ini belum tersedia.</p>
                <p>Yuk, coba kategori pembelajaran lainnya!</p>

                <button class="action-button next-button"
                    onclick="window.location.href='{{ url('/siswa/konten') }}'">
                    Kembali
                </button>
            </section>
        @endif

        <p class="small-note" style="text-align:center">
            BUBA • Belajar sambil bermain 🌈
        </p>

    </main>
</div>

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
                ? 'Soal Terakhir ✓'
                : 'Soal Berikutnya ➜';
    }

    function tampilkanSoal(index) {
        cards.forEach((card, i) => {
            card.classList.toggle('active', i === index);
        });

        nomorAktif = index;
        perbaruiProgres();
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
            'Jawaban dipilih! Kamu bisa lanjut ke soal berikutnya 😊';

        perbaruiProgres();
    }

    function soalBerikutnya() {
        if (nomorAktif < totalSoal - 1) {
            tampilkanSoal(nomorAktif + 1);
        } else {
            const belumDijawab = cards.findIndex(
                (_, index) => jawabanPengguna[index] === undefined
            );

            if (belumDijawab !== -1) {
                tampilkanSoal(belumDijawab);
                alert('Ayo jawab soal ini terlebih dahulu! 😊');
            } else {
                selesaiKuis();
            }
        }
    }

    function selesaiKuis() {
        if (Object.keys(jawabanPengguna).length < totalSoal) {
            const belumDijawab = cards.findIndex(
                (_, index) => jawabanPengguna[index] === undefined
            );

            if (belumDijawab !== -1) {
                tampilkanSoal(belumDijawab);
                alert('Masih ada soal yang belum dijawab, ya! 😊');
                return;
            }
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

        cards.forEach(card => card.classList.remove('active'));

        document.getElementById('progressArea').style.display = 'none';
        document.getElementById('quizActions').style.display = 'none';

        document.getElementById('resultCard').style.display = 'block';
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

</body>
</html>
