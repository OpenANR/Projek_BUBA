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

    {{-- NOTIFIKASI SUKSES --}}
    @if (session('success'))
        <div class="mb-5 px-4 py-3 rounded-xl bg-green-50 border border-green-200">
            <div class="flex items-start gap-2">
                <span class="text-green-600">✓</span>
                <div>
                    <p class="font-semibold text-sm text-green-800">Berhasil</p>
                    <p class="text-sm text-green-700 mt-1">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    {{-- NOTIFIKASI ERROR --}}
    @if (session('error'))
        <div class="mb-5 px-4 py-3 rounded-xl bg-red-50 border border-red-200">
            <p class="font-semibold text-sm text-red-800">Terjadi Kesalahan</p>
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
                            <th class="kolom-pilih" hidden>PILIH</th>
                            <th>NO</th>
                            <th>NAMA ANAK</th>
                            <th>KELAS</th>
                            <th>KATEGORI</th>
                            <th>BENAR</th>
                            <th>SALAH</th>
                            <th>NILAI</th>
                            <th>BINTANG</th>
                            <th>TANGGAL</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($rewards as $reward)
                            <tr>
                                {{-- CHECKBOX --}}
                                <td class="kolom-pilih" hidden>
                                    <input
                                        type="checkbox"
                                        class="checkbox-reward"
                                        value="{{ $reward->id }}"
                                    >
                                </td>

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
                                        <span class="text-gray-400 text-xs">Belum ada kelas</span>
                                    @endif
                                </td>

                                {{-- KATEGORI --}}
                                <td>
                                    @if ($reward->quis && $reward->quis->kategori)
                                        <span class="inline-block px-3 py-1.5 rounded-lg bg-amber-50 border border-amber-200 text-amber-700 text-xs whitespace-nowrap">
                                            {{ $reward->quis->kategori->nama_kategori }}
                                        </span>
                                    @else
                                        <span class="text-gray-400 text-xs">Belum ada kategori</span>
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
                                    <span data-search="{{ $reward->jumlah_bintang }}"
                                          class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg {{ $reward->jumlah_bintang > 0 ? 'bg-yellow-50 border border-yellow-200 text-yellow-700' : 'bg-gray-50 border border-gray-200 text-gray-500' }} text-xs font-semibold whitespace-nowrap">
                                        ⭐ {{ $reward->jumlah_bintang }}
                                    </span>
                                </td>

                                {{-- TANGGAL --}}
                                <td>
                                    <span class="text-gray-600 text-xs whitespace-nowrap">
                                        {{ $reward->created_at?->format('d-m-Y H:i') ?? '-' }}
                                    </span>
                                </td>

                                {{-- AKSI --}}
                                <td>
                                    <div class="flex items-center justify-center gap-2">
                                        <form action="{{ route('reward.hapus', $reward->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus hasil reward anak ini?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    title="Hapus Reward"
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

            {{-- MODE NORMAL --}}
            <div id="modeNormalReward" class="px-5 py-4 border-t border-gray-200 flex justify-end">
                <button type="button"
                        id="btnEditReward"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold transition">
                    <i class="fa-solid fa-pen"></i>
                    Edit
                </button>
            </div>

            {{-- MODE EDIT --}}
            <div id="modeEditReward" class="hidden px-5 py-4 border-t border-gray-200">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <div class="flex flex-wrap items-center gap-3">
                        <label class="inline-flex items-center gap-2 text-sm font-medium text-gray-700 cursor-pointer">
                            <input type="checkbox" id="pilihSemuaReward"
                                   class="w-4 h-4 accent-blue-600">
                            Pilih Semua
                        </label>

                        <span id="jumlahDipilihReward" class="text-sm text-gray-500">
                            0 data dipilih
                        </span>
                    </div>

                    <div class="flex flex-wrap items-center gap-2">
                        <button type="button"
                                id="btnBatalReward"
                                class="px-4 py-2.5 rounded-xl bg-gray-100 border border-gray-200 text-gray-700 text-sm font-semibold hover:bg-gray-200">
                            Batal
                        </button>

                        <button type="button"
                                id="btnHapusSemuaReward"
                                class="px-4 py-2.5 rounded-xl bg-red-50 border border-red-200 text-red-600 text-sm font-semibold hover:bg-red-100">
                            <i class="fa-solid fa-trash-can mr-1"></i>
                            Hapus Semua
                        </button>

                        <button type="button"
                                id="btnHapusPilihanReward"
                                disabled
                                class="px-4 py-2.5 rounded-xl bg-red-600 text-white text-sm font-semibold hover:bg-red-700 disabled:opacity-40 disabled:cursor-not-allowed">
                            <i class="fa-solid fa-trash mr-1"></i>
                            Hapus
                        </button>
                    </div>
                </div>
            </div>

            {{-- FORM HAPUS TERPILIH --}}
            <form id="formHapusPilihanReward"
                  action="{{ route('reward.hapusTerpilih') }}"
                  method="POST"
                  class="hidden">
                @csrf
                @method('DELETE')
                <div id="inputIdsReward"></div>
            </form>

            {{-- FORM HAPUS SEMUA --}}
            <form id="formHapusSemuaReward"
                  action="{{ route('reward.hapusSemua') }}"
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
                        <span class="text-3xl">⭐</span>
                    </div>

                    <h3 class="mt-4 text-lg font-bold text-gray-900">Belum Ada Reward</h3>

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
    const tableElement = document.getElementById('rewardTable');

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
                targets: [0, 1, 10]
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

    const searchField = document.getElementById('searchField');
    const searchReward = document.getElementById('searchReward');
    const resetSearch = document.getElementById('resetSearch');

    const modeNormal = document.getElementById('modeNormalReward');
    const modeEdit = document.getElementById('modeEditReward');
    const btnEdit = document.getElementById('btnEditReward');
    const btnBatal = document.getElementById('btnBatalReward');
    const pilihSemua = document.getElementById('pilihSemuaReward');
    const jumlahDipilih = document.getElementById('jumlahDipilihReward');
    const btnHapus = document.getElementById('btnHapusPilihanReward');
    const btnHapusSemua = document.getElementById('btnHapusSemuaReward');

    const formPilihan = document.getElementById('formHapusPilihanReward');
    const formSemua = document.getElementById('formHapusSemuaReward');
    const inputIds = document.getElementById('inputIdsReward');

    let editAktif = false;

    function semuaCheckbox() {
        return Array.from(table.rows().nodes()).flatMap(row =>
            Array.from(row.querySelectorAll('.checkbox-reward'))
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
    document.querySelectorAll('#rewardTable .kolom-pilih').forEach(kolom => {
        kolom.hidden = !aktif;
    });

    document.getElementById('modeNormalReward').classList.toggle('hidden', aktif);
    document.getElementById('modeEditReward').classList.toggle('hidden', !aktif);

    if (!aktif) {
        document.querySelectorAll('.checkbox-reward').forEach(checkbox => {
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
        if (event.target.classList.contains('checkbox-reward')) {
            perbaruiPilihan();
        }
    });

    table.on('draw', function () {
        document.querySelectorAll('#rewardTable .kolom-pilih').forEach(kolom => {
            kolom.style.display = editAktif ? 'table-cell' : 'none';
        });

        perbaruiPilihan();
    });

    btnHapus.addEventListener('click', function () {
        const ids = semuaCheckbox()
            .filter(checkbox => checkbox.checked)
            .map(checkbox => checkbox.value);

        if (ids.length === 0) {
            alert('Pilih minimal satu reward terlebih dahulu.');
            return;
        }

        if (!confirm('Yakin ingin menghapus ' + ids.length + ' hasil reward yang dipilih?')) {
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

        if (!confirm('PERINGATAN! Yakin ingin menghapus SELURUH hasil reward anak? Semua riwayat nilai dan bintang akan dihapus.')) {
            return;
        }

        formSemua.submit();
    });

    const kolom = {
        nama: 2,
        kelas: 3,
        kategori: 4,
        nilai: 7,
        bintang: 8,
        tanggal: 9
    };

    function cariReward() {
        const pilihan = searchField.value;
        const kataKunci = searchReward.value.trim();

        table.search('');
        table.columns().search('');

        if (pilihan === 'all') {
            table.search(kataKunci).draw();
            return;
        }

        if (kolom[pilihan] !== undefined) {
            table.column(kolom[pilihan]).search(kataKunci).draw();
        }
    }

    searchReward.addEventListener('input', cariReward);
    searchField.addEventListener('change', cariReward);

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
