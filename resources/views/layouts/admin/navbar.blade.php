<!-- Navbar Atas -->
<header class="h-20 bg-white flex items-center justify-between px-6 shadow-sm border-b border-slate-100 z-10">

    <!-- Kiri: Hamburger & Jam Digital -->
    <div class="flex items-center gap-5">
        <!-- Hamburger Menu Button -->
        <button class="p-2 text-slate-600 hover:text-blue-600 hover:bg-slate-100 rounded-lg transition-all focus:outline-none">
            <i class="fas fa-bars text-xl"></i>
        </button>

        <!-- Container Jam & Tanggal Digital -->
        <div class="hidden sm:flex items-center gap-3 px-3.5 py-1.5 bg-slate-50 border border-slate-200/80 rounded-xl text-slate-700">
            <!-- Icon Tanggal -->
            <div class="flex items-center gap-1.5 text-xs font-medium text-slate-600 border-r border-slate-200 pr-3">
                <i class="far fa-calendar-alt text-blue-500"></i>
                <span id="date-display">Hari, 00 Bulan 0000</span>
            </div>
            <!-- Icon & Angka Jam -->
            <div class="flex items-center gap-1.5 text-sm font-bold text-slate-800 font-mono tracking-wide">
                <i class="far fa-clock text-blue-500 text-xs"></i>
                <span id="time-display">00:00:00</span>
            </div>
        </div>
    </div>

    <!-- Kanan: Notifikasi, Profil, Maskot -->
    <div class="flex items-center gap-4 md:gap-6">

        <!-- Notifikasi -->
        <button class="relative p-2 text-slate-500 hover:text-blue-600 hover:bg-slate-100 rounded-lg transition-all focus:outline-none">
            <i class="far fa-bell text-xl"></i>
            <span class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-red-500 border-2 border-white rounded-full"></span>
        </button>

        <!-- Profil Admin Dropdown -->
        <div class="relative" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
            <button @click="open = !open" type="button"
                class="flex items-center gap-3 p-1 rounded-full hover:bg-slate-50 transition-colors cursor-pointer group focus:outline-none">
                <!-- Avatar -->
                <div
                    class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center overflow-hidden border-2 border-slate-200 group-hover:border-blue-500 transition-colors">
                    <i class="fas fa-user text-slate-500 group-hover:text-blue-600 transition-colors"></i>
                </div>
                <!-- Nama & Chevron -->
                <div class="hidden lg:flex items-center gap-2 text-sm">
                    <span
                        class="font-semibold text-slate-700 group-hover:text-blue-600 transition-colors">{{ Auth::user()->name }}</span>
                    <i class="fas fa-chevron-down text-xs text-slate-400 group-hover:text-blue-600 transition-transform duration-200"
                        :class="{ 'rotate-180': open }"></i>
                </div>
            </button>

            <!-- Dropdown Menu -->
            <div x-show="open" x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                class="absolute right-0 mt-3 w-60 bg-white rounded-xl shadow-xl border border-slate-200 py-2 z-50 divide-y divide-slate-100"
                style="display: none;">

                <!-- Info Pengguna -->
                <div class="px-4 py-3">
                    <p class="text-[11px] uppercase tracking-wider font-semibold text-slate-400">Masuk sebagai</p>
                    <p class="text-sm font-bold text-slate-800 truncate mt-0.5">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-slate-500 truncate">{{ Auth::user()->email }}</p>
                    <span
                        class="inline-flex items-center px-2 py-0.5 mt-2 rounded-full text-[11px] font-semibold bg-blue-50 text-blue-600 border border-blue-200">
                        <i class="fas fa-shield-halved mr-1 text-[10px]"></i>
                        {{ ucfirst(Auth::user()->role ?? 'Admin') }}
                    </span>
                </div>

                <!-- Navigasi Profil -->
                <div class="py-1">
                    <a href="{{ route('profile.edit') }}"
                        class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-blue-50 hover:text-blue-600 transition-colors group">
                        <i class="fas fa-user-pen w-4 text-center text-slate-400 group-hover:text-blue-600"></i>
                        <span>Edit Profil</span>
                    </a>
                </div>

                <!-- Tombol Logout -->
                <div class="py-1">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-red-600 hover:bg-red-50 transition-colors text-left group">
                            <i
                                class="fas fa-arrow-right-from-bracket w-4 text-center text-red-400 group-hover:text-red-600"></i>
                            <span>Keluar</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Maskot Beruang Kanan Atas -->
        <div class="hidden md:block relative -mb-4">
            <img src="{{ asset('images/navbarDecoration.png') }}" alt="Maskot" class="w-36 h-auto object-contain">
        </div>
    </div>
</header>

<script>
    function updateClock() {
        const now = new Date();

        const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        const months = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        const dayName = days[now.getDay()];
        const dayNumber = String(now.getDate()).padStart(2, '0');
        const monthName = months[now.getMonth()];
        const year = now.getFullYear();

        const fullDate = `${dayName}, ${dayNumber} ${monthName} ${year}`;

        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');

        const fullTime = `${hours}:${minutes}:${seconds}`;

        document.getElementById('date-display').textContent = fullDate;
        document.getElementById('time-display').textContent = fullTime;
    }

    updateClock();
    setInterval(updateClock, 1000);
</script>