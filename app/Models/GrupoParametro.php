<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrupoParametro extends Model
{
    protected $table = 'grupos_parametros';
    
    protected $fillable = [
        'nombre',
        'descripcion'
    ];

    public function parametros()
    {
        return $this->hasMany(Parametro::class, 'grupo_id');
    }
}
