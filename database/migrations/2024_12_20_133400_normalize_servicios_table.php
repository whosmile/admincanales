<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. Crear tabla para límites de servicios
        Schema::create('limites_servicios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('servicio_id')->constrained('servicios')->onDelete('cascade');
            $table->decimal('limite_minimo', 20, 2);
            $table->decimal('limite_maximo', 20, 2);
            $table->timestamp('fecha_actualizacion')->useCurrent();
            $table->string('modificado_por')->nullable();
            $table->timestamps();
            $table->string('created_by')->nullable();
            
            // Índice único para asegurar un solo registro activo por servicio
            $table->unique(['servicio_id', 'fecha_actualizacion']);
        });

        // 2. Crear tabla para configuraciones de servicios
        Schema::create('configuraciones_servicios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('servicio_id')->constrained('servicios')->onDelete('cascade');
            $table->integer('maxima_afiliacion');
            $table->boolean('requiere_verificacion')->default(false);
            $table->json('parametros_adicionales')->nullable();
            $table->timestamp('fecha_actualizacion')->useCurrent();
            $table->string('modificado_por')->nullable();
            $table->timestamps();
            $table->string('created_by')->nullable();
            
            // Índice único para asegurar un solo registro activo por servicio
            $table->unique(['servicio_id', 'fecha_actualizacion']);
        });

        // 3. Migrar datos existentes
        DB::statement('
            INSERT INTO limites_servicios (servicio_id, limite_minimo, limite_maximo, created_at, updated_at)
            SELECT id, limite_minimo, limite_maximo, NOW(), NOW()
            FROM servicios
        ');

        DB::statement('
            INSERT INTO configuraciones_servicios (servicio_id, maxima_afiliacion, created_at, updated_at)
            SELECT id, maxima_afiliacion, NOW(), NOW()
            FROM servicios
        ');

        // 4. Drop columns from servicios table
        Schema::table('servicios', function (Blueprint $table) {
            $table->dropColumn(['limite_minimo', 'limite_maximo', 'maxima_afiliacion']);
        });
    }

    public function down()
    {
        // Restore columns to servicios table
        Schema::table('servicios', function (Blueprint $table) {
            $table->decimal('limite_minimo', 20, 2)->nullable();
            $table->decimal('limite_maximo', 20, 2)->nullable();
            $table->integer('maxima_afiliacion')->nullable();
        });

        // Drop the newly created tables
        Schema::dropIfExists('configuraciones_servicios');
        Schema::dropIfExists('limites_servicios');
    }
};
