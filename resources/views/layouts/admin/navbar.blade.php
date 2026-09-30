<!-- Navbar Atas -->
<header class="h-20 bg-[white] flex items-center justify-between px-6 shadow z-10">
    
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
            <img src="{{ asset('images/navbarDecoration.png') }}" alt="" class="w-50">
        </div>
    </div>
</header>