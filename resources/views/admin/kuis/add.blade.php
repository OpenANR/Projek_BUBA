@extends('layouts.admin.app')

@section('title', 'Tambah Kuis - BUBA')

@section('content')

<div class="mx-auto max-w-4xl">

    {{-- HEADER --}}
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                Tambah Soal Kuis
            </h1>
            <p class="mt-1 text-gray-500">
                Tambahkan soal kuis baru untuk anak.
            </p>
        </div>

        <a href="{{ route('kuis.index') }}"
            class="rounded-lg bg-gray-500 px-4 py-2 text-white transition hover:bg-gray-600">
            ← Kembali
        </a>
    </div>

    {{-- ERROR VALIDASI --}}
    @if ($errors->any())
        <div class="mb-5 rounded-lg border border-red-300 bg-red-100 p-4 text-red-700">
            <p class="mb-2 font-bold">Terjadi kesalahan:</p>
            <ul class="list-inside list-disc">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- FORM --}}
    <div class="rounded-xl bg-white p-6 shadow-md">

        <form
            action="{{ route('kuis.kirim') }}"
            method="POST"
            enctype="multipart/form-data">

            @csrf

            {{-- PERTANYAAN --}}
            <div class="mb-6">

                <label for="pertanyaan"
                    class="mb-2 block text-sm font-semibold text-gray-700">
                    Pertanyaan
                </label>

                <textarea
                    name="pertanyaan"
                    id="pertanyaan"
                    rows="4"
                    maxlength="1000"
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 text-gray-800 outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-400"
                    placeholder="Masukkan pertanyaan kuis..."
                    required>{{ old('pertanyaan') }}</textarea>

                <div class="mt-2 flex justify-between">
                    <p class="text-xs text-gray-500">
                        Masukkan pertanyaan yang mudah dipahami anak.
                    </p>
                    <p id="jumlahKarakter" class="text-xs text-gray-500">
                        0/1000 karakter
                    </p>
                </div>

                <p id="peringatanKarakter" class="mt-1 hidden text-xs text-red-500">
                    Beberapa karakter tidak diizinkan dan telah dihapus.
                </p>

                @error('pertanyaan')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror

            </div>

            {{-- KELAS --}}
            <div class="mb-5">

                <label for="kelas_id"
                    class="mb-2 block text-sm font-semibold text-gray-700">
                    Kelas
                </label>

                <select
                    name="kelas_id"
                    id="kelas_id"
                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-gray-800 outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-400"
                    required>

                    <option value="">-- Pilih Kelas --</option>

                    @foreach ($kelas as $item)
                        <option
                            value="{{ $item->id }}"
                            {{ old('kelas_id') == $item->id ? 'selected' : '' }}>
                            {{ $item->nama_kelas }}
                        </option>
                    @endforeach

                </select>

                @error('kelas_id')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror

            </div>

            {{-- KATEGORI --}}
            <div class="mb-5">

                <label for="kategori_id"
                    class="mb-2 block text-sm font-semibold text-gray-700">
                    Kategori
                </label>

                <select
                    name="kategori_id"
                    id="kategori_id"
                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-gray-800 outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-400"
                    required>

                    <option value="">-- Pilih Kelas Terlebih Dahulu --</option>

                    @foreach ($kategoris as $kategori)
                        <option
                            value="{{ $kategori->id }}"
                            data-kelas="{{ $kategori->kelas_id }}"
                            {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                    @endforeach

                </select>

                @error('kategori_id')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror

                <p class="mt-2 text-xs text-gray-500">
                    Kategori akan menyesuaikan dengan kelas yang dipilih.
                </p>

            </div>

            {{-- PILIHAN JAWABAN --}}
            <div class="mb-6">

                <h3 class="mb-4 text-lg font-bold text-gray-800">
                    Pilihan Jawaban
                </h3>

                @foreach (['a' => 'A', 'b' => 'B', 'c' => 'C', 'd' => 'D'] as $key => $label)

                    <div class="mb-4">

                        <label for="pilihan_{{ $key }}"
                            class="mb-2 block text-sm font-semibold text-gray-700">
                            Pilihan {{ $label }}
                        </label>

                        <input
                            type="text"
                            name="pilihan_{{ $key }}"
                            id="pilihan_{{ $key }}"
                            value="{{ old('pilihan_' . $key) }}"
                            class="w-full rounded-lg border border-gray-300 px-4 py-3 text-gray-800 outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-400"
                            placeholder="Masukkan pilihan {{ $label }}"
                            required>

                        @error('pilihan_' . $key)
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror

                    </div>

                @endforeach

            </div>

            {{-- JAWABAN BENAR --}}
            <div class="mb-6">

                <label for="jawaban"
                    class="mb-2 block text-sm font-semibold text-gray-700">
                    Jawaban Benar
                </label>

                <select
                    name="jawaban"
                    id="jawaban"
                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-gray-800 outline-none focus:border-green-400 focus:ring-2 focus:ring-green-400"
                    required>

                    <option value="">-- Pilih Jawaban Benar --</option>

                    @foreach (['A', 'B', 'C', 'D'] as $pilihan)
                        <option
                            value="{{ $pilihan }}"
                            {{ old('jawaban') == $pilihan ? 'selected' : '' }}>
                            {{ $pilihan }}
                        </option>
                    @endforeach

                </select>

                @error('jawaban')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror

            </div>

            {{-- GAMBAR SOAL --}}
            <div class="mb-6">

                <h3 class="mb-2 text-lg font-bold text-gray-800">
                    Gambar Soal
                </h3>

                <p class="mb-4 text-sm text-gray-500">
                    Upload gambar untuk mendukung pertanyaan kuis.
                    Gambar bersifat opsional dan bisa lebih dari satu.
                </p>

                <div id="gambarContainer">

                    <div class="gambar-item mb-3 flex gap-2">

                        <input
                            type="file"
                            name="gambar[]"
                            accept=".jpg,.jpeg,.png,.webp"
                            class="min-w-0 flex-1 rounded-lg border border-gray-300 bg-white px-4 py-3 text-gray-700">

                        <button
                            type="button"
                            onclick="hapusGambar(this)"
                            class="rounded-lg bg-red-500 px-4 py-2 text-white transition hover:bg-red-600">
                            Hapus
                        </button>

                    </div>

                </div>

                <button
                    type="button"
                    onclick="tambahGambar()"
                    class="mt-2 rounded-lg bg-blue-500 px-4 py-2 text-white transition hover:bg-blue-600">
                    + Tambah Gambar
                </button>

                <p class="mt-2 text-xs text-gray-500">
                    Format JPG, JPEG, PNG, WEBP. Maksimal 2 MB per gambar.
                </p>

                @error('gambar')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror

                @error('gambar.*')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror

            </div>

            {{-- AUDIO PERTANYAAN --}}
            <div class="mb-6 rounded-xl border border-blue-200 bg-blue-50 p-5">

                <div class="mb-4">
                    <h3 class="text-lg font-bold text-gray-800">
                        🔊 Audio Pertanyaan
                    </h3>

                    <p class="mt-1 text-sm text-gray-600">
                        Upload suara untuk membacakan pertanyaan kepada anak.
                    </p>
                </div>

                <label for="audio_pertanyaan"
                    class="mb-2 block text-sm font-semibold text-gray-700">
                    File Audio Pertanyaan
                </label>

                <input
                    type="file"
                    name="audio_pertanyaan"
                    id="audio_pertanyaan"
                    accept=".mp3,.wav,.ogg,audio/mpeg,audio/wav,audio/ogg"
                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-gray-700">

                @error('audio_pertanyaan')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror

                <div id="previewContainer_audio_pertanyaan" class="mt-4 hidden">

                    <p class="mb-2 text-sm font-semibold text-gray-700">
                        Preview Audio:
                    </p>

                    <audio
                        id="preview_audio_pertanyaan"
                        controls
                        class="w-full">
                    </audio>

                </div>

            </div>

            {{-- AUDIO PILIHAN JAWABAN --}}
            <div class="mb-6 rounded-xl border border-pink-200 bg-pink-50 p-5">

                <div class="mb-5">
                    <h3 class="text-lg font-bold text-gray-800">
                        🎵 Audio Pilihan Jawaban
                    </h3>

                    <p class="mt-1 text-sm text-gray-600">
                        Upload audio untuk setiap pilihan jawaban.
                        Anak dapat mendengarkan suara dari pilihan A sampai D.
                    </p>
                </div>

                @foreach (['a' => 'A', 'b' => 'B', 'c' => 'C', 'd' => 'D'] as $key => $label)

                    <div class="mb-5 border-b border-pink-200 pb-5 last:mb-0 last:border-0 last:pb-0">

                        <label
                            for="audio_pilihan_{{ $key }}"
                            class="mb-2 block text-sm font-semibold text-gray-700">
                            🔊 Audio Pilihan {{ $label }}
                        </label>

                        <input
                            type="file"
                            name="audio_pilihan_{{ $key }}"
                            id="audio_pilihan_{{ $key }}"
                            accept=".mp3,.wav,.ogg,audio/mpeg,audio/wav,audio/ogg"
                            class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-gray-700">

                        @error('audio_pilihan_' . $key)
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror

                        <div
                            id="previewContainer_audio_pilihan_{{ $key }}"
                            class="mt-3 hidden">

                            <p class="mb-2 text-sm font-semibold text-gray-700">
                                Preview Audio {{ $label }}:
                            </p>

                            <audio
                                id="preview_audio_pilihan_{{ $key }}"
                                controls
                                class="w-full">
                            </audio>

                        </div>

                    </div>

                @endforeach

                <p class="mt-4 text-xs text-gray-500">
                    Format MP3, WAV, atau OGG. Maksimal 10 MB per file audio.
                </p>

            </div>

            {{-- TOMBOL --}}
            <div class="flex justify-end gap-3 border-t border-gray-200 pt-5">

                <a
                    href="{{ route('kuis.index') }}"
                    class="rounded-lg bg-gray-500 px-5 py-2.5 text-white transition hover:bg-gray-600">
                    Batal
                </a>

                <button
                    type="submit"
                    class="rounded-lg bg-blue-600 px-5 py-2.5 font-semibold text-white transition hover:bg-blue-700">
                    Simpan Soal
                </button>

            </div>

        </form>

    </div>

</div>

{{-- CSS --}}
<style>
    input[type="file"] {
        cursor: pointer;
    }

    audio {
        width: 100%;
        height: 40px;
    }

    .gambar-item {
        align-items: center;
    }
</style>

{{-- JAVASCRIPT --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    // =========================================
    // FILTER KATEGORI BERDASARKAN KELAS
    // =========================================

    const kelasSelect = document.getElementById('kelas_id');
    const kategoriSelect = document.getElementById('kategori_id');

    const semuaKategori = Array.from(
        kategoriSelect.querySelectorAll('option[data-kelas]')
    );

    function filterKategori() {

        const kelasId = kelasSelect.value;

        semuaKategori.forEach(function (option) {
            option.hidden = option.dataset.kelas !== kelasId;
        });

        const placeholder = kategoriSelect.querySelector('option[value=""]');

        if (!kelasId) {
            kategoriSelect.value = '';
            placeholder.textContent = '-- Pilih Kelas Terlebih Dahulu --';
            return;
        }

        placeholder.textContent = '-- Pilih Kategori --';

        const kategoriTerpilih = kategoriSelect.value;

        const masihValid = semuaKategori.some(function (option) {
            return (
                option.dataset.kelas === kelasId &&
                option.value === kategoriTerpilih
            );
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

    // =========================================
    // VALIDASI KARAKTER PERTANYAAN
    // =========================================

    const pertanyaan = document.getElementById('pertanyaan');
    const jumlahKarakter = document.getElementById('jumlahKarakter');
    const peringatanKarakter = document.getElementById('peringatanKarakter');

    const karakterDiizinkan = /^[A-Za-z0-9\s?=+\-!.,:;()×÷x]$/u;

    function bersihkanPertanyaan() {

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

    pertanyaan.addEventListener('input', bersihkanPertanyaan);
    bersihkanPertanyaan();

    // =========================================
    // PREVIEW AUDIO
    // =========================================

    const audioFields = [
        'audio_pertanyaan',
        'audio_pilihan_a',
        'audio_pilihan_b',
        'audio_pilihan_c',
        'audio_pilihan_d'
    ];

    audioFields.forEach(function (fieldName) {

        const input = document.getElementById(fieldName);

        const preview = document.getElementById(
            'preview_' + fieldName
        );

        const container = document.getElementById(
            'previewContainer_' + fieldName
        );

        let audioUrl = null;

        input.addEventListener('change', function () {

            const file = this.files[0];

            if (audioUrl) {
                URL.revokeObjectURL(audioUrl);
                audioUrl = null;
            }

            if (!file) {
                preview.pause();
                preview.removeAttribute('src');
                preview.load();
                container.classList.add('hidden');
                return;
            }

            if (!/\.(mp3|wav|ogg)$/i.test(file.name)) {
                alert('Format audio harus MP3, WAV, atau OGG.');
                this.value = '';
                container.classList.add('hidden');
                return;
            }

            if (file.size > 10 * 1024 * 1024) {
                alert('Ukuran audio maksimal 10 MB.');
                this.value = '';
                container.classList.add('hidden');
                return;
            }

            audioUrl = URL.createObjectURL(file);

            preview.src = audioUrl;
            preview.load();

            container.classList.remove('hidden');

        });

    });

});

// =========================================
// TAMBAH INPUT GAMBAR
// =========================================

function tambahGambar() {

    const container = document.getElementById('gambarContainer');

    const div = document.createElement('div');

    div.className = 'gambar-item mb-3 flex gap-2';

    div.innerHTML = `
        <input
            type="file"
            name="gambar[]"
            accept=".jpg,.jpeg,.png,.webp"
            class="min-w-0 flex-1 rounded-lg border border-gray-300 bg-white px-4 py-3 text-gray-700">

        <button
            type="button"
            onclick="hapusGambar(this)"
            class="rounded-lg bg-red-500 px-4 py-2 text-white transition hover:bg-red-600">
            Hapus
        </button>
    `;

    container.appendChild(div);
}

// =========================================
// HAPUS INPUT GAMBAR
// =========================================

function hapusGambar(button) {

    const container = document.getElementById('gambarContainer');

    const semuaInput = container.querySelectorAll('.gambar-item');

    if (semuaInput.length > 1) {
        button.parentElement.remove();
    } else {
        button.parentElement.querySelector('input').value = '';
    }
}
</script>

@endsection
