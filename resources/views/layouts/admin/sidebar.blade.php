<!-- Sidebar -->
<aside id="admin-sidebar"
    class="bg-[white] flex flex-col justify-between shadow-xl z-20 transition-all duration-300 shrink-0"
    :class="sidebarCollapsed ? 'w-20' : 'w-64'">

    <!-- Bagian Atas: Logo & Menu -->
    <div>
        <!-- Logo Buba -->
        <div class="h-20 flex items-center border-b border-gray-200/60 overflow-hidden transition-all duration-300"
            :class="sidebarCollapsed ? 'justify-center px-0' : 'px-6'">
            <img src="{{ asset('images/logoAdmin.png') }}" alt="BUBA"
                class="h-10 transition-all duration-300"
                :class="sidebarCollapsed ? 'w-10 rounded-lg object-cover object-left' : 'w-auto object-contain'">
        </div>
        <p x-show="!sidebarCollapsed" class="text-[10px] text-center text-slate-500 mt-1 tracking-wider uppercase">Belajar - Bermain - Berkembang
        </p>

        <!-- Menu Navigasi -->
        <nav class="mt-6 space-y-1 transition-all duration-300" :class="sidebarCollapsed ? 'px-2' : 'px-3'">
            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}"
                :title="sidebarCollapsed ? 'Dashboard' : null"
                class="flex items-center rounded-lg transition-all overflow-hidden {{ request()->routeIs('admin.dashboard*') || request()->is('admin/dashboard*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30 active' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}"
                :class="sidebarCollapsed ? 'justify-center px-0 py-3' : 'gap-3 px-4 py-3'">
                <i class="fas fa-home w-5 text-center shrink-0"></i>
                <span x-show="!sidebarCollapsed" class="font-medium text-sm whitespace-nowrap">Dashboard</span>
            </a>

            <!-- Kelola Kelas -->
            <a href="{{ route('kelas.index') }}"
                :title="sidebarCollapsed ? 'Kelola Kelas' : null"
                class="flex items-center rounded-lg transition-all overflow-hidden {{ request()->routeIs('kelas.*') || request()->is('admin/kelas*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30 active' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}"
                :class="sidebarCollapsed ? 'justify-center px-0 py-3' : 'gap-3 px-4 py-3'">
                <i class="fa-solid fa-school w-5 text-center shrink-0"></i>
                <span x-show="!sidebarCollapsed" class="font-medium text-sm whitespace-nowrap">Kelola Kelas</span>
            </a>

            <!-- Kelola Kategori -->
            <a href="{{ route('kategori.index') }}"
                :title="sidebarCollapsed ? 'Kelola Kategori' : null"
                class="flex items-center rounded-lg transition-all overflow-hidden {{ request()->routeIs('kategori.*') || request()->is('admin/kategori*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30 active' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}"
                :class="sidebarCollapsed ? 'justify-center px-0 py-3' : 'gap-3 px-4 py-3'">
                <i class="fa-solid fa-layer-group w-5 text-center shrink-0"></i>
                <span x-show="!sidebarCollapsed" class="font-medium text-sm whitespace-nowrap">Kelola Kategori</span>
            </a>

            <!-- Kelola Materi -->
            <a href="{{ route('materi.index') }}"
                :title="sidebarCollapsed ? 'Kelola Materi' : null"
                class="flex items-center rounded-lg transition-all overflow-hidden {{ request()->routeIs('materi.*') || request()->is('admin/materi*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30 active' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}"
                :class="sidebarCollapsed ? 'justify-center px-0 py-3' : 'gap-3 px-4 py-3'">
                <i class="fas fa-book-open w-5 text-center shrink-0"></i>
                <span x-show="!sidebarCollapsed" class="font-medium text-sm whitespace-nowrap">Kelola Materi</span>
            </a>

            <!-- Kelola Quiz -->
            <a href="{{ route('kuis.index') }}"
                :title="sidebarCollapsed ? 'Kelola Quiz' : null"
                class="flex items-center rounded-lg transition-all overflow-hidden {{ request()->routeIs('kuis.*') || request()->is('admin/kuis*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30 active' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}"
                :class="sidebarCollapsed ? 'justify-center px-0 py-3' : 'gap-3 px-4 py-3'">
                <i class="fas fa-edit w-5 text-center shrink-0"></i>
                <span x-show="!sidebarCollapsed" class="font-medium text-sm whitespace-nowrap">Kelola Quiz</span>
            </a>

            <!-- Hasil Reward -->
            <a href="{{ route('reward.index') }}"
                :title="sidebarCollapsed ? 'Hasil Reward' : null"
                class="flex items-center rounded-lg transition-all overflow-hidden {{ request()->routeIs('reward.*') || request()->is('admin/reward*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30 active' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}"
                :class="sidebarCollapsed ? 'justify-center px-0 py-3' : 'gap-3 px-4 py-3'">
                <i class="fas fa-star w-5 text-center shrink-0"></i>
                <span x-show="!sidebarCollapsed" class="font-medium text-sm whitespace-nowrap">Hasil Reward</span>
            </a>

            <!-- Kelola Pengguna -->
            <a href="{{ route('siswa.index') }}"
                :title="sidebarCollapsed ? 'Kelola Pengguna' : null"
                class="flex items-center rounded-lg transition-all overflow-hidden {{ request()->routeIs('siswa.*') || request()->is('admin/siswa*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30 active' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}"
                :class="sidebarCollapsed ? 'justify-center px-0 py-3' : 'gap-3 px-4 py-3'">
                <i class="fas fa-users w-5 text-center shrink-0"></i>
                <span x-show="!sidebarCollapsed" class="font-medium text-sm whitespace-nowrap">Kelola Pengguna</span>
            </a>
        </nav>
    </div>

    <!-- Bagian Bawah: Ilustrasi Beruang -->
    <div class="relative p-4 flex justify-center items-end h-40" x-show="!sidebarCollapsed">
        <!-- Background hijau rumput -->
        {{-- <img src="{{ asset('images/sidebarBackground.png') }}" alt=""> --}}
    </div>
    <div class="text-center mb-5 px-2" x-show="!sidebarCollapsed">
        <p class="italic">BUBA E-Learning Application | Version 1.0</p>
        <p class="font-bold">&copy; {{ date('Y') }} NAJATIF</p>
        <p class="font-bold">All Right Reserved.</p>
    </div>
</aside>
