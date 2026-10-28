@extends('layouts.admin.app')

@section('title', 'Edit Kuis - BUBA')

@section('content')

<div class="max-w-4xl mx-auto">

    {{-- HEADER --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Edit Kuis
            </h1>

            <p class="text-gray-500 text-sm mt-1">
                Ubah informasi pertanyaan dan pilihan jawaban kuis.
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

    {{-- CARD EDIT KUIS --}}
    <div class="bg-white rounded-xl shadow-md p-6">

        <form action="{{ route('kuis.update', $quis->first()->kode_kuis) }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            {{-- INFORMASI KUIS --}}
            <h2 class="text-lg font-bold text-gray-800 mb-5">
                Informasi Kuis
            </h2>

            {{-- KELAS --}}
            <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Kelas
                </label>

                <select name="kelas_id"
                        id="kelas_id"
                        required
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 bg-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none">

                    @foreach ($kelas as $item)
                        <option value="{{ $item->id }}"
                            {{ old('kelas_id', $quis->first()->kelas_id) == $item->id ? 'selected' : '' }}>
                            {{ $item->nama_kelas }}
                        </option>
                    @endforeach

                </select>
            </div>

            {{-- KATEGORI --}}
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Kategori
                </label>

                <select name="kategori_id"
                        id="kategori_id"
                        required
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 bg-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none">

                    @foreach ($kategoris as $kategori)
                        <option value="{{ $kategori->id }}"
                                data-kelas="{{ $kategori->kelas_id }}"
                            {{ old('kategori_id', $quis->first()->kategori_id) == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                    @endforeach

                </select>
            </div>

            {{-- DAFTAR SOAL --}}
            <div class="border-t border-gray-200 pt-6">

                <div class="flex flex-wrap justify-between items-center gap-3 mb-5">

                    <div>
                        <h2 class="text-lg font-bold text-gray-800">
                            Daftar Pertanyaan
                        </h2>

                        <p class="text-sm text-gray-500 mt-1">
                            Edit pertanyaan, pilihan jawaban, gambar, dan audio.
                        </p>
                    </div>

                </div>

                <div id="soalContainer" class="space-y-6">

                    @foreach ($quis as $index => $soal)

                        @php
                            $gambarLama = $soal->gambar ?? [];

                            if (is_string($gambarLama)) {
                                $decoded = json_decode($gambarLama, true);
                                $gambarLama = is_array($decoded) ? $decoded : [$gambarLama];
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

                        <div class="soal-card border border-gray-200 rounded-xl p-5">

                            {{-- HEADER SOAL --}}
                            <div class="flex justify-between items-center gap-3 mb-5 pb-4 border-b border-gray-100">

                                <h3 class="text-lg font-bold text-gray-800">
                                    Soal {{ $index + 1 }}
                                </h3>

                            </div>

                            <input type="hidden"
                                   name="soal[{{ $index }}][id]"
                                   value="{{ $soal->id }}">

                            {{-- KODE KUIS --}}
                            <div class="mb-5">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Kode Kuis
                                </label>

                                <input type="text"
                                       value="{{ $soal->kode_kuis }}"
                                       readonly
                                       class="w-full border border-gray-300 rounded-lg px-4 py-3 bg-gray-100 text-gray-500">
                            </div>

                            {{-- PERTANYAAN --}}
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Pertanyaan
                                </label>

                                <textarea name="soal[{{ $index }}][pertanyaan]"
                                          rows="4"
                                          maxlength="1000"
                                          required
                                          class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-800 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none">{{ old("soal.$index.pertanyaan", $soal->pertanyaan) }}</textarea>
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
                                                   name="soal[{{ $index }}][pilihan_{{ $opsi }}]"
                                                   value="{{ old("soal.$index.pilihan_$opsi", $soal->{'pilihan_'.$opsi}) }}"
                                                   required
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

                                <select name="soal[{{ $index }}][jawaban]"
                                        required
                                        class="w-full border border-gray-300 rounded-lg px-4 py-3 bg-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none">

                                    @foreach (['A', 'B', 'C', 'D'] as $jawaban)
                                        <option value="{{ $jawaban }}"
                                            {{ old("soal.$index.jawaban", $soal->jawaban) == $jawaban ? 'selected' : '' }}>
                                            Pilihan {{ $jawaban }}
                                        </option>
                                    @endforeach

                                </select>

                            </div>

                            {{-- GAMBAR SAAT INI --}}
                            <div class="mb-5">

                                <label class="block text-sm font-semibold text-gray-700 mb-3">
                                    Gambar Saat Ini
                                </label>

                                @if (count($gambarLama))

                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

                                        @foreach ($gambarLama as $gambar)
                                            <a href="{{ asset('storage/' . $gambar) }}"
                                               target="_blank"
                                               class="block">

                                                <img src="{{ asset('storage/' . $gambar) }}"
                                                     alt="Gambar soal"
                                                     class="w-full h-36 object-contain rounded-lg border border-gray-200 bg-gray-50 hover:shadow-md transition">

                                            </a>
                                        @endforeach

                                    </div>

                                @else

                                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 text-sm text-gray-500">
                                        Belum ada gambar.
                                    </div>

                                @endif

                            </div>

                            {{-- TAMBAH / GANTI GAMBAR --}}
                            <div class="mb-6">

                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Tambah / Ganti Gambar
                                </label>

                                <input type="file"
                                       name="soal[{{ $index }}][gambar][]"
                                       multiple
                                       accept=".jpg,.jpeg,.png,.webp"
                                       class="w-full border border-gray-300 rounded-lg px-4 py-3 bg-white">

                                <p class="text-xs text-gray-400 mt-2">
                                    Kosongkan jika ingin mempertahankan gambar lama.
                                </p>

                            </div>

                            {{-- AUDIO --}}
                            <div class="border-t border-gray-200 pt-5">

                                <h4 class="font-bold text-gray-800 mb-4">
                                    Audio Soal dan Pilihan Jawaban
                                </h4>

                                <div class="space-y-4">

                                    @foreach ($daftarAudio as $field => $label)

                                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">

                                            <label class="block text-sm font-semibold text-gray-700 mb-3">
                                                {{ $label }}
                                            </label>

                                            @if (!empty($soal->$field))

                                                @php
                                                    $extension = strtolower(
                                                        pathinfo($soal->$field, PATHINFO_EXTENSION)
                                                    );

                                                    $audioType = match ($extension) {
                                                        'mp3' => 'audio/mpeg',
                                                        'wav' => 'audio/wav',
                                                        'ogg' => 'audio/ogg',
                                                        'aac' => 'audio/aac',
                                                        default => 'audio/mpeg',
                                                    };
                                                @endphp

                                                <div class="flex items-center gap-3 mb-3">

                                                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                                        🔊
                                                    </div>

                                                    <div>
                                                        <p class="font-semibold text-gray-800">
                                                            Audio tersedia
                                                        </p>

                                                        <p class="text-xs text-gray-500">
                                                            {{ strtoupper($extension) }}
                                                        </p>
                                                    </div>

                                                </div>

                                                <audio controls preload="metadata" class="w-full mb-4">
                                                    <source src="{{ asset('storage/' . $soal->$field) }}"
                                                            type="{{ $audioType }}">
                                                    Browser tidak mendukung audio.
                                                </audio>

                                            @else

                                                <p class="text-sm text-gray-500 mb-3">
                                                    Belum ada audio.
                                                </p>

                                            @endif

                                            <input type="file"
                                                   name="soal[{{ $index }}][{{ $field }}]"
                                                   accept=".mp3,.wav,.ogg,audio/*"
                                                   class="w-full border border-gray-300 rounded-lg px-4 py-3 bg-white">

                                            <p class="text-xs text-gray-400 mt-2">
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
            <div class="flex justify-end gap-3 border-t border-gray-100 pt-6 mt-6">

                <a href="{{ route('kuis.index') }}"
                   class="px-5 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg">
                    Batal
                </a>

                <button type="submit"
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

    // FILTER KATEGORI BERDASARKAN KELAS
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

    kelasSelect.addEventListener('change', function () {
        filterKategori();
        kategoriSelect.value = '';
    });

    filterKategori();

    // PERBARUI NOMOR SOAL
    function perbaruiNomor() {

        container.querySelectorAll('.soal-card').forEach((card, index) => {
            card.querySelector('h3').textContent = 'Soal ' + (index + 1);
        });

    }

    // TAMBAH SOAL BARU
    tambahButton.addEventListener('click', function () {

        const index = nextIndex++;

        const card = document.createElement('div');

        card.className = 'soal-card border border-gray-200 rounded-xl p-5';

        card.innerHTML = `
            <div class="flex justify-between items-center gap-3 mb-5 pb-4 border-b border-gray-100">

                <h3 class="text-lg font-bold text-gray-800">
                    Soal Baru
                </h3>

                <button type="button"
                        class="hapusSoal text-sm text-red-600 hover:text-red-800 font-semibold">
                    Hapus Soal
                </button>

            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Pertanyaan
                </label>

                <textarea name="soal[${index}][pertanyaan]"
                          rows="4"
                          maxlength="1000"
                          required
                          class="w-full border border-gray-300 rounded-lg px-4 py-3"></textarea>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-3">
                    Pilihan Jawaban
                </label>

                <div class="space-y-4">
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
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Jawaban Benar
                </label>

                <select name="soal[${index}][jawaban]"
                        required
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 bg-white">

                    <option value="">-- Pilih Jawaban --</option>
                    ${['A','B','C','D'].map(j => `
                        <option value="${j}">Pilihan ${j}</option>
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
                       class="w-full border border-gray-300 rounded-lg px-4 py-3 bg-white">

                <p class="text-xs text-gray-400 mt-2">
                    Kosongkan jika tidak ingin menambahkan gambar.
                </p>
            </div>

            <div class="border-t border-gray-200 pt-5">

                <h4 class="font-bold text-gray-800 mb-4">
                    Audio Soal dan Pilihan Jawaban
                </h4>

                <div class="space-y-4">

                    ${[
                        ['audio_pertanyaan', 'Audio Pertanyaan'],
                        ['audio_pilihan_a', 'Audio Pilihan A'],
                        ['audio_pilihan_b', 'Audio Pilihan B'],
                        ['audio_pilihan_c', 'Audio Pilihan C'],
                        ['audio_pilihan_d', 'Audio Pilihan D']
                    ].map(([field, label]) => `
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">

                            <label class="block text-sm font-semibold text-gray-700 mb-3">
                                ${label}
                            </label>

                            <input type="file"
                                   name="soal[${index}][${field}]"
                                   accept=".mp3,.wav,.ogg,audio/*"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-3 bg-white">

                        </div>
                    `).join('')}

                </div>

            </div>
        `;

        container.appendChild(card);

        perbaruiNomor();

        card.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });

    });

    // HAPUS SOAL
    container.addEventListener('click', function (event) {

        if (!event.target.classList.contains('hapusSoal')) {
            return;
        }

        const cards = container.querySelectorAll('.soal-card');

        if (cards.length <= 1) {
            alert('Minimal harus ada satu soal.');
            return;
        }

        const card = event.target.closest('.soal-card');

        const idInput = card.querySelector('input[name$="[id]"]');

        // Tandai soal lama agar dihapus oleh controller
        if (idInput) {

            const hidden = document.createElement('input');

            hidden.type = 'hidden';
            hidden.name = 'hapus_soal[]';
            hidden.value = idInput.value;

            card.appendChild(hidden);

        }

        card.remove();

        perbaruiNomor();

    });

});
</script>

@endsection
