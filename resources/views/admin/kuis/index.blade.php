@extends('layouts.admin.app')

@section('title', 'Kelola Kuis - BUBA')

@section('content')

<<<<<<< HEAD
<div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-6">
=======
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
>>>>>>> 62312ce (Perbaikan kategori)

    {{-- ================= HEADER ================= --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-7">

        <div class="flex items-center gap-3">

            <div class="w-11 h-11 flex items-center justify-center rounded-xl bg-blue-100 border border-blue-200">
                <span class="text-xl">📝</span>
            </div>

            <div>
                <h1 class="text-2xl font-bold !text-gray-900">
                    Kelola Kuis
                </h1>

                <p class="text-sm !text-gray-500 mt-0.5">
                    Kelola soal berdasarkan kelas dan kategori pembelajaran.
                </p>
            </div>

        </div>

<<<<<<< HEAD

        {{-- TOMBOL TAMBAH SOAL --}}
        <a href="{{ route('kuis.tambah') }}"
           style="background-color: #2563eb !important; color: #ffffff !important;"
           class="inline-flex items-center justify-center gap-2
                  font-semibold text-sm px-5 py-3 rounded-xl
                  shadow-sm hover:shadow-md transition duration-200">
=======
        {{-- TOMBOL TAMBAH SOAL --}}
        <a href="{{ route('kuis.tambah') }}"
           style="background-color: #2563eb !important; color: #ffffff !important;"
           class="inline-flex items-center justify-center gap-2 font-semibold text-sm px-5 py-3 rounded-xl shadow-sm hover:shadow-md transition duration-200">
>>>>>>> 62312ce (Perbaikan kategori)

            <span style="color: #ffffff !important;" class="text-lg leading-none">
                +
            </span>

            <span style="color: #ffffff !important;">
                Tambah Soal
            </span>

        </a>

    </div>


    {{-- ================= ALERT SUCCESS ================= --}}
    @if (session('success'))

<<<<<<< HEAD
        <div class="mb-6 flex items-start gap-3 px-4 py-3.5
                    rounded-xl bg-green-50 border border-green-200">

            <div class="w-8 h-8 flex items-center justify-center
                        rounded-lg bg-green-100 flex-shrink-0">

                <span class="text-green-700 font-bold">
                    ✓
                </span>

=======
        <div class="mb-6 flex items-start gap-3 px-4 py-3.5 rounded-xl bg-green-50 border border-green-200">

            <div class="w-8 h-8 flex items-center justify-center rounded-lg bg-green-100 flex-shrink-0">
                <span class="text-green-700 font-bold">
                    ✓
                </span>
>>>>>>> 62312ce (Perbaikan kategori)
            </div>

            <div>
                <p class="font-semibold text-sm text-green-800">
                    Berhasil
                </p>

                <p class="text-xs text-green-700 mt-0.5">
                    {{ session('success') }}
                </p>
            </div>

        </div>

    @endif


    {{-- ================= ALERT ERROR ================= --}}
    @if ($errors->any())

<<<<<<< HEAD
        <div class="mb-6 px-4 py-3.5
                    rounded-xl bg-red-50 border border-red-200">

            <div class="flex items-start gap-3">

                <div class="w-8 h-8 flex items-center justify-center
                            rounded-lg bg-red-100 flex-shrink-0">

                    <span class="text-red-700 font-bold">
                        !
                    </span>

=======
        <div class="mb-6 px-4 py-3.5 rounded-xl bg-red-50 border border-red-200">

            <div class="flex items-start gap-3">

                <div class="w-8 h-8 flex items-center justify-center rounded-lg bg-red-100 flex-shrink-0">
                    <span class="text-red-700 font-bold">
                        !
                    </span>
>>>>>>> 62312ce (Perbaikan kategori)
                </div>

                <div>

                    <p class="font-semibold text-sm text-red-800">
                        Terdapat kesalahan
                    </p>

                    <ul class="mt-1.5 space-y-1 text-xs text-red-700">

                        @foreach ($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach

                    </ul>

                </div>

            </div>

        </div>

    @endif


    {{-- ================= CARD DAFTAR SOAL ================= --}}
    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">

        {{-- CARD HEADER --}}
        <div class="px-6 py-5 border-b border-gray-200">

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">

                <div>

                    <h2 class="text-lg font-bold !text-gray-900">
                        Daftar Soal Kuis
                    </h2>

                    <p class="text-sm !text-gray-500 mt-1">
                        Soal yang telah ditambahkan akan ditampilkan di sini.
                    </p>

                </div>

<<<<<<< HEAD

                {{-- TOTAL SOAL --}}
                <div class="inline-flex items-center gap-2 self-start sm:self-auto
                            px-3 py-2 rounded-lg
                            bg-blue-50 border border-blue-100">
=======
                {{-- TOTAL SOAL --}}
                <div class="inline-flex items-center gap-2 self-start sm:self-auto px-3 py-2 rounded-lg bg-blue-50 border border-blue-100">
>>>>>>> 62312ce (Perbaikan kategori)

                    <span class="text-xs !text-blue-600">
                        Total soal
                    </span>

                    <span class="text-sm font-bold !text-blue-700">
                        {{ $quis->count() }}
                    </span>

                </div>

            </div>

        </div>


        {{-- ================= ADA DATA ================= --}}
        @if ($quis->count() > 0)

            <div class="overflow-x-auto">

<<<<<<< HEAD
                <table id="quisTable" class="w-full">
=======
                <table id="quisTable" class="min-w-full">
>>>>>>> 62312ce (Perbaikan kategori)

                    <thead class="bg-gray-50 border-b border-gray-200">

                        <tr>

<<<<<<< HEAD
                            {{-- NO --}}
                            <th class="px-4 py-4 w-14 text-center
                                       text-[11px] font-bold !text-gray-600
                                       uppercase tracking-wide">
                                No
                            </th>


                            {{-- KODE KUIS --}}
                            <th class="px-4 py-4 min-w-[120px]
                                       text-center text-[11px] font-bold
                                       !text-gray-600 uppercase tracking-wide">
                                Kode Kuis
                            </th>


                            {{-- PERTANYAAN --}}
                            <th class="px-5 py-4 min-w-[390px]
                                       text-left text-[11px] font-bold
                                       !text-gray-600 uppercase tracking-wide">
                                Pertanyaan
                            </th>


                            {{-- KELAS --}}
                            <th class="px-4 py-4 min-w-[120px]
                                       text-center text-[11px] font-bold
                                       !text-gray-600 uppercase tracking-wide">
                                Kelas
                            </th>


                            {{-- KATEGORI --}}
                            <th class="px-4 py-4 min-w-[150px]
                                       text-center text-[11px] font-bold
                                       !text-gray-600 uppercase tracking-wide">
                                Kategori
                            </th>


                            {{-- GAMBAR --}}
                            <th class="px-4 py-4 w-[100px]
                                       text-center text-[11px] font-bold
                                       !text-gray-600 uppercase tracking-wide">
                                Gambar
                            </th>


                            {{-- JAWABAN --}}
                            <th class="px-4 py-4 w-[100px]
                                       text-center text-[11px] font-bold
                                       !text-gray-600 uppercase tracking-wide">
                                Jawaban
                            </th>


                            {{-- AKSI --}}
                            <th class="px-4 py-4 w-[150px]
                                       text-center text-[11px] font-bold
                                       !text-gray-600 uppercase tracking-wide">
=======
                            <th class="px-5 py-4 text-left text-[11px] font-bold !text-gray-600 uppercase tracking-wide">
                                No
                            </th>

                            <th class="px-5 py-4 text-left text-[11px] font-bold !text-gray-600 uppercase tracking-wide">
                                Pertanyaan
                            </th>

                            <th class="px-5 py-4 text-left text-[11px] font-bold !text-gray-600 uppercase tracking-wide">
                                Kelas
                            </th>

                            <th class="px-5 py-4 text-left text-[11px] font-bold !text-gray-600 uppercase tracking-wide">
                                Kategori
                            </th>

                            <th class="px-5 py-4 text-left text-[11px] font-bold !text-gray-600 uppercase tracking-wide">
                                Gambar
                            </th>

                            <th class="px-5 py-4 text-left text-[11px] font-bold !text-gray-600 uppercase tracking-wide">
                                Jawaban
                            </th>

                            <th class="px-5 py-4 text-center text-[11px] font-bold !text-gray-600 uppercase tracking-wide">
>>>>>>> 62312ce (Perbaikan kategori)
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-gray-100">

                        @foreach ($quis as $item)

<<<<<<< HEAD
                            <tr class="hover:bg-blue-50/30 transition duration-150">

                                {{-- NO --}}
                                <td class="px-4 py-5 align-top text-center">

                                    <span class="inline-flex items-center justify-center
                                                 w-8 h-8 rounded-lg
                                                 bg-gray-100
                                                 text-sm font-semibold
                                                 !text-gray-700">

                                        {{ $loop->iteration }}

                                    </span>

                                </td>


                                {{-- KODE KUIS --}}
                                <td class="px-4 py-5 align-top text-center">

                                    <span class="inline-flex items-center justify-center
                                                 px-3 py-1.5 rounded-lg
                                                 bg-purple-50 border border-purple-200
                                                 text-purple-700 text-xs font-bold
                                                 whitespace-nowrap">

                                        {{ $item->kode_kuis }}

=======
                            <tr class="hover:bg-blue-50/40 transition duration-150">

                                {{-- NO --}}
                                <td class="px-5 py-5 align-top">

                                    <span class="text-sm font-semibold !text-gray-700">
                                        {{ $loop->iteration }}
>>>>>>> 62312ce (Perbaikan kategori)
                                    </span>

                                </td>


                                {{-- PERTANYAAN --}}
                                <td class="px-5 py-5 align-top">

<<<<<<< HEAD
                                    <div class="max-w-[450px]">

                                        <p class="text-sm font-semibold
                                                  !text-gray-900 leading-5">

                                            {{ $item->pertanyaan }}

                                        </p>


                                        <div class="mt-3 grid grid-cols-1
                                                    sm:grid-cols-2
                                                    gap-x-6 gap-y-2">

                                            <div class="flex gap-2 text-xs !text-gray-600">

=======
                                    <div class="min-w-[280px] max-w-md">

                                        <p class="text-sm font-semibold !text-gray-900 leading-5">
                                            {{ $item->pertanyaan }}
                                        </p>

                                        <div class="mt-3 space-y-1.5">

                                            <div class="flex gap-2 text-xs !text-gray-600">
>>>>>>> 62312ce (Perbaikan kategori)
                                                <span class="font-bold !text-blue-600 w-4">
                                                    A.
                                                </span>

                                                <span>
                                                    {{ $item->pilihan_a }}
                                                </span>
<<<<<<< HEAD

                                            </div>


                                            <div class="flex gap-2 text-xs !text-gray-600">

=======
                                            </div>

                                            <div class="flex gap-2 text-xs !text-gray-600">
>>>>>>> 62312ce (Perbaikan kategori)
                                                <span class="font-bold !text-blue-600 w-4">
                                                    B.
                                                </span>

                                                <span>
                                                    {{ $item->pilihan_b }}
                                                </span>
<<<<<<< HEAD

                                            </div>


                                            <div class="flex gap-2 text-xs !text-gray-600">

=======
                                            </div>

                                            <div class="flex gap-2 text-xs !text-gray-600">
>>>>>>> 62312ce (Perbaikan kategori)
                                                <span class="font-bold !text-blue-600 w-4">
                                                    C.
                                                </span>

                                                <span>
                                                    {{ $item->pilihan_c }}
                                                </span>
<<<<<<< HEAD

                                            </div>


                                            <div class="flex gap-2 text-xs !text-gray-600">

=======
                                            </div>

                                            <div class="flex gap-2 text-xs !text-gray-600">
>>>>>>> 62312ce (Perbaikan kategori)
                                                <span class="font-bold !text-blue-600 w-4">
                                                    D.
                                                </span>

                                                <span>
                                                    {{ $item->pilihan_d }}
                                                </span>
<<<<<<< HEAD

=======
>>>>>>> 62312ce (Perbaikan kategori)
                                            </div>

                                        </div>

                                    </div>

                                </td>


                                {{-- KELAS --}}
<<<<<<< HEAD
                                <td class="px-4 py-5 align-top text-center">

                                    @if ($item->kategori && $item->kategori->kelas)

                                        <span class="inline-flex items-center justify-center
                                                     px-3 py-1.5 rounded-lg
                                                     bg-blue-50 border border-blue-200
                                                     text-blue-700 text-xs font-semibold
                                                     whitespace-nowrap">

                                            {{ $item->kategori->kelas->nama_kelas }}

=======
                                <td class="px-5 py-5 align-top">

                                    @if ($item->kategori && $item->kategori->kelas)

                                        <span class="inline-flex items-center px-3 py-1.5 rounded-lg bg-blue-50 border border-blue-200 text-blue-700 text-xs font-semibold">
                                            {{ $item->kategori->kelas->nama_kelas }}
>>>>>>> 62312ce (Perbaikan kategori)
                                        </span>

                                    @else

<<<<<<< HEAD
                                        <span class="inline-flex items-center justify-center
                                                     px-3 py-1.5 rounded-lg
                                                     bg-gray-50 border border-gray-200
                                                     text-gray-500 text-xs font-semibold">

                                            -

=======
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-lg bg-gray-50 border border-gray-200 text-gray-500 text-xs font-semibold">
                                            -
>>>>>>> 62312ce (Perbaikan kategori)
                                        </span>

                                    @endif

                                </td>


                                {{-- KATEGORI --}}
<<<<<<< HEAD
                                <td class="px-4 py-5 align-top text-center">

                                    @if ($item->kategori)

                                        <span class="inline-flex items-center justify-center
                                                     px-3 py-1.5 rounded-lg
                                                     bg-amber-50 border border-amber-200
                                                     text-amber-700 text-xs font-semibold
                                                     whitespace-nowrap">

                                            {{ $item->kategori->nama_kategori }}

=======
                                <td class="px-5 py-5 align-top">

                                    @if ($item->kategori)

                                        <span class="inline-flex items-center px-3 py-1.5 rounded-lg bg-amber-50 border border-amber-200 text-amber-700 text-xs font-semibold">
                                            {{ $item->kategori->nama_kategori }}
>>>>>>> 62312ce (Perbaikan kategori)
                                        </span>

                                    @else

<<<<<<< HEAD
                                        <span class="inline-flex items-center justify-center
                                                     px-3 py-1.5 rounded-lg
                                                     bg-gray-50 border border-gray-200
                                                     text-gray-500 text-xs font-semibold">

                                            -

=======
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-lg bg-gray-50 border border-gray-200 text-gray-500 text-xs font-semibold">
                                            -
>>>>>>> 62312ce (Perbaikan kategori)
                                        </span>

                                    @endif

                                </td>


                                {{-- GAMBAR --}}
<<<<<<< HEAD
                                <td class="px-4 py-5 align-top text-center">

                                    @if ($item->gambar)

                                        <a href="{{ asset('storage/' . $item->gambar) }}"
                                           target="_blank"
                                           title="Lihat gambar">

                                            <img
                                                src="{{ asset('storage/' . $item->gambar) }}"
                                                alt="Gambar soal"
                                                class="mx-auto rounded-xl border border-gray-200 shadow-sm
                                                       hover:shadow-md transition duration-200"
                                                style="
                                                    width: 90px;
                                                    height: 90px;
                                                    object-fit: contain;
                                                    display: block;
                                                    background-color: #f9fafb;
                                                "
                                                loading="lazy"
                                                onerror="this.onerror=null; this.src=''; this.alt='Gambar tidak dapat dimuat';"
                                            >

                                        </a>

                                    @else

                                        <div
                                            class="mx-auto flex items-center justify-center
                                                   rounded-xl bg-gray-50 border border-gray-200"
                                            style="
                                                width: 90px;
                                                height: 90px;
                                            "
                                        >

                                            <span class="text-xs !text-gray-400">
                                                Tidak ada
=======
                                <td class="px-5 py-5 align-top">

                                    @if ($item->gambar)

                                        <img
                                            src="{{ asset('storage/' . $item->gambar) }}"
                                            alt="Gambar soal"
                                            class="w-14 h-14 object-cover rounded-xl border border-gray-200 shadow-sm"
                                        >

                                    @else

                                        <div class="w-14 h-14 flex items-center justify-center rounded-xl bg-gray-50 border border-gray-200">

                                            <span class="text-lg !text-gray-400">
                                                —
>>>>>>> 62312ce (Perbaikan kategori)
                                            </span>

                                        </div>

                                    @endif

                                </td>


                                {{-- JAWABAN --}}
<<<<<<< HEAD
                                <td class="px-4 py-5 align-top text-center">

                                    <span class="inline-flex items-center justify-center
                                                 w-10 h-10 rounded-xl
                                                 bg-green-50 border border-green-200
                                                 text-green-700 text-sm font-bold">

                                        {{ $item->jawaban }}

=======
                                <td class="px-5 py-5 align-top">

                                    <span class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-green-50 border border-green-200 text-green-700 text-sm font-bold">
                                        {{ $item->jawaban }}
>>>>>>> 62312ce (Perbaikan kategori)
                                    </span>

                                </td>


                                {{-- AKSI --}}
<<<<<<< HEAD
                                <td class="px-4 py-5 align-top">
=======
                                <td class="px-5 py-5 align-top">
>>>>>>> 62312ce (Perbaikan kategori)

                                    <div class="flex items-center justify-center gap-2">

                                        {{-- DETAIL --}}
                                        <a href="{{ route('kuis.detail', $item) }}"
                                           title="Detail"
<<<<<<< HEAD
                                           style="background-color: #eff6ff !important;
                                                  color: #2563eb !important;"
                                           class="w-9 h-9 flex items-center justify-center
                                                  rounded-lg border border-blue-200
                                                  transition hover:bg-blue-100">

                                            <i class="fa-solid fa-eye text-xs"
                                               style="color: #2563eb !important;">
                                            </i>
=======
                                           style="background-color: #eff6ff !important; color: #2563eb !important;"
                                           class="w-9 h-9 flex items-center justify-center rounded-lg border border-blue-200 transition">

                                            <i class="fa-solid fa-eye text-xs"
                                               style="color: #2563eb !important;"></i>
>>>>>>> 62312ce (Perbaikan kategori)

                                        </a>


                                        {{-- EDIT --}}
                                        <a href="{{ route('kuis.edit', $item) }}"
                                           title="Edit"
<<<<<<< HEAD
                                           style="background-color: #fffbeb !important;
                                                  color: #d97706 !important;"
                                           class="w-9 h-9 flex items-center justify-center
                                                  rounded-lg border border-amber-200
                                                  transition hover:bg-amber-100">

                                            <i class="fa-solid fa-pen text-xs"
                                               style="color: #d97706 !important;">
                                            </i>
=======
                                           style="background-color: #fffbeb !important; color: #d97706 !important;"
                                           class="w-9 h-9 flex items-center justify-center rounded-lg border border-amber-200 transition">

                                            <i class="fa-solid fa-pen text-xs"
                                               style="color: #d97706 !important;"></i>
>>>>>>> 62312ce (Perbaikan kategori)

                                        </a>


                                        {{-- HAPUS --}}
                                        <form action="{{ route('kuis.hapus', $item) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus soal ini?')">

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                title="Hapus"
<<<<<<< HEAD
                                                style="background-color: #fef2f2 !important;
                                                       color: #dc2626 !important;"
                                                class="w-9 h-9 flex items-center justify-center
                                                       rounded-lg border border-red-200
                                                       transition hover:bg-red-100">

                                                <i class="fa-solid fa-trash text-xs"
                                                   style="color: #dc2626 !important;">
                                                </i>
=======
                                                style="background-color: #fef2f2 !important; color: #dc2626 !important;"
                                                class="w-9 h-9 flex items-center justify-center rounded-lg border border-red-200 transition">

                                                <i class="fa-solid fa-trash text-xs"
                                                   style="color: #dc2626 !important;"></i>
>>>>>>> 62312ce (Perbaikan kategori)

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>


        {{-- ================= BELUM ADA DATA ================= --}}
        @else

            <div class="px-6 py-16">

                <div class="max-w-md mx-auto text-center">

<<<<<<< HEAD
                    <div class="mx-auto w-20 h-20 flex items-center justify-center
                                rounded-2xl bg-blue-50 border border-blue-100">
=======
                    <div class="mx-auto w-20 h-20 flex items-center justify-center rounded-2xl bg-blue-50 border border-blue-100">
>>>>>>> 62312ce (Perbaikan kategori)

                        <span class="text-4xl">
                            📝
                        </span>

                    </div>


                    <h3 class="mt-5 text-xl font-bold !text-gray-900">
                        Belum Ada Soal Kuis
                    </h3>


                    <p class="mt-2 text-sm !text-gray-500 leading-6">
                        Belum ada soal kuis yang ditambahkan.
                        Silakan tambahkan soal pertama untuk mulai mengisi kuis BUBA.
                    </p>


<<<<<<< HEAD
                    <a href="{{ route('kuis.tambah') }}"
                       style="background-color: #2563eb !important;
                              color: #ffffff !important;"
                       class="mt-6 inline-flex items-center gap-2
                              font-semibold text-sm px-5 py-3 rounded-xl
                              shadow-sm hover:shadow-md transition">

                        <span style="color: #ffffff !important;"
                              class="text-lg leading-none">
=======
                    {{-- TOMBOL TAMBAH SOAL PERTAMA --}}
                    <a href="{{ route('kuis.tambah') }}"
                       style="background-color: #2563eb !important; color: #ffffff !important;"
                       class="mt-6 inline-flex items-center gap-2 font-semibold text-sm px-5 py-3 rounded-xl shadow-sm hover:shadow-md transition">

                        <span style="color: #ffffff !important;" class="text-lg leading-none">
>>>>>>> 62312ce (Perbaikan kategori)
                            +
                        </span>

                        <span style="color: #ffffff !important;">
                            Tambah Soal Pertama
                        </span>

                    </a>

                </div>

            </div>

        @endif

    </div>

</div>

@endsection


{{-- ================= DATATABLES ================= --}}
@push('scripts')

<script>
<<<<<<< HEAD

=======
>>>>>>> 62312ce (Perbaikan kategori)
$(document).ready(function () {

    @if ($quis->count() > 0)

        new DataTable('#quisTable', {

            pageLength: 10,

<<<<<<< HEAD
            lengthMenu: [10, 25, 50],

            order: [[0, 'asc']],

            columnDefs: [

                {
                    orderable: false,
                    searchable: false,
                    targets: [5, 7]
                }

            ],

            language: {

                search: "Cari soal:",

                lengthMenu: "Tampilkan _MENU_ data",

                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",

                infoEmpty: "Tidak ada data",

                infoFiltered: "(difilter dari _MAX_ total data)",

=======
            columnDefs: [
                {
                    orderable: false,
                    searchable: false,
                    targets: [4, 6]
                }
            ],

            language: {
                search: "Cari soal:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",

>>>>>>> 62312ce (Perbaikan kategori)
                paginate: {
                    next: "Berikutnya",
                    previous: "Sebelumnya"
                },

                zeroRecords: "Data tidak ditemukan",
<<<<<<< HEAD

                emptyTable: "Belum ada soal kuis."

=======
                emptyTable: "Belum ada soal kuis."
>>>>>>> 62312ce (Perbaikan kategori)
            }

        });

    @endif

});
<<<<<<< HEAD

</script>


<style>

.dataTables_wrapper {

    width: 100%;

    padding: 0 24px 20px;

}


.dataTables_wrapper .dt-layout-row:first-child {

    width: 100%;

    margin: 0 0 16px 0;

    padding: 18px 0 0 0;

}


.dataTables_wrapper .dt-length {

    margin-left: 0 !important;

    padding-left: 0 !important;

}


.dataTables_wrapper .dt-length label {

    font-size: 13px;

    color: #4b5563;

}


.dataTables_wrapper .dt-search {

    margin-right: 0 !important;

    padding-right: 0 !important;

}


.dataTables_wrapper .dt-search label {

    font-size: 13px;

    color: #4b5563;

}


.dataTables_wrapper .dt-search input {

    margin-left: 8px !important;

}


.dataTables_wrapper select,
.dataTables_wrapper input {

    border: 1px solid #d1d5db !important;

    border-radius: 8px !important;

    padding: 7px 10px !important;

    font-size: 13px !important;

    outline: none !important;

    background-color: #ffffff !important;

}


.dataTables_wrapper select:focus,
.dataTables_wrapper input:focus {

    border-color: #60a5fa !important;

    box-shadow: 0 0 0 3px rgba(96, 165, 250, 0.15) !important;

}


#quisTable {

    width: 100% !important;

    border-collapse: separate;

    border-spacing: 0;

}


#quisTable thead th {

    white-space: nowrap;

    background-color: #f9fafb;

}


#quisTable tbody tr {

    background-color: #ffffff;

}


#quisTable tbody tr:hover {

    background-color: #f8fbff;

}


#quisTable td,
#quisTable th {

    vertical-align: top;

}


.dataTables_wrapper .dt-layout-row:last-child {

    width: 100%;

    margin: 16px 0 0 0;

    padding: 0;

}


.dataTables_wrapper .dt-info {

    margin-left: 0 !important;

    padding-left: 0 !important;

    font-size: 13px;

    color: #6b7280;

}


.dataTables_wrapper .dt-paging {

    margin-right: 0 !important;

}


.dataTables_wrapper .dt-paging-button {

    border-radius: 8px !important;

    margin-left: 4px !important;

    border: 1px solid #e5e7eb !important;

    background: #ffffff !important;

    color: #374151 !important;

}


.dataTables_wrapper .dt-paging-button:hover {

    background: #eff6ff !important;

    border-color: #bfdbfe !important;

    color: #2563eb !important;

}


.dataTables_wrapper .dt-paging-button.current {

    background: #2563eb !important;

    border-color: #2563eb !important;

    color: #ffffff !important;

}


@media (max-width: 768px) {

    .dataTables_wrapper {

        padding: 0 14px 16px;

    }

    #quisTable {

        min-width: 1200px;

    }

}

</style>

=======
</script>

>>>>>>> 62312ce (Perbaikan kategori)
@endpush
