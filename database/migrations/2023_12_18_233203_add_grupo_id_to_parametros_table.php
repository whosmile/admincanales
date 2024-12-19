<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGrupoIdToParametrosTable extends Migration
{
    public function up()
    {
        Schema::table('parametros', function (Blueprint $table) {
            $table->foreignId('grupo_id')
                  ->after('valor')
                  ->constrained('grupos_parametros')
                  ->onDelete('restrict');
        });
    }

    public function down()
    {
        Schema::table('parametros', function (Blueprint $table) {
            $table->dropForeign(['grupo_id']);
            $table->dropColumn('grupo_id');
        });
    }
}
