<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            ['nombre' => 'Ver Dashboard', 'codigo' => 'dashboard.view', 'descripcion' => 'Permite ver el dashboard'],
            ['nombre' => 'Gestionar Usuarios', 'codigo' => 'users.manage', 'descripcion' => 'Permite gestionar usuarios'],
            ['nombre' => 'Gestionar Roles', 'codigo' => 'roles.manage', 'descripcion' => 'Permite gestionar roles'],
            ['nombre' => 'Gestionar Servicios', 'codigo' => 'services.manage', 'descripcion' => 'Permite gestionar servicios'],
            ['nombre' => 'Ver Transacciones', 'codigo' => 'transactions.view', 'descripcion' => 'Permite ver transacciones'],
            ['nombre' => 'Realizar Transacciones', 'codigo' => 'transactions.create', 'descripcion' => 'Permite realizar transacciones'],
            ['nombre' => 'Gestionar Parámetros', 'codigo' => 'parameters.manage', 'descripcion' => 'Permite gestionar parámetros del sistema'],
        ];

        foreach ($permissions as $permission) {
            DB::table('permissions')->insert([
                'nombre' => $permission['nombre'],
                'codigo' => $permission['codigo'],
                'descripcion' => $permission['descripcion'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Asignar permisos al rol de administrador
        $adminRole = DB::table('roles')->where('nombre', 'Administrador')->first();
        $allPermissions = DB::table('permissions')->get();
        
        foreach ($allPermissions as $permission) {
            DB::table('role_permissions')->insert([
                'role_id' => $adminRole->id,
                'permission_id' => $permission->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
