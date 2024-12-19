<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServicioPago extends Model
{
    use SoftDeletes;

    protected $table = 'servicios_pagos';
    
    protected $fillable = [
        'servicio_id',
        'user_id',
        'monto',
        'metodo_pago_id',
        'referencia',
        'fecha_pago'
    ];

    protected $casts = [
        'monto' => 'decimal:2',
        'fecha_pago' => 'datetime'
    ];

    public function servicio()
    {
        return $this->belongsTo(Service::class, 'servicio_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function metodoPago()
    {
        return $this->belongsTo(MetodoPago::class);
    }
}
