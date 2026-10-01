

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Tambah Materi - BUBA</title>

    <link rel="stylesheet" href="{{ asset('css/materi.css') }}">

    <style>

        /* ==============================
           PESAN VALIDASI
        ============================== */

        .field-error {
            color: #ef3340;
            font-size: 13px;
            margin-top: 7px;
            display: block;
        }

        .field-hint {
            color: #718096;
            font-size: 13px;
            margin-top: 7px;
            display: block;
        }

        .character-counter {
            text-align: right;
            color: #718096;
            font-size: 12px;
            margin-top: 5px;
        }

        .character-counter.error {
            color: #ef3340;
            font-weight: bold;
        }

        .form-control.input-error,
        .form-select.input-error,
        .form-textarea.input-error {
            border-color: #ef3340 !important;
        }

        /*
         * Kategori yang tidak sesuai kelas
         * akan disembunyikan oleh JavaScript.
         */
        #kategori_id option[data-kelas] {
            padding: 8px;
        }

    </style>

</head>


<body>


    <!-- ==========================================
         NAVIGATION BAR
    =========================================== -->

    <nav class="navbar">

        <div class="navbar-container">


            <a
                href="{{ route('materi.index') }}"
                class="navbar-brand"
            >

                BUBA <span>&bull; Materi</span>

            </a>


            <ul class="navbar-nav">

                <li>

                    <a href="{{ route('materi.index') }}">

                        Data Materi

                    </a>

                </li>


                <li>

                    <a
                        href="{{ route('materi.tambah') }}"
                        class="active"
                    >

                        + Tambah Materi

                    </a>

                </li>

            </ul>


        </div>

    </nav>



    <!-- ==========================================
         MAIN CONTENT
    =========================================== -->

    <div class="container">


        <!-- ======================================
             PAGE HEADER
        ======================================= -->

        <div class="page-header">

            <div>

                <h1 class="page-title">

                    📝 Tambah Materi Baru

                </h1>


                <p class="page-subtitle">

                    Isi formulir di bawah ini untuk menambahkan
                    materi pembelajaran baru ke sistem

                </p>

            </div>


            <div>

                <a
                    href="{{ route('materi.index') }}"
                    class="btn btn-secondary"
                >

                    &larr; Kembali ke Daftar

                </a>

            </div>

        </div>



        <!-- ======================================
             VALIDATION ERRORS
        ======================================= -->

        @if ($errors->any())

            <div class="alert alert-danger">

                <div>

                    <strong>Terjadi Kesalahan:</strong>

                    <ul>

                        @foreach ($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            </div>

        @endif



        <!-- ======================================
             FORM CARD
        ======================================= -->

        <div class="card">


            <div class="card-header">

                <h2 class="card-title">

                    Formulir Materi Pembelajaran

                </h2>

            </div>



            <div class="card-body">


                <form
                    action="{{ route('materi.kirim') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    class="crud-form"
                    id="formMateri"
                >

                    @csrf



                    <!-- ==================================
                         NAMA MATERI
                    =================================== -->

                    <div class="form-group">


                        <label
                            for="nama_materi"
                            class="form-label"
                        >

                            Nama Materi

                            <span class="required">
                                *
                            </span>

                        </label>


                        <input
                            type="text"
                            name="nama_materi"
                            id="nama_materi"
                            class="form-control @error('nama_materi') input-error @enderror"
                            placeholder="Masukkan judul atau nama materi..."
                            value="{{ old('nama_materi') }}"
                            maxlength="25"
                            autocomplete="off"
                            required
                        >


                        <span class="field-hint">

                            Hanya boleh menggunakan huruf, angka, dan spasi.

                        </span>


                        <div
                            id="namaMateriCounter"
                            class="character-counter"
                        >

                            0/25 karakter

                        </div>


                        @error('nama_materi')

                            <span class="field-error">

                                {{ $message }}

                            </span>

                        @enderror


                    </div>



                    <!-- ==================================
                         KELAS
                    =================================== -->

                    <div class="form-group">


                        <label
                            for="kelas_id"
                            class="form-label"
                        >

                            Kelas

                            <span class="required">
                                *
                            </span>

                        </label>


                        <select
                            name="kelas_id"
                            id="kelas_id"
                            class="form-select @error('kelas_id') input-error @enderror"
                            required
                        >

                            <option
                                value=""
                                disabled
                                {{ old('kelas_id') ? '' : 'selected' }}
                            >

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

                            <span class="field-error">

                                {{ $message }}

                            </span>

                        @enderror


                    </div>



                    <!-- ==================================
                         KATEGORI
                    =================================== -->

                    <div class="form-group">


                        <label
                            for="kategori_id"
                            class="form-label"
                        >

                            Kategori Materi

                            <span class="required">
                                *
                            </span>

                        </label>


                        <select
                            name="kategori_id"
                            id="kategori_id"
                            class="form-select @error('kategori_id') input-error @enderror"
                            required
                            disabled
                        >

                            <option
                                value=""
                                selected
                            >

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

                            <span class="field-error">

                                {{ $message }}

                            </span>

                        @enderror


                        <span class="field-hint">

                            Kategori akan menyesuaikan dengan kelas yang dipilih.

                        </span>


                    </div>



                    <!-- ==================================
                         GAMBAR
                    =================================== -->

                    <div class="form-group">


                        <label
                            for="gambar"
                            class="form-label"
                        >

                            Gambar Pendukung (Opsional)

                        </label>


                        <input
                            type="file"
                            name="gambar"
                            id="gambar"
                            class="form-control form-file-input"
                            accept="image/png, image/jpeg, image/jpg"
                        >


                        <span class="form-hint">

                            Format yang didukung: JPG, JPEG, PNG (Maks. 2MB)

                        </span>


                        @error('gambar')

                            <span class="field-error">

                                {{ $message }}

                            </span>

                        @enderror


                    </div>



                    <!-- ==================================
                         AUDIO
                    =================================== -->

                    <div class="form-group">


                        <label
                            for="audio"
                            class="form-label"
                        >

                            Audio (Opsional)

                        </label>


                        <input
                            type="file"
                            name="audio"
                            id="audio"
                            class="form-control form-file-input"
                            accept=".mp3,.aac,.wav,.ogg"
                        >


                        <span class="form-hint">

                            Format yang didukung: MP3, AAC, WAV, OGG

                        </span>


                        @error('audio')

                            <span class="field-error">

                                {{ $message }}

                            </span>

                        @enderror


                    </div>



                    <!-- ==================================
                         ISI MATERI
                    =================================== -->

                    <div class="form-group">


                        <label
                            for="isi_materi"
                            class="form-label"
                        >

                            Isi Materi

                            <span class="required">
                                *
                            </span>

                        </label>


                        <textarea
                            name="isi_materi"
                            id="isi_materi"
                            class="form-textarea @error('isi_materi') input-error @enderror"
                            rows="8"
                            placeholder="Tuliskan penjelasan materi lengkap di sini..."
                            required
                        >{{ old('isi_materi') }}</textarea>


                        @error('isi_materi')

                            <span class="field-error">

                                {{ $message }}

                            </span>

                        @enderror


                    </div>



                    <!-- ==================================
                         BUTTONS
                    =================================== -->

                    <div class="form-actions">


                        <button
                            type="submit"
                            class="btn btn-primary"
                        >

                            💾 Simpan Materi

                        </button>


                        <a
                            href="{{ route('materi.index') }}"
                            class="btn btn-secondary"
                        >

                            Batal

                        </a>


                    </div>


                </form>


            </div>


        </div>


    </div>



    <!-- ==========================================
         JAVASCRIPT
    =========================================== -->

    <script>

        document.addEventListener('DOMContentLoaded', function () {


            /*
             * ==========================================
             * AMBIL ELEMENT
             * ==========================================
             */

            const form =
                document.getElementById('formMateri');

            const namaMateri =
                document.getElementById('nama_materi');

            const counter =
                document.getElementById('namaMateriCounter');

            const kategori =
                document.getElementById('kategori_id');

            const kelas =
                document.getElementById('kelas_id');



            /*
             * ==========================================
             * VALIDASI NAMA MATERI
             * ==========================================
             */

            function validasiNamaMateri() {


                /*
                 * Hapus karakter selain:
                 * - huruf
                 * - angka
                 * - spasi
                 */

                namaMateri.value =
                    namaMateri.value.replace(
                        /[^A-Za-z0-9 ]/g,
                        ''
                    );


                /*
                 * Maksimal 25 karakter
                 */

                if (
                    namaMateri.value.length > 25
                ) {

                    namaMateri.value =
                        namaMateri.value.substring(
                            0,
                            25
                        );

                }


                /*
                 * Update counter
                 */

                counter.textContent =
                    namaMateri.value.length +
                    '/25 karakter';


                /*
                 * Jika mencapai batas
                 */

                if (
                    namaMateri.value.length >= 25
                ) {

                    counter.classList.add('error');

                } else {

                    counter.classList.remove('error');

                }

            }


            /*
             * Jalankan ketika mengetik
             */

            namaMateri.addEventListener(
                'input',
                validasiNamaMateri
            );


            /*
             * Jalankan saat halaman dibuka
             */

            validasiNamaMateri();



            /*
             * ==========================================
             * SIMPAN SEMUA DATA KATEGORI
             * ==========================================
             */

            const semuaKategori =
                Array.from(
                    kategori.querySelectorAll(
                        'option[data-kelas]'
                    )
                );



            /*
             * ==========================================
             * FILTER KATEGORI BERDASARKAN KELAS
             * ==========================================
             */

            function filterKategori() {


                const kelasId =
                    kelas.value;


                /*
                 * Reset pilihan kategori
                 */

                kategori.value = '';



                /*
                 * ==================================
                 * BELUM MEMILIH KELAS
                 * ==================================
                 */

                if (!kelasId) {


                    kategori.disabled = true;


                    kategori.options[0].textContent =
                        '-- Pilih Kelas Terlebih Dahulu --';


                    semuaKategori.forEach(
                        function (option) {

                            option.hidden = true;

                        }
                    );


                    return;

                }



                /*
                 * ==================================
                 * SUDAH MEMILIH KELAS
                 * ==================================
                 */

                kategori.disabled = false;


                kategori.options[0].textContent =
                    '-- Pilih Kategori --';



                /*
                 * Tampilkan hanya kategori
                 * yang mempunyai kelas_id
                 * sama dengan kelas yang dipilih
                 */

                semuaKategori.forEach(
                    function (option) {


                        if (
                            option.dataset.kelas === kelasId
                        ) {

                            option.hidden = false;

                        } else {

                            option.hidden = true;

                        }

                    }
                );

            }



            /*
             * ==========================================
             * JALANKAN FILTER KETIKA KELAS DIPILIH
             * ==========================================
             */

            kelas.addEventListener(
                'change',
                filterKategori
            );



            /*
             * ==========================================
             * JALANKAN SAAT HALAMAN DIBUKA
             * ==========================================
             */

            filterKategori();



            /*
             * ==========================================
             * VALIDASI FORM SEBELUM SUBMIT
             * ==========================================
             */

            form.addEventListener(
                'submit',
                function (event) {


                    /*
                     * ==============================
                     * VALIDASI NAMA
                     * ==============================
                     */

                    const nama =
                        namaMateri.value;


                    const regexNama =
                        /^[A-Za-z0-9 ]+$/;


                    if (
                        nama.length === 0 ||
                        nama.length > 25 ||
                        !regexNama.test(nama)
                    ) {


                        namaMateri.focus();


                        alert(
                            'Nama materi wajib diisi, maksimal 25 karakter, dan hanya boleh menggunakan huruf, angka, serta spasi.'
                        );


                        event.preventDefault();

                        return;

                    }



                    /*
                     * ==============================
                     * VALIDASI KELAS
                     * ==============================
                     */

                    if (
                        kelas.value === ''
                    ) {


                        kelas.focus();


                        alert(
                            'Kelas harus diisi.'
                        );


                        event.preventDefault();

                        return;

                    }



                    /*
                     * ==============================
                     * VALIDASI KATEGORI
                     * ==============================
                     */

                    if (
                        kategori.value === ''
                    ) {


                        kategori.focus();


                        alert(
                            'Kategori harus diisi.'
                        );


                        event.preventDefault();

                        return;

                    }

                }
            );

        });

    </script>


</body>

</html>
