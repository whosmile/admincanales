<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parametro extends Model
{
    protected $table = 'parametros';
    
    protected $fillable = [
        'codigo',
        'descripcion',
        'valor',
        'grupo_id'
    ];

    protected $casts = [
        'ES_EDITABLE' => 'boolean',
        'ES_VISIBLE' => 'boolean'
    ];

    public function grupo()
    {
        return $this->belongsTo(GrupoParametro::class, 'grupo_id');
    }
}
