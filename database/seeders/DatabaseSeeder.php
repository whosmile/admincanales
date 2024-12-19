<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            ModulosSeeder::class,
            PermissionSeeder::class,
            UserSeeder::class,
            ParameterGroupSeeder::class,
            ParameterSeeder::class,
            ServiceSeeder::class,
            TiposTransaccionSeeder::class,
            TransaccionesSeeder::class,
        ]);
    }
}
