@extends('layouts.admin.app')

@section('title', 'Tambah Materi - BUBA')

@section('content')

<div class="max-w-4xl mx-auto">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">

        <div>

            <h1 class="text-2xl font-bold text-gray-800">
                Tambah Materi
            </h1>

            <p class="text-gray-500 mt-1">
                Isi form untuk menambahkan materi pembelajaran baru.
            </p>

        </div>


        <a
            href="{{ route('materi.index') }}"
            class="px-4 py-2 rounded-lg bg-gray-500 text-white hover:bg-gray-600 transition"
        >
            ← Kembali
        </a>

    </div>


    {{-- Error Validasi --}}
    @if ($errors->any())

        <div class="mb-5 p-4 rounded-lg bg-red-100 border border-red-300 text-red-700">

            <ul class="list-disc list-inside">

                @foreach ($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- Form Materi --}}
    <div class="bg-white rounded-xl shadow-md p-6">

        <form
            action="{{ route('materi.kirim') }}"
            method="POST"
            enctype="multipart/form-data"
            id="formMateri"
        >

            @csrf


            {{-- =====================================================
                 NAMA MATERI
            ====================================================== --}}

            <div class="mb-5">

                <label
                    for="nama_materi"
                    class="block text-sm font-semibold text-gray-700 mb-2"
                >

                    Nama Materi

                    <span class="text-red-500">
                        *
                    </span>

                </label>


                <input
                    type="text"
                    name="nama_materi"
                    id="nama_materi"
                    value="{{ old('nama_materi') }}"
                    maxlength="25"
                    autocomplete="off"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-800 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none"
                    placeholder="Masukkan judul atau nama materi..."
                    required
                >


                <p class="text-xs text-gray-500 mt-2">

                    Hanya boleh menggunakan huruf, angka, dan spasi.

                </p>


                <div
                    id="namaMateriCounter"
                    class="text-xs text-gray-500 text-right mt-1"
                >
                    0/25 karakter
                </div>


                @error('nama_materi')

                    <p class="text-sm text-red-600 mt-2">
                        {{ $message }}
                    </p>

                @enderror

            </div>



            {{-- =====================================================
                 KELAS
            ====================================================== --}}

            <div class="mb-5">

                <label
                    for="kelas_id"
                    class="block text-sm font-semibold text-gray-700 mb-2"
                >

                    Kelas

                    <span class="text-red-500">
                        *
                    </span>

                </label>


                <select
                    name="kelas_id"
                    id="kelas_id"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-800 bg-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none"
                    required
                >

                    <option value="">

                        -- Pilih Kelas --

                    </option>


                    @foreach ($kelas as $item)

                        <option
                            value="{{ $item->id }}"
                            {{ old('kelas_id') == $item->id ? 'selected' : '' }}
                        >

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



            {{-- =====================================================
                 KATEGORI
            ====================================================== --}}

            <div class="mb-5">

                <label
                    for="kategori_id"
                    class="block text-sm font-semibold text-gray-700 mb-2"
                >

                    Kategori Materi

                    <span class="text-red-500">
                        *
                    </span>

                </label>


                <select
                    name="kategori_id"
                    id="kategori_id"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-800 bg-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none"
                    required
                    disabled
                >

                    <option value="">

                        -- Pilih Kelas Terlebih Dahulu --

                    </option>


                    @foreach ($kategori as $item)

                        <option
                            value="{{ $item->id }}"
                            data-kelas="{{ $item->kelas_id }}"
                            {{ old('kategori_id') == $item->id ? 'selected' : '' }}
                        >

                            {{ $item->nama_kategori }}

                        </option>

                    @endforeach

                </select>


                @error('kategori_id')

                    <p class="text-sm text-red-600 mt-2">
                        {{ $message }}
                    </p>

                @enderror


                <p class="text-xs text-gray-500 mt-2">

                    Kategori akan menyesuaikan dengan kelas yang dipilih.

                </p>

            </div>



            {{-- =====================================================
                 GAMBAR
            ====================================================== --}}

            <div class="mb-5">

                <label
                    for="gambar"
                    class="block text-sm font-semibold text-gray-700 mb-2"
                >

                    Gambar Pendukung

                    <span class="font-normal text-gray-500">
                        (Opsional)
                    </span>

                </label>


                <input
                    type="file"
                    name="gambar"
                    id="gambar"
                    accept=".jpg,.jpeg,.png,.webp"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-700 bg-white"
                >


                <p class="text-xs text-gray-500 mt-2">

                    Format: JPG, JPEG, PNG, WEBP. Maksimal 2 MB.

                </p>


                @error('gambar')

                    <p class="text-sm text-red-600 mt-2">
                        {{ $message }}
                    </p>

                @enderror

            </div>



            {{-- =====================================================
                 AUDIO
            ====================================================== --}}

            <div class="mb-5">

                <label
                    for="audio"
                    class="block text-sm font-semibold text-gray-700 mb-2"
                >

                    Audio

                    <span class="font-normal text-gray-500">
                        (Opsional)
                    </span>

                </label>


                <input
                    type="file"
                    name="audio"
                    id="audio"
                    accept=".mp3,.aac,.wav,.ogg"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-700 bg-white"
                >


                <p class="text-xs text-gray-500 mt-2">

                    Format: MP3, AAC, WAV, OGG.

                </p>


                @error('audio')

                    <p class="text-sm text-red-600 mt-2">
                        {{ $message }}
                    </p>

                @enderror

            </div>



            {{-- =====================================================
                 ISI MATERI
            ====================================================== --}}

            <div class="mb-6">

                <label
                    for="isi_materi"
                    class="block text-sm font-semibold text-gray-700 mb-2"
                >

                    Isi Materi

                    <span class="text-red-500">
                        *
                    </span>

                </label>


                <textarea
                    name="isi_materi"
                    id="isi_materi"
                    rows="8"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-800 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none"
                    placeholder="Tuliskan penjelasan materi lengkap di sini..."
                    required
                >{{ old('isi_materi') }}</textarea>


                @error('isi_materi')

                    <p class="text-sm text-red-600 mt-2">
                        {{ $message }}
                    </p>

                @enderror

            </div>



            {{-- =====================================================
                 TOMBOL
            ====================================================== --}}

            <div class="flex justify-end gap-3">

                <a
                    href="{{ route('materi.index') }}"
                    class="px-5 py-2.5 rounded-lg bg-gray-500 text-white hover:bg-gray-600 transition"
                >

                    Batal

                </a>


                <button
                    type="submit"
                    class="px-5 py-2.5 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition"
                >

                    ✓ Simpan Materi

                </button>

            </div>


        </form>

    </div>

</div>



{{-- =====================================================
     JAVASCRIPT
====================================================== --}}

<script>

document.addEventListener('DOMContentLoaded', function () {


    const form =
        document.getElementById('formMateri');


    const namaMateri =
        document.getElementById('nama_materi');


    const counter =
        document.getElementById('namaMateriCounter');


    const kelasSelect =
        document.getElementById('kelas_id');


    const kategoriSelect =
        document.getElementById('kategori_id');


    const semuaKategori =
        Array.from(
            kategoriSelect.querySelectorAll(
                'option[data-kelas]'
            )
        );



    /* =====================================================
       NAMA MATERI
    ====================================================== */

    function validasiNamaMateri() {

        namaMateri.value =
            namaMateri.value.replace(
                /[^A-Za-z0-9 ]/g,
                ''
            );


        if (
            namaMateri.value.length > 25
        ) {

            namaMateri.value =
                namaMateri.value.substring(
                    0,
                    25
                );

        }


        counter.textContent =
            namaMateri.value.length +
            '/25 karakter';


        if (
            namaMateri.value.length >= 25
        ) {

            counter.classList.remove(
                'text-gray-500'
            );

            counter.classList.add(
                'text-red-600',
                'font-semibold'
            );

        } else {

            counter.classList.remove(
                'text-red-600',
                'font-semibold'
            );

            counter.classList.add(
                'text-gray-500'
            );

        }

    }


    namaMateri.addEventListener(
        'input',
        validasiNamaMateri
    );


    validasiNamaMateri();



    /* =====================================================
       FILTER KATEGORI BERDASARKAN KELAS
    ====================================================== */

    function filterKategori() {


        const kelasId =
            kelasSelect.value;


        if (!kelasId) {

            kategoriSelect.disabled = true;

            kategoriSelect.value = '';

            kategoriSelect.querySelector(
                'option[value=""]'
            ).textContent =
                '-- Pilih Kelas Terlebih Dahulu --';


            semuaKategori.forEach(
                function (option) {

                    option.hidden = true;

                }
            );

            return;
        }


        kategoriSelect.disabled = false;


        kategoriSelect.querySelector(
            'option[value=""]'
        ).textContent =
            '-- Pilih Kategori --';


        semuaKategori.forEach(
            function (option) {


                if (
                    option.dataset.kelas ===
                    kelasId
                ) {

                    option.hidden = false;

                } else {

                    option.hidden = true;

                }

            }
        );


        const kategoriTerpilih =
            kategoriSelect.value;


        const masihValid =
            semuaKategori.some(
                function (option) {

                    return (
                        option.dataset.kelas === kelasId &&
                        option.value === kategoriTerpilih
                    );

                }
            );


        if (!masihValid) {

            kategoriSelect.value = '';

        }

    }


    kelasSelect.addEventListener(
        'change',
        function () {

            kategoriSelect.value = '';

            filterKategori();

        }
    );


    filterKategori();



    /* =====================================================
       VALIDASI SUBMIT
    ====================================================== */

    form.addEventListener(
        'submit',
        function (event) {


            const nama =
                namaMateri.value.trim();


            const regexNama =
                /^[A-Za-z0-9 ]+$/;


            if (
                nama.length === 0 ||
                nama.length > 25 ||
                !regexNama.test(nama)
            ) {

                event.preventDefault();

                namaMateri.focus();

                alert(
                    'Nama materi wajib diisi, maksimal 25 karakter, dan hanya boleh menggunakan huruf, angka, serta spasi.'
                );

                return;

            }


            if (
                kelasSelect.value === ''
            ) {

                event.preventDefault();

                kelasSelect.focus();

                alert(
                    'Kelas harus diisi.'
                );

                return;

            }


            if (
                kategoriSelect.value === ''
            ) {

                event.preventDefault();

                kategoriSelect.focus();

                alert(
                    'Kategori harus diisi.'
                );

                return;

            }

        }
    );

});

</script>

@endsection