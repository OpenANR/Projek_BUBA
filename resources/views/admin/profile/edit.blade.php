@extends('layouts.admin.app')
@section('title', 'Edit Profil - BUBA')

@section('content')
    <div class="max-w-4xl mx-auto space-y-8 pb-12">
        <!-- Header Halaman -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-gray-200/80 pb-5">
            <div>
                <h1 class="text-2xl font-bold text-slate-800 flex items-center gap-2">
                    <i class="fas fa-user-circle text-blue-600"></i> Edit Profil
                </h1>
                <p class="text-sm text-slate-500 mt-1">Perbarui informasi profil dan kata sandi akun admin Anda.</p>
            </div>
            <a href="{{ route('admin.dashboard') }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-lg transition self-start sm:self-auto">
                <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
            </a>
        </div>

        <!-- Notifikasi Status Profil -->
        @if (session('status') === 'profile-updated')
            <div x-data="{ show: true }" x-show="show" x-transition
                class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-xl shadow-sm flex items-center justify-between"
                role="alert">
                <div class="flex items-center gap-2">
                    <i class="fas fa-check-circle text-green-600"></i>
                    <span class="text-sm font-medium">Informasi profil berhasil diperbarui.</span>
                </div>
                <button @click="show = false" class="text-green-600 hover:text-green-800">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        <!-- Notifikasi Status Password -->
        @if (session('status') === 'password-updated')
            <div x-data="{ show: true }" x-show="show" x-transition
                class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-xl shadow-sm flex items-center justify-between"
                role="alert">
                <div class="flex items-center gap-2">
                    <i class="fas fa-check-circle text-green-600"></i>
                    <span class="text-sm font-medium">Kata sandi berhasil diperbarui.</span>
                </div>
                <button @click="show = false" class="text-green-600 hover:text-green-800">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        <!-- 1. INFORMASI PROFIL -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8">
            <div class="border-b border-gray-100 pb-4 mb-6">
                <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <i class="fas fa-id-card text-blue-500"></i> Informasi Profil
                </h2>
                <p class="text-sm text-slate-500 mt-1">Perbarui nama dan alamat email akun admin Anda.</p>
            </div>

            <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                @csrf
            </form>

            <form method="post" action="{{ route('profile.update') }}" class="space-y-5 max-w-xl">
                @csrf
                @method('patch')

                <!-- Kode User / Role (Readonly Info) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">
                            Kode Akun
                        </label>
                        <input type="text" value="{{ $user->kode_user ?? '-' }}" disabled
                            class="w-full px-4 py-2.5 text-slate-500 bg-slate-100 border border-gray-200 rounded-lg text-sm cursor-not-allowed">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">
                            Peran / Role
                        </label>
                        <input type="text" value="{{ ucfirst($user->role ?? 'Guru') }}" disabled
                            class="w-full px-4 py-2.5 text-slate-500 bg-slate-100 border border-gray-200 rounded-lg text-sm cursor-not-allowed">
                    </div>
                </div>

                <!-- Nama -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name"
                        class="w-full px-4 py-2.5 text-black border @error('name') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-sm">
                    @error('name')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">
                        Alamat Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="username"
                        class="w-full px-4 py-2.5 text-black border @error('email') border-red-500 ring-1 ring-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-sm">
                    @error('email')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror

                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                        <div class="mt-3 p-3 bg-amber-50 border border-amber-200 rounded-lg">
                            <p class="text-xs text-amber-800">
                                Alamat email Anda belum diverifikasi.
                                <button form="send-verification" class="underline text-amber-900 font-semibold hover:text-amber-700 ml-1">
                                    Klik di sini untuk mengirim ulang email verifikasi.
                                </button>
                            </p>
                            @if (session('status') === 'verification-link-sent')
                                <p class="mt-1.5 font-medium text-xs text-green-600">
                                    Tautan verifikasi baru telah dikirim ke alamat email Anda.
                                </p>
                            @endif
                        </div>
                    @endif
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit"
                        class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2.5 rounded-lg shadow-sm transition text-sm">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        <!-- 2. PERBARUI KATA SANDI -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8">
            <div class="border-b border-gray-100 pb-4 mb-6">
                <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <i class="fas fa-lock text-teal-500"></i> Perbarui Kata Sandi
                </h2>
                <p class="text-sm text-slate-500 mt-1">Pastikan akun Anda menggunakan kata sandi yang panjang dan aman.</p>
            </div>

            <form method="post" action="{{ route('password.update') }}" class="space-y-5 max-w-xl">
                @csrf
                @method('put')

                <!-- Password Saat Ini -->
                <div>
                    <label for="update_password_current_password" class="block text-sm font-semibold text-gray-700 mb-1">
                        Kata Sandi Saat Ini <span class="text-red-500">*</span>
                    </label>
                    <input type="password" id="update_password_current_password" name="current_password" autocomplete="current-password"
                        class="w-full px-4 py-2.5 text-black border {{ $errors->updatePassword->has('current_password') ? 'border-red-500 ring-1 ring-red-500' : 'border-gray-300' }} rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-sm">
                    @if ($errors->updatePassword->has('current_password'))
                        <p class="mt-1 text-xs text-red-600">{{ $errors->updatePassword->first('current_password') }}</p>
                    @endif
                </div>

                <!-- Password Baru -->
                <div>
                    <label for="update_password_password" class="block text-sm font-semibold text-gray-700 mb-1">
                        Kata Sandi Baru <span class="text-red-500">*</span>
                    </label>
                    <input type="password" id="update_password_password" name="password" autocomplete="new-password"
                        class="w-full px-4 py-2.5 text-black border {{ $errors->updatePassword->has('password') ? 'border-red-500 ring-1 ring-red-500' : 'border-gray-300' }} rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-sm">
                    @if ($errors->updatePassword->has('password'))
                        <p class="mt-1 text-xs text-red-600">{{ $errors->updatePassword->first('password') }}</p>
                    @endif
                </div>

                <!-- Konfirmasi Password Baru -->
                <div>
                    <label for="update_password_password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1">
                        Konfirmasi Kata Sandi Baru <span class="text-red-500">*</span>
                    </label>
                    <input type="password" id="update_password_password_confirmation" name="password_confirmation" autocomplete="new-password"
                        class="w-full px-4 py-2.5 text-black border {{ $errors->updatePassword->has('password_confirmation') ? 'border-red-500 ring-1 ring-red-500' : 'border-gray-300' }} rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-sm">
                    @if ($errors->updatePassword->has('password_confirmation'))
                        <p class="mt-1 text-xs text-red-600">{{ $errors->updatePassword->first('password_confirmation') }}</p>
                    @endif
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit"
                        class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2.5 rounded-lg shadow-sm transition text-sm">
                        <i class="fas fa-key"></i> Simpan Kata Sandi
                    </button>
                </div>
            </form>
        </div>

        <!-- 3. HAPUS AKUN -->
        <div class="bg-white rounded-2xl border border-red-200 shadow-sm p-6 sm:p-8" x-data="{ showConfirmModal: {{ $errors->userDeletion->isNotEmpty() ? 'true' : 'false' }} }">
            <div class="border-b border-gray-100 pb-4 mb-4">
                <h2 class="text-lg font-bold text-red-600 flex items-center gap-2">
                    <i class="fas fa-triangle-exclamation"></i> Hapus Akun
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Setelah akun Anda dihapus, semua sumber daya dan datanya akan dihapus secara permanen. Sebelum menghapus akun Anda, harap unduh data apa pun yang ingin Anda simpan.
                </p>
            </div>

            <button type="button" @click="showConfirmModal = true"
                class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2.5 rounded-lg shadow-sm transition text-sm">
                <i class="fas fa-trash"></i> Hapus Akun Saya
            </button>

            <!-- Modal Konfirmasi Hapus Akun -->
            <div x-show="showConfirmModal"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 z-50 overflow-y-auto px-4 py-6 sm:px-0 flex items-center justify-center"
                 style="display: none;">
                
                <!-- Backdrop -->
                <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" @click="showConfirmModal = false"></div>

                <!-- Modal Dialog -->
                <div class="relative bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl border border-slate-200 z-10"
                     @keydown.escape.window="showConfirmModal = false">
                    <form method="post" action="{{ route('profile.destroy') }}">
                        @csrf
                        @method('delete')

                        <div class="flex items-center gap-3 text-red-600 mb-3">
                            <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center shrink-0">
                                <i class="fas fa-exclamation-triangle text-red-600 text-lg"></i>
                            </div>
                            <h3 class="text-lg font-bold text-slate-800">Apakah Anda yakin ingin menghapus akun?</h3>
                        </div>

                        <p class="text-sm text-slate-500 mb-4">
                            Setelah akun Anda dihapus, semua sumber daya dan datanya akan dihapus secara permanen. Silakan masukkan kata sandi Anda untuk mengonfirmasi bahwa Anda ingin menghapus akun secara permanen.
                        </p>

                        <div class="mb-5">
                            <label for="delete_password" class="block text-sm font-semibold text-gray-700 mb-1">
                                Kata Sandi <span class="text-red-500">*</span>
                            </label>
                            <input type="password" id="delete_password" name="password" placeholder="Masukkan kata sandi Anda"
                                class="w-full px-4 py-2.5 text-black border {{ $errors->userDeletion->has('password') ? 'border-red-500 ring-1 ring-red-500' : 'border-gray-300' }} rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition text-sm">
                            @if ($errors->userDeletion->has('password'))
                                <p class="mt-1 text-xs text-red-600">{{ $errors->userDeletion->first('password') }}</p>
                            @endif
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-3 border-t border-gray-100">
                            <button type="button" @click="showConfirmModal = false"
                                class="px-4 py-2 text-sm font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition">
                                Batal
                            </button>
                            <button type="submit"
                                class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded-lg shadow transition text-sm">
                                <i class="fas fa-trash"></i> Ya, Hapus Akun
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
