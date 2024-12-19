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
                'descripcion' => 'Rol con acceso completo al sistema',
            ],
            [
                'nombre' => 'Usuario',
                'descripcion' => 'Usuario regular del sistema',
            ],
            [
                'nombre' => 'Operador',
                'descripcion' => 'Operador con acceso a funciones específicas',
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
