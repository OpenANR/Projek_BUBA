 @extends('layouts.siswa.app')

@section('title', 'Pilih Kategori - BUBA')

@section('content')
<div>
    <div>
        @foreach ($kategori as $item)
            @if ($konten === 'kuis')
                <a href="{{ route('siswa.quis.index', [
                    'kelas' => $dataKelas->id,
                    'kategori' => $item->id
                ]) }}">
                    <button>{{ $item->nama_kategori }}</button>
                </a>
            @else
                <a href="{{ route('siswa.materi', [
                    'konten' => $konten,
                    'kelas' => $dataKelas->nama_kelas,
                    'kategori' => $item->id
                ]) }}">
                    <button>{{ $item->nama_kategori }}</button>
                </a>
            @endif
        @endforeach
    </div>
</div>
@endsection
