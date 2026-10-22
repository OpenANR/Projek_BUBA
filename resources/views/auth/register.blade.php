@extends('layouts.auth')

@section('title', 'Registrasi')

@section('content')
    <!-- Header Form -->
    <div class="text-center mb-8">
        <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-wider uppercase">
            REGISTRASI
        </h2>
        <p class="text-[11px] sm:text-xs font-semibold text-gray-500 tracking-wider uppercase mt-1">
            SILAHKAN MEMBUAT AKUN BARU TERLEBIH DAHULU
        </p>
    </div>

    <!-- Form Registrasi -->
    <form method="POST" action="{{ route('register') }}" class="space-y-4" id="registerForm">
        @csrf

        <!-- Nama Lengkap -->
        <div>
            <div class="relative flex items-center">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <rect x="3" y="4" width="18" height="16" rx="2"/>
                        <line x1="7" y1="8" x2="7.01" y2="8" stroke-width="2.5" stroke-linecap="round"/>
                        <line x1="11" y1="8" x2="17" y2="8"/>
                        <line x1="11" y1="12" x2="17" y2="12"/>
                        <line x1="7" y1="16" x2="17" y2="16"/>
                    </svg>
                </div>
                <input
                    id="name"
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    autofocus
                    autocomplete="name"
                    placeholder="Nama Lengkap..."
                    class="w-full pl-11 pr-4 py-3 bg-white border border-gray-300 rounded-lg text-sm sm:text-base text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#2490df] focus:border-transparent transition shadow-xs"
                />
            </div>
            @error('name')
                <p class="text-xs text-red-500 mt-1 pl-1">{{ $message }}</p>
            @enderror
        </div>

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
                    autocomplete="new-password"
                    placeholder="Password..."
                    class="w-full pl-11 pr-4 py-3 bg-white border border-gray-300 rounded-lg text-sm sm:text-base text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#2490df] focus:border-transparent transition shadow-xs"
                />
            </div>
            @error('password')
                <p class="text-xs text-red-500 mt-1 pl-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Konfirmasi Password (Hidden agar tetap aman disinkronkan) -->
        <input type="hidden" name="password_confirmation" id="password_confirmation">

        <!-- Tombol Submit -->
        <div class="pt-2">
            <button
                type="submit"
                class="w-full py-3 px-4 bg-[#2490df] hover:bg-[#1d7bc2] active:bg-[#186aab] text-white font-bold text-sm sm:text-base uppercase tracking-wider rounded-lg shadow-sm transition duration-150 ease-in-out cursor-pointer text-center"
            >
                DAFTAR
            </button>
        </div>

        <!-- Footer Link Login -->
        <div class="pt-4 text-center">
            <p class="text-xs sm:text-sm text-gray-700 font-medium">
                Sudah mempunyai akun ?
                <a href="{{ route('login') }}" class="text-[#2490df] font-bold hover:underline">
                    Login
                </a>
            </p>
        </div>
    </form>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const passwordInput = document.getElementById('password');
        const confirmationInput = document.getElementById('password_confirmation');
        const form = document.getElementById('registerForm');

        if (passwordInput && confirmationInput) {
            const syncPassword = () => {
                confirmationInput.value = passwordInput.value;
            };
            passwordInput.addEventListener('input', syncPassword);
            passwordInput.addEventListener('change', syncPassword);
            if (form) {
                form.addEventListener('submit', syncPassword);
            }
        }
    });
</script>
@endpush
