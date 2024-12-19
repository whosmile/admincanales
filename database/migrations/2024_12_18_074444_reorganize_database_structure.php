<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. Tablas base del sistema
        if (!Schema::hasTable('roles')) {
            Schema::create('roles', function (Blueprint $table) {
                $table->id();
                $table->string('nombre', 50);
                $table->text('descripcion')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('permissions')) {
            Schema::create('permissions', function (Blueprint $table) {
                $table->id();
                $table->string('nombre', 50);
                $table->string('codigo', 50)->unique();
                $table->text('descripcion')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('role_permissions')) {
            Schema::create('role_permissions', function (Blueprint $table) {
                $table->foreignId('role_id')->constrained()->onDelete('cascade');
                $table->foreignId('permission_id')->constrained()->onDelete('cascade');
                $table->primary(['role_id', 'permission_id']);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->foreignId('role_id')->constrained();
                $table->string('name');
                $table->string('apellido');
                $table->string('cedula', 20)->unique();
                $table->string('telefono', 15)->nullable();
                $table->string('email')->unique();
                $table->string('username')->unique();
                $table->string('password');
                $table->enum('status', ['active', 'inactive', 'blocked'])->default('active');
                $table->boolean('activo')->default(true);
                $table->timestamp('ultimo_login')->nullable();
                $table->integer('intentos_fallidos')->default(0);
                $table->timestamp('bloqueado_hasta')->nullable();
                $table->rememberToken();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('sessions')) {
            Schema::create('sessions', function (Blueprint $table) {
                $table->string('id')->primary();
                $table->foreignId('user_id')->nullable()->index();
                $table->string('ip_address', 45)->nullable();
                $table->text('user_agent')->nullable();
                $table->longText('payload');
                $table->integer('last_activity')->index();
            });
        }

        if (!Schema::hasTable('password_reset_tokens')) {
            Schema::create('password_reset_tokens', function (Blueprint $table) {
                $table->string('email')->primary();
                $table->string('token');
                $table->timestamp('created_at')->nullable();
            });
        }

        if (!Schema::hasTable('user_logs')) {
            Schema::create('user_logs', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained();
                $table->string('action');
                $table->string('ip_address')->nullable();
                $table->text('user_agent')->nullable();
                $table->json('details')->nullable();
                $table->timestamps();
            });
        }

        // 2. Módulos y Bitácora
        if (!Schema::hasTable('modulos')) {
            Schema::create('modulos', function (Blueprint $table) {
                $table->id();
                $table->string('codigo')->unique();
                $table->string('nombre');
                $table->text('descripcion')->nullable();
                $table->boolean('activo')->default(true);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('bitacora')) {
            Schema::create('bitacora', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained();
                $table->string('usuario');
                $table->string('accion');
                $table->foreignId('modulo_id')->constrained('modulos');
                $table->text('detalles')->nullable();
                $table->json('datos_nuevos')->nullable();
                $table->string('ip')->nullable();
                $table->text('user_agent')->nullable();
                $table->timestamps();
            });
        }

        // 3. Parámetros del Sistema
        if (!Schema::hasTable('grupos_parametros')) {
            Schema::create('grupos_parametros', function (Blueprint $table) {
                $table->id();
                $table->string('codigo')->unique();
                $table->string('nombre');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('parametros')) {
            Schema::create('parametros', function (Blueprint $table) {
                $table->id();
                $table->foreignId('grupo_id')->constrained('grupos_parametros');
                $table->string('codigo')->unique();
                $table->text('valor');
                $table->text('descripcion');
                $table->boolean('es_editable')->default(true);
                $table->boolean('es_visible')->default(true);
                $table->timestamps();
            });
        }

        // 4. Transacciones
        if (!Schema::hasTable('tipos_transaccion')) {
            Schema::create('tipos_transaccion', function (Blueprint $table) {
                $table->id();
                $table->string('codigo', 10)->unique();
                $table->string('nombre');
                $table->string('descripcion')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('transacciones')) {
            Schema::create('transacciones', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users');
                $table->foreignId('tipo_transaccion_id')->constrained('tipos_transaccion');
                $table->string('cedula');
                $table->dateTime('fecha_hora');
                $table->string('origen')->nullable();
                $table->string('destino')->nullable();
                $table->decimal('monto', 10, 2)->default(0);
                $table->string('descripcion')->nullable();
                $table->string('ref')->nullable();
                $table->string('ip')->nullable();
                $table->softDeletes();
                $table->timestamps();
            });
        }

        // 5. Servicios
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
            });
        }

        if (!Schema::hasTable('servicios')) {
            Schema::create('servicios', function (Blueprint $table) {
                $table->id();
                $table->string('nombre');
                $table->enum('tipo_servicio', ['telefonia', 'electricidad', 'agua', 'tv']);
                $table->enum('estatus', ['Activo', 'Inactivo'])->default('Activo');
                $table->decimal('limite_minimo', 20, 2);
                $table->decimal('limite_maximo', 20, 2);
                $table->integer('maxima_afiliacion');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('afiliaciones_servicio')) {
            Schema::create('afiliaciones_servicio', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained();
                $table->foreignId('servicio_id')->constrained('servicios');
                $table->string('numero_afiliado');
                $table->enum('estatus', ['Activo', 'Inactivo'])->default('Activo');
                $table->timestamps();
                $table->unique(['user_id', 'servicio_id', 'numero_afiliado']);
            });
        }
    }

    public function down()
    {
        // Eliminar las tablas en orden inverso para evitar problemas de claves foráneas
        Schema::dropIfExists('afiliaciones_servicio');
        Schema::dropIfExists('servicios');
        Schema::dropIfExists('empresas_servicios');
        Schema::dropIfExists('transacciones');
        Schema::dropIfExists('tipos_transaccion');
        Schema::dropIfExists('parametros');
        Schema::dropIfExists('grupos_parametros');
        Schema::dropIfExists('bitacora');
        Schema::dropIfExists('modulos');
        Schema::dropIfExists('user_logs');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('users');
        Schema::dropIfExists('role_permissions');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('roles');
    }
};
