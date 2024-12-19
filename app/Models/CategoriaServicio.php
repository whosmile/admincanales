<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriaServicio extends Model
{
    protected $table = 'categorias_servicio';
    
    protected $fillable = [
        'nombre',
        'descripcion',
        'parent_id',
        'orden',
        'activo'
    ];

    protected $casts = [
        'activo' => 'boolean',
        'orden' => 'integer'
    ];

    public function parent()
    {
        return $this->belongsTo(CategoriaServicio::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(CategoriaServicio::class, 'parent_id');
    }

    public function servicios()
    {
        return $this->hasMany(Service::class, 'categoria_id');
    }

    // Método helper para obtener la ruta completa de la categoría
    public function getFullPathAttribute()
    {
        $path = [$this->nombre];
        $parent = $this->parent;
        
        while ($parent) {
            array_unshift($path, $parent->nombre);
            $parent = $parent->parent;
        }
        
        return implode(' > ', $path);
    }
}
