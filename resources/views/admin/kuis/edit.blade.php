@extends('layouts.admin.app')

@section('title', 'Edit Kuis - BUBA')

@section('content')

<div class="max-w-4xl mx-auto">

    {{-- Header --}}
    <div class="mb-6">

        <h1 class="text-3xl font-bold text-gray-800">
            Edit Soal Kuis
        </h1>

        <p class="text-gray-500 text-sm mt-1">
            Ubah data soal kuis yang sudah dibuat.
        </p>

    </div>


    {{-- Error --}}
    @if ($errors->any())

        <div class="mb-5 p-4 rounded-lg bg-red-100 border border-red-300 text-red-700">

            <ul class="list-disc list-inside">

                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>

    @endif


    {{-- Success --}}
    @if (session('success'))

        <div class="mb-5 p-4 rounded-lg bg-green-100 border border-green-300 text-green-700">
            {{ session('success') }}
        </div>

    @endif


    <div class="bg-white rounded-xl shadow-md p-6">

        <form
            action="{{ route('kuis.update', $quis) }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf
            @method('PUT')


            {{-- Kode Kuis --}}
            <div class="mb-5">

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Kode Kuis
                </label>

                <input
                    type="text"
                    value="{{ $quis->kode_kuis }}"
                    readonly
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-500 bg-gray-100"
                >

                <p class="text-xs text-gray-400 mt-1">
                    Kode kuis dibuat otomatis dan tidak dapat diubah.
                </p>

            </div>


            {{-- Pertanyaan --}}
            <div class="mb-5">

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Pertanyaan
                </label>

                <textarea
                    name="pertanyaan"
                    rows="4"
                    required
                    oninput="this.value = this.value.replace(/[^A-Za-z0-9 ?=+\-]/g, '')"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                >{{ old('pertanyaan', $quis->pertanyaan) }}</textarea>

                <p class="text-xs text-gray-500 mt-2">
                    Hanya huruf, angka, spasi, dan simbol ?, =, +, -.
                </p>

                @error('pertanyaan')
                    <p class="text-red-500 text-sm mt-1">
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
                    required
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-800 bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                >

                    <option value="">
                        -- Pilih Kelas --
                    </option>

                    @foreach ($kelas as $item)

                        <option
                            value="{{ $item->id }}"
                            {{ old('kelas_id', $quis->kelas_id) == $item->id ? 'selected' : '' }}
                        >
                            {{ $item->nama_kelas }}
                        </option>

                    @endforeach

                </select>

                @error('kelas_id')
                    <p class="text-red-500 text-sm mt-1">
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
                    required
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-800 bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                >

                    <option value="">
                        -- Pilih Kategori --
                    </option>

                    @foreach ($kategoris as $kategori)

                        <option
                            value="{{ $kategori->id }}"
                            data-kelas="{{ $kategori->kelas_id }}"
                            {{ old('kategori_id', $quis->kategori_id) == $kategori->id ? 'selected' : '' }}
                        >
                            {{ $kategori->nama_kategori }}
                        </option>

                    @endforeach

                </select>

                @error('kategori_id')
                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- Pilihan A --}}
            <div class="mb-5">

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Pilihan A
                </label>

                <input
                    type="text"
                    name="pilihan_a"
                    value="{{ old('pilihan_a', $quis->pilihan_a) }}"
                    required
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                >

                @error('pilihan_a')
                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- Pilihan B --}}
            <div class="mb-5">

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Pilihan B
                </label>

                <input
                    type="text"
                    name="pilihan_b"
                    value="{{ old('pilihan_b', $quis->pilihan_b) }}"
                    required
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                >

                @error('pilihan_b')
                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- Pilihan C --}}
            <div class="mb-5">

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Pilihan C
                </label>

                <input
                    type="text"
                    name="pilihan_c"
                    value="{{ old('pilihan_c', $quis->pilihan_c) }}"
                    required
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                >

                @error('pilihan_c')
                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- Pilihan D --}}
            <div class="mb-5">

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Pilihan D
                </label>

                <input
                    type="text"
                    name="pilihan_d"
                    value="{{ old('pilihan_d', $quis->pilihan_d) }}"
                    required
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                >

                @error('pilihan_d')
                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- Jawaban --}}
            <div class="mb-5">

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Jawaban Benar
                </label>

                <select
                    name="jawaban"
                    required
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-800 bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                >

                    <option value="">
                        -- Pilih Jawaban Benar --
                    </option>

                    @foreach (['A', 'B', 'C', 'D'] as $jawaban)

                        <option
                            value="{{ $jawaban }}"
                            {{ old('jawaban', $quis->jawaban) == $jawaban ? 'selected' : '' }}
                        >
                            {{ $jawaban }}
                        </option>

                    @endforeach

                </select>

                @error('jawaban')
                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- Gambar Saat Ini --}}
            <div class="mb-6">

                <p class="text-sm font-semibold text-gray-700 mb-3">
                    Gambar Saat Ini
                </p>

                @php

                    $gambarLama = $quis->gambar ?? [];

                    if (!is_array($gambarLama)) {
                        $gambarLama = [$gambarLama];
                    }

                @endphp

                @if (count($gambarLama) > 0)

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

                        @foreach ($gambarLama as $gambar)

                            <div class="border border-gray-200 rounded-lg p-2">

                                <img
                                    src="{{ asset('storage/' . $gambar) }}"
                                    alt="Gambar soal"
                                    class="w-full h-32 object-contain rounded-lg bg-gray-50"
                                >

                            </div>

                        @endforeach

                    </div>

                @else

                    <div class="p-4 rounded-lg bg-gray-50 border border-gray-200 text-sm text-gray-500">
                        Belum ada gambar.
                    </div>

                @endif

            </div>


            {{-- Ganti Gambar --}}
            <div class="mb-6">

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Ganti Gambar
                </label>

                <input
                    type="file"
                    name="gambar[]"
                    id="gambar"
                    multiple
                    accept=".jpg,.jpeg,.png,.webp"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-800 bg-white"
                >

                <p class="text-xs text-gray-400 mt-1">
                    Pilih gambar baru sebanyak yang diperlukan.
                    Jika dipilih, semua gambar lama akan diganti.
                    Tidak ada batas jumlah gambar.
                    Maksimal 2 MB per gambar.
                </p>

                <p
                    id="gambarInfo"
                    class="text-xs text-blue-600 mt-2"
                ></p>

                @error('gambar')
                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror

                @error('gambar.*')
                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- Audio Lama --}}
            <div class="mb-5">

                <p class="text-sm font-semibold text-gray-700 mb-2">
                    Audio Saat Ini
                </p>

                @if ($quis->audio)

                    <audio controls class="w-full">
                        <source src="{{ asset('storage/' . $quis->audio) }}">
                        Browser tidak mendukung pemutar audio.
                    </audio>

                @else

                    <div class="p-4 rounded-lg bg-gray-50 border border-gray-200 text-sm text-gray-500">
                        Belum ada audio.
                    </div>

                @endif

            </div>


            {{-- Audio Baru --}}
            <div class="mb-6">

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Ganti Audio
                </label>

                <input
                    type="file"
                    name="audio"
                    accept=".mp3,.wav,.ogg"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-800 bg-white"
                >

                <p class="text-xs text-gray-400 mt-1">
                    Jika dipilih, audio lama akan diganti.
                    Maksimal 10 MB.
                </p>

                @error('audio')
                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- Tombol --}}
            <div class="flex justify-end gap-3">

                <a
                    href="{{ route('kuis.index') }}"
                    class="px-5 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    class="px-5 py-2.5 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded-lg"
                >
                    Simpan Perubahan
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
    const gambarInput = document.getElementById('gambar');
    const gambarInfo = document.getElementById('gambarInfo');

    const semuaKategori = Array.from(
        kategoriSelect.querySelectorAll('option[data-kelas]')
    );


    /*
    |--------------------------------------------------------------------------
    | Filter kategori berdasarkan kelas
    |--------------------------------------------------------------------------
    */

    function filterKategori() {

        const kelasId = kelasSelect.value;
        const kategoriSekarang = kategoriSelect.value;

        semuaKategori.forEach(function (option) {

            option.hidden = option.dataset.kelas !== kelasId;

        });

        if (!kelasId) {

            kategoriSelect.value = '';

            return;

        }

        const masihValid = semuaKategori.some(function (option) {

            return option.dataset.kelas === kelasId &&
                   option.value === kategoriSekarang;

        });

        if (!masihValid) {

            kategoriSelect.value = '';

        }

    }


    kelasSelect.addEventListener('change', function () {

        kategoriSelect.value = '';

        filterKategori();

    });


    /*
    |--------------------------------------------------------------------------
    | Tampilkan jumlah gambar baru yang dipilih
    |--------------------------------------------------------------------------
    */

    gambarInput.addEventListener('change', function () {

        if (this.files.length === 0) {

            gambarInfo.textContent = '';

        } else {

            gambarInfo.textContent =
                this.files.length +
                ' gambar dipilih. Semua gambar lama akan diganti.';

        }

    });


    filterKategori();

});

</script>

@endsection
