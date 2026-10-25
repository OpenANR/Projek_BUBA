@extends('layouts.admin.app')

@section('title', 'Edit Paket Kuis - BUBA')

@section('content')
<div class="max-w-5xl mx-auto">

    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Edit Paket Kuis</h1>
        <p class="text-gray-500 text-sm mt-1">
            Ubah informasi paket dan soal-soal di dalamnya.
        </p>
    </div>

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

        <form action="{{ route('kuis.update', $paket->id) }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            {{-- INFORMASI PAKET --}}
            <h2 class="text-xl font-bold text-gray-800 mb-4">
                Informasi Paket Kuis
            </h2>

            <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Nama Paket Kuis
                </label>
                <input
                    type="text"
                    name="nama_kuis"
                    value="{{ old('nama_kuis', $paket->nama_kuis) }}"
                    required
                    class="w-full border border-gray-300 rounded-lg px-4 py-3"
                    placeholder="Masukkan nama paket kuis">
                @error('nama_kuis')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-8">

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Kelas
                    </label>
                    <select
                        name="kelas_id"
                        id="kelas_id"
                        required
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 bg-white">

                        @foreach ($kelas as $item)
                            <option value="{{ $item->id }}"
                                {{ old('kelas_id', $paket->kelas_id) == $item->id ? 'selected' : '' }}>
                                {{ $item->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Kategori
                    </label>
                    <select
                        name="kategori_id"
                        id="kategori_id"
                        required
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 bg-white">

                        @foreach ($kategoris as $kategori)
                            <option
                                value="{{ $kategori->id }}"
                                data-kelas="{{ $kategori->kelas_id }}"
                                {{ old('kategori_id', $paket->kategori_id) == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>

            <div class="border-t border-gray-200 pt-6 mb-6">
                <div class="flex justify-between items-center gap-3 mb-5">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">
                            Daftar Soal
                        </h2>
                        <p class="text-sm text-gray-500">
                            Edit soal yang sudah ada atau tambahkan soal baru.
                        </p>
                    </div>

                    <button
                        type="button"
                        id="tambahSoal"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold">
                        + Tambah Soal
                    </button>
                </div>

                <div id="soalContainer" class="space-y-6">

                    @foreach ($quis as $index => $soal)

                        @php
                            $gambarLama = $soal->gambar ?? [];

                            if (is_string($gambarLama)) {
                                $decoded = json_decode($gambarLama, true);
                                $gambarLama = is_array($decoded)
                                    ? $decoded
                                    : [$gambarLama];
                            }

                            if (!is_array($gambarLama)) {
                                $gambarLama = [];
                            }

                            $gambarLama = array_filter($gambarLama);

                            $daftarAudio = [
                                'audio_pertanyaan' => 'Audio Pertanyaan',
                                'audio_pilihan_a' => 'Audio Pilihan A',
                                'audio_pilihan_b' => 'Audio Pilihan B',
                                'audio_pilihan_c' => 'Audio Pilihan C',
                                'audio_pilihan_d' => 'Audio Pilihan D',
                            ];
                        @endphp

                        <div class="soal-card border border-gray-200 rounded-xl p-5"
                             data-index="{{ $index }}">

                            <div class="flex justify-between items-center mb-5">
                                <h3 class="text-lg font-bold text-gray-800">
                                    Soal {{ $index + 1 }}
                                </h3>

                                <button
                                    type="button"
                                    class="hapusSoal text-red-600 hover:text-red-800 font-semibold">
                                    Hapus Soal
                                </button>
                            </div>

                            <input
                                type="hidden"
                                name="soal[{{ $index }}][id]"
                                value="{{ $soal->id }}">

                            <div class="mb-5">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Kode Kuis
                                </label>
                                <input
                                    type="text"
                                    value="{{ $soal->kode_kuis }}"
                                    readonly
                                    class="w-full border border-gray-300 rounded-lg px-4 py-3 bg-gray-100 text-gray-500">
                            </div>

                            <div class="mb-5">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Pertanyaan
                                </label>
                                <textarea
                                    name="soal[{{ $index }}][pertanyaan]"
                                    rows="3"
                                    required
                                    class="w-full border border-gray-300 rounded-lg px-4 py-3">{{ old("soal.$index.pertanyaan", $soal->pertanyaan) }}</textarea>
                            </div>

                            {{-- PILIHAN JAWABAN --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">

                                @foreach (['a', 'b', 'c', 'd'] as $opsi)
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Pilihan {{ strtoupper($opsi) }}
                                        </label>
                                        <input
                                            type="text"
                                            name="soal[{{ $index }}][pilihan_{{ $opsi }}]"
                                            value="{{ old("soal.$index.pilihan_$opsi", $soal->{'pilihan_'.$opsi}) }}"
                                            required
                                            class="w-full border border-gray-300 rounded-lg px-4 py-3">
                                    </div>
                                @endforeach

                            </div>

                            {{-- JAWABAN BENAR --}}
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Jawaban Benar
                                </label>

                                <select
                                    name="soal[{{ $index }}][jawaban]"
                                    required
                                    class="w-full border border-gray-300 rounded-lg px-4 py-3 bg-white">

                                    @foreach (['A', 'B', 'C', 'D'] as $jawaban)
                                        <option value="{{ $jawaban }}"
                                            {{ old("soal.$index.jawaban", $soal->jawaban) == $jawaban ? 'selected' : '' }}>
                                            {{ $jawaban }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- GAMBAR LAMA --}}
                            <div class="mb-5">
                                <label class="block text-sm font-semibold text-gray-700 mb-3">
                                    Gambar Saat Ini
                                </label>

                                @if (count($gambarLama))
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                        @foreach ($gambarLama as $gambar)
                                            <div class="border rounded-lg p-2">
                                                <img
                                                    src="{{ asset('storage/' . $gambar) }}"
                                                    class="w-full h-28 object-contain bg-gray-50 rounded">
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-sm text-gray-500">
                                        Belum ada gambar.
                                    </p>
                                @endif
                            </div>

                            {{-- GAMBAR BARU --}}
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Tambah / Ganti Gambar
                                </label>

                                <input
                                    type="file"
                                    name="soal[{{ $index }}][gambar][]"
                                    multiple
                                    accept=".jpg,.jpeg,.png,.webp"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-3">

                                <p class="text-xs text-gray-400 mt-1">
                                    Kosongkan jika ingin mempertahankan gambar lama.
                                </p>
                            </div>

                            {{-- AUDIO --}}
                            <div class="border-t border-gray-200 pt-5">
                                <h4 class="font-bold text-gray-800 mb-4">
                                    Audio Soal dan Pilihan Jawaban
                                </h4>

                                <div class="space-y-5">

                                    @foreach ($daftarAudio as $field => $label)

                                        <div class="border border-gray-200 rounded-lg p-4">

                                            <label class="block text-sm font-semibold text-gray-700 mb-3">
                                                {{ $label }}
                                            </label>

                                            @if (!empty($soal->$field))
                                                <audio controls preload="metadata" class="w-full mb-3">
                                                    <source src="{{ asset('storage/' . $soal->$field) }}">
                                                    Browser tidak mendukung audio.
                                                </audio>
                                            @else
                                                <p class="text-sm text-gray-500 mb-3">
                                                    Belum ada audio.
                                                </p>
                                            @endif

                                            <input
                                                type="file"
                                                name="soal[{{ $index }}][{{ $field }}]"
                                                accept=".mp3,.wav,.ogg,audio/*"
                                                class="w-full border border-gray-300 rounded-lg px-4 py-3">

                                            <p class="text-xs text-gray-400 mt-1">
                                                Kosongkan jika ingin mempertahankan audio lama.
                                            </p>

                                        </div>

                                    @endforeach

                                </div>
                            </div>

                        </div>

                    @endforeach

                </div>
            </div>

            {{-- TOMBOL --}}
            <div class="flex justify-end gap-3 border-t pt-6">

                <a href="{{ route('kuis.index') }}"
                   class="px-5 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg">
                    Batal
                </a>

                <button
                    type="submit"
                    class="px-5 py-2.5 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded-lg">
                    Simpan Perubahan
                </button>

            </div>

        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const container = document.getElementById('soalContainer');
    const tambahButton = document.getElementById('tambahSoal');
    const kelasSelect = document.getElementById('kelas_id');
    const kategoriSelect = document.getElementById('kategori_id');

    let nextIndex = {{ $quis->count() }};

    const semuaKategori = Array.from(
        kategoriSelect.querySelectorAll('option[data-kelas]')
    );

    function filterKategori() {
        const kelasId = kelasSelect.value;

        semuaKategori.forEach(option => {
            option.hidden = option.dataset.kelas !== kelasId;
        });

        const selected = kategoriSelect.selectedOptions[0];

        if (selected && selected.dataset.kelas !== kelasId) {
            kategoriSelect.value = '';
        }
    }

    kelasSelect.addEventListener('change', filterKategori);
    filterKategori();

    function perbaruiNomor() {
        container.querySelectorAll('.soal-card').forEach((card, index) => {
            card.querySelector('h3').textContent = 'Soal ' + (index + 1);
        });
    }

    tambahButton.addEventListener('click', function () {

        const index = nextIndex++;

        const card = document.createElement('div');
        card.className = 'soal-card border border-gray-200 rounded-xl p-5';

        card.innerHTML = `
            <div class="flex justify-between items-center mb-5">
                <h3 class="text-lg font-bold text-gray-800">Soal Baru</h3>
                <button type="button"
                    class="hapusSoal text-red-600 hover:text-red-800 font-semibold">
                    Hapus Soal
                </button>
            </div>

            <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Pertanyaan
                </label>
                <textarea name="soal[${index}][pertanyaan]"
                    rows="3" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-3"></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
                ${['a','b','c','d'].map(opsi => `
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Pilihan ${opsi.toUpperCase()}
                        </label>
                        <input type="text"
                            name="soal[${index}][pilihan_${opsi}]"
                            required
                            class="w-full border border-gray-300 rounded-lg px-4 py-3">
                    </div>
                `).join('')}
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Jawaban Benar
                </label>
                <select name="soal[${index}][jawaban]" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 bg-white">
                    <option value="">-- Pilih Jawaban --</option>
                    ${['A','B','C','D'].map(j => `
                        <option value="${j}">${j}</option>
                    `).join('')}
                </select>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Gambar Soal
                </label>
                <input type="file"
                    name="soal[${index}][gambar][]"
                    multiple
                    accept=".jpg,.jpeg,.png,.webp"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3">
            </div>

            <div class="border-t border-gray-200 pt-5">
                <h4 class="font-bold text-gray-800 mb-4">
                    Audio Soal dan Pilihan Jawaban
                </h4>

                <div class="space-y-5">
                    ${[
                        ['audio_pertanyaan','Audio Pertanyaan'],
                        ['audio_pilihan_a','Audio Pilihan A'],
                        ['audio_pilihan_b','Audio Pilihan B'],
                        ['audio_pilihan_c','Audio Pilihan C'],
                        ['audio_pilihan_d','Audio Pilihan D']
                    ].map(([field,label]) => `
                        <div class="border border-gray-200 rounded-lg p-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-3">
                                ${label}
                            </label>
                            <input type="file"
                                name="soal[${index}][${field}]"
                                accept=".mp3,.wav,.ogg,audio/*"
                                class="w-full border border-gray-300 rounded-lg px-4 py-3">
                        </div>
                    `).join('')}
                </div>
            </div>
        `;

        container.appendChild(card);
        perbaruiNomor();
        card.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });

    container.addEventListener('click', function (event) {

        if (event.target.classList.contains('hapusSoal')) {
            const cards = container.querySelectorAll('.soal-card');

            if (cards.length <= 1) {
                alert('Minimal harus ada satu soal dalam paket kuis.');
                return;
            }

            const card = event.target.closest('.soal-card');
            const idInput = card.querySelector('input[name$="[id]"]');

            if (idInput) {
                const hidden = document.createElement('input');
                hidden.type = 'hidden';
                hidden.name = 'hapus_soal[]';
                hidden.value = idInput.value;
                card.appendChild(hidden);
            }

            card.remove();
            perbaruiNomor();
        }
    });

});
</script>
@endsection
