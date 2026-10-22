@extends('layouts.admin.app')

@section('title', 'Edit Materi - BUBA')

@section('content')

<div class="max-w-4xl mx-auto">

    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">
            Edit Materi
        </h1>

        <p class="text-gray-500 text-sm mt-1">
            Ubah data materi yang sudah dibuat.
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
            action="{{ route('materi.update', $materi->kode_materi) }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf
            @method('PUT')

            {{-- Kode Materi --}}
            <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Kode Materi
                </label>

                <input
                    type="text"
                    value="{{ $materi->kode_materi }}"
                    readonly
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-500 bg-gray-100"
                >

                <p class="text-xs text-gray-400 mt-1">
                    Kode materi dibuat otomatis dan tidak dapat diubah.
                </p>
            </div>

            {{-- Nama Materi --}}
            <div class="mb-5">
                <label for="nama_materi" class="block text-sm font-semibold text-gray-700 mb-2">
                    Nama Materi
                </label>

                <input
                    type="text"
                    name="nama_materi"
                    id="nama_materi"
                    maxlength="25"
                    value="{{ old('nama_materi', $materi->nama_materi) }}"
                    required
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                >

                @error('nama_materi')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Kelas --}}
            <div class="mb-5">
                <label for="kelas_id" class="block text-sm font-semibold text-gray-700 mb-2">
                    Kelas
                </label>

                <select
                    name="kelas_id"
                    id="kelas_id"
                    required
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-800 bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                >
                    <option value="">-- Pilih Kelas --</option>

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
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Kategori --}}
            <div class="mb-5">
                <label for="kategori_id" class="block text-sm font-semibold text-gray-700 mb-2">
                    Kategori
                </label>

                <select
                    name="kategori_id"
                    id="kategori_id"
                    required
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-800 bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                >
                    <option value="">-- Pilih Kategori --</option>

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
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Isi Materi --}}
            <div class="mb-5">
                <label for="isi_materi" class="block text-sm font-semibold text-gray-700 mb-2">
                    Isi Materi
                </label>

                <textarea
                    name="isi_materi"
                    id="isi_materi"
                    rows="6"
                    required
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                >{{ old('isi_materi', $materi->isi_materi) }}</textarea>

                @error('isi_materi')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Gambar Saat Ini --}}
            <div class="mb-5">
                <p class="text-sm font-semibold text-gray-700 mb-3">
                    Gambar Saat Ini
                </p>

                @if ($materi->gambar)
                    <div class="border border-gray-200 rounded-lg p-3 inline-block">
                        <img
                            src="{{ asset('storage/' . $materi->gambar) }}"
                            alt="{{ $materi->nama_materi }}"
                            class="w-48 h-40 object-contain rounded-lg border border-gray-200 bg-gray-50"
                        >
                    </div>
                @else
                    <div class="p-4 rounded-lg bg-gray-50 border border-gray-200 text-sm text-gray-500">
                        Belum ada gambar.
                    </div>
                @endif
            </div>

            {{-- Ganti Gambar --}}
            <div class="mb-6">
                <label for="gambar" class="block text-sm font-semibold text-gray-700 mb-2">
                    Ganti Gambar
                </label>

                <input
                    type="file"
                    name="gambar"
                    id="gambar"
                    accept=".jpg,.jpeg,.png,.webp"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-800 bg-white"
                >

                <p class="text-xs text-gray-400 mt-1">
                    Pilih gambar baru jika ingin mengganti gambar lama.
                    Kosongkan jika tidak ingin mengganti gambar.
                </p>

                @error('gambar')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Audio Saat Ini --}}
            <div class="mb-5">
                <p class="text-sm font-semibold text-gray-700 mb-2">
                    Audio Saat Ini
                </p>

                @if ($materi->audio)
                    <audio controls class="w-full">
                        <source src="{{ asset('storage/' . $materi->audio) }}">
                        Browser tidak mendukung pemutar audio.
                    </audio>

                    <p class="text-xs text-gray-400 mt-2">
                        File: {{ basename($materi->audio) }}
                    </p>
                @else
                    <div class="p-4 rounded-lg bg-gray-50 border border-gray-200 text-sm text-gray-500">
                        Belum ada audio.
                    </div>
                @endif
            </div>

            {{-- Ganti Audio --}}
            <div class="mb-6">
                <label for="audio" class="block text-sm font-semibold text-gray-700 mb-2">
                    Ganti Audio
                </label>

                <input
                    type="file"
                    name="audio"
                    id="audio"
                    accept=".mp3,.wav,.ogg,.aac"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-800 bg-white"
                >

                <p class="text-xs text-gray-400 mt-1">
                    Pilih audio baru jika ingin mengganti audio lama.
                    Kosongkan jika tidak ingin mengganti audio.
                </p>

                @error('audio')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tombol --}}
            <div class="flex justify-end gap-3">

                <a
                    href="{{ route('materi.index') }}"
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

    // Simpan kategori yang dipilih sebelumnya
    const kategoriAwal = @json(old('kategori_id', $materi->kategori_id));

    // Filter kategori sesuai kelas yang dipilih
    function filterKategori(resetKategori = false) {

        const kelasId = kelasSelect.value;
        const kategoriSebelumnya = kategoriSelect.value;

        semuaKategori.forEach(function (option) {
            option.hidden = option.dataset.kelas !== kelasId;
        });

        if (!kelasId) {
            kategoriSelect.value = '';
            return;
        }

        if (resetKategori) {
            kategoriSelect.value = '';
            return;
        }

        const kategoriValid = semuaKategori.find(function (option) {
            return option.value == kategoriSebelumnya &&
                   option.dataset.kelas === kelasId;
        });

        if (kategoriValid) {
            kategoriSelect.value = kategoriValid.value;
            return;
        }

        const kategoriAwalValid = semuaKategori.find(function (option) {
            return option.value == kategoriAwal &&
                   option.dataset.kelas === kelasId;
        });

        kategoriSelect.value = kategoriAwalValid
            ? kategoriAwalValid.value
            : '';
    }

    // Filter saat halaman pertama kali dibuka
    filterKategori();

    // Kosongkan kategori ketika kelas diganti
    kelasSelect.addEventListener('change', function () {
        filterKategori(true);
    });

});
</script>

@endsection