<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiciosSeeder extends Seeder
{
    public function run(): void
    {
        $servicios = [
            // Telefonía
            [
                'tipo_servicio_id' => DB::table('tipos_servicios')->where('codigo', 'TELEFONIA')->value('id'),
                'nombre' => 'Movistar Venezuela',
                'empresa' => 'Telefónica Venezuela',
                'codigo_servicio' => 'MOVISTAR_VE',
                'limite_minimo' => 1.00,
                'limite_maximo' => 1000000.00,
                'maxima_afiliacion' => 5,
                'activo' => true,
                'descripcion' => 'Servicios de telefonía móvil Movistar',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tipo_servicio_id' => DB::table('tipos_servicios')->where('codigo', 'TELEFONIA')->value('id'),
                'nombre' => 'Digitel',
                'empresa' => 'Corporación Digitel C.A.',
                'codigo_servicio' => 'DIGITEL_VE',
                'limite_minimo' => 1.00,
                'limite_maximo' => 1000000.00,
                'maxima_afiliacion' => 5,
                'activo' => true,
                'descripcion' => 'Servicios de telefonía móvil Digitel',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Electricidad
            [
                'tipo_servicio_id' => DB::table('tipos_servicios')->where('codigo', 'ELECTRICIDAD')->value('id'),
                'nombre' => 'CORPOELEC',
                'empresa' => 'Corporación Eléctrica Nacional',
                'codigo_servicio' => 'CORPOELEC_VE',
                'limite_minimo' => 1.00,
                'limite_maximo' => 5000000.00,
                'maxima_afiliacion' => 3,
                'activo' => true,
                'descripcion' => 'Servicio eléctrico nacional',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Agua
            [
                'tipo_servicio_id' => DB::table('tipos_servicios')->where('codigo', 'AGUA')->value('id'),
                'nombre' => 'Hidrocapital',
                'empresa' => 'Hidrológica de la Región Capital',
                'codigo_servicio' => 'HIDROCAPITAL_VE',
                'limite_minimo' => 1.00,
                'limite_maximo' => 1000000.00,
                'maxima_afiliacion' => 3,
                'activo' => true,
                'descripcion' => 'Servicio de agua potable región capital',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Internet
            [
                'tipo_servicio_id' => DB::table('tipos_servicios')->where('codigo', 'INTERNET')->value('id'),
                'nombre' => 'CANTV',
                'empresa' => 'Compañía Anónima Nacional Teléfonos de Venezuela',
                'codigo_servicio' => 'CANTV_INTERNET_VE',
                'limite_minimo' => 1.00,
                'limite_maximo' => 2000000.00,
                'maxima_afiliacion' => 3,
                'activo' => true,
                'descripcion' => 'Servicio de internet ABA',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Televisión
            [
                'tipo_servicio_id' => DB::table('tipos_servicios')->where('codigo', 'TELEVISION')->value('id'),
                'nombre' => 'Inter',
                'empresa' => 'Inter Venezuela',
                'codigo_servicio' => 'INTER_VE',
                'limite_minimo' => 1.00,
                'limite_maximo' => 1500000.00,
                'maxima_afiliacion' => 2,
                'activo' => true,
                'descripcion' => 'Servicio de televisión por cable',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Gas
            [
                'tipo_servicio_id' => DB::table('tipos_servicios')->where('codigo', 'GAS')->value('id'),
                'nombre' => 'Gas Comunal',
                'empresa' => 'Gas Comunal S.A.',
                'codigo_servicio' => 'GAS_COMUNAL_VE',
                'limite_minimo' => 1.00,
                'limite_maximo' => 500000.00,
                'maxima_afiliacion' => 2,
                'activo' => true,
                'descripcion' => 'Servicio de gas doméstico',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Seguros
            [
                'tipo_servicio_id' => DB::table('tipos_servicios')->where('codigo', 'SEGUROS')->value('id'),
                'nombre' => 'Seguros La Previsora',
                'empresa' => 'La Previsora Seguros C.A.',
                'codigo_servicio' => 'PREVISORA_VE',
                'limite_minimo' => 100.00,
                'limite_maximo' => 10000000.00,
                'maxima_afiliacion' => 5,
                'activo' => true,
                'descripcion' => 'Servicios de seguros varios',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Impuestos
            [
                'tipo_servicio_id' => DB::table('tipos_servicios')->where('codigo', 'IMPUESTOS')->value('id'),
                'nombre' => 'SENIAT',
                'empresa' => 'Servicio Nacional Integrado de Administración Aduanera y Tributaria',
                'codigo_servicio' => 'SENIAT_VE',
                'limite_minimo' => 1.00,
                'limite_maximo' => 50000000.00,
                'maxima_afiliacion' => 1,
                'activo' => true,
                'descripcion' => 'Pago de impuestos nacionales',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Educación
            [
                'tipo_servicio_id' => DB::table('tipos_servicios')->where('codigo', 'EDUCACION')->value('id'),
                'nombre' => 'Universidad Central de Venezuela',
                'empresa' => 'Universidad Central de Venezuela',
                'codigo_servicio' => 'UCV_VE',
                'limite_minimo' => 1.00,
                'limite_maximo' => 5000000.00,
                'maxima_afiliacion' => 2,
                'activo' => true,
                'descripcion' => 'Pagos universitarios UCV',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Tarjetas de Crédito
            [
                'tipo_servicio_id' => DB::table('tipos_servicios')->where('codigo', 'TARJETAS')->value('id'),
                'nombre' => 'Banco de Venezuela',
                'empresa' => 'Banco de Venezuela S.A.',
                'codigo_servicio' => 'BDV_TC_VE',
                'limite_minimo' => 1.00,
                'limite_maximo' => 100000000.00,
                'maxima_afiliacion' => 5,
                'activo' => true,
                'descripcion' => 'Pago de tarjetas de crédito Banco de Venezuela',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('servicios')->insert($servicios);
    }
}
