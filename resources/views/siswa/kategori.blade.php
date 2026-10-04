@extends('layouts.siswa.app')

@section('title', 'Pilih Kategori - BUBA')

@section('content')

    <div>
        <div>
            @foreach ($kategori as $item)
                <a
                    href="{{ route('siswa.materi', ['konten' => $konten, 'kelas' => $dataKelas, 'kategori' => $item->id]) }}">
                    <button>{{ $item->nama_kategori }}</button>
                </a>
            @endforeach
        </div>
    </div>

@endsection
