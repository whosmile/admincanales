<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('parametros', function (Blueprint $table) {
            $table->string('descripcion')->nullable()->after('codigo');
        });

        // Copiar datos de nombre a descripcion
        DB::statement('UPDATE parametros SET descripcion = nombre');

        Schema::table('parametros', function (Blueprint $table) {
            $table->dropColumn('nombre');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('parametros', function (Blueprint $table) {
            $table->string('nombre')->nullable()->after('codigo');
        });

        // Copiar datos de descripcion a nombre
        DB::statement('UPDATE parametros SET nombre = descripcion');

        Schema::table('parametros', function (Blueprint $table) {
            $table->dropColumn('descripcion');
        });
    }
};
