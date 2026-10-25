@extends('layouts.siswa.app')

@section('title', 'Pilih Kategori - BUBA')

@section('content')
    @php
        $palettes = [
            [
                'bg'       => 'bg-[#71bf4f]',
                'hover_bg' => 'hover:bg-[#62aa43]',
                'shadow'   => 'hover:shadow-[0_22px_36px_rgba(113,191,79,0.45)]',
            ],
            [
                'bg'       => 'bg-[#faa63a]',
                'hover_bg' => 'hover:bg-[#e89427]',
                'shadow'   => 'hover:shadow-[0_22px_36px_rgba(250,166,58,0.45)]',
            ],
            [
                'bg'       => 'bg-[#d8759c]',
                'hover_bg' => 'hover:bg-[#ca5e88]',
                'shadow'   => 'hover:shadow-[0_22px_36px_rgba(216,117,156,0.45)]',
            ],
            [
                'bg'       => 'bg-[#5ebef3]',
                'hover_bg' => 'hover:bg-[#47ade7]',
                'shadow'   => 'hover:shadow-[0_22px_36px_rgba(94,190,243,0.45)]',
            ],
            [
                'bg'       => 'bg-[#9c65cd]',
                'hover_bg' => 'hover:bg-[#894fc0]',
                'shadow'   => 'hover:shadow-[0_22px_36px_rgba(156,101,205,0.45)]',
            ],
            [
                'bg'       => 'bg-[#ffd629]',
                'hover_bg' => 'hover:bg-[#f0c313]',
                'shadow'   => 'hover:shadow-[0_22px_36px_rgba(255,214,41,0.45)]',
            ],
            [
                'bg'       => 'bg-[#3cbdb1]',
                'hover_bg' => 'hover:bg-[#2fa89d]',
                'shadow'   => 'hover:shadow-[0_22px_36px_rgba(60,189,177,0.45)]',
            ],
            [
                'bg'       => 'bg-[#f36b6b]',
                'hover_bg' => 'hover:bg-[#df5555]',
                'shadow'   => 'hover:shadow-[0_22px_36px_rgba(243,107,107,0.45)]',
            ],
        ];

        $categoryIcons = [
            'baca'        => ['type' => 'image', 'value' => asset('images/icon-materi.png')],
            'materi'      => ['type' => 'image', 'value' => asset('images/icon-materi.png')],
            'buku'        => ['type' => 'image', 'value' => asset('images/icon-materi.png')],
            'kuis'        => ['type' => 'image', 'value' => asset('images/icon-kuis.png')],
            'soal'        => ['type' => 'image', 'value' => asset('images/icon-kuis.png')],
            'latihan'     => ['type' => 'image', 'value' => asset('images/icon-kuis.png')],
            'komputer'    => ['type' => 'emoji', 'value' => '💻'],
            'operasi'     => ['type' => 'emoji', 'value' => '💻'],
            'sistem'      => ['type' => 'emoji', 'value' => '💻'],
            'teknologi'   => ['type' => 'emoji', 'value' => '💻'],
            'huruf'       => ['type' => 'emoji', 'value' => '🔠'],
            'abjad'       => ['type' => 'emoji', 'value' => '🔤'],
            'alfabet'     => ['type' => 'emoji', 'value' => '🔤'],
            'angka'       => ['type' => 'emoji', 'value' => '🔢'],
            'hitung'      => ['type' => 'emoji', 'value' => '🧮'],
            'matematika'  => ['type' => 'emoji', 'value' => '🧮'],
            'warna'       => ['type' => 'emoji', 'value' => '🎨'],
            'gambar'      => ['type' => 'emoji', 'value' => '🎨'],
            'seni'        => ['type' => 'emoji', 'value' => '🎨'],
            'bentuk'      => ['type' => 'emoji', 'value' => '🔺🟦'],
            'hewan'       => ['type' => 'emoji', 'value' => '🦁'],
            'binatang'    => ['type' => 'emoji', 'value' => '🐱'],
            'fauna'       => ['type' => 'emoji', 'value' => '🦁'],
            'tumbuhan'    => ['type' => 'emoji', 'value' => '🪴'],
            'tanaman'     => ['type' => 'emoji', 'value' => '🌻'],
            'flora'       => ['type' => 'emoji', 'value' => '🪴'],
            'tubuh'       => ['type' => 'emoji', 'value' => '🙆'],
            'indra'       => ['type' => 'emoji', 'value' => '👀'],
            'kebersihan'  => ['type' => 'emoji', 'value' => '🛁'],
            'sehat'       => ['type' => 'emoji', 'value' => '🍎'],
            'sains'       => ['type' => 'emoji', 'value' => '🔬'],
            'ipa'         => ['type' => 'emoji', 'value' => '🔬'],
            'alam'        => ['type' => 'emoji', 'value' => '🌈'],
            'musik'       => ['type' => 'emoji', 'value' => '🎵'],
            'nyanyi'      => ['type' => 'emoji', 'value' => '🎤'],
            'olahraga'    => ['type' => 'emoji', 'value' => '⚽'],
            'bicara'      => ['type' => 'emoji', 'value' => '💬'],
            'agama'       => ['type' => 'emoji', 'value' => '⭐'],
        ];

        $defaultIcon = ($konten === 'kuis')
            ? ['type' => 'image', 'value' => asset('images/icon-kuis.png')]
            : ['type' => 'image', 'value' => asset('images/icon-materi.png')];
    @endphp

    <!-- Container Utama (Fullscreen responsif) -->
    <div class="relative flex h-screen min-h-[600px] w-full flex-col items-center justify-between overflow-x-hidden overflow-y-auto px-4 py-5 select-none sm:overflow-hidden sm:px-6 md:px-8">

        <!-- 1. Background Image -->
        <img src="{{ asset('images/backgroundSplash.png') }}" alt="BUBA Background"
            class="pointer-events-none absolute inset-0 z-0 h-full w-full select-none object-cover object-bottom">

        <!-- 2. Tombol Kembali (Top Left) -->
        <div class="absolute left-4 top-4 z-30 sm:left-6 sm:top-6 md:left-8 md:top-8">
            <a href="{{ route('siswa.kelas', ['konten' => $konten]) }}"
                class="group flex h-12 w-12 items-center justify-center rounded-full border-[4px] border-white bg-[#5ebef3] text-white shadow-[0_6px_14px_rgba(0,0,0,0.18)] transition-all duration-200 hover:scale-110 hover:bg-[#47ade7] hover:shadow-xl active:scale-90 active:translate-y-0.5 focus:outline-none focus:ring-4 focus:ring-white/70 sm:h-14 sm:w-14 md:h-16 md:w-16 md:border-[5px]"
                aria-label="Kembali ke pilihan kelas">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                    class="h-6 w-6 text-white drop-shadow transition-transform duration-200 group-hover:-translate-x-0.5 sm:h-7 sm:w-7 md:h-8 md:w-8">
                    <path d="M16 5.5a1 1 0 0 0-1.6-.8l-9 7a1 1 0 0 0 0 1.6l9 7A1 1 0 0 0 16 19.5V5.5z" />
                </svg>
            </a>
        </div>

        <!-- 3. Header Banner: MATERI/KUIS KELAS (Center Top) -->
        <div class="relative z-10 flex items-center justify-center pt-2 sm:pt-4 md:pt-6">
            <div class="rounded-2xl border-[4px] border-white bg-[#1e60be] px-7 py-2 shadow-[0_8px_20px_rgba(0,0,0,0.2)] transition-transform duration-300 hover:scale-105 sm:rounded-[2rem] sm:border-[5px] sm:px-10 sm:py-3 md:rounded-[2.2rem] md:border-[6px] md:px-14 md:py-3.5">
                <h1 class="text-center font-sans text-2xl font-black tracking-wider text-white drop-shadow-[0_2px_4px_rgba(0,0,0,0.3)] sm:text-3xl md:text-4xl lg:text-[2.6rem]">
                    {{ strtoupper($konten) }} KELAS {{ strtoupper($kelas->nama_kelas) }}
                </h1>
            </div>
        </div>

        <!-- 4. Pilihan Kategori (Center) -->
        @if ($kategori->isNotEmpty())
            <div class="relative z-10 my-auto flex w-full max-w-5xl flex-wrap items-center justify-center gap-5 px-4 py-4 sm:gap-8 md:gap-10">
                @foreach ($kategori as $item)
                    @php
                        $namaLower = mb_strtolower($item->nama_kategori);
                        $iconData = $defaultIcon;

                        foreach ($categoryIcons as $keyword => $data) {
                            if (str_contains($namaLower, $keyword)) {
                                $iconData = $data;
                                break;
                            }
                        }

                        $palette = $palettes[$loop->index % count($palettes)];
                        $routeName = ($konten === 'kuis') ? 'siswa.kuis' : 'siswa.materi';
                    @endphp

                    <a href="{{ route($routeName, ['konten' => $konten, 'kelas' => trim($kelas->nama_kelas), 'kategori' => $item->id]) }}"
                        class="group relative flex flex-col items-center justify-between w-48 h-60 sm:w-56 sm:h-72 md:w-64 md:h-80 p-5 sm:p-6 md:p-7 {{ $palette['bg'] }} {{ $palette['hover_bg'] }} border-[5px] sm:border-[6px] md:border-8 border-white rounded-[2rem] sm:rounded-[2.4rem] md:rounded-[2.8rem] shadow-[0_12px_24px_rgba(0,0,0,0.18)] transition-all duration-300 ease-out hover:scale-105 hover:-translate-y-2.5 {{ $palette['shadow'] }} active:scale-95 active:translate-y-1 active:shadow-md focus:outline-none focus:ring-4 focus:ring-white/70"
                        aria-label="Pilih kategori {{ $item->nama_kategori }}">

                        <!-- Ilustrasi / Ikon Kategori -->
                        <div class="flex-1 flex items-center justify-center w-full">
                            @if ($iconData['type'] === 'image')
                                <img src="{{ $iconData['value'] }}" alt="{{ $item->nama_kategori }}"
                                    class="w-24 h-24 sm:w-28 sm:h-28 md:w-36 md:h-36 object-contain drop-shadow-md transition-all duration-300 ease-out group-hover:scale-110 group-hover:-rotate-3 group-hover:-translate-y-1">
                            @else
                                <span class="text-6xl sm:text-7xl md:text-8xl drop-shadow-md transition-all duration-300 ease-out group-hover:scale-110 group-hover:-rotate-6 group-hover:-translate-y-1 select-none"
                                    aria-hidden="true">{{ $iconData['value'] }}</span>
                            @endif
                        </div>

                        <!-- Label Nama Kategori -->
                        <span class="text-white font-black text-xl sm:text-2xl md:text-3xl tracking-wider text-center drop-shadow-[0_2px_4px_rgba(0,0,0,0.25)] font-sans uppercase line-clamp-2">
                            {{ $item->nama_kategori }}
                        </span>
                    </a>
                @endforeach
            </div>
        @else
            <!-- State Kosong jika belum ada kategori -->
            <div class="relative z-10 my-auto flex flex-col items-center justify-center rounded-[2rem] border-[5px] border-white bg-white/95 px-8 py-6 text-center shadow-[0_10px_25px_rgba(0,0,0,0.18)] max-w-md">
                <span class="text-5xl mb-2">📁</span>
                <p class="text-lg font-black text-[#1e60be]">Belum Ada Kategori</p>
                <p class="text-sm font-semibold text-slate-600 mt-1">Kategori pembelajaran untuk kelas ini belum tersedia.</p>
            </div>
        @endif

        <!-- 5. Spacer Bawah (Menjaga ilustrasi rumput & anak-anak tetap terlihat) -->
        <div class="relative z-10 h-6 shrink-0 sm:h-10 md:h-14"></div>

    </div>
@endsection
