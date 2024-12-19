<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoTransaccion;

class TiposTransaccionSeeder extends Seeder
{
    public function run()
    {
        $tipos = [
            [
                'codigo' => 'PAGO',
                'nombre' => 'Pago de Servicio',
                'descripcion' => 'Pago de servicio realizado por el cliente'
            ],
            [
                'codigo' => 'RECA',
                'nombre' => 'Recarga',
                'descripcion' => 'Recarga de saldo'
            ],
            [
                'codigo' => 'CONS',
                'nombre' => 'Consulta',
                'descripcion' => 'Consulta de saldo o estado de cuenta'
            ],
            [
                'codigo' => 'TRAN',
                'nombre' => 'Transferencia',
                'descripcion' => 'Transferencia entre cuentas'
            ],
            [
                'codigo' => 'REVE',
                'nombre' => 'Reverso',
                'descripcion' => 'Reverso de transacción'
            ]
        ];

        foreach ($tipos as $tipo) {
            TipoTransaccion::firstOrCreate(
                ['codigo' => $tipo['codigo']],
                $tipo
            );
        }
    }
}
