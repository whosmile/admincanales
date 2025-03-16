<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserLimitsTable extends Migration
{
    public function up()
    {
        Schema::create('user_limits', function (Blueprint $table) {
            $table->id();
            $table->string('cedula');
            $table->decimal('limite_delsur', 15, 2)->default(0);
            $table->decimal('limite_otros', 15, 2)->default(50000.00);
            $table->timestamps();
            
            $table->foreign('cedula')
                  ->references('cedula')
                  ->on('users')
                  ->onDelete('cascade');

            $table->unique('cedula');
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_limits');
    }
}
