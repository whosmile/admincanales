<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadoTransaccion extends Model
{
    protected $table = 'estados_transaccion';
    
    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion'
    ];

    public function transacciones()
    {
        return $this->hasMany(Transaccion::class, 'estado_id');
    }

    // Constantes para los estados
    const PENDIENTE = 'PENDIENTE';
    const PROCESANDO = 'PROCESANDO';
    const COMPLETADA = 'COMPLETADA';
    const FALLIDA = 'FALLIDA';
    const CANCELADA = 'CANCELADA';
}
