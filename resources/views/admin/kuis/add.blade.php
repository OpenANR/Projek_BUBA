@extends('layouts.admin.app')

@section('title', 'Tambah Kuis - BUBA')

@section('content')

<div class="max-w-4xl mx-auto">

    {{-- HEADER --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                Tambah Kuis
            </h1>

            <p class="text-gray-500 mt-1">
                Isi form untuk menambahkan pertanyaan kuis baru.
            </p>
        </div>
    </div>

    {{-- ERROR VALIDASI --}}
    @if ($errors->any())
        <div class="mb-5 p-4 rounded-lg bg-red-100 border border-red-300 text-red-700">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- FORM KUIS --}}
    <div class="bg-white rounded-xl shadow-md p-6">

        <form action="{{ route('kuis.kirim') }}"
              method="POST"
              enctype="multipart/form-data"
              id="formKuis">

            @csrf

            {{-- KELAS --}}
            <div class="mb-5">

                <label for="kelas_id"
                       class="block text-sm font-semibold text-gray-700 mb-2">
                    Kelas
                    <span class="text-red-500">*</span>
                </label>

                <select name="kelas_id"
                        id="kelas_id"
                        required
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-800 bg-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none">

                    <option value="">-- Pilih Kelas --</option>

                    @foreach ($kelas as $item)
                        <option value="{{ $item->id }}"
                            {{ old('kelas_id') == $item->id ? 'selected' : '' }}>
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

            {{-- KATEGORI --}}
            <div class="mb-6">

                <label for="kategori_id"
                       class="block text-sm font-semibold text-gray-700 mb-2">
                    Kategori Kuis
                    <span class="text-red-500">*</span>
                </label>

                <select name="kategori_id"
                        id="kategori_id"
                        required
                        disabled
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-800 bg-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none">

                    <option value="">
                        -- Pilih Kelas Terlebih Dahulu --
                    </option>

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

                @error('kategori_id')
                    <p class="text-sm text-red-600 mt-2">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            {{-- DAFTAR SOAL --}}
            <div class="mb-6">

                <div class="mb-4">
                    <h3 class="text-base font-bold text-gray-800">
                        Daftar Pertanyaan
                    </h3>

                    <p class="text-xs text-gray-500 mt-1">
                        Masukkan pertanyaan kuis beserta pilihan jawabannya.
                    </p>
                </div>

                <div id="soalContainer"></div>

            </div>

            {{-- TOMBOL --}}
            <div class="flex justify-end gap-3 border-t border-gray-100 pt-5">

                <a href="{{ route('kuis.index') }}"
                   class="px-5 py-2.5 rounded-lg bg-gray-500 text-white hover:bg-gray-600 transition">
                    Batal
                </a>

                <button type="submit"
                        class="px-5 py-2.5 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition">
                    ✓ Simpan Kuis
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

    // =========================================
    // TAMPILKAN SATU SOAL SECARA OTOMATIS
    // =========================================

    tambahSoal();

});


// =========================================
// TEMPLATE SATU SOAL
// =========================================

function tambahSoal() {

    const index = 0;
    const container = document.getElementById('soalContainer');

    const card = document.createElement('div');

    card.className = 'soal-card overflow-hidden rounded-xl border border-gray-200 bg-white';

    card.dataset.index = index;

    card.innerHTML = `
        <div class="border-b border-gray-200 bg-gray-50 px-4 py-3">

            <h3 class="font-bold text-gray-800">
                Pertanyaan Kuis
            </h3>

        </div>

        <div class="space-y-5 p-4">

            {{-- PERTANYAAN --}}
            <div>
                <label class="mb-2 block text-sm font-semibold text-gray-700">
                    Pertanyaan
                    <span class="text-red-500">*</span>
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
            <div>
                <h4 class="mb-3 font-bold text-gray-800">
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
                                class="w-full rounded-lg border border-gray-300 px-4 py-3 text-gray-800 outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-400">
                        </div>
                    `;
                }).join('')}
            </div>

            {{-- JAWABAN BENAR --}}
            <div>
                <label class="mb-2 block text-sm font-semibold text-gray-700">
                    Jawaban Benar
                    <span class="text-red-500">*</span>
                </label>

                <select name="soal[${index}][jawaban]"
                        required
                        class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-gray-800 outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-400">

                    <option value="">-- Pilih Jawaban Benar --</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                    <option value="D">D</option>

                </select>
            </div>

            {{-- GAMBAR --}}
            <div class="rounded-lg border border-gray-200 p-4">

                <h4 class="mb-2 font-bold text-gray-800">
                    Gambar Soal
                    <span class="font-normal text-gray-500 text-xs">(Opsional)</span>
                </h4>

                <p class="mb-3 text-xs text-gray-500">
                    Gambar bisa lebih dari satu.
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
            <div class="rounded-lg border border-gray-200 p-4">

                <h4 class="mb-2 font-bold text-gray-800">
                    Audio Pertanyaan
                    <span class="font-normal text-gray-500 text-xs">(Opsional)</span>
                </h4>

                <p class="mb-3 text-xs text-gray-500">
                    Upload suara untuk membacakan pertanyaan.
                </p>

                ${buatInputAudio(index, 'audio_pertanyaan', 'Audio Pertanyaan')}

            </div>

            {{-- AUDIO PILIHAN --}}
            <div class="rounded-lg border border-gray-200 p-4">

                <h4 class="mb-2 font-bold text-gray-800">
                    Audio Pilihan Jawaban
                    <span class="font-normal text-gray-500 text-xs">(Opsional)</span>
                </h4>

                <p class="mb-3 text-xs text-gray-500">
                    Upload audio untuk setiap pilihan jawaban.
                </p>

                ${['a','b','c','d'].map(function (huruf) {
                    return buatInputAudio(
                        index,
                        'audio_pilihan_' + huruf,
                        'Audio Pilihan ' + huruf.toUpperCase()
                    );
                }).join('')}

                <p class="mt-2 text-xs text-gray-500">
                    Format MP3, WAV, atau OGG. Maksimal 10 MB per file.
                </p>

            </div>

        </div>
    `;

    container.appendChild(card);
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

        textarea.closest('.soal-card')
            .querySelector('.peringatan-karakter')
            .classList.remove('hidden');
    } else {
        textarea.closest('.soal-card')
            .querySelector('.peringatan-karakter')
            .classList.add('hidden');
    }

    textarea.closest('.soal-card')
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

</script>

@endsection
