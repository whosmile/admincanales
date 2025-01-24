<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class CheckOperatorAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the current user is authenticated
        if (Auth::check()) {
            // Get the authenticated user with role relationship
            $user = User::with('role')
                ->where('id', Auth::id())
                ->first();
            
            // Check if user has Operador role
            if ($user && $user->role && $user->role->nombre === 'Operador') {
                // List of routes that Operador should not access
                $restrictedRoutes = [
                    'servicios.edit',
                    'servicios.update',
                    'parametros.edit',
                    'parametros.update',
                    'parametros.create',  // Prevent creating new parameters
                    'parametros.store',   // Prevent storing new parameters
                    'servicios.create',   // Prevent creating new services
                    'servicios.store',    // Prevent storing new services
                    // Add more restricted routes as needed
                ];

                // Get the current route name
                $currentRouteName = $request->route()->getName();

                // If the current route is in the restricted list, abort with a 403 error
                if (in_array($currentRouteName, $restrictedRoutes)) {
                    abort(403, 'No tienes permiso para realizar esta acción.');
                }
            }
        }

        return $next($request);
    }
}
