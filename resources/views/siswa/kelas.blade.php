@extends('layouts.siswa.app')

@section('title', 'Pilih Kelas - BUBA')

@section('content')

<div>
    @foreach ($kelas as $item)
        <div>
            <a href="{{ route('siswa.kategori', ['konten' => $konten, 'kelas' => $item->nama_kelas]) }}">
                <button>{{ $item->nama_kelas }}</button>
            </a>
        </div>
    @endforeach
</div>

@endsection