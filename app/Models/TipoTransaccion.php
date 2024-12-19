<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoTransaccion extends Model
{
    protected $table = 'tipos_transaccion';
    
    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion'
    ];

    public function transacciones()
    {
        return $this->hasMany(Transaccion::class, 'tipo_transaccion_id');
    }
}
