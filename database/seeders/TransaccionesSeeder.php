<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaccion;
use App\Models\TipoTransaccion;
use App\Models\User;
use Carbon\Carbon;

class TransaccionesSeeder extends Seeder
{
    public function run()
    {
        // Obtener usuarios y tipos de transacción
        $users = User::all();
        $tiposTransaccion = TipoTransaccion::all();

        if ($users->isEmpty() || $tiposTransaccion->isEmpty()) {
            return;
        }

        // Crear algunas transacciones de prueba
        $transacciones = [
            [
                'user_id' => $users->random()->id,
                'tipo_transaccion_id' => $tiposTransaccion->where('codigo', 'PAGO')->first()->id,
                'cedula' => 'V-12345678',
                'fecha_hora' => Carbon::now()->subDays(2),
                'origen' => 'Cuenta 1234',
                'destino' => 'Servicio XYZ',
                'monto' => 150.00,
                'descripcion' => 'Pago de servicio mensual',
                'ref' => 'REF-' . rand(1000, 9999),
                'ip' => '192.168.1.' . rand(1, 255)
            ],
            [
                'user_id' => $users->random()->id,
                'tipo_transaccion_id' => $tiposTransaccion->where('codigo', 'RECA')->first()->id,
                'cedula' => 'V-87654321',
                'fecha_hora' => Carbon::now()->subDay(),
                'origen' => 'Agente 5678',
                'destino' => 'Cuenta 9876',
                'monto' => 200.00,
                'descripcion' => 'Recarga de saldo',
                'ref' => 'REF-' . rand(1000, 9999),
                'ip' => '192.168.1.' . rand(1, 255)
            ],
            [
                'user_id' => $users->random()->id,
                'tipo_transaccion_id' => $tiposTransaccion->where('codigo', 'CONS')->first()->id,
                'cedula' => 'V-12345678',
                'fecha_hora' => Carbon::now(),
                'origen' => 'App Móvil',
                'destino' => 'Sistema',
                'monto' => 0.00,
                'descripcion' => 'Consulta de saldo',
                'ref' => 'REF-' . rand(1000, 9999),
                'ip' => '192.168.1.' . rand(1, 255)
            ],
            [
                'user_id' => $users->random()->id,
                'tipo_transaccion_id' => $tiposTransaccion->where('codigo', 'TRAN')->first()->id,
                'cedula' => 'V-87654321',
                'fecha_hora' => Carbon::now()->subHours(3),
                'origen' => 'Cuenta 1234',
                'destino' => 'Cuenta 5678',
                'monto' => 300.00,
                'descripcion' => 'Transferencia entre cuentas',
                'ref' => 'REF-' . rand(1000, 9999),
                'ip' => '192.168.1.' . rand(1, 255)
            ],
            [
                'user_id' => $users->random()->id,
                'tipo_transaccion_id' => $tiposTransaccion->where('codigo', 'REVE')->first()->id,
                'cedula' => 'V-12345678',
                'fecha_hora' => Carbon::now()->subHours(1),
                'origen' => 'Sistema',
                'destino' => 'Cuenta 1234',
                'monto' => 150.00,
                'descripcion' => 'Reverso de pago',
                'ref' => 'REF-' . rand(1000, 9999),
                'ip' => '192.168.1.' . rand(1, 255)
            ]
        ];

        foreach ($transacciones as $transaccion) {
            Transaccion::create($transaccion);
        }
    }
}
