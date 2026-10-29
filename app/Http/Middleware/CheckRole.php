<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!Auth::check()){
            return redirect()->route('login');
        }

        $user = Auth::user();

        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        if ($user->role === 'guru') {
            return redirect()->route('admin.dashboard');
        }

        if ($user->role === 'siswa') {
            return redirect()->route('siswa.splash');
        }

        abort(403, 'Unauthorized action.');
        
    }
}
