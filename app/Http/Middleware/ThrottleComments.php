<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class ThrottleComments
{
    /**
     * Handle an incoming request to prevent comment spam
     */
    public function handle(Request $request, Closure $next): Response
    {
        $key = 'comment:' . $request->user()->id;

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);

            session()->flash('error', "Terlalu banyak komentar. Silakan coba lagi dalam {$seconds} detik.");
            return back();
        }

        RateLimiter::hit($key, 60); // 5 comments per minute

        return $next($request);
    }
}
