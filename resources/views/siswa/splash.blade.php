@extends('layouts.siswa.app')

@section('title', 'Welcome to BUBA')

@section('content')

<div>
    <div>
        <img src="{{ asset('images/logoBuba.png') }}" alt="">
    </div>
    <div>
        <a href="{{ route('siswa.konten') }}">
            <button class="bg-blue-300 p-3 cursor-pointer">MULAI</button>
        </a>
    </div>
</div>

@endsection