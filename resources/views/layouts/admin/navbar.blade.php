<!-- Navbar Atas -->
<header class="h-20 bg-[#0f172a] flex items-center justify-between px-6 border-b border-slate-800/60 z-10">
    
    <!-- Kiri: Hamburger & Bintang -->
    <div class="flex items-center gap-4">
        <button class="text-slate-400 hover:text-white transition-colors">
            <i class="fas fa-bars text-xl"></i>
        </button>
        <i class="fas fa-star text-yellow-400 text-lg"></i>
    </div>

    <!-- Kanan: Notifikasi, Profil, Maskot -->
    <div class="flex items-center gap-6">
        
        <!-- Notifikasi -->
        <button class="relative text-slate-400 hover:text-white transition-colors">
            <i class="fas fa-bell text-xl"></i>
            <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
        </button>

        <!-- Profil Admin -->
        <div class="flex items-center gap-3 cursor-pointer group">
            <!-- Avatar -->
            <div class="w-10 h-10 rounded-full bg-slate-700 flex items-center justify-center overflow-hidden border-2 border-slate-600 group-hover:border-blue-500 transition-colors">
                <i class="fas fa-user text-slate-400"></i>
            </div>
            <!-- Nama & Dropdown -->
            <div class="flex items-center gap-2 text-sm">
                <span class="font-medium text-white">Admin</span>
                <i class="fas fa-chevron-down text-xs text-slate-400 group-hover:text-white transition-colors"></i>
            </div>
        </div>

        <!-- Maskot Beruang Kanan Atas -->
        <div class="hidden md:block relative -mb-4">
            <!-- Ganti ini dengan gambar beruang Anda -->
            <svg class="w-16 h-16 text-orange-400" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
                <circle cx="8.5" cy="10.5" r="1.5" fill="currentColor"/>
                <circle cx="15.5" cy="10.5" r="1.5" fill="currentColor"/>
                <circle cx="12" cy="14" r="2" fill="currentColor"/>
            </svg>
        </div>
    </div>
</header>