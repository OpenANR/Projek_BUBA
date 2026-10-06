@extends('layouts.siswa.app')

@section('title', 'Pilih Materi - BUBA')

@section('content')

    <div>
        <div>
            @forelse ($materi as $item)
                <a href="{{ route('siswa.showMateri', ['konten' => $konten, 'kelas' => $kelas, 'kategori' => $kategori, 'materi' => $item->kode_materi]) }}">
                    <button>{{ $item->nama_materi }}</button>
                </a>
            @empty
                <div>Materi belum tersedia</div>
            @endforelse

        </div>
    </div>

@endsection
