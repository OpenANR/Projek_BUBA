@extends('layouts.auth')

@section('title', 'Verifikasi Email')

@section('content')
    <div class="bg-white/95 backdrop-blur-md rounded-[2.2rem] sm:rounded-[2.6rem] border-[5px] border-white shadow-[0_16px_40px_rgba(30,96,190,0.14)] p-6 sm:p-8 pt-8 relative">

        <!-- Header Banner Melayang (Khas Tampilan Siswa BUBA) -->
        <div class="flex justify-center -mt-14 sm:-mt-16 mb-5">
            <div class="rounded-2xl sm:rounded-[1.8rem] border-[4px] border-white bg-[#1e60be] px-7 py-2.5 sm:px-9 sm:py-3 shadow-[0_8px_20px_rgba(30,96,190,0.3)] transition-transform duration-300 hover:scale-105">
                <h1 class="text-white font-black text-xl sm:text-2xl tracking-wider text-center drop-shadow-[0_2px_4px_rgba(0,0,0,0.3)] font-sans uppercase">
                    VERIFIKASI EMAIL
                </h1>
            </div>
        </div>

        <!-- Salam Pembuka Ramah Anak -->
        <div class="text-center mb-6">
            <p class="text-slate-800 font-extrabold text-base sm:text-lg">
                Satu Langkah Lagi! 📬
            </p>
            <p class="text-xs sm:text-sm font-semibold text-slate-500 mt-0.5">
                Yuk verifikasi emailmu supaya bisa mulai belajar &amp; bermain
            </p>
        </div>

        <!-- Flash Message Status -->
        @if (session('status') == 'verification-link-sent')
            <div class="mb-5 flex items-center gap-2.5 p-3.5 rounded-2xl bg-emerald-50 border-2 border-emerald-300 text-emerald-800 text-xs sm:text-sm font-bold shadow-xs animate-buba-pop">
                <span class="text-base">✅</span>
                <span>{{ __('Tautan verifikasi baru sudah dikirim ke alamat email yang kamu daftarkan.') }}</span>
            </div>
        @endif

        <!-- Info Verifikasi -->
        <div class="mb-6 flex items-start gap-2.5 p-3.5 rounded-2xl bg-sky-50 border-2 border-sky-200 text-sky-800 text-xs sm:text-sm font-bold shadow-xs">
            <span class="text-base">✉️</span>
            <span>Terima kasih sudah mendaftar! Sebelum mulai, klik tautan verifikasi yang sudah kami kirim ke emailmu. Belum menerima email? Kami siap mengirim ulang.</span>
        </div>

        <!-- Form Kirim Ulang Verifikasi -->
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <button
                    type="submit"
                    class="btn-buba-3d group relative w-full flex items-center justify-center gap-2.5 py-3.5 sm:py-4 px-6 bg-gradient-to-b from-[#71bf4f] via-[#5db139] to-[#459623] hover:from-[#65b244] hover:to-[#3b841c] text-white font-black text-base sm:text-lg uppercase tracking-wider rounded-2xl border-[3px] border-white shadow-[0_6px_0_#2e6a14] hover:shadow-[0_4px_0_#2e6a14] active:shadow-none active:translate-y-[6px] transition-all duration-150 cursor-pointer overflow-hidden"
                >
                    <!-- Kilauan Efek Shimmer -->
                    <span class="pointer-events-none absolute inset-0 w-1/2 h-full bg-white/20 -skew-x-12 -translate-x-full group-hover:translate-x-[300%] transition-transform duration-1000"></span>

                    <span class="drop-shadow-[0_2px_4px_rgba(0,0,0,0.3)] flex items-center gap-2 font-sans">
                        KIRIM ULANG EMAIL
                        <i class="fa-solid fa-paper-plane text-base transition-transform duration-200 group-hover:translate-x-1"></i>
                    </span>
                </button>
            </div>
        </form>

        <!-- Pembatas / Divider Lembut -->
        <div class="relative flex items-center justify-center pt-4">
            <div class="border-t border-slate-200 w-full"></div>
            <span class="bg-white px-3 text-[11px] font-black uppercase text-slate-400 absolute">Atau</span>
        </div>

        <!-- Keluar dari Akun -->
        <div class="pt-2 text-center">
            <p class="text-xs sm:text-sm text-slate-600 font-bold mb-2">
                Ingin masuk dengan akun lain?
            </p>
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button
                    type="submit"
                    class="inline-flex items-center justify-center gap-2 w-full py-2.5 px-4 rounded-2xl border-2 border-rose-300 bg-rose-50 hover:bg-rose-100 active:scale-95 text-rose-600 font-black text-xs sm:text-sm uppercase tracking-wide transition-all duration-200 shadow-xs hover:shadow-sm"
                >
                    <span>🚪</span>
                    <span>Keluar dari Akun</span>
                    <i class="fa-solid fa-arrow-right-from-bracket text-xs"></i>
                </button>
            </form>
        </div>
    </div>
@endsection
