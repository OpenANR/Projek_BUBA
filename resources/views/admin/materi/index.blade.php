{{-- @extends('layouts.development.development') --}}
@section('title', 'Kelola Materi - BUBA')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kelola Materi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen py-8 px-4">
    <div class="max-w-6xl mx-auto">
        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">📚 Tabel Materi</h1>
                <p class="text-gray-500 text-sm mt-1">Kelola daftar materi pembelajaran BUBA</p>
            </div>
            <a href="{{ route('materi.tambah') }}"
               class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg shadow transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Materi
            </a>
        </div>

        {{-- Alert Success --}}
        @if (session('success') || session('succes'))
            <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm">
                {{ session('success') ?? session('succes') }}
            </div>
        @endif

        {{-- Table Card --}}
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kode</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Judul</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kategori</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Gambar</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse ($materi as $item)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $loop->iteration }}</td>
                                <td class="px-4 py-3 text-sm font-mono text-gray-800">{{ $item->kode_materi }}</td>
                                <td class="px-4 py-3 text-sm font-medium text-gray-800">{{ $item->nama_materi }}</td>
                                <td class="px-4 py-3 text-sm">
                                    @if ($item->kategori)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $item->kategori->nama_kategori }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-200 text-gray-600">
                                            Tidak ada Kategori
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    @if ($item->gambar)
                                        <img src="{{ asset('storage/' . $item->gambar) }}"
                                             alt="{{ $item->nama_materi }}"
                                             class="w-20 h-20 object-cover rounded-lg border border-gray-200 shadow-sm">
                                    @else
                                        <span class="text-xs text-gray-400 italic">Tidak ada gambar</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <a href="{{ route('materi.edit', $item) }}"
                                           class="inline-flex items-center gap-1 bg-yellow-500 hover:bg-yellow-600 text-white text-xs font-semibold px-3 py-1.5 rounded-md shadow-sm transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Edit
                                        </a>
                                        <a href="{{ route('materi.detail', $item) }}"
                                           class="inline-flex items-center gap-1 bg-blue-500 hover:bg-blue-600 text-white text-xs font-semibold px-3 py-1.5 rounded-md shadow-sm transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            Selengkapnya
                                        </a>
                                        <form action="{{ route('materi.hapus', $item) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    onclick="return confirm('Yakin ingin menghapus materi ini?')"
                                                    class="inline-flex items-center gap-1 bg-red-500 hover:bg-red-600 text-white text-xs font-semibold px-3 py-1.5 rounded-md shadow-sm transition">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-10 text-center text-gray-400 italic">
                                    Belum ada data materi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>