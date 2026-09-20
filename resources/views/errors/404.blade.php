<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        @keyframes glitch {

            0%,
            100% {
                transform: translate(0);
            }

            20% {
                transform: translate(-3px, 3px);
            }

            40% {
                transform: translate(-3px, -3px);
            }

            60% {
                transform: translate(3px, 3px);
            }

            80% {
                transform: translate(3px, -3px);
            }
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        .animate-glitch {
            animation: glitch 0.3s ease-in-out infinite;
        }
    </style>
</head>

<body
    class="min-h-screen bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 flex items-center justify-center p-4 overflow-hidden">

    <!-- Background decorative elements -->
    <div class="absolute inset-0 overflow-hidden">
        <div
            class="absolute top-20 left-10 w-72 h-72 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-float">
        </div>
        <div class="absolute bottom-20 right-10 w-72 h-72 bg-pink-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-float"
            style="animation-delay: 2s;"></div>
        <div class="absolute top-1/2 left-1/2 w-72 h-72 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-float"
            style="animation-delay: 4s;"></div>
    </div>

    <!-- Main content -->
    <div class="relative z-10 text-center max-w-2xl mx-auto">

        <!-- 404 Number -->
        <div class="relative mb-8">
            <h1
                class="text-[150px] sm:text-[200px] md:text-[250px] font-black text-transparent bg-clip-text bg-gradient-to-r from-purple-400 via-pink-400 to-purple-400 leading-none select-none">
                404
            </h1>
            <!-- Ghost floating on top -->
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 animate-float">
                <svg class="w-24 h-24 sm:w-32 sm:h-32 text-white/90 drop-shadow-2xl" viewBox="0 0 24 24"
                    fill="currentColor">
                    <path
                        d="M12 2C7.58 2 4 5.58 4 10v10c0 .55.45 1 1 1s1-.45 1-1v-1h2v1c0 .55.45 1 1 1s1-.45 1-1v-1h2v1c0 .55.45 1 1 1s1-.45 1-1v-1h2v1c0 .55.45 1 1 1s1-.45 1-1V10c0-4.42-3.58-8-8-8zm-3 9c-.83 0-1.5-.67-1.5-1.5S8.17 8 9 8s1.5.67 1.5 1.5S9.83 11 9 11zm6 0c-.83 0-1.5-.67-1.5-1.5S14.17 8 15 8s1.5.67 1.5 1.5S15.83 11 15 11z" />
                </svg>
            </div>
        </div>

        <!-- Message -->
        <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-white mb-4">
            Ups! Halaman Tidak Ditemukan
        </h2>
        <p class="text-gray-300 text-base sm:text-lg mb-8 max-w-md mx-auto">
            Sepertinya halaman yang kamu cari sudah pindah, dihapus, atau tidak pernah ada. Jangan khawatir, kamu bisa
            kembali ke beranda.
        </p>

        <!-- Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
            <a href="{{ route('home') }}"
                class="group relative inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-purple-500 to-pink-500 text-white font-semibold rounded-full shadow-lg shadow-purple-500/50 hover:shadow-pink-500/50 hover:scale-105 transition-all duration-300">
                <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Kembali ke Beranda
            </a>

            <button onclick="history.back()"
                class="group inline-flex items-center gap-2 px-8 py-4 bg-white/10 backdrop-blur-sm text-white font-semibold rounded-full border border-white/20 hover:bg-white/20 hover:scale-105 transition-all duration-300">
                <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Halaman Sebelumnya
            </button>
        </div>

        <!-- Error code -->
        <p class="mt-12 text-gray-400 text-sm">
            Error Code: <span class="font-mono text-purple-400">404_NOT_FOUND</span>
        </p>
        <p class="mt-12 text-gray-400 text-sm">
            &copy; 2026 NAJATIF. Politeknik Negeri Jember.
        </p>
    </div>

</body>

</html>
