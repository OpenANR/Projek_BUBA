@extends('layouts.admin.app')

@section('title', 'Edit Materi - BUBA')

@section('content')

<div class="max-w-3xl mx-auto">

    <div class="bg-white rounded-xl shadow-md overflow-hidden">

        {{-- Header --}}
        <div class="bg-gradient-to-r from-yellow-500 to-orange-500 px-6 py-5">
            <h1 class="text-2xl font-bold text-white">✏️ Edit Materi</h1>
            <p class="text-yellow-100 text-sm mt-1">
                Perbarui informasi materi di bawah ini
            </p>
        </div>

        <div class="p-6">

            {{-- Error Alert --}}
            @if ($errors->any())
                <div class="mb-5 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded">
                    <p class="font-semibold mb-1">Terjadi kesalahan:</p>

                    <ul class="list-disc list-inside text-sm space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form
                action="{{ route('materi.update', $materi->kode_materi) }}"
                method="POST"
                enctype="multipart/form-data"
                class="space-y-5"
            >
                @csrf
                @method('PUT')

                {{-- Nama Materi --}}
                <div>
                    <label for="nama_materi"
                        class="block text-sm font-semibold text-gray-700 mb-1">
                        Nama Materi <span class="text-red-500">*</span>
                    </label>

                    <input
                        type="text"
                        name="nama_materi"
                        id="nama_materi"
                        maxlength="25"
                        value="{{ old('nama_materi', $materi->nama_materi) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg
                        focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500
                        outline-none transition"
                        required
                    >
                </div>

                {{-- Kelas --}}
                <div>
                    <label for="kelas_id"
                        class="block text-sm font-semibold text-gray-700 mb-1">
                        Kelas <span class="text-red-500">*</span>
                    </label>

                    <select
                        name="kelas_id"
                        id="kelas_id"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg
                        focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500
                        outline-none transition bg-white"
                        required
                    >
                        <option value="">--- Pilih Kelas ---</option>

                        @foreach ($kelas as $item)
                            <option
                                value="{{ $item->id }}"
                                {{ old('kelas_id', $materi->kelas_id) == $item->id ? 'selected' : '' }}
                            >
                                {{ $item->nama_kelas }}
                            </option>
                        @endforeach
                    </select>

                    @error('kelas_id')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Kategori --}}
                <div>
                    <label for="kategori_id"
                        class="block text-sm font-semibold text-gray-700 mb-1">
                        Kategori <span class="text-red-500">*</span>
                    </label>

                    <select
                        name="kategori_id"
                        id="kategori_id"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg
                        focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500
                        outline-none transition bg-white"
                        required
                    >
                        <option value="">--- Pilih Kategori ---</option>

                        @foreach ($kategori as $item)
                            <option
                                value="{{ $item->id }}"
                                data-kelas="{{ $item->kelas_id }}"
                                {{ old('kategori_id', $materi->kategori_id) == $item->id ? 'selected' : '' }}
                            >
                                {{ $item->nama_kategori }}
                            </option>
                        @endforeach
                    </select>

                    @error('kategori_id')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Isi Materi --}}
                <div>
                    <label for="isi_materi"
                        class="block text-sm font-semibold text-gray-700 mb-1">
                        Isi Materi <span class="text-red-500">*</span>
                    </label>

                    <textarea
                        name="isi_materi"
                        id="isi_materi"
                        cols="30"
                        rows="8"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg
                        focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500
                        outline-none transition resize-y"
                        required
                    >{{ old('isi_materi', $materi->isi_materi) }}</textarea>

                    @error('isi_materi')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Upload Gambar & Audio --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    {{-- Gambar --}}
                    <div>
                        <label for="gambar"
                            class="block text-sm font-semibold text-gray-700 mb-1">
                            Gambar
                        </label>

                        <input
                            type="file"
                            name="gambar"
                            id="gambar"
                            accept=".jpg,.jpeg,.png"
                            class="w-full text-sm text-gray-600
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-lg file:border-0
                            file:text-sm file:font-semibold
                            file:bg-yellow-50 file:text-yellow-700
                            hover:file:bg-yellow-100
                            border border-gray-300 rounded-lg cursor-pointer"
                        >

                        @if ($materi->gambar)
                            <div class="mt-2 flex items-center gap-3">

                                <img
                                    src="{{ asset('storage/' . $materi->gambar) }}"
                                    alt="{{ $materi->nama_materi }}"
                                    class="w-24 h-24 object-cover rounded-lg
                                    border border-gray-200 shadow-sm"
                                >

                                <small class="text-xs text-gray-500">
                                    Gambar saat ini:
                                    <span class="font-mono">
                                        {{ $materi->gambar }}
                                    </span>
                                </small>

                            </div>
                        @endif

                        @error('gambar')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Audio --}}
                    <div>
                        <label for="audio"
                            class="block text-sm font-semibold text-gray-700 mb-1">
                            Audio
                        </label>

                        <input
                            type="file"
                            name="audio"
                            id="audio"
                            accept=".mp3,.wav,.ogg,.aac"
                            class="w-full text-sm text-gray-600
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-lg file:border-0
                            file:text-sm file:font-semibold
                            file:bg-yellow-50 file:text-yellow-700
                            hover:file:bg-yellow-100
                            border border-gray-300 rounded-lg cursor-pointer"
                        >

                        @if ($materi->audio)
                            <small class="block mt-2 text-xs text-gray-500">
                                Audio saat ini:
                                <span class="font-mono">
                                    {{ $materi->audio }}
                                </span>
                            </small>
                        @endif

                        @error('audio')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                </div>

                {{-- Buttons --}}
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">

                    <a
                        href="{{ route('materi.index') }}"
                        class="px-4 py-2 text-sm font-semibold
                        text-gray-600 bg-gray-100 hover:bg-gray-200
                        rounded-lg transition"
                    >
                        Batal
                    </a>

                    <button
                        type="submit"
                        class="inline-flex items-center gap-2
                        bg-yellow-500 hover:bg-yellow-600
                        text-white font-semibold px-5 py-2
                        rounded-lg shadow transition"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"
                            />
                        </svg>

                        Update
                    </button>

                </div>

            </form>

        </div>
    </div>

</div>

{{-- Filter Kategori berdasarkan Kelas --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const kelasSelect = document.getElementById('kelas_id');
    const kategoriSelect = document.getElementById('kategori_id');

    const kategoriOptions = Array.from(
        kategoriSelect.querySelectorAll('option[data-kelas]')
    );

    const kategoriLama = "{{ old('kategori_id', $materi->kategori_id) }}";

    function filterKategori() {

        const kelasId = kelasSelect.value;

        kategoriSelect.value = '';

        kategoriOptions.forEach(function (option) {

            if (option.dataset.kelas === kelasId) {
                option.style.display = '';
            } else {
                option.style.display = 'none';
            }

        });

        const selectedOption = kategoriOptions.find(function (option) {
            return option.value === kategoriLama &&
                   option.dataset.kelas === kelasId;
        });

        if (selectedOption) {
            kategoriSelect.value = selectedOption.value;
        }
    }

    filterKategori();

    kelasSelect.addEventListener('change', function () {

        kategoriSelect.value = '';

        kategoriOptions.forEach(function (option) {

            if (option.dataset.kelas === this.value) {
                option.style.display = '';
            } else {
                option.style.display = 'none';
            }

        });

    });

});
</script>

@endsection