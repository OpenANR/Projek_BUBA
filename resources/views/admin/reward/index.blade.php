@extends('layouts.admin.app')

@section('title', 'Hasil Reward - BUBA')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5">

    {{-- HEADER --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 flex items-center justify-center rounded-xl bg-blue-100 border border-blue-200">
                <span class="text-lg">⭐</span>
            </div>

            <div>
                <h1 class="text-xl font-bold text-gray-900">Hasil Reward</h1>
                <p class="text-sm text-gray-500 mt-1">
                    Lihat hasil pengerjaan kuis dan bintang yang diperoleh anak.
                </p>
            </div>
        </div>
    </div>

    {{-- KARTU DAFTAR REWARD --}}
    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">

        {{-- HEADER KARTU --}}
        <div class="px-5 py-5 border-b border-gray-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <h2 class="text-lg font-bold text-gray-900">
                        Daftar Hasil Reward Anak
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">
                        Hasil pengerjaan kuis dan perolehan bintang anak ditampilkan di sini.
                    </p>
                </div>

                <div class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-blue-50 border border-blue-100 text-blue-600 text-sm">
                    <span>Total reward</span>
                    <span class="font-bold">{{ $rewards->count() }}</span>
                </div>
            </div>
        </div>

        {{-- JIKA DATA REWARD ADA --}}
        @if ($rewards->count() > 0)

            {{-- PENCARIAN --}}
            <div class="px-5 py-5">
                <div class="flex flex-col sm:flex-row gap-3">

                    <select id="searchField"
                            class="sm:w-48 border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-700 bg-white outline-none focus:ring-2 focus:ring-blue-400">
                        <option value="all">Cari berdasarkan...</option>
                        <option value="nama">Nama Anak</option>
                        <option value="kelas">Kelas</option>
                        <option value="kategori">Kategori</option>
                        <option value="nilai">Nilai</option>
                        <option value="bintang">Bintang</option>
                        <option value="tanggal">Tanggal</option>
                    </select>

                    <input type="text"
                           id="searchReward"
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
                <table id="rewardTable" class="display w-full text-sm">

                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NAMA ANAK</th>
                            <th>KELAS</th>
                            <th>KATEGORI</th>
                            <th>BENAR</th>
                            <th>SALAH</th>
                            <th>NILAI</th>
                            <th>BINTANG</th>
                            <th>TANGGAL</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($rewards as $reward)

                            <tr>
                                {{-- NOMOR --}}
                                <td>
                                    <span class="inline-flex items-center justify-center min-w-8 h-8 rounded-lg bg-gray-100 text-gray-700 font-medium">
                                        {{ $loop->iteration }}
                                    </span>
                                </td>

                                {{-- NAMA ANAK --}}
                                <td>
                                    <span class="font-semibold text-gray-800">
                                        {{ $reward->user->name ?? 'Anak tidak ditemukan' }}
                                    </span>
                                </td>

                                {{-- KELAS --}}
                                <td>
                                    @if ($reward->quis && $reward->quis->kelas)
                                        <span class="inline-block px-3 py-1.5 rounded-lg bg-blue-50 border border-blue-200 text-blue-700 text-xs whitespace-nowrap">
                                            {{ $reward->quis->kelas->nama_kelas }}
                                        </span>
                                    @else
                                        <span class="text-gray-400 text-xs">
                                            Belum ada kelas
                                        </span>
                                    @endif
                                </td>

                                {{-- KATEGORI --}}
                                <td>
                                    @if ($reward->quis && $reward->quis->kategori)
                                        <span class="inline-block px-3 py-1.5 rounded-lg bg-amber-50 border border-amber-200 text-amber-700 text-xs whitespace-nowrap">
                                            {{ $reward->quis->kategori->nama_kategori }}
                                        </span>
                                    @else
                                        <span class="text-gray-400 text-xs">
                                            Belum ada kategori
                                        </span>
                                    @endif
                                </td>

                                {{-- BENAR --}}
                                <td>
                                    <span class="inline-flex items-center justify-center min-w-8 px-2 py-1.5 rounded-lg bg-green-50 border border-green-200 text-green-700 text-xs font-semibold">
                                        {{ $reward->jumlah_benar }}
                                    </span>
                                </td>

                                {{-- SALAH --}}
                                <td>
                                    <span class="inline-flex items-center justify-center min-w-8 px-2 py-1.5 rounded-lg bg-red-50 border border-red-200 text-red-700 text-xs font-semibold">
                                        {{ $reward->jumlah_salah }}
                                    </span>
                                </td>

                                {{-- NILAI --}}
                                <td>
                                    <span class="inline-block px-3 py-1.5 rounded-lg bg-purple-50 border border-purple-200 text-purple-700 text-xs font-bold">
                                        {{ $reward->skor }}
                                    </span>
                                </td>

                                {{-- BINTANG --}}
                                <td>
                                    @if ($reward->jumlah_bintang > 0)
                                        <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-yellow-50 border border-yellow-200 text-yellow-700 text-xs font-semibold whitespace-nowrap">
                                            ⭐ {{ $reward->jumlah_bintang }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-gray-50 border border-gray-200 text-gray-500 text-xs">
                                            0 ⭐
                                        </span>
                                    @endif
                                </td>

                                {{-- TANGGAL --}}
                                <td>
                                    <span class="text-gray-600 text-xs whitespace-nowrap">
                                        {{ $reward->created_at->format('d-m-Y H:i') }}
                                    </span>
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
                        <span class="text-3xl">⭐</span>
                    </div>

                    <h3 class="mt-4 text-lg font-bold text-gray-900">
                        Belum Ada Reward
                    </h3>

                    <p class="mt-2 text-sm text-gray-500 leading-6">
                        Belum ada hasil pengerjaan kuis anak.
                        Hasil nilai dan bintang yang diperoleh anak
                        akan ditampilkan di halaman ini.
                    </p>

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

    const tableElement = document.getElementById('rewardTable');

    // Jika data reward kosong, tidak perlu menjalankan DataTables
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
                    targets: [0]
                }
            ],

            language: {
                lengthMenu: 'Tampilkan _MENU_ data',
                info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                infoEmpty: 'Tidak ada data reward',
                infoFiltered: '(difilter dari _MAX_ total data)',
                paginate: {
                    next: 'Berikutnya',
                    previous: 'Sebelumnya'
                },
                zeroRecords: 'Data tidak ditemukan',
                emptyTable: 'Belum ada data reward.'
            }
        });
    }

    const searchField = document.getElementById('searchField');
    const searchReward = document.getElementById('searchReward');
    const resetSearch = document.getElementById('resetSearch');

    if (!searchField || !searchReward || !resetSearch) {
        return;
    }

    // Pencarian berdasarkan kolom
    function cariReward() {

        const pilihan = searchField.value;
        const kataKunci = searchReward.value;

        table.search('');
        table.columns().search('');

        if (pilihan === 'all') {
            table.search(kataKunci).draw();
            return;
        }

        const kolom = {
            nama: 1,
            kelas: 2,
            kategori: 3,
            nilai: 6,
            bintang: 7,
            tanggal: 8
        };

        if (kolom[pilihan] !== undefined) {
            table.column(kolom[pilihan]).search(kataKunci).draw();
        }
    }

    searchReward.addEventListener('input', cariReward);
    searchField.addEventListener('change', cariReward);

    // Reset pencarian
    resetSearch.addEventListener('click', function () {

        searchField.value = 'all';
        searchReward.value = '';

        table.search('');
        table.columns().search('');
        table.draw();

    });

});
</script>
@endpush
