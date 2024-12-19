<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Crear módulos base del sistema
        $modulos = [
            [
                'codigo' => 'CLIENTES',
                'nombre' => 'Gestión de Clientes',
                'descripcion' => 'Módulo para la gestión y consulta de clientes del sistema',
                'activo' => true,
            ],
            [
                'codigo' => 'LOG-TRANSACCIONAL',
                'nombre' => 'Log Transaccional',
                'descripcion' => 'Módulo para la consulta y seguimiento de transacciones del sistema',
                'activo' => true,
            ],
            [
                'codigo' => 'PARAMETROS',
                'nombre' => 'Parámetros del Sistema',
                'descripcion' => 'Módulo para la configuración de parámetros del sistema',
                'activo' => true,
            ],
            [
                'codigo' => 'BITACORA',
                'nombre' => 'Bitácora del Sistema',
                'descripcion' => 'Módulo para la consulta de eventos y acciones del sistema',
                'activo' => true,
            ],
            [
                'codigo' => 'USUARIOS',
                'nombre' => 'Gestión de Usuarios',
                'descripcion' => 'Módulo para la administración de usuarios y roles',
                'activo' => true,
            ],
            [
                'codigo' => 'SERVICIOS',
                'nombre' => 'Gestión de Servicios',
                'descripcion' => 'Módulo para la administración de servicios y afiliaciones',
                'activo' => true,
            ]
        ];

        foreach ($modulos as $modulo) {
            DB::table('modulos')->updateOrInsert(
                ['codigo' => $modulo['codigo']],
                array_merge($modulo, [
                    'created_at' => now(),
                    'updated_at' => now()
                ])
            );
        }
    }

    public function down()
    {
        // No eliminamos los módulos en el rollback para mantener la integridad de los datos
    }
};
