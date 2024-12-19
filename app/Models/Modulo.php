<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modulo extends Model
{
    protected $table = 'modulos';
    
    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion'
    ];

    public function bitacoras()
    {
        return $this->hasMany(Bitacora::class);
    }
}
