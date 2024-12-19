<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiciosSeeder extends Seeder
{
    public function run()
    {
        $servicios = [
            // Telefonía Fija
            [
                'NOMBRE' => 'CANTV',
                'TIPO_SERVICIO' => 'TELEFONIA',
                'ESTATUS' => true,
                'LIMITE_MINIMO' => 50.00,
                'LIMITE_MAXIMO' => 1000.00,
                'MAXIMA_AFILIACION' => 3,
                'MULTIPLO' => 5.00,
                'FECHA_CREACION' => now(),
            ],

            // Telefonía Móvil
            [
                'NOMBRE' => 'Movistar',
                'TIPO_SERVICIO' => 'TELEFONIA_MOVIL',
                'ESTATUS' => true,
                'LIMITE_MINIMO' => 20.00,
                'LIMITE_MAXIMO' => 500.00,
                'MAXIMA_AFILIACION' => 5,
                'MULTIPLO' => 2.00,
                'FECHA_CREACION' => now(),
            ],
            [
                'NOMBRE' => 'Digitel',
                'TIPO_SERVICIO' => 'TELEFONIA_MOVIL',
                'ESTATUS' => true,
                'LIMITE_MINIMO' => 25.00,
                'LIMITE_MAXIMO' => 600.00,
                'MAXIMA_AFILIACION' => 5,
                'MULTIPLO' => 2.50,
                'FECHA_CREACION' => now(),
            ],

            // Televisión
            [
                'NOMBRE' => 'SimpleTV',
                'TIPO_SERVICIO' => 'TELEVISION',
                'ESTATUS' => true,
                'LIMITE_MINIMO' => 100.00,
                'LIMITE_MAXIMO' => 2000.00,
                'MAXIMA_AFILIACION' => 2,
                'MULTIPLO' => 10.00,
                'FECHA_CREACION' => now(),
            ],
            [
                'NOMBRE' => 'Inter',
                'TIPO_SERVICIO' => 'TELEVISION',
                'ESTATUS' => true,
                'LIMITE_MINIMO' => 120.00,
                'LIMITE_MAXIMO' => 2500.00,
                'MAXIMA_AFILIACION' => 2,
                'MULTIPLO' => 10.00,
                'FECHA_CREACION' => now(),
            ],

            // Agua
            [
                'NOMBRE' => 'Hidrocapital',
                'TIPO_SERVICIO' => 'AGUA',
                'ESTATUS' => true,
                'LIMITE_MINIMO' => 30.00,
                'LIMITE_MAXIMO' => 800.00,
                'MAXIMA_AFILIACION' => 1,
                'MULTIPLO' => 5.00,
                'FECHA_CREACION' => now(),
            ],

            // Gas
            [
                'NOMBRE' => 'PDVSA Gas',
                'TIPO_SERVICIO' => 'GAS',
                'ESTATUS' => true,
                'LIMITE_MINIMO' => 40.00,
                'LIMITE_MAXIMO' => 600.00,
                'MAXIMA_AFILIACION' => 1,
                'MULTIPLO' => 5.00,
                'FECHA_CREACION' => now(),
            ],

            // Electricidad
            [
                'NOMBRE' => 'Corpoelec',
                'TIPO_SERVICIO' => 'ELECTRICIDAD',
                'ESTATUS' => true,
                'LIMITE_MINIMO' => 80.00,
                'LIMITE_MAXIMO' => 3000.00,
                'MAXIMA_AFILIACION' => 1,
                'MULTIPLO' => 10.00,
                'FECHA_CREACION' => now(),
            ],

            // Internet
            [
                'NOMBRE' => 'CANTV ABA',
                'TIPO_SERVICIO' => 'INTERNET',
                'ESTATUS' => true,
                'LIMITE_MINIMO' => 150.00,
                'LIMITE_MAXIMO' => 2000.00,
                'MAXIMA_AFILIACION' => 2,
                'MULTIPLO' => 10.00,
                'FECHA_CREACION' => now(),
            ],
            [
                'NOMBRE' => 'NetUno',
                'TIPO_SERVICIO' => 'INTERNET',
                'ESTATUS' => true,
                'LIMITE_MINIMO' => 180.00,
                'LIMITE_MAXIMO' => 2500.00,
                'MAXIMA_AFILIACION' => 2,
                'MULTIPLO' => 10.00,
                'FECHA_CREACION' => now(),
            ],
        ];

        DB::table('servicios')->insert($servicios);
    }
}
