@extends('layouts.admin.app')

@section('content')
    <!-- Di sini Anda isi konten utama seperti di gambar -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-white">Halo, Admin!</h1>
        <p class="text-slate-400 mt-1">Selamat datang di Dashboard Buba.</p>
        <p class="text-slate-400">Kelola semua fitur pembelajaran dengan mudah di sini.</p>
    </div>

    <!-- Contoh Grid Kartu Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Kartu Total Materi -->
        <div class="bg-[#1e293b] p-6 rounded-2xl border border-slate-700 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-blue-500/20 flex items-center justify-center text-blue-400">
                <i class="fas fa-book text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-slate-400">Total Materi</p>
                <p class="text-2xl font-bold text-white">20</p>
            </div>
        </div>
        <!-- Tambahkan kartu lain sesuai gambar -->
    </div>
@endsection