@extends('layouts.siswa.app')

@section('title', 'Pilih Materi - BUBA')

@section('content')

   @foreach ($dataMateri as $item)
       <table>
        <tr>
            <td>Kode Materi</td>
            <td>:</td>
            <td>{{ $item->kode_materi }}</td>
        </tr>
        <tr>
            <td>Nama Materi</td>
            <td>:</td>
            <td>{{ $item->nama_materi }}</td>
        </tr>
        <tr>
            <td>Gambar : </td>
            <td>:</td>
            <td>
                <img src="{{ asset('storage/' . $item->gambar) }}" alt="">
            </td>
        </tr>
       </table>
   @endforeach

@endsection
