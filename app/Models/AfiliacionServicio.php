<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AfiliacionServicio extends Model
{
    protected $table = 'afiliaciones_servicio';

    protected $fillable = [
        'user_id',
        'servicio_id',
        'numero_servicio',
        'alias',
        'estatus',
        'fecha_afiliacion',
        'fecha_desafiliacion'
    ];

    protected $casts = [
        'fecha_afiliacion' => 'datetime',
        'fecha_desafiliacion' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }
}
