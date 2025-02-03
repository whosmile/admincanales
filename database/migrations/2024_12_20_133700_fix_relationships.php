<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // 1. Asegurar que la tabla empresas_servicios exista
        if (!Schema::hasTable('empresas_servicios')) {
            Schema::create('empresas_servicios', function (Blueprint $table) {
                $table->id();
                $table->string('nombre');
                $table->string('rif')->unique();
                $table->string('direccion')->nullable();
                $table->string('telefono')->nullable();
                $table->string('email')->nullable();
                $table->string('persona_contacto')->nullable();
                $table->enum('estatus', ['Activo', 'Inactivo'])->default('Activo');
                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('modificado_por')->nullable();
            });
        }

        // 2. Crear empresa por defecto
        DB::table('empresas_servicios')->updateOrInsert(
            ['rif' => 'J-00000000-0'],
            [
                'nombre' => 'Empresa Por Defecto',
                'estatus' => 'Activo',
                'created_at' => now(),
                'updated_at' => now()
            ]
        );

        // 3. Obtener el ID de la empresa por defecto
        $empresaId = DB::table('empresas_servicios')
            ->where('rif', 'J-00000000-0')
            ->value('id');

        // 4. Agregar la columna empresa_servicio_id a servicios
        if (!Schema::hasColumn('servicios', 'empresa_servicio_id')) {
            Schema::table('servicios', function (Blueprint $table) {
                $table->unsignedBigInteger('empresa_servicio_id')->nullable()->after('tipo_servicio_id');
            });
        }

        // 5. Actualizar todos los servicios existentes
        DB::table('servicios')
            ->whereNull('empresa_servicio_id')
            ->update(['empresa_servicio_id' => $empresaId]);

        // 6. Agregar la restricción de llave foránea
        Schema::table('servicios', function (Blueprint $table) {
            if (!Schema::hasColumn('servicios', 'empresa_servicio_id')) {
                $table->foreign('empresa_servicio_id')
                    ->references('id')
                    ->on('empresas_servicios')
                    ->onDelete('restrict');
            }
        });

        // 7. Crear tabla estados_transaccion si no existe
        if (!Schema::hasTable('estados_transaccion')) {
            Schema::create('estados_transaccion', function (Blueprint $table) {
                $table->id();
                $table->string('codigo', 20)->unique();
                $table->string('nombre', 50);
                $table->text('descripcion')->nullable();
                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('modificado_por')->nullable();
            });

            // Insertar estados por defecto
            $estados = [
                ['codigo' => 'PENDIENTE', 'nombre' => 'Pendiente'],
                ['codigo' => 'APROBADA', 'nombre' => 'Aprobada'],
                ['codigo' => 'RECHAZADA', 'nombre' => 'Rechazada'],
                ['codigo' => 'CANCELADA', 'nombre' => 'Cancelada']
            ];

            foreach ($estados as $estado) {
                DB::table('estados_transaccion')->updateOrInsert(
                    ['codigo' => $estado['codigo']],
                    array_merge($estado, [
                        'created_at' => now(),
                        'updated_at' => now()
                    ])
                );
            }
        }

        // 8. Actualizar tabla transacciones
        if (Schema::hasTable('transacciones')) {
            Schema::table('transacciones', function (Blueprint $table) {
                if (!Schema::hasColumn('transacciones', 'servicio_id')) {
                    $table->foreignId('servicio_id')->nullable()->constrained('servicios')->onDelete('restrict');
                }
                if (!Schema::hasColumn('transacciones', 'estado_id')) {
                    $table->foreignId('estado_id')->nullable()->constrained('estados_transaccion')->onDelete('restrict');
                }
            });
        }

        // 9. Actualizar tabla afiliaciones_servicio
        if (Schema::hasTable('afiliaciones_servicio')) {
            Schema::table('afiliaciones_servicio', function (Blueprint $table) {
                if (!Schema::hasColumn('afiliaciones_servicio', 'user_id')) {
                    $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('restrict');
                }
                if (!Schema::hasColumn('afiliaciones_servicio', 'servicio_id')) {
                    $table->foreignId('servicio_id')->nullable()->constrained('servicios')->onDelete('restrict');
                }
                // Agregar índice compuesto
                $table->index(['user_id', 'servicio_id']);
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('servicios')) {
            Schema::table('servicios', function (Blueprint $table) {
                $table->dropForeign(['empresa_servicio_id']);
                $table->dropColumn('empresa_servicio_id');
            });
        }

        if (Schema::hasTable('afiliaciones_servicio')) {
            Schema::table('afiliaciones_servicio', function (Blueprint $table) {
                $table->dropForeign(['user_id']);
                $table->dropForeign(['servicio_id']);
                $table->dropColumn(['user_id', 'servicio_id']);
            });
        }

        if (Schema::hasTable('transacciones')) {
            Schema::table('transacciones', function (Blueprint $table) {
                $table->dropForeign(['servicio_id']);
                $table->dropForeign(['estado_id']);
                $table->dropColumn(['servicio_id', 'estado_id']);
            });
        }
    }
};
