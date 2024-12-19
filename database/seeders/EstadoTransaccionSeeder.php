<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadoTransaccionSeeder extends Seeder
{
    public function run()
    {
        $estados = [
            [
                'nombre' => 'COMPLETADA',
                'codigo' => 'COMPLETADA',
                'descripcion' => 'Transacción completada exitosamente',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'PENDIENTE',
                'codigo' => 'PENDIENTE',
                'descripcion' => 'Transacción en proceso',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'FALLIDA',
                'codigo' => 'FALLIDA',
                'descripcion' => 'Transacción fallida',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        DB::table('estado_transacciones')->insert($estados);
    }
}
