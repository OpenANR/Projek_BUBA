@extends('layouts.admin.app')

@section('title', 'Kelola Materi - BUBA')

@section('content')

<div class="max-w-6xl mx-auto">

    {{-- HEADER --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                📚 Tabel Materi
            </h1>

            <p class="text-gray-500 mt-1">
                Kelola data materi pembelajaran BUBA.
            </p>
        </div>

        <a href="{{ route('materi.tambah') }}"
           class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition">
            + Tambah Materi
        </a>
    </div>


    {{-- PESAN SUKSES --}}
    @if (session('success'))
        <div class="mb-5 p-4 rounded-lg bg-green-100 border border-green-300 text-green-700">
            {{ session('success') }}
        </div>
    @endif


    {{-- PENCARIAN CUSTOM --}}
    <div class="bg-white rounded-xl shadow-md p-5 mb-6">

        <div class="flex flex-col md:flex-row gap-3">

            {{-- PILIH JENIS PENCARIAN --}}
            <div class="w-full md:w-64">
                <select
                    id="searchField"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">

                    <option value="all">
                        Semua
                    </option>

                    <option value="kode">
                        Kode
                    </option>

                    <option value="judul">
                        Judul
                    </option>

                    <option value="kelas">
                        Kelas
                    </option>

                    <option value="kategori">
                        Kategori
                    </option>

                </select>
            </div>


            {{-- INPUT PENCARIAN --}}
            <div class="flex-1">
                <input
                    type="text"
                    id="searchMateri"
                    placeholder="Ketik yang ingin dicari..."
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>


            {{-- TOMBOL RESET --}}
            <button
                type="button"
                id="resetSearch"
                class="px-5 py-2.5 rounded-lg bg-gray-500 text-white hover:bg-gray-600 transition">

                Reset

            </button>

        </div>

    </div>


    {{-- TABEL --}}
    <div class="bg-white rounded-xl shadow-md p-6">

        <div class="overflow-x-auto">

            <table
                id="materiTable"
                class="display w-full">

                <thead>
                    <tr>

                        <th>No</th>

                        <th>Kode</th>

                        <th>Judul</th>

                        <th>Kelas</th>

                        <th>Kategori</th>

                        <th>Gambar</th>

                        <th>Aksi</th>

                    </tr>
                </thead>


                <tbody>

                    @forelse ($materi as $item)

                        <tr>

                            {{-- NO --}}
                            <td>
                                {{ $loop->iteration }}
                            </td>


                            {{-- KODE --}}
                            <td>
                                {{ $item->kode_materi }}
                            </td>


                            {{-- JUDUL --}}
                            <td>
                                {{ $item->nama_materi }}
                            </td>


                            {{-- KELAS --}}
                            <td>

                                @if ($item->kelas)

                                    <span class="inline-block px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-sm">
                                        {{ $item->kelas->nama_kelas }}
                                    </span>

                                @else

                                    <span class="text-gray-400">
                                        Tidak ada Kelas
                                    </span>

                                @endif

                            </td>


                            {{-- KATEGORI --}}
                            <td>

                                @if ($item->kategori)

                                    <span class="inline-block px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm">
                                        {{ $item->kategori->nama_kategori }}
                                    </span>

                                @else

                                    <span class="text-gray-400">
                                        Tidak ada Kategori
                                    </span>

                                @endif

                            </td>


                            {{-- GAMBAR --}}
                            <td>

                                @if ($item->gambar)

                                    <img
                                        src="{{ asset('storage/' . $item->gambar) }}"
                                        alt="{{ $item->nama_materi }}"
                                        class="w-16 h-16 object-cover rounded-lg">

                                @else

                                    <span class="text-gray-400">
                                        Tidak ada gambar
                                    </span>

                                @endif

                            </td>

                              {{-- AKSI --}}
                                <td class="px-5 py-5 align-top">

                                    <div class="flex items-center justify-center gap-2">


                                        {{-- DETAIL --}}
                                        <a
                                            href="{{ route('materi.detail', $item) }}"
                                            title="Detail"
                                            style="background-color: #eff6ff !important; color: #2563eb !important;"
                                            class="w-9 h-9 flex items-center justify-center rounded-lg border border-blue-200 transition hover:bg-blue-100"
                                        >

                                            <i
                                                class="fa-solid fa-eye text-xs"
                                                style="color: #2563eb !important;"
                                            ></i>

                                        </a>


                                        {{-- EDIT --}}
                                        <a
                                            href="{{ route('materi.edit', $item) }}"
                                            title="Edit"
                                            style="background-color: #fffbeb !important; color: #d97706 !important;"
                                            class="w-9 h-9 flex items-center justify-center rounded-lg border border-amber-200 transition hover:bg-amber-100"
                                        >

                                            <i
                                                class="fa-solid fa-pen text-xs"
                                                style="color: #d97706 !important;"
                                            ></i>

                                        </a>


                                        {{-- HAPUS --}}
                                        <form
                                            action="{{ route('materi.hapus', $item) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus soal ini?')"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                title="Hapus"
                                                style="background-color: #fef2f2 !important; color: #dc2626 !important;"
                                                class="w-9 h-9 flex items-center justify-center rounded-lg border border-red-200 transition hover:bg-red-100"
                                            >

                                                <i
                                                    class="fa-solid fa-trash text-xs"
                                                    style="color: #dc2626 !important;"
                                                ></i>

                                            </button>

                                        </form>

                                    </div>

                                </td>
                        </tr>

                    @empty

                        <tr>

                            <td colspan="7" class="text-center py-8 text-gray-500">

                                Belum ada data materi.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>


{{-- DATATABLES --}}
<link
    rel="stylesheet"
    href="https://cdn.datatables.net/2.3.2/css/dataTables.dataTables.min.css">


<script src="https://cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>


<script>

document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | DATATABLES
    |--------------------------------------------------------------------------
    */

    const table = new DataTable('#materiTable', {

        pageLength: 10,


        /*
        |--------------------------------------------------------------------------
        | HAPUS SEARCH BAWAAN DATATABLES
        |--------------------------------------------------------------------------
        |
        | Tampilkan 10 data tetap ada.
        | Yang dihilangkan hanya:
        |
        | Cari materi: [____________]
        |
        */

        layout: {
            topStart: 'pageLength',
            topEnd: null
        },


        /*
        |--------------------------------------------------------------------------
        | KOLOM
        |--------------------------------------------------------------------------
        */

        columnDefs: [

            {
                orderable: false,
                searchable: false,
                targets: [5, 6]
            }

        ],


        /*
        |--------------------------------------------------------------------------
        | BAHASA
        |--------------------------------------------------------------------------
        */

        language: {

            lengthMenu: "Tampilkan _MENU_ data",

            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",

            infoEmpty: "Tidak ada data materi",

            infoFiltered: "(difilter dari _MAX_ total data)",

            paginate: {

                next: "Berikutnya",

                previous: "Sebelumnya"

            },

            zeroRecords: "Data tidak ditemukan",

            emptyTable: "Belum ada data materi."

        }

    });


    /*
    |--------------------------------------------------------------------------
    | PENCARIAN CUSTOM
    |--------------------------------------------------------------------------
    */

    const searchField = document.getElementById('searchField');

    const searchMateri = document.getElementById('searchMateri');

    const resetSearch = document.getElementById('resetSearch');


    function doSearch() {

        const field = searchField.value;

        const keyword = searchMateri.value;


        /*
        |--------------------------------------------------------------------------
        | BERSIHKAN PENCARIAN KOLOM
        |--------------------------------------------------------------------------
        */

        table.columns().search('');


        /*
        |--------------------------------------------------------------------------
        | SEMUA
        |--------------------------------------------------------------------------
        */

        if (field === 'all') {

            table
                .search(keyword)
                .draw();

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | KODE
        |--------------------------------------------------------------------------
        */

        if (field === 'kode') {

            table
                .column(1)
                .search(keyword)
                .draw();

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | JUDUL
        |--------------------------------------------------------------------------
        */

        if (field === 'judul') {

            table
                .column(2)
                .search(keyword)
                .draw();

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | KELAS
        |--------------------------------------------------------------------------
        */

        if (field === 'kelas') {

            table
                .column(3)
                .search(keyword)
                .draw();

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | KATEGORI
        |--------------------------------------------------------------------------
        */

        if (field === 'kategori') {

            table
                .column(4)
                .search(keyword)
                .draw();

            return;

        }

    }


    /*
    |--------------------------------------------------------------------------
    | KETIKA MENGETIK
    |--------------------------------------------------------------------------
    */

    searchMateri.addEventListener('input', function () {

        doSearch();

    });


    /*
    |--------------------------------------------------------------------------
    | KETIKA DROPDOWN BERUBAH
    |--------------------------------------------------------------------------
    */

    searchField.addEventListener('change', function () {

        doSearch();

    });


    /*
    |--------------------------------------------------------------------------
    | RESET
    |--------------------------------------------------------------------------
    */

    resetSearch.addEventListener('click', function () {

        searchField.value = 'all';

        searchMateri.value = '';


        table
            .search('')
            .columns()
            .search('')
            .draw();

    });

});

</script>

@endsection