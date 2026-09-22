<!-- Sidebar -->
<aside class="w-64 bg-[#0b1120] flex flex-col justify-between border-r border-slate-800/60 shadow-xl z-20 transition-all duration-300">
    
    <!-- Bagian Atas: Logo & Menu -->
    <div>
        <!-- Logo Buba -->
        <div class="h-20 flex items-center px-6 gap-3 border-b border-slate-800/60">
            <!-- Ikon Beruang (SVG sederhana) -->
            <svg class="w-10 h-10 text-orange-400" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
                <circle cx="8.5" cy="10.5" r="1.5" fill="currentColor"/>
                <circle cx="15.5" cy="10.5" r="1.5" fill="currentColor"/>
                <circle cx="12" cy="14" r="2" fill="currentColor"/>
            </svg>
            <span class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-orange-400 to-pink-500">
                Buba
            </span>
        </div>
        <p class="text-[10px] text-center text-slate-500 mt-1 tracking-wider uppercase">Belajar - Bermain - Berkembang</p>

        <!-- Menu Navigasi -->
        <nav class="mt-6 px-3 space-y-1">
            <!-- Dashboard (Aktif) -->
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-blue-600 text-white shadow-lg shadow-blue-600/30 transition-all">
                <i class="fas fa-home w-5 text-center"></i>
                <span class="font-medium text-sm">Dashboard</span>
            </a>

            <!-- Kelola Materi -->
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-400 hover:bg-slate-800/50 hover:text-white transition-all">
                <i class="fas fa-book-open w-5 text-center"></i>
                <span class="font-medium text-sm">Kelola Materi</span>
            </a>

            <!-- Kelola Quiz -->
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-400 hover:bg-slate-800/50 hover:text-white transition-all">
                <i class="fas fa-edit w-5 text-center"></i>
                <span class="font-medium text-sm">Kelola Quiz</span>
            </a>

            <!-- Kelola Reward -->
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-400 hover:bg-slate-800/50 hover:text-white transition-all">
                <i class="fas fa-star w-5 text-center"></i>
                <span class="font-medium text-sm">Kelola Reward</span>
            </a>

            <!-- Kelola Pengaturan -->
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-400 hover:bg-slate-800/50 hover:text-white transition-all">
                <i class="fas fa-cog w-5 text-center"></i>
                <span class="font-medium text-sm">Kelola Pengaturan</span>
            </a>

            <!-- Kelola Pengguna -->
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-400 hover:bg-slate-800/50 hover:text-white transition-all">
                <i class="fas fa-users w-5 text-center"></i>
                <span class="font-medium text-sm">Kelola Pengguna</span>
            </a>

            <!-- Evaluasi -->
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-400 hover:bg-slate-800/50 hover:text-white transition-all">
                <i class="fas fa-chart-bar w-5 text-center"></i>
                <span class="font-medium text-sm">Evaluasi</span>
            </a>
        </nav>
    </div>

    <!-- Bagian Bawah: Ilustrasi Beruang -->
    <div class="relative p-4 flex justify-center items-end h-40">
        <!-- Background hijau rumput -->
        <div class="absolute bottom-0 w-full h-24 bg-[#1a3c2e] rounded-t-[50%] opacity-80"></div>
        <!-- Ilustrasi Beruang Membaca (Placeholder SVG) -->
        <svg class="w-24 h-24 text-orange-400 relative z-10 mb-2" fill="currentColor" viewBox="0 0 24 24">
             <!-- Gunakan gambar beruang Anda di sini, ini hanya placeholder -->
             <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15h-2v-2h2v2zm0-4h-2V7h2v6zm4 4h-2v-2h2v2zm0-4h-2V7h2v6z"/>
        </svg>
    </div>
</aside>