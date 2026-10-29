@extends('layouts.siswa.app')

@section('title', 'Selamat Datang - BUBA')

@section('content')

    <!-- Container Utama (Fullscreen Responsif dengan Alpine.js untuk state Popup Info) -->
    <div x-data="{ showInfo: false }"
        class="relative flex h-screen min-h-[600px] w-full flex-col items-center justify-between overflow-x-hidden overflow-y-auto px-4 py-5 select-none sm:overflow-hidden sm:px-6 md:px-8">

        <!-- 1. Background Image (Ilustrasi Utama BUBA) -->
        <img src="{{ asset('images/backgroundSplash.png') }}" alt="BUBA Background"
            class="pointer-events-none absolute inset-0 z-0 h-full w-full select-none object-cover object-bottom">

        <!-- 2. Dekorasi Animasi Mengambang di Langit (Awan & Bintang Berpendar) -->
        <div class="pointer-events-none absolute inset-0 overflow-hidden z-10 select-none">
            <!-- Awan Animasi 1 (Kiri) -->
            <div class="absolute top-[8%] left-[6%] opacity-65 animate-buba-cloud-1 hidden sm:block">
                <svg class="w-20 sm:w-28 md:w-36 h-auto text-white/90 drop-shadow-md" viewBox="0 0 100 60" fill="currentColor">
                    <path d="M20 50 C10 50 2 42 2 32 C2 24 8 18 16 16 C19 8 28 2 38 2 C49 2 58 8 62 18 C66 16 70 16 74 18 C83 19 90 26 90 35 C90 43 83 50 74 50 Z" />
                </svg>
            </div>
            <!-- Awan Animasi 2 (Kanan) -->
            <div class="absolute top-[16%] right-[8%] opacity-60 animate-buba-cloud-2 hidden md:block">
                <svg class="w-24 sm:w-32 md:w-40 h-auto text-white/85 drop-shadow-md" viewBox="0 0 100 60" fill="currentColor">
                    <path d="M20 50 C10 50 2 42 2 32 C2 24 8 18 16 16 C19 8 28 2 38 2 C49 2 58 8 62 18 C66 16 70 16 74 18 C83 19 90 26 90 35 C90 43 83 50 74 50 Z" />
                </svg>
            </div>
            <!-- Bintang Mengambang Ceria -->
            <div class="absolute top-[20%] left-[16%] text-2xl sm:text-3xl animate-buba-wiggle opacity-85 hidden sm:block drop-shadow">
                ⭐
            </div>
            <div class="absolute top-[14%] right-[20%] text-2xl sm:text-3xl animate-buba-float-slow opacity-85 hidden sm:block drop-shadow">
                ✨
            </div>
        </div>

        <!-- 3. Tombol Info di Pojok Kiri Atas (Konsisten dengan tombol kembali di view siswa) -->
        <div class="absolute left-4 top-4 z-30 sm:left-6 sm:top-6 md:left-8 md:top-8">
            <button
                @click="showInfo = true"
                type="button"
                class="group relative flex h-12 w-12 sm:h-14 sm:w-14 md:h-16 md:w-16 items-center justify-center rounded-full border-[4px] md:border-[5px] border-white bg-[#5ebef3] hover:bg-[#47ade7] active:bg-[#349bd5] text-white shadow-[0_6px_14px_rgba(0,0,0,0.18)] transition-all duration-200 hover:scale-110 hover:shadow-xl active:scale-90 active:translate-y-0.5 focus:outline-none focus:ring-4 focus:ring-white/70"
                title="Informasi Aplikasi BUBA"
                aria-label="Buka Informasi Aplikasi BUBA">

                <!-- Icon Info Huruf 'i' -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.6"
                    stroke="currentColor"
                    class="h-6 w-6 sm:h-7 sm:w-7 md:h-8 md:w-8 text-white drop-shadow transition-transform duration-200 group-hover:scale-110">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                </svg>

                <!-- Indikator Pulsa Kuning yang menarik perhatian -->
                <span class="absolute -top-1 -right-1 flex h-3.5 w-3.5 sm:h-4 sm:w-4">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#ffd629] opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3.5 w-3.5 sm:h-4 sm:w-4 bg-[#ffd629] border-2 border-white shadow-xs"></span>
                </span>

                <!-- Tooltip Mini saat hover (Tampil di Desktop) -->
                <span class="pointer-events-none absolute left-full ml-3 hidden sm:group-hover:flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-white/95 text-[#1e60be] text-xs font-black tracking-wide border-2 border-[#5ebef3] shadow-lg whitespace-nowrap animate-buba-pop">
                    <span>ℹ️</span>
                    <span>Info BUBA</span>
                </span>
            </button>
        </div>

        <!-- 4. Logo BUBA (Center Top dengan Animasi Mengambang Ceria) -->
        <div class="absolute top-[8%] sm:top-[10%] left-1/2 -translate-x-1/2 z-20 w-[82%] sm:w-[70%] max-w-sm sm:max-w-md md:max-w-xl">
            <div class="animate-buba-float transition-transform duration-300 hover:scale-105">
                <img src="{{ asset('images/logoBuba.png') }}" alt="Logo BUBA - Belajar Bermain Berkembang"
                    class="w-full h-auto drop-shadow-[0_12px_24px_rgba(0,0,0,0.22)] select-none pointer-events-none">
            </div>
        </div>

        <!-- 5. Tombol MULAI (Center Bottom dengan Gaya 3D Konsisten View Siswa) -->
        <div class="absolute bottom-[16%] sm:bottom-[18%] md:bottom-[20%] left-1/2 -translate-x-1/2 z-20">
            <a href="{{ route('siswa.konten') }}"
                class="group relative flex items-center justify-center gap-3 sm:gap-4 md:gap-5 bg-[#5ebef3] hover:bg-[#47ade7] active:bg-[#349bd5] border-[5px] sm:border-[6px] md:border-8 border-white rounded-[2.2rem] sm:rounded-[2.6rem] md:rounded-[3rem] px-8 py-3.5 sm:px-12 sm:py-4 md:px-16 md:py-5 shadow-[0_10px_0_#3898cf,0_16px_25px_rgba(0,0,0,0.22)] transition-all duration-200 hover:scale-105 hover:translate-y-1 hover:shadow-[0_5px_0_#3898cf,0_10px_18px_rgba(0,0,0,0.2)] active:translate-y-2.5 active:shadow-[0_2px_0_#3898cf] active:scale-95 focus:outline-none focus:ring-4 focus:ring-white/70 overflow-hidden"
                aria-label="Mulai Belajar dan Bermain bersama BUBA">

                <!-- Kilauan Pantulan Cahaya saat hover -->
                <span class="pointer-events-none absolute inset-0 -translate-x-full bg-gradient-to-r from-transparent via-white/30 to-transparent skew-x-[-20deg] transition-transform duration-1000 ease-out group-hover:translate-x-[250%]"></span>

                <!-- Icon Play Segitiga Putih -->
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                    class="w-8 h-8 sm:w-11 sm:h-11 md:w-14 md:h-14 text-white drop-shadow-[0_2px_4px_rgba(0,0,0,0.3)] transition-transform duration-200 group-hover:scale-110 group-hover:translate-x-1">
                    <path fill-rule="evenodd"
                        d="M4.5 5.653c0-1.426 1.529-2.33 2.779-1.643l11.54 6.348c1.295.712 1.295 2.573 0 3.285L7.28 19.991c-1.25.687-2.779-.217-2.779-1.643V5.653z"
                        clip-rule="evenodd" />
                </svg>

                <!-- Text MULAI -->
                <span class="text-white text-3xl sm:text-4xl md:text-5xl font-black tracking-widest drop-shadow-[0_2px_4px_rgba(0,0,0,0.3)] font-sans">
                    MULAI
                </span>
            </a>
        </div>

        <!-- 6. POPUP MODAL INFO BUBA (TailwindCSS + Alpine.js) -->
        <div
            x-show="showInfo"
            x-cloak
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @keydown.escape.window="showInfo = false"
            class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-5 md:p-6 bg-slate-900/60 backdrop-blur-sm overflow-y-auto"
            style="display: none;"
            role="dialog"
            aria-modal="true"
            aria-labelledby="info-modal-title">

            <!-- Backdrop klik untuk menutup -->
            <div class="fixed inset-0" @click="showInfo = false"></div>

            <!-- Kartu Modal Utama (Gaya Konsisten BUBA: Rounded Tebal, Border Putih, Shading) -->
            <div
                x-show="showInfo"
                x-transition:enter="transition cubic-bezier(0.34, 1.56, 0.64, 1) duration-300"
                x-transition:enter-start="opacity-0 scale-90 translate-y-4"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                x-transition:leave-end="opacity-0 scale-90 translate-y-4"
                class="relative w-full max-w-lg sm:max-w-xl md:max-w-2xl bg-white rounded-[2rem] sm:rounded-[2.6rem] border-[5px] sm:border-[6px] md:border-[7px] border-white shadow-[0_20px_50px_rgba(0,0,0,0.35)] overflow-hidden z-10 max-h-[90vh] flex flex-col my-auto select-text">

                <!-- Header Modal dengan Banner Khas BUBA -->
                <div class="relative bg-gradient-to-b from-[#5ebef3]/25 via-[#5ebef3]/10 to-transparent pt-6 sm:pt-7 px-5 sm:px-7 pb-3 flex flex-col items-center">
                    
                    <!-- Tombol Silang / Tutup di Kanan Atas -->
                    <button
                        @click="showInfo = false"
                        type="button"
                        class="absolute top-4 right-4 sm:top-5 sm:right-5 w-10 h-10 sm:w-11 sm:h-11 rounded-full bg-[#f36b6b] hover:bg-[#df5555] active:bg-[#c94444] border-[3px] border-white text-white flex items-center justify-center shadow-md transition-all duration-200 hover:scale-110 active:scale-90 focus:outline-none focus:ring-4 focus:ring-red-200"
                        title="Tutup Info"
                        aria-label="Tutup Informasi">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <!-- Banner Judul (Konsisten dengan Header PILIH KONTEN & PILIH KELAS) -->
                    <div class="rounded-2xl sm:rounded-[2rem] border-[4px] sm:border-[5px] border-white bg-[#1e60be] px-7 py-2 sm:px-10 sm:py-2.5 shadow-[0_6px_16px_rgba(30,96,190,0.35)] transition-transform duration-200 hover:scale-105">
                        <h2 id="info-modal-title" class="text-white font-black text-xl sm:text-2xl md:text-3xl tracking-wider text-center drop-shadow-[0_2px_4px_rgba(0,0,0,0.3)] font-sans flex items-center gap-2">
                            <span>ℹ️</span> TENTANG BUBA
                        </h2>
                    </div>

                    <!-- Tagline Ceria -->
                    <div class="mt-3 inline-flex items-center gap-2 px-4 py-1 rounded-full bg-amber-100 border-2 border-amber-300 text-amber-900 text-xs sm:text-sm font-extrabold shadow-2xs">
                        <span>🌈</span>
                        <span>Belajar • Bermain • Berkembang</span>
                        <span>⭐</span>
                    </div>
                </div>

                <!-- Konten Scrollable di dalam Popup Info -->
                <div class="px-5 sm:px-7 py-4 overflow-y-auto space-y-4 text-slate-700">

                    <!-- Kartu Sambutan Ringkas -->
                    <div class="bg-sky-50/80 border-2 border-[#5ebef3]/40 rounded-2xl p-3.5 sm:p-4 text-center">
                        <p class="text-xs sm:text-sm md:text-base font-bold text-sky-950 leading-relaxed">
                            Halo Teman Belajar! 👋 Selamat datang di <span class="text-[#1e60be] font-black">BUBA</span>! Media pembelajaran interaktif yang dirancang khusus untuk anak-anak dengan nuansa ceria, visual menyenangkan, dan penuh semangat!
                        </p>
                    </div>

                    <!-- 3 Kartu Fitur Utama (Menggunakan Palet Warna View Siswa) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-3.5">

                        <!-- Fitur 1: MATERI (Warna Hijau #71bf4f) -->
                        <div class="flex items-start gap-3 p-3.5 rounded-2xl bg-[#71bf4f]/10 border-2 border-[#71bf4f]/35 hover:border-[#71bf4f] transition-colors">
                            <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-2xl bg-[#71bf4f] border-[3px] border-white text-white flex items-center justify-center shrink-0 shadow-md text-2xl">
                                📚
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="font-black text-[#5ba23c] text-sm sm:text-base">Materi Menyenangkan</h3>
                                <p class="text-xs sm:text-xs md:text-sm font-medium text-slate-600 leading-snug mt-0.5">
                                    Belajar membaca, berhitung, mengenal hewan, sains, dan dunia sekitar melalui gambar penuh warna!
                                </p>
                            </div>
                        </div>

                        <!-- Fitur 2: KUIS (Warna Oranye #faa63a) -->
                        <div class="flex items-start gap-3 p-3.5 rounded-2xl bg-[#faa63a]/10 border-2 border-[#faa63a]/35 hover:border-[#faa63a] transition-colors">
                            <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-2xl bg-[#faa63a] border-[3px] border-white text-white flex items-center justify-center shrink-0 shadow-md text-2xl">
                                🎮
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="font-black text-[#e89427] text-sm sm:text-base">Kuis & Bintang Prestasi</h3>
                                <p class="text-xs sm:text-xs md:text-sm font-medium text-slate-600 leading-snug mt-0.5">
                                    Bermain kuis seru berhadiah bintang untuk mengasah pemahaman dengan penuh rasa percaya diri!
                                </p>
                            </div>
                        </div>

                        <!-- Fitur 3: KELAS (Warna Pink #d8759c) -->
                        <div class="flex items-start gap-3 p-3.5 rounded-2xl bg-[#d8759c]/10 border-2 border-[#d8759c]/35 hover:border-[#d8759c] transition-colors">
                            <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-2xl bg-[#d8759c] border-[3px] border-white text-white flex items-center justify-center shrink-0 shadow-md text-2xl">
                                🏫
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="font-black text-[#ca5e88] text-sm sm:text-base">Tingkatan Belajar</h3>
                                <p class="text-xs sm:text-xs md:text-sm font-medium text-slate-600 leading-snug mt-0.5">
                                    Materi dan kuis disesuaikan berdasarkan kelas dan tahapan tumbuh kembang ananda.
                                </p>
                            </div>
                        </div>

                        <!-- Fitur 4: MOTTO (Warna Biru Langit #5ebef3) -->
                        <div class="flex items-start gap-3 p-3.5 rounded-2xl bg-[#5ebef3]/10 border-2 border-[#5ebef3]/35 hover:border-[#5ebef3] transition-colors">
                            <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-2xl bg-[#5ebef3] border-[3px] border-white text-white flex items-center justify-center shrink-0 shadow-md text-2xl">
                                🚀
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="font-black text-[#3898cf] text-sm sm:text-base">Langkah Kecil, Impian Besar</h3>
                                <p class="text-xs sm:text-xs md:text-sm font-medium text-slate-600 leading-snug mt-0.5">
                                    Setiap langkah belajar hari ini adalah jembatan menuju mimpi besar di masa depan!
                                </p>
                            </div>
                        </div>

                    </div>

                    <!-- Petunjuk Cara Memulai Belajar -->
                    <div class="rounded-2xl border-2 border-slate-200/90 bg-slate-50/90 p-3.5 sm:p-4">
                        <h4 class="font-black text-xs sm:text-sm uppercase tracking-wider text-slate-700 mb-2.5 flex items-center gap-2">
                            <span>💡</span> Langkah Mudah Memulai:
                        </h4>
                        <ol class="space-y-2 text-xs sm:text-sm font-semibold text-slate-600">
                            <li class="flex items-center gap-2.5">
                                <span class="w-5 h-5 rounded-full bg-[#5ebef3] text-white font-black text-xs flex items-center justify-center shrink-0 shadow-2xs">1</span>
                                <span>Klik tombol besar <strong class="text-[#1e60be]">"MULAI"</strong> di halaman utama.</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span class="w-5 h-5 rounded-full bg-[#71bf4f] text-white font-black text-xs flex items-center justify-center shrink-0 shadow-2xs">2</span>
                                <span>Pilih menu <strong class="text-[#71bf4f]">Materi</strong> untuk belajar atau <strong class="text-[#faa63a]">Kuis</strong> untuk bermain tantangan.</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span class="w-5 h-5 rounded-full bg-[#d8759c] text-white font-black text-xs flex items-center justify-center shrink-0 shadow-2xs">3</span>
                                <span>Pilih <strong class="text-[#d8759c]">Kelas</strong> dan kategori favoritmu, lalu nikmati petualangan belajarmu!</span>
                            </li>
                        </ol>
                    </div>

                </div>

                <!-- Footer Modal (Tombol Aksi Ramah Anak) -->
                <div class="p-4 sm:p-5 bg-slate-50 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-center gap-3">
                    <!-- Tombol Ayo Mulai (Langsung ke halaman konten) -->
                    <a href="{{ route('siswa.konten') }}"
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2.5 px-8 py-3 rounded-full bg-[#5ebef3] hover:bg-[#47ade7] active:bg-[#349bd5] border-[3.5px] border-white text-white font-black text-sm sm:text-base tracking-wide shadow-[0_5px_0_#3898cf] hover:shadow-[0_2px_0_#3898cf] hover:translate-y-0.5 active:translate-y-1 transition-all focus:outline-none focus:ring-4 focus:ring-sky-200">
                        <span>Ayo Mulai Belajar!</span>
                        <span class="text-lg">🚀</span>
                    </a>

                    <!-- Tombol Tutup -->
                    <button
                        @click="showInfo = false"
                        type="button"
                        class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 rounded-full bg-slate-200 hover:bg-slate-300 active:bg-slate-400 text-slate-700 font-extrabold text-sm sm:text-base border-2 border-white transition-all active:scale-95">
                        Tutup
                    </button>
                </div>

            </div>

        </div>

    </div>

@endsection
