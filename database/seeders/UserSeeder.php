<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener el ID del rol de administrador
        $adminRole = DB::table('roles')->where('nombre', 'Administrador')->first();
        $userRole = DB::table('roles')->where('nombre', 'Usuario')->first();
        $operadorRole = DB::table('roles')->where('nombre', 'Operador')->first();

        $users = [
            [
                'name' => 'Admin',
                'apellido' => 'Sistema',
                'email' => 'admin@admin.com',
                'username' => 'admin',
                'password' => Hash::make('password123'),
                'telefono' => '04141234567',
                'cedula' => 'V-12345678',
                'role_id' => $adminRole->id,
            ],
            [
                'name' => 'Usuario',
                'apellido' => 'Demo',
                'email' => 'usuario@demo.com',
                'username' => 'usuario',
                'password' => Hash::make('password123'),
                'telefono' => '04141234568',
                'cedula' => 'V-87654321',
                'role_id' => $userRole->id,
            ],
            [
                'name' => 'Operador',
                'apellido' => 'Sistema',
                'email' => 'operador@sistema.com',
                'username' => 'operador',
                'password' => Hash::make('password123'),
                'telefono' => '04141234569',
                'cedula' => 'V-11223344',
                'role_id' => $operadorRole->id,
            ],
        ];

        foreach ($users as $user) {
            DB::table('users')->insert($user);
        }
    }
}
