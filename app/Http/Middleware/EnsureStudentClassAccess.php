<?php

namespace App\Http\Middleware;

use App\Models\Kelas;
use App\Models\Materi;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureStudentClassAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        abort_unless($user && $user->role === 'siswa', 403);

        $requestedClass = $request->route('kelas')
            ?? $request->route('kelas_id');

        if ($requestedClass === null && $request->route('kode_materi')) {
            $materi = Materi::where('kode_materi', $request->route('kode_materi'))->first();

            if (!$materi) {
                return $next($request);
            }

            $requestedClass = $materi->kelas_id;
        }

        $requestedClass ??= $request->input('kelas_id');

        if ($requestedClass === null) {
            return $next($request);
        }

        if ($requestedClass instanceof Kelas) {
            $requestedClassId = $requestedClass->id;
        } elseif (is_numeric($requestedClass)) {
            $requestedClassId = (int) $requestedClass;
        } else {
            $requestedClassId = Kelas::where('nama_kelas', $requestedClass)->value('id');
        }

        abort_unless(
            $user->kelas_id !== null
                && $requestedClassId !== null
                && (int) $user->kelas_id === (int) $requestedClassId,
            403
        );

        return $next($request);
    }
}