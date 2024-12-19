<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        // Servicios de telefonía
        $telefonia = DB::table('servicios')->insertGetId([
            'nombre' => 'Servicio de Telefonía',
            'tipo_servicio' => 'telefonia',
            'estatus' => 'Activo',
            'limite_minimo' => 5.00,
            'limite_maximo' => 1000.00,
            'maxima_afiliacion' => 5,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Servicio de electricidad
        $electricidad = DB::table('servicios')->insertGetId([
            'nombre' => 'Servicio Eléctrico',
            'tipo_servicio' => 'electricidad',
            'estatus' => 'Activo',
            'limite_minimo' => 10.00,
            'limite_maximo' => 5000.00,
            'maxima_afiliacion' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Servicio de agua
        $agua = DB::table('servicios')->insertGetId([
            'nombre' => 'Servicio de Agua',
            'tipo_servicio' => 'agua',
            'estatus' => 'Activo',
            'limite_minimo' => 5.00,
            'limite_maximo' => 2000.00,
            'maxima_afiliacion' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Servicio de TV
        $tv = DB::table('servicios')->insertGetId([
            'nombre' => 'Servicio de TV',
            'tipo_servicio' => 'tv',
            'estatus' => 'Activo',
            'limite_minimo' => 15.00,
            'limite_maximo' => 500.00,
            'maxima_afiliacion' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
