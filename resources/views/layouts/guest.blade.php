@extends('layouts.auth')

@section('content')
    {{ $slot ?? '' }}
    @yield('content')
@endsection
