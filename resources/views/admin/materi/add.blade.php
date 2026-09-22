{{-- @extends('layouts.development.development') --}}
@section('title', 'Tambah Materi - BUBA')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tambah Materi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen py-8 px-4">
    <div class="max-w-3xl mx-auto">
        {{-- Card --}}
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            {{-- Header --}}
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-5">
                <h1 class="text-2xl font-bold text-white">➕ Tambah Materi</h1>
                <p class="text-blue-100 text-sm mt-1">Isi form di bawah untuk menambahkan materi baru</p>
            </div>

            <div class="p-6">
                {{-- Error Alert --}}
                @if ($errors->any())
                    <div class="mb-5 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded">
                        <p class="font-semibold mb-1">Terjadi kesalahan:</p>
                        <ul class="list-disc list-inside text-sm space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('materi.kirim') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf

                    {{-- Nama Materi --}}
                    <div>
                        <label for="nama_materi" class="block text-sm font-semibold text-gray-700 mb-1">
                            Nama Materi <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama_materi" id="nama_materi"
                               value="{{ old('nama_materi') }}" required
                               placeholder="Masukkan nama materi"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                    </div>

                    {{-- Kategori --}}
                    <div>
                        <label for="kategori_id" class="block text-sm font-semibold text-gray-700 mb-1">
                            Kategori <span class="text-red-500">*</span>
                        </label>
                        <select name="kategori_id" id="kategori_id" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition bg-white">
                            <option value="" disabled {{ old('kategori_id') ? '' : 'selected' }}>--- Pilih Kategori ---</option>
                            @foreach ($kategori as $item)
                                <option value="{{ $item->id }}" {{ old('kategori_id') == $item->id ? 'selected' : '' }}>
                                    {{ $item->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Isi Materi --}}
                    <div>
                        <label for="isi_materi" class="block text-sm font-semibold text-gray-700 mb-1">
                            Isi Materi <span class="text-red-500">*</span>
                        </label>
                        <textarea name="isi_materi" id="isi_materi" cols="30" rows="8" required
                                  placeholder="Tulis isi materi di sini..."
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition resize-y">{{ old('isi_materi') }}</textarea>
                    </div>

                    {{-- Upload Grid --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label for="gambar" class="block text-sm font-semibold text-gray-700 mb-1">Gambar</label>
                            <input type="file" name="gambar" id="gambar"
                                   class="w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 border border-gray-300 rounded-lg cursor-pointer">
                        </div>
                        <div>
                            <label for="audio" class="block text-sm font-semibold text-gray-700 mb-1">Audio</label>
                            <input type="file" name="audio" id="audio"
                                   class="w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 border border-gray-300 rounded-lg cursor-pointer">
                        </div>
                    </div>

                    {{-- Buttons --}}
                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                        <a href="{{ route('materi.index') }}"
                           class="px-4 py-2 text-sm font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition">
                            Batal
                        </a>
                        <button type="submit"
                                class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded-lg shadow transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Kirim
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>