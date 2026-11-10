<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // 1. Validasi input (gunakan rule string)
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // 2. Cari user beserta relasi kelasnya
        $user = User::with('kelas')->where('email', $request->email)->first();

        // 3. Cek keberadaan user dan password
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau kata sandi salah.',
            ], 401);
        }

        // 4. Pastikan hanya role siswa yang login ke aplikasi Flutter
        if ($user->role !== 'siswa') {
            return response()->json([
                'success' => false,
                'message' => 'Akses ditolak. Aplikasi ini hanya diperuntukkan bagi siswa.',
            ], 403);
        }

        // 5. Generate Personal Access Token Sanctum
        $token = $user->createToken('buba_flutter_siswa_token')->plainTextToken;

        if (!$user->hasVerifiedEmail()) {
            // Kirim email verifikasi ke Mailtrap
            $user->sendEmailVerificationNotification();

            return response()->json([
                'success' => true,
                'email_verified' => false,
                'message' => 'Email Anda belum diverifikasi. Link verifikasi telah dikirimkan ke email Anda.',
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => [
                    'id' => $user->id,
                    'kode_user' => $user->kode_user,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'jenis_kelamin' => $user->jenis_kelamin,
                    'kelas' => $user->kelas ? [
                        'id' => $user->kelas->id,
                        'nama_kelas' => $user->kelas->nama_kelas,
                    ] : null,
                ],
            ], 200);
        }

        return response()->json([
            'success' => true,
            'email_verified' => true,
            'message' => 'Login berhasil.',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => [
                'id' => $user->id,
                'kode_user' => $user->kode_user,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'jenis_kelamin' => $user->jenis_kelamin,
                'kelas' => $user->kelas ? [
                    'id' => $user->kelas->id,
                    'nama_kelas' => $user->kelas->nama_kelas,
                ] : null,
            ],
        ], 200);
    }

    public function checkEmailStatus(Request $request)
    {
        $user = $request->user()->fresh()->load('kelas');

        return response()->json([
            'success' => true,
            'email_verified' => $user->hasVerifiedEmail(),
            'user' => [
                'id' => $user->id,
                'kode_user' => $user->kode_user,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'jenis_kelamin' => $user->jenis_kelamin,
                'kelas' => $user->kelas ? [
                    'id' => $user->kelas->id,
                    'nama_kelas' => $user->kelas->nama_kelas,
                ] : null,
            ],
        ]);
    }

    public function resendVerificationEmail(Request $request)
    {
        $user = $request->user();
        if ($user->hasVerifiedEmail()) {
            return response()->json([
                'success' => false,
                'message' => 'Email Anda sudah terverifikasi.',
            ], 400);
        }
        $user->sendEmailVerificationNotification();
        return response()->json([
            'success' => true,
            'message' => 'Email verifikasi berhasil dikirim ulang.',
        ]);
    }

    public function logout(Request $request)
    {
        // Hapus token yang sedang digunakan saat ini
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil logout.',
        ], 200);
    }

    public function me(Request $request)
    {
        $user = $request->user()->load('kelas');

        return response()->json([
            'success' => true,
            'user' => [
                'id' => $user->id,
                'kode_user' => $user->kode_user,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'jenis_kelamin' => $user->jenis_kelamin,
                'kelas' => $user->kelas ? [
                    'id' => $user->kelas->id,
                    'nama_kelas' => $user->kelas->nama_kelas,
                ] : null,
            ],
        ], 200);
    }
}
