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

        <div>
            <a href="{{ route('kuis.tambah') }}"
               class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-3 rounded-xl shadow-sm transition">
                <span class="text-lg">+</span>
                <span>Tambah Kuis</span>
            </a>
        </div>
    </div>

    {{-- PESAN SUKSES --}}
    @if (session('success'))
        <div class="mb-5 px-4 py-3 rounded-xl bg-green-50 border border-green-200">
            <p class="font-semibold text-sm text-green-800">Berhasil</p>
            <p class="text-sm text-green-700 mt-1">{{ session('success') }}</p>
        </div>
    @endif

    {{-- PESAN ERROR --}}
    @if (session('error'))
        <div class="mb-5 px-4 py-3 rounded-xl bg-red-50 border border-red-200">
            <p class="font-semibold text-sm text-red-800">Terjadi kesalahan</p>
            <p class="text-sm text-red-700 mt-1">{{ session('error') }}</p>
        </div>
    @endif

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
                    <h2 class="text-lg font-bold text-gray-900">Daftar Kuis</h2>
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
                            <th class="kolom-pilih" hidden>PILIH</th>
                            <th>NO</th>
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
                                {{-- CHECKBOX --}}
                                <td class="kolom-pilih" hidden>
                                <input
                                    type="checkbox"
                                    class="checkbox-kuis"
                                    value="{{ $item->id }}"
                                >
                                </td>

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
                                        <span class="text-gray-400 text-xs">Belum ada kelas</span>
                                    @endif
                                </td>

                                {{-- KATEGORI --}}
                                <td>
                                    @if ($item->kategori)
                                        <span class="inline-block px-3 py-1.5 rounded-lg bg-amber-50 border border-amber-200 text-amber-700 text-xs whitespace-nowrap">
                                            {{ $item->kategori->nama_kategori }}
                                        </span>
                                    @else
                                        <span class="text-gray-400 text-xs">Belum ada kategori</span>
                                    @endif
                                </td>

                                {{-- AKSI --}}
                                <td>
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('kuis.detail', $item->kode_kuis) }}"
                                           title="Detail Kuis"
                                           style="background-color: #eff6ff !important; color: #2563eb !important;"
                                           class="w-9 h-9 flex items-center justify-center rounded-lg border border-blue-200 transition hover:bg-blue-100">
                                            <i class="fa-solid fa-eye text-xs"></i>
                                        </a>

                                        <a href="{{ route('kuis.edit', $item->kode_kuis) }}"
                                           title="Edit Kuis"
                                           style="background-color: #fffbeb !important; color: #d97706 !important;"
                                           class="w-9 h-9 flex items-center justify-center rounded-lg border border-amber-200 transition hover:bg-amber-100">
                                            <i class="fa-solid fa-pen text-xs"></i>
                                        </a>

                                        <form action="{{ route('kuis.hapus', $item->kode_kuis) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus pertanyaan kuis ini beserta hasil reward terkait?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    title="Hapus Kuis"
                                                    style="background-color: #fef2f2 !important; color: #dc2626 !important;"
                                                    class="w-9 h-9 flex items-center justify-center rounded-lg border border-red-200 transition hover:bg-red-100">
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

            {{-- TOMBOL MODE NORMAL --}}
            <div id="modeNormalKuis" class="px-5 py-4 border-t border-gray-200 flex justify-end">
                <button type="button"
                        id="btnEditKuis"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold transition">
                    <i class="fa-solid fa-pen"></i>
                    Edit
                </button>
            </div>

            {{-- TOMBOL MODE EDIT --}}
            <div id="modeEditKuis" class="hidden px-5 py-4 border-t border-gray-200">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <div class="flex flex-wrap items-center gap-3">
                        <label class="inline-flex items-center gap-2 text-sm font-medium text-gray-700 cursor-pointer">
                            <input type="checkbox" id="pilihSemuaKuis"
                                   class="w-4 h-4 accent-blue-600">
                            Pilih Semua
                        </label>

                        <span id="jumlahDipilihKuis" class="text-sm text-gray-500">
                            0 data dipilih
                        </span>
                    </div>

                    <div class="flex flex-wrap items-center gap-2">
                        <button type="button"
                                id="btnBatalKuis"
                                class="px-4 py-2.5 rounded-xl bg-gray-100 border border-gray-200 text-gray-700 text-sm font-semibold hover:bg-gray-200">
                            Batal
                        </button>

                        <button type="button"
                                id="btnHapusSemuaKuis"
                                class="px-4 py-2.5 rounded-xl bg-red-50 border border-red-200 text-red-600 text-sm font-semibold hover:bg-red-100">
                            <i class="fa-solid fa-trash-can mr-1"></i>
                            Hapus Semua
                        </button>

                        <button type="button"
                                id="btnHapusPilihanKuis"
                                disabled
                                class="px-4 py-2.5 rounded-xl bg-red-600 text-white text-sm font-semibold hover:bg-red-700 disabled:opacity-40 disabled:cursor-not-allowed">
                            <i class="fa-solid fa-trash mr-1"></i>
                            Hapus
                        </button>
                    </div>
                </div>
            </div>

            {{-- FORM HAPUS TERPILIH --}}
            <form id="formHapusPilihanKuis"
                  action="{{ route('kuis.hapusTerpilih') }}"
                  method="POST"
                  class="hidden">
                @csrf
                @method('DELETE')
                <div id="inputIdsKuis"></div>
            </form>

            {{-- FORM HAPUS SEMUA --}}
            <form id="formHapusSemuaKuis"
                  action="{{ route('kuis.hapusSemua') }}"
                  method="POST"
                  class="hidden">
                @csrf
                @method('DELETE')
            </form>

        @else

            {{-- TAMPILAN KOSONG --}}
            <div class="px-5 py-12 text-center">
                <div class="max-w-sm mx-auto">
                    <div class="mx-auto w-16 h-16 flex items-center justify-center rounded-xl bg-blue-50 border border-blue-100">
                        <span class="text-3xl">📝</span>
                    </div>

                    <h3 class="mt-4 text-lg font-bold text-gray-900">Belum Ada Kuis</h3>

                    <p class="mt-2 text-sm text-gray-500 leading-6">
                        Belum ada pertanyaan kuis yang ditambahkan.
                        Silakan tambahkan kuis pertama untuk mulai mengisi kuis BUBA.
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

@push('styles')
<style>
    .kolom-pilih[hidden] {
    display: none !important;
    }

    .kolom-pilih:not([hidden]) {
        display: table-cell !important;
        text-align: center;
    }

    .kolom-pilih {
        display: none;
        text-align: center !important;
    }

    .kolom-pilih input {
        cursor: pointer;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const tableElement = document.getElementById('quisTable');

    if (!tableElement || typeof DataTable === 'undefined') {
        return;
    }

    const table = new DataTable(tableElement, {
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
                targets: [0, 1, 6]
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

    const searchField = document.getElementById('searchField');
    const searchKuis = document.getElementById('searchKuis');
    const resetSearch = document.getElementById('resetSearch');

    const modeNormal = document.getElementById('modeNormalKuis');
    const modeEdit = document.getElementById('modeEditKuis');
    const btnEdit = document.getElementById('btnEditKuis');
    const btnBatal = document.getElementById('btnBatalKuis');
    const pilihSemua = document.getElementById('pilihSemuaKuis');
    const jumlahDipilih = document.getElementById('jumlahDipilihKuis');
    const btnHapus = document.getElementById('btnHapusPilihanKuis');
    const btnHapusSemua = document.getElementById('btnHapusSemuaKuis');

    const formPilihan = document.getElementById('formHapusPilihanKuis');
    const formSemua = document.getElementById('formHapusSemuaKuis');
    const inputIds = document.getElementById('inputIdsKuis');

    let editAktif = false;

    function semuaCheckbox() {
        return Array.from(table.rows().nodes()).flatMap(row =>
            Array.from(row.querySelectorAll('.checkbox-kuis'))
        );
    }

    function perbaruiPilihan() {
        const checkbox = semuaCheckbox();
        const terpilih = checkbox.filter(item => item.checked).length;

        jumlahDipilih.textContent = terpilih + ' data dipilih';
        btnHapus.disabled = terpilih === 0;

        pilihSemua.checked = checkbox.length > 0 && terpilih === checkbox.length;
        pilihSemua.indeterminate = terpilih > 0 && terpilih < checkbox.length;
    }

    function aturModeEdit(aktif) {
    document.querySelectorAll('#quisTable .kolom-pilih').forEach(kolom => {
        kolom.hidden = !aktif;
    });

    document.getElementById('modeNormalKuis').classList.toggle('hidden', aktif);
    document.getElementById('modeEditKuis').classList.toggle('hidden', !aktif);

    if (!aktif) {
        document.querySelectorAll('.checkbox-kuis').forEach(checkbox => {
            checkbox.checked = false;
        });
    }

    perbaruiPilihan();
    }

    btnEdit.addEventListener('click', function () {
        aturModeEdit(true);
    });

    btnBatal.addEventListener('click', function () {
        aturModeEdit(false);
    });

    pilihSemua.addEventListener('change', function () {
        semuaCheckbox().forEach(checkbox => {
            checkbox.checked = pilihSemua.checked;
        });

        perbaruiPilihan();
    });

    tableElement.addEventListener('change', function (event) {
        if (event.target.classList.contains('checkbox-kuis')) {
            perbaruiPilihan();
        }
    });

    table.on('draw', function () {
        document.querySelectorAll('#quisTable .kolom-pilih').forEach(kolom => {
            kolom.style.display = editAktif ? 'table-cell' : 'none';
        });

        perbaruiPilihan();
    });

    btnHapus.addEventListener('click', function () {
        const ids = semuaCheckbox()
            .filter(checkbox => checkbox.checked)
            .map(checkbox => checkbox.value);

        if (ids.length === 0) {
            alert('Pilih minimal satu kuis terlebih dahulu.');
            return;
        }

        if (!confirm('Yakin ingin menghapus ' + ids.length + ' kuis yang dipilih beserta hasil reward terkait?')) {
            return;
        }

        inputIds.innerHTML = '';

        ids.forEach(id => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'ids[]';
            input.value = id;
            inputIds.appendChild(input);
        });

        formPilihan.submit();
    });

    btnHapusSemua.addEventListener('click', function () {
        semuaCheckbox().forEach(checkbox => checkbox.checked = true);
        pilihSemua.checked = true;
        perbaruiPilihan();

        if (!confirm('PERINGATAN! Yakin ingin menghapus SELURUH data kuis beserta semua hasil reward anak? Data yang dihapus tidak dapat dikembalikan.')) {
            return;
        }

        formSemua.submit();
    });

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
            kode: 2,
            pertanyaan: 3,
            kelas: 4,
            kategori: 5
        };

        if (kolom[pilihan] !== undefined) {
            table.column(kolom[pilihan]).search(kataKunci).draw();
        }
    }

    searchKuis.addEventListener('input', cariKuis);
    searchField.addEventListener('change', cariKuis);

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
