Halo, {{ !empty($user->name) ? $user->name : 'Teman Pintar' }}! 👋

Kami menerima permintaan untuk mengatur ulang kata sandi akun BUBA (Belajar, Bermain, Berkembang) milikmu.

Untuk membuat kata sandi baru, silakan buka tautan berikut di peramban web:
{{ $url }}

Catatan Penting: Tautan atur ulang kata sandi ini akan kedaluwarsa dalam {{ $expireMinutes ?? config('auth.passwords.' . config('auth.defaults.passwords') . '.expire', 60) }} menit.
Jika kamu tidak merasa meminta pengaturan ulang kata sandi, tidak ada tindakan lebih lanjut yang diperlukan dan akunmu tetap aman.

Salam hangat & penuh semangat,
Tim BUBA (Belajar, Bermain, Berkembang)
© {{ date('Y') }} NAJATIF. All Right Reserved.
