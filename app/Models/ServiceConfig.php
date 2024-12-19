<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceConfig extends Model
{
    protected $fillable = [
        'service_id',
        'tipo_config_id',
        'valor'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function tipoConfig()
    {
        return $this->belongsTo(TipoConfigServicio::class, 'tipo_config_id');
    }

    // Helper para obtener el valor tipado según el tipo de configuración
    public function getValorTipado()
    {
        if (!$this->tipoConfig) {
            return $this->valor;
        }

        switch ($this->tipoConfig->tipo_dato) {
            case TipoConfigServicio::TIPO_NUMERO:
                return is_numeric($this->valor) ? floatval($this->valor) : null;
            case TipoConfigServicio::TIPO_BOOLEANO:
                return filter_var($this->valor, FILTER_VALIDATE_BOOLEAN);
            case TipoConfigServicio::TIPO_FECHA:
                return \Carbon\Carbon::parse($this->valor);
            case TipoConfigServicio::TIPO_MULTIPLE:
                return json_decode($this->valor, true) ?? [];
            default:
                return $this->valor;
        }
    }
}
