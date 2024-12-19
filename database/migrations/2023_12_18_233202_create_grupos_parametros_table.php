<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGruposParametrosTable extends Migration
{
    public function up()
    {
        Schema::create('grupos_parametros', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('descripcion')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        // Insertar grupos por defecto
        DB::table('grupos_parametros')->insert([
            [
                'nombre' => 'Sistema',
                'descripcion' => 'Parámetros generales del sistema',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Seguridad',
                'descripcion' => 'Parámetros relacionados con la seguridad',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Notificaciones',
                'descripcion' => 'Configuración de notificaciones',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('grupos_parametros');
    }
}
