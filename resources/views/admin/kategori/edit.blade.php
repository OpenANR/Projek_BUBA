@extends('layouts.admin.app')
@section('title', 'Edit Kategori - BUBA')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="bg-linear-to-r from-yellow-500 to-orange-500 px-6 py-5">
                <h1 class="text-2xl font-bold text-white">Edit Kategori</h1>
                <p class="text-yellow-100 text-sm mt-1">Edit kategori {{ $kategori->nama_kategori }}</p>
            </div>

            <div class="p-6">
                @if ($errors->any())
                    <div class="mb-5 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded" role="alert">
                        <p class="font-semibold mb-1">Terjadi kesalahan:</p>
                        <ul class="list-disc list-inside text-sm space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('kategori.update', $kategori->id) }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT')
                    <div>
                        <label for="nama_kategori" class="block text-sm font-semibold text-gray-700 mb-1">
                            Nama Kategori <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama_kategori" id="nama_kategori"
                            value="{{ old('nama_kategori', $kategori->nama_kategori) }}"
                            required maxlength="30" placeholder="Contoh: Kategori-1"
                            class="w-full px-4 py-2 text-black border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 outline-none transition">

                        <span id="char_count_kategori" class="text-xs font-medium text-gray-500">0/30</span>
                    </div>

                    <div>
                        <label for="kelas_id" class="block text-sm font-semibold text-gray-700 mb-2">
                            Kelas <span class="text-red-500">*</span>
                        </label>

                        <select name="kelas_id" id="kelas_id"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-800 bg-white focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 outline-none"
                            required>
                            <option value="">-- Pilih Kelas --</option>
                            @foreach ($kelas as $item)
                                <option value="{{ $item->id }}" {{ old('kelas_id', $kategori->kelas_id) == $item->id ? 'selected' : '' }}>
                                    {{ $item->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="deskripsi" class="block text-sm font-semibold text-gray-700 mb-1">
                            Deskripsi <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="deskripsi" id="deskripsi"
                            value="{{ old('deskripsi', $kategori->deskripsi) }}"
                            required maxlength="50" placeholder="Contoh: Deskripsi kategori"
                            class="w-full px-4 py-2 text-black border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 outline-none transition">

                        <span id="char_count_deskripsi" class="text-xs font-medium text-gray-500">0/50</span>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                        <a href="{{ route('kategori.index') }}"
                            class="px-4 py-2 text-sm font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition">
                            Batal
                        </a>
                        <button type="submit"
                            class="inline-flex items-center gap-2 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-5 py-2 rounded-lg shadow transition">
                            <i class="fas fa-rotate" aria-hidden="true"></i>
                            Update Kategori
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputKategori = document.getElementById('nama_kategori');
            const countKategori = document.getElementById('char_count_kategori');
            const maxKategori = parseInt(inputKategori.getAttribute('maxlength')) || 30;

            const selectKelas = document.getElementById('kelas_id');

            const inputDeskripsi = document.getElementById('deskripsi');
            const countDeskripsi = document.getElementById('char_count_deskripsi');
            const maxDeskripsi = parseInt(inputDeskripsi.getAttribute('maxlength')) || 50;

            const button = inputKategori.form.querySelector('button[type="submit"]');

            function updateButtonState() {
                // Sanitasi Nama Kategori (huruf, angka, spasi, dan tanda hubung)
                const cursorPosition = inputKategori.selectionStart;
                const sanitizedValue = inputKategori.value.replace(/[^A-Za-z0-9 -]/g, '');

                if (sanitizedValue !== inputKategori.value) {
                    const sanitizedCursor = inputKategori.value.slice(0, cursorPosition).replace(/[^A-Za-z0-9 -]/g, '').length;
                    inputKategori.value = sanitizedValue;
                    inputKategori.setSelectionRange(sanitizedCursor, sanitizedCursor);
                }

                // Update indikator jumlah karakter
                const lenKategori = inputKategori.value.length;
                const lenDeskripsi = inputDeskripsi.value.length;

                if (countKategori) {
                    countKategori.textContent = `${lenKategori}/${maxKategori}`;
                }
                if (countDeskripsi) {
                    countDeskripsi.textContent = `${lenDeskripsi}/${maxDeskripsi}`;
                }

                // Validasi semua input wajib
                const isKategoriValid = inputKategori.value.trim().length > 0 && lenKategori <= maxKategori;
                const isKelasValid = selectKelas.value !== '';
                const isDeskripsiValid = inputDeskripsi.value.trim().length > 0 && lenDeskripsi <= maxDeskripsi;

                const isValid = isKategoriValid && isKelasValid && isDeskripsiValid;

                button.disabled = !isValid;
                button.classList.toggle('bg-yellow-500', isValid);
                button.classList.toggle('hover:bg-yellow-600', isValid);
                button.classList.toggle('bg-gray-400', !isValid);
                button.classList.toggle('hover:bg-gray-400', !isValid);
                button.classList.toggle('cursor-not-allowed', !isValid);
            }

            inputKategori.addEventListener('input', updateButtonState);
            selectKelas.addEventListener('change', updateButtonState);
            inputDeskripsi.addEventListener('input', updateButtonState);

            updateButtonState();
        });
    </script>
@endpush