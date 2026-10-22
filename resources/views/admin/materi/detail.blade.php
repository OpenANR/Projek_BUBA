@extends('layouts.admin.app')

@section('title', 'Detail Materi - BUBA')

@section('content')

<div class="max-w-4xl mx-auto">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">

        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Detail Materi
            </h1>

            <p class="text-gray-500 text-sm mt-1">
                Informasi lengkap materi pembelajaran.
            </p>
        </div>


    </div>

    {{-- Card Detail Materi --}}
    <div class="bg-white rounded-xl shadow-md p-6">

        {{-- Kode Materi --}}
        <div class="mb-5">
            <p class="text-sm font-semibold text-gray-500 mb-2">
                Kode Materi
            </p>

            <div class="bg-gray-50 rounded-lg p-4 text-gray-800 font-semibold">
                {{ $materi->kode_materi }}
            </div>
        </div>

        {{-- Nama Materi --}}
        <div class="mb-5">
            <p class="text-sm font-semibold text-gray-500 mb-2">
                Nama Materi
            </p>

            <div class="bg-gray-50 rounded-lg p-4 text-gray-800 font-semibold">
                {{ $materi->nama_materi }}
            </div>
        </div>

        {{-- Kelas --}}
        <div class="mb-5">
            <p class="text-sm font-semibold text-gray-500 mb-2">
                Kelas
            </p>

            <div class="bg-gray-50 rounded-lg p-4 text-gray-800 font-semibold">
                {{ $materi->kelas->nama_kelas ?? '-' }}
            </div>
        </div>

        {{-- Kategori --}}
        <div class="mb-6">
            <p class="text-sm font-semibold text-gray-500 mb-2">
                Kategori
            </p>

            <div class="bg-gray-50 rounded-lg p-4 text-gray-800 font-semibold">
                {{ $materi->kategori->nama_kategori ?? '-' }}
            </div>
        </div>

        {{-- Isi Materi --}}
        <div class="mb-6">
            <p class="text-sm font-semibold text-gray-500 mb-2">
                Isi Materi
            </p>

            <div class="bg-gray-50 rounded-lg p-4 text-gray-800 whitespace-pre-line">
                {{ $materi->isi_materi ?: 'Belum ada isi materi.' }}
            </div>
        </div>

        {{-- Gambar --}}
        <div class="mb-6">
            <p class="text-sm font-semibold text-gray-500 mb-3">
                Gambar
            </p>

            @if ($materi->gambar)

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <a
                        href="{{ asset('storage/' . $materi->gambar) }}"
                        target="_blank"
                        class="block"
                    >
                        <img
                            src="{{ asset('storage/' . $materi->gambar) }}"
                            alt="{{ $materi->nama_materi }}"
                            class="w-full h-40 object-contain rounded-lg border border-gray-200 bg-gray-50 hover:shadow-md transition"
                        >
                    </a>
                </div>

            @else

                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 text-sm text-gray-500">
                    Tidak ada gambar.
                </div>

            @endif
        </div>

        {{-- Audio --}}
        <div class="mb-6">
            <p class="text-sm font-semibold text-gray-500 mb-3">
                Audio
            </p>

            @if ($materi->audio)

                @php
                    $extension = strtolower(
                        pathinfo($materi->audio, PATHINFO_EXTENSION)
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
                                Audio Materi
                            </p>

                            <p class="text-xs text-gray-500">
                                {{ strtoupper($extension) }}
                            </p>
                        </div>
                    </div>

                    <audio controls preload="metadata" class="w-full">
                        <source
                            src="{{ asset('storage/' . $materi->audio) }}"
                            type="{{ $audioType }}"
                        >

                        Browser kamu tidak mendukung pemutar audio.
                    </audio>

                </div>

            @else

                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 text-sm text-gray-500">
                    Tidak ada audio.
                </div>

            @endif
        </div>

        {{-- Tombol --}}
        <div class="flex justify-end gap-3">

            <a
                href="{{ route('materi.index') }}"
                class="px-5 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg"
            >
                Kembali
            </a>

            <a
                href="{{ route('materi.edit', $materi->kode_materi) }}"
                class="px-5 py-2.5 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded-lg"
            >
                Edit Materi
            </a>

        </div>

    </div>

</div>

@endsection