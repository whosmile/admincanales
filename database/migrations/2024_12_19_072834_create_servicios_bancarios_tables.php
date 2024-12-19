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
        Schema::create('tipos_servicios', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 20)->unique();
            $table->string('nombre', 50);
            $table->text('descripcion')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        // Modificar la tabla servicios existente
        Schema::table('servicios', function (Blueprint $table) {
            // Eliminar columnas existentes
            $table->dropColumn(['tipo_servicio', 'estatus']);
            
            // Agregar nuevas columnas
            $table->foreignId('tipo_servicio_id')->after('id')->constrained('tipos_servicios');
            $table->string('empresa', 100)->after('nombre');
            $table->string('codigo_servicio', 50)->unique()->after('empresa');
            $table->boolean('activo')->default(true)->after('maxima_afiliacion');
            $table->text('descripcion')->nullable()->after('activo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('servicios', function (Blueprint $table) {
            // Revertir cambios en la tabla servicios
            $table->dropForeign(['tipo_servicio_id']);
            $table->dropColumn(['tipo_servicio_id', 'empresa', 'codigo_servicio', 'activo', 'descripcion']);
            $table->enum('tipo_servicio', ['telefonia', 'electricidad', 'agua', 'tv']);
            $table->enum('estatus', ['Activo', 'Inactivo'])->default('Activo');
        });

        Schema::dropIfExists('tipos_servicios');
    }
};
