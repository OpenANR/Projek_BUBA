@extends('layouts.admin.app')
@section('title', 'Kelola Kategori - BUBA')

@section('content')
<body>
    <h1>KELOLA KATEGORI</h1>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kategori</th>
                <th>Deskripsi</th>
                <th>Kelas</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($categories as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->nama_kategori }}</td>
                    <td>{{ $item->deskripsi }}</td>
                    <td>{{ $item->kelas->nama_kelas }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
@endsection