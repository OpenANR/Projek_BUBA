@extends('layouts.siswa.app')

@section('title', 'Welcome')

@section('content')

    <!-- Container Utama (Fullscreen) -->
    <div class="relative w-full h-screen flex flex-col justify-center items-center">

        <!-- 1. Background Image (Ilustrasi Utama) -->
        <!-- Ganti 'images/splash-bg.png' dengan nama file gambarmu di folder public -->
        <img src="{{ asset('images/backgroundSplash.png') }}" alt="BUBA Splash Screen"
            class="absolute inset-0 w-full h-full object-cover z-0">

        <!-- 2. Top Left Icons (Pengaturan & Info) -->
        <div class="absolute top-6 left-6 z-20 flex flex-col gap-4">
            <!-- Tombol Pengaturan -->
            <button
                class="w-16 h-16 rounded-full border-2 border-white bg-white/20 backdrop-blur-sm flex justify-center items-center text-white hover:bg-white/40 transition duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="w-8 h-8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </button>

            <!-- Tombol Info -->
            <button
                class="w-16 h-16 rounded-full border-2 border-white bg-white/20 backdrop-blur-sm flex justify-center items-center text-white hover:bg-white/40 transition duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="w-8 h-8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                </svg>
            </button>   
        </div>

        <!-- 3. Logo BUBA (Center) -->
        <!-- Atur posisi top dan ukuran width sesuai kebutuhan -->
        <div class="absolute top-[10%] left-1/2 -translate-x-1/2 z-20 w-[70%] max-w-md md:max-w-xl">
            <img src="{{ asset('images/logoBuba.png') }}" alt="Logo BUBA" class="w-full h-auto drop-shadow-2xl">
        </div>

        <!-- 3. Tombol MULAI (Center Bottom) -->
        <!-- Menggunakan absolute positioning agar tepat berada di tengah bawah ilustrasi -->
        <div class="absolute bottom-[20%] z-20">
            <a href="{{ route('siswa.konten') }}"
                class="group relative flex items-center justify-center gap-4 bg-[#69bdfa] hover:bg-[#58a8e5] border-4 border-white rounded-[2rem] px-10 py-4 shadow-[0_8px_0_rgba(0,0,0,0.1)] transition-all duration-300 hover:scale-105 hover:shadow-[0_4px_0_rgba(0,0,0,0.1)] hover:translate-y-1">
                <!-- Icon Play -->
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                    class="w-12 h-12 text-white drop-shadow-md">
                    <path fill-rule="evenodd"
                        d="M4.5 5.653c0-1.426 1.529-2.33 2.779-1.643l11.54 6.348c1.295.712 1.295 2.573 0 3.285L7.28 19.991c-1.25.687-2.779-.217-2.779-1.643V5.653z"
                        clip-rule="evenodd" />
                </svg>
                <!-- Text MULAI -->
                <span class="text-white text-4xl font-extrabold tracking-widest drop-shadow-md font-sans">
                    MULAI
                </span>
            </a>
        </div>
    </div>
@endsection
