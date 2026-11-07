@extends('layouts.status')

@section('title', '404 - Halaman Tidak Ditemukan | BUBA')

@php
    $user = auth()->user();
    $role = $user?->role;

    if (in_array($role, ['guru', 'admin'], true)) {
        $homeUrl = route('admin.dashboard');
        $homeLabel = 'Kembali ke Dashboard';
    } elseif ($role === 'siswa') {
        $homeUrl = route('siswa.splash');
        $homeLabel = 'Kembali ke Beranda';
    } else {
        $homeUrl = url('/');
        $homeLabel = 'Kembali ke Beranda';
    }
@endphp

@section('content')
    <div class="badge">
        <span class="badge-dot"></span>
        Error 404
    </div>

    <div class="error-art" aria-hidden="true">
        <svg class="mini-cloud" viewBox="0 0 100 60" fill="currentColor">
            <path
                d="M20 50 C10 50 2 42 2 32 C2 24 8 18 16 16 C19 8 28 2 38 2 C49 2 58 8 62 18 C66 16 70 16 74 18 C83 19 90 26 90 35 C90 43 83 50 74 50 Z" />
        </svg>

        <div class="digit digit--sky">4</div>
        <div class="digit digit--yellow">
            0
            <span class="digit-spark">&#9733;</span>
        </div>
        <div class="digit digit--pink">4</div>
    </div>

    <h1 class="title">Ups! Halaman Ini <span class="marker">Tersesat</span></h1>

    <p class="lead">
        Sepertinya halaman yang kamu cari sudah dipindahkan, dihapus, atau alamatnya salah ketik.
        Tenang saja, petualangan belajar di <strong>BUBA</strong> masih bisa dilanjutkan dari beranda.
    </p>

    <div class="actions">
        <a class="btn btn-primary" href="{{ $homeUrl }}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                <path
                    d="M11.47 3.84a.75.75 0 011.06 0l8.69 8.69a.75.75 0 11-1.06 1.06l-.72-.72V19.5a2.25 2.25 0 01-2.25 2.25h-3a.75.75 0 01-.75-.75v-4.5h-3v4.5a.75.75 0 01-.75.75h-3A2.25 2.25 0 014.5 19.5v-6.63l-.72.72a.75.75 0 11-1.06-1.06l8.69-8.69z" />
            </svg>
            {{ $homeLabel }}
        </a>

        <button class="btn btn-secondary" type="button" onclick="history.back()">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2.4" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12l7.5-7.5M3 12h18" />
            </svg>
            Halaman Sebelumnya
        </button>
    </div>

    <p class="note">
        <span aria-hidden="true">&#128269;</span>
        Kode kesalahan 404 &mdash; periksa kembali alamat halaman yang kamu tuju.
    </p>
@endsection
