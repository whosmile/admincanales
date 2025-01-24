<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LimiteServicio extends Model
{
    protected $table = 'limites_servicios';

    protected $fillable = [
        'servicio_id',
        'limite_minimo',
        'limite_maximo',
        'fecha_actualizacion',
        'actualizado_por'
    ];

    protected $casts = [
        'limite_minimo' => 'decimal:2',
        'limite_maximo' => 'decimal:2',
        'fecha_actualizacion' => 'datetime'
    ];

    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }
}
