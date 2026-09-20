<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'BUBA Development')</title>
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Konfigurasi kustom (opsional) -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'spin-slow': 'spin 12s linear infinite',
                        'bounce-slow': 'bounce 3s infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': {
                                transform: 'translateY(0px)'
                            },
                            '50%': {
                                transform: 'translateY(-20px)'
                            },
                        }
                    }
                }
            }
        }
    </script>
    <style>
        /* Fallback font & smoothing */
        body {
            font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Efek kustom untuk gradien teks */
        .text-gradient {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #d946ef 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Overlay pola titik-titik halus */
        .bg-dots {
            background-image: radial-gradient(rgba(99, 102, 241, 0.15) 1px, transparent 1px);
            background-size: 24px 24px;
        }
    </style>
</head>

<body
    class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-indigo-50/30 flex items-center justify-center p-4 antialiased">

    <!-- Latar belakang dekoratif: pola titik & blob gradien -->
    <div class="fixed inset-0 -z-10 overflow-hidden">
        <!-- Pola titik -->
        <div class="absolute inset-0 bg-dots opacity-60"></div>

        <!-- Blob 1: ungu -->
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-indigo-200/40 rounded-full blur-3xl animate-float"
            style="animation-delay: 0s;"></div>

        <!-- Blob 2: fuchsia -->
        <div class="absolute -bottom-32 -right-32 w-[30rem] h-[30rem] bg-fuchsia-200/30 rounded-full blur-3xl animate-float"
            style="animation-delay: 2s;"></div>

        <!-- Blob 3: sky (tengah) -->
        <div
            class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[40rem] h-[40rem] bg-sky-100/40 rounded-full blur-3xl animate-pulse-slow">
        </div>

        <!-- Lingkaran dekoratif berputar -->
        <div class="absolute top-10 right-10 w-32 h-32 border border-indigo-200/60 rounded-full animate-spin-slow">
        </div>
        <div class="absolute bottom-20 left-10 w-24 h-24 border border-fuchsia-200/60 rounded-full animate-spin-slow"
            style="animation-direction: reverse;"></div>
    </div>

    <!-- Kartu utama -->
    <main class="relative w-full max-w-2xl">
        <!-- Efek glow di belakang kartu -->
        <div
            class="absolute -inset-1 bg-gradient-to-r from-indigo-300/30 via-purple-300/30 to-fuchsia-300/30 rounded-3xl blur-2xl opacity-70">
        </div>

        <!-- Kartu konten -->
        <div
            class="relative bg-white/80 backdrop-blur-xl rounded-3xl shadow-2xl shadow-indigo-500/10 border border-white/60 overflow-hidden">

            <!-- Garis aksen atas -->
            <div class="h-1.5 w-full bg-gradient-to-r from-indigo-500 via-purple-500 to-fuchsia-500"></div>

            <div class="px-6 py-12 sm:px-12 sm:py-16 text-center">

                <!-- Ikon animasi (roket / konstruksi) -->
                <div class="flex justify-center mb-8">
                    <div class="relative">
                        <!-- Lingkaran latar ikon -->
                        <div
                            class="absolute inset-0 bg-gradient-to-br from-indigo-500 to-fuchsia-500 rounded-2xl blur-md opacity-40 animate-pulse">
                        </div>
                        <div
                            class="relative w-20 h-20 bg-gradient-to-br from-indigo-500 via-purple-500 to-fuchsia-500 rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-500/30 animate-float">
                            <!-- Icon: construction / tools -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-white" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Badge "Dalam Pengembangan" -->
                <div
                    class="inline-flex items-center gap-2 px-4 py-1.5 mb-6 rounded-full bg-indigo-50 border border-indigo-100 text-indigo-600 text-xs font-semibold tracking-wide uppercase">
                    <span class="relative flex h-2 w-2">
                        <span
                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                    </span>
                    Sedang Dikembangkan
                </div>

                <!-- Judul utama -->
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold tracking-tight text-slate-800 mb-4">
                    Halaman Masih <span class="text-gradient">Dalam Pengembangan</span>
                </h1>

                <!-- Deskripsi -->
                <p class="text-base sm:text-lg text-slate-500 max-w-md mx-auto mb-10 leading-relaxed">
                    Kami sedang bekerja keras untuk menyiapkan sesuatu yang luar biasa.
                    Halaman ini akan segera tersedia. Terima kasih atas kesabaran Anda! 🚀
                </p>

                <!-- Tombol aksi -->
                <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
                    <!-- Tombol utama -->
                    <a href="{{ route('home') }}"
                        class="group w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-gradient-to-r from-indigo-500 to-fuchsia-500 text-white font-semibold text-sm shadow-lg shadow-indigo-500/25 hover:shadow-xl hover:shadow-indigo-500/35 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-4 h-4 transition-transform group-hover:-translate-x-0.5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Kembali ke Beranda
                    </a>

                    <!-- Tombol sekunder -->
                    <a href="#"
                        class="group w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-white text-slate-600 font-semibold text-sm border border-slate-200 shadow-sm hover:bg-slate-50 hover:border-slate-300 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-4 h-4 text-slate-400 group-hover:text-indigo-500 transition-colors" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Hubungi Kami
                    </a>
                </div>

                <!-- Info tambahan / estimasi -->
                <p class="mt-8 text-xs text-slate-400 flex items-center justify-center gap-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Estimasi selesai: Segera
                </p>

            </div>

            <!-- Footer kecil di dalam kartu -->
            <div class="px-6 py-4 bg-slate-50/80 border-t border-slate-100 text-center">
                <p class="text-xs text-slate-400">
                    &copy; 2026 NAJATIF. Politeknik Negeri Jember.
                </p>
            </div>

        </div>
    </main>

</body>

</html>
