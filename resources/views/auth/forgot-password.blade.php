@extends('layouts.auth')

@section('title', 'Lupa Kata Sandi')

@section('content')
    <div class="bg-white/95 backdrop-blur-md rounded-[2.2rem] sm:rounded-[2.6rem] border-[5px] border-white shadow-[0_16px_40px_rgba(30,96,190,0.14)] p-6 sm:p-8 pt-8 relative">

        <!-- Header Banner Melayang (Khas Tampilan Siswa BUBA) -->
        <div class="flex justify-center -mt-14 sm:-mt-16 mb-5">
            <div class="rounded-2xl sm:rounded-[1.8rem] border-[4px] border-white bg-[#1e60be] px-7 py-2.5 sm:px-9 sm:py-3 shadow-[0_8px_20px_rgba(30,96,190,0.3)] transition-transform duration-300 hover:scale-105">
                <h1 class="text-white font-black text-xl sm:text-2xl tracking-wider text-center drop-shadow-[0_2px_4px_rgba(0,0,0,0.3)] font-sans uppercase">
                    LUPA KATA SANDI
                </h1>
            </div>
        </div>

        <!-- Salam Pembuka Ramah Anak -->
        <div class="text-center mb-6">
            <p class="text-slate-800 font-extrabold text-base sm:text-lg">
                Tenang, Kami Bantu! 🔐
            </p>
            <p class="text-xs sm:text-sm font-semibold text-slate-500 mt-0.5">
                Masukkan email akunmu, kami kirimkan tautan untuk membuat sandi baru
            </p>
        </div>

        <!-- Flash Message Status -->
        @if (session('status'))
            <div class="mb-5 flex items-center gap-2.5 p-3.5 rounded-2xl bg-emerald-50 border-2 border-emerald-300 text-emerald-800 text-xs sm:text-sm font-bold shadow-xs animate-buba-pop">
                <span class="text-base">✅</span>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        <!-- Form Lupa Kata Sandi -->
        <form method="POST" action="{{ route('password.email') }}" class="space-y-4 sm:space-y-4.5">
            @csrf

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
                        autofocus
                        autocomplete="username"
                        placeholder="contoh: budi@sekolah.id"
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

            <!-- Tombol Submit 3D (Kid Game Style) -->
            <div class="pt-2">
                <button
                    type="submit"
                    class="btn-buba-3d group relative w-full flex items-center justify-center gap-2.5 py-3.5 sm:py-4 px-6 bg-gradient-to-b from-[#3ba2f4] via-[#2490df] to-[#1e60be] hover:from-[#2e9cf0] hover:to-[#174fa1] text-white font-black text-base sm:text-lg uppercase tracking-wider rounded-2xl border-[3px] border-white shadow-[0_6px_0_#144a8b] hover:shadow-[0_4px_0_#144a8b] active:shadow-none active:translate-y-[6px] transition-all duration-150 cursor-pointer overflow-hidden"
                >
                    <!-- Kilauan Efek Shimmer -->
                    <span class="pointer-events-none absolute inset-0 w-1/2 h-full bg-white/20 -skew-x-12 -translate-x-full group-hover:translate-x-[300%] transition-transform duration-1000"></span>

                    <span class="drop-shadow-[0_2px_4px_rgba(0,0,0,0.3)] flex items-center gap-2 font-sans">
                        KIRIM LINK RESET
                        <i class="fa-solid fa-paper-plane text-base transition-transform duration-200 group-hover:translate-x-1"></i>
                    </span>
                </button>
            </div>

            <!-- Pembatas / Divider Lembut -->
            <div class="relative flex items-center justify-center pt-2">
                <div class="border-t border-slate-200 w-full"></div>
                <span class="bg-white px-3 text-[11px] font-black uppercase text-slate-400 absolute">Atau</span>
            </div>

            <!-- Kembali ke Halaman Masuk -->
            <div class="pt-2 text-center">
                <p class="text-xs sm:text-sm text-slate-600 font-bold mb-2">
                    Ingat kata sandimu sekarang?
                </p>
                <a
                    href="{{ route('login') }}"
                    class="inline-flex items-center justify-center gap-2 w-full py-2.5 px-4 rounded-2xl border-2 border-sky-300 bg-sky-50 hover:bg-sky-100 active:scale-95 text-[#1e60be] font-black text-xs sm:text-sm uppercase tracking-wide transition-all duration-200 shadow-xs hover:shadow-sm"
                >
                    <span>🔑</span>
                    <span>Kembali ke Halaman Masuk</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>
        </form>
    </div>
@endsection
