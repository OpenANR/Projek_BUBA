@extends('layouts.admin.app')

@section('content')
    @php
        // Variabel tambahan bersifat opsional: kalau belum dikirim dari controller, tampil 0.
        $stats = [
            ['label' => 'Total Kelas',    'value' => $total_kelas ?? 0,    'icon' => 'fa-school',       'tone' => 'amber', 'href' => url('admin/kelas')],
            ['label' => 'Total Kategori', 'value' => $total_kategori ?? 0, 'icon' => 'fa-layer-group',  'tone' => 'teal',  'href' => url('admin/kategori')],
            ['label' => 'Total Materi',   'value' => $total_materi ?? 0,   'icon' => 'fa-book-open',    'tone' => 'blue',  'href' => url('admin/materi')],
            ['label' => 'Total Kuis',     'value' => $total_kuis ?? 0,     'icon' => 'fa-pen-to-square', 'tone' => 'pink',  'href' => url('admin/quiz')],
        ];

        $tones = [
            'blue'  => ['bg' => 'bg-blue-50',  'text' => 'text-blue-600',  'bar' => 'bg-blue-500'],
            'pink'  => ['bg' => 'bg-pink-50',  'text' => 'text-pink-600',  'bar' => 'bg-pink-500'],
            'teal'  => ['bg' => 'bg-teal-50',  'text' => 'text-teal-600',  'bar' => 'bg-teal-500'],
            'amber' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-600', 'bar' => 'bg-amber-500'],
        ];

        $actions = [
            ['label' => 'Tambah Materi',   'desc' => 'Buat materi belajar baru',     'icon' => 'fa-book-open',    'tone' => 'blue',  'href' => url('admin/materi')],
            ['label' => 'Tambah Kuis',     'desc' => 'Susun soal latihan',           'icon' => 'fa-pen-to-square', 'tone' => 'pink',  'href' => url('admin/quiz')],
            ['label' => 'Tambah Kategori', 'desc' => 'Kelompokkan materi',           'icon' => 'fa-layer-group',  'tone' => 'teal',  'href' => url('admin/kategori')],
            ['label' => 'Kelola Reward',   'desc' => 'Atur hadiah untuk siswa',      'icon' => 'fa-star',         'tone' => 'amber', 'href' => url('admin/reward')],
        ];

        $totalKonten = ($total_materi ?? 0) + ($total_kuis ?? 0);
    @endphp

    {{-- Sapaan --}}
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-800">Halo, Admin!</h1>
        <p class="text-slate-500 mt-1">Selamat datang di Dashboard Buba. Kelola semua fitur pembelajaran dengan mudah di sini.</p>
    </div>

    {{-- Kartu statistik --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-8">
        @foreach ($stats as $s)
            @php $t = $tones[$s['tone']]; @endphp
            <a href="{{ $s['href'] }}"
               class="group bg-white p-5 rounded-2xl border border-slate-200 shadow-sm hover:border-blue-300 hover:shadow-md transition flex items-center gap-4 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500">
                <div class="w-12 h-12 shrink-0 rounded-xl {{ $t['bg'] }} {{ $t['text'] }} flex items-center justify-center">
                    <i class="fas {{ $s['icon'] }} text-lg"></i>
                </div>
                <div class="min-w-0">
                    <p class="text-sm text-slate-500">{{ $s['label'] }}</p>
                    <p class="text-2xl font-bold text-slate-800 leading-tight">{{ $s['value'] }}</p>
                </div>
                <i class="fas fa-chevron-right ml-auto text-xs text-slate-300 group-hover:text-blue-500 transition"></i>
            </a>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Aksi cepat --}}
        <section class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <h2 class="text-lg font-semibold text-slate-800">Aksi cepat</h2>
            <p class="text-sm text-slate-500 mb-5">Pintasan untuk pekerjaan yang paling sering dilakukan.</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach ($actions as $a)
                    @php $t = $tones[$a['tone']]; @endphp
                    <a href="{{ $a['href'] }}"
                       class="flex items-center gap-4 p-4 rounded-xl border border-slate-200 hover:bg-slate-50 hover:border-blue-300 transition focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500">
                        <div class="w-10 h-10 shrink-0 rounded-lg {{ $t['bg'] }} {{ $t['text'] }} flex items-center justify-center">
                            <i class="fas {{ $a['icon'] }}"></i>
                        </div>
                        <div>
                            <p class="font-medium text-slate-800">{{ $a['label'] }}</p>
                            <p class="text-sm text-slate-500">{{ $a['desc'] }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>

        {{-- Komposisi konten --}}
        <section class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <h2 class="text-lg font-semibold text-slate-800">Komposisi konten</h2>
            <p class="text-sm text-slate-500 mb-5">Perbandingan materi dan kuis yang tersedia.</p>

            @if ($totalKonten > 0)
                @php
                    $pctMateri = round((($total_materi ?? 0) / $totalKonten) * 100);
                    $pctKuis = 100 - $pctMateri;
                @endphp
                <div class="flex h-3 rounded-full overflow-hidden bg-slate-100 mb-5" role="img"
                     aria-label="Materi {{ $pctMateri }} persen, kuis {{ $pctKuis }} persen">
                    <div class="bg-blue-500" style="width: {{ $pctMateri }}%"></div>
                    <div class="bg-pink-500" style="width: {{ $pctKuis }}%"></div>
                </div>

                <ul class="space-y-3 text-sm">
                    <li class="flex items-center justify-between">
                        <span class="flex items-center gap-2 text-slate-600">
                            <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span> Materi
                        </span>
                        <span class="font-semibold text-slate-800">{{ $total_materi ?? 0 }} ({{ $pctMateri }}%)</span>
                    </li>
                    <li class="flex items-center justify-between">
                        <span class="flex items-center gap-2 text-slate-600">
                            <span class="w-2.5 h-2.5 rounded-full bg-pink-500"></span> Kuis
                        </span>
                        <span class="font-semibold text-slate-800">{{ $total_kuis ?? 0 }} ({{ $pctKuis }}%)</span>
                    </li>
                </ul>
            @else
                <div class="text-center py-6">
                    <div class="w-12 h-12 mx-auto mb-3 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <p class="font-medium text-slate-800">Belum ada konten</p>
                    <p class="text-sm text-slate-500 mt-1">Mulai dengan menambahkan materi pertama.</p>
                    <a href="{{ url('admin/materi') }}"
                       class="inline-block mt-4 px-4 py-2 rounded-lg bg-blue-600 text-white text-sm font-medium hover:bg-blue-700 transition">
                        Tambah materi
                    </a>
                </div>
            @endif
        </section>
    </div>
@endsection