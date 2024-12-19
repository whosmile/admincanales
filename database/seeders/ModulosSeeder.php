<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModulosSeeder extends Seeder
{
    public function run()
    {
        $modulos = [
            [
                'nombre' => 'DASHBOARD',
                'codigo' => 'DASHBOARD',
                'descripcion' => 'Módulo principal del dashboard',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'CLIENTES',
                'codigo' => 'CLIENTES',
                'descripcion' => 'Módulo de gestión de clientes',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'PARAMETROS',
                'codigo' => 'PARAMETROS',
                'descripcion' => 'Configuración de parámetros del sistema',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'BITACORA',
                'codigo' => 'BITACORA',
                'descripcion' => 'Registro de actividades del sistema',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'LOG-TRANSACCIONAL',
                'codigo' => 'LOG-TRANSACCIONAL',
                'descripcion' => 'Módulo de consulta de log transaccional',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        foreach ($modulos as $modulo) {
            DB::table('modulos')->updateOrInsert(
                ['codigo' => $modulo['codigo']],
                $modulo
            );
        }
    }
}
