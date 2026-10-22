
@extends('layouts.admin.app')

@section('title', 'Kelola Materi - BUBA')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5">

    {{-- HEADER --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 flex items-center justify-center rounded-xl bg-blue-100 border border-blue-200">
                <span class="text-lg">📚</span>
            </div>

            <div>
                <h1 class="text-xl font-bold text-gray-900">Kelola Materi</h1>
                <p class="text-sm text-gray-500 mt-1">
                    Kelola materi berdasarkan kelas dan kategori pembelajaran.
                </p>
            </div>
        </div>

        <a href="{{ route('materi.tambah') }}"
           class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-3 rounded-xl shadow-sm transition">
            <span class="text-lg">+</span>
            <span>Tambah Materi</span>
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

    {{-- KARTU DAFTAR MATERI --}}
    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">

        {{-- HEADER KARTU --}}
        <div class="px-5 py-5 border-b border-gray-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <h2 class="text-lg font-bold text-gray-900">
                        Daftar Materi
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">
                        Materi yang telah ditambahkan akan ditampilkan di sini.
                    </p>
                </div>

                <div class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-blue-50 border border-blue-100 text-blue-600 text-sm">
                    <span>Total materi</span>
                    <span class="font-bold">{{ $materi->count() }}</span>
                </div>
            </div>
        </div>

        {{-- JIKA MATERI ADA --}}
        @if ($materi->count() > 0)

            {{-- PENCARIAN --}}
            <div class="px-5 py-5">
                <div class="flex flex-col md:flex-row gap-3">

                    <div class="w-full md:w-64 flex-shrink-0">
                        <select id="searchField"
                                class="w-full h-11 border border-gray-300 rounded-xl px-4 text-sm text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="all">Cari berdasarkan...</option>
                            <option value="kode">Kode Materi</option>
                            <option value="judul">Judul Materi</option>
                            <option value="kelas">Kelas</option>
                            <option value="kategori">Kategori</option>
                        </select>
                    </div>

                    <div class="flex-1">
                        <input type="text"
                               id="searchMateri"
                               placeholder="Masukkan pencarian..."
                               class="w-full h-11 border border-gray-300 rounded-xl px-4 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <button type="button"
                            id="resetSearch"
                            class="h-11 px-4 rounded-xl bg-gray-100 border border-gray-200 text-gray-600 text-sm hover:bg-gray-200 transition">
                        Reset
                    </button>

                </div>
            </div>

            {{-- TABEL --}}
            <div class="overflow-x-auto">
                <table id="materiTable" class="display w-full text-sm">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>KODE MATERI</th>
                            <th>JUDUL MATERI</th>
                            <th>KELAS</th>
                            <th>KATEGORI</th>
                            <th>GAMBAR</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($materi as $item)
                            <tr>
                                {{-- NOMOR --}}
                                <td>
                                    <span class="inline-flex items-center justify-center min-w-8 h-8 rounded-lg bg-gray-100 text-gray-700 font-medium">
                                        {{ $loop->iteration }}
                                    </span>
                                </td>

                                {{-- KODE --}}
                                <td>
                                    <span class="inline-block px-3 py-1.5 rounded-lg bg-purple-50 border border-purple-200 text-purple-700 text-xs font-semibold whitespace-nowrap">
                                        {{ $item->kode_materi }}
                                    </span>
                                </td>

                                {{-- JUDUL --}}
                                <td>
                                    <span class="font-medium text-gray-800">
                                        {{ $item->nama_materi }}
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

                                {{-- GAMBAR --}}
                                <td>
                                    @if ($item->gambar)
                                        <img
                                            src="{{ asset('storage/' . $item->gambar) }}"
                                            alt="{{ $item->nama_materi }}"
                                            class="w-14 h-14 object-cover rounded-lg border border-gray-200"
                                            loading="lazy">
                                    @else
                                        <span class="text-gray-400 text-xs">
                                            Tidak ada gambar
                                        </span>
                                    @endif
                                </td>

                                {{-- AKSI --}}
                                <td>
                                    <div class="flex items-center justify-center gap-2">

                                        {{-- DETAIL --}}
                                        <a href="{{ route('materi.detail', $item) }}"
                                           title="Detail materi"
                                           class="w-8 h-8 flex items-center justify-center rounded-lg border border-blue-200 bg-blue-50 text-blue-600 hover:bg-blue-100">
                                            <i class="fa-solid fa-eye text-xs"></i>
                                        </a>

                                        {{-- EDIT --}}
                                        <a href="{{ route('materi.edit', $item) }}"
                                           title="Edit materi"
                                           class="w-8 h-8 flex items-center justify-center rounded-lg border border-amber-200 bg-amber-50 text-amber-600 hover:bg-amber-100">
                                            <i class="fa-solid fa-pen text-xs"></i>
                                        </a>

                                        {{-- HAPUS --}}
                                        <form action="{{ route('materi.hapus', $item) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus materi ini?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    title="Hapus materi"
                                                    class="w-8 h-8 flex items-center justify-center rounded-lg border border-red-200 bg-red-50 text-red-600 hover:bg-red-100">
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
                        <span class="text-3xl">📚</span>
                    </div>

                    <h3 class="mt-4 text-lg font-bold text-gray-900">
                        Belum Ada Materi
                    </h3>

                    <p class="mt-2 text-sm text-gray-500 leading-6">
                        Belum ada materi pembelajaran yang ditambahkan.
                        Silakan tambahkan materi pertama untuk mulai mengisi
                        pembelajaran BUBA.
                    </p>

                    <a href="{{ route('materi.tambah') }}"
                       class="mt-5 inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl shadow-sm transition">
                        <span class="text-lg">+</span>
                        <span>Tambah Materi Pertama</span>
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
    const tableElement = document.getElementById('materiTable');

    // Jika materi kosong, tidak ada tabel yang perlu dijalankan
    if (!tableElement) {
        return;
    }

    if (typeof DataTable === 'undefined') {
        console.error('DataTables belum dimuat pada layout admin.');
        return;
    }

    // Hindari inisialisasi ulang jika layout sudah membuat tabel
    let table;

    if (DataTable.isDataTable(tableElement)) {
        table = DataTable.isDataTable(tableElement)
            ? new DataTable(tableElement, { retrieve: true })
            : null;
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
                    targets: [5, 6]
                }
            ],

            language: {
                lengthMenu: 'Tampilkan _MENU_ data',
                info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                infoEmpty: 'Tidak ada data materi',
                infoFiltered: '(difilter dari _MAX_ total data)',
                paginate: {
                    next: 'Berikutnya',
                    previous: 'Sebelumnya'
                },
                zeroRecords: 'Data tidak ditemukan',
                emptyTable: 'Belum ada data materi.'
            }
        });
    }

    const searchField = document.getElementById('searchField');
    const searchMateri = document.getElementById('searchMateri');
    const resetSearch = document.getElementById('resetSearch');

    if (!searchField || !searchMateri || !resetSearch || !table) {
        return;
    }

    // Pencarian sesuai kolom yang dipilih
    function cariMateri() {
        const pilihan = searchField.value;
        const kataKunci = searchMateri.value;

        table.search('');
        table.columns().search('');

        if (pilihan === 'all') {
            table.search(kataKunci).draw();
            return;
        }

        const kolom = {
            kode: 1,
            judul: 2,
            kelas: 3,
            kategori: 4
        };

        if (kolom[pilihan] !== undefined) {
            table.column(kolom[pilihan]).search(kataKunci).draw();
        }
    }

    searchMateri.addEventListener('input', cariMateri);
    searchField.addEventListener('change', cariMateri);

    // Reset pencarian
    resetSearch.addEventListener('click', function () {
        searchField.value = 'all';
        searchMateri.value = '';

        table.search('');
        table.columns().search('');
        table.draw();
    });
});
</script>
@endpush