@extends('layouts.admin.app')

@section('title', 'Detail Kuis - BUBA')

@section('content')

<div class="max-w-4xl mx-auto">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">

        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Detail Kuis
            </h1>

            <p class="text-gray-500 text-sm mt-1">
                Informasi lengkap pertanyaan dan pilihan jawaban kuis.
            </p>
        </div>

    </div>

    {{-- Card Detail Kuis --}}
    <div class="bg-white rounded-xl shadow-md p-6">

        {{-- Kode Kuis --}}
        <div class="mb-5">
            <p class="text-sm font-semibold text-gray-500 mb-2">
                Kode Kuis
            </p>

            <div class="bg-gray-50 rounded-lg p-4 text-gray-800 font-semibold">
                {{ $quis->kode_kuis }}
            </div>
        </div>

        {{-- Kelas --}}
        <div class="mb-5">
            <p class="text-sm font-semibold text-gray-500 mb-2">
                Kelas
            </p>

            <div class="bg-gray-50 rounded-lg p-4 text-gray-800 font-semibold">
                {{ $quis->kelas->nama_kelas ?? '-' }}
            </div>
        </div>

        {{-- Kategori --}}
        <div class="mb-5">
            <p class="text-sm font-semibold text-gray-500 mb-2">
                Kategori
            </p>

            <div class="bg-gray-50 rounded-lg p-4 text-gray-800 font-semibold">
                {{ $quis->kategori->nama_kategori ?? '-' }}
            </div>
        </div>

        {{-- Pertanyaan --}}
        <div class="mb-6">
            <p class="text-sm font-semibold text-gray-500 mb-2">
                Pertanyaan
            </p>

            <div class="bg-gray-50 rounded-lg p-4 text-gray-800 whitespace-pre-line">
                {{ $quis->pertanyaan ?: 'Belum ada pertanyaan.' }}
            </div>
        </div>

        {{-- Gambar --}}
        <div class="mb-6">

            <p class="text-sm font-semibold text-gray-500 mb-3">
                Gambar Soal
            </p>

            @php
                $gambar = $quis->gambar ?? [];

                if (is_string($gambar)) {
                    $decoded = json_decode($gambar, true);
                    $gambar = is_array($decoded) ? $decoded : [$gambar];
                }

                if (!is_array($gambar)) {
                    $gambar = [];
                }

                $gambar = array_filter($gambar);
            @endphp

            @if (count($gambar) > 0)

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

                    @foreach ($gambar as $file)
                        <a
                            href="{{ asset('storage/' . $file) }}"
                            target="_blank"
                            class="block"
                        >
                            <img
                                src="{{ asset('storage/' . $file) }}"
                                alt="Gambar soal"
                                class="w-full h-40 object-contain rounded-lg border border-gray-200 bg-gray-50 hover:shadow-md transition"
                            >
                        </a>
                    @endforeach

                </div>

            @else

                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 text-sm text-gray-500">
                    Tidak ada gambar.
                </div>

            @endif

        </div>

        {{-- Pilihan Jawaban --}}
        <div class="mb-6">

            <p class="text-sm font-semibold text-gray-500 mb-3">
                Pilihan Jawaban
            </p>

            <div class="space-y-3">

                @foreach (['a', 'b', 'c', 'd'] as $opsi)

                    @php
                        $isBenar = strtoupper($opsi) === strtoupper($quis->jawaban ?? '');
                    @endphp

                    <div class="rounded-lg p-4 border
                        {{ $isBenar
                            ? 'bg-green-50 border-green-300'
                            : 'bg-gray-50 border-gray-200' }}">

                        <div class="flex items-center justify-between gap-3">

                            <p class="text-sm font-semibold text-gray-500">
                                Pilihan {{ strtoupper($opsi) }}
                            </p>

                            @if ($isBenar)
                                <span class="text-xs font-bold text-green-600">
                                    ✓ Jawaban Benar
                                </span>
                            @endif

                        </div>

                        <p class="text-gray-800 font-semibold mt-2">
                            {{ $quis->{'pilihan_' . $opsi} ?? '-' }}
                        </p>

                    </div>

                @endforeach

            </div>

        </div>

        {{-- Jawaban Benar --}}
        <div class="mb-6">

            <p class="text-sm font-semibold text-gray-500 mb-2">
                Jawaban Benar
            </p>

            <div class="bg-blue-50 border border-blue-100 rounded-lg p-4 text-blue-700 font-bold">
                Pilihan {{ $quis->jawaban ?? '-' }}
            </div>

        </div>

        {{-- Audio --}}
        <div class="mb-6">

            <p class="text-sm font-semibold text-gray-500 mb-3">
                Audio
            </p>

            @php
                $daftarAudio = [
                    'audio_pertanyaan' => 'Audio Pertanyaan',
                    'audio_pilihan_a' => 'Audio Pilihan A',
                    'audio_pilihan_b' => 'Audio Pilihan B',
                    'audio_pilihan_c' => 'Audio Pilihan C',
                    'audio_pilihan_d' => 'Audio Pilihan D',
                ];
            @endphp

            <div class="space-y-4">

                @foreach ($daftarAudio as $field => $label)

                    @if (!empty($quis->$field))

                        @php
                            $extension = strtolower(
                                pathinfo($quis->$field, PATHINFO_EXTENSION)
                            );

                            $audioType = match ($extension) {
                                'mp3' => 'audio/mpeg',
                                'wav' => 'audio/wav',
                                'ogg' => 'audio/ogg',
                                'aac' => 'audio/aac',
                                default => 'audio/mpeg',
                            };
                        @endphp

                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">

                            <div class="flex items-center gap-3 mb-3">

                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                    🔊
                                </div>

                                <div>
                                    <p class="font-semibold text-gray-800">
                                        {{ $label }}
                                    </p>

                                    <p class="text-xs text-gray-500">
                                        {{ strtoupper($extension) }}
                                    </p>
                                </div>

                            </div>

                            <audio controls preload="metadata" class="w-full">
                                <source
                                    src="{{ asset('storage/' . $quis->$field) }}"
                                    type="{{ $audioType }}"
                                >

                                Browser kamu tidak mendukung pemutar audio.
                            </audio>

                        </div>

                    @else

                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">

                            <div class="flex items-center gap-3">

                                <div class="w-10 h-10 bg-gray-200 rounded-lg flex items-center justify-center">
                                    🔊
                                </div>

                                <div>
                                    <p class="font-semibold text-gray-800">
                                        {{ $label }}
                                    </p>

                                    <p class="text-xs text-gray-500">
                                        Tidak ada audio.
                                    </p>
                                </div>

                            </div>

                        </div>

                    @endif

                @endforeach

            </div>

        </div>

        {{-- Tombol --}}
        <div class="flex justify-end gap-3">

            <a
                href="{{ route('kuis.index') }}"
                class="px-5 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg"
            >
                Kembali
            </a>

            <a
                href="{{ route('kuis.edit', $quis->kode_kuis) }}"
                class="px-5 py-2.5 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded-lg"
            >
                Edit Kuis
            </a>

        </div>

    </div>

</div>

@endsection