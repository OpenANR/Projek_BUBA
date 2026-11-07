<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>@yield('title', 'Welcome to BUBA')</title>
    @include('layouts.partials.favicon')
</head>

@php
    $realtimePage = match (true) {
        request()->routeIs('siswa.kelas') => 'kelas-siswa',
        request()->routeIs('siswa.kategori') => 'kategori-siswa',
        request()->routeIs('siswa.materi') => 'materi-siswa',
        request()->routeIs('siswa.showMateri') => 'materi-detail',
        request()->routeIs('siswa.kuis') => 'kuis-siswa',
        request()->routeIs('siswa.reward') => 'reward-siswa',
        default => '',
    };

    // $dataMateri bisa berupa Model (halaman detail) atau Collection (halaman daftar materi).
    // Collection tidak punya property "id", jadi harus dicek dulu agar tidak error.
    $realtimeResourceId = isset($dataMateri) && $dataMateri instanceof \Illuminate\Database\Eloquent\Model
        ? $dataMateri->getKey()
        : '';
@endphp

<body data-realtime-page="{{ $realtimePage }}"
      data-realtime-role="{{ auth()->user()?->role }}"
      data-realtime-user-id="{{ auth()->id() }}"
      data-realtime-resource-id="{{ $realtimeResourceId }}">
    <div class="w-full min-h-screen overflow-x-hidden">
        <main>
            {{-- <img src="{{ asset('images/backgroundSplash.png') }}" alt="" class="w-full h-full object-cover"> --}}
            @yield('content')
        </main>
    </div>
</body>

</html>
