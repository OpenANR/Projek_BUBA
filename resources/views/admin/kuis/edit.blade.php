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
                    value="{{ $quis->kode_kuis }}"
                    readonly
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-500 bg-gray-100"
                >

                <p class="text-xs text-gray-400 mt-1">
                    Kode kuis dibuat otomatis dan tidak dapat diubah.
                </p>
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
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
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
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-800 bg-white"
                >
                    <option value="">-- Pilih Kelas --</option>

                    @foreach ($kelas as $item)
                        <option
                            value="{{ $item->id }}"
                            {{ old('kelas_id', $quis->kelas_id) == $item->id ? 'selected' : '' }}
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
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Kategori
                </label>

                <select
                    name="kategori_id"
                    id="kategori_id"
                    required
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-800 bg-white"
                >
                    <option value="">-- Pilih Kategori --</option>

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
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Pilihan Jawaban --}}
            @foreach (['a', 'b', 'c', 'd'] as $opsi)
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Pilihan {{ strtoupper($opsi) }}
                    </label>

                    <input
                        type="text"
                        name="pilihan_{{ $opsi }}"
                        value="{{ old('pilihan_' . $opsi, $quis->{'pilihan_' . $opsi}) }}"
                        required
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    >

                    @error('pilihan_' . $opsi)
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            @endforeach

            {{-- Jawaban Benar --}}
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Jawaban Benar
                </label>

                <select
                    name="jawaban"
                    required
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-800 bg-white"
                >
                    <option value="">-- Pilih Jawaban Benar --</option>

                    @foreach (['A', 'B', 'C', 'D'] as $jawaban)
                        <option
                            value="{{ $jawaban }}"
                            {{ old('jawaban', $quis->jawaban) == $jawaban ? 'selected' : '' }}
                        >
                            {{ $jawaban }}
                        </option>
                    @endforeach
                </select>

                @error('jawaban')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Gambar Saat Ini --}}
            @php
                $gambarLama = $quis->gambar ?? [];

                if (is_string($gambarLama)) {
                    $decoded = json_decode($gambarLama, true);
                    $gambarLama = is_array($decoded) ? $decoded : [$gambarLama];
                }

                if (!is_array($gambarLama)) {
                    $gambarLama = [];
                }

                $gambarLama = array_filter($gambarLama);
            @endphp

            <div class="mb-6">
                <p class="text-sm font-semibold text-gray-700 mb-3">
                    Gambar Saat Ini
                </p>

                @if (count($gambarLama) > 0)
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach ($gambarLama as $gambar)
                            <div class="border border-gray-200 rounded-lg p-2">
                                <img
                                    src="{{ asset('storage/' . $gambar) }}"
                                    alt="Gambar soal"
                                    class="w-full h-32 object-contain rounded-lg bg-gray-50"
                                >
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-4 rounded-lg bg-gray-50 border border-gray-200 text-sm text-gray-500">
                        Belum ada gambar.
                    </div>
                @endif
            </div>

            {{-- Ganti Gambar --}}
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Ganti Gambar
                </label>

                <input
                    type="file"
                    name="gambar[]"
                    id="gambar"
                    multiple
                    accept=".jpg,.jpeg,.png,.webp"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-800 bg-white"
                >

                <p class="text-xs text-gray-400 mt-1">
                    Jika memilih gambar baru, gambar lama akan diganti.
                    Maksimal 2 MB per gambar.
                </p>

                <p id="gambarInfo" class="text-xs text-blue-600 mt-2"></p>

                @error('gambar')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

                @error('gambar.*')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- AUDIO LAMA DAN AUDIO BARU --}}
            @php
                $daftarAudio = [
                    'audio_pertanyaan' => 'Audio Pertanyaan',
                    'audio_pilihan_a' => 'Audio Pilihan A',
                    'audio_pilihan_b' => 'Audio Pilihan B',
                    'audio_pilihan_c' => 'Audio Pilihan C',
                    'audio_pilihan_d' => 'Audio Pilihan D',
                ];
            @endphp

            <div class="mb-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4">
                    Audio Soal dan Pilihan Jawaban
                </h2>

                <div class="space-y-5">
                    @foreach ($daftarAudio as $field => $label)

                        <div class="border border-gray-200 rounded-lg p-4">

                            <label class="block text-sm font-semibold text-gray-700 mb-3">
                                {{ $label }}
                            </label>

                            {{-- Audio Lama --}}
                            <p class="text-xs text-gray-500 mb-2">
                                Audio Saat Ini
                            </p>

                            @if (!empty($quis->$field))
                                @php
                                    $extension = strtolower(
                                        pathinfo($quis->$field, PATHINFO_EXTENSION)
                                    );

                                    $audioType = match ($extension) {
                                        'mp3' => 'audio/mpeg',
                                        'wav' => 'audio/wav',
                                        'ogg' => 'audio/ogg',
                                        default => 'audio/mpeg',
                                    };
                                @endphp

                                <audio controls preload="metadata" class="w-full mb-4">
                                    <source
                                        src="{{ asset('storage/' . $quis->$field) }}"
                                        type="{{ $audioType }}"
                                    >
                                    Browser tidak mendukung pemutar audio.
                                </audio>
                            @else
                                <div class="bg-gray-50 rounded-lg p-3 text-sm text-gray-500 mb-4">
                                    Belum ada audio.
                                </div>
                            @endif

                            {{-- Upload Audio Baru --}}
                            <label class="block text-xs font-semibold text-gray-600 mb-2">
                                Ganti Audio
                            </label>

                            <input
                                type="file"
                                name="{{ $field }}"
                                accept=".mp3,.wav,.ogg,audio/mpeg,audio/wav,audio/ogg"
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-800 bg-white"
                            >

                            <p class="text-xs text-gray-400 mt-2">
                                Kosongkan jika ingin mempertahankan audio lama.
                                Maksimal 10 MB.
                            </p>

                            @error($field)
                                <p class="text-red-500 text-sm mt-1">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                    @endforeach
                </div>
            </div>

            {{-- Tombol --}}
            <div class="flex justify-end gap-3">

                <a
                    href="{{ route('kuis.index') }}"
                    class="px-5 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    class="px-5 py-2.5 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded-lg transition"
                >
                    Simpan Perubahan
                </button>

            </div>

        </form>
    </div>
</div>

{{-- JavaScript --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const kelasSelect = document.getElementById('kelas_id');
    const kategoriSelect = document.getElementById('kategori_id');
    const gambarInput = document.getElementById('gambar');
    const gambarInfo = document.getElementById('gambarInfo');

    const semuaKategori = Array.from(
        kategoriSelect.querySelectorAll('option[data-kelas]')
    );

    // Filter kategori berdasarkan kelas
    function filterKategori() {

        const kelasId = kelasSelect.value;
        const kategoriSekarang = kategoriSelect.value;

        semuaKategori.forEach(function (option) {
            option.hidden = option.dataset.kelas !== kelasId;
        });

        if (!kelasId) {
            kategoriSelect.value = '';
            return;
        }

        const masihValid = semuaKategori.some(function (option) {
            return option.dataset.kelas === kelasId &&
                   option.value === kategoriSekarang;
        });

        if (!masihValid) {
            kategoriSelect.value = '';
        }
    }

    kelasSelect.addEventListener('change', function () {
        kategoriSelect.value = '';
        filterKategori();
    });

    // Informasi gambar baru
    gambarInput.addEventListener('change', function () {

        if (this.files.length === 0) {
            gambarInfo.textContent = '';
        } else {
            gambarInfo.textContent =
                this.files.length +
                ' gambar dipilih. Semua gambar lama akan diganti.';
        }
    });

    filterKategori();

});
</script>

@endsection
