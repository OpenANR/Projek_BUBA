@extends('layouts.admin.app')

@section('title', 'Tambah Paket Kuis - BUBA')

@section('content')

<div class="mx-auto max-w-5xl px-4 py-6">

    {{-- HEADER --}}
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Tambah Paket Kuis</h1>
            <p class="mt-1 text-sm text-gray-500">
                Buat paket kuis dan tambahkan beberapa soal sekaligus.
            </p>
        </div>

        <a href="{{ route('kuis.index') }}"
           class="rounded-lg bg-gray-500 px-4 py-2 text-white hover:bg-gray-600">
            ← Kembali
        </a>
    </div>

    {{-- ERROR --}}
    @if ($errors->any())
        <div class="mb-5 rounded-lg border border-red-300 bg-red-50 p-4 text-red-700">
            <p class="mb-2 font-bold">Terjadi kesalahan:</p>
            <ul class="list-inside list-disc text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('kuis.kirim') }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf

        {{-- INFORMASI PAKET --}}
        <div class="mb-6 rounded-xl border border-gray-200 bg-white p-6 shadow-sm">

            <h2 class="mb-5 text-lg font-bold text-gray-800">
                📚 Informasi Paket Kuis
            </h2>

            <div class="mb-5">
                <label class="mb-2 block text-sm font-semibold text-gray-700">
                    Nama Paket Kuis
                </label>

                <input type="text"
                       name="nama_kuis"
                       value="{{ old('nama_kuis') }}"
                       maxlength="255"
                       required
                       placeholder="Contoh: Kuis Mengenal Hewan"
                       class="w-full rounded-lg border border-gray-300 px-4 py-3 text-gray-800 outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-400">
            </div>

            <div class="mb-5">
                <label class="mb-2 block text-sm font-semibold text-gray-700">
                    Kelas
                </label>

                <select name="kelas_id"
                        id="kelas_id"
                        required
                        class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-gray-800">
                    <option value="">-- Pilih Kelas --</option>

                    @foreach ($kelas as $item)
                        <option value="{{ $item->id }}"
                            {{ old('kelas_id') == $item->id ? 'selected' : '' }}>
                            {{ $item->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-gray-700">
                    Kategori
                </label>

                <select name="kategori_id"
                        id="kategori_id"
                        required
                        class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-gray-800">

                    <option value="">-- Pilih Kelas Terlebih Dahulu --</option>

                    @foreach ($kategoris as $kategori)
                        <option value="{{ $kategori->id }}"
                                data-kelas="{{ $kategori->kelas_id }}"
                            {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                    @endforeach
                </select>

                <p class="mt-2 text-xs text-gray-500">
                    Kategori akan menyesuaikan dengan kelas yang dipilih.
                </p>
            </div>
        </div>

        {{-- DAFTAR SOAL --}}
        <div class="mb-6">

            <div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">
                        📝 Daftar Pertanyaan
                    </h2>
                    <p class="mt-1 text-sm text-gray-500">
                        Tambahkan pertanyaan yang akan dimasukkan ke paket ini.
                    </p>
                </div>

                <button type="button"
                        onclick="tambahSoal()"
                        class="rounded-lg bg-blue-600 px-4 py-2.5 font-semibold text-white hover:bg-blue-700">
                    + Tambah Soal
                </button>
            </div>

            <div id="soalContainer"></div>

        </div>

        {{-- TOMBOL SIMPAN --}}
        <div class="flex justify-end gap-3 rounded-xl border border-gray-200 bg-white p-5 shadow-sm">

            <a href="{{ route('kuis.index') }}"
               class="rounded-lg bg-gray-500 px-5 py-2.5 text-white hover:bg-gray-600">
                Batal
            </a>

            <button type="submit"
                    class="rounded-lg bg-blue-600 px-6 py-2.5 font-semibold text-white hover:bg-blue-700">
                Simpan Paket Kuis
            </button>

        </div>

    </form>
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

    // =========================================
    // BUAT SOAL PERTAMA
    // =========================================

    tambahSoal();

});

// =========================================
// TEMPLATE SOAL
// =========================================

let nomorSoal = 0;

function tambahSoal() {

    const index = nomorSoal++;

    const container = document.getElementById('soalContainer');

    const card = document.createElement('div');

    card.className = 'soal-card mb-6 overflow-hidden rounded-xl border border-blue-200 bg-white shadow-sm';

    card.dataset.index = index;

    card.innerHTML = `
        <div class="flex items-center justify-between border-b border-blue-100 bg-blue-50 px-5 py-4">

            <h3 class="judul-soal font-bold text-gray-800">
                Soal ${container.children.length + 1}
            </h3>

            <button type="button"
                    onclick="hapusSoal(this)"
                    class="rounded-lg bg-red-100 px-3 py-2 text-sm font-semibold text-red-600 hover:bg-red-200">
                Hapus Soal
            </button>

        </div>

        <div class="p-5">

            {{-- PERTANYAAN --}}
            <div class="mb-6">
                <label class="mb-2 block text-sm font-semibold text-gray-700">
                    Pertanyaan
                </label>

                <textarea
                    name="soal[${index}][pertanyaan]"
                    rows="4"
                    maxlength="1000"
                    required
                    oninput="validasiPertanyaan(this)"
                    placeholder="Masukkan pertanyaan kuis..."
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 text-gray-800 outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-400"></textarea>

                <div class="mt-2 flex justify-between">
                    <p class="text-xs text-gray-500">
                        Gunakan pertanyaan yang mudah dipahami anak.
                    </p>

                    <p class="jumlah-karakter text-xs text-gray-500">
                        0/1000 karakter
                    </p>
                </div>

                <p class="peringatan-karakter mt-1 hidden text-xs text-red-500">
                    Beberapa karakter tidak diizinkan dan telah dihapus.
                </p>
            </div>

            {{-- PILIHAN JAWABAN --}}
            <div class="mb-6">
                <h4 class="mb-4 font-bold text-gray-800">
                    Pilihan Jawaban
                </h4>

                ${['a','b','c','d'].map(function (huruf) {
                    return `
                        <div class="mb-4">
                            <label class="mb-2 block text-sm font-semibold text-gray-700">
                                Pilihan ${huruf.toUpperCase()}
                            </label>

                            <input
                                type="text"
                                name="soal[${index}][pilihan_${huruf}]"
                                required
                                placeholder="Masukkan pilihan ${huruf.toUpperCase()}"
                                class="w-full rounded-lg border border-gray-300 px-4 py-3 text-gray-800">
                        </div>
                    `;
                }).join('')}
            </div>

            {{-- JAWABAN BENAR --}}
            <div class="mb-6">
                <label class="mb-2 block text-sm font-semibold text-gray-700">
                    Jawaban Benar
                </label>

                <select name="soal[${index}][jawaban]"
                        required
                        class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-gray-800">

                    <option value="">-- Pilih Jawaban Benar --</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                    <option value="D">D</option>

                </select>
            </div>

            {{-- GAMBAR --}}
            <div class="mb-6 rounded-xl border border-gray-200 p-4">
                <h4 class="mb-2 font-bold text-gray-800">
                    🖼️ Gambar Soal
                </h4>

                <p class="mb-4 text-xs text-gray-500">
                    Gambar bersifat opsional dan bisa lebih dari satu.
                </p>

                <div class="gambar-container">
                    <div class="gambar-item mb-3 flex gap-2">
                        <input
                            type="file"
                            name="soal[${index}][gambar][]"
                            accept=".jpg,.jpeg,.png,.webp"
                            class="min-w-0 flex-1 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm">

                        <button type="button"
                                onclick="hapusGambar(this)"
                                class="rounded-lg bg-red-500 px-3 py-2 text-sm text-white hover:bg-red-600">
                            Hapus
                        </button>
                    </div>
                </div>

                <button type="button"
                        onclick="tambahGambar(this)"
                        class="rounded-lg bg-blue-500 px-3 py-2 text-sm text-white hover:bg-blue-600">
                    + Tambah Gambar
                </button>

                <p class="mt-2 text-xs text-gray-500">
                    JPG, JPEG, PNG, WEBP. Maksimal 2 MB per gambar.
                </p>
            </div>

            {{-- AUDIO PERTANYAAN --}}
            <div class="mb-6 rounded-xl border border-blue-200 bg-blue-50 p-5">
                <h4 class="mb-2 font-bold text-gray-800">
                    🔊 Audio Pertanyaan
                </h4>

                <p class="mb-4 text-xs text-gray-600">
                    Upload suara untuk membacakan pertanyaan.
                </p>

                ${buatInputAudio(index, 'audio_pertanyaan', 'Audio Pertanyaan')}
            </div>

            {{-- AUDIO PILIHAN --}}
            <div class="rounded-xl border border-pink-200 bg-pink-50 p-5">
                <h4 class="mb-2 font-bold text-gray-800">
                    🎵 Audio Pilihan Jawaban
                </h4>

                <p class="mb-4 text-xs text-gray-600">
                    Upload audio untuk setiap pilihan jawaban.
                </p>

                ${['a','b','c','d'].map(function (huruf) {
                    return buatInputAudio(
                        index,
                        'audio_pilihan_' + huruf,
                        'Audio Pilihan ' + huruf.toUpperCase()
                    );
                }).join('')}

                <p class="mt-3 text-xs text-gray-500">
                    Format MP3, WAV, atau OGG. Maksimal 10 MB per file.
                </p>
            </div>

        </div>
    `;

    container.appendChild(card);

    perbaruiNomorSoal();
}

// =========================================
// TEMPLATE INPUT AUDIO
// =========================================

function buatInputAudio(index, field, label) {

    const id = `audio_${index}_${field}`;

    return `
        <div class="mb-4 last:mb-0">

            <label for="${id}"
                   class="mb-2 block text-sm font-semibold text-gray-700">
                ${label}
            </label>

            <input
                type="file"
                name="soal[${index}][${field}]"
                id="${id}"
                accept=".mp3,.wav,.ogg,audio/mpeg,audio/wav,audio/ogg"
                onchange="previewAudio(this)"
                class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm">

            <div class="preview-audio mt-3 hidden">
                <p class="mb-2 text-xs font-semibold text-gray-700">
                    Preview Audio:
                </p>

                <audio controls class="w-full"></audio>
            </div>

        </div>
    `;
}

// =========================================
// VALIDASI PERTANYAAN
// =========================================

function validasiPertanyaan(textarea) {

    const karakterDiizinkan = /^[A-Za-z0-9\s?=+\-!.,:;()×÷x]$/u;

    const nilaiAwal = textarea.value;

    const nilaiBersih = Array.from(nilaiAwal)
        .filter(karakter => karakterDiizinkan.test(karakter))
        .join('');

    if (nilaiAwal !== nilaiBersih) {
        textarea.value = nilaiBersih;
        textarea.closest('.mb-6')
            .querySelector('.peringatan-karakter')
            .classList.remove('hidden');
    } else {
        textarea.closest('.mb-6')
            .querySelector('.peringatan-karakter')
            .classList.add('hidden');
    }

    textarea.closest('.mb-6')
        .querySelector('.jumlah-karakter')
        .textContent = `${Array.from(textarea.value).length}/1000 karakter`;
}

// =========================================
// TAMBAH GAMBAR
// =========================================

function tambahGambar(button) {

    const container = button.previousElementSibling;

    const item = document.createElement('div');

    item.className = 'gambar-item mb-3 flex gap-2';

    item.innerHTML = `
        <input
            type="file"
            name="${container.querySelector('input').name}"
            accept=".jpg,.jpeg,.png,.webp"
            class="min-w-0 flex-1 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm">

        <button type="button"
                onclick="hapusGambar(this)"
                class="rounded-lg bg-red-500 px-3 py-2 text-sm text-white hover:bg-red-600">
            Hapus
        </button>
    `;

    container.appendChild(item);
}

// =========================================
// HAPUS GAMBAR
// =========================================

function hapusGambar(button) {

    const container = button.closest('.gambar-container');

    const semua = container.querySelectorAll('.gambar-item');

    if (semua.length > 1) {
        button.closest('.gambar-item').remove();
    } else {
        button.closest('.gambar-item').querySelector('input').value = '';
    }
}

// =========================================
// PREVIEW AUDIO
// =========================================

function previewAudio(input) {

    const file = input.files[0];

    const container = input.parentElement.querySelector('.preview-audio');

    const audio = container.querySelector('audio');

    if (!file) {
        audio.pause();
        audio.removeAttribute('src');
        audio.load();
        container.classList.add('hidden');
        return;
    }

    if (!/\.(mp3|wav|ogg)$/i.test(file.name)) {
        alert('Format audio harus MP3, WAV, atau OGG.');
        input.value = '';
        container.classList.add('hidden');
        return;
    }

    if (file.size > 10 * 1024 * 1024) {
        alert('Ukuran audio maksimal 10 MB.');
        input.value = '';
        container.classList.add('hidden');
        return;
    }

    if (audio.dataset.url) {
        URL.revokeObjectURL(audio.dataset.url);
    }

    const url = URL.createObjectURL(file);

    audio.dataset.url = url;
    audio.src = url;
    audio.load();

    container.classList.remove('hidden');
}

// =========================================
// HAPUS SOAL
// =========================================

function hapusSoal(button) {

    const container = document.getElementById('soalContainer');

    if (container.children.length <= 1) {
        alert('Minimal harus ada satu soal dalam paket kuis.');
        return;
    }

    button.closest('.soal-card').remove();

    perbaruiNomorSoal();
}

// =========================================
// PERBARUI NOMOR SOAL
// =========================================

function perbaruiNomorSoal() {

    document.querySelectorAll('.soal-card').forEach(function (card, index) {
        card.querySelector('.judul-soal').textContent = `Soal ${index + 1}`;
    });
}
</script>

@endsection
