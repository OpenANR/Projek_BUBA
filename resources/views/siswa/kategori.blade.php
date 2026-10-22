 @extends('layouts.siswa.app')

@section('title', 'Materi Kelas ' . $dataKelas->nama_kelas . ' - BUBA')

@section('content')
    @php
        $colors = [
            'bg-[#78c95b]',
            'bg-[#f5cd08]',
            'bg-[#c653c2]',
            'bg-[#e4145d]',
            'bg-[#56bdc8]',
            'bg-[#5139b4]',
            'bg-[#079b43]',
            'bg-[#4f840d]',
        ];
        $categoryIcons = [
            'huruf' => '🔠',
            'angka' => '🔢',
            'warna' => '🎨',
            'bentuk' => '🔴🟦',
            'hewan' => '🐈',
            'tubuh' => '🙆',
            'kebersihan' => '🛁',
            'tumbuhan' => '🪴',
        ];
    @endphp

    <div class="relative flex min-h-screen flex-col items-center overflow-hidden bg-cover bg-center px-4 py-5 sm:px-6"
        style="background-image: linear-gradient(rgba(0, 35, 53, .38), rgba(0, 35, 53, .38)), url('{{ asset('images/backgroundSplash.png') }}');">
        <a href="{{ route('siswa.kelas', ['konten' => $konten]) }}"
            class="absolute left-4 top-5 z-10 flex h-14 w-14 items-center justify-center rounded-full border-[3px] border-white bg-sky-400/90 text-white shadow-md transition hover:scale-105 hover:bg-sky-500 focus:outline-none focus:ring-4 focus:ring-white/70 sm:left-8 sm:top-6"
            aria-label="Kembali pilih kelas">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-8 w-8">
                <path d="M20 12a1 1 0 0 1-1 1H7.83l4.58 4.59L11 19l-7-7 7-7 1.41 1.41L7.83 11H19a1 1 0 0 1 1 1Z" />
            </svg>
        </a>

        <h1 class="mb-5 mt-1 rounded-[1.4rem] border-[5px] border-white bg-blue-600 px-5 py-2 text-center text-2xl font-extrabold tracking-wide text-white shadow-lg sm:px-8 sm:text-3xl">
            {{ strtoupper($konten) }} KELAS {{ strtoupper($dataKelas->nama_kelas) }}
        </h1>

        @if ($kategori->isNotEmpty())
            <div class="grid w-full max-w-[680px] grid-cols-2 gap-4 sm:grid-cols-4 sm:gap-5">
                @foreach ($kategori as $item)
                    @php
                        $namaKategori = mb_strtolower($item->nama_kategori);
                        $icon = '📚';
                        foreach ($categoryIcons as $kata => $emoji) {
                            if (str_contains($namaKategori, $kata)) {
                                $icon = $emoji;
                                break;
                            }
                        }
                        $warna = $colors[$loop->index % count($colors)];
                    @endphp
                    <a href="{{ route('siswa.materi', ['konten' => $konten, 'kelas' => $dataKelas->id, 'kategori' => $item->id]) }}"
                        class="flex min-h-[154px] flex-col items-center justify-between rounded-[1.4rem] border-[5px] border-white {{ $warna }} px-3 py-4 text-center text-white shadow-lg transition duration-200 hover:-translate-y-1 hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-white/70 sm:min-h-[162px]"
                        aria-label="Buka kategori {{ $item->nama_kategori }}">
                        <span class="text-base font-bold uppercase leading-snug sm:text-lg">{{ $item->nama_kategori }}</span>
                        <span class="text-4xl leading-none" aria-hidden="true">{{ $icon }}</span>
                    </a>
                @endforeach
            </div>
        @else
            <div class="rounded-2xl border-4 border-white bg-white/90 px-6 py-5 text-center font-semibold text-slate-700 shadow-lg">
                Belum ada kategori untuk kelas ini.
            </div>
        @endif
    </div>
@endsection
