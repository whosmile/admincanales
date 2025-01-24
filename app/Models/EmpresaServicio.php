<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmpresaServicio extends Model
{
    protected $table = 'empresas_servicios';

    protected $fillable = [
        'nombre',
        'rif',
        'direccion',
        'telefono',
        'email',
        'persona_contacto',
        'estatus'
    ];

    protected $casts = [
        'estatus' => 'string'
    ];

    public function servicios()
    {
        return $this->hasMany(Servicio::class);
    }
}
