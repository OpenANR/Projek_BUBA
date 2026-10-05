@extends('layouts.admin.app')
@section('title', 'Tambah Kategori - BUBA')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="bg-linear-to-r from-blue-600 to-indigo-600 px-6 py-5">
                <h1 class="text-2xl font-bold text-white">Tambah Kategori</h1>
                <p class="text-blue-100 text-sm mt-1">Isi form untuk menambahkan kategori baru</p>
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

                <form action="{{ route('kategori.kirim') }}" method="POST" class="space-y-5">
                    @csrf
                    <div>
                        <label for="nama_kategori" class="block text-sm font-semibold text-gray-700 mb-1">
                            Nama Kategori <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama_kategori" id="nama_kategori" value="{{ old('nama_kategori') }}"
                            required maxlength="30" placeholder="Contoh: Kategori-1"
                            class="w-full px-4 py-2 text-black border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Kelas
                        </label>

                        <select name="kelas_id" id="kelas_id"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-800 bg-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none"
                            required>

                            <option value="">
                                -- Pilih Kelas --
                            </option>

                            @foreach ($kelas as $item)
                                <option value="{{ $item->id }}" {{ old('kelas_id', $item->kelas_id) == $item->id ? 'selected' : '' }}>

                                    {{ $item->nama_kelas }}

                                </option>
                            @endforeach

                        </select>
                    </div>

                     <div>
                        <label for="deskripsi" class="block text-sm font-semibold text-gray-700 mb-1">
                            Deskripsi <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="deskripsi" id="deskripsi" value="{{ old('deskripsi') }}"
                            required maxlength="30" placeholder="Contoh: Deskripsi kategori"
                            class="w-full px-4 py-2 text-black border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                        <a href="{{ route('kategori.index') }}"
                            class="px-4 py-2 text-sm font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition">
                            Batal
                        </a>
                        <button type="submit"
                            class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded-lg shadow transition">
                            <i class="fas fa-check" aria-hidden="true"></i>
                            Simpan Kategori
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
            const input = document.getElementById('nama_kelas');
            const button = input.form.querySelector('button[type="submit"]');

            function updateButtonState() {
                const cursorPosition = input.selectionStart;
                const sanitizedValue = input.value.replace(/[^A-Za-z0-9-]/g, '');

                if (sanitizedValue !== input.value) {
                    const sanitizedCursorPosition = input.value.slice(0, cursorPosition).replace(/[^A-Za-z0-9-]/g,
                        '').length;
                    input.value = sanitizedValue;
                    input.setSelectionRange(sanitizedCursorPosition, sanitizedCursorPosition);
                }

                const isValid = input.value.length > 0 &&
                    input.value.length <= 10 &&
                    /^[A-Za-z0-9-]+$/.test(input.value);

                button.disabled = !isValid;
                button.classList.toggle('bg-blue-600', isValid);
                button.classList.toggle('hover:bg-blue-700', isValid);
                button.classList.toggle('bg-gray-400', !isValid);
                button.classList.toggle('hover:bg-gray-400', !isValid);
                button.classList.toggle('cursor-not-allowed', !isValid);
            }

            input.addEventListener('input', updateButtonState);
            updateButtonState();
        });
    </script>
@endpush
