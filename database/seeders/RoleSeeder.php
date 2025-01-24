<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'nombre' => 'Administrador',
                'descripcion' => 'Rol con acceso total y privilegios completos. Gestiona usuarios, base de datos y tiene visibilidad total del sistema.',
            ],
            [
                'nombre' => 'Usuario Máster',
                'descripcion' => 'Rol con alto nivel de control. Acceso a consultas de clientes, bitácoras de administradores y logs transaccionales.',
            ],
            [
                'nombre' => 'Operador',
                'descripcion' => 'Rol para tareas operativas básicas. Gestiona parámetros generales, contenido de Internet Banking y servicios.',
            ],
        ];

        foreach ($roles as $role) {
            DB::table('roles')->insert([
                'nombre' => $role['nombre'],
                'descripcion' => $role['descripcion'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
