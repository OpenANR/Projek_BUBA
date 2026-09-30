@extends('layouts.admin.app')

@section('title', 'Kelola Kuis - BUBA')

@section('content')

<div class="max-w-6xl mx-auto px-5 py-5">

    {{-- ================= HEADER ================= --}}
    <div class="flex items-center justify-between mb-6">

        <div>
            <h1 class="text-2xl font-bold !text-black">
                📝 Kelola Kuis
            </h1>

            <p class="mt-1 text-sm !text-black">
                Kelola soal kuis berdasarkan kelas dan kategori pembelajaran.
            </p>
        </div>

        <a href="{{ route('kuis.tambah') }}"
           class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 !text-white font-semibold px-4 py-2.5 rounded-lg shadow-sm transition">

            <span class="text-lg font-bold">+</span>
            <span>Tambah Soal</span>

        </a>

    </div>


    {{-- ================= NOTIFIKASI ================= --}}

    @if (session('success'))

        <div class="mb-5 px-4 py-3 rounded-lg bg-green-100 border border-green-300">

            <p class="font-bold !text-green-900 text-sm">
                Berhasil
            </p>

            <p class="text-xs !text-green-900 mt-1">
                {{ session('success') }}
            </p>

        </div>

    @endif


    @if ($errors->any())

        <div class="mb-5 px-4 py-3 rounded-lg bg-red-100 border border-red-300">

            <p class="font-bold !text-red-900 text-sm mb-1">
                Terdapat kesalahan:
            </p>

            <ul class="list-disc list-inside text-xs !text-red-900">

                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>

    @endif


    {{-- ================= CARD TABEL ================= --}}

    <div class="bg-white border border-gray-300 rounded-xl shadow-md overflow-hidden">

        {{-- HEADER CARD --}}

        <div class="px-5 py-4 bg-white border-b border-gray-300">

            <h2 class="text-lg font-bold !text-black">
                Daftar Soal Kuis
            </h2>

            <p class="text-xs !text-black mt-1">
                Soal kuis yang telah ditambahkan akan tampil di bawah.
            </p>

        </div>


        {{-- ================= TABEL ================= --}}

        <div class="overflow-x-auto">

            <table id="quisTable" class="min-w-full">

                {{-- HEADER TABEL --}}

                <thead class="bg-gray-100">

                    <tr>

                        <th class="px-3 py-3 text-left text-[11px] font-bold !text-black uppercase">
                            No
                        </th>

                        <th class="px-3 py-3 text-left text-[11px] font-bold !text-black uppercase">
                            Pertanyaan
                        </th>

                        <th class="px-3 py-3 text-left text-[11px] font-bold !text-black uppercase">
                            Kelas
                        </th>

                        <th class="px-3 py-3 text-left text-[11px] font-bold !text-black uppercase">
                            Kategori
                        </th>

                        <th class="px-3 py-3 text-left text-[11px] font-bold !text-black uppercase">
                            Gambar
                        </th>

                        <th class="px-3 py-3 text-left text-[11px] font-bold !text-black uppercase">
                            Jawaban
                        </th>

                        <th class="px-3 py-3 text-left text-[11px] font-bold !text-black uppercase">
                            Aksi
                        </th>

                    </tr>

                </thead>


                {{-- ISI TABEL --}}

                <tbody class="bg-white">

                    @forelse ($quis as $item)

                        <tr class="border-b border-gray-200 hover:bg-indigo-50 transition">

                            {{-- NO --}}

                            <td class="px-3 py-4 align-top">

                                <span class="text-xs font-bold !text-black">
                                    {{ $loop->iteration }}
                                </span>

                            </td>


                            {{-- PERTANYAAN --}}

                            <td class="px-3 py-4 align-top">

                                <div class="w-64">

                                    <p class="text-xs font-bold !text-black leading-5">
                                        {{ $item->pertanyaan }}
                                    </p>


                                    {{-- PILIHAN --}}

                                    <div class="mt-2.5 space-y-1">

                                        <div class="flex gap-1.5 text-xs !text-black">

                                            <span class="font-bold text-indigo-700 w-4">
                                                A.
                                            </span>

                                            <span class="!text-black">
                                                {{ $item->pilihan_a }}
                                            </span>

                                        </div>


                                        <div class="flex gap-1.5 text-xs !text-black">

                                            <span class="font-bold text-indigo-700 w-4">
                                                B.
                                            </span>

                                            <span class="!text-black">
                                                {{ $item->pilihan_b }}
                                            </span>

                                        </div>


                                        <div class="flex gap-1.5 text-xs !text-black">

                                            <span class="font-bold text-indigo-700 w-4">
                                                C.
                                            </span>

                                            <span class="!text-black">
                                                {{ $item->pilihan_c }}
                                            </span>

                                        </div>


                                        <div class="flex gap-1.5 text-xs !text-black">

                                            <span class="font-bold text-indigo-700 w-4">
                                                D.
                                            </span>

                                            <span class="!text-black">
                                                {{ $item->pilihan_d }}
                                            </span>

                                        </div>

                                    </div>

                                </div>

                            </td>


                            {{-- KELAS --}}

                            <td class="px-3 py-4 align-top">

                                @if ($item->kelas === 'A')

                                    <span class="inline-flex px-2.5 py-1 rounded-full bg-blue-100 border border-blue-300 !text-blue-900 text-[10px] font-bold">
                                        Kelas A
                                    </span>

                                @else

                                    <span class="inline-flex px-2.5 py-1 rounded-full bg-purple-100 border border-purple-300 !text-purple-900 text-[10px] font-bold">
                                        Kelas B
                                    </span>

                                @endif

                            </td>


                            {{-- KATEGORI --}}

                            <td class="px-3 py-4 align-top">

                                <span class="inline-flex px-2.5 py-1 rounded-full bg-yellow-100 border border-yellow-300 !text-yellow-900 text-[10px] font-bold">
                                    {{ $item->kategori }}
                                </span>

                            </td>


                            {{-- GAMBAR --}}

                            <td class="px-3 py-4 align-top">

                                @if ($item->gambar)

                                    <img
                                        src="{{ asset('storage/' . $item->gambar) }}"
                                        alt="Gambar soal"
                                        class="w-12 h-12 object-cover rounded-lg border border-gray-300"
                                    >

                                @else

                                    <span class="text-xs font-medium !text-black">
                                        Tidak ada gambar
                                    </span>

                                @endif

                            </td>


                            {{-- JAWABAN --}}

                            <td class="px-3 py-4 align-top">

                                <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-green-100 border border-green-300 !text-green-900 text-xs font-bold">
                                    {{ $item->jawaban }}
                                </span>

                            </td>


                            {{-- AKSI --}}

                            <td class="px-3 py-4 align-top">

                                <div class="flex flex-col gap-1.5 w-20">

                                    <a href="{{ route('kuis.edit', $item) }}"
                                       class="text-center bg-yellow-500 hover:bg-yellow-600 !text-white text-[11px] font-bold px-2 py-1.5 rounded-md transition">

                                        Edit

                                    </a>


                                    <a href="{{ route('kuis.detail', $item) }}"
                                       class="text-center bg-indigo-600 hover:bg-indigo-700 !text-white text-[11px] font-bold px-2 py-1.5 rounded-md transition">

                                        Detail

                                    </a>


                                    <form action="{{ route('kuis.hapus', $item) }}"
                                          method="POST">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            onclick="return confirm('Yakin ingin menghapus soal ini?')"
                                            class="w-full bg-red-600 hover:bg-red-700 !text-white text-[11px] font-bold px-2 py-1.5 rounded-md transition">

                                            Hapus

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>


                    @empty

                        {{-- ================= BELUM ADA DATA ================= --}}

                        <tr>

                            <td colspan="7">

                                <div class="flex flex-col items-center justify-center py-14">

                                    <div class="w-16 h-16 flex items-center justify-center rounded-full bg-indigo-100 mb-4">

                                        <span class="text-3xl">
                                            📝
                                        </span>

                                    </div>


                                    <h3 class="text-lg font-bold !text-black">
                                        Belum Ada Soal Kuis
                                    </h3>


                                    <p class="text-xs !text-black mt-1">
                                        Belum ada data quiz yang ditambahkan.
                                    </p>


                                    <a href="{{ route('kuis.tambah') }}"
                                       class="mt-4 inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 !text-white font-semibold text-sm px-4 py-2 rounded-lg shadow-sm transition">

                                        <span class="font-bold">
                                            +
                                        </span>

                                        Tambah Soal

                                    </a>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection


{{-- ================= DATATABLES ================= --}}

@push('scripts')

<script>

$(document).ready(function () {

    @if ($quis->count() > 0)

        new DataTable('#quisTable', {

            pageLength: 10,

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

                paginate: {
                    next: "Berikutnya",
                    previous: "Sebelumnya"
                },

                zeroRecords: "Data tidak ditemukan",

                emptyTable: "Belum ada soal kuis."

            }

        });

    @endif

});

</script>

@endpush
