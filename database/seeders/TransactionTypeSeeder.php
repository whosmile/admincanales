<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            [
                'codigo' => 'PAGO_SERVICIO',
                'nombre' => 'Pago de Servicio',
                'descripcion' => 'Pago de servicios públicos o privados'
            ],
            [
                'codigo' => 'TRANSFERENCIA',
                'nombre' => 'Transferencia',
                'descripcion' => 'Transferencia entre cuentas'
            ],
            [
                'codigo' => 'RECARGA',
                'nombre' => 'Recarga',
                'descripcion' => 'Recarga de servicios prepagados'
            ],
        ];

        foreach ($types as $type) {
            DB::table('transaction_types')->insert([
                'codigo' => $type['codigo'],
                'nombre' => $type['nombre'],
                'descripcion' => $type['descripcion'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
