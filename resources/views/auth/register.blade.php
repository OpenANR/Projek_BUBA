@extends('layouts.auth')

@section('title', 'Registrasi')

@section('content')
    <div class="bg-white/95 backdrop-blur-md rounded-[2.2rem] sm:rounded-[2.6rem] border-[5px] border-white shadow-[0_16px_40px_rgba(30,96,190,0.14)] p-6 sm:p-8 pt-8 relative">

        <!-- Header Banner Melayang (Khas Tampilan Siswa BUBA) -->
        <div class="flex justify-center -mt-14 sm:-mt-16 mb-5">
            <div class="rounded-2xl sm:rounded-[1.8rem] border-[4px] border-white bg-[#1e60be] px-7 py-2.5 sm:px-9 sm:py-3 shadow-[0_8px_20px_rgba(30,96,190,0.3)] transition-transform duration-300 hover:scale-105">
                <h1 class="text-white font-black text-xl sm:text-2xl tracking-wider text-center drop-shadow-[0_2px_4px_rgba(0,0,0,0.3)] font-sans uppercase">
                    DAFTAR AKUN BARU
                </h1>
            </div>
        </div>

        <!-- Salam Pembuka Ramah Anak -->
        <div class="text-center mb-6">
            <p class="text-slate-800 font-extrabold text-base sm:text-lg">
                Selamat Datang Teman Baru! 🎉
            </p>
            <p class="text-xs sm:text-sm font-semibold text-slate-500 mt-0.5">
                Yuk lengkapi formulir di bawah untuk mulai petualangan belajarmu
            </p>
        </div>

        <!-- Form Registrasi -->
        <form method="POST" action="{{ route('register') }}" class="space-y-4 sm:space-y-4.5" id="registerForm">
            @csrf

            <!-- Input Nama Lengkap -->
            <div>
                <label for="name" class="block text-xs sm:text-sm font-extrabold text-slate-700 mb-1.5 pl-1">
                    <span class="inline-flex items-center gap-1.5">
                        <span>🧒</span>
                        <span>Nama Lengkap</span>
                    </span>
                </label>
                <div class="relative flex items-center">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <div class="w-8 h-8 rounded-xl bg-pink-100 border border-pink-200 text-[#d8759c] flex items-center justify-center text-xs shadow-xs">
                            <i class="fa-solid fa-user"></i>
                        </div>
                    </div>
                    <input
                        id="name"
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        autofocus
                        autocomplete="name"
                        placeholder="contoh: Nabila Putri"
                        class="w-full pl-13 pr-4 py-3 sm:py-3.5 bg-slate-50/90 hover:bg-white focus:bg-white border-2 border-slate-200 focus:border-[#2490df] rounded-2xl text-sm sm:text-base text-slate-800 placeholder-slate-400 font-semibold transition-all duration-200 shadow-xs focus:ring-4 focus:ring-sky-100 outline-none"
                    />
                </div>
                @error('name')
                    <div class="flex items-center gap-1.5 text-xs font-bold text-rose-500 mt-1.5 pl-2 animate-buba-wiggle">
                        <i class="fa-solid fa-circle-exclamation text-rose-500"></i>
                        <span>{{ $message }}</span>
                    </div>
                @enderror
            </div>

            <!-- Input Email -->
            <div>
                <label for="email" class="block text-xs sm:text-sm font-extrabold text-slate-700 mb-1.5 pl-1">
                    <span class="inline-flex items-center gap-1.5">
                        <span>📧</span>
                        <span>Alamat Email</span>
                    </span>
                </label>
                <div class="relative flex items-center">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <div class="w-8 h-8 rounded-xl bg-sky-100 border border-sky-200 text-[#1e60be] flex items-center justify-center text-xs shadow-xs">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                    </div>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autocomplete="username"
                        placeholder="contoh: nabila@sekolah.id"
                        class="w-full pl-13 pr-4 py-3 sm:py-3.5 bg-slate-50/90 hover:bg-white focus:bg-white border-2 border-slate-200 focus:border-[#2490df] rounded-2xl text-sm sm:text-base text-slate-800 placeholder-slate-400 font-semibold transition-all duration-200 shadow-xs focus:ring-4 focus:ring-sky-100 outline-none"
                    />
                </div>
                @error('email')
                    <div class="flex items-center gap-1.5 text-xs font-bold text-rose-500 mt-1.5 pl-2 animate-buba-wiggle">
                        <i class="fa-solid fa-circle-exclamation text-rose-500"></i>
                        <span>{{ $message }}</span>
                    </div>
                @enderror
            </div>

            <!-- Input Password -->
            <div>
                <label for="password" class="block text-xs sm:text-sm font-extrabold text-slate-700 mb-1.5 pl-1">
                    <span class="inline-flex items-center gap-1.5">
                        <span>🔑</span>
                        <span>Kata Sandi</span>
                    </span>
                </label>
                <div class="relative flex items-center">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <div class="w-8 h-8 rounded-xl bg-amber-100 border border-amber-200 text-amber-700 flex items-center justify-center text-xs shadow-xs">
                            <i class="fa-solid fa-lock"></i>
                        </div>
                    </div>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        autocomplete="new-password"
                        placeholder="Minimal 8 karakter..."
                        class="w-full pl-13 pr-12 py-3 sm:py-3.5 bg-slate-50/90 hover:bg-white focus:bg-white border-2 border-slate-200 focus:border-[#2490df] rounded-2xl text-sm sm:text-base text-slate-800 placeholder-slate-400 font-semibold transition-all duration-200 shadow-xs focus:ring-4 focus:ring-sky-100 outline-none"
                    />
                    <!-- Tombol Tampilkan Password -->
                    <button
                        type="button"
                        onclick="togglePassword('password', 'toggleRegisterPasswordIcon')"
                        class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 active:scale-90 transition-all cursor-pointer"
                        title="Tampilkan / Sembunyikan Password"
                        aria-label="Tampilkan / Sembunyikan Password">
                        <i id="toggleRegisterPasswordIcon" class="fa-regular fa-eye text-sm"></i>
                    </button>
                </div>
                @error('password')
                    <div class="flex items-center gap-1.5 text-xs font-bold text-rose-500 mt-1.5 pl-2 animate-buba-wiggle">
                        <i class="fa-solid fa-circle-exclamation text-rose-500"></i>
                        <span>{{ $message }}</span>
                    </div>
                @enderror
            </div>

            <!-- Konfirmasi Password (Tersinkronisasi otomatis) -->
            <input type="hidden" name="password_confirmation" id="password_confirmation">

            <!-- Tombol Submit 3D (Kid Game Style - Aksen Hijau/Biru) -->
            <div class="pt-2">
                <button
                    type="submit"
                    class="btn-buba-3d group relative w-full flex items-center justify-center gap-2.5 py-3.5 sm:py-4 px-6 bg-gradient-to-b from-[#71bf4f] via-[#5db139] to-[#459623] hover:from-[#65b244] hover:to-[#3b841c] text-white font-black text-base sm:text-lg uppercase tracking-wider rounded-2xl border-[3px] border-white shadow-[0_6px_0_#2e6a14] hover:shadow-[0_4px_0_#2e6a14] active:shadow-none active:translate-y-[6px] transition-all duration-150 cursor-pointer overflow-hidden"
                >
                    <!-- Kilauan Efek Shimmer -->
                    <span class="pointer-events-none absolute inset-0 w-1/2 h-full bg-white/20 -skew-x-12 -translate-x-full group-hover:translate-x-[300%] transition-transform duration-1000"></span>

                    <span class="drop-shadow-[0_2px_4px_rgba(0,0,0,0.3)] flex items-center gap-2 font-sans">
                        DAFTAR SEKARANG
                        <i class="fa-solid fa-user-plus text-base transition-transform duration-200 group-hover:scale-110"></i>
                    </span>
                </button>
            </div>

            <!-- Pembatas / Divider Lembut -->
            <div class="relative flex items-center justify-center pt-2">
                <div class="border-t border-slate-200 w-full"></div>
                <span class="bg-white px-3 text-[11px] font-black uppercase text-slate-400 absolute">Atau</span>
            </div>

            <!-- Pilihan Masuk Akun yang Sudah Ada -->
            <div class="pt-2 text-center">
                <p class="text-xs sm:text-sm text-slate-600 font-bold mb-2">
                    Sudah memiliki akun BUBA?
                </p>
                <a
                    href="{{ route('login') }}"
                    class="inline-flex items-center justify-center gap-2 w-full py-2.5 px-4 rounded-2xl border-2 border-sky-300 bg-sky-50 hover:bg-sky-100 active:scale-95 text-[#1e60be] font-black text-xs sm:text-sm uppercase tracking-wide transition-all duration-200 shadow-xs hover:shadow-sm"
                >
                    <span>🔑</span>
                    <span>Masuk ke Akun Saya</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>
        </form>
    </div>
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
