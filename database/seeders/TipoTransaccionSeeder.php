<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoTransaccionSeeder extends Seeder
{
    public function run()
    {
        $tipos = [
            [
                'nombre' => 'PAGO',
                'codigo' => 'PAGO',
                'descripcion' => 'Pago de servicio',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'RECARGA',
                'codigo' => 'RECARGA',
                'descripcion' => 'Recarga de saldo',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'TRANSFERENCIA',
                'codigo' => 'TRANSFERENCIA',
                'descripcion' => 'Transferencia entre cuentas',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        DB::table('tipo_transacciones')->insert($tipos);
    }
}
