<?php

namespace App\Http\Middleware;

use Closure;

class AuthSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $sessionLogin = $request->session()->get('token');
        if (!$sessionLogin) {
            return redirect()->route('auth.form');
        } else {
            return $next($request);
        }
        return $next($request);
    }
}
