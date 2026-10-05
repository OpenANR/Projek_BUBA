@extends('layouts.admin.app')

@section('title', 'Detail Kuis - BUBA')

@section('content')

<div class="max-w-4xl mx-auto">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">

        <div>

            <h1 class="text-3xl font-bold text-gray-800">
                Detail Soal Kuis
            </h1>

            <p class="text-gray-500 text-sm mt-1">
                Informasi lengkap soal kuis.
            </p>

        </div>

        <a
            href="{{ route('kuis.index') }}"
            class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg"
        >
            Kembali
        </a>

    </div>


    <div class="bg-white rounded-xl shadow-md p-6">

        {{-- Kode --}}
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
        <div class="mb-6">

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

            <div class="bg-gray-50 rounded-lg p-4 text-gray-800">
                {{ $quis->pertanyaan }}
            </div>

        </div>


        {{-- Gambar --}}
        @php

            $gambar = $quis->gambar ?? [];

            if (!is_array($gambar)) {
                $gambar = [$gambar];
            }

        @endphp

        <div class="mb-6">

            <p class="text-sm font-semibold text-gray-500 mb-3">
                Gambar
            </p>

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


        {{-- Audio --}}
        <div class="mb-6">

            <p class="text-sm font-semibold text-gray-500 mb-2">
                Audio
            </p>

            @if ($quis->audio)

                <audio controls class="w-full">
                    <source src="{{ asset('storage/' . $quis->audio) }}">
                    Browser tidak mendukung audio.
                </audio>

            @else

                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 text-sm text-gray-500">
                    Tidak ada audio.
                </div>

            @endif

        </div>


        {{-- Pilihan --}}
        <div class="mb-6">

            <p class="text-sm font-semibold text-gray-500 mb-3">
                Pilihan Jawaban
            </p>

            <div class="grid md:grid-cols-2 gap-4">

                <div class="border border-gray-200 rounded-lg p-4">
                    <p class="text-sm text-gray-500 mb-1">
                        Pilihan A
                    </p>
                    <p class="font-semibold text-gray-800">
                        {{ $quis->pilihan_a }}
                    </p>
                </div>


                <div class="border border-gray-200 rounded-lg p-4">
                    <p class="text-sm text-gray-500 mb-1">
                        Pilihan B
                    </p>
                    <p class="font-semibold text-gray-800">
                        {{ $quis->pilihan_b }}
                    </p>
                </div>


                <div class="border border-gray-200 rounded-lg p-4">
                    <p class="text-sm text-gray-500 mb-1">
                        Pilihan C
                    </p>
                    <p class="font-semibold text-gray-800">
                        {{ $quis->pilihan_c }}
                    </p>
                </div>


                <div class="border border-gray-200 rounded-lg p-4">
                    <p class="text-sm text-gray-500 mb-1">
                        Pilihan D
                    </p>
                    <p class="font-semibold text-gray-800">
                        {{ $quis->pilihan_d }}
                    </p>
                </div>

            </div>

        </div>


        {{-- Jawaban --}}
        <div class="mb-6">

            <p class="text-sm font-semibold text-gray-500 mb-2">
                Jawaban Benar
            </p>

            <span class="inline-flex px-4 py-2 bg-green-100 text-green-700 rounded-lg font-bold">
                {{ $quis->jawaban }}
            </span>

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
                href="{{ route('kuis.edit', $quis) }}"
                class="px-5 py-2.5 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded-lg"
            >
                Edit Soal
            </a>

        </div>

    </div>

</div>

@endsection
