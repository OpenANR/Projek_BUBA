@extends('layouts.admin.app')

@section('title', 'Tambah Siswa - BUBA')

@section('content')

<div class="max-w-4xl mx-auto">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">

        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                Tambah Siswa
            </h1>

            <p class="text-gray-500 mt-1">
                Tambahkan data siswa baru ke sistem BUBA.
            </p>
        </div>

        <a
            href="{{ route('siswa.index') }}"
            class="px-4 py-2 rounded-lg bg-gray-500 text-white hover:bg-gray-600 transition"
        >
            ← Kembali
        </a>

    </div>


    {{-- Error Validasi --}}
    @if ($errors->any())

        <div class="mb-5 p-4 rounded-lg bg-red-100 border border-red-300 text-red-700">

            <ul class="list-disc list-inside">

                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>

    @endif


    {{-- Form --}}
    <div class="bg-white rounded-xl shadow-md p-6">

        <form
            action="{{ route('siswa.kirim') }}"
            method="POST"
        >

            @csrf

            {{-- ========================= --}}
            {{-- NAMA SISWA --}}
            {{-- ========================= --}}
            <div class="mb-5">

                <label
                    for="name"
                    class="block text-sm font-semibold text-gray-700 mb-2"
                >
                    Nama Siswa <span class="text-red-500">*</span>
                </label>

                <input
                    type="text"
                    name="name"
                    id="name"
                    value="{{ old('name') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-800 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none"
                    placeholder="Masukkan nama lengkap siswa..."
                    required
                >

                @error('name')
                    <p class="text-sm text-red-600 mt-2">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- ========================= --}}
            {{-- JENIS KELAMIN --}}
            {{-- ========================= --}}
            <div class="mb-5">

                <label
                    for="jenis_kelamin"
                    class="block text-sm font-semibold text-gray-700 mb-2"
                >
                    Jenis Kelamin <span class="text-red-500">*</span>
                </label>

                <select
                    name="jenis_kelamin"
                    id="jenis_kelamin"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-800 bg-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none"
                    required
                >

                    <option value="" disabled {{ old('jenis_kelamin') ? '' : 'selected' }}>
                        -- Pilih Jenis Kelamin --
                    </option>

                    <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>
                        Laki-Laki
                    </option>

                    <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>
                        Perempuan
                    </option>

                </select>

                @error('jenis_kelamin')
                    <p class="text-sm text-red-600 mt-2">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- ========================= --}}
            {{-- KELAS --}}
            {{-- ========================= --}}
            <div class="mb-5">

                <label
                    for="kelas_id"
                    class="block text-sm font-semibold text-gray-700 mb-2"
                >
                    Kelas <span class="text-red-500">*</span>
                </label>

                <select
                    name="kelas_id"
                    id="kelas_id"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-800 bg-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none"
                    required
                >

                    <option value="" disabled {{ old('kelas_id') ? '' : 'selected' }}>
                        -- Pilih Kelas --
                    </option>

                    @foreach ($dataKelas as $item)

                        <option
                            value="{{ $item->id }}"
                            {{ old('kelas_id') == $item->id ? 'selected' : '' }}
                        >
                            {{ $item->nama_kelas }}
                        </option>

                    @endforeach

                </select>

                @error('kelas_id')
                    <p class="text-sm text-red-600 mt-2">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- ========================= --}}
            {{-- ROLE --}}
            {{-- ========================= --}}
            <div class="mb-5">

                <label
                    for="role"
                    class="block text-sm font-semibold text-gray-700 mb-2"
                >
                    Role <span class="text-red-500">*</span>
                </label>

                <select
                    name="role"
                    id="role"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-800 bg-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none"
                    required
                >

                    <option value="siswa" {{ old('role', 'siswa') == 'siswa' ? 'selected' : '' }}>
                        Siswa
                    </option>

                </select>

                @error('role')
                    <p class="text-sm text-red-600 mt-2">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- ========================= --}}
            {{-- EMAIL --}}
            {{-- ========================= --}}
            <div class="mb-5">

                <label
                    for="email"
                    class="block text-sm font-semibold text-gray-700 mb-2"
                >
                    Email <span class="text-red-500">*</span>
                </label>

                <input
                    type="email"
                    name="email"
                    id="email"
                    value="{{ old('email') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-800 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none"
                    placeholder="Masukkan alamat email siswa..."
                    required
                >

                @error('email')
                    <p class="text-sm text-red-600 mt-2">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- ========================= --}}
            {{-- PASSWORD --}}
            {{-- ========================= --}}
            <div class="mb-6">

                <label
                    for="password"
                    class="block text-sm font-semibold text-gray-700 mb-2"
                >
                    Password <span class="text-red-500">*</span>
                </label>

                <input
                    type="password"
                    name="password"
                    id="password"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-800 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none"
                    placeholder="Masukkan password akun siswa..."
                    required
                >

                <p class="text-xs text-gray-500 mt-2">
                    Password digunakan untuk masuk (login) ke dalam sistem BUBA.
                </p>

                @error('password')
                    <p class="text-sm text-red-600 mt-2">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- ========================= --}}
            {{-- TOMBOL --}}
            {{-- ========================= --}}
            <div class="flex justify-end gap-3 pt-2">

                <a
                    href="{{ route('siswa.index') }}"
                    class="px-5 py-2.5 rounded-lg bg-gray-500 text-white hover:bg-gray-600 transition"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    class="px-5 py-2.5 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition"
                >
                    Simpan Siswa
                </button>

            </div>

        </form>

    </div>

</div>

@endsection