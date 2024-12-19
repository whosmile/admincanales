<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class LogTransaccionalService
{
    protected $channel = 'transaccional';

    public function log($message, $type = 'info', $context = [])
    {
        if (!$this->checkConfiguration()) {
            throw new \Exception('El módulo LOG-TRANSACCIONAL no está configurado correctamente en el sistema.');
        }

        Log::channel($this->channel)->$type($message, $context);
    }

    protected function checkConfiguration()
    {
        // Verificar que el canal existe en la configuración
        $channels = config('logging.channels');
        if (!isset($channels[$this->channel])) {
            return false;
        }

        // Verificar que el directorio de logs existe y es escribible
        $logPath = storage_path('logs');
        if (!file_exists($logPath)) {
            mkdir($logPath, 0755, true);
        }

        return is_writable($logPath);
    }

    public function searchByCode($codigo)
    {
        if (!$this->checkConfiguration()) {
            throw new \Exception('El módulo LOG-TRANSACCIONAL no está configurado correctamente en el sistema.');
        }

        $logPath = storage_path('logs/transaccional.log');
        if (!file_exists($logPath)) {
            return [];
        }

        $results = [];
        $handle = fopen($logPath, "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                $logEntry = json_decode($line, true);
                if ($logEntry && isset($logEntry['context']['codigo']) && $logEntry['context']['codigo'] === $codigo) {
                    $results[] = $logEntry;
                }
            }
            fclose($handle);
        }

        return $results;
    }
}
