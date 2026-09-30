@extends('layouts.admin.app')

@section('title', 'Edit Kuis - BUBA')

@section('content')

<div class="max-w-4xl mx-auto">

    <div class="mb-6">

        <h1 class="text-3xl font-bold text-gray-800">
            Edit Soal Kuis
        </h1>

        <p class="text-gray-500 text-sm mt-1">
            Ubah data soal kuis yang sudah dibuat.
        </p>

    </div>


    <div class="bg-white rounded-xl shadow-md p-6">

        <form
            action="{{ route('kuis.update', $quis) }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf

            @method('PUT')


            {{-- Pertanyaan --}}
            <div class="mb-5">

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Pertanyaan
                </label>

                <textarea
                    name="pertanyaan"
                    rows="4"
                    required
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500"
                >{{ old('pertanyaan', $quis->pertanyaan) }}</textarea>

                @error('pertanyaan')
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
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500"
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
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500"
                >

                @error('pilihan_b')
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
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500"
                >

                    <option value="">
                        Pilih jawaban benar
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
                    accept="image/*"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3"
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

@endsection
