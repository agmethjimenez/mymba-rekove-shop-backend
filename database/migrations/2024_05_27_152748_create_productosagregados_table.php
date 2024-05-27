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
        Schema::create('productosagregados', function (Blueprint $table) {
            $table->string('administrador');
            $table->string('producto')->unique();
            $table->timestamp('agregado_el');
            $table->foreign('administrador')->references('id')->on('administradores');
            $table->foreign('producto')->references('idProducto')->on('productos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productosagregados');
    }
};
