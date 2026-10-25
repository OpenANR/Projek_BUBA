@extends('layouts.admin.app')

@section('title', 'Detail Paket Kuis - BUBA')

@section('content')

<div class="max-w-5xl mx-auto">

    {{-- HEADER --}}
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">
            Detail Paket Kuis
        </h1>
        <p class="text-gray-500 text-sm mt-1">
            Informasi paket dan seluruh soal kuis.
        </p>
    </div>

    {{-- INFORMASI PAKET --}}
    <div class="bg-white rounded-xl shadow-md p-6 mb-6">

        <h2 class="text-xl font-bold text-gray-800 mb-5">
            Informasi Paket
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            <div>
                <p class="text-sm font-semibold text-gray-500 mb-2">
                    Nama Paket Kuis
                </p>
                <div class="bg-gray-50 rounded-lg p-4 text-gray-800 font-semibold">
                    {{ $paket->nama_kuis ?? '-' }}
                </div>
            </div>

            <div>
                <p class="text-sm font-semibold text-gray-500 mb-2">
                    Kelas
                </p>
                <div class="bg-gray-50 rounded-lg p-4 text-gray-800 font-semibold">
                    {{ $paket->nama_kelas ?? '-' }}
                </div>
            </div>

            <div>
                <p class="text-sm font-semibold text-gray-500 mb-2">
                    Kategori
                </p>
                <div class="bg-gray-50 rounded-lg p-4 text-gray-800 font-semibold">
                    {{ $paket->nama_kategori ?? '-' }}
                </div>
            </div>

            <div>
                <p class="text-sm font-semibold text-gray-500 mb-2">
                    Jumlah Soal
                </p>
                <div class="bg-blue-50 rounded-lg p-4 text-blue-700 font-bold">
                    {{ $quis->count() }} Soal
                </div>
            </div>

        </div>
    </div>

    {{-- DAFTAR SOAL --}}
    <div class="bg-white rounded-xl shadow-md p-6">

        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-xl font-bold text-gray-800">
                    Daftar Soal Kuis
                </h2>
                <p class="text-gray-500 text-sm mt-1">
                    Detail pertanyaan dan pilihan jawaban.
                </p>
            </div>
        </div>

        @forelse ($quis as $index => $soal)

            @php
                $gambar = $soal->gambar ?? [];

                if (is_string($gambar)) {
                    $decoded = json_decode($gambar, true);
                    $gambar = is_array($decoded) ? $decoded : [$gambar];
                }

                if (!is_array($gambar)) {
                    $gambar = [];
                }

                $gambar = array_filter($gambar);

                $daftarAudio = [
                    'audio_pertanyaan' => 'Audio Pertanyaan',
                    'audio_pilihan_a' => 'Audio Pilihan A',
                    'audio_pilihan_b' => 'Audio Pilihan B',
                    'audio_pilihan_c' => 'Audio Pilihan C',
                    'audio_pilihan_d' => 'Audio Pilihan D',
                ];
            @endphp

            <div class="border border-gray-200 rounded-xl p-5 mb-6">

                {{-- HEADER SOAL --}}
                <div class="flex flex-wrap justify-between items-center gap-3 mb-5 pb-4 border-b">

                    <div>
                        <h3 class="text-lg font-bold text-gray-800">
                            Soal {{ $index + 1 }}
                        </h3>
                        <p class="text-xs text-gray-500 mt-1">
                            Kode: {{ $soal->kode_kuis ?? '-' }}
                        </p>
                    </div>

                    <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold">
                        {{ $soal->jawaban ?? '-' }}
                    </span>

                </div>

                {{-- PERTANYAAN --}}
                <div class="mb-6">
                    <p class="text-sm font-semibold text-gray-500 mb-2">
                        Pertanyaan
                    </p>

                    <div class="bg-gray-50 rounded-lg p-4 text-gray-800">
                        {{ $soal->pertanyaan ?? '-' }}
                    </div>
                </div>

                {{-- GAMBAR --}}
                <div class="mb-6">

                    <p class="text-sm font-semibold text-gray-500 mb-3">
                        Gambar Soal
                    </p>

                    @if (count($gambar) > 0)

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

                            @foreach ($gambar as $file)
                                <a
                                    href="{{ asset('storage/' . $file) }}"
                                    target="_blank"
                                    class="block">

                                    <img
                                        src="{{ asset('storage/' . $file) }}"
                                        alt="Gambar soal"
                                        class="w-full h-40 object-contain rounded-lg border border-gray-200 bg-gray-50 hover:shadow-md transition">
                                </a>
                            @endforeach

                        </div>

                    @else

                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 text-sm text-gray-500">
                            Tidak ada gambar.
                        </div>

                    @endif

                </div>

                {{-- PILIHAN JAWABAN --}}
                <div class="mb-6">

                    <p class="text-sm font-semibold text-gray-500 mb-3">
                        Pilihan Jawaban
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        @foreach (['a', 'b', 'c', 'd'] as $opsi)

                            <div class="border rounded-lg p-4
                                {{ strtoupper($opsi) == $soal->jawaban
                                    ? 'border-green-300 bg-green-50'
                                    : 'border-gray-200 bg-white' }}">

                                <div class="flex justify-between items-center mb-1">

                                    <p class="text-sm text-gray-500">
                                        Pilihan {{ strtoupper($opsi) }}
                                    </p>

                                    @if (strtoupper($opsi) == $soal->jawaban)
                                        <span class="text-xs font-bold text-green-600">
                                            Jawaban Benar
                                        </span>
                                    @endif

                                </div>

                                <p class="font-semibold text-gray-800">
                                    {{ $soal->{'pilihan_' . $opsi} ?? '-' }}
                                </p>

                            </div>

                        @endforeach

                    </div>

                </div>

                {{-- AUDIO --}}
                <div class="border-t border-gray-200 pt-5">

                    <p class="text-sm font-semibold text-gray-500 mb-3">
                        Audio Soal dan Pilihan Jawaban
                    </p>

                    <div class="space-y-4">

                        @foreach ($daftarAudio as $field => $label)

                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">

                                <div class="flex items-center gap-3 mb-3">

                                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center text-xl">
                                        🔊
                                    </div>

                                    <div>
                                        <p class="font-semibold text-gray-800">
                                            {{ $label }}
                                        </p>

                                        @if (!empty($soal->$field))
                                            <p class="text-xs text-green-600">
                                                Audio tersedia
                                            </p>
                                        @else
                                            <p class="text-xs text-gray-500">
                                                Audio belum ditambahkan
                                            </p>
                                        @endif
                                    </div>

                                </div>

                                @if (!empty($soal->$field))

                                    @php
                                        $extension = strtolower(
                                            pathinfo($soal->$field, PATHINFO_EXTENSION)
                                        );

                                        $audioType = match ($extension) {
                                            'mp3' => 'audio/mpeg',
                                            'wav' => 'audio/wav',
                                            'ogg' => 'audio/ogg',
                                            default => 'audio/mpeg',
                                        };
                                    @endphp

                                    <audio controls preload="metadata" class="w-full">
                                        <source
                                            src="{{ asset('storage/' . $soal->$field) }}"
                                            type="{{ $audioType }}">

                                        Browser tidak mendukung pemutar audio.
                                    </audio>

                                @else

                                    <p class="text-sm text-gray-400 italic">
                                        Tidak ada file audio.
                                    </p>

                                @endif

                            </div>

                        @endforeach

                    </div>
                </div>

            </div>

        @empty

            <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 text-center">
                <p class="text-gray-500">
                    Belum ada soal dalam paket kuis ini.
                </p>
            </div>

        @endforelse

        {{-- TOMBOL --}}
        <div class="flex justify-end gap-3 border-t border-gray-200 pt-6">

            <a
                href="{{ route('kuis.index') }}"
                class="px-5 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition">
                Kembali
            </a>

            <a
                href="{{ route('kuis.edit', $paket->id) }}"
                class="px-5 py-2.5 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded-lg transition">
                Edit Paket Kuis
            </a>

        </div>

    </div>

</div>

@endsection
