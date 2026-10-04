@extends('layouts.siswa.app')

@section('title', 'Pilih Konten - BUBA')

@section('content')

<div>
    <div>
        <a href="{{ route('siswa.kelas', ['konten' => 'materi']) }}">
            <button>MATERI</button>
        </a>
    </div>
    <div>
        <a href="{{ route('siswa.kelas', ['konten' => 'kuis']) }}">
            <button>KUIS</button>
        </a>
    </div>
</div>

@endsection