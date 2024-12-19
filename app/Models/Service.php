<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'categoria_id',
        'nombre',
        'descripcion',
        'precio',
        'activo'
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'activo' => 'boolean'
    ];

    public function categoria()
    {
        return $this->belongsTo(CategoriaServicio::class, 'categoria_id');
    }

    public function configuraciones()
    {
        return $this->hasMany(ServiceConfig::class);
    }

    public function pagos()
    {
        return $this->hasMany(ServicioPago::class, 'servicio_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'service_affiliations')
            ->withPivot(['fecha_inicio', 'fecha_fin', 'estado'])
            ->withTimestamps();
    }
}
