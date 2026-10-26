@extends('layouts.admin.app')

@section('title', 'Kelola Kuis - BUBA')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5">

    {{-- HEADER --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 flex items-center justify-center rounded-xl bg-blue-100 border border-blue-200">
                <span class="text-lg">📝</span>
            </div>

            <div>
                <h1 class="text-xl font-bold text-gray-900">Kelola Kuis</h1>
                <p class="text-sm text-gray-500 mt-1">
                    Kelola pertanyaan kuis berdasarkan kelas dan kategori pembelajaran.
                </p>
            </div>
        </div>

        <a href="{{ route('kuis.tambah') }}"
           class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-3 rounded-xl shadow-sm transition">
            <span class="text-lg">+</span>
            <span>Tambah Kuis</span>
        </a>
    </div>

    {{-- PESAN SUKSES --}}
    @if (session('success'))
        <div class="mb-5 px-4 py-3 rounded-xl bg-green-50 border border-green-200">
            <p class="font-semibold text-sm text-green-800">Berhasil</p>
            <p class="text-sm text-green-700 mt-1">
                {{ session('success') }}
            </p>
        </div>
    @endif

    {{-- PESAN ERROR --}}
    @if ($errors->any())
        <div class="mb-5 px-4 py-3 rounded-xl bg-red-50 border border-red-200">
            <p class="font-semibold text-sm text-red-800">Terdapat kesalahan</p>
            <ul class="mt-1 text-sm text-red-700 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- KARTU DAFTAR KUIS --}}
    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">

        {{-- HEADER KARTU --}}
        <div class="px-5 py-5 border-b border-gray-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <h2 class="text-lg font-bold text-gray-900">
                        Daftar Kuis
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">
                        Pertanyaan kuis yang telah dibuat akan ditampilkan di sini.
                    </p>
                </div>

                <div class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-blue-50 border border-blue-100 text-blue-600 text-sm">
                    <span>Total kuis</span>
                    <span class="font-bold">{{ $quis->count() }}</span>
                </div>
            </div>
        </div>

        {{-- JIKA KUIS ADA --}}
        @if ($quis->count() > 0)
            {{-- PENCARIAN --}}
            <div class="px-5 py-5">
                <div class="flex flex-col sm:flex-row gap-3">

                    <select id="searchField"
                            class="sm:w-48 border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-700 bg-white outline-none focus:ring-2 focus:ring-blue-400">
                        <option value="all">Cari berdasarkan...</option>
                        <option value="kode">Kode Kuis</option>
                        <option value="pertanyaan">Pertanyaan</option>
                        <option value="kelas">Kelas</option>
                        <option value="kategori">Kategori</option>
                    </select>

                    <input type="text"
                        id="searchKuis"
                        placeholder="Masukkan pencarian..."
                        autocomplete="off"
                        class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-700 outline-none focus:ring-2 focus:ring-blue-400">

                    <button type="button"
                            id="resetSearch"
                            class="px-4 py-2 rounded-lg bg-gray-100 border border-gray-200 text-gray-600 text-sm hover:bg-gray-200 transition">
                        Reset
                    </button>

                </div>
            </div>

            {{-- TABEL --}}
            <div class="overflow-x-auto">
                <table id="quisTable" class="display w-full text-sm">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>KODE KUIS</th>
                            <th>PERTANYAAN</th>
                            <th>KELAS</th>
                            <th>KATEGORI</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($quis as $item)
                            <tr>
                                {{-- NOMOR --}}
                                <td>
                                    <span class="inline-flex items-center justify-center min-w-8 h-8 rounded-lg bg-gray-100 text-gray-700 font-medium">
                                        {{ $loop->iteration }}
                                    </span>
                                </td>

                                {{-- KODE KUIS --}}
                                <td>
                                    <span class="inline-block px-3 py-1.5 rounded-lg bg-purple-50 border border-purple-200 text-purple-700 text-xs font-semibold whitespace-nowrap">
                                        {{ $item->kode_kuis }}
                                    </span>
                                </td>

                                {{-- PERTANYAAN --}}
                                <td>
                                    <span class="font-medium text-gray-800">
                                        {{ \Illuminate\Support\Str::limit($item->pertanyaan, 70) }}
                                    </span>
                                </td>

                                {{-- KELAS --}}
                                <td>
                                    @if ($item->kelas)
                                        <span class="inline-block px-3 py-1.5 rounded-lg bg-blue-50 border border-blue-200 text-blue-700 text-xs whitespace-nowrap">
                                            {{ $item->kelas->nama_kelas }}
                                        </span>
                                    @else
                                        <span class="text-gray-400 text-xs">
                                            Belum ada kelas
                                        </span>
                                    @endif
                                </td>

                                {{-- KATEGORI --}}
                                <td>
                                    @if ($item->kategori)
                                        <span class="inline-block px-3 py-1.5 rounded-lg bg-amber-50 border border-amber-200 text-amber-700 text-xs whitespace-nowrap">
                                            {{ $item->kategori->nama_kategori }}
                                        </span>
                                    @else
                                        <span class="text-gray-400 text-xs">
                                            Belum ada kategori
                                        </span>
                                    @endif
                                </td>

                                {{-- AKSI --}}
                                <td>
                                    <div class="flex items-center justify-center gap-2">

                                        {{-- DETAIL --}}
                                        <a
                                            href="{{ route('kuis.detail', $item->kode_kuis) }}"
                                            title="Detail Kuis"
                                            style="background-color: #eff6ff !important; color: #2563eb !important;"
                                            class="w-9 h-9 flex items-center justify-center rounded-lg border border-blue-200 transition hover:bg-blue-100"
                                        >
                                            <i class="fa-solid fa-eye text-xs"></i>
                                        </a>

                                        {{-- EDIT --}}
                                        <a
                                            href="{{ route('kuis.edit', $item->kode_kuis) }}"
                                            title="Edit Kuis"
                                            style="background-color: #fffbeb !important; color: #d97706 !important;"
                                            class="w-9 h-9 flex items-center justify-center rounded-lg border border-amber-200 transition hover:bg-amber-100"
                                        >
                                            <i class="fa-solid fa-pen text-xs"></i>
                                        </a>

                                        {{-- HAPUS --}}
                                        <form
                                            action="{{ route('kuis.hapus', $item->kode_kuis) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus pertanyaan kuis ini?')"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                title="Hapus Kuis"
                                                style="background-color: #fef2f2 !important; color: #dc2626 !important;"
                                                class="w-9 h-9 flex items-center justify-center rounded-lg border border-red-200 transition hover:bg-red-100"
                                            >
                                                <i class="fa-solid fa-trash text-xs"></i>
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

            {{-- TAMPILAN KOSONG --}}
            <div class="px-5 py-12 text-center">
                <div class="max-w-sm mx-auto">

                    <div class="mx-auto w-16 h-16 flex items-center justify-center rounded-xl bg-blue-50 border border-blue-100">
                        <span class="text-3xl">📝</span>
                    </div>

                    <h3 class="mt-4 text-lg font-bold text-gray-900">
                        Belum Ada Kuis
                    </h3>

                    <p class="mt-2 text-sm text-gray-500 leading-6">
                        Belum ada pertanyaan kuis yang ditambahkan.
                        Silakan tambahkan kuis pertama untuk mulai mengisi
                        kuis BUBA.
                    </p>

                    <a href="{{ route('kuis.tambah') }}"
                       class="mt-5 inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl shadow-sm transition">
                        <span class="text-lg">+</span>
                        <span>Tambah Kuis Pertama</span>
                    </a>

                </div>
            </div>

        @endif

    </div>
</div>
@endsection

{{-- DATATABLES --}}
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const tableElement = document.getElementById('quisTable');

    // Jika data kuis kosong, tidak perlu menjalankan DataTables
    if (!tableElement) {
        return;
    }

    if (typeof DataTable === 'undefined') {
        console.error('DataTables belum dimuat pada layout admin.');
        return;
    }

    // Inisialisasi DataTables
    let table;

    if (DataTable.isDataTable(tableElement)) {
        table = new DataTable(tableElement, {
            retrieve: true
        });
    } else {
        table = new DataTable(tableElement, {
            pageLength: 10,
            lengthMenu: [10, 25, 50],
            autoWidth: false,

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
                    targets: [5]
                }
            ],

            language: {
                lengthMenu: 'Tampilkan _MENU_ data',
                info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                infoEmpty: 'Tidak ada data kuis',
                infoFiltered: '(difilter dari _MAX_ total data)',
                paginate: {
                    next: 'Berikutnya',
                    previous: 'Sebelumnya'
                },
                zeroRecords: 'Data tidak ditemukan',
                emptyTable: 'Belum ada data kuis.'
            }
        });
    }

    const searchField = document.getElementById('searchField');
    const searchKuis = document.getElementById('searchKuis');
    const resetSearch = document.getElementById('resetSearch');

    if (!searchField || !searchKuis || !resetSearch) {
        return;
    }

    // Pencarian berdasarkan kolom
    function cariKuis() {
        const pilihan = searchField.value;
        const kataKunci = searchKuis.value;

        table.search('');
        table.columns().search('');

        if (pilihan === 'all') {
            table.search(kataKunci).draw();
            return;
        }

        const kolom = {
            kode: 1,
            pertanyaan: 2,
            kelas: 3,
            kategori: 4
        };

        if (kolom[pilihan] !== undefined) {
            table.column(kolom[pilihan]).search(kataKunci).draw();
        }
    }

    searchKuis.addEventListener('input', cariKuis);
    searchField.addEventListener('change', cariKuis);

    // Reset pencarian
    resetSearch.addEventListener('click', function () {
        searchField.value = 'all';
        searchKuis.value = '';

        table.search('');
        table.columns().search('');
        table.draw();
    });
});
</script>
@endpush
