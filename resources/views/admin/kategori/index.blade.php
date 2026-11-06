@extends('layouts.admin.app')

@section('title', 'Kelola Kategori - BUBA')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5">

    {{-- HEADER --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 flex items-center justify-center rounded-xl bg-blue-100 border border-blue-200">
                <span class="text-lg">🏷️</span>
            </div>

            <div>
                <h1 class="text-xl font-bold text-gray-900">Kelola Kategori</h1>
                <p class="text-sm text-gray-500 mt-1">
                    Kelola daftar kategori pembelajaran BUBA.
                </p>
            </div>
        </div>

        <a href="{{ route('kategori.tambah') }}"
           class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-3 rounded-xl shadow-sm transition">
            <span class="text-lg">+</span>
            <span>Tambah Kategori</span>
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
    @if (session('error'))
        <div class="mb-5 px-4 py-3 rounded-xl bg-red-50 border border-red-200">
            <p class="font-semibold text-sm text-red-800">Gagal</p>
            <p class="text-sm text-red-700 mt-1">
                {{ session('error') }}
            </p>
        </div>
    @endif

    {{-- KARTU DAFTAR KATEGORI --}}
    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">

        {{-- HEADER KARTU --}}
        <div class="px-5 py-5 border-b border-gray-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <h2 class="text-lg font-bold text-gray-900">
                        Daftar Kategori
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">
                        Kategori yang telah ditambahkan akan ditampilkan di sini.
                    </p>
                </div>

                <div class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-blue-50 border border-blue-100 text-blue-600 text-sm">
                    <span>Total kategori</span>
                    <span class="font-bold">{{ $kategori->count() }}</span>
                </div>
            </div>
        </div>

        {{-- JIKA KATEGORI ADA --}}
        @if ($kategori->count() > 0)

            {{-- PENCARIAN --}}
            <div class="px-5 py-5">
                <div class="flex flex-col md:flex-row gap-3">

                    <div class="w-full md:w-64 flex-shrink-0">
                        <select id="searchField"
                                class="w-full h-11 border border-gray-300 rounded-xl px-4 text-sm text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="all">Cari berdasarkan...</option>
                            <option value="nama">Nama Kategori</option>
                            <option value="kelas">Kelas</option>
                            <option value="deskripsi">Deskripsi</option>
                        </select>
                    </div>

                    <div class="flex-1">
                        <input type="text"
                               id="searchKategori"
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
                <table id="kategoriTable" class="display w-full text-sm">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NAMA KATEGORI</th>
                            <th>KELAS</th>
                            <th>DESKRIPSI</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($kategori as $item)
                            <tr>
                                {{-- NOMOR --}}
                                <td>
                                    <span class="inline-flex items-center justify-center min-w-8 h-8 rounded-lg bg-gray-100 text-gray-700 font-medium">
                                        {{ $loop->iteration }}
                                    </span>
                                </td>

                                {{-- NAMA KATEGORI --}}
                                <td>
                                    <span class="font-medium text-gray-800">
                                        {{ $item->nama_kategori }}
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

                                {{-- DESKRIPSI --}}
                                <td>
                                    <span class="text-gray-700 line-clamp-2 max-w-md"
                                          title="{{ $item->deskripsi }}">
                                        {{ $item->deskripsi }}
                                    </span>
                                </td>

                                {{-- AKSI --}}
                                <td>
                                    <div class="flex items-center justify-center gap-2">

                                        {{-- EDIT --}}
                                        <a href="{{ route('kategori.edit', $item) }}"
                                           title="Edit kategori"
                                           class="w-8 h-8 flex items-center justify-center rounded-lg border border-amber-200 bg-amber-50 text-amber-600 hover:bg-amber-100">
                                            <i class="fa-solid fa-pen text-xs"></i>
                                        </a>

                                        {{-- HAPUS --}}
                                        <form action="{{ route('kategori.hapus', $item) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    title="Hapus kategori"
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
                        <span class="text-3xl">🏷️</span>
                    </div>

                    <h3 class="mt-4 text-lg font-bold text-gray-900">
                        Belum Ada Kategori
                    </h3>

                    <p class="mt-2 text-sm text-gray-500 leading-6">
                        Belum ada kategori pembelajaran yang ditambahkan.
                        Silakan tambahkan kategori pertama untuk mulai mengisi
                        pembelajaran BUBA.
                    </p>

                    <a href="{{ route('kategori.tambah') }}"
                       class="mt-5 inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl shadow-sm transition">
                        <span class="text-lg">+</span>
                        <span>Tambah Kategori Pertama</span>
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
    const tableElement = document.getElementById('kategoriTable');

    // Jika kategori kosong, tidak ada tabel yang perlu dijalankan
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
        table = new DataTable(tableElement, { retrieve: true });
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
                    targets: [4]
                }
            ],

            language: {
                lengthMenu: 'Tampilkan _MENU_ data',
                info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                infoEmpty: 'Tidak ada data kategori',
                infoFiltered: '(difilter dari _MAX_ total data)',
                paginate: {
                    next: 'Berikutnya',
                    previous: 'Sebelumnya'
                },
                zeroRecords: 'Data tidak ditemukan',
                emptyTable: 'Belum ada data kategori.'
            }
        });
    }

    const searchField = document.getElementById('searchField');
    const searchKategori = document.getElementById('searchKategori');
    const resetSearch = document.getElementById('resetSearch');

    if (!searchField || !searchKategori || !resetSearch || !table) {
        return;
    }

    // Pencarian sesuai kolom yang dipilih
    function cariKategori() {
        const pilihan = searchField.value;
        const kataKunci = searchKategori.value;

        table.search('');
        table.columns().search('');

        if (pilihan === 'all') {
            table.search(kataKunci).draw();
            return;
        }

        const kolom = {
            nama: 1,
            kelas: 2,
            deskripsi: 3
        };

        if (kolom[pilihan] !== undefined) {
            table.column(kolom[pilihan]).search(kataKunci).draw();
        }
    }

    searchKategori.addEventListener('input', cariKategori);
    searchField.addEventListener('change', cariKategori);

    // Reset pencarian
    resetSearch.addEventListener('click', function () {
        searchField.value = 'all';
        searchKategori.value = '';

        table.search('');
        table.columns().search('');
        table.draw();
    });
});
</script>
@endpush
