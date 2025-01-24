<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $table = 'servicios';

    protected $fillable = [
        'tipo_servicio_id',
        'empresa_servicio_id',
        'nombre',
        'empresa',
        'codigo_servicio',
        'activo',
        'descripcion'
    ];

    protected $casts = [
        'activo' => 'boolean'
    ];

    // Relaciones
    public function tipoServicio()
    {
        return $this->belongsTo(TipoServicio::class);
    }

    public function empresaServicio()
    {
        return $this->belongsTo(EmpresaServicio::class);
    }

    public function limites()
    {
        return $this->hasMany(LimiteServicio::class);
    }

    public function configuracion()
    {
        return $this->hasMany(ConfiguracionServicio::class);
    }

    public function afiliaciones()
    {
        return $this->hasMany(AfiliacionServicio::class);
    }

    public function transacciones()
    {
        return $this->hasMany(Transaccion::class);
    }

    // Obtener el límite actual
    public function limiteActual()
    {
        return $this->hasOne(LimiteServicio::class)
            ->orderBy('fecha_actualizacion', 'desc');
    }

    // Obtener la configuración actual
    public function configuracionActual()
    {
        return $this->hasOne(ConfiguracionServicio::class)
            ->orderBy('fecha_actualizacion', 'desc');
    }
}
