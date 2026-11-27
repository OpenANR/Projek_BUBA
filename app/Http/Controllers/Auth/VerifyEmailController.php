<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VerifyEmailController extends Controller
{
    /**
     * Mark the user's email address as verified.
     *
     * Route ini sengaja tidak memakai middleware auth agar tautan dari email
     * tetap bisa dibuka di browser/perangkat mana pun (alur mobile).
     */
    public function __invoke(Request $request, string $id, string $hash): RedirectResponse|View
    {
        $user = User::findOrFail($id);

        if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            abort(403, 'Tautan verifikasi tidak valid.');
        }

        if (! $user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            event(new Verified($user));
        }

        if ($request->user()) {
            $targetRoute = $request->user()->role === 'siswa'
                ? route('siswa.splash', absolute: false)
                : route('admin.dashboard', absolute: false);

            return redirect()->intended($targetRoute . '?verified=1');
        }

        return view('auth.verify-email-success', [
            'user' => $user,
        ]);
    }
}
