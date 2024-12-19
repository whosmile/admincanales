<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BitacoraSeeder extends Seeder
{
    public function run(): void
    {
        $usuarios = ['admin', 'supervisor', 'operador'];
        $acciones = [
            'Crear Usuario',
            'Modificar Usuario',
            'Eliminar Usuario',
            'Consulta Cliente',
            'Modificar Límites',
            'Consulta Parámetros',
            'Inicio de Sesión',
            'Cierre de Sesión',
            'Actualizar Parámetro',
            'Consulta Log Transaccional'
        ];
        $tablas = ['users', 'parametros', 'transacciones', 'clientes', 'limites'];
        
        $registros = [];
        $fecha_base = Carbon::now()->subDays(30);
        
        for ($i = 0; $i < 100; $i++) {
            $fecha = $fecha_base->copy()->addMinutes(rand(0, 43200)); // Distribuir en 30 días
            
            $registros[] = [
                'usuario' => $usuarios[array_rand($usuarios)],
                'fecha_hora' => $fecha,
                'accion' => $acciones[array_rand($acciones)],
                'tabla' => $tablas[array_rand($tablas)],
                'ip' => rand(0, 1) ? '10.81.234.' . rand(1, 255) : '10.2.6.' . rand(1, 255),
                'detalles' => json_encode([
                    'navegador' => ['Chrome', 'Firefox', 'Edge'][rand(0, 2)],
                    'plataforma' => ['Windows', 'Linux', 'Mac'][rand(0, 2)],
                    'resultado' => ['Exitoso', 'Fallido'][rand(0, 1)]
                ]),
                'created_at' => $fecha,
                'updated_at' => $fecha
            ];
        }

        DB::table('bitacora')->insert($registros);
    }
}
