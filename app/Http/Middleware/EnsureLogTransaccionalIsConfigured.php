<?php

namespace App\Http\Middleware;

use Closure;
use App\Traits\LogTransaccional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response;

class EnsureLogTransaccionalIsConfigured
{
    use LogTransaccional;

    public function handle(Request $request, Closure $next)
    {
        try {
            // Intentar inicializar la configuración
            $this->initializeLogTransaccional();
            
            // Verificar si la configuración fue exitosa
            if (!$this->isLogTransaccionalConfigured()) {
                throw new \Exception('No se pudo configurar el módulo LOG-TRANSACCIONAL.');
            }

            return $next($request);
        } catch (\Exception $e) {
            Log::error('Error en la configuración de LOG-TRANSACCIONAL: ' . $e->getMessage());
            
            return Response::json([
                'error' => 'El módulo LOG-TRANSACCIONAL no está configurado en el sistema.',
                'code' => 'LOG_TRANSACCIONAL_NOT_CONFIGURED',
                'details' => $e->getMessage()
            ], 500);
        }
    }
}
