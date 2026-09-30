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
                    name="kode_kuis"
                    value="{{ old('kode_kuis', $quis->kode_kuis) }}"
                    required
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Contoh: KUIS001"
                >

                @error('kode_kuis')
                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror

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
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                >{{ old('pertanyaan', $quis->pertanyaan) }}</textarea>

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
                            {{ old('kelas_id', $quis->kategori->kelas_id ?? '') == $item->id ? 'selected' : '' }}
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


            {{-- Jawaban Benar --}}
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

                    <option
                        value="A"
                        {{ old('jawaban', $quis->jawaban) == 'A' ? 'selected' : '' }}
                    >
                        A
                    </option>

                    <option
                        value="B"
                        {{ old('jawaban', $quis->jawaban) == 'B' ? 'selected' : '' }}
                    >
                        B
                    </option>

                    <option
                        value="C"
                        {{ old('jawaban', $quis->jawaban) == 'C' ? 'selected' : '' }}
                    >
                        C
                    </option>

                    <option
                        value="D"
                        {{ old('jawaban', $quis->jawaban) == 'D' ? 'selected' : '' }}
                    >
                        D
                    </option>

                </select>

                @error('jawaban')
                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- Gambar Lama --}}
            @if ($quis->gambar)

                <div class="mb-5">

                    <p class="text-sm font-semibold text-gray-700 mb-2">
                        Gambar Saat Ini
                    </p>

                    <img
                        src="{{ asset('storage/' . $quis->gambar) }}"
                        alt="Gambar soal"
                        class="w-32 h-32 object-cover rounded-lg border border-gray-200"
                    >

                </div>

            @endif


            {{-- Gambar Baru --}}
            <div class="mb-6">

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Ganti Gambar
                </label>

                <input
                    type="file"
                    name="gambar"
                    accept=".jpg,.jpeg,.png,.webp"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-800"
                >

                <p class="text-xs text-gray-400 mt-1">
                    Kosongkan jika tidak ingin mengganti gambar.
                </p>

                @error('gambar')
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

    const semuaKategori = Array.from(
        kategoriSelect.querySelectorAll('option[data-kelas]')
    );

    function filterKategori() {

        const kelasId = kelasSelect.value;
        const kategoriSekarang = kategoriSelect.value;

        semuaKategori.forEach(function (option) {

            if (option.dataset.kelas === kelasId) {
                option.hidden = false;
            } else {
                option.hidden = true;
            }

        });

        if (!kelasId) {

            kategoriSelect.value = '';

        } else {

            const kategoriMasihSesuai = semuaKategori.some(function (option) {

                return option.dataset.kelas === kelasId &&
                       option.value === kategoriSekarang;

            });

            if (!kategoriMasihSesuai) {
                kategoriSelect.value = '';
            }

        }

    }

    kelasSelect.addEventListener('change', filterKategori);

    filterKategori();

});
</script>

@endsection
