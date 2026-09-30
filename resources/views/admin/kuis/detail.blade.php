@extends('layouts.admin.app')

@section('title', 'Detail Kuis - BUBA')

@section('content')

<div class="max-w-4xl mx-auto">

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
        @if ($quis->gambar)

            <div class="mb-6">

                <p class="text-sm font-semibold text-gray-500 mb-2">
                    Gambar
                </p>

                <img
                    src="{{ asset('storage/' . $quis->gambar) }}"
                    alt="Gambar soal"
                    class="max-w-sm max-h-64 object-contain rounded-lg border border-gray-200"
                >

            </div>

        @endif


        {{-- Pilihan --}}
        <div class="grid md:grid-cols-2 gap-4 mb-6">

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
        <div class="flex justify-end">

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
