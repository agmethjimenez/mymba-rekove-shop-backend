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
        Schema::create('pedidos', function (Blueprint $table) {
            $table->string('idPedido')->primary();
            $table->unsignedBigInteger('usuario');
            $table->string('ciudad');
            $table->string('direccion');
            $table->timestamp('fecha');
            $table->decimal('total',14,0);
            $table->string('detalles_pago');
            $table->unsignedBigInteger('estado');

            $table->foreign('usuario')->references('id')->on('usuarios');
            $table->foreign('estado')->references('codEst')->on('estados');
        });
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pedidos');
    }
};
