@extends('layouts.admin.app')

@section('title', 'Kelola Siswa - BUBA')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    {{-- HEADER --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-7">

        <div class="flex items-center gap-3">

            <div class="w-11 h-11 flex items-center justify-center rounded-xl bg-blue-100 border border-blue-200">
                <span class="text-xl">👨‍🎓</span>
            </div>

            <div>
                <h1 class="text-2xl font-bold !text-gray-900">
                    Kelola Siswa
                </h1>

                <p class="text-sm !text-gray-500 mt-0.5">
                    Kelola data dan akun siswa pembelajaran BUBA.
                </p>
            </div>

        </div>

        {{-- TOMBOL TAMBAH SISWA --}}
        <a
            href="{{ route('siswa.tambah') }}"
            style="background-color: #2563eb !important; color: #ffffff !important;"
            class="inline-flex items-center justify-center gap-2 font-semibold text-sm px-5 py-3 rounded-xl shadow-sm hover:shadow-md transition duration-200"
        >
            <span style="color: #ffffff !important;" class="text-lg leading-none">+</span>
            <span style="color: #ffffff !important;">Tambah Siswa</span>
        </a>

    </div>

    {{-- PESAN SUKSES --}}
    @if (session('success'))
        <div class="mb-6 flex items-start gap-3 px-4 py-3.5 rounded-xl bg-green-50 border border-green-200">
            <div class="w-8 h-8 flex items-center justify-center rounded-lg bg-green-100 flex-shrink-0">
                <span class="text-green-700 font-bold">✓</span>
            </div>
            <div>
                <p class="font-semibold text-sm text-green-800">Berhasil</p>
                <p class="text-xs text-green-700 mt-0.5">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    {{-- PESAN ERROR --}}
    @if (session('error'))
        <div class="mb-6 flex items-start gap-3 px-4 py-3.5 rounded-xl bg-red-50 border border-red-200">
            <div class="w-8 h-8 flex items-center justify-center rounded-lg bg-red-100 flex-shrink-0">
                <span class="text-red-700 font-bold">!</span>
            </div>
            <div>
                <p class="font-semibold text-sm text-red-800">Terjadi Kesalahan</p>
                <p class="text-xs text-red-700 mt-0.5">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-6 px-4 py-3.5 rounded-xl bg-red-50 border border-red-200">
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 flex items-center justify-center rounded-lg bg-red-100 flex-shrink-0">
                    <span class="text-red-700 font-bold">!</span>
                </div>
                <div>
                    <p class="font-semibold text-sm text-red-800">Terdapat kesalahan</p>
                    <ul class="mt-1.5 space-y-1 text-xs text-red-700">
                        @foreach ($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    {{-- CARD KONTEN UTAMA --}}
    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">

        {{-- CARD HEADER --}}
        <div class="px-6 py-5 border-b border-gray-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <h2 class="text-lg font-bold !text-gray-900">
                        Daftar Siswa
                    </h2>
                    <p class="text-sm !text-gray-500 mt-1">
                        Daftar seluruh siswa yang terdaftar dalam sistem BUBA.
                    </p>
                </div>

                {{-- TOTAL SISWA --}}
                <div class="inline-flex items-center gap-2 self-start sm:self-auto px-3 py-2 rounded-lg bg-blue-50 border border-blue-100">
                    <span class="text-xs !text-blue-600 font-medium">Total Siswa</span>
                    <span class="text-sm font-bold !text-blue-700">{{ $siswa->count() }}</span>
                </div>
            </div>
        </div>

        @if ($siswa->count() > 0)

            {{-- PENCARIAN CUSTOM --}}
            <div class="px-6 pt-5">
                <div class="flex flex-col sm:flex-row gap-3">

                    {{-- PILIH KOLOM PENCARIAN --}}
                    <div class="w-full sm:w-56">
                        <select
                            id="filterSiswa"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-700 bg-white outline-none focus:ring-2 focus:ring-blue-400"
                        >
                            <option value="all">Semua Kolom</option>
                            <option value="1">Kode Siswa</option>
                            <option value="2">Nama</option>
                            <option value="3">Jenis Kelamin</option>
                            <option value="4">Email</option>
                            <option value="5">Kelas</option>
                            <option value="6">Role</option>
                        </select>
                    </div>

                    {{-- INPUT PENCARIAN --}}
                    <div class="flex-1">
                        <input
                            type="text"
                            id="inputCariSiswa"
                            placeholder="Ketik kata kunci yang ingin dicari..."
                            autocomplete="off"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-700 outline-none focus:ring-2 focus:ring-blue-400"
                        >
                    </div>

                    {{-- TOMBOL RESET --}}
                    <button
                        type="button"
                        id="resetSearchSiswa"
                        class="px-5 py-2 rounded-lg bg-gray-500 text-white text-sm font-medium hover:bg-gray-600 transition"
                    >
                        Reset
                    </button>

                </div>
            </div>

            {{-- TABEL SISWA --}}
            <div class="overflow-x-auto mt-4">
                <table id="siswaTable" class="min-w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-4 w-14 text-center text-[11px] font-bold !text-gray-600 uppercase tracking-wide">
                                No
                            </th>
                            <th class="px-4 py-4 min-w-[130px] text-center text-[11px] font-bold !text-gray-600 uppercase tracking-wide">
                                Kode Siswa
                            </th>
                            <th class="px-5 py-4 min-w-[200px] text-left text-[11px] font-bold !text-gray-600 uppercase tracking-wide">
                                Nama
                            </th>
                            <th class="px-4 py-4 min-w-[140px] text-center text-[11px] font-bold !text-gray-600 uppercase tracking-wide">
                                Jenis Kelamin
                            </th>
                            <th class="px-5 py-4 min-w-[220px] text-left text-[11px] font-bold !text-gray-600 uppercase tracking-wide">
                                Email
                            </th>
                            <th class="px-4 py-4 min-w-[110px] text-center text-[11px] font-bold !text-gray-600 uppercase tracking-wide">
                                Kelas
                            </th>
                            <th class="px-4 py-4 min-w-[110px] text-center text-[11px] font-bold !text-gray-600 uppercase tracking-wide">
                                Role
                            </th>
                            <th class="px-4 py-4 w-[120px] text-center text-[11px] font-bold !text-gray-600 uppercase tracking-wide">
                                Aksi
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @foreach ($siswa as $item)
                            <tr class="hover:bg-blue-50/40 transition duration-150">

                                {{-- NO --}}
                                <td class="px-4 py-4 align-middle text-center">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-gray-100 text-sm font-semibold !text-gray-700">
                                        {{ $loop->iteration }}
                                    </span>
                                </td>

                                {{-- KODE SISWA --}}
                                <td class="px-4 py-4 align-middle text-center">
                                    <span class="inline-flex items-center justify-center px-3 py-1.5 rounded-lg bg-purple-50 border border-purple-200 text-purple-700 text-xs font-bold whitespace-nowrap">
                                        {{ $item->kode_user ?? '-' }}
                                    </span>
                                </td>

                                {{-- NAMA --}}
                                <td class="px-5 py-4 align-middle">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full bg-blue-100 border border-blue-200 text-blue-700 font-bold text-sm flex items-center justify-center flex-shrink-0">
                                            {{ strtoupper(substr($item->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold !text-gray-900 leading-snug">
                                                {{ $item->name }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                {{-- JENIS KELAMIN --}}
                                <td class="px-4 py-4 align-middle text-center">
                                    @php
                                        $jk = strtoupper(trim($item->jenis_kelamin ?? ''));
                                    @endphp

                                    @if ($jk === 'L' || $jk === 'LAKI-LAKI')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-50 border border-blue-200 text-blue-700 text-xs font-medium">
                                            <i class="fa-solid fa-mars text-[11px]"></i>
                                            Laki-Laki
                                        </span>
                                    @elseif ($jk === 'P' || $jk === 'PEREMPUAN')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-pink-50 border border-pink-200 text-pink-700 text-xs font-medium">
                                            <i class="fa-solid fa-venus text-[11px]"></i>
                                            Perempuan
                                        </span>
                                    @else
                                        <span class="text-xs text-gray-400 font-medium">
                                            -
                                        </span>
                                    @endif
                                </td>

                                {{-- EMAIL --}}
                                <td class="px-5 py-4 align-middle">
                                    <div class="flex items-center gap-2 text-sm text-gray-700">
                                        <i class="fa-regular fa-envelope text-gray-400 text-xs"></i>
                                        <span>{{ $item->email }}</span>
                                    </div>
                                </td>

                                {{-- KELAS --}}
                                <td class="px-4 py-4 align-middle text-center">
                                    @if ($item->kelas)
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-blue-50 border border-blue-200 text-blue-700 text-xs font-semibold whitespace-nowrap">
                                            <i class="fa-solid fa-school text-[10px]"></i>
                                            {{ $item->kelas->nama_kelas }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center justify-center px-2 py-0.5 rounded text-xs text-gray-400 font-medium">
                                            -
                                        </span>
                                    @endif
                                </td>

                                {{-- ROLE --}}
                                <td class="px-4 py-4 align-middle text-center">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-semibold capitalize">
                                        <i class="fa-solid fa-user-graduate text-[10px]"></i>
                                        {{ $item->role }}
                                    </span>
                                </td>

                                {{-- AKSI --}}
                                <td class="px-4 py-4 align-middle">
                                    <div class="flex items-center justify-center gap-2">

                                        {{-- EDIT --}}
                                        <a
                                            href="{{ route('siswa.edit', $item) }}"
                                            title="Edit Siswa"
                                            style="background-color: #fffbeb !important; color: #d97706 !important;"
                                            class="w-9 h-9 flex items-center justify-center rounded-lg border border-amber-200 transition hover:bg-amber-100"
                                        >
                                            <i class="fa-solid fa-pen text-xs" style="color: #d97706 !important;"></i>
                                        </a>

                                        {{-- HAPUS --}}
                                        <form
                                            action="{{ route('siswa.hapus', $item) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus siswa {{ $item->name }}?')"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                title="Hapus Siswa"
                                                style="background-color: #fef2f2 !important; color: #dc2626 !important;"
                                                class="w-9 h-9 flex items-center justify-center rounded-lg border border-red-200 transition hover:bg-red-100"
                                            >
                                                <i class="fa-solid fa-trash text-xs" style="color: #dc2626 !important;"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        @else

            {{-- BELUM ADA DATA --}}
            <div class="px-6 py-16">
                <div class="max-w-md mx-auto text-center">

                    <div class="mx-auto w-20 h-20 flex items-center justify-center rounded-2xl bg-blue-50 border border-blue-100">
                        <span class="text-4xl">👨‍🎓</span>
                    </div>

                    <h3 class="mt-5 text-xl font-bold !text-gray-900">
                        Belum Ada Data Siswa
                    </h3>

                    <p class="mt-2 text-sm !text-gray-500 leading-6">
                        Belum ada data siswa yang ditambahkan ke sistem.
                        Silakan tambahkan data siswa pertama untuk memulai.
                    </p>

                    {{-- TOMBOL TAMBAH PERTAMA --}}
                    <a
                        href="{{ route('siswa.tambah') }}"
                        style="background-color: #2563eb !important; color: #ffffff !important;"
                        class="mt-6 inline-flex items-center gap-2 font-semibold text-sm px-5 py-3 rounded-xl shadow-sm hover:shadow-md transition"
                    >
                        <span style="color: #ffffff !important;" class="text-lg leading-none">+</span>
                        <span style="color: #ffffff !important;">Tambah Siswa Pertama</span>
                    </a>

                </div>
            </div>

        @endif

    </div>

</div>

@endsection

@push('scripts')

<script>
$(document).ready(function () {

    @if ($siswa->count() > 0)

        const table = new DataTable('#siswaTable', {

            pageLength: 10,

            lengthMenu: [10, 25, 50, 100],

            order: [[0, 'asc']],

            searching: true,

            /*
             * Layout DataTables:
             * topStart: jumlah per halaman
             * search bawaan dinonaktifkan (diganti search custom)
             */
            layout: {
                topStart: 'pageLength',
                topEnd: null,
                bottomStart: 'info',
                bottomEnd: 'paging'
            },

            columnDefs: [
                {
                    orderable: false,
                    searchable: false,
                    targets: [7]
                }
            ],

            language: {
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Tidak ada data siswa",
                infoFiltered: "(difilter dari _MAX_ total data)",
                paginate: {
                    next: "Berikutnya",
                    previous: "Sebelumnya"
                },
                zeroRecords: "Data siswa tidak ditemukan",
                emptyTable: "Belum ada data siswa."
            }

        });

        // =========================================
        // SEARCH CUSTOM
        // =========================================
        const filter = document.getElementById('filterSiswa');
        const input = document.getElementById('inputCariSiswa');
        const resetBtn = document.getElementById('resetSearchSiswa');

        function doSearch() {
            const nilai = input.value.trim();
            const kolom = filter.value;

            // Cari di semua kolom
            if (kolom === 'all') {
                table
                    .search(nilai)
                    .columns()
                    .search('')
                    .draw();
                return;
            }

            // Cari di kolom tertentu
            table
                .search('')
                .columns()
                .search('');

            if (nilai !== '') {
                table
                    .column(parseInt(kolom))
                    .search(nilai)
                    .draw();
            } else {
                table.draw();
            }
        }

        input.addEventListener('keyup', doSearch);

        filter.addEventListener('change', function () {
            input.value = '';
            table
                .search('')
                .columns()
                .search('')
                .draw();
            input.focus();
        });

        resetBtn.addEventListener('click', function () {
            filter.value = 'all';
            input.value = '';
            table
                .search('')
                .columns()
                .search('')
                .draw();
        });

    @endif

});
</script>

<style>
/* =========================================
   DATATABLES OVERRIDES & STYLING
   ========================================= */

.dataTables_wrapper {
    width: 100%;
    padding: 0 24px 20px;
}

/* Hilangkan search bawaan DataTables */
.dataTables_wrapper .dt-search,
.dataTables_wrapper div.dt-search {
    display: none !important;
}

/* Baris atas DataTables */
.dataTables_wrapper .dt-layout-row:first-child {
    width: 100%;
    margin: 0 0 16px 0;
    padding: 18px 0 0 0;
}

.dataTables_wrapper .dt-layout-row:first-child .dt-layout-cell {
    width: auto !important;
}

.dataTables_wrapper .dt-length {
    margin-left: 0 !important;
    padding-left: 0 !important;
}

.dataTables_wrapper .dt-length label {
    font-size: 13px;
    color: #4b5563;
}

.dataTables_wrapper select {
    border: 1px solid #d1d5db !important;
    border-radius: 8px !important;
    padding: 7px 10px !important;
    font-size: 13px !important;
    outline: none !important;
    background-color: #ffffff !important;
}

.dataTables_wrapper select:focus {
    border-color: #60a5fa !important;
    box-shadow: 0 0 0 3px rgba(96, 165, 250, 0.15) !important;
}

/* Tabel */
#siswaTable {
    width: 100% !important;
    border-collapse: separate;
    border-spacing: 0;
}

#siswaTable thead th {
    white-space: nowrap;
    background-color: #f9fafb;
}

#siswaTable tbody tr {
    background-color: #ffffff;
}

#siswaTable tbody tr:hover {
    background-color: #f8fbff;
}

/* Info & Pagination */
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

    #siswaTable {
        min-width: 900px;
    }
}
</style>

@endpush