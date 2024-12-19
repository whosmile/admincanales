<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ParameterSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener los IDs de los grupos
        $grupos = DB::table('grupos_parametros')
            ->whereIn('codigo', ['sistema', 'pagos', 'transferencias', 'seguridad', 'notificaciones', 'logs'])
            ->pluck('id', 'codigo');

        $parametros = [
            // Parámetros del sistema
            [
                'grupo_codigo' => 'sistema',
                'codigo' => 'sistema.version',
                'descripcion' => 'Versión actual del sistema de administración de canales',
                'valor' => '1.0.0',
                'es_editable' => false,
                'es_visible' => true,
            ],
            [
                'grupo_codigo' => 'sistema',
                'codigo' => 'sistema.nombre',
                'descripcion' => 'Nombre oficial del sistema para mostrar en la interfaz',
                'valor' => 'Admin Canales',
                'es_editable' => true,
                'es_visible' => true,
            ],
            
            // Parámetros de pagos
            [
                'grupo_codigo' => 'pagos',
                'codigo' => 'pagos.monto.minimo',
                'descripcion' => 'Monto mínimo permitido para transacciones de pago en el sistema',
                'valor' => '15',
                'es_editable' => true,
                'es_visible' => true,
            ],
            [
                'grupo_codigo' => 'pagos',
                'codigo' => 'pagos.monto.maximo',
                'descripcion' => 'Monto máximo permitido para transacciones de pago en el sistema',
                'valor' => '5900',
                'es_editable' => true,
                'es_visible' => true,
            ],
            
            // Parámetros de transferencias
            [
                'grupo_codigo' => 'transferencias',
                'codigo' => 'transferencias.monto.maximo',
                'descripcion' => 'Límite máximo permitido para transferencias entre cuentas diferentes',
                'valor' => '1600000',
                'es_editable' => true,
                'es_visible' => true,
            ],
            [
                'grupo_codigo' => 'transferencias',
                'codigo' => 'transferencias.internas.monto.maximo',
                'descripcion' => 'Límite máximo para transferencias entre cuentas del mismo titular (-1 sin límite)',
                'valor' => '-1',
                'es_editable' => true,
                'es_visible' => true,
            ],
            
            // Parámetros de seguridad
            [
                'grupo_codigo' => 'seguridad',
                'codigo' => 'seguridad.sesion.duracion',
                'descripcion' => 'Tiempo máximo de inactividad antes de cerrar la sesión (en minutos)',
                'valor' => '120',
                'es_editable' => true,
                'es_visible' => true,
            ],
            [
                'grupo_codigo' => 'seguridad',
                'codigo' => 'seguridad.intentos.maximos',
                'descripcion' => 'Número máximo de intentos fallidos de inicio de sesión antes del bloqueo',
                'valor' => '3',
                'es_editable' => true,
                'es_visible' => true,
            ],
            
            // Parámetros de notificaciones
            [
                'grupo_codigo' => 'notificaciones',
                'codigo' => 'notificaciones.email.habilitado',
                'descripcion' => 'Activa o desactiva el envío de notificaciones por correo electrónico',
                'valor' => 'true',
                'es_editable' => true,
                'es_visible' => true,
            ],
            
            // Parámetros de logs
            [
                'grupo_codigo' => 'logs',
                'codigo' => 'logs.dias.retencion',
                'descripcion' => 'Días que se mantienen los registros de actividad antes de ser archivados',
                'valor' => '90',
                'es_editable' => true,
                'es_visible' => true,
            ],
            [
                'grupo_codigo' => 'logs',
                'codigo' => 'logs.nivel.minimo',
                'descripcion' => 'Nivel mínimo de importancia para registrar eventos en los logs del sistema',
                'valor' => 'info',
                'es_editable' => true,
                'es_visible' => true,
            ]
        ];

        foreach ($parametros as $parametro) {
            $grupo_id = $grupos[$parametro['grupo_codigo']] ?? null;
            
            if ($grupo_id) {
                DB::table('parametros')->updateOrInsert(
                    ['codigo' => $parametro['codigo']],
                    [
                        'grupo_id' => $grupo_id,
                        'valor' => $parametro['valor'],
                        'descripcion' => $parametro['descripcion'],
                        'es_editable' => $parametro['es_editable'],
                        'es_visible' => $parametro['es_visible'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }
    }
}
