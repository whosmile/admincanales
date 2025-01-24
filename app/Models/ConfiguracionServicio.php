<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConfiguracionServicio extends Model
{
    protected $table = 'configuraciones_servicios';

    protected $fillable = [
        'servicio_id',
        'maxima_afiliacion',
        'requiere_verificacion',
        'parametros_adicionales',
        'fecha_actualizacion',
        'actualizado_por'
    ];

    protected $casts = [
        'requiere_verificacion' => 'boolean',
        'parametros_adicionales' => 'array',
        'fecha_actualizacion' => 'datetime'
    ];

    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }
}
