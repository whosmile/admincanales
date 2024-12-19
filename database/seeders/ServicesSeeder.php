<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Telefonía
        DB::table('telefonia_services')->insert([
            [
                'nombre' => 'Plan Movilnet Básico',
                'tipo' => 'Prepago',
                'tipo_recarga' => 'Escala',
                'descripcion' => 'Plan básico de telefonía móvil prepago con recarga por escala',
                'estatus' => 'Activo',
                'limite_minimo' => 5.00,
                'limite_maximo' => 100.00,
                'maxima_afiliacion' => 5,
                'escala_montos' => json_encode([5, 10, 20, 50, 100]),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nombre' => 'Plan Movistar Premium',
                'tipo' => 'Postpago',
                'tipo_recarga' => 'Libre',
                'descripcion' => 'Plan premium de telefonía móvil postpago con recarga libre',
                'estatus' => 'Activo',
                'limite_minimo' => 20.00,
                'limite_maximo' => 500.00,
                'maxima_afiliacion' => 3,
                'escala_montos' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        // Electricidad
        DB::table('electricidad_services')->insert([
            [
                'nombre' => 'Servicio Residencial CORPOELEC',
                'tipo' => 'Residencial',
                'estatus' => 'Activo',
                'limite_minimo' => 10.00,
                'limite_maximo' => 1000.00,
                'maxima_afiliacion' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nombre' => 'Servicio Industrial CORPOELEC',
                'tipo' => 'Industrial',
                'estatus' => 'Activo',
                'limite_minimo' => 100.00,
                'limite_maximo' => 10000.00,
                'maxima_afiliacion' => 5,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        // Agua
        DB::table('agua_services')->insert([
            [
                'nombre' => 'Servicio Residencial Hidrocapital',
                'tipo' => 'Residencial',
                'estatus' => 'Activo',
                'limite_minimo' => 5.00,
                'limite_maximo' => 500.00,
                'maxima_afiliacion' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nombre' => 'Servicio Comercial Hidrolara',
                'tipo' => 'Comercial',
                'estatus' => 'Activo',
                'limite_minimo' => 20.00,
                'limite_maximo' => 2000.00,
                'maxima_afiliacion' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        // Internet
        DB::table('internet_services')->insert([
            [
                'nombre' => 'Internet Residencial CANTV',
                'tipo' => 'Residencial',
                'estatus' => 'Activo',
                'limite_minimo' => 15.00,
                'limite_maximo' => 200.00,
                'maxima_afiliacion' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nombre' => 'Internet Empresarial Inter',
                'tipo' => 'Empresarial',
                'estatus' => 'Activo',
                'limite_minimo' => 50.00,
                'limite_maximo' => 1000.00,
                'maxima_afiliacion' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        // Televisión
        DB::table('television_services')->insert([
            [
                'nombre' => 'Plan Básico DirecTV',
                'tipo' => 'Básico',
                'estatus' => 'Activo',
                'limite_minimo' => 10.00,
                'limite_maximo' => 100.00,
                'maxima_afiliacion' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nombre' => 'Plan Premium SimpleTV',
                'tipo' => 'Premium',
                'estatus' => 'Activo',
                'limite_minimo' => 30.00,
                'limite_maximo' => 300.00,
                'maxima_afiliacion' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        // Gas
        DB::table('gas_services')->insert([
            [
                'nombre' => 'Gas Residencial PDVSA',
                'tipo' => 'Residencial',
                'estatus' => 'Activo',
                'limite_minimo' => 5.00,
                'limite_maximo' => 200.00,
                'maxima_afiliacion' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nombre' => 'Gas Industrial Tropigas',
                'tipo' => 'Industrial',
                'estatus' => 'Activo',
                'limite_minimo' => 100.00,
                'limite_maximo' => 5000.00,
                'maxima_afiliacion' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        // Seguros
        DB::table('seguros_services')->insert([
            [
                'nombre' => 'Seguro de Vida La Previsora',
                'tipo' => 'Vida',
                'estatus' => 'Activo',
                'limite_minimo' => 50.00,
                'limite_maximo' => 1000.00,
                'maxima_afiliacion' => 5,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nombre' => 'Seguro de Vehículo Seguros Caracas',
                'tipo' => 'Vehículo',
                'estatus' => 'Activo',
                'limite_minimo' => 100.00,
                'limite_maximo' => 2000.00,
                'maxima_afiliacion' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        // Impuestos
        DB::table('impuestos_services')->insert([
            [
                'nombre' => 'Impuesto Municipal Alcaldía de Caracas',
                'tipo' => 'Municipal',
                'estatus' => 'Activo',
                'limite_minimo' => 10.00,
                'limite_maximo' => 1000.00,
                'maxima_afiliacion' => 5,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nombre' => 'Impuesto Nacional SENIAT',
                'tipo' => 'Nacional',
                'estatus' => 'Activo',
                'limite_minimo' => 50.00,
                'limite_maximo' => 5000.00,
                'maxima_afiliacion' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        // Educación
        DB::table('educacion_services')->insert([
            [
                'nombre' => 'Matrícula UCV',
                'tipo' => 'Pregrado',
                'estatus' => 'Activo',
                'limite_minimo' => 100.00,
                'limite_maximo' => 2000.00,
                'maxima_afiliacion' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nombre' => 'Diplomado UCAB',
                'tipo' => 'Diplomado',
                'estatus' => 'Activo',
                'limite_minimo' => 200.00,
                'limite_maximo' => 3000.00,
                'maxima_afiliacion' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        // Tarjetas
        DB::table('tarjetas_services')->insert([
            [
                'nombre' => 'Tarjeta Clásica Banco de Venezuela',
                'tipo' => 'Clásica',
                'estatus' => 'Activo',
                'limite_minimo' => 10.00,
                'limite_maximo' => 1000.00,
                'maxima_afiliacion' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nombre' => 'Tarjeta Platinum Banesco',
                'tipo' => 'Platinum',
                'estatus' => 'Activo',
                'limite_minimo' => 100.00,
                'limite_maximo' => 10000.00,
                'maxima_afiliacion' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
