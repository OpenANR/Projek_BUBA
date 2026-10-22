<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Autentikasi') - {{ config('app.name', 'BUBA') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans antialiased text-gray-900 bg-white">
    <div class="min-h-screen flex flex-col lg:flex-row w-full">
        <!-- Sisi Kiri: Visual Branding & Background Ilustrasi -->
        <div class="relative w-full lg:w-[58%] min-h-[380px] lg:min-h-screen flex flex-col justify-between p-6 sm:p-10 lg:p-14 bg-cover bg-center bg-no-repeat overflow-hidden"
             style="background-image: url('{{ asset('images/backgroundAuth.jpg') }}');">
            <!-- Overlay halus untuk kontras -->
            <div class="absolute inset-0 bg-black/5 pointer-events-none"></div>

            <!-- Logo BUBA di pojok kiri atas -->
            <div class="relative z-10">
                <a href="{{ url('/') }}" class="inline-block transition-transform hover:scale-105 duration-200">
                    <img src="{{ asset('images/logoBuba.png') }}" alt="Logo BUBA" class="w-32 sm:w-40 md:w-44 h-auto object-contain drop-shadow-md">
                </a>
            </div>

            <!-- Teks Hero Branding di bagian bawah kiri -->
            <div class="relative z-10 mt-12 lg:mt-auto">
                <h1 class="text-2xl sm:text-4xl lg:text-5xl font-black text-white uppercase tracking-wide leading-tight drop-shadow-[0_2px_4px_rgba(0,0,0,0.5)]">
                    BELAJAR, BERMAIN,<br>
                    BERKEMBANG
                </h1>
                <p class="text-white text-xs sm:text-sm md:text-base font-medium mt-2 sm:mt-3 max-w-lg leading-relaxed drop-shadow-[0_1px_3px_rgba(0,0,0,0.5)]">
                    Aplikasi Pembelajaran Interaktif Untuk Anak Usia Dini berbasis Website &amp; Mobile.
                </p>
            </div>
        </div>

        <!-- Sisi Kanan: Form Autentikasi -->
        <div class="w-full lg:w-[42%] flex flex-col justify-center items-center p-6 sm:p-10 lg:p-12 bg-white min-h-[460px] lg:min-h-screen">
            <div class="w-full max-w-[380px]">
                @yield('content')
            </div>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
