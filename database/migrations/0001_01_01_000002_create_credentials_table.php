<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('credenciales', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->unique();
            $table->string('email')->unique();
            $table->string('token');
            $table->integer('codigo');
            $table->dateTime('fecha_cambio')->nullable();
            $table->string('password');
            $table->boolean('activo')->default(true);

            $table->foreign('id')->references('id')->on('usuarios');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('credenciales');
    }
};
