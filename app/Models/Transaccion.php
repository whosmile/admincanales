<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaccion extends Model
{
    use SoftDeletes;

    protected $table = 'transacciones';

    protected $fillable = [
        'user_id',
        'tipo_transaccion_id',
        'cedula',
        'fecha_hora',
        'origen',
        'destino',
        'monto',
        'descripcion',
        'ref',
        'ip'
    ];

    protected $casts = [
        'fecha_hora' => 'datetime',
        'monto' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tipoTransaccion()
    {
        return $this->belongsTo(TipoTransaccion::class, 'tipo_transaccion_id');
    }
}
