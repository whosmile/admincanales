<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;

trait LogTransaccional
{
    protected $logChannel = 'transaccional';

    protected function initializeLogTransaccional()
    {
        // Crear el directorio de logs si no existe
        $logPath = storage_path('logs');
        if (!file_exists($logPath)) {
            mkdir($logPath, 0755, true);
        }

        // Verificar si el archivo de log existe, si no, crearlo
        $logFile = $logPath . '/transaccional.log';
        if (!file_exists($logFile)) {
            file_put_contents($logFile, '');
            chmod($logFile, 0644);
        }

        // Configurar el canal de log dinámicamente
        config(['logging.channels.' . $this->logChannel => [
            'driver' => 'daily',
            'path' => storage_path('logs/transaccional.log'),
            'level' => 'debug',
            'days' => 14,
        ]]);

        // Limpiar la caché de la configuración
        Artisan::call('config:clear');
    }

    protected function logTransaccional($message, $type = 'info', $context = [])
    {
        if (!$this->isLogTransaccionalConfigured()) {
            throw new \Exception('El módulo LOG-TRANSACCIONAL no está configurado en el sistema.');
        }

        try {
            Log::channel($this->logChannel)->$type($message, $context);
            return true;
        } catch (\Exception $e) {
            throw new \Exception('Error al escribir en el log transaccional: ' . $e->getMessage());
        }
    }

    protected function isLogTransaccionalConfigured()
    {
        try {
            // Verificar que el canal existe en la configuración
            if (!config('logging.channels.' . $this->logChannel)) {
                $this->initializeLogTransaccional();
            }

            // Verificar que el archivo de log existe y es escribible
            $logFile = storage_path('logs/transaccional.log');
            if (!file_exists($logFile) || !is_writable($logFile)) {
                return false;
            }

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
