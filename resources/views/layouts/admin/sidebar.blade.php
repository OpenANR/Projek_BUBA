<!-- Sidebar -->
<aside class="w-64 bg-[white] flex flex-col justify-between  shadow-xl z-20 transition-all duration-300">
    
    <!-- Bagian Atas: Logo & Menu -->
    <div>
        <!-- Logo Buba -->
        <div class="h-20 flex items-center px-6 gap-3 border-b border-gray-200/60">
            <!-- Ikon Beruang (SVG sederhana) -->
            <img src="{{ asset('images/logoAdmin.png') }}" alt="">
        </div>
        <p class="text-[10px] text-center text-slate-500 mt-1 tracking-wider uppercase">Belajar - Bermain - Berkembang</p>

        <!-- Menu Navigasi -->
        <nav class="mt-6 px-3 space-y-1">
            <!-- Dashboard (Aktif) -->
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-blue-600 text-white shadow-lg shadow-blue-600/30 transition-all">
                <i class="fas fa-home w-5 text-center"></i>
                <span class="font-medium text-sm">Dashboard</span>
            </a>

            <!-- Kelola Kelas -->
            <a href="{{ route('kelas.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-400 hover:bg-slate-800/50 hover:text-white transition-all">
                <i class="fa-solid fa-school"></i>
                <span class="font-medium text-sm">Kelola Kelas</span>
            </a>

            <!-- Kelola Kategori -->
            <a href="{{ route('kategori.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-400 hover:bg-slate-800/50 hover:text-white transition-all">
                <i class="fa-solid fa-layer-group"></i>
                <span class="font-medium text-sm">Kelola Kategori</span>
            </a>

            <!-- Kelola Materi -->
            <a href="{{ route('materi.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-400 hover:bg-slate-800/50 hover:text-white transition-all">
                <i class="fas fa-book-open w-5 text-center"></i>
                <span class="font-medium text-sm">Kelola Materi</span>
            </a>

            <!-- Kelola Quiz -->
            <a href="{{ route('kuis.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-400 hover:bg-slate-800/50 hover:text-white transition-all">
                <i class="fas fa-edit w-5 text-center"></i>
                <span class="font-medium text-sm">Kelola Quiz</span>
            </a>

            <!-- Kelola Reward -->
            <a href="{{ route('reward.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-400 hover:bg-slate-800/50 hover:text-white transition-all">
                <i class="fas fa-star w-5 text-center"></i>
                <span class="font-medium text-sm">Kelola Reward</span>
            </a>

            <!-- Kelola Pengguna -->
            <a href="{{ route('siswa.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-400 hover:bg-slate-800/50 hover:text-white transition-all">
                <i class="fas fa-users w-5 text-center"></i>
                <span class="font-medium text-sm">Kelola Pengguna</span>
            </a>
        </nav>
    </div>

    <!-- Bagian Bawah: Ilustrasi Beruang -->
    <div class="relative p-4 flex justify-center items-end h-40">
        <!-- Background hijau rumput -->
        {{-- <img src="{{ asset('images/sidebarBackground.png') }}" alt=""> --}}
        
        <!-- Ilustrasi Beruang Membaca (Placeholder SVG) -->
    </div>
</aside>