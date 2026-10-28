@extends('layouts.admin.app')

@section('title', 'Tambah Kuis - BUBA')

@section('content')

<div class="max-w-4xl mx-auto">

    {{-- HEADER --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Tambah Kuis
            </h1>

            <p class="text-gray-500 text-sm mt-1">
                Isi informasi pertanyaan dan pilihan jawaban kuis.
            </p>
        </div>
    </div>

    {{-- ERROR VALIDASI --}}
    @if ($errors->any())
        <div class="mb-5 p-4 rounded-lg bg-red-100 border border-red-300 text-red-700">
            <p class="font-bold mb-2">Kuis belum dapat disimpan:</p>

            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- CARD TAMBAH KUIS --}}
    <div class="bg-white rounded-xl shadow-md p-6">

        <form action="{{ route('kuis.kirim') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            {{-- INFORMASI KUIS --}}
            <h2 class="text-lg font-bold text-gray-800 mb-5">
                Informasi Kuis
            </h2>

            {{-- KELAS --}}
            <div class="mb-5">
                <label for="kelas_id"
                       class="block text-sm font-semibold text-gray-700 mb-2">
                    Kelas
                </label>

                <select name="kelas_id"
                        id="kelas_id"
                        required
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 bg-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none">

                    <option value="">-- Pilih Kelas --</option>

                    @foreach ($kelas as $item)
                        <option value="{{ $item->id }}"
                            {{ old('kelas_id') == $item->id ? 'selected' : '' }}>
                            {{ $item->nama_kelas }}
                        </option>
                    @endforeach

                </select>
            </div>

            {{-- KATEGORI --}}
            <div class="mb-6">
                <label for="kategori_id"
                       class="block text-sm font-semibold text-gray-700 mb-2">
                    Kategori
                </label>

                <select name="kategori_id"
                        id="kategori_id"
                        required
                        disabled
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 bg-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none">

                    <option value="">-- Pilih Kelas Terlebih Dahulu --</option>

                    @foreach ($kategoris as $kategori)
                        <option value="{{ $kategori->id }}"
                                data-kelas="{{ $kategori->kelas_id }}"
                            {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                    @endforeach

                </select>

                <p class="text-xs text-gray-500 mt-2">
                    Kategori akan menyesuaikan dengan kelas yang dipilih.
                </p>
            </div>

            {{-- DAFTAR PERTANYAAN --}}
            <div class="border-t border-gray-200 pt-6">

                <div class="mb-5">
                    <h2 class="text-lg font-bold text-gray-800">
                        Daftar Pertanyaan
                    </h2>

                    <p class="text-sm text-gray-500 mt-1">
                        Masukkan pertanyaan, pilihan jawaban, gambar, dan audio.
                    </p>
                </div>

                <div id="soalContainer" class="space-y-6">

                    <div class="soal-card border border-gray-200 rounded-xl p-5">

                        {{-- HEADER SOAL --}}
                        <div class="flex justify-between items-center gap-3 mb-5 pb-4 border-b border-gray-100">
                            <h3 class="text-lg font-bold text-gray-800">
                                Soal 1
                            </h3>
                        </div>

                        {{-- PERTANYAAN --}}
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Pertanyaan
                            </label>

                            <textarea name="soal[0][pertanyaan]"
                                      rows="4"
                                      maxlength="1000"
                                      required
                                      placeholder="Masukkan pertanyaan kuis..."
                                      class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-800 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none">{{ old('soal.0.pertanyaan') }}</textarea>

                            <div class="flex justify-between mt-2">
                                <p class="text-xs text-gray-500">
                                    Gunakan pertanyaan yang mudah dipahami anak.
                                </p>

                                <p id="jumlahKarakter" class="text-xs text-gray-500">
                                    0/1000 karakter
                                </p>
                            </div>

                            <p id="peringatanKarakter"
                               class="hidden text-xs text-red-500 mt-1">
                                Beberapa karakter tidak diizinkan.
                            </p>
                        </div>

                        {{-- PILIHAN JAWABAN --}}
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-3">
                                Pilihan Jawaban
                            </label>

                            <div class="space-y-4">

                                @foreach (['a', 'b', 'c', 'd'] as $opsi)
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Pilihan {{ strtoupper($opsi) }}
                                        </label>

                                        <input type="text"
                                               name="soal[0][pilihan_{{ $opsi }}]"
                                               value="{{ old('soal.0.pilihan_'.$opsi) }}"
                                               required
                                               placeholder="Masukkan pilihan {{ strtoupper($opsi) }}"
                                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none">
                                    </div>
                                @endforeach

                            </div>
                        </div>

                        {{-- JAWABAN BENAR --}}
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Jawaban Benar
                            </label>

                            <select name="soal[0][jawaban]"
                                    required
                                    class="w-full border border-gray-300 rounded-lg px-4 py-3 bg-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none">

                                <option value="">-- Pilih Jawaban Benar --</option>

                                @foreach (['A', 'B', 'C', 'D'] as $jawaban)
                                    <option value="{{ $jawaban }}"
                                        {{ old('soal.0.jawaban') == $jawaban ? 'selected' : '' }}>
                                        Pilihan {{ $jawaban }}
                                    </option>
                                @endforeach

                            </select>
                        </div>

                        {{-- GAMBAR --}}
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-3">
                                Gambar Soal
                            </label>

                            <div id="gambarContainer">

                                <div class="gambar-item flex gap-2 mb-3">
                                    <input type="file"
                                           name="soal[0][gambar][]"
                                           accept=".jpg,.jpeg,.png,.webp"
                                           class="min-w-0 flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm bg-white">

                                    <button type="button"
                                            class="hapusGambar px-3 py-2 bg-red-500 hover:bg-red-600 text-white text-sm rounded-lg">
                                        Hapus
                                    </button>
                                </div>

                            </div>

                            <button type="button"
                                    id="tambahGambar"
                                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-lg font-semibold transition">
                                + Tambah Gambar
                            </button>

                            <p class="text-xs text-gray-400 mt-2">
                                Format JPG, JPEG, PNG, WEBP. Maksimal 2 MB per gambar.
                            </p>
                        </div>

                        {{-- AUDIO --}}
                        <div class="border-t border-gray-200 pt-5">

                            <h4 class="font-bold text-gray-800 mb-4">
                                Audio Soal dan Pilihan Jawaban
                            </h4>

                            <div class="space-y-4">

                                {{-- AUDIO PERTANYAAN --}}
                                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">

                                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                                        Audio Pertanyaan
                                    </label>

                                    <input type="file"
                                           name="soal[0][audio_pertanyaan]"
                                           accept=".mp3,.wav,.ogg,audio/mpeg,audio/wav,audio/ogg"
                                           class="audio-input w-full border border-gray-300 rounded-lg px-4 py-3 bg-white">

                                    <div class="preview-audio hidden mt-3">
                                        <p class="text-xs font-semibold text-gray-700 mb-2">
                                            Preview Audio:
                                        </p>

                                        <audio controls class="w-full"></audio>
                                    </div>

                                </div>

                                {{-- AUDIO PILIHAN --}}
                                @foreach (['a', 'b', 'c', 'd'] as $opsi)

                                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">

                                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                                            Audio Pilihan {{ strtoupper($opsi) }}
                                        </label>

                                        <input type="file"
                                               name="soal[0][audio_pilihan_{{ $opsi }}]"
                                               accept=".mp3,.wav,.ogg,audio/mpeg,audio/wav,audio/ogg"
                                               class="audio-input w-full border border-gray-300 rounded-lg px-4 py-3 bg-white">

                                        <div class="preview-audio hidden mt-3">
                                            <p class="text-xs font-semibold text-gray-700 mb-2">
                                                Preview Audio:
                                            </p>

                                            <audio controls class="w-full"></audio>
                                        </div>

                                    </div>

                                @endforeach

                            </div>

                            <p class="text-xs text-gray-400 mt-3">
                                Format MP3, WAV, atau OGG. Maksimal 10 MB per file.
                            </p>

                        </div>

                    </div>

                </div>

            </div>

            {{-- TOMBOL --}}
            <div class="flex justify-end gap-3 border-t border-gray-100 pt-6 mt-6">

                <a href="{{ route('kuis.index') }}"
                   class="px-5 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition">
                    Batal
                </a>

                <button type="submit"
                        class="px-5 py-2.5 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded-lg transition">
                    Simpan Kuis
                </button>

            </div>

        </form>

    </div>

</div>

<style>
    input[type="file"] {
        cursor: pointer;
    }

    audio {
        width: 100%;
        height: 40px;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // FILTER KATEGORI BERDASARKAN KELAS
    const kelasSelect = document.getElementById('kelas_id');
    const kategoriSelect = document.getElementById('kategori_id');

    const semuaKategori = Array.from(
        kategoriSelect.querySelectorAll('option[data-kelas]')
    );

    function filterKategori() {

        const kelasId = kelasSelect.value;
        const placeholder = kategoriSelect.querySelector('option[value=""]');

        semuaKategori.forEach(function (option) {
            option.hidden = option.dataset.kelas !== kelasId;
        });

        if (!kelasId) {
            kategoriSelect.disabled = true;
            kategoriSelect.value = '';
            placeholder.textContent = '-- Pilih Kelas Terlebih Dahulu --';
            return;
        }

        kategoriSelect.disabled = false;
        placeholder.textContent = '-- Pilih Kategori --';

        const terpilih = semuaKategori.find(function (option) {
            return option.value === kategoriSelect.value &&
                   option.dataset.kelas === kelasId;
        });

        if (!terpilih) {
            kategoriSelect.value = '';
        }
    }

    kelasSelect.addEventListener('change', function () {
        kategoriSelect.value = '';
        filterKategori();
    });

    filterKategori();

    // JUMLAH KARAKTER DAN VALIDASI PERTANYAAN
    const pertanyaan = document.querySelector(
        'textarea[name="soal[0][pertanyaan]"]'
    );

    const jumlahKarakter = document.getElementById('jumlahKarakter');
    const peringatanKarakter = document.getElementById('peringatanKarakter');

    const karakterDiizinkan = /^[A-Za-z0-9\s?=+\-!.,:;()×÷x]$/u;

    function validasiPertanyaan() {

        const nilaiAwal = pertanyaan.value;

        const nilaiBersih = Array.from(nilaiAwal)
            .filter(karakter => karakterDiizinkan.test(karakter))
            .join('');

        if (nilaiAwal !== nilaiBersih) {
            pertanyaan.value = nilaiBersih;
            peringatanKarakter.classList.remove('hidden');
        } else {
            peringatanKarakter.classList.add('hidden');
        }

        jumlahKarakter.textContent =
            `${Array.from(pertanyaan.value).length}/1000 karakter`;
    }

    pertanyaan.addEventListener('input', validasiPertanyaan);
    validasiPertanyaan();

    // TAMBAH GAMBAR
    const gambarContainer = document.getElementById('gambarContainer');

    document.getElementById('tambahGambar').addEventListener('click', function () {

        const item = document.createElement('div');

        item.className = 'gambar-item flex gap-2 mb-3';

        item.innerHTML = `
            <input type="file"
                   name="soal[0][gambar][]"
                   accept=".jpg,.jpeg,.png,.webp"
                   class="min-w-0 flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm bg-white">

            <button type="button"
                    class="hapusGambar px-3 py-2 bg-red-500 hover:bg-red-600 text-white text-sm rounded-lg">
                Hapus
            </button>
        `;

        gambarContainer.appendChild(item);
    });

    // HAPUS GAMBAR
    gambarContainer.addEventListener('click', function (event) {

        if (!event.target.classList.contains('hapusGambar')) {
            return;
        }

        const semuaGambar = gambarContainer.querySelectorAll('.gambar-item');

        if (semuaGambar.length > 1) {
            event.target.closest('.gambar-item').remove();
        } else {
            event.target.closest('.gambar-item').querySelector('input').value = '';
        }
    });

    // PREVIEW AUDIO
    document.querySelectorAll('.audio-input').forEach(function (input) {

        input.addEventListener('change', function () {

            const file = this.files[0];
            const preview = this.parentElement.querySelector('.preview-audio');
            const audio = preview.querySelector('audio');

            if (!file) {
                audio.pause();
                audio.removeAttribute('src');
                audio.load();
                preview.classList.add('hidden');
                return;
            }

            const formatValid = /\.(mp3|wav|ogg)$/i.test(file.name);

            if (!formatValid) {
                alert('Format audio harus MP3, WAV, atau OGG.');
                this.value = '';
                preview.classList.add('hidden');
                return;
            }

            if (file.size > 10 * 1024 * 1024) {
                alert('Ukuran audio maksimal 10 MB.');
                this.value = '';
                preview.classList.add('hidden');
                return;
            }

            if (audio.dataset.url) {
                URL.revokeObjectURL(audio.dataset.url);
            }

            const url = URL.createObjectURL(file);

            audio.dataset.url = url;
            audio.src = url;
            audio.load();

            preview.classList.remove('hidden');
        });

    });

});
</script>

@endsection
