<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckBanned
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Jika ada user dan dia dibanned
        if (Auth::check() && (bool) Auth::user()->banned) {
            // logout user, invalidate session, regenerasi token
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // redirect ke halaman login dengan pesan flash
            return redirect()->route('login')->withErrors([
                'email' => 'Akun Anda telah diblokir (banned). Hubungi admin.'
            ]);
            // atau: abort(403, 'Account banned.');
        }

        return $next($request);
    }
}
