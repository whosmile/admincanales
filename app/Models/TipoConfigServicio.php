<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoConfigServicio extends Model
{
    protected $table = 'tipos_config_servicio';
    
    protected $fillable = [
        'nombre',
        'tipo_dato',
        'validacion',
        'descripcion',
        'requerido',
        'opciones'
    ];

    protected $casts = [
        'requerido' => 'boolean',
        'opciones' => 'array'
    ];

    public function configuraciones()
    {
        return $this->hasMany(ServiceConfig::class, 'tipo_config_id');
    }

    // Tipos de datos disponibles
    const TIPO_TEXTO = 'text';
    const TIPO_NUMERO = 'number';
    const TIPO_BOOLEANO = 'boolean';
    const TIPO_FECHA = 'date';
    const TIPO_SELECCION = 'select';
    const TIPO_MULTIPLE = 'multiple';

    public static function getTiposDato()
    {
        return [
            self::TIPO_TEXTO => 'Texto',
            self::TIPO_NUMERO => 'Número',
            self::TIPO_BOOLEANO => 'Si/No',
            self::TIPO_FECHA => 'Fecha',
            self::TIPO_SELECCION => 'Selección única',
            self::TIPO_MULTIPLE => 'Selección múltiple'
        ];
    }
}
