<?php

namespace App\Providers;

use App\Services\LogTransaccionalService;
use Illuminate\Support\ServiceProvider;
use App\Traits\LogTransaccional;

class LogTransaccionalServiceProvider extends ServiceProvider
{
    use LogTransaccional;

    public function register()
    {
        $this->app->singleton(LogTransaccionalService::class, function ($app) {
            return new LogTransaccionalService();
        });
    }

    public function boot()
    {
        try {
            // Asegurarse de que el directorio de logs existe
            $logPath = storage_path('logs');
            if (!file_exists($logPath)) {
                mkdir($logPath, 0755, true);
            }

            // Inicializar la configuración del log transaccional
            $this->initializeLogTransaccional();

            // Registrar el canal de log en la configuración
            $this->app['config']->set('logging.channels.' . $this->logChannel, [
                'driver' => 'daily',
                'path' => storage_path('logs/transaccional.log'),
                'level' => 'debug',
                'days' => 14,
            ]);
        } catch (\Exception $e) {
            // Registrar el error pero no detener la aplicación
            \Log::error('Error al inicializar LOG-TRANSACCIONAL: ' . $e->getMessage());
        }
    }
}
