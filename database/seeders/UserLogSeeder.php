<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserLogSeeder extends Seeder
{
    public function run(): void
    {
        $users = DB::table('users')->get();
        $actions = ['login', 'logout', 'update_profile', 'view_dashboard', 'search_client'];
        $userAgents = [
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/121.0'
        ];

        // Generar registros para los últimos 6 meses
        $startDate = Carbon::now()->subMonths(6);
        $endDate = Carbon::now();

        $logs = [];
        foreach ($users as $user) {
            // Generar entre 10 y 30 registros por usuario
            $numLogs = rand(10, 30);
            
            for ($i = 0; $i < $numLogs; $i++) {
                $action = $actions[array_rand($actions)];
                $date = Carbon::createFromTimestamp(rand($startDate->timestamp, $endDate->timestamp));
                
                $logs[] = [
                    'user_id' => $user->id,
                    'accion' => $action,
                    'detalles' => 'El usuario realizó la acción: ' . $action,
                    'ip_address' => '127.0.0.1',
                    'created_at' => $date,
                ];
            }
        }

        DB::table('user_logs')->insert($logs);
    }
}
