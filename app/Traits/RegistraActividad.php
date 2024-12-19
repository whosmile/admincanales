<?php

namespace App\Traits;

use App\Models\Bitacora;
use App\Models\Modulo;
use Illuminate\Support\Facades\Auth;

trait RegistraActividad
{
    protected static function bootRegistraActividad()
    {
        // Registrar creación
        static::created(function ($model) {
            self::registrarActividad('creación', 'Se creó un nuevo registro', null, $model->toArray());
        });

        // Registrar actualización
        static::updated(function ($model) {
            $datosPrevios = array_intersect_key($model->getOriginal(), $model->getDirty());
            $datosNuevos = $model->getDirty();
            self::registrarActividad('actualización', 'Se actualizó el registro', $datosPrevios, $datosNuevos);
        });

        // Registrar eliminación
        static::deleted(function ($model) {
            self::registrarActividad('eliminación', 'Se eliminó el registro', $model->toArray(), null);
        });
    }

    protected static function registrarActividad($accion, $descripcion, $datosPrevios = null, $datosNuevos = null)
    {
        $user = Auth::user();
        $moduloNombre = strtolower(class_basename(get_called_class()));
        
        // Obtener o crear el módulo
        $modulo = Modulo::firstOrCreate(
            ['codigo' => strtoupper($moduloNombre)],
            [
                'nombre' => ucfirst($moduloNombre),
                'descripcion' => 'Módulo de ' . ucfirst($moduloNombre),
                'activo' => true
            ]
        );

        Bitacora::create([
            'user_id' => $user ? $user->id : null,
            'usuario' => $user ? $user->name . ' ' . $user->apellido : 'Sistema',
            'accion' => $accion,
            'modulo_id' => $modulo->id,
            'detalles' => $descripcion,
            'datos_previos' => $datosPrevios ? json_encode($datosPrevios) : null,
            'datos_nuevos' => $datosNuevos ? json_encode($datosNuevos) : null,
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent()
        ]);
    }

    public static function registrarBusqueda($termino, $resultados = null)
    {
        $user = Auth::user();
        $moduloNombre = strtolower(class_basename(get_called_class()));
        
        // Obtener o crear el módulo
        $modulo = Modulo::firstOrCreate(
            ['codigo' => strtoupper($moduloNombre)],
            [
                'nombre' => ucfirst($moduloNombre),
                'descripcion' => 'Módulo de ' . ucfirst($moduloNombre),
                'activo' => true
            ]
        );

        Bitacora::create([
            'user_id' => $user ? $user->id : null,
            'usuario' => $user ? $user->name . ' ' . $user->apellido : 'Sistema',
            'accion' => 'búsqueda',
            'modulo_id' => $modulo->id,
            'detalles' => "Búsqueda realizada con término: {$termino}",
            'datos_previos' => null,
            'datos_nuevos' => $resultados ? json_encode($resultados) : null,
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent()
        ]);
    }
}
