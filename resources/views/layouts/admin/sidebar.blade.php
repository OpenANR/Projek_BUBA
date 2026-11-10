<!-- Sidebar -->
<aside id="admin-sidebar"
    class="bg-[white] flex flex-col justify-between shadow-xl z-20 transition-all duration-300 shrink-0">

    <!-- Bagian Atas: Logo & Menu -->
    <div>
        <!-- Logo Buba -->
        <div class="h-20 flex items-center justify-center px-4 border-b border-gray-200/60 overflow-hidden transition-all duration-300">
            <img src="{{ asset('images/logoAdmin.png') }}" alt="BUBA" data-sidebar-logo="expanded"
                class="h-10 w-auto object-contain transition-all duration-300">
            <img src="{{ asset('images/logoAdminIcon.png') }}" alt="BUBA" data-sidebar-logo="collapsed"
                class="h-10 w-10 object-contain transition-all duration-300">
        </div>
        <p x-show="!sidebarCollapsed" data-sidebar-label
            class="text-[10px] text-center text-slate-500 mt-1 tracking-wider uppercase">Belajar - Bermain - Berkembang
        </p>

        <!-- Menu Navigasi -->
        <nav class="mt-6 px-3 space-y-1 transition-all duration-300">
            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}"
                :title="sidebarCollapsed ? 'Dashboard' : null"
                class="flex items-center rounded-lg transition-all overflow-hidden {{ request()->routeIs('admin.dashboard*') || request()->is('admin/dashboard*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30 active' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                <i class="fas fa-home w-5 text-center shrink-0"></i>
                <span x-show="!sidebarCollapsed" data-sidebar-label class="font-medium text-sm whitespace-nowrap">Dashboard</span>
            </a>

            <!-- Kelola Kelas -->
            <a href="{{ route('kelas.index') }}"
                :title="sidebarCollapsed ? 'Kelola Kelas' : null"
                class="flex items-center rounded-lg transition-all overflow-hidden {{ request()->routeIs('kelas.*') || request()->is('admin/kelas*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30 active' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                <i class="fa-solid fa-school w-5 text-center shrink-0"></i>
                <span x-show="!sidebarCollapsed" data-sidebar-label class="font-medium text-sm whitespace-nowrap">Kelola Kelas</span>
            </a>

            <!-- Kelola Kategori -->
            <a href="{{ route('kategori.index') }}"
                :title="sidebarCollapsed ? 'Kelola Kategori' : null"
                class="flex items-center rounded-lg transition-all overflow-hidden {{ request()->routeIs('kategori.*') || request()->is('admin/kategori*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30 active' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                <i class="fa-solid fa-layer-group w-5 text-center shrink-0"></i>
                <span x-show="!sidebarCollapsed" data-sidebar-label class="font-medium text-sm whitespace-nowrap">Kelola Kategori</span>
            </a>

            <!-- Kelola Materi -->
            <a href="{{ route('materi.index') }}"
                :title="sidebarCollapsed ? 'Kelola Materi' : null"
                class="flex items-center rounded-lg transition-all overflow-hidden {{ request()->routeIs('materi.*') || request()->is('admin/materi*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30 active' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                <i class="fas fa-book-open w-5 text-center shrink-0"></i>
                <span x-show="!sidebarCollapsed" data-sidebar-label class="font-medium text-sm whitespace-nowrap">Kelola Materi</span>
            </a>

            <!-- Kelola Quiz -->
            <a href="{{ route('kuis.index') }}"
                :title="sidebarCollapsed ? 'Kelola Quiz' : null"
                class="flex items-center rounded-lg transition-all overflow-hidden {{ request()->routeIs('kuis.*') || request()->is('admin/kuis*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30 active' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                <i class="fas fa-edit w-5 text-center shrink-0"></i>
                <span x-show="!sidebarCollapsed" data-sidebar-label class="font-medium text-sm whitespace-nowrap">Kelola Quiz</span>
            </a>

            <!-- Hasil Reward -->
            <a href="{{ route('reward.index') }}"
                :title="sidebarCollapsed ? 'Hasil Reward' : null"
                class="flex items-center rounded-lg transition-all overflow-hidden {{ request()->routeIs('reward.*') || request()->is('admin/reward*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30 active' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                <i class="fas fa-star w-5 text-center shrink-0"></i>
                <span x-show="!sidebarCollapsed" data-sidebar-label class="font-medium text-sm whitespace-nowrap">Hasil Reward</span>
            </a>

            <!-- Kelola Pengguna -->
            <a href="{{ route('siswa.index') }}"
                :title="sidebarCollapsed ? 'Kelola Pengguna' : null"
                class="flex items-center rounded-lg transition-all overflow-hidden {{ request()->routeIs('siswa.*') || request()->is('admin/siswa*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30 active' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                <i class="fas fa-users w-5 text-center shrink-0"></i>
                <span x-show="!sidebarCollapsed" data-sidebar-label class="font-medium text-sm whitespace-nowrap">Kelola Pengguna</span>
            </a>
        </nav>
    </div>

    <!-- Bagian Bawah: Ilustrasi Beruang -->
    <div class="relative p-4 flex justify-center items-end h-40" x-show="!sidebarCollapsed" data-sidebar-label>
        <!-- Background hijau rumput -->
        {{-- <img src="{{ asset('images/sidebarBackground.png') }}" alt=""> --}}
    </div>
    <div class="text-center mb-5 px-2" x-show="!sidebarCollapsed" data-sidebar-label>
        <p class="font-bold">BUBA E-Learning Application</p>
        <p class="">&copy; {{ date('Y') }} NAJATIF</p>
        <p class="">All Right Reserved.</p>
    </div>
</aside>
