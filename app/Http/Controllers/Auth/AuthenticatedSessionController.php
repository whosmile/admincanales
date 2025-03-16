<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\WebTransactionalLog;
use App\Models\BitacoraAdministrativa;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Registrar el cierre de sesión en ambas bitácoras antes de cerrar la sesión
        $user = Auth::user();
        
        if ($user) {
            $logData = [
                'user_id' => $user->id,
                'usuario' => $user->name . ' ' . $user->apellido,
                'accion' => 'cierre_sesion',
                'modulo' => 'Autenticación',
                'detalles' => 'El usuario ha cerrado sesión en el sistema',
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ];

            WebTransactionalLog::create($logData);
            BitacoraAdministrativa::create($logData);
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
