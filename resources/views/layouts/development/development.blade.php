@extends('layouts.status')

@section('title', 'Halaman Dalam Pengembangan | BUBA')

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
    <div class="badge badge--sky">
        <span class="badge-dot"></span>
        Sedang Dikembangkan
    </div>

    <div class="dev-art" aria-hidden="true">
        <div class="dev-halo"></div>
        <div class="dev-emoji">&#128640;</div>
        <span class="dev-spark dev-spark-1">&#10024;</span>
        <span class="dev-spark dev-spark-2">&#11088;</span>
        <span class="dev-spark dev-spark-3">&#10024;</span>
        <span class="dev-tool">&#128736;&#65039;</span>
    </div>

    <h1 class="title">Halaman Segera <span class="marker">Hadir!</span></h1>

    <p class="lead">
        Tim <strong>BUBA</strong> sedang menyiapkan halaman ini dengan penuh semangat.
        Sebentar lagi kamu bisa belajar dan bermain di sini. Terima kasih sudah menunggu, ya!
    </p>

    <div class="chips" aria-label="Fitur yang sedang disiapkan">
        <span class="chip chip--green">&#128218; Materi</span>
        <span class="chip chip--orange">&#127918; Kuis</span>
        <span class="chip chip--pink">&#127942; Reward</span>
    </div>

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
        <span aria-hidden="true">&#128161;</span>
        Halaman ini belum tersedia. Silakan kembali lagi nanti, ya!
    </p>
@endsection
