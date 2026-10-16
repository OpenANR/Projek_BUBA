@extends('layouts.auth')

@section('title', 'Login')

@section('content')
    <!-- Status Sesi (Flash Message) -->
    @if (session('status'))
        <div class="mb-4 text-sm font-medium text-green-600 bg-green-50 p-3 rounded-lg border border-green-200">
            {{ session('status') }}
        </div>
    @endif

    <!-- Header Form -->
    <div class="text-center mb-8">
        <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-wider uppercase">
            LOGIN
        </h2>
        <p class="text-[11px] sm:text-xs font-semibold text-gray-500 tracking-wider uppercase mt-1">
            SILAHKAN LOGIN UNTUK MASUK KE DALAM APLIKASI
        </p>
    </div>

    <!-- Form Login -->
    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <div class="relative flex items-center">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <rect x="3" y="5" width="18" height="14" rx="2"/>
                        <polyline points="3 7 12 13 21 7"/>
                    </svg>
                </div>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="E-mail..."
                    class="w-full pl-11 pr-4 py-3 bg-white border border-gray-300 rounded-lg text-sm sm:text-base text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#2490df] focus:border-transparent transition shadow-xs"
                />
            </div>
            @error('email')
                <p class="text-xs text-red-500 mt-1 pl-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <div class="relative flex items-center">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="7.5" cy="15.5" r="4.5"/>
                        <path d="M10.8 12.2L20 3m-3 0l3 3m-5 1l3 3"/>
                    </svg>
                </div>
                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    placeholder="Password..."
                    class="w-full pl-11 pr-4 py-3 bg-white border border-gray-300 rounded-lg text-sm sm:text-base text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#2490df] focus:border-transparent transition shadow-xs"
                />
            </div>
            @error('password')
                <p class="text-xs text-red-500 mt-1 pl-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Tombol Submit -->
        <div class="pt-2">
            <button
                type="submit"
                class="w-full py-3 px-4 bg-[#2490df] hover:bg-[#1d7bc2] active:bg-[#186aab] text-white font-bold text-sm sm:text-base uppercase tracking-wider rounded-lg shadow-sm transition duration-150 ease-in-out cursor-pointer text-center"
            >
                DAFTAR
            </button>
        </div>

        <!-- Footer Link Registrasi -->
        <div class="pt-4 text-center">
            <p class="text-xs sm:text-sm text-gray-700 font-medium">
                Belum mempunyai akun ?
                <a href="{{ route('register') }}" class="text-[#2490df] font-bold hover:underline">
                    Registrasi
                </a>
            </p>
        </div>
    </form>
@endsection
