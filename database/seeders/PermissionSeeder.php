<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Definir permisos más específicos
        $permissions = [
            // Permisos de Administrador
            ['nombre' => 'Dashboard Completo', 'codigo' => 'admin.dashboard.full', 'descripcion' => 'Acceso total al dashboard con métricas clave'],
            ['nombre' => 'Gestión Completa de Usuarios', 'codigo' => 'admin.users.manage', 'descripcion' => 'Crear, modificar y eliminar cuentas de usuarios'],
            ['nombre' => 'Control Total de Base de Datos', 'codigo' => 'admin.database.full', 'descripcion' => 'Gestión completa de base de datos, respaldos y recuperación'],
            
            // Permisos de Usuario Máster
            ['nombre' => 'Consulta Detallada de Clientes', 'codigo' => 'master.clients.view', 'descripcion' => 'Acceso a información detallada de clientes, historial y transacciones'],
            ['nombre' => 'Bitácora de Administradores', 'codigo' => 'master.admin.logs', 'descripcion' => 'Acceso al registro de acciones de administradores'],
            ['nombre' => 'Log Transaccional', 'codigo' => 'master.transactions.log', 'descripcion' => 'Monitoreo y registro de todas las transacciones'],
            
            // Permisos de Operador (Solo Lectura)
            ['nombre' => 'Ver Parámetros Generales', 'codigo' => 'operator.parameters.view', 'descripcion' => 'Visualización de configuraciones básicas del sistema'],
            ['nombre' => 'Ver Contenido Internet Banking', 'codigo' => 'operator.internet.content.view', 'descripcion' => 'Visualización del contenido de banca en línea'],
            ['nombre' => 'Ver Servicios', 'codigo' => 'operator.services.view', 'descripcion' => 'Visualización de servicios bancarios']
        ];

        // Insertar permisos
        foreach ($permissions as $permission) {
            DB::table('permissions')->insert([
                'nombre' => $permission['nombre'],
                'codigo' => $permission['codigo'],
                'descripcion' => $permission['descripcion'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Asignar permisos a roles específicos
        $roles = [
            'Administrador' => [
                'admin.dashboard.full', 
                'admin.users.manage', 
                'admin.database.full'
            ],
            'Usuario Máster' => [
                'master.clients.view', 
                'master.admin.logs', 
                'master.transactions.log'
            ],
            'Operador' => [
                'operator.parameters.view', 
                'operator.internet.content.view', 
                'operator.services.view'
            ]
        ];

        foreach ($roles as $roleName => $rolePermissions) {
            $role = DB::table('roles')->where('nombre', $roleName)->first();
            
            foreach ($rolePermissions as $permissionCode) {
                $permission = DB::table('permissions')
                    ->where('codigo', $permissionCode)
                    ->first();
                
                if ($role && $permission) {
                    DB::table('role_permissions')->insert([
                        'role_id' => $role->id,
                        'permission_id' => $permission->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}
