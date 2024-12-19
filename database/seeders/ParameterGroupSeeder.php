<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ParameterGroupSeeder extends Seeder
{
    public function run(): void
    {
        $groups = [
            [
                'codigo' => 'sistema',
                'nombre' => 'Configuración del Sistema',
            ],
            [
                'codigo' => 'pagos',
                'nombre' => 'Configuración de Pagos',
            ],
            [
                'codigo' => 'transferencias',
                'nombre' => 'Configuración de Transferencias',
            ],
            [
                'codigo' => 'seguridad',
                'nombre' => 'Configuración de Seguridad',
            ],
            [
                'codigo' => 'notificaciones',
                'nombre' => 'Configuración de Notificaciones',
            ],
            [
                'codigo' => 'logs',
                'nombre' => 'Configuración de Logs',
            ]
        ];

        foreach ($groups as $group) {
            DB::table('grupos_parametros')->updateOrInsert(
                ['codigo' => $group['codigo']],
                [
                    'nombre' => $group['nombre'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
