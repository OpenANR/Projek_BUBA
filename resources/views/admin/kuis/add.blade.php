@extends('layouts.admin.app')

@section('title', 'Tambah Kuis - BUBA')

@section('content')

<div class="max-w-4xl mx-auto">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">

        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                Tambah Soal Kuis
            </h1>

            <p class="text-gray-500 mt-1">
                Tambahkan soal kuis baru untuk anak.
            </p>
        </div>

        <a href="{{ route('kuis.index') }}"
           class="px-4 py-2 rounded-lg bg-gray-500 text-white hover:bg-gray-600 transition">
            ← Kembali
        </a>

    </div>


    {{-- Error Validasi --}}
    @if ($errors->any())

        <div class="mb-5 p-4 rounded-lg bg-red-100 border border-red-300 text-red-700">

            <ul class="list-disc list-inside">

                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>

    @endif


    <div class="bg-white rounded-xl shadow-md p-6">

        <form action="{{ route('kuis.kirim') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf


            {{-- Pertanyaan --}}
            <div class="mb-5">

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Pertanyaan
                </label>

                <textarea
                    name="pertanyaan"
                    rows="4"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-800 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none"
                    placeholder="Masukkan pertanyaan kuis..."
                    oninput="this.value = this.value.replace(/[^A-Za-z0-9 ?=+\-]/g, '')"
                    required>{{ old('pertanyaan') }}</textarea>

                <p class="text-xs text-gray-500 mt-2">
                    Hanya boleh menggunakan huruf, angka, spasi, dan simbol
                    ?, =, +, -.
                </p>

                @error('pertanyaan')
                    <p class="text-sm text-red-600 mt-2">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- Kelas --}}
            <div class="mb-5">

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Kelas
                </label>

                <select
                    name="kelas_id"
                    id="kelas_id"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-800 bg-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none"
                    required
                >

                    <option value="">
                        -- Pilih Kelas --
                    </option>

                    @foreach ($kelas as $item)

                        <option
                            value="{{ $item->id }}"
                            {{ old('kelas_id') == $item->id ? 'selected' : '' }}
                        >
                            {{ $item->nama_kelas }}
                        </option>

                    @endforeach

                </select>

                @error('kelas_id')
                    <p class="text-sm text-red-600 mt-2">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- Kategori --}}
            <div class="mb-5">

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Kategori
                </label>

                <select
                    name="kategori_id"
                    id="kategori_id"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-800 bg-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none"
                    required
                >

                    <option value="">
                        -- Pilih Kelas Terlebih Dahulu --
                    </option>

                    @foreach ($kategoris as $kategori)

                        <option
                            value="{{ $kategori->id }}"
                            data-kelas="{{ $kategori->kelas_id }}"
                            {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}
                        >
                            {{ $kategori->nama_kategori }}
                        </option>

                    @endforeach

                </select>

                @error('kategori_id')
                    <p class="text-sm text-red-600 mt-2">
                        {{ $message }}
                    </p>
                @enderror

                <p class="text-xs text-gray-500 mt-2">
                    Kategori akan menyesuaikan dengan kelas yang dipilih.
                </p>

            </div>


            {{-- Pilihan Jawaban --}}
            <div class="mb-5">

                <label class="block text-sm font-semibold text-gray-700 mb-3">
                    Pilihan Jawaban
                </label>


                {{-- A --}}
                <div class="mb-3">

                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Pilihan A
                    </label>

                    <input
                        type="text"
                        name="pilihan_a"
                        value="{{ old('pilihan_a') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-800 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none"
                        placeholder="Masukkan pilihan A"
                        required
                    >

                </div>


                {{-- B --}}
                <div class="mb-3">

                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Pilihan B
                    </label>

                    <input
                        type="text"
                        name="pilihan_b"
                        value="{{ old('pilihan_b') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-800 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none"
                        placeholder="Masukkan pilihan B"
                        required
                    >

                </div>


                {{-- C --}}
                <div class="mb-3">

                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Pilihan C
                    </label>

                    <input
                        type="text"
                        name="pilihan_c"
                        value="{{ old('pilihan_c') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-800 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none"
                        placeholder="Masukkan pilihan C"
                        required
                    >

                </div>


                {{-- D --}}
                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Pilihan D
                    </label>

                    <input
                        type="text"
                        name="pilihan_d"
                        value="{{ old('pilihan_d') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-800 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none"
                        placeholder="Masukkan pilihan D"
                        required
                    >

                </div>

            </div>


            {{-- Jawaban Benar --}}
            <div class="mb-5">

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Jawaban Benar
                </label>

                <select
                    name="jawaban"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-800 bg-white focus:ring-2 focus:ring-green-400 focus:border-green-400 outline-none"
                    required
                >

                    <option value="">
                        -- Pilih Jawaban Benar --
                    </option>

                    @foreach (['A', 'B', 'C', 'D'] as $jawaban)

                        <option
                            value="{{ $jawaban }}"
                            {{ old('jawaban') == $jawaban ? 'selected' : '' }}
                        >
                            {{ $jawaban }}
                        </option>

                    @endforeach

                </select>

                @error('jawaban')
                    <p class="text-sm text-red-600 mt-2">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- Gambar --}}
            <div class="mb-5">

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Gambar
                    <span class="font-normal text-gray-500">
                        (Opsional, bisa lebih dari satu)
                    </span>
                </label>

                <input
                    type="file"
                    name="gambar[]"
                    multiple
                    accept=".jpg,.jpeg,.png,.webp"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-700 bg-white"
                >

                <p class="text-xs text-gray-500 mt-2">
                    Bisa memilih beberapa gambar sekaligus.
                    Format JPG, JPEG, PNG, WEBP. Maksimal 2 MB per gambar.
                </p>

                @error('gambar')
                    <p class="text-sm text-red-600 mt-2">
                        {{ $message }}
                    </p>
                @enderror

                @error('gambar.*')
                    <p class="text-sm text-red-600 mt-2">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- Audio --}}
            <div class="mb-6">

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Audio
                    <span class="font-normal text-gray-500">
                        (Opsional)
                    </span>
                </label>

                <input
                    type="file"
                    name="audio"
                    accept=".mp3,.wav,.ogg"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-700 bg-white"
                >

                <p class="text-xs text-gray-500 mt-2">
                    Format MP3, WAV, atau OGG. Maksimal 10 MB.
                </p>

                @error('audio')
                    <p class="text-sm text-red-600 mt-2">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- Tombol --}}
            <div class="flex justify-end gap-3">

                <a
                    href="{{ route('kuis.index') }}"
                    class="px-5 py-2.5 rounded-lg bg-gray-500 text-white hover:bg-gray-600 transition"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    class="px-5 py-2.5 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition"
                >
                    Simpan Soal
                </button>

            </div>

        </form>

    </div>

</div>


{{-- Filter Kategori Berdasarkan Kelas --}}
<script>

document.addEventListener('DOMContentLoaded', function () {

    const kelasSelect = document.getElementById('kelas_id');
    const kategoriSelect = document.getElementById('kategori_id');

    const semuaKategori = Array.from(
        kategoriSelect.querySelectorAll('option[data-kelas]')
    );

    function filterKategori() {

        const kelasId = kelasSelect.value;

        semuaKategori.forEach(function (option) {

            if (option.dataset.kelas === kelasId) {
                option.hidden = false;
            } else {
                option.hidden = true;
            }

        });

        if (!kelasId) {

            kategoriSelect.value = '';

            kategoriSelect.querySelector(
                'option[value=""]'
            ).textContent = '-- Pilih Kelas Terlebih Dahulu --';

            return;
        }

        kategoriSelect.querySelector(
            'option[value=""]'
        ).textContent = '-- Pilih Kategori --';

        const kategoriTerpilih = kategoriSelect.value;

        const masihValid = semuaKategori.some(function (option) {

            return option.dataset.kelas === kelasId &&
                   option.value === kategoriTerpilih;

        });

        if (!masihValid) {
            kategoriSelect.value = '';
        }

    }

    kelasSelect.addEventListener('change', function () {

        kategoriSelect.value = '';

        filterKategori();

    });

    filterKategori();

});

</script>

@endsection
