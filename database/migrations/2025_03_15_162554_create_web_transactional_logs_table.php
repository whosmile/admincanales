<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('web_transactional_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('usuario');
            $table->string('accion');
            $table->string('modulo')->default('parametros_generales');
            $table->string('tabla_afectada')->nullable();
            $table->text('detalles')->nullable();
            $table->json('datos_anteriores')->nullable();
            $table->json('datos_nuevos')->nullable();
            $table->json('parametros_busqueda')->nullable(); // Parámetros usados en la búsqueda
            $table->integer('total_resultados')->nullable(); // Total de resultados encontrados
            $table->string('criterio_busqueda')->nullable(); // Criterio principal de búsqueda
            $table->string('filtros_aplicados')->nullable(); // Filtros adicionales aplicados
            $table->string('ip')->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();

            // Índices para mejorar el rendimiento de las búsquedas
            $table->index('user_id');
            $table->index('accion');
            $table->index('modulo');
            $table->index('created_at');
            $table->index('criterio_busqueda');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('web_transactional_logs');
    }
};
