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
        Schema::create('detallepedido', function (Blueprint $table) {
            $table->string('idPedido');
            $table->string('idProducto');
            $table->primary(['idPedido', 'idProducto']);

            $table->integer('cantidad');
            $table->decimal('total',14,0);

            $table->foreign('idPedido')->references('idPedido')->on('pedidos');
            $table->foreign('idProducto')->references('idProducto')->on('productos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detallepedido');
    }
};
