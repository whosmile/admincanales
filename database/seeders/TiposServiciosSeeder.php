<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TiposServiciosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos = [
            [
                'codigo' => 'TELEFONIA',
                'nombre' => 'Telefonía',
                'descripcion' => 'Servicios de telefonía fija y móvil',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 'ELECTRICIDAD',
                'nombre' => 'Electricidad',
                'descripcion' => 'Servicios de energía eléctrica',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 'AGUA',
                'nombre' => 'Agua',
                'descripcion' => 'Servicios de agua potable',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 'INTERNET',
                'nombre' => 'Internet',
                'descripcion' => 'Servicios de internet',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 'TELEVISION',
                'nombre' => 'Televisión por Cable',
                'descripcion' => 'Servicios de televisión por cable y satelital',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 'GAS',
                'nombre' => 'Gas Natural',
                'descripcion' => 'Servicios de gas doméstico',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 'SEGUROS',
                'nombre' => 'Seguros',
                'descripcion' => 'Servicios de seguros',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 'IMPUESTOS',
                'nombre' => 'Impuestos',
                'descripcion' => 'Pagos de impuestos nacionales',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 'EDUCACION',
                'nombre' => 'Instituciones Educativas',
                'descripcion' => 'Pagos de instituciones educativas',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 'TARJETAS',
                'nombre' => 'Tarjetas de Crédito',
                'descripcion' => 'Pagos de tarjetas de crédito',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('tipos_servicios')->insert($tipos);
    }
}
