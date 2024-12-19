<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SessionTimeout
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $lastActivity = Session::get('last_activity');
            $sessionLifetime = config('session.lifetime') * 60; // Convertir minutos a segundos

            if ($lastActivity && time() - $lastActivity > $sessionLifetime) {
                Auth::logout();
                Session::flush();
                return redirect()->route('login')->with('error', 'Su sesión ha expirado por inactividad.');
            }

            Session::put('last_activity', time());
        }

        return $next($request);
    }
}
