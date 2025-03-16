<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebTransactionalLog extends Model
{
    protected $fillable = [
        'user_id',
        'usuario',
        'accion',
        'modulo',
        'tabla_afectada',
        'detalles',
        'datos_anteriores',
        'datos_nuevos',
        'parametros_busqueda',
        'total_resultados',
        'criterio_busqueda',
        'filtros_aplicados',
        'ip',
        'user_agent'
    ];

    protected $casts = [
        'datos_anteriores' => 'json',
        'datos_nuevos' => 'json',
        'parametros_busqueda' => 'json'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
