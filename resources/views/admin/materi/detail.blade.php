{{-- @extends('layouts.development.development') --}}
@section('title', 'Detail Materi - BUBA')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detail Materi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen py-8 px-4">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            {{-- Header --}}
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-5">
                <h1 class="text-2xl font-bold text-white">📖 Detail Materi</h1>
                <p class="text-indigo-100 text-sm mt-1">Informasi lengkap mengenai materi</p>
            </div>

            <div class="p-6 space-y-5">
                {{-- Kode Materi --}}
                <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-4 border-b border-gray-100 pb-4">
                    <span class="text-sm font-semibold text-gray-500 w-32">Kode Materi</span>
                    <span class="font-mono text-sm bg-gray-100 text-gray-800 px-3 py-1 rounded-md inline-block">
                        {{ $materi->kode_materi }}
                    </span>
                </div>

                {{-- Judul --}}
                <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-4 border-b border-gray-100 pb-4">
                    <span class="text-sm font-semibold text-gray-500 w-32">Judul Materi</span>
                    <span class="text-gray-800 font-semibold">{{ $materi->nama_materi }}</span>
                </div>

                {{-- Kategori --}}
                <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-4 border-b border-gray-100 pb-4">
                    <span class="text-sm font-semibold text-gray-500 w-32">Kategori</span>
                    @if ($materi->kategori)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            {{ $materi->kategori->nama_kategori }}
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-200 text-gray-600">
                            Tidak Ada Kategori
                        </span>
                    @endif
                </div>

                {{-- Isi Materi --}}
                <div class="border-b border-gray-100 pb-4">
                    <span class="text-sm font-semibold text-gray-500 block mb-2">Isi Materi</span>
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 text-gray-700 leading-relaxed whitespace-pre-line">
                        {{ $materi->isi_materi }}
                    </div>
                </div>

                {{-- Media (opsional tampilkan gambar/audio jika ada) --}}
                @if ($materi->gambar)
                    <div class="border-b border-gray-100 pb-4">
                        <span class="text-sm font-semibold text-gray-500 block mb-2">Gambar</span>
                        <img src="{{ asset('storage/' . $materi->gambar) }}"
                             alt="{{ $materi->nama_materi }}"
                             class="rounded-lg border border-gray-200 shadow-sm max-w-xs">
                    </div>
                @endif

                @if ($materi->audio)
                    <div class="border-b border-gray-100 pb-4">
                        <span class="text-sm font-semibold text-gray-500 block mb-2">Audio</span>
                        <audio controls class="w-full">
                            <source src="{{ asset('storage/' . $materi->audio) }}">
                            Browser Anda tidak mendukung elemen audio.
                        </audio>
                    </div>
                @endif

                {{-- Tombol Kembali --}}
                <div class="pt-2">
                    <a href="{{ route('materi.index') }}"
                       class="inline-flex items-center gap-2 bg-gray-700 hover:bg-gray-800 text-white font-semibold px-4 py-2 rounded-lg shadow transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>